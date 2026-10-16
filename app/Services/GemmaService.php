<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * GemmaService
 *
 * Supports two backends automatically based on the API key format:
 *   • Hugging Face Inference API  — key starts with "AQ." or "hf_"
 *   • Google AI Studio (Gemini)   — key starts with "AIza"
 */
class GemmaService
{
    protected string $apiKey;
    protected string $model;
    protected string $baseUrl;
    protected int    $timeout;
    protected int    $maxTokens;
    protected float  $temperature;

    // Which backend we'll use
    protected string $backend; // 'huggingface' | 'google'

    public function __construct()
    {
        $this->apiKey      = config('gemma.api_key', '');
        $this->model       = config('gemma.model', 'gemini-2.0-flash');
        $this->baseUrl     = config('gemma.base_url', 'https://generativelanguage.googleapis.com/v1beta/models');
        $this->timeout     = (int)   config('gemma.timeout', 60);
        $this->maxTokens   = (int)   config('gemma.max_tokens', 2048);
        $this->temperature = (float) config('gemma.temperature', 0.3);

        // Auto-detect backend from key prefix
        $this->backend = $this->detectBackend($this->apiKey);
    }

    /**
     * Detect which AI backend to use based on the API key format.
     *
     * Google AI Studio keys: start with 'AIza' (classic) OR 'AQ.' (newer format)
     * Hugging Face tokens:   start with 'hf_'
     */
    protected function detectBackend(string $key): string
    {
        if (str_starts_with($key, 'hf_')) {
            return 'huggingface';
        }

        // Both 'AIza...' and 'AQ....' are Google AI Studio keys
        return 'google';
    }

    /**
     * Check if the AI API is configured.
     */
    public function isConfigured(): bool
    {
        return !empty($this->apiKey);
    }

    /**
     * Get the current backend name for display.
     */
    public function getBackendName(): string
    {
        return $this->backend === 'huggingface' ? 'Hugging Face (Gemma)' : 'Google AI (Gemini)';
    }

