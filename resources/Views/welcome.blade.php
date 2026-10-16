<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <title>eWitnessVault | Sovereign Judicial Evidence Registry</title>
    <meta name="description" content="The definitive judicial platform for tamper-proof digital evidence. Preserving truth with immutable cryptographic custody.">

    <!-- PWA Metadata -->
    <meta name="theme-color" content="#070a12">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo-192.png') }}">

    <!-- Favicon — matching nav header gold scales crest -->
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 64 64'%3E%3Cdefs%3E%3ClinearGradient id='b' x1='0%25' y1='0%25' x2='100%25' y2='100%25'%3E%3Cstop offset='0%25' stop-color='%23141a2e'/%3E%3Cstop offset='100%25' stop-color='%23050811'/%3E%3C/linearGradient%3E%3C/defs%3E%3Crect x='2' y='2' width='60' height='60' rx='14' fill='url(%23b)'/%3E%3Crect x='2' y='2' width='60' height='60' rx='14' fill='none' stroke='%23fbbf24' stroke-width='2.5'/%3E%3Cg transform='translate(10,10) scale(1.833)' stroke='%23fbbf24' stroke-width='2.2' stroke-linecap='round' stroke-linejoin='round' fill='none'%3E%3Cpath d='M7 20h10'/%3E%3Cpath d='M6 6l6-1 6 1'/%3E%3Cpath d='M12 5v15'/%3E%3Cpath d='M9 11l-3-6-3 6a3 3 0 0 0 6 0'/%3E%3Cpath d='M21 11l-3-6-3 6a3 3 0 0 0 6 0'/%3E%3C/g%3E%3C/svg%3E">
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <link rel="apple-touch-icon" href="{{ asset('favicon.png') }}">

    <!-- Fonts: Cinzel for Judicial Dignity & Outfit for Modern Clarity -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@600;700;800;900&family=Outfit:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- Tabler Icons -->
    <link href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont/tabler-icons.min.css" rel="stylesheet">

    <style>
        :root {
            --bg-obsidian: #060911;
            --bg-charcoal: #0c111d;
            --bg-card: rgba(16, 23, 38, 0.75);
            --gold-primary: #f59e0b;
            --gold-bright: #fbbf24;
            --gold-pale: #fef3c7;
            --gold-dark: #b45309;
            --gold-border: rgba(245, 158, 11, 0.28);
            --gold-glow: 0 0 35px rgba(245, 158, 11, 0.22);
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
            --font-display: 'Cinzel', serif;
            --font-body: 'Outfit', sans-serif;
            --font-mono: 'JetBrains Mono', monospace;
        }

        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

        html { scroll-behavior: smooth; }

        body {
            min-height: 100vh;
            font-family: var(--font-body);
            color: var(--text-main);
            background-color: var(--bg-obsidian);
            background-image: 
                radial-gradient(circle at 50% -10%, rgba(245, 158, 11, 0.16) 0%, transparent 60%),
                radial-gradient(circle at 10% 40%, rgba(217, 119, 6, 0.08) 0%, transparent 50%),
                radial-gradient(circle at 90% 70%, rgba(245, 158, 11, 0.06) 0%, transparent 50%),
                linear-gradient(180deg, #060911 0%, #0a0e1a 100%);
            background-attachment: fixed;
            position: relative;
            overflow-x: hidden;
            line-height: 1.6;
        }

        /* Subtle Geometric Background Grid */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background-image: 
                linear-gradient(rgba(245, 158, 11, 0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(245, 158, 11, 0.03) 1px, transparent 1px);
            background-size: 60px 60px;
            pointer-events: none;
            z-index: 0;
        }

        /* Ambient Courtroom Glow Accent */
        .ambient-beam {
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 800px;
            height: 450px;
            background: radial-gradient(ellipse at center, rgba(245, 158, 11, 0.18), transparent 70%);
            filter: blur(60px);
            pointer-events: none;
            z-index: 0;
        }

        /* Typography */
        h1, h2, h3, .font-judicial {
            font-family: var(--font-display);
            letter-spacing: 0.03em;
        }

        /* Top Navigation */
        .judicial-nav {
            position: sticky;
            top: 0;
            z-index: 100;
            background: rgba(6, 9, 17, 0.85);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border-bottom: 1px solid var(--gold-border);
            padding: 1rem 2rem;
            transition: all 0.3s ease;
        }

        .nav-inner {
            max-width: 1320px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .brand-crest {
            display: flex;
            align-items: center;
            gap: 0.85rem;
            text-decoration: none;
        }

        .crest-icon-box {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: linear-gradient(135deg, rgba(245, 158, 11, 0.25), rgba(180, 83, 9, 0.15));
            border: 1.5px solid var(--gold-bright);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--gold-bright);
            font-size: 1.4rem;
            box-shadow: 0 0 20px rgba(245, 158, 11, 0.3);
        }

        .brand-text-name {
            font-family: var(--font-display);
            font-size: 1.35rem;
            font-weight: 800;
            background: linear-gradient(135deg, #ffffff 40%, var(--gold-bright) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            letter-spacing: 0.05em;
        }

        .brand-text-sub {
            font-size: 0.68rem;
            text-transform: uppercase;
            letter-spacing: 0.12em;
            color: var(--gold-primary);
            font-weight: 700;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 1.75rem;
        }

        .nav-link-item {
            color: var(--text-muted);
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 600;
            letter-spacing: 0.02em;
            transition: color 0.2s ease;
        }

        .nav-link-item:hover {
            color: var(--gold-bright);
        }

        .nav-actions {
            display: flex;
            align-items: center;
            gap: 0.85rem;
        }

        .btn-gold-ghost {
            padding: 0.55rem 1.25rem;
            border-radius: 8px;
            color: #e2e8f0;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.875rem;
            border: 1px solid rgba(245, 158, 11, 0.35);
            background: rgba(245, 158, 11, 0.05);
            transition: all 0.25s ease;
        }

        .btn-gold-ghost:hover {
            border-color: var(--gold-bright);
            color: var(--gold-bright);
            background: rgba(245, 158, 11, 0.15);
            transform: translateY(-1px);
        }

        .btn-gold-solid {
            padding: 0.6rem 1.4rem;
            border-radius: 8px;
            color: #0b0f19;
            text-decoration: none;
            font-weight: 700;
            font-size: 0.875rem;
            background: linear-gradient(135deg, #f59e0b 0%, #fbbf24 60%, #d97706 100%);
            border: 1px solid #fbbf24;
            box-shadow: 0 4px 20px rgba(245, 158, 11, 0.35);
            transition: all 0.25s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-gold-solid:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(245, 158, 11, 0.55);
            background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
        }

        /* Hero Section */
        .hero-section {
            position: relative;
            z-index: 10;
            max-width: 1240px;
            margin: 0 auto;
            padding: 5.5rem 1.5rem 3.5rem;
            text-align: center;
        }

        .statutory-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.6rem;
            padding: 0.45rem 1.25rem;
            background: rgba(245, 158, 11, 0.08);
            border: 1px solid var(--gold-border);
            border-radius: 50px;
            font-size: 0.775rem;
            font-weight: 700;
            color: var(--gold-bright);
            letter-spacing: 0.08em;
            text-transform: uppercase;
            margin-bottom: 2rem;
            box-shadow: 0 0 25px rgba(245, 158, 11, 0.12);
        }

        .hero-title {
            font-size: clamp(2.5rem, 5.5vw, 4.4rem);
            font-weight: 900;
            line-height: 1.15;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            background: linear-gradient(180deg, #ffffff 40%, #e2e8f0 70%, var(--gold-bright) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            max-width: 1040px;
            margin: 0 auto 1.5rem;
            text-shadow: 0 10px 40px rgba(0, 0, 0, 0.8);
        }

        .hero-description {
            font-size: 1.15rem;
            color: #cbd5e1;
            max-width: 780px;
            margin: 0 auto 2.75rem;
            font-weight: 300;
            line-height: 1.75;
        }

        .hero-cta-cluster {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1.25rem;
            flex-wrap: wrap;
            margin-bottom: 4rem;
        }

        .btn-hero-primary {
            padding: 0.95rem 2.25rem;
            font-size: 1rem;
            font-weight: 800;
            border-radius: 10px;
            background: linear-gradient(135deg, #f59e0b 0%, #fbbf24 60%, #b45309 100%);
            color: #070a12;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.65rem;
            border: 1.5px solid #fbbf24;
            box-shadow: 0 8px 35px rgba(245, 158, 11, 0.45);
            transition: all 0.3s ease;
            letter-spacing: 0.03em;
        }

        .btn-hero-primary:hover {
            transform: translateY(-3px) scale(1.02);
            box-shadow: 0 12px 50px rgba(245, 158, 11, 0.7);
        }

        .btn-hero-secondary {
            padding: 0.95rem 2.25rem;
            font-size: 1rem;
            font-weight: 700;
            border-radius: 10px;
            background: rgba(15, 23, 42, 0.7);
            border: 1.5px solid rgba(245, 158, 11, 0.35);
            color: #f1f5f9;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.65rem;
            backdrop-filter: blur(16px);
            transition: all 0.3s ease;
        }

        .btn-hero-secondary:hover {
            border-color: var(--gold-bright);
            color: var(--gold-bright);
            background: rgba(245, 158, 11, 0.12);
            transform: translateY(-3px);
        }

        /* Judicial Trust Metrics Strip */
        .trust-strip {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1.25rem;
            max-width: 1200px;
            margin: 0 auto 5.5rem;
            padding: 0 1.5rem;
        }

        .trust-item {
            background: rgba(15, 23, 42, 0.65);
            backdrop-filter: blur(20px);
            border: 1px solid var(--gold-border);
            border-radius: 14px;
            padding: 1.5rem 1.25rem;
            text-align: left;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .trust-item::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; height: 2px;
            background: linear-gradient(90deg, transparent, var(--gold-bright), transparent);
            opacity: 0.6;
        }

        .trust-item:hover {
            transform: translateY(-4px);
            border-color: rgba(245, 158, 11, 0.6);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.5), var(--gold-glow);
        }

        .trust-icon {
            font-size: 1.75rem;
            color: var(--gold-bright);
            margin-bottom: 0.75rem;
            display: block;
        }

        .trust-value {
            font-size: 1.2rem;
            font-weight: 800;
            color: #ffffff;
            font-family: var(--font-display);
            margin-bottom: 0.25rem;
        }

        .trust-label {
            font-size: 0.75rem;
            color: #94a3b8;
            line-height: 1.45;
        }

        /* Interactive Real-Time Hash Verifier Box */
        .verifier-section {
            max-width: 1040px;
            margin: 0 auto 6rem;
            padding: 0 1.5rem;
            position: relative;
            z-index: 10;
        }

        .verifier-card {
            background: rgba(14, 20, 36, 0.85);
            backdrop-filter: blur(24px);
            border: 1.5px solid var(--gold-border);
            border-radius: 20px;
            padding: 2.5rem;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.6), inset 0 1px 0 rgba(251, 191, 36, 0.15);
            position: relative;
            overflow: hidden;
        }

        .verifier-head {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.75rem;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .verifier-title {
            font-size: 1.35rem;
            font-weight: 800;
            color: #f8fafc;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .verifier-badge {
            font-size: 0.7rem;
            font-weight: 700;
            padding: 0.25rem 0.75rem;
            background: rgba(16, 185, 129, 0.15);
            border: 1px solid rgba(16, 185, 129, 0.35);
            color: #34d399;
            border-radius: 50px;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
        }

        .verifier-input-wrap {
            position: relative;
            margin-bottom: 1.25rem;
        }

        .verifier-input {
            width: 100%;
            padding: 1rem 1.25rem;
            background: rgba(8, 12, 22, 0.9);
            border: 1.5px solid rgba(71, 85, 105, 0.4);
            border-radius: 12px;
            font-family: var(--font-body);
            color: #f1f5f9;
            font-size: 0.95rem;
            outline: none;
            transition: all 0.25s ease;
        }

        .verifier-input:focus {
            border-color: var(--gold-bright);
            box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.18);
        }

        .verifier-output {
            background: rgba(6, 9, 17, 0.95);
            border: 1px solid rgba(245, 158, 11, 0.2);
            border-radius: 12px;
            padding: 1.25rem;
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .output-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 0.5rem;
            font-size: 0.8125rem;
        }

        .output-label {
            color: #94a3b8;
            font-weight: 600;
        }

        .output-hash {
            font-family: var(--font-mono);
            color: var(--gold-bright);
            background: rgba(245, 158, 11, 0.08);
            padding: 0.35rem 0.65rem;
            border-radius: 6px;
            word-break: break-all;
            font-size: 0.825rem;
        }

        /* Evidence Lifecycle Section */
        .section-header {
            text-align: center;
            max-width: 720px;
            margin: 0 auto 3.5rem;
            padding: 0 1rem;
        }

        .section-kicker {
            font-size: 0.75rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.15em;
            color: var(--gold-bright);
            margin-bottom: 0.5rem;
            display: block;
        }

        .section-heading {
            font-size: 2.25rem;
            font-weight: 800;
            color: #ffffff;
            margin-bottom: 0.75rem;
        }

        .section-desc {
            font-size: 0.95rem;
            color: var(--text-muted);
        }

        .lifecycle-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1.5rem;
            max-width: 1240px;
            margin: 0 auto 6rem;
            padding: 0 1.5rem;
        }

        .lifecycle-card {
            background: rgba(14, 20, 36, 0.7);
            border: 1px solid rgba(71, 85, 105, 0.3);
            border-radius: 16px;
            padding: 2rem 1.5rem;
            position: relative;
            transition: all 0.3s ease;
        }

        .lifecycle-card:hover {
            border-color: var(--gold-bright);
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.5), var(--gold-glow);
            background: rgba(16, 23, 42, 0.9);
        }

        .lifecycle-step {
            position: absolute;
            top: 1.25rem;
            right: 1.25rem;
            font-family: var(--font-display);
            font-size: 1.4rem;
            font-weight: 900;
            color: rgba(245, 158, 11, 0.25);
        }

        .lifecycle-icon {
            width: 52px;
            height: 52px;
            border-radius: 12px;
            background: rgba(245, 158, 11, 0.1);
            border: 1px solid var(--gold-border);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: var(--gold-bright);
            margin-bottom: 1.25rem;
        }

        .lifecycle-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: #f1f5f9;
            margin-bottom: 0.5rem;
        }

        .lifecycle-text {
            font-size: 0.825rem;
            color: #94a3b8;
            line-height: 1.55;
        }

        /* 4 Role Clearances Section */
        .roles-section {
            max-width: 1240px;
            margin: 0 auto 6rem;
            padding: 0 1.5rem;
        }

        .role-cards-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
        }

        .role-portal-card {
            background: linear-gradient(180deg, rgba(16, 24, 40, 0.8) 0%, rgba(10, 15, 26, 0.9) 100%);
            border: 1px solid var(--gold-border);
            border-radius: 18px;
            padding: 2.25rem 1.5rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            transition: all 0.3s ease;
            position: relative;
        }

        .role-portal-card:hover {
            border-color: var(--gold-bright);
            transform: translateY(-6px);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.6), var(--gold-glow);
        }

        .role-portal-icon {
            font-size: 2.5rem;
            color: var(--gold-bright);
            margin-bottom: 1rem;
            display: inline-block;
        }

        .role-portal-name {
            font-size: 1.25rem;
            font-weight: 700;
            font-family: var(--font-display);
            color: #ffffff;
            margin-bottom: 0.4rem;
        }

        .role-portal-clearance {
            font-size: 0.72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--gold-primary);
            margin-bottom: 1rem;
        }

        .role-portal-desc {
            font-size: 0.8125rem;
            color: #94a3b8;
            line-height: 1.55;
            margin-bottom: 1.75rem;
        }

        .role-portal-link {
            font-size: 0.825rem;
            font-weight: 700;
            color: var(--gold-bright);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.4rem;
            transition: gap 0.2s ease;
        }

        .role-portal-card:hover .role-portal-link {
            gap: 0.7rem;
        }

        /* Statutory Callout Banner */
        .statute-banner {
            max-width: 1200px;
            margin: 0 auto 6rem;
            padding: 0 1.5rem;
        }

        .statute-inner {
            background: linear-gradient(135deg, rgba(245, 158, 11, 0.12) 0%, rgba(15, 23, 42, 0.95) 45%, rgba(180, 83, 9, 0.1) 100%);
            border: 1.5px solid var(--gold-border);
            border-radius: 20px;
            padding: 3rem 2.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 2rem;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
            flex-wrap: wrap;
        }

        .statute-text-wrap {
            max-width: 680px;
        }

        .statute-text-wrap h3 {
            font-size: 1.75rem;
            font-weight: 800;
            color: #ffffff;
            margin-bottom: 0.75rem;
        }

        .statute-text-wrap p {
            font-size: 0.95rem;
            color: #cbd5e1;
            line-height: 1.65;
        }

        /* Footer */
        .judicial-footer {
            border-top: 1px solid var(--gold-border);
            background: rgba(6, 9, 17, 0.95);
            padding: 4rem 1.5rem 2rem;
            position: relative;
            z-index: 10;
        }

        .footer-grid {
            max-width: 1240px;
            margin: 0 auto 3rem;
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr;
            gap: 3rem;
        }

        .footer-brand-bio {
            font-size: 0.825rem;
            color: #64748b;
            line-height: 1.6;
            margin-top: 1rem;
            max-width: 320px;
        }

        .footer-col-title {
            font-size: 0.75rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.12em;
            color: var(--gold-bright);
            margin-bottom: 1.25rem;
            font-family: var(--font-display);
        }

        .footer-col-links {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 0.65rem;
        }

        .footer-col-links a {
            color: #94a3b8;
            text-decoration: none;
            font-size: 0.825rem;
            transition: color 0.2s ease;
        }

        .footer-col-links a:hover {
            color: var(--gold-bright);
        }

        .footer-bottom {
            max-width: 1240px;
            margin: 0 auto;
            padding-top: 2rem;
            border-top: 1px solid rgba(71, 85, 105, 0.25);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
            font-size: 0.775rem;
            color: #64748b;
        }

        /* Responsive Breakpoints */
        @media (max-width: 1024px) {
            .trust-strip { grid-template-columns: repeat(2, 1fr); }
            .lifecycle-grid { grid-template-columns: repeat(2, 1fr); }
            .role-cards-grid { grid-template-columns: repeat(2, 1fr); }
            .footer-grid { grid-template-columns: 1fr 1fr; }
        }

        @media (max-width: 768px) {
            .nav-links { display: none; }
            .hero-section { padding-top: 3.5rem; }
            .trust-strip { grid-template-columns: 1fr; }
            .lifecycle-grid { grid-template-columns: 1fr; }
            .role-cards-grid { grid-template-columns: 1fr; }
            .footer-grid { grid-template-columns: 1fr; }
            .statute-inner { padding: 2rem 1.5rem; }
        }
    </style>
