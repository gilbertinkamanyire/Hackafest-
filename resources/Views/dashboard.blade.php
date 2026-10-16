<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- PWA / Theme -->
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

    <title>Judicial Dashboard | eWitnessVault</title>

    <!-- Fonts: Cinzel & Outfit -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@600;700;800;900&family=Outfit:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- Tabler Icons -->
    <link href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont/tabler-icons.min.css" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/css/dashboard-new.css'])

    <style>
        :root {
            --bg-obsidian: #060911;
            --bg-charcoal: #0c111d;
            --gold-primary: #f59e0b;
            --gold-bright: #fbbf24;
            --gold-pale: #fef3c7;
            --gold-border: rgba(245, 158, 11, 0.28);
            --gold-glow: 0 0 35px rgba(245, 158, 11, 0.22);
            --font-display: 'Cinzel', serif;
            --font-body: 'Outfit', sans-serif;
            --font-mono: 'JetBrains Mono', monospace;
        }

        body {
            background-color: var(--bg-obsidian);
            color: #f8fafc;
            font-family: var(--font-body);
            min-height: 100vh;
        }

        .dashboard-container {
            max-width: 1380px;
            margin: 0 auto;
            padding: 2.5rem 1.5rem;
        }

        /* Judicial Hero Banner */
        .judicial-hero-card {
            background: linear-gradient(135deg, rgba(16, 24, 40, 0.95) 0%, rgba(12, 17, 29, 0.92) 50%, rgba(20, 16, 5, 0.95) 100%);
            border: 1.5px solid var(--gold-border);
            border-radius: 20px;
            padding: 2.5rem;
            margin-bottom: 2.25rem;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.5), var(--gold-glow);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 2rem;
            position: relative;
            overflow: hidden;
        }

        .judicial-hero-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; height: 3px;
            background: linear-gradient(90deg, transparent, #fbbf24, transparent);
        }

        .hero-title-main {
            font-family: var(--font-display);
            font-size: 2rem;
            font-weight: 800;
            background: linear-gradient(135deg, #ffffff 40%, #fbbf24 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 0.35rem;
        }

        .hero-desc-role {
            font-size: 0.925rem;
            color: #94a3b8;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .role-pill {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            padding: 0.25rem 0.75rem;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            background: rgba(245, 158, 11, 0.15);
            color: #fbbf24;
            border: 1px solid rgba(245, 158, 11, 0.35);
        }

        /* Stat Grid Overhaul */
        .prestige-stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1.25rem;
            margin-bottom: 2.5rem;
        }

        .prestige-stat-box {
            background: rgba(14, 20, 36, 0.75);
            backdrop-filter: blur(20px);
            border: 1px solid var(--gold-border);
            border-radius: 16px;
            padding: 1.6rem 1.4rem;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .prestige-stat-box:hover {
            transform: translateY(-4px);
            border-color: rgba(251, 191, 36, 0.6);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.5), var(--gold-glow);
        }

        .stat-meta-number {
            font-family: var(--font-display);
            font-size: 2rem;
            font-weight: 800;
            color: #ffffff;
            line-height: 1.1;
            margin-bottom: 0.35rem;
        }

        .stat-meta-label {
            font-size: 0.8125rem;
            font-weight: 600;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .stat-meta-sub {
            font-size: 0.72rem;
            color: #64748b;
            margin-top: 0.35rem;
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .stat-icon-wrapper {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background: rgba(245, 158, 11, 0.12);
            border: 1px solid rgba(245, 158, 11, 0.28);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            color: #fbbf24;
            flex-shrink: 0;
        }

        /* Action Grid */
        .judicial-actions-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1.25rem;
            margin-bottom: 2.75rem;
        }

        .judicial-action-item {
            background: rgba(14, 20, 36, 0.7);
            border: 1px solid rgba(71, 85, 105, 0.3);
            border-radius: 14px;
            padding: 1.4rem;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 1rem;
            transition: all 0.25s ease;
        }

        .judicial-action-item:hover {
            border-color: var(--gold-bright);
            background: rgba(245, 158, 11, 0.08);
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.4);
        }

        .judicial-action-icon {
            width: 44px;
            height: 44px;
            border-radius: 10px;
            background: rgba(245, 158, 11, 0.1);
            border: 1px solid rgba(245, 158, 11, 0.25);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            color: #fbbf24;
            flex-shrink: 0;
        }

        .judicial-action-title {
            font-size: 0.95rem;
            font-weight: 700;
            color: #f1f5f9;
            margin-bottom: 0.15rem;
        }

        .judicial-action-desc {
            font-size: 0.75rem;
            color: #64748b;
        }

        /* Evidence Table Container */
        .evidence-registry-card {
            background: rgba(14, 20, 36, 0.85);
            border: 1.5px solid var(--gold-border);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.5);
            margin-bottom: 2.5rem;
        }

        .registry-card-header {
            padding: 1.5rem 2rem;
            border-bottom: 1px solid rgba(71, 85, 105, 0.3);
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: rgba(245, 158, 11, 0.03);
            flex-wrap: wrap;
            gap: 1rem;
        }

        .registry-card-title {
            font-family: var(--font-display);
            font-size: 1.25rem;
            font-weight: 800;
            color: #ffffff;
            display: flex;
            align-items: center;
            gap: 0.65rem;
        }

        .registry-table-custom {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.875rem;
            text-align: left;
        }

        .registry-table-custom th {
            padding: 1rem 1.5rem;
            background: rgba(8, 12, 22, 0.8);
            font-size: 0.72rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #94a3b8;
            border-bottom: 1px solid rgba(71, 85, 105, 0.3);
        }

        .registry-table-custom td {
            padding: 1.15rem 1.5rem;
            border-bottom: 1px solid rgba(71, 85, 105, 0.18);
            color: #cbd5e1;
            vertical-align: middle;
        }

        .registry-table-custom tr:hover td {
            background: rgba(245, 158, 11, 0.04);
        }

        .hash-code-tag {
            font-family: var(--font-mono);
            font-size: 0.75rem;
            color: #fbbf24;
            background: rgba(245, 158, 11, 0.08);
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            border: 1px solid rgba(245, 158, 11, 0.2);
            display: inline-block;
        }

        .court-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            padding: 0.25rem 0.65rem;
            border-radius: 50px;
            font-size: 0.72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }

        .court-badge--verified {
            background: rgba(16, 185, 129, 0.15);
            color: #34d399;
            border: 1px solid rgba(16, 185, 129, 0.35);
        }

        .court-badge--pending {
            background: rgba(245, 158, 11, 0.15);
            color: #fbbf24;
            border: 1px solid rgba(245, 158, 11, 0.35);
        }

        @media (max-width: 1100px) {
            .prestige-stats-grid { grid-template-columns: repeat(2, 1fr); }
            .judicial-actions-grid { grid-template-columns: repeat(2, 1fr); }
        }

        @media (max-width: 680px) {
            .prestige-stats-grid { grid-template-columns: 1fr; }
            .judicial-actions-grid { grid-template-columns: 1fr; }
            .judicial-hero-card { padding: 1.75rem 1.25rem; }
            .hero-title-main { font-size: 1.5rem; }
        }
    </style>
