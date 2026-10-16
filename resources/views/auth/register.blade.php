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
                        Tamper-Evident Chain of Custody
                    </h3>
                    <p style="font-size: 0.8125rem; color: #94a3b8; line-height: 1.55;">
                        Designed to safeguard the integrity of digital evidence from submission through judicial trial review.
                    </p>
                </div>

                <!-- Trust Pillars -->
                <div style="display: flex; flex-direction: column; gap: 1rem; margin-bottom: 2rem;">
                    <div style="display: flex; gap: 0.75rem; align-items: flex-start;">
                        <div style="width: 32px; height: 32px; border-radius: 8px; background: rgba(245, 158, 11, 0.12); border: 1px solid rgba(245, 158, 11, 0.28); display: flex; align-items: center; justify-content: center; color: #fbbf24; flex-shrink: 0; font-size: 1.05rem;">
                            <i class="ti ti-binary"></i>
                        </div>
                        <div>
                            <div style="font-size: 0.8125rem; font-weight: 700; color: #e2e8f0;">Cryptographic SHA-256</div>
                            <div style="font-size: 0.72rem; color: #64748b; line-height: 1.4;">Every uploaded file is hashed at ingestion to detect alterations.</div>
                        </div>
                    </div>

                    <div style="display: flex; gap: 0.75rem; align-items: flex-start;">
                        <div style="width: 32px; height: 32px; border-radius: 8px; background: rgba(245, 158, 11, 0.12); border: 1px solid rgba(245, 158, 11, 0.28); display: flex; align-items: center; justify-content: center; color: #fbbf24; flex-shrink: 0; font-size: 1.05rem;">
                            <i class="ti ti-map-pin-check"></i>
                        </div>
                        <div>
                            <div style="font-size: 0.8125rem; font-weight: 700; color: #e2e8f0;">Forensic Metadata</div>
                            <div style="font-size: 0.72rem; color: #64748b; line-height: 1.4;">Automatic GPS coordinates and UTC timestamps locked to each exhibit.</div>
                        </div>
                    </div>

                    <div style="display: flex; gap: 0.75rem; align-items: flex-start;">
                        <div style="width: 32px; height: 32px; border-radius: 8px; background: rgba(245, 158, 11, 0.12); border: 1px solid rgba(245, 158, 11, 0.28); display: flex; align-items: center; justify-content: center; color: #fbbf24; flex-shrink: 0; font-size: 1.05rem;">
                            <i class="ti ti-scale"></i>
                        </div>
                        <div>
                            <div style="font-size: 0.8125rem; font-weight: 700; color: #e2e8f0;">Judicial Admissibility</div>
                            <div style="font-size: 0.72rem; color: #64748b; line-height: 1.4;">Structured audit logs recognized for evidentiary discovery in court.</div>
                        </div>
                    </div>
                </div>

                <!-- Selected Role Preview Box -->
                <div id="role-preview-box" style="padding: 0.85rem 1rem; background: rgba(30, 41, 59, 0.6); border: 1px solid rgba(245, 158, 11, 0.25); border-radius: 12px; margin-bottom: 1.5rem;">
                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 0.35rem;">
                        <span style="font-size: 0.68rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #fbbf24;">Selected Role</span>
                        <span id="role-preview-badge" class="role-choice__badge role-choice__badge--instant">Instant Access</span>
                    </div>
                    <div id="role-preview-title" style="font-size: 0.9rem; font-weight: 700; color: #f1f5f9; display: flex; align-items: center; gap: 0.4rem;">
                        <i class="ti ti-user-check" style="color: #fbbf24;"></i> Witness Account
                    </div>
                    <div id="role-preview-text" style="font-size: 0.72rem; color: #94a3b8; margin-top: 0.25rem; line-height: 1.4;">
                        Upload digital recordings, photos, and incident testimony directly to the secure repository.
                    </div>
                </div>
            </div>

            <!-- Footer in Sidebar -->
            <div style="padding-top: 1rem; border-top: 1px solid rgba(71, 85, 105, 0.3); display: flex; align-items: center; justify-content: space-between;">
                <div style="font-size: 0.75rem; color: #64748b; display: flex; align-items: center; gap: 0.35rem;">
                    <i class="ti ti-lock" style="color: #10b981;"></i> 256-bit Encrypted
                </div>
                <a href="{{ route('login') }}" class="auth-link" style="font-size: 0.78rem;">
                    Existing account? Sign in &rarr;
                </a>
            </div>
        </aside>

        <!-- Main Registration Form -->
        <main class="auth-split__content">
            <div class="mb-5">
                <h2 style="font-size: 1.65rem; font-weight: 800; color: #f8fafc; letter-spacing: -0.02em; margin-bottom: 0.25rem;">
                    Create Account
                </h2>
                <p style="font-size: 0.85rem; color: #94a3b8;">
                    Enter your personal details and select your clearance role to initialize your vault access.
                </p>
            </div>

            @if ($errors->any())
                <div class="auth-alert auth-alert--error" style="margin-bottom: 1.25rem;">
                    <i class="ti ti-alert-circle" style="font-size: 1.1rem; flex-shrink: 0;"></i>
                    <div>
                        <div style="font-weight: 600;">Please review the highlighted errors:</div>
                        <ul style="margin-top: 0.25rem; padding-left: 1.25rem; font-size: 0.75rem; list-style-type: disc;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}" class="auth-form" id="register-form" style="gap: 1.25rem;">
                @csrf

                <!-- SECTION 1: Personal Details -->
                <div>
                    <div class="form-section-title">
                        <i class="ti ti-user-circle"></i>
                        <span>1. Personal & Contact Information</span>
                    </div>

                    <div class="form-grid-2" style="margin-top: 0.5rem;">
                        <!-- Full Name -->
                        <div class="auth-form__field">
                            <label for="name" class="auth-label">Full Name <span style="color: #ef4444;">*</span></label>
                            <div class="input-icon-wrapper">
                                <i class="ti ti-user input-icon"></i>
                                <input id="name" class="auth-input" type="text" name="name"
                                    value="{{ old('name') }}" required autofocus autocomplete="name"
                                    placeholder="e.g. Adv. John Doe">
                            </div>
                            @error('name')
                                <p class="auth-error"><i class="ti ti-alert-circle"></i> {{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Phone -->
                        <div class="auth-form__field">
                            <label for="phone" class="auth-label">
                                Contact Phone <span style="color: #64748b; font-weight: 400;">(Optional)</span>
                            </label>
                            <div class="input-icon-wrapper">
                                <i class="ti ti-phone input-icon"></i>
                                <input id="phone" class="auth-input" type="tel" name="phone"
                                    value="{{ old('phone') }}" autocomplete="tel"
                                    placeholder="+256 700 000 000">
                            </div>
                            @error('phone')
                                <p class="auth-error"><i class="ti ti-alert-circle"></i> {{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Email Address -->
                    <div class="auth-form__field" style="margin-top: 0.85rem;">
                        <label for="email" class="auth-label">Official Email Address <span style="color: #ef4444;">*</span></label>
                        <div class="input-icon-wrapper">
                            <i class="ti ti-mail input-icon"></i>
                            <input id="email" class="auth-input" type="email" name="email"
                                value="{{ old('email') }}" required autocomplete="username"
                                placeholder="name@organization.gov or personal email">
                        </div>
                        @error('email')
                            <p class="auth-error"><i class="ti ti-alert-circle"></i> {{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- SECTION 2: Role Selection Cards -->
                <div>
                    <div class="form-section-title">
                        <i class="ti ti-id-badge-2"></i>
                        <span>2. Role & Clearance Level</span>
                    </div>

                    <div class="role-grid" style="margin-top: 0.6rem;">
                        <!-- Role: Witness -->
                        <label class="role-choice">
                            <input type="radio" name="role_requested" value="Witness" class="role-radio-input"
                                {{ old('role_requested', 'Witness') == 'Witness' ? 'checked' : '' }}
                                data-title="Witness Account"
                                data-icon="ti-user-check"
                                data-badge="Instant Access"
                                data-badge-type="instant"
                                data-desc="Upload digital recordings, photos, and incident testimony directly to the secure repository.">
                            <div class="role-choice__card">
                                <div class="role-choice__head">
                                    <div class="role-choice__title">
                                        <i class="ti ti-user-check" style="font-size: 1.15rem; color: #fbbf24;"></i>
                                        <span>Witness</span>
                                    </div>
                                    <span class="role-choice__badge role-choice__badge--instant">Instant</span>
                                </div>
                                <div class="role-choice__desc">
                                    Submit citizen evidence, incident reports, and secure testimony.
                                </div>
                            </div>
                        </label>


                        <!-- Role: Lawyer -->
                        <label class="role-choice">
                            <input type="radio" name="role_requested" value="Lawyer" class="role-radio-input"
                                {{ old('role_requested') == 'Lawyer' ? 'checked' : '' }}
                                data-title="Legal Counsel / Lawyer"
                                data-icon="ti-scale"
                                data-badge="Bar Verification"
                                data-badge-type="review"
                                data-desc="Legal counsel representing parties; requires bar association or law firm credential confirmation by Admin.">
                            <div class="role-choice__card">
                                <div class="role-choice__head">
                                    <div class="role-choice__title">
                                        <i class="ti ti-scale" style="font-size: 1.15rem; color: #fbbf24;"></i>
                                        <span>Lawyer</span>
                                    </div>
                                    <span class="role-choice__badge role-choice__badge--review">Review Req.</span>
                                </div>
                                <div class="role-choice__desc">
                                    Legal advocates accessing case discovery and evidence briefs.
                                </div>
                            </div>
                        </label>

                        <!-- Role: Judge -->
                        <label class="role-choice">
                            <input type="radio" name="role_requested" value="Judge" class="role-radio-input"
                                {{ old('role_requested') == 'Judge' ? 'checked' : '' }}
                                data-title="Judicial Officer / Judge"
                                data-icon="ti-gavel"
                                data-badge="Judicial Review"
                                data-badge-type="review"
                                data-desc="Presiding magistrate or trial judge with evidentiary admissibility authority; verified by Admin before court access.">
                            <div class="role-choice__card">
                                <div class="role-choice__head">
                                    <div class="role-choice__title">
                                        <i class="ti ti-gavel" style="font-size: 1.15rem; color: #fbbf24;"></i>
                                        <span>Judge</span>
                                    </div>
                                    <span class="role-choice__badge role-choice__badge--review">Review Req.</span>
                                </div>
                                <div class="role-choice__desc">
                                    Judicial officers presiding over trials and ruling on exhibit admissibility.
                                </div>
                            </div>
                        </label>
                    </div>

                    <!-- Role Verification Notice (Shows when Judge or Lawyer is active) -->
                    <div id="role-review-notice" style="display: none; margin-top: 0.75rem; padding: 0.75rem 0.9rem; background: rgba(245, 158, 11, 0.1); border: 1px solid rgba(245, 158, 11, 0.25); border-radius: 10px; font-size: 0.75rem; color: #fde68a;">
                        <div style="display: flex; gap: 0.5rem; align-items: flex-start;">
                            <i class="ti ti-info-circle" style="font-size: 1.1rem; color: #fbbf24; flex-shrink: 0; margin-top: 0.05rem;"></i>
                            <div>
                                <span style="font-weight: 700;">Administrative Review Notice:</span>
                                Accounts requesting judicial or legal counsel roles are placed in pending status until credentials are confirmed by the system administrator.
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SECTION 3: Password & Security -->
                <div>
                    <div class="form-section-title">
                        <i class="ti ti-shield-lock"></i>
                        <span>3. Security Credentials</span>
                    </div>

                    <div class="form-grid-2" style="margin-top: 0.5rem;">
                        <!-- Password -->
                        <div class="auth-form__field">
                            <label for="password" class="auth-label">Create Password <span style="color: #ef4444;">*</span></label>
                            <div class="input-icon-wrapper password-wrapper">
                                <i class="ti ti-lock input-icon"></i>
                                <input id="password" class="auth-input" type="password" name="password"
                                    required autocomplete="new-password" placeholder="Min. 8 characters"
                                    style="padding-right: 3rem;">
                                <button type="button" class="password-toggle" onclick="togglePasswordVisibility('password', this)" title="Toggle password visibility">
                                    <i class="ti ti-eye"></i>
                                </button>
                            </div>
                            @error('password')
                                <p class="auth-error"><i class="ti ti-alert-circle"></i> {{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div class="auth-form__field">
                            <label for="password_confirmation" class="auth-label">Confirm Password <span style="color: #ef4444;">*</span></label>
                            <div class="input-icon-wrapper password-wrapper">
                                <i class="ti ti-lock-check input-icon"></i>
                                <input id="password_confirmation" class="auth-input" type="password"
                                    name="password_confirmation" required autocomplete="new-password"
                                    placeholder="Re-enter password" style="padding-right: 3rem;">
                                <button type="button" class="password-toggle" onclick="togglePasswordVisibility('password_confirmation', this)" title="Toggle password visibility">
                                    <i class="ti ti-eye"></i>
                                </button>
                            </div>
                            @error('password_confirmation')
                                <p class="auth-error"><i class="ti ti-alert-circle"></i> {{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Password Live Strength & Requirements -->
                    <div class="password-meter-wrap">
                        <div style="display: flex; justify-content: space-between; align-items: center; font-size: 0.72rem;">
                            <span style="color: #64748b;">Password Strength</span>
                            <span id="strength-label" style="font-weight: 700; color: #64748b;">Too short</span>
                        </div>
                        <div class="password-meter">
                            <div id="strength-bar" class="password-meter__bar"></div>
                        </div>

                        <div class="password-reqs">
                            <div id="req-len" class="pwd-req">
                                <i class="ti ti-circle-x"></i>
                                <span>At least 8 characters</span>
                            </div>
                            <div id="req-num" class="pwd-req">
                                <i class="ti ti-circle-x"></i>
                                <span>Includes a number or symbol</span>
                            </div>
                            <div id="req-match" class="pwd-req">
                                <i class="ti ti-circle-x"></i>
                                <span>Passwords match</span>
                            </div>
                            <div id="req-case" class="pwd-req">
                                <i class="ti ti-circle-x"></i>
                                <span>Uppercase & lowercase letters</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SECTION 4: Terms & Integrity Agreement -->
                <div style="margin-top: 0.25rem;">
                    <label class="auth-checkbox" style="align-items: flex-start; gap: 0.65rem;">
                        <input id="terms" type="checkbox" name="terms" required checked style="margin-top: 0.2rem;">
                        <span style="font-size: 0.775rem; color: #94a3b8; line-height: 1.45;">
                            I acknowledge that all digital materials submitted to <strong style="color: #e2e8f0;">eWitnessVault</strong> are cryptographically sealed, geotagged, and maintained under an immutable chain of custody.
                        </span>
                    </label>
                </div>

                <!-- Submit CTA -->
                <button type="submit" class="auth-button" style="margin-top: 0.5rem; display: flex; align-items: center; justify-content: center; gap: 0.5rem;">
                    <i class="ti ti-shield-check" style="font-size: 1.25rem;"></i>
                    <span>Create Secure Account</span>
                </button>
            </form>

            <div class="auth-footer" style="margin-top: 1.75rem;">
                Already registered with eWitnessVault?
                <a href="{{ route('login') }}" class="auth-link">Sign in to your vault</a>
            </div>
        </main>
    </div>

    <!-- Interactive Client Script -->
    <script>
        // Password Visibility Toggle
        function togglePasswordVisibility(inputId, btn) {
            const input = document.getElementById(inputId);
            const icon = btn.querySelector('i');
            if (input.type === 'password') {
                input.type = 'text';
                icon.className = 'ti ti-eye-off';
            } else {
                input.type = 'password';
                icon.className = 'ti ti-eye';
            }
        }

        // Live Role Selection & Sidebar sync
        const roleInputs = document.querySelectorAll('input[name="role_requested"]');
        const rolePreviewBox = document.getElementById('role-preview-box');
        const rolePreviewTitle = document.getElementById('role-preview-title');
        const rolePreviewText = document.getElementById('role-preview-text');
        const rolePreviewBadge = document.getElementById('role-preview-badge');
        const roleReviewNotice = document.getElementById('role-review-notice');

        function updateRoleSelection(radio) {
            if (!radio || !radio.checked) return;

            const title = radio.getAttribute('data-title');
            const icon = radio.getAttribute('data-icon');
            const desc = radio.getAttribute('data-desc');
            const badge = radio.getAttribute('data-badge');
            const badgeType = radio.getAttribute('data-badge-type');

            if (rolePreviewTitle) {
                rolePreviewTitle.innerHTML = `<i class="ti ${icon}" style="color: #fbbf24;"></i> ${title}`;
            }
            if (rolePreviewText) {
                rolePreviewText.textContent = desc;
            }
            if (rolePreviewBadge) {
                rolePreviewBadge.textContent = badge;
                rolePreviewBadge.className = `role-choice__badge role-choice__badge--${badgeType}`;
            }

            if (roleReviewNotice) {
                if (badgeType === 'review') {
                    roleReviewNotice.style.display = 'block';
                } else {
                    roleReviewNotice.style.display = 'none';
                }
            }
        }

        roleInputs.forEach(radio => {
            radio.addEventListener('change', () => updateRoleSelection(radio));
            if (radio.checked) {
                updateRoleSelection(radio);
            }
        });

        // Live Password Strength & Requirements Checker
        const pwdInput = document.getElementById('password');
        const confirmInput = document.getElementById('password_confirmation');
        const strengthBar = document.getElementById('strength-bar');
        const strengthLabel = document.getElementById('strength-label');

        const reqLen = document.getElementById('req-len');
        const reqNum = document.getElementById('req-num');
        const reqCase = document.getElementById('req-case');
        const reqMatch = document.getElementById('req-match');

        function setReqStatus(el, isValid) {
            const icon = el.querySelector('i');
            if (isValid) {
                el.classList.add('is-valid');
                icon.className = 'ti ti-circle-check';
            } else {
                el.classList.remove('is-valid');
                icon.className = 'ti ti-circle-x';
            }
        }

        function checkPasswordSecurity() {
            const pwd = pwdInput.value;
            const confirm = confirmInput.value;

            // 1. Length >= 8
            const hasLen = pwd.length >= 8;
            setReqStatus(reqLen, hasLen);

            // 2. Numbers or symbols
            const hasNum = /[0-9!@#$%^&*(),.?":{}|<>]/.test(pwd);
            setReqStatus(reqNum, hasNum);

            // 3. Mixed case
            const hasCase = /[a-z]/.test(pwd) && /[A-Z]/.test(pwd);
            setReqStatus(reqCase, hasCase);

            // 4. Passwords match
            const hasMatch = pwd.length > 0 && pwd === confirm;
            setReqStatus(reqMatch, hasMatch);

            // Calculate overall score (0 to 4)
            let score = 0;
            if (hasLen) score++;
            if (hasNum) score++;
            if (hasCase) score++;
            if (pwd.length >= 12) score++;

            if (pwd.length === 0) {
                strengthBar.style.width = '0%';
                strengthBar.style.background = 'transparent';
                strengthLabel.textContent = 'Too short';
                strengthLabel.style.color = '#64748b';
            } else if (score <= 1) {
                strengthBar.style.width = '25%';
                strengthBar.style.background = '#ef4444';
                strengthLabel.textContent = 'Weak';
                strengthLabel.style.color = '#f87171';
            } else if (score === 2) {
                strengthBar.style.width = '55%';
                strengthBar.style.background = '#f59e0b';
                strengthLabel.textContent = 'Moderate';
                strengthLabel.style.color = '#fbbf24';
            } else if (score === 3) {
                strengthBar.style.width = '80%';
                strengthBar.style.background = '#d97706';
                strengthLabel.textContent = 'Strong';
                strengthLabel.style.color = '#fbbf24';
            } else {
                strengthBar.style.width = '100%';
                strengthBar.style.background = '#10b981';
                strengthLabel.textContent = 'Excellent';
                strengthLabel.style.color = '#34d399';
            }
        }

        if (pwdInput && confirmInput) {
            pwdInput.addEventListener('input', checkPasswordSecurity);
            confirmInput.addEventListener('input', checkPasswordSecurity);
        }
    </script>
</x-guest-layout>
