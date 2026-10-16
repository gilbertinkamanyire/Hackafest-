<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Evidence;
use App\Models\User;
use App\Models\LegalCase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Ensure user is authenticated
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display role-specific dashboard
     */
    public function index()
    {
        $user = Auth::user();

        // Check if user is verified
        if (!$user->is_verified && $user->hasAnyRole(['Judge', 'Lawyer'])) {
            return view('dashboard-pending');
        }

        // Redirect admin to admin dashboard
        if ($user->hasRole('Admin')) {
            return redirect()->route('admin.dashboard');
        }

        // Fetch evidence based on role
        if ($user->hasRole('Judge')) {
            // Judges only see evidence that belongs to dockets assigned to them
            $assignedCaseIds = \App\Models\LegalCase::where('assigned_judge_id', $user->id)->pluck('id');
            $evidenceIds     = \DB::table('case_evidence')->whereIn('case_id', $assignedCaseIds)->pluck('evidence_id');
            $evidenceList    = Evidence::whereIn('id', $evidenceIds)->orderBy('created_at', 'desc')->get();
        } elseif ($user->hasRole('Lawyer')) {
            // Lawyers see ALL evidence in the vault
            $evidenceList = Evidence::orderBy('created_at', 'desc')->get();
        } else {
            // Witnesses see only their own submissions
            $evidenceList = Evidence::where('uploaded_by', $user->id)
                ->orderBy('created_at', 'desc')
                ->get();
        }

        // Role-specific statistics
        $stats = $this->getRoleStats($user);

        // Role-specific features
        $features = $this->getRoleFeatures($user);

        return view('dashboard', compact('user', 'evidenceList', 'stats', 'features'));
    }

    /**
     * Get role-specific statistics
     */
    private function getRoleStats($user)
    {
        $stats = [
            'user_evidence' => Evidence::where('uploaded_by', $user->id)->count(),
            'total_evidence' => Evidence::count(),
            'total_users' => User::count(),
            'verified_users' => User::where('is_verified', true)->count(),
        ];

        // Role-specific stats
        if ($user->hasRole('Judge')) {
            $stats['assigned_dockets'] = \App\Models\LegalCase::where('assigned_judge_id', $user->id)->count();
            $stats['open_dockets']     = \App\Models\LegalCase::where('assigned_judge_id', $user->id)->where('status', 'open')->count();
        }

        if ($user->hasRole('Lawyer')) {
            $stats['active_cases'] = \App\Models\LegalCase::where('created_by', $user->id)->where('status', 'open')->count();
            $stats['closed_cases'] = \App\Models\LegalCase::where('created_by', $user->id)->where('status', 'closed')->count();
        }

        return $stats;
    }

    /**
     * Get role-specific features
     */
    private function getRoleFeatures($user)
    {
        $features = [
            'can_view_all' => $user->hasAnyRole(['Lawyer', 'Admin']),
            'can_upload'   => $user->hasRole('Witness'),   // ONLY witnesses may upload
            'can_review'   => $user->hasRole('Judge'),
            'can_assign'   => $user->hasRole('Admin'),
            'role_name'    => $this->getRoleName($user),
            'role_icon'    => $this->getRoleIcon($user),
        ];

        return $features;
    }

    /**
     * Get primary role name
     */
    private function getRoleName($user)
    {
        if ($user->hasRole('Judge')) return 'Judge';
        if ($user->hasRole('Lawyer')) return 'Lawyer';
        if ($user->hasRole('Admin')) return 'Administrator';
        return 'Witness';
    }

    /**
     * Get role icon
     */
    private function getRoleIcon($user)
    {
        if ($user->hasRole('Judge')) return 'ti-gavel';
        if ($user->hasRole('Lawyer')) return 'ti-briefcase';
        if ($user->hasRole('Admin')) return 'ti-shield-cog';
        return 'ti-user-check';
    }
}