<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        \Illuminate\Support\Facades\Log::info('Registration attempt', ['email' => $request->email]);
        
        if (\App\Models\User::where('email', $request->email)->exists()) {
            return back()->withInput()->withErrors(['email' => 'This email is already registered. Please sign in instead.']);
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique('users', 'email')],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'phone' => ['nullable', 'string', 'max:20'],
            'role_requested' => ['nullable', 'string', 'in:Witness,Lawyer,Judge'],
        ]);

        $selectedRole = $request->role_requested ?: 'Witness';
        $requiresReview = in_array($selectedRole, ['Judge', 'Lawyer']);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'role_requested' => $requiresReview ? $selectedRole : null,
            'is_verified' => !$requiresReview, // Witnesses get instant access
        ]);

        // Assign chosen role
        $role = \App\Models\Role::where('name', $selectedRole)->first();
        if ($role) {
            $user->roles()->attach($role->id);
        } else {
            $fallbackRole = \App\Models\Role::where('name', 'Witness')->orWhere('name', 'User')->first();
            if ($fallbackRole) {
                $user->roles()->attach($fallbackRole->id);
            }
        }

        event(new Registered($user));

        // If user requested Judge or Lawyer, hold for administrative credential review
        if ($requiresReview) {
            return redirect()->route('login')->with('status', "Registration submitted! As a {$selectedRole}, your account is undergoing administrative credential verification. You will be able to sign in once approved.");
        }

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
