<x-guest-layout :wide="true">
    <div class="auth-split">
        <!-- Sidebar / Security Pillars -->
        <aside class="auth-split__sidebar">
            <div>
                <!-- Brand Header -->
                <div class="flex items-center gap-3 mb-6">
                    <div style="width: 48px; height: 48px; border-radius: 14px; background: linear-gradient(135deg, rgba(245, 158, 11, 0.25), rgba(180, 83, 9, 0.15)); border: 1px solid #fbbf24; display: flex; align-items: center; justify-content: center; box-shadow: 0 0 25px rgba(245, 158, 11, 0.35);">
                        <i class="ti ti-shield-lock" style="font-size: 1.75rem; color: #fbbf24;"></i>
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
                        Credential Recovery Protocol
                    </h3>
                    <p style="font-size: 0.8125rem; color: #94a3b8; line-height: 1.55;">
                        Self-service identity verification and secure password restoration for authorized vault accounts.
                    </p>
                </div>

                <!-- Trust Pillars -->
                <div style="display: flex; flex-direction: column; gap: 1rem; margin-bottom: 2rem;">
                    <div style="display: flex; gap: 0.75rem; align-items: flex-start;">
                        <div style="width: 32px; height: 32px; border-radius: 8px; background: rgba(245, 158, 11, 0.12); border: 1px solid rgba(245, 158, 11, 0.28); display: flex; align-items: center; justify-content: center; color: #fbbf24; flex-shrink: 0; font-size: 1.05rem;">
                            <i class="ti ti-key"></i>
                        </div>
                        <div>
                            <div style="font-size: 0.8125rem; font-weight: 700; color: #e2e8f0;">Signed Recovery Tokens</div>
                            <div style="font-size: 0.72rem; color: #64748b; line-height: 1.4;">Time-limited cryptographic token dispatched directly to your sworn email.</div>
                        </div>
                    </div>

                    <div style="display: flex; gap: 0.75rem; align-items: flex-start;">
                        <div style="width: 32px; height: 32px; border-radius: 8px; background: rgba(245, 158, 11, 0.12); border: 1px solid rgba(245, 158, 11, 0.28); display: flex; align-items: center; justify-content: center; color: #fbbf24; flex-shrink: 0; font-size: 1.05rem;">
                            <i class="ti ti-shield-check"></i>
                        </div>
                        <div>
                            <div style="font-size: 0.8125rem; font-weight: 700; color: #e2e8f0;">Zero Credential Exposure</div>
                            <div style="font-size: 0.72rem; color: #64748b; line-height: 1.4;">Vault passwords are salted and hashed with Argon2/Bcrypt; never stored in cleartext.</div>
                        </div>
                    </div>

                    <div style="display: flex; gap: 0.75rem; align-items: flex-start;">
                        <div style="width: 32px; height: 32px; border-radius: 8px; background: rgba(245, 158, 11, 0.12); border: 1px solid rgba(245, 158, 11, 0.28); display: flex; align-items: center; justify-content: center; color: #fbbf24; flex-shrink: 0; font-size: 1.05rem;">
                            <i class="ti ti-history"></i>
                        </div>
                        <div>
                            <div style="font-size: 0.8125rem; font-weight: 700; color: #e2e8f0;">Audited Reset Event</div>
                            <div style="font-size: 0.72rem; color: #64748b; line-height: 1.4;">Every password restoration dispatch is permanently recorded in the security audit log.</div>
                        </div>
                    </div>
                </div>

                <!-- Vault Health Status Card -->
                <div style="padding: 0.85rem 1rem; background: rgba(30, 41, 59, 0.6); border: 1px solid rgba(245, 158, 11, 0.25); border-radius: 12px; margin-bottom: 1.5rem;">
                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 0.4rem;">
                        <span style="font-size: 0.68rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #fbbf24;">Security Protocol</span>
                        <span class="role-choice__badge role-choice__badge--instant" style="display: flex; align-items: center; gap: 0.25rem;">
                            <span style="display: inline-block; width: 6px; height: 6px; border-radius: 50%; background: #10b981;"></span>
                            Token Dispatch Ready
                        </span>
                    </div>
                    <div style="font-size: 0.75rem; color: #cbd5e1; font-weight: 600;">
                        eWitnessVault Identity Recovery
                    </div>
                    <div style="font-size: 0.7rem; color: #64748b; margin-top: 0.2rem;">
                        Automated Token Expiration: 60 Minutes
                    </div>
                </div>
            </div>

            <!-- Footer in Sidebar -->
            <div style="padding-top: 1rem; border-top: 1px solid rgba(71, 85, 105, 0.3); display: flex; align-items: center; justify-content: space-between;">
                <div style="font-size: 0.75rem; color: #64748b; display: flex; align-items: center; gap: 0.35rem;">
                    <i class="ti ti-lock" style="color: #10b981;"></i> 256-bit Encrypted
                </div>
                <a href="{{ route('login') }}" class="auth-link" style="font-size: 0.78rem;">
                    Remember password? Sign in &rarr;
                </a>
            </div>
        </aside>

        <!-- Main Recovery Content -->
        <main class="auth-split__content" style="display: flex; flex-direction: column; justify-content: center;">
            <div class="mb-5">
                <div style="display: inline-flex; align-items: center; gap: 0.4rem; padding: 0.25rem 0.65rem; border-radius: 50px; background: rgba(245, 158, 11, 0.12); border: 1px solid rgba(245, 158, 11, 0.3); color: #fbbf24; font-size: 0.72rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.06em; margin-bottom: 0.75rem;">
                    <i class="ti ti-key"></i> Password Restoration
                </div>
                <h2 style="font-size: 1.65rem; font-weight: 800; color: #f8fafc; letter-spacing: -0.02em; margin-bottom: 0.35rem;">
                    Reset Vault Password
                </h2>
                <p style="font-size: 0.85rem; color: #94a3b8; line-height: 1.5;">
                    Provide your verified registered email address. We will transmit an authenticated password reset link enabling you to establish new secure credentials.
                </p>
            </div>

            <!-- Session Status Alerts -->
            @if (session('status'))
                <div class="auth-alert auth-alert--success" style="margin-bottom: 1.35rem;">
                    <i class="ti ti-circle-check" style="font-size: 1.25rem; flex-shrink: 0; color: #34d399;"></i>
                    <div style="font-size: 0.8125rem; color: #e2e8f0; line-height: 1.45;">
                        <strong style="color: #34d399; display: block; margin-bottom: 0.15rem;">Recovery Dispatch Transmitted</strong>
                        {{ session('status') }}
                    </div>
                </div>
            @endif

            @if ($errors->any())
                <div class="auth-alert auth-alert--error" style="margin-bottom: 1.35rem;">
                    <i class="ti ti-alert-circle" style="font-size: 1.25rem; flex-shrink: 0; color: #f87171;"></i>
                    <div style="font-size: 0.8125rem; color: #fca5a5;">
                        {{ $errors->first('email') ?: __('Unable to process credential reset. Please verify your address and retry.') }}
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}" class="auth-form" style="gap: 1.35rem;">
                @csrf

                <!-- Email Address -->
                <div class="auth-form__field">
                    <label for="email" class="auth-label">Registered Official Email Address</label>
                    <div class="input-icon-wrapper">
                        <i class="ti ti-mail input-icon"></i>
                        <input id="email" class="auth-input" type="email" name="email"
                            value="{{ old('email') }}" required autofocus autocomplete="username"
                            placeholder="officer@agency.gov or registered email address">
                    </div>
                    <span style="font-size: 0.72rem; color: #64748b; margin-top: 0.35rem; display: block;">
                        The recovery dispatch will be delivered exclusively to this account address.
                    </span>
                    @error('email')
                        <p class="auth-error"><i class="ti ti-alert-circle"></i> {{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit CTA -->
                <button type="submit" class="auth-button" style="margin-top: 0.5rem; display: flex; align-items: center; justify-content: center; gap: 0.5rem;">
                    <i class="ti ti-send" style="font-size: 1.15rem;"></i>
                    <span>Transmit Password Reset Link</span>
                </button>
            </form>

            <!-- Judicial Security Advisory Box -->
            <div style="margin-top: 1.75rem; padding: 1rem 1.15rem; background: rgba(8, 12, 22, 0.7); border: 1px solid rgba(71, 85, 105, 0.3); border-radius: 12px; display: flex; gap: 0.75rem; align-items: flex-start;">
                <i class="ti ti-info-circle" style="color: #fbbf24; font-size: 1.15rem; flex-shrink: 0; margin-top: 0.1rem;"></i>
                <div style="font-size: 0.75rem; color: #94a3b8; line-height: 1.5;">
                    <strong style="color: #cbd5e1; display: block; margin-bottom: 0.15rem;">Chain of Custody Security Directive</strong>
                    Password reset tokens are valid for 60 minutes and single-use only. If you did not request a credential recovery dispatch, report this event to the platform administrator immediately.
                </div>
            </div>

            <div class="auth-footer" style="margin-top: 2rem;">
                Back to authorized access?
                <a href="{{ route('login') }}" class="auth-link">Sign In to Vault</a>
            </div>
        </main>
    </div>
</x-guest-layout>
