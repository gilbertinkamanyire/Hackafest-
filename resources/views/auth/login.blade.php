<x-guest-layout :wide="true">
    <div class="auth-split">
        <!-- Sidebar / Security Pillars -->
        <aside class="auth-split__sidebar">
            <div>
                <!-- Brand Header -->
                <div class="flex items-center gap-3 mb-6">
                    <div style="width: 48px; height: 48px; border-radius: 14px; background: linear-gradient(135deg, rgba(245, 158, 11, 0.25), rgba(180, 83, 9, 0.15)); border: 1px solid #fbbf24; display: flex; align-items: center; justify-content: center; box-shadow: 0 0 25px rgba(245, 158, 11, 0.35);">
                        <i class="ti ti-scale" style="font-size: 1.75rem; color: #fbbf24;"></i>
                    </div>
                    <div>
                        <div style="font-family: 'Cinzel', serif; font-size: 1.4rem; font-weight: 800; background: linear-gradient(to right, #ffffff, #fbbf24); -webkit-background-clip: text; -webkit-text-fill-color: transparent; letter-spacing: 0.5px;">
                            eWitnessVault
                        </div>
                        <div style="font-size: 0.68rem; color: #f59e0b; letter-spacing: 0.1em; text-transform: uppercase; font-weight: 700;">
                            Judicial Evidence Registry
                        </div>
                    </div>
                </div>

                <div style="margin-bottom: 2rem;">
                    <h3 style="font-family: 'Cinzel', serif; font-size: 1.15rem; font-weight: 700; color: #f8fafc; margin-bottom: 0.5rem;">
                        Secure Vault Authentication
                    </h3>
                    <p style="font-size: 0.8125rem; color: #94a3b8; line-height: 1.55;">
                        Role-guarded digital portal for witnesses, legal counsel, and judicial officers.
                    </p>
                </div>

                <!-- Trust Pillars -->
                <div style="display: flex; flex-direction: column; gap: 1rem; margin-bottom: 2rem;">
                    <div style="display: flex; gap: 0.75rem; align-items: flex-start;">
                        <div style="width: 32px; height: 32px; border-radius: 8px; background: rgba(245, 158, 11, 0.12); border: 1px solid rgba(245, 158, 11, 0.28); display: flex; align-items: center; justify-content: center; color: #fbbf24; flex-shrink: 0; font-size: 1.05rem;">
                            <i class="ti ti-user-shield"></i>
                        </div>
                        <div>
                            <div style="font-size: 0.8125rem; font-weight: 700; color: #e2e8f0;">Zero-Trust Access Control</div>
                            <div style="font-size: 0.72rem; color: #64748b; line-height: 1.4;">Granular role permissions ensure only authorized officers review evidence.</div>
                        </div>
                    </div>

                    <div style="display: flex; gap: 0.75rem; align-items: flex-start;">
                        <div style="width: 32px; height: 32px; border-radius: 8px; background: rgba(245, 158, 11, 0.12); border: 1px solid rgba(245, 158, 11, 0.28); display: flex; align-items: center; justify-content: center; color: #fbbf24; flex-shrink: 0; font-size: 1.05rem;">
                            <i class="ti ti-history"></i>
                        </div>
                        <div>
                            <div style="font-size: 0.8125rem; font-weight: 700; color: #e2e8f0;">Immutable Audit Trails</div>
                            <div style="font-size: 0.72rem; color: #64748b; line-height: 1.4;">Every login, exhibit view, and chain of custody event is cryptographically logged.</div>
                        </div>
                    </div>

                    <div style="display: flex; gap: 0.75rem; align-items: flex-start;">
                        <div style="width: 32px; height: 32px; border-radius: 8px; background: rgba(245, 158, 11, 0.12); border: 1px solid rgba(245, 158, 11, 0.28); display: flex; align-items: center; justify-content: center; color: #fbbf24; flex-shrink: 0; font-size: 1.05rem;">
                            <i class="ti ti-database-check"></i>
                        </div>
                        <div>
                            <div style="font-size: 0.8125rem; font-weight: 700; color: #e2e8f0;">Encrypted Vault Storage</div>
                            <div style="font-size: 0.72rem; color: #64748b; line-height: 1.4;">Enterprise relational MySQL storage with SHA-256 verification.</div>
                        </div>
                    </div>
                </div>

                <!-- Vault Health Status Card -->
                <div style="padding: 0.85rem 1rem; background: rgba(30, 41, 59, 0.6); border: 1px solid rgba(245, 158, 11, 0.25); border-radius: 12px; margin-bottom: 1.5rem;">
                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 0.4rem;">
                        <span style="font-size: 0.68rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #fbbf24;">Platform Status</span>
                        <span class="role-choice__badge role-choice__badge--instant" style="display: flex; align-items: center; gap: 0.25rem;">
                            <span style="display: inline-block; width: 6px; height: 6px; border-radius: 50%; background: #10b981;"></span>
                            Live & Online
                        </span>
                    </div>
                    <div style="font-size: 0.75rem; color: #cbd5e1; font-weight: 600;">
                        eWitnessVault Forensic Gateway
                    </div>
                    <div style="font-size: 0.7rem; color: #64748b; margin-top: 0.2rem;">
                        SHA-256 Verification Engine Active
                    </div>
                </div>
            </div>

            <!-- Footer in Sidebar -->
            <div style="padding-top: 1rem; border-top: 1px solid rgba(71, 85, 105, 0.3); display: flex; align-items: center; justify-content: space-between;">
                <div style="font-size: 0.75rem; color: #64748b; display: flex; align-items: center; gap: 0.35rem;">
                    <i class="ti ti-lock" style="color: #10b981;"></i> 256-bit Encrypted
                </div>
                <a href="{{ route('register') }}" class="auth-link" style="font-size: 0.78rem;">
                    New account? Sign up &rarr;
                </a>
            </div>
        </aside>

        <!-- Main Login Content -->
        <main class="auth-split__content" style="display: flex; flex-direction: column; justify-content: center;">
            <div class="mb-5">
                <h2 style="font-size: 1.65rem; font-weight: 800; color: #f8fafc; letter-spacing: -0.02em; margin-bottom: 0.25rem;">
                    Sign In to Vault
                </h2>
                <p style="font-size: 0.85rem; color: #94a3b8;">
                    Enter your authorized credentials to access evidence management and case files.
                </p>
            </div>

            <!-- Session Status Alerts -->
            @if (session('status'))
                <div class="auth-alert auth-alert--success" style="margin-bottom: 1.25rem;">
                    <i class="ti ti-circle-check" style="font-size: 1.15rem; flex-shrink: 0;"></i>
                    <div style="font-size: 0.8125rem;">{{ session('status') }}</div>
                </div>
            @endif

            @if (session('message'))
                <div class="auth-alert auth-alert--success" style="margin-bottom: 1.25rem;">
                    <i class="ti ti-circle-check" style="font-size: 1.15rem; flex-shrink: 0;"></i>
                    <div style="font-size: 0.8125rem;">{{ session('message') }}</div>
                </div>
            @endif

            @if ($errors->any())
                <div class="auth-alert auth-alert--error" style="margin-bottom: 1.25rem;">
                    <i class="ti ti-alert-circle" style="font-size: 1.15rem; flex-shrink: 0;"></i>
                    <div style="font-size: 0.8125rem;">
                        {{ __('Invalid credentials or unauthorized account status. Please check your details and try again.') }}
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="auth-form" style="gap: 1.25rem;">
                @csrf

                <!-- Email Address -->
                <div class="auth-form__field">
                    <label for="email" class="auth-label">Official Email Address</label>
                    <div class="input-icon-wrapper">
                        <i class="ti ti-mail input-icon"></i>
                        <input id="email" class="auth-input" type="email" name="email"
                            value="{{ old('email') }}" required autofocus autocomplete="username"
                            placeholder="officer@agency.gov or registered email">
                    </div>
                    @error('email')
                        <p class="auth-error"><i class="ti ti-alert-circle"></i> {{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="auth-form__field">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <label for="password" class="auth-label">Vault Password</label>
                        @if (Route::has('password.request'))
                            <a class="auth-link" href="{{ route('password.request') }}" style="font-size: 0.78rem;">
                                Forgot password?
                            </a>
                        @endif
                    </div>
                    <div class="input-icon-wrapper password-wrapper">
                        <i class="ti ti-lock input-icon"></i>
                        <input id="password" class="auth-input" type="password" name="password"
                            required autocomplete="current-password" placeholder="••••••••••••"
                            style="padding-right: 3rem;">
                        <button type="button" class="password-toggle" onclick="toggleLoginPassword(this)" title="Toggle password visibility">
                            <i class="ti ti-eye"></i>
                        </button>
                    </div>
                    @error('password')
                        <p class="auth-error"><i class="ti ti-alert-circle"></i> {{ $message }}</p>
                    @enderror
                </div>

                <!-- Remember Me & Security Notice -->
                <div class="auth-meta" style="margin-top: -0.25rem;">
                    <label for="remember_me" class="auth-checkbox">
                        <input id="remember_me" type="checkbox" name="remember">
                        <span>Remember this secure session</span>
                    </label>
                </div>

                <!-- Submit CTA -->
                <button type="submit" class="auth-button" style="margin-top: 0.5rem; display: flex; align-items: center; justify-content: center; gap: 0.5rem;">
                    <i class="ti ti-login" style="font-size: 1.25rem;"></i>
                    <span>Sign In to Vault</span>
                </button>
            </form>

            <div class="auth-footer" style="margin-top: 2rem;">
                Need credentials to access eWitnessVault?
                <a href="{{ route('register') }}" class="auth-link">Create a vault account</a>
            </div>
        </main>
    </div>

    <script>
        function toggleLoginPassword(btn) {
            const input = document.getElementById('password');
            const icon = btn.querySelector('i');
            if (input.type === 'password') {
                input.type = 'text';
                icon.className = 'ti ti-eye-off';
            } else {
                input.type = 'password';
                icon.className = 'ti ti-eye';
            }
        }
    </script>
</x-guest-layout>
