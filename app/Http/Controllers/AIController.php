<?php

namespace App\Http\Controllers;

use App\Http\Requests\AIAnalysisRequest;
use App\Models\Evidence;
use App\Models\LegalCase;
use App\Services\GemmaService;
use Illuminate\Http\Request;

class AIController extends Controller
{
    protected GemmaService $gemma;

    public function __construct(GemmaService $gemma)
    {
        $this->gemma = $gemma;
        $this->middleware('auth');
    }

    /**
     * Show the AI dashboard with available features.
     */
    public function index()
    {
        $features = config('gemma.features', []);
        $configured = $this->gemma->isConfigured();

        return view('ai.index', compact('features', 'configured'));
    }

    /**
     * Show evidence analysis form.
     */
    public function evidenceAnalysis(Request $request)
    {
        $evidenceId = $request->query('evidence_id');

        $evidence = null;
        if ($evidenceId) {
            $evidence = Evidence::with('user')->findOrFail($evidenceId);
            $user = $request->user();

            // Authorization: owner or authorized judicial roles
            if ($evidence->uploaded_by !== $user->id && !$user->hasAnyRole(['Admin', 'Judge', 'Lawyer'])) {
                abort(403, 'Unauthorized access to this evidence.');
            }
        }

        $recentEvidence = Evidence::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(20)
            ->get();

        return view('ai.evidence-analysis', compact('evidence', 'recentEvidence'));
    }

    /**
     * Run AI analysis on evidence.
     */
    public function analyzeEvidence(AIAnalysisRequest $request, GemmaService $gemma)
    {
        if (!$gemma->isConfigured()) {
            return back()->withErrors(['Gemma API is not configured. Please contact the administrator.']);
        }

        $evidenceId = $request->validated('evidence_id');
        $evidence = Evidence::with('user')->findOrFail($evidenceId);

        $user = $request->user();
        if ($evidence->uploaded_by !== $user->id && !$user->hasAnyRole(['Admin', 'Judge', 'Lawyer'])) {
            abort(403, 'Unauthorized access to this evidence.');
        }

        $evidenceData = [
            'id' => $evidence->id,
            'title' => $evidence->title,
            'description' => $evidence->description,
            'file_hash' => $evidence->file_hash,
            'mime_type' => $evidence->mime_type,
            'file_size' => $evidence->file_size,
            'captured_at' => $evidence->captured_at?->toIso8601String(),
            'metadata' => $evidence->metadata,
        ];

        $result = $gemma->analyzeEvidence($evidenceData);

        if (!$result['success']) {
            return back()->withErrors(['AI analysis failed: ' . $result['error']])->withInput();
        }

        // Store the analysis in session for display
        session(['ai_analysis' => $result]);

        return redirect()->route('ai.evidence-results', ['evidence_id' => $evidence->id])
            ->with('success', 'Evidence analysis completed successfully.');
    }

    /**
     * Show AI analysis results for evidence.
     */
    public function evidenceResults(Request $request, $evidenceId)
    {
        $evidence = Evidence::with('user')->findOrFail($evidenceId);
        $user = $request->user();

        if ($evidence->uploaded_by !== $user->id && !$user->hasAnyRole(['Admin', 'Judge', 'Lawyer'])) {
            abort(403, 'Unauthorized access to this evidence.');
        }

        $analysis = session('ai_analysis');

        return view('ai.evidence-results', compact('evidence', 'analysis'));
    }

    /**
     * Show case summarization form.
     */
    public function caseSummary(Request $request)
    {
        $caseId = $request->query('case_id');

        $case = null;
        if ($caseId) {
            $case = LegalCase::with('evidence')->findOrFail($caseId);
            $user = $request->user();

            if (!$user->hasAnyRole(['Admin', 'Judge', 'Lawyer'])) {
                abort(403, 'Only judicial roles can generate case summaries.');
            }
        }

        $cases = LegalCase::withCount('evidence')
            ->orderBy('created_at', 'desc')
            ->limit(20)
            ->get();

        return view('ai.case-summary', compact('case', 'cases'));
    }

    /**
     * Generate AI summary for a case.
     */
    public function summarizeCase(AIAnalysisRequest $request, GemmaService $gemma)
    {
        if (!$gemma->isConfigured()) {
            return back()->withErrors(['Gemma API is not configured. Please contact the administrator.']);
        }

        $caseId = $request->validated('case_id');
        $case = LegalCase::with('evidence')->findOrFail($caseId);

        $user = $request->user();
        if (!$user->hasAnyRole(['Admin', 'Judge', 'Lawyer'])) {
            abort(403, 'Only judicial roles can generate case summaries.');
        }

        $caseData = [
            'id' => $case->id,
            'title' => $case->title,
            'description' => $case->description,
            'status' => $case->status,
        ];

        $evidenceList = $case->evidence->map(fn($e) => [
            'id' => $e->id,
            'title' => $e->title,
            'description' => $e->description,
            'mime_type' => $e->mime_type,
        ])->toArray();

        $result = $gemma->summarizeCase($caseData, $evidenceList);

        if (!$result['success']) {
            return back()->withErrors(['Case summary failed: ' . $result['error']])->withInput();
        }

        session(['ai_case_summary' => $result]);

        return redirect()->route('ai.case-results', ['case_id' => $case->id])
            ->with('success', 'Case summary generated successfully.');
    }

    /**
     * Show case summary results.
     */
    public function caseResults(Request $request, $caseId)
    {
        $case = LegalCase::with('evidence')->findOrFail($caseId);
        $user = $request->user();

        if (!$user->hasAnyRole(['Admin', 'Judge', 'Lawyer'])) {
            abort(403, 'Only judicial roles can view case summaries.');
        }

        $summary = session('ai_case_summary');

        return view('ai.case-results', compact('case', 'summary'));
    }
}