</head>
<body>
    <div class="ambient-beam"></div>

    <!-- Judicial Top Navigation -->
    <header class="judicial-nav">
        <div class="nav-inner">
            <a href="{{ url('/') }}" class="brand-crest">
                <div class="crest-icon-box">
                    <i class="ti ti-scale"></i>
                </div>
                <div>
                    <div class="brand-text-name">eWitnessVault</div>
                    <div class="brand-text-sub">Sovereign Evidence Registry</div>
                </div>
            </a>

            <nav class="nav-links">
                <a href="#protocol" class="nav-link-item">Custody Protocol</a>
                <a href="#verifier" class="nav-link-item">Live Verifier</a>
                <a href="#roles" class="nav-link-item">Judicial Roles</a>
                <a href="{{ route('about') }}" class="nav-link-item">Legal Framework</a>
            </nav>

            <div class="nav-actions">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ route('dashboard') }}" class="btn-gold-solid">
                            <i class="ti ti-layout-dashboard"></i>
                            <span>Access Vault</span>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn-gold-ghost">Sign In</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn-gold-solid">
                                <i class="ti ti-shield-check"></i>
                                <span>Create Account</span>
                            </a>
                        @endif
                    @endauth
                @endif
            </div>
        </div>
    </header>

    <!-- Main Hero -->
    <main>
        <section class="hero-section">
            <div class="statutory-badge">
                <i class="ti ti-certificate"></i>
                <span>Statutory Chain of Custody · Admissible Digital Evidence</span>
            </div>

            <h1 class="hero-title">
                The Sovereign Vault for Digital Evidence
            </h1>

            <p class="hero-description">
                Engineered for High Court proceedings, legal practitioners, and sworn citizen testimony. Every exhibit is cryptographically sealed at ingest with SHA-256 digests, automated GPS telemetry, and unbroken chains of custody.
            </p>

            <div class="hero-cta-cluster">
                @auth
                    <a href="{{ route('dashboard') }}" class="btn-hero-primary">
                        <i class="ti ti-gavel"></i>
                        <span>Enter Judicial Vault</span>
                    </a>
                    <a href="{{ route('upload') }}" class="btn-hero-secondary">
                        <i class="ti ti-cloud-upload"></i>
                        <span>Submit Sworn Evidence</span>
                    </a>
                @else
                    <a href="{{ route('register') }}" class="btn-hero-primary">
                        <i class="ti ti-shield-check"></i>
                        <span>Register with Vault</span>
                    </a>
                    <a href="#verifier" class="btn-hero-secondary">
                        <i class="ti ti-binary"></i>
                        <span>Test Cryptographic Engine</span>
                    </a>
                @endauth
            </div>
        </section>

        <!-- Trust Pillars Strip -->
        <section class="trust-strip">
            <div class="trust-item">
                <i class="ti ti-binary trust-icon"></i>
                <div class="trust-value">SHA-256</div>
                <div class="trust-label">One-way cryptographic digest computed on upload to guarantee file immutability.</div>
            </div>

            <div class="trust-item">
                <i class="ti ti-map-pin-check trust-icon"></i>
                <div class="trust-value">WGS-84 GPS</div>
                <div class="trust-label">Automated satellite geolocation locked to exhibit metadata with UTC timestamps.</div>
            </div>

            <div class="trust-item">
                <i class="ti ti-history trust-icon"></i>
                <div class="trust-value">Strict Custody</div>
                <div class="trust-label">Continuous ledger documenting every officer view, transfer, and deliberation note.</div>
            </div>

            <div class="trust-item">
                <i class="ti ti-gavel trust-icon"></i>
                <div class="trust-value">Court Admissible</div>
                <div class="trust-label">Structured forensic export ready for direct judicial examination and trial discovery.</div>
            </div>
        </section>

        <!-- Live Interactive Cryptographic Hash Verifier -->
        <section class="verifier-section" id="verifier">
            <div class="verifier-card">
                <div class="verifier-head">
                    <div>
                        <div class="verifier-title">
                            <i class="ti ti-shield-lock" style="color: var(--gold-bright);"></i>
                            <span>Real-Time Cryptographic Verification Engine</span>
                        </div>
                        <div style="font-size: 0.8rem; color: #94a3b8; margin-top: 0.2rem;">
                            Test the live hashing algorithm that protects all submissions in eWitnessVault.
                        </div>
                    </div>
                    <div class="verifier-badge">
                        <i class="ti ti-circle-check"></i>
                        <span>WebCrypto Engine Live</span>
                    </div>
                </div>

                <div class="verifier-input-wrap">
                    <input type="text" id="live-verifier-input" class="verifier-input" 
                        value="High Court Case #2026-CR-0982: Digital Audio Recording Exhibit A"
                        placeholder="Type text or statement to inspect instant SHA-256 signature...">
                </div>

                <div class="verifier-output">
                    <div class="output-row">
                        <span class="output-label">Digest Algorithm</span>
                        <span style="color: #cbd5e1; font-weight: 700;">SHA-256 (FIPS 180-4 Standard)</span>
                    </div>
                    <div class="output-row">
                        <span class="output-label">Immutable Fingerprint</span>
                        <span id="live-hash-display" class="output-hash">Calculating...</span>
                    </div>
                    <div class="output-row">
                        <span class="output-label">Integrity Status</span>
                        <span style="color: #34d399; font-weight: 700; display: flex; align-items: center; gap: 0.35rem;">
                            <i class="ti ti-check"></i> Tamper-Evident Seal Intact
                        </span>
                    </div>
                </div>
            </div>
        </section>

        <!-- Evidence Lifecycle Section -->
        <section class="lifecycle-section" id="protocol">
            <div class="section-header">
                <span class="section-kicker">Evidentiary Protocol</span>
                <h2 class="section-heading">Four Pillars of Judicial Custody</h2>
                <p class="section-desc">Every piece of electronic record undergoes a rigorous multi-tier preservation pipeline.</p>
            </div>

            <div class="lifecycle-grid">
                <div class="lifecycle-card">
                    <div class="lifecycle-step">01</div>
                    <div class="lifecycle-icon"><i class="ti ti-upload"></i></div>
                    <h3 class="lifecycle-title">Sworn Ingestion</h3>
                    <p class="lifecycle-text">Exhibits captured by witnesses are immediately bound to verified geospatial telemetry and UTC timestamps.</p>
                </div>

                <div class="lifecycle-card">
                    <div class="lifecycle-step">02</div>
                    <div class="lifecycle-icon"><i class="ti ti-shield-lock"></i></div>
                    <h3 class="lifecycle-title">Cryptographic Seal</h3>
                    <p class="lifecycle-text">An unforgeable 256-bit SHA digest is computed at ingest. Even a 1-bit alteration completely breaks the cryptographic verification seal.</p>
                </div>

                <div class="lifecycle-card">
                    <div class="lifecycle-step">03</div>
                    <div class="lifecycle-icon"><i class="ti ti-history"></i></div>
                    <h3 class="lifecycle-title">Custody Ledger</h3>
                    <p class="lifecycle-text">Every review, judicial inspection, or lawyer discovery request is appended to an append-only digital audit trail.</p>
                </div>

                <div class="lifecycle-card">
                    <div class="lifecycle-step">04</div>
                    <div class="lifecycle-icon"><i class="ti ti-gavel"></i></div>
                    <h3 class="lifecycle-title">Judicial Discovery</h3>
                    <p class="lifecycle-text">Judges and authorized counsel access sealed exhibits with complete forensic verification certificates ready for open court presentation.</p>
                </div>
            </div>
        </section>

        <!-- Role Clearances Section -->
        <section class="roles-section" id="roles">
            <div class="section-header">
                <span class="section-kicker">Access Governance</span>
                <h2 class="section-heading">Multi-Clearance Courtroom Matrix</h2>
                <p class="section-desc">Strict zero-trust role segregation tailored for the administration of justice.</p>
            </div>

            <div class="role-cards-grid">
                <!-- Judge -->
                <div class="role-portal-card">
                    <div>
                        <i class="ti ti-gavel role-portal-icon"></i>
                        <h3 class="role-portal-name">Judicial Officer</h3>
                        <div class="role-portal-clearance">Presiding Authority</div>
                        <p class="role-portal-desc">
                            High Court judges and trial magistrates presiding over criminal & civil cases with exclusive authority to rule on evidence admissibility and issue rulings.
                        </p>
                    </div>
                    <a href="{{ route('register') }}" class="role-portal-link">
                        <span>Request Judicial Credentials</span>
                        <i class="ti ti-arrow-right"></i>
                    </a>
                </div>

                <!-- Lawyer -->
                <div class="role-portal-card">
                    <div>
                        <i class="ti ti-scale role-portal-icon"></i>
                        <h3 class="role-portal-name">Legal Counsel</h3>
                        <div class="role-portal-clearance">Bar Admission Required</div>
                        <p class="role-portal-desc">
                            Licensed advocates and trial attorneys representing parties, filing discovery motions, and reviewing admissible evidentiary bundles.
                        </p>
                    </div>
                    <a href="{{ route('register') }}" class="role-portal-link">
                        <span>Register as Counsel</span>
                        <i class="ti ti-arrow-right"></i>
                    </a>
                </div>


                <!-- Witness -->
                <div class="role-portal-card">
                    <div>
                        <i class="ti ti-user-check role-portal-icon"></i>
                        <h3 class="role-portal-name">Citizen Witness</h3>
                        <div class="role-portal-clearance">Instant Access</div>
                        <p class="role-portal-desc">
                            Witnesses and public citizens filing time-sensitive recordings, photographic documentation, or sworn affidavits directly into protected vault storage.
                        </p>
                    </div>
                    <a href="{{ route('register') }}" class="role-portal-link">
                        <span>Submit Testimony</span>
                        <i class="ti ti-arrow-right"></i>
                    </a>
                </div>
            </div>
        </section>

        <!-- Statute Trust Banner -->
        <section class="statute-banner">
            <div class="statute-inner">
                <div class="statute-text-wrap">
                    <span style="font-size: 0.72rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.12em; color: var(--gold-bright);">
                        Judicial Integrity Certified
                    </span>
                    <h3>Ready to Preserve Truth in the Administration of Justice?</h3>
                    <p>
                        eWitnessVault combines cryptographic certainty with full compliance under modern Electronic Transactions Acts, Evidence Acts, and Judicial Discovery Directives.
                    </p>
                </div>
                <div>
                    <a href="{{ route('register') }}" class="btn-hero-primary" style="padding: 1rem 2rem;">
                        <i class="ti ti-shield-check"></i>
                        <span>Initialize Case Vault</span>
                    </a>
                </div>
            </div>
        </section>
    </main>

    <!-- Judicial Footer -->
    <footer class="judicial-footer">
        <div class="footer-grid">
            <div>
                <a href="{{ url('/') }}" class="brand-crest" style="margin-bottom: 1rem;">
                    <div class="crest-icon-box" style="width: 36px; height: 36px; font-size: 1.15rem;">
                        <i class="ti ti-scale"></i>
                    </div>
                    <div>
                        <div class="brand-text-name" style="font-size: 1.15rem;">eWitnessVault</div>
                    </div>
                </a>
                <p class="footer-brand-bio">
                    The sovereign digital evidence repository and chain of custody management system for the modern judiciary. Preserving digital artifacts with verifiable cryptographic certainty.
                </p>
            </div>

            <div>
                <div class="footer-col-title">Platform</div>
                <ul class="footer-col-links">
                    <li><a href="#protocol">Custody Protocol</a></li>
                    <li><a href="#verifier">Real-Time Verifier</a></li>
                    <li><a href="#roles">Judicial Matrix</a></li>
                    <li><a href="{{ route('about') }}">Legal Framework</a></li>
                </ul>
            </div>

            <div>
                <div class="footer-col-title">Portal Access</div>
                <ul class="footer-col-links">
                    <li><a href="{{ route('login') }}">Sign In</a></li>
                    <li><a href="{{ route('register') }}">Create Account</a></li>
                    <li><a href="{{ route('upload') }}">Evidence Ingest</a></li>
                    <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                </ul>
            </div>

            <div>
                <div class="footer-col-title">Compliance</div>
                <ul class="footer-col-links">
                    <li><a href="#">Evidence Act 2026</a></li>
                    <li><a href="#">SHA-256 FIPS Standard</a></li>
                    <li><a href="#">WGS-84 Geotagging</a></li>
                    <li><a href="#">Chain of Custody ISO</a></li>
                </ul>
            </div>
        </div>

        <div class="footer-bottom">
            <div>
                &copy; {{ date('Y') }} eWitnessVault &mdash; All Rights Reserved. Sovereign Judicial Evidence System.
            </div>
            <div style="display: flex; gap: 1.5rem;">
                <span style="display: flex; align-items: center; gap: 0.35rem; color: #10b981;">
                    <i class="ti ti-shield-check"></i> 256-Bit Vault Active
                </span>
                <span>Powered by <strong style="color: var(--gold-bright);">TinkaTech Forensic Suite</strong></span>
            </div>
        </div>
    </footer>

    <!-- Interactive Hash Engine Script -->
    <script>
        async function computeSHA256(str) {
            const buffer = new TextEncoder().encode(str);
            const hashBuffer = await crypto.subtle.digest('SHA-256', buffer);
            const hashArray = Array.from(new Uint8Array(hashBuffer));
            return hashArray.map(b => b.toString(16).padStart(2, '0')).join('');
        }

        const verifierInput = document.getElementById('live-verifier-input');
        const hashDisplay = document.getElementById('live-hash-display');

        async function updateHash() {
            if (!verifierInput || !hashDisplay) return;
            const text = verifierInput.value.trim() || 'eWitnessVault';
            const hash = await computeSHA256(text);
            hashDisplay.textContent = hash;
        }

        if (verifierInput) {
            verifierInput.addEventListener('input', updateHash);
            updateHash();
        }
    </script>
</body>
</html>