    /**
     * Quick ping to verify the API key actually works.
     * Returns ['valid' => true] or ['valid' => false, 'error' => '...']
     */
    public function testConnection(): array
    {
        if (!$this->isConfigured()) {
            return ['valid' => false, 'error' => 'No API key set. Add GEMINI_API_KEY to your .env file.'];
        }

        $result = $this->generate('Reply with: OK', ['max_tokens' => 120, 'temperature' => 0.0]);

        if ($result['success']) {
            return ['valid' => true, 'backend' => $this->getBackendName()];
        }

        return ['valid' => false, 'error' => $result['error']];
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Public generate method — routes to the correct backend
    // ─────────────────────────────────────────────────────────────────────────

    /**
     * Generate a completion. Automatically selects Google or Hugging Face backend.
     */
    public function generate(string $prompt, array $options = []): array
    {
        if (!$this->isConfigured()) {
            return [
                'success' => false,
                'error'   => 'AI API key is not set. Please add GEMINI_API_KEY to your .env file.',
            ];
        }

        if ($this->backend === 'huggingface') {
            return $this->generateHuggingFace($prompt, $options);
        }

        return $this->generateGoogle($prompt, $options);
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Google AI Studio (Gemini) backend
    // ─────────────────────────────────────────────────────────────────────────

    protected function generateGoogle(string $prompt, array $options = []): array
    {
        $candidateModels = array_unique([
            $this->model,
            'gemini-3.5-flash',
            'gemini-3.6-flash',
            'gemini-3.7-flash',
        ]);

        $lastError = 'Unknown error';

        foreach ($candidateModels as $model) {
            $endpoint = rtrim($this->baseUrl, '/') . '/' . $model . ':generateContent?key=' . $this->apiKey;

            $payload = [
                'contents'         => [['parts' => [['text' => $prompt]]]],
                'generationConfig' => [
                    'maxOutputTokens' => $options['max_tokens'] ?? $this->maxTokens,
                    'temperature'     => $options['temperature'] ?? $this->temperature,
                ],
            ];

            try {
                $response = Http::timeout(min($this->timeout, 15))
                    ->withHeaders(['Content-Type' => 'application/json'])
                    ->post($endpoint, $payload);

                if ($response->successful()) {
                    $parts = $response->json('candidates.0.content.parts', []);
                    $text  = '';
                    foreach ($parts as $part) {
                        if (!empty($part['text']) && empty($part['thought'])) {
                            $text .= $part['text'];
                        }
                    }
                    if (!$text && !empty($parts[0]['text'])) {
                        $text = $parts[0]['text'];
                    }
                    if ($text) {
                        return ['success' => true, 'text' => trim($text), 'backend' => 'google', 'model' => $model];
                    }
                }

                $errMsg = $response->json('error.message') ?? $response->body();
                Log::warning("Google AI model {$model} returned status {$response->status()}", ['body' => $errMsg]);

                // If error is 503 (busy) or 404 (not found), backoff briefly and try the next candidate model
                if (in_array($response->status(), [404, 503])) {
                    $lastError = $errMsg;
                    usleep(600000); // 600ms backoff
                    continue;
                }

                $friendly = match ($response->status()) {
                    401     => 'Invalid Google API key. Get one free at https://aistudio.google.com/app/apikey',
                    403     => 'API key lacks permission for this model.',
                    429     => 'Rate limit reached. Wait a moment and retry.',
                    default => "Google AI error ({$response->status()}): {$errMsg}",
                };

                return ['success' => false, 'error' => $friendly];

            } catch (\Exception $e) {
                Log::error('Google AI exception', ['model' => $model, 'message' => $e->getMessage()]);
                $lastError = $e->getMessage();
            }
        }

        return ['success' => false, 'error' => "All AI models were busy or unavailable. Last error: {$lastError}"];
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Hugging Face Inference API backend
    // ─────────────────────────────────────────────────────────────────────────

    protected function generateHuggingFace(string $prompt, array $options = []): array
    {
        // Map friendly model names to HuggingFace model IDs
        $hfModelMap = [
            'gemma-3-1b-it'      => 'google/gemma-3-1b-it',
            'gemma-3-4b-it'      => 'google/gemma-3-4b-it',
            'gemma-2-2b-it'      => 'google/gemma-2-2b-it',
            'gemini-2.0-flash'   => 'google/gemma-3-4b-it',
            'gemini-1.5-flash'   => 'google/gemma-3-4b-it',
        ];

        $hfModel  = $hfModelMap[$this->model] ?? 'google/gemma-3-1b-it';

        // HuggingFace Inference API v2 (router endpoint — more reliable)
        $endpoint = 'https://router.huggingface.co/hf-inference/models/' . $hfModel . '/v1/chat/completions';

        $payload = [
            'model'    => $hfModel,
            'messages' => [
                ['role' => 'user', 'content' => $prompt],
            ],
            'max_tokens' => min($options['max_tokens'] ?? $this->maxTokens, 1024),
            'temperature' => $options['temperature'] ?? $this->temperature,
            'stream'     => false,
        ];

        try {
            $response = Http::timeout($this->timeout)
                ->withHeaders([
                    'Authorization' => 'Bearer ' . $this->apiKey,
                    'Content-Type'  => 'application/json',
                ])
                ->post($endpoint, $payload);

            if ($response->failed()) {
                $body   = $response->json();
                $errMsg = $body['error'] ?? $response->body();

                Log::error('HuggingFace API error', [
                    'status'  => $response->status(),
                    'model'   => $hfModel,
                    'message' => $errMsg,
                ]);

                // Model may be loading (503) — tell user to retry
                if ($response->status() === 503) {
                    $estimatedTime = $body['estimated_time'] ?? 20;
                    return [
                        'success' => false,
                        'error'   => "The AI model is warming up (takes ~{$estimatedTime}s on first use). Please wait and try again.",
                        'retry'   => true,
                    ];
                }

                $friendly = match ($response->status()) {
                    401     => 'Invalid Hugging Face token. Check GEMINI_API_KEY in your .env file.',
                    403     => 'This Hugging Face token does not have access to this model.',
                    429     => 'Rate limit reached. Wait a moment and retry.',
                    default => "Hugging Face error ({$response->status()}): {$errMsg}",
                };

                return ['success' => false, 'error' => $friendly];
            }

            // HuggingFace router returns OpenAI-compatible chat completions format
            $data = $response->json();

            // Try chat completions format first (router API)
            $text = $data['choices'][0]['message']['content'] ?? null;

            // Fallback: old text-generation format
            if (!$text && is_array($data)) {
                $text = $data[0]['generated_text'] ?? null;
            }

            if (!$text) {
                return ['success' => false, 'error' => 'No response from Hugging Face. The model may still be loading. Try again in 20 seconds.'];
            }

            return ['success' => true, 'text' => trim($text), 'backend' => 'huggingface', 'model' => $hfModel];

        } catch (\Exception $e) {
            Log::error('HuggingFace exception', ['message' => $e->getMessage()]);
            return ['success' => false, 'error' => 'Connection error: ' . $e->getMessage()];
        }
    }

    // ─────────────────────────────────────────────────────────────────────────
    // High-level analysis methods
    // ─────────────────────────────────────────────────────────────────────────

    /**
     * Analyze evidence and generate a forensic summary.
     */
    public function analyzeEvidence(array $evidence): array
    {
        $prompt = $this->buildEvidenceAnalysisPrompt($evidence);

        $result = $this->generate($prompt, [
            'max_tokens'  => 900,
            'temperature' => 0.2,
        ]);

        if (!$result['success']) {
            return $result;
        }

        return [
            'success'      => true,
            'analysis'     => $result['text'],
            'text'         => $result['text'],
            'evidence_id'  => $evidence['id'] ?? null,
            'backend'      => $result['backend'] ?? $this->backend,
            'model'        => $result['model']   ?? $this->model,
            'generated_at' => now()->toIso8601String(),
        ];
    }

    /**
     * Summarize a legal case with all its evidence.
     */
    public function summarizeCase(array $caseData, array $evidenceList = []): array
    {
        $prompt = $this->buildCaseSummaryPrompt($caseData, $evidenceList);

        $result = $this->generate($prompt, [
            'max_tokens'  => 900,
            'temperature' => 0.3,
        ]);

        if (!$result['success']) {
            return $result;
        }

        return [
            'success'      => true,
            'summary'      => $result['text'],
            'text'         => $result['text'],
            'case_id'      => $caseData['id'] ?? null,
            'backend'      => $result['backend'] ?? $this->backend,
            'model'        => $result['model']   ?? $this->model,
            'generated_at' => now()->toIso8601String(),
        ];
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Prompt builders
    // ─────────────────────────────────────────────────────────────────────────

    protected function buildEvidenceAnalysisPrompt(array $evidence): string
    {
        $title       = $evidence['title']       ?? 'Untitled Evidence';
        $description = $evidence['description'] ?? 'No description provided.';
        $fileHash    = $evidence['file_hash']   ?? 'N/A';
        $mimeType    = $evidence['mime_type']   ?? 'N/A';
        $fileSize    = isset($evidence['file_size']) ? number_format((int)$evidence['file_size']) . ' bytes' : 'N/A';
        $lat         = $evidence['latitude']    ?? null;
        $lng         = $evidence['longitude']   ?? null;
        $alt         = $evidence['altitude']    ?? null;
        $gpsAcc      = $evidence['gps_accuracy']?? null;
        $deviceInfo  = $evidence['device_info']  ?? 'N/A';
        $capturedAt  = $evidence['captured_at'] ?? 'N/A';
        $ingestedAt  = $evidence['ingested_at'] ?? 'N/A';
        $uploader    = $evidence['uploaded_by'] ?? 'Registered Witness';

        $rawMeta     = $evidence['metadata']    ?? [];
        $meta        = is_string($rawMeta) ? json_decode($rawMeta, true) : (is_array($rawMeta) ? $rawMeta : []);
        $metaJson    = json_encode($meta, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

        $gpsSummary  = ($lat !== null && $lng !== null)
            ? "Latitude: {$lat}, Longitude: {$lng}" . ($alt ? ", Altitude: {$alt}m" : "") . ($gpsAcc ? " (Accuracy: +/-{$gpsAcc}m)" : "")
            : "No direct GPS coordinates provided.";

        $exifSummary = (!empty($meta['exif_gps_lat']) && !empty($meta['exif_gps_lon']))
            ? "EXIF Lat: {$meta['exif_gps_lat']}, EXIF Lon: {$meta['exif_gps_lon']}, EXIF Timestamp: " . ($meta['exif_datetime'] ?? 'N/A')
            : "No embedded EXIF coordinates found.";

        return <<<PROMPT
You are a senior forensic evidence analyst for eWitnessVault, a judicial digital evidence management system serving Judges, Prosecutors, and Defense Counsel.

Analyze this digital evidence exhibit and provide a structured forensic evaluation report adhering strictly to the required 5-part Analysis Scope:

═══════════════════════════════════════════════════════════════════════════
EVIDENCE RECORD
═══════════════════════════════════════════════════════════════════════════
• Title: {$title}
• Description / Narrative: {$description}
• Submitting Witness: {$uploader}
• Declared Incident Timestamp: {$capturedAt}
• Vault Ingestion Timestamp: {$ingestedAt}

FILE METADATA:
• MIME Type: {$mimeType}
• File Size: {$fileSize}
• Cryptographic Hash (SHA-256): {$fileHash}

GEOLOCATION & EXIF DATA:
• Device GPS Coordinates: {$gpsSummary}
• Embedded EXIF Telemetry: {$exifSummary}

DEVICE & CAPTURE ENVIRONMENT:
• Sensor / Client Hardware: {$deviceInfo}
• Complete Raw Metadata:
{$metaJson}

═══════════════════════════════════════════════════════════════════════════
REQUIRED FORENSIC ANALYSIS SCOPE (Include all 5 sections)
═══════════════════════════════════════════════════════════════════════════
1. Title and Description
   - Analyze the clarity, narrative consistency, and specific assertions made by the witness.
   - Note any discrepancies between the described incident and the underlying technical data.

2. File Metadata (MIME type, size, hash)
   - Evaluate the file format ({$mimeType}) and payload size ({$fileSize}).
   - Validate the cryptographic SHA-256 digest ({$fileHash}) for tamper detection and integrity verification.

3. GPS and EXIF Data
   - Geolocation verification: physical location lock, coordinate precision, and plausibility.
   - Cross-check embedded EXIF capture timestamps against the declared capture date and ingestion time.

4. Device and Capture Information
   - Telemetry audit of the client device ({$deviceInfo}), operating system, camera/sensor hardware, and capture method.
   - Evaluate authenticity markers indicating original capture versus re-encoded or forwarded media.

5. Chain-of-Custody Considerations
   - Assess digital chain of custody from capture to vault ingestion.
   - Review court admissibility under statutory rules (e.g. Section 106, FRE 902), anti-spoliation safeguards, and judicial readiness.

Deliver an objective, legally rigorous report for the court docket.
PROMPT;
    }

    protected function buildCaseSummaryPrompt(array $caseData, array $evidenceList): string
    {
        $caseTitle   = $caseData['title']           ?? 'Untitled Case';
        $caseDesc    = $caseData['description']     ?? 'No description provided.';
        $caseStatus  = $caseData['status']          ?? 'Unknown';
        $docketNum   = $caseData['docket_number']   ?? ($caseData['case_number'] ?? ('CASE-#' . ($caseData['id'] ?? 'N/A')));
        $courtRef    = $caseData['court_reference'] ?? 'N/A';
        $hearingDate = $caseData['hearing_date']    ?? 'Not scheduled';
        $lawyer      = $caseData['lawyer']          ?? 'Unassigned Counsel';
        $judge       = $caseData['assigned_judge']  ?? 'Unassigned Bench';

        $evidenceCount   = count($evidenceList);
        $evidenceSummary = 'No linked evidence exhibits currently filed.';

        if (!empty($evidenceList)) {
            $items = [];
            foreach ($evidenceList as $i => $ev) {
                $n     = $i + 1;
                $t     = $ev['title']       ?? 'Untitled Exhibit';
                $m     = $ev['mime_type']   ?? 'unknown format';
                $h     = isset($ev['file_hash']) ? substr($ev['file_hash'], 0, 16) . '...' : 'N/A';
                $d     = $ev['description'] ?? 'No description';
                $w     = $ev['witness']     ?? 'Witness';
                $items[] = "{$n}. [Exhibit #{$ev['id']}] {$t} ({$m}) | Hash: {$h} | By: {$w} — {$d}";
            }
            $evidenceSummary = implode("\n", $items);
        }

        return <<<PROMPT
You are a senior judicial case analyst for eWitnessVault, an evidentiary management system used by presiding Judges and Legal Counsel.

Analyze this case docket and provide an executive judicial summary strictly structured according to the required 5-part Summary Scope:

═══════════════════════════════════════════════════════════════════════════
CASE DOCKET INFORMATION
═══════════════════════════════════════════════════════════════════════════
• Docket Number: {$docketNum}
• Court Reference: {$courtRef}
• Case Title: {$caseTitle}
• Current Docket Status: {$caseStatus}
• Scheduled Hearing Date: {$hearingDate}
• Filing Counsel: {$lawyer}
• Presiding Judge: {$judge}
• Substantive Case Description:
{$caseDesc}

LINKED EVIDENCE INVENTORY ({$evidenceCount} items):
{$evidenceSummary}

═══════════════════════════════════════════════════════════════════════════
REQUIRED SUMMARY SCOPE (Include all 5 sections)
═══════════════════════════════════════════════════════════════════════════
1. Case Title and Description
   - Synthesis of the core legal controversy, substantive claims, and factual backdrop.
   - Summary of primary allegations and claims raised by filing counsel.

2. Current Status and Docket Number
   - Procedural posture of docket {$docketNum} (Status: {$caseStatus}).
   - Readiness for hearing ({$hearingDate}) and milestone compliance.

3. Linked Evidence Inventory
   - Itemized audit of filed digital exhibits and witness submissions.
   - Cryptographic integrity and evidential classification of each linked item.

4. Strengths and Gaps Assessment
   - Detailed analysis of evidential strength (probative value, corroboration, chain-of-custody robustness).
   - Identification of missing corroboration, evidential gaps, potential defense objections, or unverified claims.

5. Judicial Focus Recommendations
   - Key factual and legal issues requiring bench inquiry or preliminary rulings.
   - Targeted questions for counsel and evidentiary admissibility determinations prior to trial.

Deliver an objective, high-level briefing tailored for judicial deliberation.
PROMPT;
    }
}
