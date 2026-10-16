<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class GemmaService
{
    protected string $apiKey;
    protected string $endpoint;
    protected string $model;
    protected int $timeout;
    protected int $maxTokens;
    protected float $temperature;

    public function __construct()
    {
        $this->apiKey = config('gemma.api_key');
        $this->endpoint = config('gemma.endpoint');
        $this->model = config('gemma.model');
        $this->timeout = config('gemma.timeout');
        $this->maxTokens = config('gemma.max_tokens');
        $this->temperature = config('gemma.temperature');
    }

    /**
     * Check if Gemma is configured and available.
     */
    public function isConfigured(): bool
    {
        return !empty($this->apiKey);
    }

    /**
     * Generate a completion from Gemma.
     */
    public function generate(string $prompt, array $options = []): array
    {
        if (!$this->isConfigured()) {
            return [
                'success' => false,
                'error' => 'Gemma API is not configured. Please set GEMMA_API_KEY in your .env file.',
            ];
        }

        $payload = [
            'contents' => [
                [
                    'parts' => [
                        ['text' => $prompt],
                    ],
                ],
            ],
            'generationConfig' => [
                'maxOutputTokens' => $options['max_tokens'] ?? $this->maxTokens,
                'temperature' => $options['temperature'] ?? $this->temperature,
            ],
        ];

        try {
            $response = Http::timeout($this->timeout)
                ->withHeaders([
                    'Content-Type' => 'application/json',
                    'x-goog-api-key' => $this->apiKey,
                ])
                ->post($this->endpoint, $payload);

            if ($response->failed()) {
                Log::error('Gemma API error', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);

                return [
                    'success' => false,
                    'error' => 'Gemma API request failed with status ' . $response->status(),
                ];
            }

            $data = $response->json();

            $text = $data['candidates'][0]['content']['parts'][0]['text'] ?? null;

            if (!$text) {
                return [
                    'success' => false,
                    'error' => 'No response text received from Gemma.',
                ];
            }

            return [
                'success' => true,
                'text' => $text,
                'raw' => $data,
            ];
        } catch (\Exception $e) {
            Log::error('Gemma API exception', ['message' => $e->getMessage()]);

            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Analyze evidence and generate a summary with forensic insights.
     */
    public function analyzeEvidence(array $evidence): array
    {
        $prompt = $this->buildEvidenceAnalysisPrompt($evidence);

        $result = $this->generate($prompt, [
            'max_tokens' => 1500,
            'temperature' => 0.2,
        ]);

        if (!$result['success']) {
            return $result;
        }

        return [
            'success' => true,
            'analysis' => $result['text'],
            'evidence_id' => $evidence['id'] ?? null,
            'generated_at' => now()->toIso8601String(),
        ];
    }

    /**
     * Summarize a case with all its evidence.
     */
    public function summarizeCase(array $caseData, array $evidenceList = []): array
    {
        $prompt = $this->buildCaseSummaryPrompt($caseData, $evidenceList);

        $result = $this->generate($prompt, [
            'max_tokens' => 2000,
            'temperature' => 0.3,
        ]);

        if (!$result['success']) {
            return $result;
        }

        return [
            'success' => true,
            'summary' => $result['text'],
            'case_id' => $caseData['id'] ?? null,
            'generated_at' => now()->toIso8601String(),
        ];
    }

    /**
     * Build the evidence analysis prompt.
     */
    protected function buildEvidenceAnalysisPrompt(array $evidence): string
    {
        $title = $evidence['title'] ?? 'Untitled Evidence';
        $description = $evidence['description'] ?? 'No description provided.';
        $metadata = $evidence['metadata'] ?? [];
        $metadataJson = is_string($metadata) ? $metadata : json_encode($metadata, JSON_PRETTY_PRINT);
        $fileHash = $evidence['file_hash'] ?? 'N/A';
        $capturedAt = $evidence['captured_at'] ?? 'N/A';
        $mimeType = $evidence['mime_type'] ?? 'N/A';
        $fileSize = $evidence['file_size'] ?? 'N/A';

        return <<<PROMPT
You are a forensic evidence analyst for eWitnessVault, a judicial evidence management system. Analyze the following evidence submission and provide a professional forensic summary suitable for court proceedings.

EVIDENCE DETAILS:
- Title: {$title}
- Description: {$description}
- File Hash (SHA-256): {$fileHash}
- MIME Type: {$mimeType}
- File Size: {$fileSize} bytes
- Captured At: {$capturedAt}
- Metadata: {$metadataJson}

Please provide:
1. A concise summary of what this evidence appears to be
2. Key forensic observations from the metadata
3. Potential evidentiary value and relevance
4. Any chain-of-custody considerations
5. Recommended next steps for judicial review

Format your response as a structured forensic analysis report. Be objective, professional, and avoid speculation beyond what the metadata supports.
PROMPT;
    }

    /**
     * Build the case summary prompt.
     */
    protected function buildCaseSummaryPrompt(array $caseData, array $evidenceList): string
    {
        $caseTitle = $caseData['title'] ?? 'Untitled Case';
        $caseDescription = $caseData['description'] ?? 'No description provided.';
        $caseStatus = $caseData['status'] ?? 'Unknown';
        $caseId = $caseData['id'] ?? 'N/A';

        $evidenceSummary = 'No evidence attached.';
        if (!empty($evidenceList)) {
            $items = [];
            foreach ($evidenceList as $ev) {
                $items[] = sprintf("- %s (%s) - %s", $ev['title'] ?? 'Untitled', $ev['mime_type'] ?? 'unknown', $ev['description'] ?? 'No description');
            }
            $evidenceSummary = implode("\n", $items);
        }

        return <<<PROMPT
You are a judicial case analyst for eWitnessVault. Summarize the following case for court proceedings based on the available case data and attached evidence.

CASE DETAILS:
- Case ID: {$caseId}
- Title: {$caseTitle}
- Status: {$caseStatus}
- Description: {$caseDescription}

ATTACHED EVIDENCE:
{$evidenceSummary}

Please provide:
1. Executive summary of the case
2. Key facts established by the evidence
3. Evidence strength assessment
4. Identified gaps or missing information
5. Recommended judicial focus areas

Format as a structured case summary report suitable for judicial review. Remain objective and base all conclusions strictly on the provided case data and evidence descriptions.
PROMPT;
    }
}