</head>
<body class="dashboard-body">
    <!-- Background overlay -->
    <div class="dashboard-background"></div>

    <!-- Navigation Header -->
    @include('layouts.dashboard-nav')

    <!-- Dashboard Content Container -->
    <div class="dashboard-container">
        <!-- Hero Header -->
        <header class="judicial-hero-card">
            <div>
                <div style="display: flex; align-items: center; gap: 0.65rem; margin-bottom: 0.65rem;">
                    <span class="role-pill">
                        <i class="ti {{ $features['role_icon'] ?? 'ti-shield-check' }}"></i>
                        {{ $features['role_name'] ?? 'Witness' }} Clearance
                    </span>
                    <span style="font-size: 0.72rem; color: #10b981; display: inline-flex; align-items: center; gap: 0.3rem;">
                        <span style="width: 7px; height: 7px; border-radius: 50%; background: #10b981; display: inline-block;"></span>
                        Vault Session Sealed
                    </span>
                </div>
                <h1 class="hero-title-main">
                    Welcome, {{ Auth::user()->name }}
                </h1>
                <p class="hero-desc-role">
                    @if(($features['role_name'] ?? '') === 'Judge')
                        Presiding Judicial Officer &mdash; Evidentiary admissibility review and judicial oversight console.
                    @elseif(($features['role_name'] ?? '') === 'Lawyer')
                        Counsel Dashboard &mdash; Discovery requests, subpoena exhibits, and legal filings.
                    @else
                        Sovereign Witness Vault &mdash; Sworn digital evidence capture and immutable cryptographic repository.
                    @endif
                </p>
            </div>

            <div style="display: flex; gap: 0.85rem; align-items: center;">
                @if($features['can_upload'] ?? false)
                    <a href="{{ route('upload') }}" class="btn-gold-solid" style="padding: 0.75rem 1.6rem; font-size: 0.9rem;">
                        <i class="ti ti-camera"></i>
                        <span>Capture New Evidence</span>
                    </a>
                @else
                    <a href="{{ route('evidence.index') }}" class="btn-gold-solid" style="padding: 0.75rem 1.6rem; font-size: 0.9rem;">
                        <i class="ti ti-files"></i>
                        <span>Inspect Evidence Ledger</span>
                    </a>
                @endif
            </div>
        </header>

        <!-- Prestige Statistics Grid -->
        <section class="prestige-stats-grid">
            <!-- Stat 1: User Evidence Exhibits -->
            <div class="prestige-stat-box">
                <div>
                    <div class="stat-meta-number">{{ $stats['user_evidence'] ?? 0 }}</div>
                    <div class="stat-meta-label">My Exhibits</div>
                    <div class="stat-meta-sub">
                        <i class="ti ti-shield-check" style="color: #34d399;"></i>
                        <span>Cryptographically Sealed</span>
                    </div>
                </div>
                <div class="stat-icon-wrapper">
                    <i class="ti ti-files"></i>
                </div>
            </div>

            <!-- Stat 2: Total Evidence Repository (for all or role) -->
            <div class="prestige-stat-box">
                <div>
                    <div class="stat-meta-number">{{ $stats['total_evidence'] ?? 0 }}</div>
                    <div class="stat-meta-label">Total Vault Archive</div>
                    <div class="stat-meta-sub">
                        <i class="ti ti-database" style="color: #fbbf24;"></i>
                        <span>Statutory Case Ledger</span>
                    </div>
                </div>
                <div class="stat-icon-wrapper">
                    <i class="ti ti-database-check"></i>
                </div>
            </div>

            <!-- Stat 3: Role-specific Metric -->
            @if(($features['role_name'] ?? '') === 'Judge')
                <div class="prestige-stat-box">
                    <div>
                        <div class="stat-meta-number">{{ $stats['pending_review'] ?? 0 }}</div>
                        <div class="stat-meta-label">Pending Review</div>
                        <div class="stat-meta-sub">
                            <i class="ti ti-gavel" style="color: #fbbf24;"></i>
                            <span>Awaiting Ruling</span>
                        </div>
                    </div>
                    <div class="stat-icon-wrapper">
                        <i class="ti ti-clock-pause"></i>
                    </div>
                </div>
            @elseif(($features['role_name'] ?? '') === 'Lawyer')
                <div class="prestige-stat-box">
                    <div>
                        <div class="stat-meta-number">{{ $stats['active_cases'] ?? 0 }}</div>
                        <div class="stat-meta-label">Active Discovery</div>
                        <div class="stat-meta-sub">
                            <i class="ti ti-briefcase" style="color: #38bdf8;"></i>
                            <span>Trial Proceedings</span>
                        </div>
                    </div>
                    <div class="stat-icon-wrapper">
                        <i class="ti ti-briefcase"></i>
                    </div>
                </div>
            @else
                <div class="prestige-stat-box">
                    <div>
                        <div class="stat-meta-number">100%</div>
                        <div class="stat-meta-label">Chain of Custody</div>
                        <div class="stat-meta-sub">
                            <i class="ti ti-lock" style="color: #10b981;"></i>
                            <span>Zero Tampering</span>
                        </div>
                    </div>
                    <div class="stat-icon-wrapper">
                        <i class="ti ti-certificate"></i>
                    </div>
                </div>
            @endif

            <!-- Stat 4: Security Standard -->
            <div class="prestige-stat-box">
                <div>
                    <div class="stat-meta-number">SHA-256</div>
                    <div class="stat-meta-label">Integrity Protocol</div>
                    <div class="stat-meta-sub">
                        <i class="ti ti-binary" style="color: #fbbf24;"></i>
                        <span>FIPS 180-4 Standard</span>
                    </div>
                </div>
                <div class="stat-icon-wrapper">
                    <i class="ti ti-shield-lock"></i>
                </div>
            </div>
        </section>

        <!-- Quick Actions Grid -->
        <section class="judicial-actions-grid">
            @if($features['can_upload'] ?? false)
            <a href="{{ route('upload') }}" class="judicial-action-item">
                <div class="judicial-action-icon">
                    <i class="ti ti-camera"></i>
                </div>
                <div>
                    <div class="judicial-action-title">Capture Evidence</div>
                    <div class="judicial-action-desc">Ingest photo, video or camera snapshot</div>
                </div>
            </a>
            @else
            <a href="{{ route('evidence.index') }}" class="judicial-action-item">
                <div class="judicial-action-icon">
                    <i class="ti ti-eye"></i>
                </div>
                <div>
                    <div class="judicial-action-title">Inspect Docket</div>
                    <div class="judicial-action-desc">Review case files & verified exhibits</div>
                </div>
            </a>
            @endif

            <a href="{{ route('evidence.index') }}" class="judicial-action-item">
                <div class="judicial-action-icon">
                    <i class="ti ti-archive"></i>
                </div>
                <div>
                    <div class="judicial-action-title">Evidence Vault</div>
                    <div class="judicial-action-desc">Browse complete exhibit registry</div>
                </div>
            </a>

            <a href="{{ route('profile.edit') }}" class="judicial-action-item">
                <div class="judicial-action-icon">
                    <i class="ti ti-shield-check"></i>
                </div>
                <div>
                    <div class="judicial-action-title">Security & Keys</div>
                    <div class="judicial-action-desc">Manage judicial credentials</div>
                </div>
            </a>

            <a href="{{ route('about') }}" class="judicial-action-item">
                <div class="judicial-action-icon">
                    <i class="ti ti-book-2"></i>
                </div>
                <div>
                    <div class="judicial-action-title">Statutory Protocol</div>
                    <div class="judicial-action-desc">Evidence custody guidelines</div>
                </div>
            </a>
        </section>

        <!-- Recent Evidence Registry Table -->
        <section class="evidence-registry-card">
            <div class="registry-card-header">
                <div class="registry-card-title">
                    <i class="ti ti-gavel" style="color: #fbbf24;"></i>
                    <span>Recent Court Exhibits & Sworn Records</span>
                </div>
                <a href="{{ route('evidence.index') }}" class="btn-gold-ghost" style="font-size: 0.8rem; padding: 0.4rem 0.95rem;">
                    <span>View Complete Archive</span>
                    <i class="ti ti-arrow-right" style="margin-left: 0.35rem;"></i>
                </a>
            </div>

            @if(isset($evidenceList) && $evidenceList->count() > 0)
                <div style="overflow-x: auto;">
                    <table class="registry-table-custom">
                        <thead>
                            <tr>
                                <th>Exhibit Title & Reference</th>
                                <th>Description / Narrative</th>
                                <th>Filing Date & Time</th>
                                <th>Forensic Status</th>
                                <th style="text-align: right;">Judicial Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($evidenceList->take(6) as $evidence)
                            <tr>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                                        <div style="width: 36px; height: 36px; border-radius: 8px; background: rgba(245, 158, 11, 0.1); border: 1px solid rgba(245, 158, 11, 0.25); display: flex; align-items: center; justify-content: center; color: #fbbf24; flex-shrink: 0;">
                                            <i class="ti ti-file-text"></i>
                                        </div>
                                        <div>
                                            <div style="font-weight: 700; color: #f8fafc;">{{ $evidence->title ?? 'Untitled Exhibit' }}</div>
                                            <div style="font-size: 0.72rem; color: #64748b;">ID #{{ substr(md5($evidence->id ?? '1'), 0, 8) }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div style="max-width: 320px; font-size: 0.8125rem; color: #94a3b8; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                        {{ $evidence->description ?? 'No contextual notes recorded.' }}
                                    </div>
                                </td>
                                <td>
                                    <div style="font-size: 0.8125rem; color: #e2e8f0;">
                                        {{ $evidence->created_at ? $evidence->created_at->format('d M Y') : 'Recent' }}
                                    </div>
                                    <div style="font-size: 0.72rem; color: #64748b;">
                                        {{ $evidence->created_at ? $evidence->created_at->format('H:i:s T') : 'UTC' }}
                                    </div>
                                </td>
                                <td>
                                    @if(($evidence->status ?? '') === 'approved')
                                        <span class="court-badge court-badge--verified">
                                            <i class="ti ti-shield-check"></i> Admissible
                                        </span>
                                    @elseif(($evidence->status ?? '') === 'rejected')
                                        <span class="court-badge" style="background: rgba(239, 68, 68, 0.15); color: #f87171; border: 1px solid rgba(239, 68, 68, 0.35);">
                                            <i class="ti ti-circle-x"></i> Inadmissible
                                        </span>
                                    @else
                                        <span class="court-badge court-badge--pending">
                                            <i class="ti ti-clock"></i> In Custody
                                        </span>
                                    @endif
                                </td>
                                <td style="text-align: right;">
                                    <a href="{{ route('evidence.show', $evidence->id) }}" class="btn-gold-ghost" style="padding: 0.35rem 0.85rem; font-size: 0.775rem;">
                                        <i class="ti ti-eye"></i> Inspect
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div style="text-align: center; padding: 4.5rem 2rem;">
                    <div style="width: 64px; height: 64px; border-radius: 16px; background: rgba(245, 158, 11, 0.1); border: 1.5px solid rgba(245, 158, 11, 0.25); display: flex; align-items: center; justify-content: center; font-size: 2rem; color: #fbbf24; margin: 0 auto 1.25rem;">
                        <i class="ti ti-folder-plus"></i>
                    </div>
                    <h3 style="font-size: 1.25rem; font-weight: 700; color: #f1f5f9; margin-bottom: 0.5rem; font-family: var(--font-display);">
                        No Exhibits Currently Filed
                    </h3>
                    <p style="font-size: 0.85rem; color: #94a3b8; max-width: 440px; margin: 0 auto 1.75rem;">
                        Initialize your evidence chain of custody by uploading your first photographic, video, or documentary exhibit.
                    </p>
                    <a href="{{ route('upload') }}" class="btn-gold-solid" style="padding: 0.75rem 1.75rem;">
                        <i class="ti ti-cloud-upload"></i>
                        <span>Upload First Exhibit</span>
                    </a>
                </div>
            @endif
        </section>
    </div>

    <!-- Judicial Footer -->
    <footer style="border-top: 1px solid rgba(245, 158, 11, 0.18); background: rgba(6, 9, 17, 0.95); padding: 2rem 1.5rem; text-align: center; font-size: 0.8rem; color: #64748b;">
        <div style="max-width: 1380px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
            <div>&copy; {{ date('Y') }} eWitnessVault &mdash; Sovereign Judicial Evidence Registry.</div>
            <div style="display: flex; gap: 1rem; align-items: center;">
                <span style="color: #10b981;"><i class="ti ti-lock"></i> 256-Bit Vault Sealed</span>
                <span>Powered by <strong style="color: #fbbf24;">TinkaTech</strong></span>
            </div>
        </div>
    </footer>
</body>
</html>