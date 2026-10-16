<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\LegalCase;
use App\Models\Evidence;
use App\Models\User;


class CaseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * List all cases. Lawyers see their own; Judges & Admins see all.
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->hasRole('Judge')) {
            // Judges can ONLY see dockets explicitly pushed to them by a lawyer
            $cases = LegalCase::where('assigned_judge_id', $user->id)
                ->with(['lawyer', 'evidence', 'assignedJudge'])
                ->orderBy('created_at', 'desc')
                ->paginate(12);
        } elseif ($user->hasRole('Admin')) {
            $cases = LegalCase::with(['lawyer', 'evidence', 'assignedJudge'])
                ->orderBy('created_at', 'desc')
                ->paginate(12);
        } elseif ($user->hasRole('Lawyer')) {
            $cases = LegalCase::where('created_by', $user->id)
                ->with(['lawyer', 'evidence', 'assignedJudge'])
                ->orderBy('created_at', 'desc')
                ->paginate(12);
        } else {
            abort(403, 'Case dockets are restricted to Legal Counsel and Judicial Officers.');
        }

        return view('cases.index', compact('cases', 'user'));
    }

    /**
     * Show the create-case form (Lawyer & Admin only)
     */
    public function create()
    {
        $user = Auth::user();
        if (!$user->hasAnyRole(['Lawyer', 'Admin'])) {
            abort(403, 'Only Legal Counsel may open new case dockets.');
        }

        // Available evidence to link — all evidence visible to user
        $availableEvidence = Evidence::with('user')->orderBy('created_at', 'desc')->get();

        // Get all verified Judges so the lawyer can select presiding judge
        $judgeRole = \DB::table('roles')->where('name', 'Judge')->first();
        $judges = collect();
        if ($judgeRole) {
            $judgeUserIds = \DB::table('user_roles')->where('role_id', $judgeRole->id)->pluck('user_id');
            $judges = User::whereIn('id', $judgeUserIds)->where('is_verified', true)->orderBy('name')->get();
        }

        return view('cases.create', compact('availableEvidence', 'judges'));
    }

    /**
     * Store a new case
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        if (!$user->hasAnyRole(['Lawyer', 'Admin'])) {
            abort(403, 'Only Legal Counsel may open new case dockets.');
        }

        $request->validate([
            'title'             => 'required|string|max:255',
            'description'       => 'nullable|string|max:5000',
            'court_reference'   => 'nullable|string|max:255',
            'hearing_date'      => 'nullable|date|after_or_equal:today',
            'status'            => 'in:open,under_review,closed,archived',
            'assigned_judge_id' => 'nullable|integer|exists:users,id',
            'evidence_ids'      => 'nullable|array',
            'evidence_ids.*'    => 'integer|exists:evidence,id',
        ]);

        // Concurrency lock to strictly prevent parallel double submissions
        $lockKey = 'case_store_lock_' . $user->id;
        $lock = \Illuminate\Support\Facades\Cache::lock($lockKey, 15);

        if (!$lock->get()) {
            return redirect()->route('cases.index')->with('info', 
                'Case docket creation is currently in progress. Please wait a moment.'
            );
        }

        try {
            // DUPLICATE SUBMISSION CHECK: Prevent double docket creation
            $existingCase = LegalCase::where('created_by', $user->id)
                ->where('title', $request->title)
                ->where('created_at', '>=', now()->subSeconds(60))
                ->first();

            if ($existingCase) {
                return redirect()->route('cases.show', $existingCase->id)
                    ->with('info', 'Case docket ' . $existingCase->case_number . ' is already registered.');
            }

            $case = LegalCase::create([
                'title'             => $request->title,
                'description'       => $request->description,
                'created_by'        => $user->id,
                'assigned_judge_id' => $request->assigned_judge_id ?: null,
                'status'            => $request->status ?? 'open',
                'court_reference'   => $request->court_reference,
                'hearing_date'      => $request->hearing_date,
            ]);

            // Attach selected evidence in lawyer's specified initial order
            if ($request->has('evidence_ids') && is_array($request->evidence_ids)) {
                $pivotData = [];
                foreach (array_values($request->evidence_ids) as $i => $evidenceId) {
                    $pivotData[$evidenceId] = [
                        'added_by'   => $user->id,
                        'sort_order' => $i,
                        'notes'      => null,
                    ];
                }
                $case->evidence()->attach($pivotData);
            }

            return redirect()->route('cases.show', $case->id)
                ->with('success', 'Case docket ' . $case->case_number . ' created successfully.');
        } finally {
            optional($lock)->release();
        }
    }

    /**
     * View a case with its linked evidence
     */
    public function show($id)
    {
        $user = Auth::user();

        if (!$user->hasAnyRole(['Lawyer', 'Judge', 'Admin'])) {
            abort(403, 'Access to case dockets is restricted to Legal Officers.');
        }

        $case = LegalCase::with(['lawyer', 'assignedJudge', 'evidence.user'])->findOrFail($id);

        // Lawyers can only see their own cases
        if ($user->hasRole('Lawyer') && $case->created_by !== $user->id) {
            abort(403, 'You do not have clearance to view this case docket.');
        }

        // Judges can only see cases assigned to them
        if ($user->hasRole('Judge') && $case->assigned_judge_id !== $user->id) {
            abort(403, 'This docket has not been assigned to you.');
        }

        // All evidence available to add to the case (not already linked) — for Lawyer/Admin sidebar
        $availableEvidence = collect();
        if ($user->hasAnyRole(['Lawyer', 'Admin'])) {
            $linkedIds = $case->evidence->pluck('id')->toArray();
            $availableEvidence = Evidence::with('user')
                ->whereNotIn('id', $linkedIds)
                ->orderBy('created_at', 'desc')
                ->get();
        }

        // List of judges for assignment panel (Lawyer/Admin only)
        $judges = collect();
        if ($user->hasAnyRole(['Lawyer', 'Admin'])) {
            $judgeRole = \DB::table('roles')->where('name', 'Judge')->first();
            if ($judgeRole) {
                $judgeUserIds = \DB::table('user_roles')->where('role_id', $judgeRole->id)->pluck('user_id');
                $judges = User::whereIn('id', $judgeUserIds)->where('is_verified', true)->get();
            }
        }

        return view('cases.show', compact('case', 'user', 'availableEvidence', 'judges'));
    }

    /**
     * Show edit form (Lawyer owner or Admin)
     */
    public function edit($id)
    {
        $user  = Auth::user();
        $case  = LegalCase::with('evidence')->findOrFail($id);

        if ($user->hasRole('Lawyer') && $case->created_by !== $user->id) {
            abort(403, 'You may only edit your own case dockets.');
        }
        if (!$user->hasAnyRole(['Lawyer', 'Admin'])) {
            abort(403, 'Only Legal Counsel may edit case dockets.');
        }

        $linkedIds        = $case->evidence->pluck('id')->toArray();
        $availableEvidence = Evidence::with('user')
            ->whereNotIn('id', $linkedIds)
            ->orderBy('created_at', 'desc')
            ->get();

        $judgeRole = \DB::table('roles')->where('name', 'Judge')->first();
        $judges = collect();
        if ($judgeRole) {
            $judgeUserIds = \DB::table('user_roles')->where('role_id', $judgeRole->id)->pluck('user_id');
            $judges = User::whereIn('id', $judgeUserIds)->where('is_verified', true)->orderBy('name')->get();
        }

        return view('cases.edit', compact('case', 'availableEvidence', 'judges'));
    }

    /**
     * Update case details
     */
    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $case = LegalCase::findOrFail($id);

        if ($user->hasRole('Lawyer') && $case->created_by !== $user->id) {
            abort(403, 'You may only edit your own case dockets.');
        }
        if (!$user->hasAnyRole(['Lawyer', 'Admin'])) {
            abort(403, 'Only Legal Counsel may edit case dockets.');
        }

        $request->validate([
            'title'             => 'required|string|max:255',
            'description'       => 'nullable|string|max:5000',
            'court_reference'   => 'nullable|string|max:255',
            'hearing_date'      => 'nullable|date',
            'status'            => 'in:open,under_review,closed,archived',
            'assigned_judge_id' => 'nullable|integer|exists:users,id',
        ]);

        $case->update([
            'title'             => $request->title,
            'description'       => $request->description,
            'status'            => $request->status,
            'assigned_judge_id' => $request->assigned_judge_id ?: null,
            'court_reference'   => $request->court_reference,
            'hearing_date'      => $request->hearing_date,
        ]);

        return redirect()->route('cases.show', $case->id)
            ->with('success', 'Case docket updated successfully.');
    }

    /**
     * Add evidence to a case
     */
    public function addEvidence(Request $request, $id)
    {
        $user = Auth::user();
        $case = LegalCase::findOrFail($id);

        if ($user->hasRole('Lawyer') && $case->created_by !== $user->id) {
            abort(403, 'You may only modify your own case dockets.');
        }
        if (!$user->hasAnyRole(['Lawyer', 'Admin'])) {
            abort(403, 'Only Legal Counsel may modify case dockets.');
        }

        $request->validate([
            'evidence_ids'   => 'required|array|min:1',
            'evidence_ids.*' => 'integer|exists:evidence,id',
            'notes'          => 'nullable|string|max:1000',
        ]);

        $currentCount = $case->evidence()->count();
        $pivotData    = [];

        foreach (array_values($request->evidence_ids) as $i => $evidenceId) {
            $pivotData[$evidenceId] = [
                'added_by'   => $user->id,
                'sort_order' => $currentCount + $i,
                'notes'      => $request->notes,
            ];
        }

        $case->evidence()->syncWithoutDetaching($pivotData);

        return back()->with('success', count($request->evidence_ids) . ' exhibit(s) added to case docket.');
    }

    /**
     * Remove a single evidence from a case
     */
    public function removeEvidence(Request $request, $id, $evidenceId)
    {
        $user = Auth::user();
        $case = LegalCase::findOrFail($id);

        if ($user->hasRole('Lawyer') && $case->created_by !== $user->id) {
            abort(403, 'You may only modify your own case dockets.');
        }
        if (!$user->hasAnyRole(['Lawyer', 'Admin'])) {
            abort(403, 'Only Legal Counsel may modify case dockets.');
        }

        $case->evidence()->detach($evidenceId);

        return back()->with('success', 'Exhibit removed from case docket.');
    }

    /**
     * Update pivot note for a specific evidence in a case
     */
    public function updateEvidenceNote(Request $request, $id, $evidenceId)
    {
        $user = Auth::user();
        $case = LegalCase::findOrFail($id);

        if ($user->hasRole('Lawyer') && $case->created_by !== $user->id) {
            abort(403, 'Unauthorized.');
        }
        if (!$user->hasAnyRole(['Lawyer', 'Admin'])) {
            abort(403, 'Unauthorized.');
        }

        $request->validate(['notes' => 'nullable|string|max:1000']);

        $case->evidence()->updateExistingPivot($evidenceId, ['notes' => $request->notes]);

        return back()->with('success', 'Exhibit notes updated.');
    }

    /**
     * Delete a case
     */
    public function destroy($id)
    {
        $user = Auth::user();
        $case = LegalCase::findOrFail($id);

        if ($user->hasRole('Lawyer') && $case->created_by !== $user->id) {
            abort(403, 'You may only delete your own case dockets.');
        }
        if (!$user->hasAnyRole(['Lawyer', 'Admin'])) {
            abort(403, 'Only Legal Counsel may delete case dockets.');
        }

        $caseNumber = $case->case_number;
        $case->delete();

        return redirect()->route('cases.index')
            ->with('success', 'Case docket ' . $caseNumber . ' has been permanently closed.');
    }

    /**
     * Assign (push) this docket to a specific judge.
     * Only the owning Lawyer or an Admin may do this.
     */
    public function assignJudge(Request $request, $id)
    {
        $user = Auth::user();
        $case = LegalCase::findOrFail($id);

        if ($user->hasRole('Lawyer') && $case->created_by !== $user->id) {
            abort(403, 'You may only assign judges to your own case dockets.');
        }
        if (!$user->hasAnyRole(['Lawyer', 'Admin'])) {
            abort(403, 'Only Legal Counsel may assign judges to case dockets.');
        }

        $request->validate([
            'judge_id' => 'required|integer|exists:users,id',
        ]);

        // Verify target user is actually a Judge
        $judgeRole    = \DB::table('roles')->where('name', 'Judge')->first();
        $isJudge      = $judgeRole && \DB::table('user_roles')
            ->where('user_id', $request->judge_id)
            ->where('role_id', $judgeRole->id)
            ->exists();

        if (!$isJudge) {
            return back()->withErrors(['judge_id' => 'The selected user does not hold the Judge role.']);
        }

        $judge = User::findOrFail($request->judge_id);

        $case->update(['assigned_judge_id' => $judge->id]);

        return back()->with('success', 'Docket ' . $case->case_number . ' has been pushed to Judge ' . $judge->name . '.');
    }

    /**
     * Revoke judge assignment from a docket.
     */
    public function unassignJudge($id)
    {
        $user = Auth::user();
        $case = LegalCase::findOrFail($id);

        if ($user->hasRole('Lawyer') && $case->created_by !== $user->id) {
            abort(403, 'You may only modify your own case dockets.');
        }
        if (!$user->hasAnyRole(['Lawyer', 'Admin'])) {
            abort(403, 'Only Legal Counsel may modify case dockets.');
        }

        $case->update(['assigned_judge_id' => null]);

        return back()->with('success', 'Judge assignment removed from docket.');
    }

    /**
     * Reorder evidence in a case docket (move up, move down, or set new order)
     */
    public function reorderEvidence(Request $request, $id)
    {
        $user = Auth::user();
        $case = LegalCase::with(['evidence' => fn($q) => $q->orderBy('case_evidence.sort_order')])->findOrFail($id);

        if ($user->hasRole('Lawyer') && $case->created_by !== $user->id) {
            abort(403, 'Unauthorized.');
        }
        if (!$user->hasAnyRole(['Lawyer', 'Admin'])) {
            abort(403, 'Unauthorized.');
        }

        if ($request->has('evidence_id') && $request->has('direction')) {
            $evidenceId = (int) $request->evidence_id;
            $direction  = $request->direction;

            $items = $case->evidence->values();
            $index = $items->search(fn($item) => $item->id === $evidenceId);

            if ($index !== false) {
                if ($direction === 'up' && $index > 0) {
                    $targetItem   = $items[$index - 1];
                    $currentOrder = $items[$index]->pivot->sort_order ?? $index;
                    $targetOrder  = $targetItem->pivot->sort_order ?? ($index - 1);

                    if ($currentOrder === $targetOrder) {
                        $currentOrder = $index;
                        $targetOrder  = $index - 1;
                    }

                    $case->evidence()->updateExistingPivot($evidenceId, ['sort_order' => $targetOrder]);
                    $case->evidence()->updateExistingPivot($targetItem->id, ['sort_order' => $currentOrder]);
                } elseif ($direction === 'down' && $index < $items->count() - 1) {
                    $targetItem   = $items[$index + 1];
                    $currentOrder = $items[$index]->pivot->sort_order ?? $index;
                    $targetOrder  = $targetItem->pivot->sort_order ?? ($index + 1);

                    if ($currentOrder === $targetOrder) {
                        $currentOrder = $index;
                        $targetOrder  = $index + 1;
                    }

                    $case->evidence()->updateExistingPivot($evidenceId, ['sort_order' => $targetOrder]);
                    $case->evidence()->updateExistingPivot($targetItem->id, ['sort_order' => $currentOrder]);
                }
            }

            return back()->with('success', 'Exhibit sequence reordered successfully.');
        }

        return back();
    }
}
