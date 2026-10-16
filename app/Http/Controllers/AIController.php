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
        $this->middleware(function ($request, $next) {
            $user = $request->user();
            if (!$user || !$user->hasAnyRole(['Judge', 'Lawyer', 'Admin'])) {
                abort(403, 'Access Denied. Gemma AI evidentiary analysis tools are strictly reserved for Judges and Legal Counsel. Witnesses cannot access or use Gemma AI.');
            }
            return $next($request);
        });
    }

    /**
     * Show the AI dashboard with available features.
     */
    public function index()
    {
        $features    = config('gemma.features', []);
        $configured  = $this->gemma->isConfigured();
        $backend     = $this->gemma->getBackendName();
        $apiKeyHint  = $configured ? substr(config('gemma.api_key', ''), 0, 8) . '...' : null;

        // Only test live connection if a key is present (avoids timeout on load)
        $connectionOk    = false;
        $connectionError = null;
        $activeModel     = config('gemma.model', 'gemini-flash-lite-latest');

        if ($configured) {
            $test = $this->gemma->testConnection();
            $connectionOk    = $test['valid'];
            $connectionError = $test['error'] ?? null;
            $activeModel     = $test['model'] ?? $activeModel;
        }

        return view('ai.index', compact(
            'features', 'configured', 'backend',
            'apiKeyHint', 'connectionOk', 'connectionError', 'activeModel'
        ));
    }

    /**
     * Show evidence analysis form.
     */
    public function evidenceAnalysis(Request $request)
    {
        $user = $request->user();
        if (!$user->hasAnyRole(['Admin', 'Judge', 'Lawyer'])) {
            abort(403, 'Access Denied. Witnesses cannot access Gemma AI analysis.');
        }

        $evidenceId = $request->query('evidence_id');

        $evidence = null;
        if ($evidenceId) {
            $evidence = Evidence::with('user')->findOrFail($evidenceId);
        }

        if ($user->hasRole('Judge')) {
            $assignedCaseIds = \App\Models\LegalCase::where('assigned_judge_id', $user->id)->pluck('id');
            $assignedEvIds   = \DB::table('case_evidence')->whereIn('case_id', $assignedCaseIds)->pluck('evidence_id');
            $recentEvidence  = Evidence::with('user')
                ->whereIn('id', $assignedEvIds)
                ->orderBy('created_at', 'desc')
                ->limit(20)
                ->get();

            if ($recentEvidence->isEmpty()) {
                $recentEvidence = Evidence::with('user')->orderBy('created_at', 'desc')->limit(20)->get();
            }
        } else {
            $recentEvidence = Evidence::with('user')
                ->orderBy('created_at', 'desc')
                ->limit(20)
                ->get();
        }

        return view('ai.evidence-analysis', compact('evidence', 'recentEvidence'));
    }

    /**
     * Run AI analysis on evidence.
     */
    public function analyzeEvidence(AIAnalysisRequest $request, GemmaService $gemma)
    {
        $user = $request->user();
        if (!$user->hasAnyRole(['Admin', 'Judge', 'Lawyer'])) {
            abort(403, 'Access Denied. Witnesses cannot use Gemma AI.');
        }

        if (!$gemma->isConfigured()) {
            return back()->withErrors(['Gemma API is not configured. Please contact the administrator.']);
        }

        $evidenceId = $request->validated('evidence_id');
        $evidence = Evidence::with('user')->findOrFail($evidenceId);

        $evidenceData = [
            'id'           => $evidence->id,
            'title'        => $evidence->title,
            'description'  => $evidence->description,
            'file_hash'    => $evidence->file_hash,
            'mime_type'    => $evidence->mime_type,
            'file_size'    => $evidence->file_size,
            'latitude'     => $evidence->latitude,
            'longitude'    => $evidence->longitude,
            'altitude'     => $evidence->altitude,
            'gps_accuracy' => $evidence->gps_accuracy,
            'device_info'  => $evidence->device_info,
            'captured_at'  => $evidence->captured_at?->toIso8601String(),
            'ingested_at'  => $evidence->created_at?->toIso8601String(),
            'uploaded_by'  => $evidence->user?->name ?? 'Witness ID #' . $evidence->uploaded_by,
            'metadata'     => $evidence->metadata,
        ];

        $result = $gemma->analyzeEvidence($evidenceData);

        if (!$result['success']) {
            return back()->withErrors(['AI analysis failed: ' . $result['error']])->withInput();
        }

        // Store the analysis in session for display
        session(['ai_analysis' => $result]);

        return redirect()->route('ai.evidence-results', ['evidenceId' => $evidence->id])
            ->with('success', 'Evidence analysis completed successfully.');
    }

    /**
     * Show AI analysis results for evidence.
     */
    public function evidenceResults(Request $request, $evidenceId)
    {
        $user = $request->user();
        if (!$user->hasAnyRole(['Admin', 'Judge', 'Lawyer'])) {
            abort(403, 'Access Denied. Witnesses cannot view Gemma AI results.');
        }

        $evidence = Evidence::with('user')->findOrFail($evidenceId);

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
        $case = LegalCase::with(['evidence.user', 'lawyer', 'assignedJudge'])->findOrFail($caseId);

        $user = $request->user();
        if (!$user->hasAnyRole(['Admin', 'Judge', 'Lawyer'])) {
            abort(403, 'Only judicial roles can generate case summaries.');
        }

        $caseData = [
            'id'              => $case->id,
            'case_number'     => $case->case_number,
            'docket_number'   => $case->case_number,
            'title'           => $case->title,
            'description'     => $case->description,
            'status'          => $case->status,
            'court_reference' => $case->court_reference,
            'hearing_date'    => $case->hearing_date?->format('M d, Y'),
            'lawyer'          => $case->lawyer?->name,
            'assigned_judge'  => $case->assignedJudge?->name,
        ];

        $evidenceList = $case->evidence->map(fn($e) => [
            'id'          => $e->id,
            'title'       => $e->title,
            'description' => $e->description,
            'mime_type'   => $e->mime_type,
            'file_hash'   => $e->file_hash,
            'file_size'   => $e->file_size,
            'witness'     => $e->user?->name ?? 'Witness #' . $e->uploaded_by,
        ])->toArray();

        $result = $gemma->summarizeCase($caseData, $evidenceList);

        if (!$result['success']) {
            return back()->withErrors(['Case summary failed: ' . $result['error']])->withInput();
        }

        session(['ai_case_summary' => $result]);

        return redirect()->route('ai.case-results', ['caseId' => $case->id])
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
