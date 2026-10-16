<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
        <title>About | eWitnessVault &mdash; Judicial Evidence Platform</title>
        <meta name="description" content="Learn about eWitnessVault — the premier judicial digital evidence repository with immutable chain of custody.">

        <!-- PWA Support -->
        <link rel="manifest" href="/manifest.json">
        <meta name="theme-color" content="#060911">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
        <link rel="apple-touch-icon" href="/images/logo-192.png">

        <!-- Favicon — matching nav header gold scales crest -->
        <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 64 64'%3E%3Cdefs%3E%3ClinearGradient id='b' x1='0%25' y1='0%25' x2='100%25' y2='100%25'%3E%3Cstop offset='0%25' stop-color='%23141a2e'/%3E%3Cstop offset='100%25' stop-color='%23050811'/%3E%3C/linearGradient%3E%3C/defs%3E%3Crect x='2' y='2' width='60' height='60' rx='14' fill='url(%23b)'/%3E%3Crect x='2' y='2' width='60' height='60' rx='14' fill='none' stroke='%23fbbf24' stroke-width='2.5'/%3E%3Cg transform='translate(10,10) scale(1.833)' stroke='%23fbbf24' stroke-width='2.2' stroke-linecap='round' stroke-linejoin='round' fill='none'%3E%3Cpath d='M7 20h10'/%3E%3Cpath d='M6 6l6-1 6 1'/%3E%3Cpath d='M12 5v15'/%3E%3Cpath d='M9 11l-3-6-3 6a3 3 0 0 0 6 0'/%3E%3Cpath d='M21 11l-3-6-3 6a3 3 0 0 0 6 0'/%3E%3C/g%3E%3C/svg%3E">
        <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
        <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
        <link rel="apple-touch-icon" href="{{ asset('favicon.png') }}">

        <!-- Fonts: Cinzel, Outfit, JetBrains Mono -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@600;700;800;900&family=Outfit:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">

        <!-- Tabler Icons -->
        <link href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont/tabler-icons.min.css" rel="stylesheet">

        <style>
            *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

            body {
                min-height: 100vh;
                font-family: 'Outfit', sans-serif;
                color: #f8fafc;
                background-color: #060911;
                background-image: 
                    radial-gradient(circle at 50% 0%, rgba(245, 158, 11, 0.12) 0%, transparent 60%),
                    radial-gradient(circle at 10% 40%, rgba(180, 83, 9, 0.08) 0%, transparent 50%),
                    url("{{ asset('images/home-bg.png') }}");
                background-size: cover;
                background-position: center;
                background-attachment: fixed;
                display: flex;
                flex-direction: column;
                position: relative;
            }
            body::before {
                content: '';
                position: absolute;
                inset: 0;
                background: linear-gradient(180deg, rgba(6, 9, 17, 0.94) 0%, rgba(12, 17, 29, 0.96) 100%);
                z-index: 0;
            }

            /* Sticky Judicial Navigation */
            .top-nav {
                position: sticky;
                top: 0;
                z-index: 100;
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 1rem 2.5rem;
                background: rgba(8, 11, 20, 0.96);
                backdrop-filter: blur(24px);
                border-bottom: 1px solid rgba(245, 158, 11, 0.22);
                box-shadow: 0 4px 30px rgba(0, 0, 0, 0.5);
            }
            .top-nav-brand {
                display: flex; align-items: center; gap: 0.75rem; text-decoration: none;
            }
            .top-nav-brand-icon {
                width: 38px; height: 38px; border-radius: 10px;
                background: linear-gradient(135deg, rgba(245, 158, 11, 0.25), rgba(180, 83, 9, 0.15));
                border: 1px solid #fbbf24; display: flex; align-items: center; justify-content: center;
                color: #fbbf24; font-size: 1.35rem; box-shadow: 0 0 15px rgba(245, 158, 11, 0.3);
            }
            .top-nav-brand-text {
                font-family: 'Cinzel', serif; font-size: 1.25rem; font-weight: 800;
                background: linear-gradient(to right, #ffffff, #fbbf24);
                -webkit-background-clip: text; -webkit-text-fill-color: transparent;
                letter-spacing: 0.5px;
            }
            .top-nav-links { display: flex; gap: 0.85rem; align-items: center; }
            .nav-btn {
                padding: 0.5rem 1.15rem; border-radius: 10px; font-size: 0.875rem;
                font-weight: 600; text-decoration: none; transition: all 0.2s;
                font-family: 'Outfit', sans-serif;
            }
            .nav-btn-ghost { color: #cbd5e1; border: 1px solid rgba(148, 163, 184, 0.25); background: rgba(30, 41, 59, 0.4); }
            .nav-btn-ghost:hover { color: #fbbf24; border-color: rgba(245, 158, 11, 0.4); background: rgba(245, 158, 11, 0.1); }
            .nav-btn-primary {
                color: #000; background: linear-gradient(135deg, #f59e0b, #d97706);
                border: 1px solid #fbbf24; box-shadow: 0 0 20px rgba(245, 158, 11, 0.35); font-weight: 700;
            }
            .nav-btn-primary:hover { transform: translateY(-1px); box-shadow: 0 0 30px rgba(245, 158, 11, 0.55); }

            /* Content */
            .content-wrapper {
                position: relative; z-index: 10; flex: 1;
                padding-bottom: 5rem; width: 100%; max-width: 1200px;
                margin: 0 auto; display: flex; flex-direction: column;
            }

            /* Page Header */
            .page-header {
                text-align: center; padding: 5rem 2rem 3rem;
            }
            .badge-hero {
                display: inline-flex; align-items: center; gap: 0.45rem;
                padding: 0.35rem 0.95rem; border-radius: 50px;
                background: rgba(245, 158, 11, 0.12); border: 1px solid rgba(245, 158, 11, 0.35);
                color: #fbbf24; font-size: 0.78rem; font-weight: 700;
                text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 1.25rem;
            }
            .page-title {
                font-family: 'Cinzel', serif; font-size: 3.5rem; font-weight: 900; margin-bottom: 1.25rem;
                background: linear-gradient(135deg, #ffffff 40%, #fbbf24 100%);
                -webkit-background-clip: text; -webkit-text-fill-color: transparent;
                letter-spacing: -0.02em; line-height: 1.15;
            }
            .page-subtitle {
                font-size: 1.2rem; color: #94a3b8; font-weight: 300; max-width: 720px;
                margin: 0 auto; line-height: 1.6;
            }

            /* Sections */
            .section { margin-bottom: 5.5rem; padding: 0 2rem; }
            .section-title {
                font-family: 'Cinzel', serif; font-size: 2.25rem; font-weight: 800; text-align: center;
                margin-bottom: 0.65rem; color: #f8fafc; letter-spacing: 0.5px;
            }
            .section-subtitle {
                text-align: center; color: #94a3b8; font-size: 1rem;
                margin-bottom: 3rem; max-width: 650px; margin-left: auto; margin-right: auto;
            }

            /* Stats */
            .stats-grid {
                display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
                gap: 1.5rem; margin-bottom: 3rem;
            }
            .stat-card {
                text-align: center; padding: 2.25rem 1.5rem;
                background: rgba(12, 17, 29, 0.85); backdrop-filter: blur(16px);
                border: 1.5px solid rgba(245, 158, 11, 0.25);
                border-radius: 18px; transition: all 0.3s;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4);
            }
            .stat-card:hover {
                transform: translateY(-5px);
                border-color: rgba(245, 158, 11, 0.5);
                box-shadow: 0 15px 40px rgba(245, 158, 11, 0.2);
            }
            .stat-icon { font-size: 2.25rem; color: #fbbf24; margin-bottom: 0.85rem; display: block; }
            .stat-number {
                font-family: 'JetBrains Mono', monospace;
                font-size: 2.85rem; font-weight: 900; display: block; margin-bottom: 0.35rem;
                background: linear-gradient(135deg, #ffffff, #fbbf24);
                -webkit-background-clip: text; -webkit-text-fill-color: transparent;
            }
            .stat-label { color: #94a3b8; font-size: 0.875rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; }

            /* Feature Cards */
            .grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 1.5rem; }
            .card {
                background: rgba(12, 17, 29, 0.85); backdrop-filter: blur(16px);
                border: 1.5px solid rgba(71, 85, 105, 0.3);
                border-radius: 18px; padding: 2.25rem 2rem; transition: all 0.3s;
                position: relative; overflow: hidden;
            }
            .card:hover {
                transform: translateY(-5px); background: rgba(16, 24, 40, 0.95);
                border-color: rgba(245, 158, 11, 0.45);
                box-shadow: 0 20px 45px rgba(0, 0, 0, 0.5), 0 0 25px rgba(245, 158, 11, 0.12);
            }
            .card-icon {
                font-size: 1.85rem; margin-bottom: 1.25rem; display: inline-flex;
                align-items: center; justify-content: center;
                width: 54px; height: 54px; border-radius: 14px;
                background: rgba(245, 158, 11, 0.12); border: 1px solid rgba(245, 158, 11, 0.3);
                color: #fbbf24;
            }
            .card h3 {
                font-family: 'Cinzel', serif; font-size: 1.2rem; font-weight: 800;
                color: #f8fafc; margin-bottom: 0.65rem;
            }
            .card p { color: #94a3b8; line-height: 1.65; font-size: 0.92rem; }

            /* Mission */
            .mission-section {
                text-align: center;
                background: linear-gradient(145deg, rgba(245, 158, 11, 0.12) 0%, rgba(12, 17, 29, 0.95) 60%, rgba(180, 83, 9, 0.1) 100%);
                border-radius: 24px; padding: 4rem 3rem;
                border: 1.5px solid rgba(245, 158, 11, 0.35); margin-bottom: 3.5rem;
                box-shadow: 0 25px 60px rgba(0, 0, 0, 0.6), 0 0 35px rgba(245, 158, 11, 0.12);
            }
            .mission-section h2 {
                font-family: 'Cinzel', serif; font-size: 2.25rem; margin-bottom: 1.5rem; color: #ffffff;
            }
            .mission-icon {
                font-size: 3.5rem; color: #fbbf24; margin-bottom: 1.25rem; display: block;
                filter: drop-shadow(0 0 20px rgba(245, 158, 11, 0.4));
            }
            .mission-text {
                font-size: 1.2rem; line-height: 1.85; max-width: 820px; margin: 0 auto;
                color: #cbd5e1; font-weight: 300; font-style: italic;
            }

            /* Timeline */
            .timeline { position: relative; padding: 2rem 0; }
            .timeline::before {
                content: ''; position: absolute; left: 50%; top: 0; bottom: 0;
                width: 2px; background: linear-gradient(to bottom, #f59e0b, rgba(245, 158, 11, 0.1));
                transform: translateX(-50%);
            }
            .timeline-item {
                display: flex; justify-content: space-between; align-items: center;
                margin-bottom: 3.5rem; position: relative;
            }
            .timeline-item:nth-child(even) { flex-direction: row-reverse; }
            .timeline-content {
                width: 45%; background: rgba(12, 17, 29, 0.85); backdrop-filter: blur(12px);
                padding: 1.75rem 2rem; border-radius: 16px; border: 1.5px solid rgba(245, 158, 11, 0.22);
                transition: all 0.3s;
            }
            .timeline-content:hover {
                transform: translateY(-4px); border-color: rgba(245, 158, 11, 0.45);
                box-shadow: 0 15px 35px rgba(0, 0, 0, 0.5), 0 0 20px rgba(245, 158, 11, 0.15);
            }
            .timeline-date {
                font-family: 'JetBrains Mono', monospace; font-size: 1.15rem;
                font-weight: 800; color: #fbbf24; margin-bottom: 0.35rem;
            }
            .timeline-title {
                font-family: 'Cinzel', serif; font-size: 1.15rem; font-weight: 700;
                color: #f8fafc; margin-bottom: 0.5rem;
            }
            .timeline-text { color: #94a3b8; line-height: 1.6; font-size: 0.9rem; }
            .timeline-dot {
                width: 20px; height: 20px;
                background: linear-gradient(135deg, #f59e0b, #fbbf24);
                border: 2px solid #060911; border-radius: 50%;
                position: absolute; left: 50%; transform: translateX(-50%);
                box-shadow: 0 0 25px rgba(245, 158, 11, 0.8);
            }

            /* FAQ */
            .faq-container { max-width: 880px; margin: 0 auto; }
            .faq-item {
                background: rgba(12, 17, 29, 0.8); border: 1.5px solid rgba(71, 85, 105, 0.3);
                border-radius: 14px; margin-bottom: 0.85rem; overflow: hidden; transition: all 0.25s;
            }
            .faq-item:hover { border-color: rgba(245, 158, 11, 0.35); }
            .faq-question {
                padding: 1.35rem 1.75rem; cursor: pointer; display: flex;
                justify-content: space-between; align-items: center;
                font-weight: 700; color: #e2e8f0; transition: all 0.2s; font-size: 1rem;
            }
            .faq-question:hover { color: #fbbf24; }
            .faq-icon { font-size: 1.25rem; color: #fbbf24; transition: transform 0.3s; flex-shrink: 0; }
            .faq-item.active .faq-icon { transform: rotate(45deg); }
            .faq-answer { max-height: 0; overflow: hidden; transition: max-height 0.35s ease; padding: 0 1.75rem; }
            .faq-item.active .faq-answer { max-height: 350px; padding: 0 1.75rem 1.35rem; }
            .faq-answer-text { color: #94a3b8; line-height: 1.8; font-size: 0.92rem; }

            /* Contact */
            .contact-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 1.5rem; }
            .contact-card {
                text-align: center; padding: 2.25rem 1.5rem;
                background: rgba(12, 17, 29, 0.8); border: 1.5px solid rgba(71, 85, 105, 0.3);
                border-radius: 18px; transition: all 0.3s;
            }
            .contact-card:hover {
                transform: translateY(-5px); border-color: rgba(245, 158, 11, 0.4);
                box-shadow: 0 15px 35px rgba(0, 0, 0, 0.5), 0 0 20px rgba(245, 158, 11, 0.12);
            }
            .contact-icon { font-size: 2.25rem; color: #fbbf24; margin-bottom: 0.85rem; display: block; }
            .contact-title { font-family: 'Cinzel', serif; font-size: 1.1rem; font-weight: 700; color: #f8fafc; margin-bottom: 0.4rem; }
            .contact-info { color: #94a3b8; font-size: 0.9rem; }
            .contact-link { color: #fbbf24; text-decoration: none; transition: color 0.2s; font-weight: 600; }
            .contact-link:hover { color: #f59e0b; text-decoration: underline; }

            /* CTA Actions */
            .nav-actions { text-align: center; display: flex; gap: 1.25rem; justify-content: center; flex-wrap: wrap; padding: 1rem 2rem 2rem; }
            .btn {
                display: inline-flex; align-items: center; gap: 0.5rem;
                text-decoration: none; font-weight: 800; transition: all 0.3s;
                padding: 0.95rem 2.25rem; border-radius: 50px; font-size: 0.95rem;
                position: relative; overflow: hidden; font-family: 'Outfit', sans-serif;
            }
            .btn-primary {
                background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
                color: #000; border: 1px solid #fbbf24; box-shadow: 0 0 25px rgba(245, 158, 11, 0.35);
            }
            .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 0 45px rgba(245, 158, 11, 0.6); }
            .btn-back { color: #cbd5e1; border: 1px solid rgba(148, 163, 184, 0.3); background: rgba(30, 41, 59, 0.4); }
            .btn-back:hover { color: #fbbf24; border-color: rgba(245, 158, 11, 0.4); background: rgba(245, 158, 11, 0.1); transform: translateY(-2px); }

            /* Footer */
            footer {
                position: relative; z-index: 10; padding: 2rem 2.5rem;
                background: rgba(8, 11, 20, 0.85); backdrop-filter: blur(12px);
                border-top: 1px solid rgba(245, 158, 11, 0.18); margin-top: 2rem;
            }
            .footer-inner { max-width: 1200px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem; }
            .footer-text { font-size: 0.875rem; color: #64748b; }
            .footer-brand { font-weight: 700; color: #fbbf24; }

            @media (max-width: 768px) {
                .page-title { font-size: 2.4rem; }
                .top-nav { padding: 0.875rem 1rem; }
                .section { padding: 0 1rem; }
                .section-title { font-size: 1.75rem; }
                .grid { grid-template-columns: 1fr; }
                .timeline::before { left: 20px; }
                .timeline-item { flex-direction: column !important; align-items: flex-start; padding-left: 50px; }
                .timeline-content { width: 100%; }
                .timeline-dot { left: 20px; }
                .nav-actions { flex-direction: column; align-items: center; }
                .btn { width: 100%; max-width: 300px; justify-content: center; }
            }
        </style>
    </head>
    <body class="antialiased">
        <!-- Sticky Judicial Navigation -->
        <nav class="top-nav">
            <a href="{{ url('/') }}" class="top-nav-brand">
                <div class="top-nav-brand-icon">
                    <i class="ti ti-scale"></i>
                </div>
                <div class="top-nav-brand-text">
                    eWitnessVault
                </div>
            </a>
            <div class="top-nav-links">
                <a href="{{ url('/') }}" class="nav-btn nav-btn-ghost">
                    <i class="ti ti-home" style="margin-right: 0.3rem;"></i>Home
                </a>
                <a href="{{ route('login') }}" class="nav-btn nav-btn-ghost">Sign In</a>
                <a href="{{ route('register') }}" class="nav-btn nav-btn-primary">Access Vault</a>
            </div>
        </nav>

        <div class="content-wrapper">
            <!-- Page Header -->
            <div class="page-header">
                <div class="badge-hero">
                    <i class="ti ti-certificate"></i> Judicial Integrity Standard
                </div>
                <h1 class="page-title">Pioneering Digital Evidence Integrity</h1>
                <p class="page-subtitle">
                    eWitnessVault establishes a cryptographically sealed chain of custody engineered for trial discovery, evidentiary preservation, and immutable judicial proceedings.
                </p>
            </div>

            <!-- Stats Section -->
            <section class="section">
                <h2 class="section-title">Institutional Performance</h2>
                <p class="section-subtitle">Trusted by magistrates, legal practitioners, and sworn witnesses</p>
                <div class="stats-grid">
                    <div class="stat-card">
                        <i class="ti ti-users stat-icon"></i>
                        <span class="stat-number">10K+</span>
                        <span class="stat-label">Authorized Officers</span>
                    </div>
                    <div class="stat-card">
                        <i class="ti ti-files stat-icon"></i>
                        <span class="stat-number">50K+</span>
                        <span class="stat-label">Sealed Exhibits</span>
                    </div>
                    <div class="stat-card">
                        <i class="ti ti-server-2 stat-icon"></i>
                        <span class="stat-number">99.9%</span>
                        <span class="stat-label">Registry Uptime</span>
                    </div>
                    <div class="stat-card">
                        <i class="ti ti-shield-lock stat-icon"></i>
                        <span class="stat-number">100%</span>
                        <span class="stat-label">SHA-256 Verified</span>
                    </div>
                </div>
            </section>

            <!-- Core Features -->
            <section class="section">
                <h2 class="section-title">Cryptographic Architecture</h2>
                <p class="section-subtitle">Defense-grade integrity protocols for legal proceedings</p>
                <div class="grid">
                    <div class="card">
                        <div class="card-icon"><i class="ti ti-binary"></i></div>
                        <h3>SHA-256 Sealing</h3>
                        <p>Every file is hashed instantaneously upon upload. The cryptographic digest is permanently inscribed into the database to mathematically detect any post-incident bit alterations.</p>
                    </div>
                    <div class="card">
                        <div class="card-icon"><i class="ti ti-link"></i></div>
                        <h3>Chain of Custody</h3>
                        <p>Every administrative inspection, docket verification, and forensic viewing event is cryptographically logged with UTC timestamps and user credentials for trial admissibility.</p>
                    </div>
                    <div class="card">
                        <div class="card-icon"><i class="ti ti-map-pin-check"></i></div>
                        <h3>Forensic Telemetry</h3>
                        <p>Hardware satellite GPS coordinates, altitude, radial accuracy, and device telemetry are paired with exhibits to corroborate scene provenance and physical presence.</p>
                    </div>
                    <div class="card">
                        <div class="card-icon"><i class="ti ti-key"></i></div>
                        <h3>Role-Guarded Clearance</h3>
                        <p>Granular access privileges enforce strict boundaries between Citizen Witnesses, Bar-verified Lawyers, Presiding Judicial Officers, and Vault Administrators.</p>
                    </div>
                    <div class="card">
                        <div class="card-icon"><i class="ti ti-scale"></i></div>
                        <h3>Section 106 Compliance</h3>
                        <p>Standardized exhibit dockets and metadata logs structured specifically to fulfill statutory guidelines for digital forensic discovery in high courts of law.</p>
                    </div>
                    <div class="card">
                        <div class="card-icon"><i class="ti ti-database-check"></i></div>
                        <h3>Relational SQL Storage</h3>
                        <p>Backed exclusively by high-reliability MySQL relational storage with structured foreign key integrity, ensuring zero database corruption and atomic transactions.</p>
                    </div>
                </div>
            </section>

            <!-- Mission -->
            <section class="section">
                <div class="mission-section">
                    <i class="ti ti-scale mission-icon"></i>
                    <h2>Our Judicial Mandate</h2>
                    <p class="mission-text">
                        &ldquo;To preserve the unimpeachable truth of digital records. The integrity of physical and digital exhibits is the cornerstone of justice. Our architecture guarantees that authentic evidence survives from the street to the courtroom docket without suspicion of spoliation.&rdquo;
                    </p>
                </div>
            </section>

            <!-- Timeline -->
            <section class="section">
                <h2 class="section-title">Evolution of the Vault</h2>
                <p class="section-subtitle">Continuous innovation in evidentiary preservation</p>
                <div class="timeline">
                    <div class="timeline-item">
                        <div class="timeline-content">
                            <div class="timeline-date">Phase III &bull; 2026</div>
                            <div class="timeline-title">Judicial Modernization</div>
                            <div class="timeline-text">Full enterprise rollout featuring automated WebCrypto digest generation, courtroom exhibits docket, and role clearance verification.</div>
                        </div>
                        <div class="timeline-dot"></div>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-content">
                            <div class="timeline-date">Phase II &bull; 2024</div>
                            <div class="timeline-title">Forensic Field Testing</div>
                            <div class="timeline-text">Operational field deployment with law enforcement agencies and legal advocates validating geotagging and custody ledgers.</div>
                        </div>
                        <div class="timeline-dot"></div>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-content">
                            <div class="timeline-date">Phase I &bull; 2023</div>
                            <div class="timeline-title">Cryptographic Blueprint</div>
                            <div class="timeline-text">Architectural formulation of the zero-trust custody engine to eliminate forensic evidence tampering and trial contestation.</div>
                        </div>
                        <div class="timeline-dot"></div>
                    </div>
                </div>
            </section>

            <!-- FAQ -->
            <section class="section">
                <h2 class="section-title">Frequently Asked Questions</h2>
                <p class="section-subtitle">Evidentiary standards, admissibility, and custody mechanics</p>
                <div class="faq-container">
                    <div class="faq-item">
                        <div class="faq-question" onclick="toggleFAQ(this)">
                            <span>How does eWitnessVault guarantee that files cannot be tampered with?</span>
                            <i class="ti ti-plus faq-icon"></i>
                        </div>
                        <div class="faq-answer">
                            <p class="faq-answer-text">Each uploaded file undergoes client-side and server-side SHA-256 cryptographic hashing. The resulting unique 256-bit hexadecimal string is immutable. Even a single changed byte in the file yields an entirely different hash, immediately exposing any alteration attempt.</p>
                        </div>
                    </div>
                    <div class="faq-item">
                        <div class="faq-question" onclick="toggleFAQ(this)">
                            <span>Is evidence stored in eWitnessVault admissible in court?</span>
                            <i class="ti ti-plus faq-icon"></i>
                        </div>
                        <div class="faq-answer">
                            <p class="faq-answer-text">Yes. eWitnessVault generates comprehensive exhibit sheets containing custody timelines, submitter credentials, GPS telemetry, and cryptographic proofs designed to meet statutory requirements under Section 106 and international rules of evidence.</p>
                        </div>
                    </div>
                    <div class="faq-item">
                        <div class="faq-question" onclick="toggleFAQ(this)">
                            <span>Why do Judges and Lawyers require administrative verification?</span>
                            <i class="ti ti-plus faq-icon"></i>
                        </div>
                        <div class="faq-answer">
                            <p class="faq-answer-text">Judges and Lawyers have expansive evidentiary access across court discovery dockets. To preserve confidential proceedings, institutional verification by the system administrator ensures only authentic bar-certified advocates and magistrate officers gain clearance.</p>
                        </div>
                    </div>
                    <div class="faq-item">
                        <div class="faq-question" onclick="toggleFAQ(this)">
                            <span>What formats of evidence can be submitted to the vault?</span>
                            <i class="ti ti-plus faq-icon"></i>
                        </div>
                        <div class="faq-answer">
                            <p class="faq-answer-text">The platform accepts high-resolution photography (JPEG, PNG, TIFF), bodycam and phone video recordings (MP4, MOV, MKV, AVI), audio testimony recordings (WAV, MP3, AAC), and digital documents (PDF, DOCX) up to enterprise upload limits.</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Contact -->
            <section class="section">
                <h2 class="section-title">Judicial Support Registry</h2>
                <p class="section-subtitle">Direct communication channels for trial registries and law enforcement</p>
                <div class="contact-grid">
                    <div class="contact-card">
                        <i class="ti ti-mail contact-icon"></i>
                        <div class="contact-title">Institutional Inquiries</div>
                        <div class="contact-info">
                            <a href="mailto:support@ewitnessvault.com" class="contact-link">registry@ewitnessvault.com</a>
                        </div>
                    </div>
                    <div class="contact-card">
                        <i class="ti ti-phone contact-icon"></i>
                        <div class="contact-title">Direct Helpline</div>
                        <div class="contact-info">
                            <a href="tel:+256700000000" class="contact-link">+256 700 000 000</a>
                        </div>
                    </div>
                    <div class="contact-card">
                        <i class="ti ti-shield-check contact-icon"></i>
                        <div class="contact-title">Forensic Verification</div>
                        <div class="contact-info">24/7 Verification Active</div>
                    </div>
                    <div class="contact-card">
                        <i class="ti ti-map-pin contact-icon"></i>
                        <div class="contact-title">Jurisdiction</div>
                        <div class="contact-info">Court Systems &bull; Global Standard</div>
                    </div>
                </div>
            </section>

            <!-- CTA Actions -->
            <div class="nav-actions">
                <a href="{{ route('register') }}" class="btn btn-primary">
                    <i class="ti ti-shield-lock"></i> Register Your Credentials
                </a>
                <a href="{{ url('/') }}" class="btn btn-back">
                    <i class="ti ti-arrow-left"></i> Return to Registry Home
                </a>
            </div>
        </div>

        <footer>
            <div class="footer-inner">
                <div class="footer-text">&copy; {{ date('Y') }} eWitnessVault &mdash; Cryptographically Sealed Judicial Evidence Platform.</div>
                <div class="footer-text">Designed by <span class="footer-brand">Tinka</span></div>
            </div>
        </footer>

        <script>
            function toggleFAQ(element) {
                const faqItem = element.parentElement;
                const isActive = faqItem.classList.contains('active');
                document.querySelectorAll('.faq-item').forEach(item => item.classList.remove('active'));
                if (!isActive) faqItem.classList.add('active');
            }

            // Scroll animation
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, { threshold: 0.1, rootMargin: '0px 0px -60px 0px' });

            document.querySelectorAll('.section').forEach(section => {
                section.style.opacity = '0';
                section.style.transform = 'translateY(25px)';
                section.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
                observer.observe(section);
            });
        </script>
    </body>
</html>