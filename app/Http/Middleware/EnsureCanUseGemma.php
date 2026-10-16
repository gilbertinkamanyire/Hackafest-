<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureCanUseGemma
{
    /**
     * Handle an incoming request.
     *
     * Only Judges, Lawyers, and Admins can access Gemma AI tools.
     * Witnesses are strictly prohibited from using Gemma AI.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Only Judge, Lawyer, and Admin roles are permitted to use Gemma AI
        if (!$user->hasAnyRole(['Judge', 'Lawyer', 'Admin'])) {
            abort(403, 'Access Denied. Gemma AI evidentiary analysis tools are strictly reserved for Judges and Legal Counsel. Witnesses cannot access or use Gemma AI.');
        }

        return $next($request);
    }
}
