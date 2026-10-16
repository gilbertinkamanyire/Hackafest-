<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, viewport-fit=cover">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- PWA / Mobile Theme -->
        <meta name="theme-color" content="#0f172a">
        <meta name="mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
        <meta name="apple-mobile-web-app-title" content="eWitnessVault">
        
        <link rel="manifest" href="{{ asset('manifest.json') }}">
        <link rel="apple-touch-icon" href="{{ asset('images/logo-192.png') }}">

        <!-- Favicon — matching nav header gold scales crest -->
        <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 64 64'%3E%3Cdefs%3E%3ClinearGradient id='b' x1='0%25' y1='0%25' x2='100%25' y2='100%25'%3E%3Cstop offset='0%25' stop-color='%23141a2e'/%3E%3Cstop offset='100%25' stop-color='%23050811'/%3E%3C/linearGradient%3E%3C/defs%3E%3Crect x='2' y='2' width='60' height='60' rx='14' fill='url(%23b)'/%3E%3Crect x='2' y='2' width='60' height='60' rx='14' fill='none' stroke='%23fbbf24' stroke-width='2.5'/%3E%3Cg transform='translate(10,10) scale(1.833)' stroke='%23fbbf24' stroke-width='2.2' stroke-linecap='round' stroke-linejoin='round' fill='none'%3E%3Cpath d='M7 20h10'/%3E%3Cpath d='M6 6l6-1 6 1'/%3E%3Cpath d='M12 5v15'/%3E%3Cpath d='M9 11l-3-6-3 6a3 3 0 0 0 6 0'/%3E%3Cpath d='M21 11l-3-6-3 6a3 3 0 0 0 6 0'/%3E%3C/g%3E%3C/svg%3E">
        <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
        <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
        <link rel="apple-touch-icon" href="{{ asset('favicon.png') }}">

        <title>{{ config('app.name', 'eWitnessVault') }}</title>

        <!-- Fonts: Cinzel & Outfit -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@600;700;800;900&family=Outfit:wght@300;400;500;600;700;900&display=swap" rel="stylesheet">

        <!-- Tabler Icons -->
        <link href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont/tabler-icons.min.css" rel="stylesheet">

        <!-- Capacitor Core JS (Safe detection) -->
        <script>
            window.isNative = false;
            // Native detection
            if (window.Capacitor && window.Capacitor.isNative) {
                window.isNative = true;
                document.documentElement.classList.add('native-app');
            }

            // Service Worker Registration
            if ('serviceWorker' in navigator) {
                window.addEventListener('load', () => {
                    navigator.serviceWorker.register("{{ asset('sw.js') }}").then(reg => {
                        console.log('SW (Guest) registered:', reg);
                    }).catch(err => {
                        console.log('SW (Guest) registration failed:', err);
                    });
                });
            }
        </script>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            * { margin: 0; padding: 0; box-sizing: border-box; }

            html, body { height: 100%; font-family: 'Outfit', sans-serif; }

            .auth-body {
                min-height: 100vh;
                overflow-y: auto;
                background-color: #060911;
                background-image: 
                    radial-gradient(circle at 50% 0%, rgba(245, 158, 11, 0.15) 0%, transparent 60%),
                    radial-gradient(circle at 10% 40%, rgba(180, 83, 9, 0.08) 0%, transparent 50%),
                    url("{{ asset('images/home-bg.png') }}");
                background-size: cover;
                background-position: center;
                background-attachment: fixed;
                position: relative;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 2.5rem 1rem;
            }

            .auth-body::before {
                content: '';
                position: absolute;
                inset: 0;
                background: linear-gradient(135deg, rgba(6, 9, 17, 0.94) 0%, rgba(12, 17, 29, 0.96) 100%);
                z-index: 0;
            }

            /* Animated background orbs */
            .auth-orb {
                position: absolute;
                border-radius: 50%;
                filter: blur(90px);
                opacity: 0.14;
                z-index: 0;
                animation: orbFloat 8s ease-in-out infinite;
            }
            .auth-orb-1 { width: 420px; height: 420px; background: #f59e0b; top: -100px; right: -100px; animation-delay: 0s; }
            .auth-orb-2 { width: 340px; height: 340px; background: #b45309; bottom: -80px; left: -80px; animation-delay: 3s; }

            @keyframes orbFloat {
                0%, 100% { transform: translateY(0px) scale(1); }
                50% { transform: translateY(-30px) scale(1.05); }
            }

            .auth-container {
                position: relative;
                z-index: 10;
                width: 100%;
                max-width: 440px;
                margin: auto;
                transition: max-width 0.3s ease;
            }

            .auth-container--wide {
                max-width: 980px;
            }

            /* Brand header above card */
            .auth-brand {
                text-align: center;
                margin-bottom: 1.5rem;
            }
            .auth-brand-icon {
                font-size: 3rem;
                background: linear-gradient(135deg, #f59e0b, #fbbf24);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                display: block;
                margin-bottom: 0.5rem;
                filter: drop-shadow(0 0 20px rgba(245, 158, 11, 0.5));
            }
            .auth-brand-name {
                font-family: 'Cinzel', serif;
                font-size: 1.6rem;
                font-weight: 800;
                background: linear-gradient(to right, #ffffff, #fbbf24);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                letter-spacing: 1px;
            }
            .auth-brand-tagline {
                font-size: 0.78rem;
                color: rgba(245, 158, 11, 0.85);
                margin-top: 0.25rem;
                letter-spacing: 0.1em;
                text-transform: uppercase;
                font-weight: 700;
            }

            /* Glassmorphism card */
            .auth-card {
                background: rgba(14, 20, 36, 0.85);
                backdrop-filter: blur(24px);
                -webkit-backdrop-filter: blur(24px);
                border: 1.5px solid rgba(245, 158, 11, 0.28);
                border-radius: 20px;
                padding: 2.25rem 2rem;
                box-shadow: 0 25px 60px rgba(0, 0, 0, 0.65), 0 0 0 1px rgba(245, 158, 11, 0.05) inset;
                width: 100%;
            }

            .auth-card--wide {
                padding: 0;
                overflow: hidden;
                border-radius: 24px;
            }

            /* Split Layout */
            .auth-split {
                display: grid;
                grid-template-columns: 360px 1fr;
                min-height: 640px;
            }

            .auth-split__sidebar {
                background: linear-gradient(170deg, rgba(245, 158, 11, 0.1) 0%, rgba(12, 17, 29, 0.98) 45%, rgba(180, 83, 9, 0.08) 100%);
                border-right: 1px solid rgba(245, 158, 11, 0.22);
                padding: 2.5rem 2rem;
                display: flex;
                flex-direction: column;
                justify-content: space-between;
                position: relative;
            }

            .auth-split__sidebar::before {
                content: '';
                position: absolute;
                top: 0; left: 0; right: 0; height: 3px;
                background: linear-gradient(90deg, #f59e0b, #fbbf24);
            }

            .auth-split__content {
                padding: 2.5rem 2.25rem;
                background: rgba(10, 15, 26, 0.7);
            }

            /* Section labels */
            .form-section-title {
                display: flex;
                align-items: center;
                gap: 0.5rem;
                font-size: 0.75rem;
                font-weight: 800;
                text-transform: uppercase;
                letter-spacing: 0.08em;
                color: #fbbf24;
                margin-top: 0.5rem;
                margin-bottom: 0.25rem;
            }
            .form-section-title::after {
                content: '';
                flex: 1;
                height: 1px;
                background: linear-gradient(90deg, rgba(245, 158, 11, 0.3), transparent);
            }

            /* Form Grid 2-col */
            .form-grid-2 {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 1rem;
            }

            /* Role Selector Cards */
            .role-grid {
                display: grid;
                grid-template-columns: repeat(2, 1fr);
                gap: 0.75rem;
            }

            .role-radio-input {
                position: absolute;
                opacity: 0;
                pointer-events: none;
            }

            .role-choice {
                display: block;
                cursor: pointer;
                user-select: none;
            }

            .role-choice__card {
                padding: 0.85rem 0.9rem;
                background: rgba(8, 12, 22, 0.75);
                border: 1.5px solid rgba(71, 85, 105, 0.45);
                border-radius: 12px;
                transition: all 0.22s ease;
                display: flex;
                flex-direction: column;
                gap: 0.35rem;
                height: 100%;
                position: relative;
            }

            .role-choice:hover .role-choice__card {
                background: rgba(16, 24, 40, 0.9);
                border-color: rgba(245, 158, 11, 0.5);
                transform: translateY(-1px);
            }

            .role-radio-input:checked + .role-choice__card {
                background: rgba(245, 158, 11, 0.12);
                border-color: #fbbf24;
                box-shadow: 0 0 20px rgba(245, 158, 11, 0.25), inset 0 0 10px rgba(245, 158, 11, 0.05);
            }

            .role-choice__head {
                display: flex;
                align-items: center;
                justify-content: space-between;
            }

            .role-choice__badge {
                font-size: 0.65rem;
                font-weight: 700;
                padding: 0.15rem 0.45rem;
                border-radius: 20px;
                letter-spacing: 0.03em;
                text-transform: uppercase;
            }

            .role-choice__badge--instant {
                background: rgba(16, 185, 129, 0.15);
                color: #34d399;
                border: 1px solid rgba(16, 185, 129, 0.3);
            }

            .role-choice__badge--review {
                background: rgba(245, 158, 11, 0.15);
                color: #fbbf24;
                border: 1px solid rgba(245, 158, 11, 0.3);
            }

            .role-choice__title {
                display: flex;
                align-items: center;
                gap: 0.45rem;
                font-size: 0.875rem;
                font-weight: 700;
                color: #f1f5f9;
            }

            .role-radio-input:checked + .role-choice__card .role-choice__title {
                color: #fbbf24;
            }

            .role-choice__desc {
                font-size: 0.72rem;
                line-height: 1.35;
                color: #94a3b8;
            }

            /* Password Live Checklist & Meter */
            .password-meter-wrap {
                display: flex;
                flex-direction: column;
                gap: 0.4rem;
                margin-top: 0.25rem;
            }

            .password-meter {
                height: 4px;
                background: rgba(71, 85, 105, 0.4);
                border-radius: 4px;
                overflow: hidden;
                display: flex;
            }

            .password-meter__bar {
                height: 100%;
                width: 0%;
                transition: width 0.3s ease, background 0.3s ease;
                border-radius: 4px;
            }

            .password-reqs {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 0.3rem 0.75rem;
                margin-top: 0.2rem;
            }

            .pwd-req {
                font-size: 0.72rem;
                color: #64748b;
                display: flex;
                align-items: center;
                gap: 0.3rem;
                transition: color 0.2s ease;
            }

            .pwd-req.is-valid {
                color: #34d399;
            }
            .pwd-req.is-valid i {
                color: #10b981;
            }

            /* Responsive rules */
            @media (max-width: 860px) {
                .auth-split {
                    grid-template-columns: 1fr;
                }
                .auth-split__sidebar {
                    padding: 1.75rem 1.5rem;
                    border-right: none;
                    border-bottom: 1px solid rgba(245, 158, 11, 0.2);
                }
                .auth-split__content {
                    padding: 1.75rem 1.5rem;
                }
                .form-grid-2 {
                    grid-template-columns: 1fr;
                }
            }

            @media (max-width: 520px) {
                .role-grid {
                    grid-template-columns: 1fr;
                }
                .password-reqs {
                    grid-template-columns: 1fr;
                }
            }

            .auth-card__header {
                text-align: center;
                margin-bottom: 1.75rem;
            }

            .auth-card__title {
                font-family: 'Cinzel', serif;
                font-size: 1.85rem;
                font-weight: 800;
                color: #f1f5f9;
                margin-bottom: 0.35rem;
            }

            .auth-card__subtitle {
                font-size: 0.875rem;
                color: #94a3b8;
            }

            /* Form */
            .auth-form {
                display: flex;
                flex-direction: column;
                gap: 1.1rem;
            }

            .auth-form__field {
                display: flex;
                flex-direction: column;
                gap: 0.4rem;
            }

            .auth-label {
                font-size: 0.8125rem;
                font-weight: 700;
                color: #cbd5e1;
                letter-spacing: 0.3px;
            }

            /* Input with icon */
            .input-icon-wrapper {
                position: relative;
                display: flex;
                align-items: center;
            }
            .input-icon {
                position: absolute;
                left: 0.875rem;
                color: #64748b;
                font-size: 1rem;
                pointer-events: none;
                z-index: 1;
                transition: color 0.2s;
            }
            .auth-input {
                width: 100%;
                padding: 0.75rem 0.875rem 0.75rem 2.5rem;
                background: rgba(8, 12, 22, 0.85);
                border: 1.5px solid rgba(71, 85, 105, 0.45);
                border-radius: 10px;
                font-size: 0.875rem;
                font-family: 'Outfit', sans-serif;
                color: #f1f5f9;
                transition: all 0.25s;
            }
            .auth-input::placeholder { color: #64748b; }
            .auth-input:focus {
                outline: none;
                border-color: #fbbf24;
                background: rgba(8, 12, 22, 0.95);
                box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.18);
            }
            .auth-input:focus + .input-icon,
            .input-icon-wrapper:focus-within .input-icon {
                color: #fbbf24;
            }

            /* Select */
            .auth-input option {
                background: #0f172a;
                color: #e2e8f0;
            }

            /* Password wrapper */
            .password-wrapper {
                position: relative;
                width: 100%;
            }
            .password-toggle {
                position: absolute;
                right: 0.75rem;
                top: 50%;
                transform: translateY(-50%);
                background: none;
                border: none;
                color: #64748b;
                font-size: 1.1rem;
                cursor: pointer;
                padding: 0.25rem;
                transition: color 0.2s;
                display: flex;
                align-items: center;
                justify-content: center;
                z-index: 2;
            }
            .password-toggle:hover { color: #fbbf24; }

            /* Button */
            .auth-button {
                width: 100%;
                padding: 0.85rem 1.25rem;
                background: linear-gradient(135deg, #f59e0b 0%, #fbbf24 60%, #b45309 100%);
                color: #070a12;
                font-weight: 800;
                font-size: 0.95rem;
                font-family: 'Outfit', sans-serif;
                border: 1.5px solid #fbbf24;
                border-radius: 10px;
                cursor: pointer;
                transition: all 0.25s;
                margin-top: 0.35rem;
                letter-spacing: 0.5px;
                box-shadow: 0 4px 20px rgba(245, 158, 11, 0.35);
                position: relative;
                overflow: hidden;
            }
            .auth-button:hover {
                background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
                transform: translateY(-2px);
                box-shadow: 0 8px 30px rgba(245, 158, 11, 0.55);
            }
            .auth-button:active { transform: translateY(0); }
            .auth-button::before {
                content: '';
                position: absolute;
                top: 0; left: -100%;
                width: 100%; height: 100%;
                background: linear-gradient(90deg, transparent, rgba(255,255,255,0.15), transparent);
                transition: left 0.5s;
            }
            .auth-button:hover::before { left: 100%; }
            .auth-button:hover {
                background: linear-gradient(135deg, #0891b2 0%, #0e7490 100%);
                transform: translateY(-2px);
                box-shadow: 0 8px 30px rgba(6, 182, 212, 0.5);
            }
            .auth-button:active { transform: translateY(0); }

            /* Meta row */
            .auth-meta {
                display: flex;
                justify-content: space-between;
                align-items: center;
                font-size: 0.8125rem;
            }
            .auth-checkbox {
                display: flex;
                align-items: center;
                gap: 0.5rem;
                color: #64748b;
                cursor: pointer;
            }
            .auth-checkbox input[type="checkbox"] {
                width: 15px; height: 15px;
                accent-color: #f59e0b;
                cursor: pointer;
            }

            /* Links */
            .auth-link {
                color: #fbbf24;
                text-decoration: none;
                font-weight: 700;
                transition: color 0.2s;
            }
            .auth-link:hover { color: #f59e0b; text-decoration: underline; }

            /* Footer */
            .auth-footer {
                text-align: center;
                margin-top: 1.5rem;
                font-size: 0.875rem;
                color: #475569;
            }

            /* Alerts */
            .auth-alert {
                padding: 0.7rem 1rem;
                border-radius: 10px;
                font-size: 0.8125rem;
                margin-bottom: 1rem;
                display: flex;
                align-items: center;
                gap: 0.5rem;
            }
            .auth-alert--success {
                background: rgba(16, 185, 129, 0.1);
                color: #6ee7b7;
                border: 1px solid rgba(16, 185, 129, 0.3);
            }
            .auth-alert--error {
                background: rgba(239, 68, 68, 0.1);
                color: #fca5a5;
                border: 1px solid rgba(239, 68, 68, 0.3);
            }
            .auth-error {
                color: #f87171;
                font-size: 0.75rem;
                margin-top: 0.2rem;
                display: flex;
                align-items: center;
                gap: 0.25rem;
            }

            /* Divider */
            .auth-divider {
                height: 1px;
                background: rgba(71, 85, 105, 0.3);
                margin: 0.5rem 0;
            }

            @media (max-width: 480px) {
                .auth-card { padding: 1.75rem 1.25rem; border-radius: 16px; }
                .auth-brand-icon { font-size: 2.5rem; }
                .auth-brand-name { font-size: 1.25rem; }
            }
        </style>
    </head>
    <body class="auth-body">
        <div class="auth-orb auth-orb-1"></div>
        <div class="auth-orb auth-orb-2"></div>

        <div class="auth-container {{ !empty($wide) ? 'auth-container--wide' : '' }}" @if(!empty($maxWidth)) style="max-width: {{ $maxWidth }};" @endif>
            <!-- Brand Header -->
            @if(empty($wide))
            <div class="auth-brand">
                <i class="ti ti-shield-check-filled auth-brand-icon"></i>
                <div class="auth-brand-name">eWitnessVault</div>
                <div class="auth-brand-tagline">Secure Digital Evidence Platform</div>
            </div>
            @endif

            <!-- Auth Card -->
            <div class="auth-card {{ !empty($wide) ? 'auth-card--wide' : '' }}">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
