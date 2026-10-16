<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Evidence Vault Registry | eWitnessVault</title>

    <!-- Favicon — matching nav header gold scales crest -->
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 64 64'%3E%3Cdefs%3E%3ClinearGradient id='b' x1='0%25' y1='0%25' x2='100%25' y2='100%25'%3E%3Cstop offset='0%25' stop-color='%23141a2e'/%3E%3Cstop offset='100%25' stop-color='%23050811'/%3E%3C/linearGradient%3E%3C/defs%3E%3Crect x='2' y='2' width='60' height='60' rx='14' fill='url(%23b)'/%3E%3Crect x='2' y='2' width='60' height='60' rx='14' fill='none' stroke='%23fbbf24' stroke-width='2.5'/%3E%3Cg transform='translate(10,10) scale(1.833)' stroke='%23fbbf24' stroke-width='2.2' stroke-linecap='round' stroke-linejoin='round' fill='none'%3E%3Cpath d='M7 20h10'/%3E%3Cpath d='M6 6l6-1 6 1'/%3E%3Cpath d='M12 5v15'/%3E%3Cpath d='M9 11l-3-6-3 6a3 3 0 0 0 6 0'/%3E%3Cpath d='M21 11l-3-6-3 6a3 3 0 0 0 6 0'/%3E%3C/g%3E%3C/svg%3E">
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <link rel="apple-touch-icon" href="{{ asset('favicon.png') }}">

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

        .registry-wrapper {
            max-width: 1380px;
            margin: 0 auto;
            padding: 2.5rem 1.5rem 5rem;
        }

        .registry-header-banner {
            background: linear-gradient(135deg, rgba(16, 24, 40, 0.95) 0%, rgba(12, 17, 29, 0.92) 50%, rgba(20, 16, 5, 0.95) 100%);
            border: 1.5px solid var(--gold-border);
            border-radius: 20px;
            padding: 2.25rem 2rem;
            margin-bottom: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1.5rem;
            box-shadow: 0 15px 45px rgba(0, 0, 0, 0.5), var(--gold-glow);
            position: relative;
            overflow: hidden;
        }

        .registry-header-banner::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; height: 3px;
            background: linear-gradient(90deg, transparent, #fbbf24, transparent);
        }

        .registry-main-card {
            background: rgba(14, 20, 36, 0.85);
            backdrop-filter: blur(24px);
            border: 1.5px solid var(--gold-border);
            border-radius: 22px;
            overflow: hidden;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.6);
        }

        .registry-topbar {
            padding: 1.5rem 2rem;
            border-bottom: 1px solid rgba(71, 85, 105, 0.3);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
            background: rgba(245, 158, 11, 0.03);
        }

        .table-judicial {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        .table-judicial th {
            padding: 1rem 1.5rem;
            background: rgba(8, 12, 22, 0.85);
            font-size: 0.72rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #94a3b8;
            border-bottom: 1px solid rgba(71, 85, 105, 0.3);
        }

        .table-judicial td {
            padding: 1.2rem 1.5rem;
            border-bottom: 1px solid rgba(71, 85, 105, 0.18);
            color: #cbd5e1;
            font-size: 0.875rem;
            vertical-align: middle;
        }

        .table-judicial tr:hover td {
            background: rgba(245, 158, 11, 0.04);
        }

        .hash-tag {
            font-family: var(--font-mono);
            font-size: 0.75rem;
            color: #fbbf24;
            background: rgba(245, 158, 11, 0.08);
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            border: 1px solid rgba(245, 158, 11, 0.2);
            display: inline-block;
        }

        .status-badge-verified {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            padding: 0.25rem 0.65rem;
            border-radius: 50px;
            font-size: 0.72rem;
            font-weight: 700;
            text-transform: uppercase;
            background: rgba(16, 185, 129, 0.15);
            color: #34d399;
            border: 1px solid rgba(16, 185, 129, 0.35);
        }

        @media (max-width: 860px) {
            .desktop-view { display: none !important; }
            .mobile-view { display: block !important; }
        }
        @media (min-width: 861px) {
            .desktop-view { display: block !important; }
            .mobile-view { display: none !important; }
        }
    </style>
</head>
<body class="dashboard-body">
    <!-- Background overlay -->
    <div class="dashboard-background"></div>

    <!-- Navigation Header -->
    @include('layouts.dashboard-nav')

    <div class="registry-wrapper">
        <!-- Banner Header -->
        <header class="registry-header-banner">
            <div>
                <div style="font-size: 0.72rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.1em; color: #fbbf24; margin-bottom: 0.35rem;">
                    Sovereign Judicial Registry
                </div>
                <h1 style="font-family: var(--font-display); font-size: 1.85rem; font-weight: 800; color: #ffffff;">
                    Court Evidence Archive & Custody Log
                </h1>
                <p style="font-size: 0.85rem; color: #94a3b8;">
                    All items below maintain full chain of custody continuity with cryptographic SHA-256 integrity verification.
                </p>
            </div>
            <div style="display: flex; gap: 0.75rem; align-items: center;">
                <a href="{{ route('upload') }}" class="btn-gold-solid" style="padding: 0.65rem 1.4rem;">
                    <i class="ti ti-plus"></i>
                    <span>File New Exhibit</span>
                </a>
            </div>
        </header>

        <!-- Main Card -->
        <div class="registry-main-card">
            <div class="registry-topbar">
                <div style="display: flex; align-items: center; gap: 0.75rem;">
                    <div style="width: 38px; height: 38px; border-radius: 10px; background: rgba(245, 158, 11, 0.12); border: 1px solid var(--gold-border); display: flex; align-items: center; justify-content: center; color: #fbbf24;">
                        <i class="ti ti-archive" style="font-size: 1.2rem;"></i>
                    </div>
                    <div>
                        <div style="font-size: 1rem; font-weight: 700; color: #ffffff;">
                            @if(Auth::user()->hasAnyRole(['Admin', 'Judge', 'Lawyer']))
                                Master Evidentiary Ledger
                            @else
                                My Registered Evidence Exhibits
                            @endif
                        </div>
                        <div style="font-size: 0.78rem; color: #64748b;">
                            {{ $evidenceList->total() ?? $evidenceList->count() }} Sealed Record{{ ($evidenceList->total() ?? $evidenceList->count()) !== 1 ? 's' : '' }} in Archive
                        </div>
                    </div>
                </div>

                <div>
                    <a href="{{ route('upload') }}" class="btn-gold-ghost" style="padding: 0.45rem 1rem; font-size: 0.8rem;">
                        <i class="ti ti-cloud-upload"></i>
                        <span>Upload Artifact</span>
                    </a>
                </div>
            </div>

            @if($evidenceList->count() > 0)
                <!-- Desktop Table View -->
                <div class="desktop-view" style="overflow-x: auto;">
                    <table class="table-judicial">
                        <thead>
                            <tr>
                                <th>Exhibit Identification</th>
                                <th>Contextual Narrative</th>
                                @if(Auth::user()->hasAnyRole(['Admin', 'Judge', 'Lawyer']))
                                    <th>Filing Deponent</th>
                                @endif
                                <th>Date & Time</th>
                                <th>Integrity</th>
                                <th style="text-align: right;">Judicial Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($evidenceList as $evidence)
                            <tr>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                                        <div style="width: 36px; height: 36px; border-radius: 8px; background: rgba(245, 158, 11, 0.1); border: 1px solid rgba(245, 158, 11, 0.25); display: flex; align-items: center; justify-content: center; color: #fbbf24; flex-shrink: 0;">
                                            <i class="ti ti-file-certificate"></i>
                                        </div>
                                        <div>
                                            <div style="font-weight: 700; color: #f8fafc;">{{ $evidence->title }}</div>
                                            <span class="hash-tag">{{ substr($evidence->file_hash, 0, 12) }}...</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div style="max-width: 280px; font-size: 0.825rem; color: #94a3b8; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                        {{ $evidence->description ?? 'No narrative submitted.' }}
                                    </div>
                                </td>
                                @if(Auth::user()->hasAnyRole(['Admin', 'Judge', 'Lawyer']))
                                <td>
                                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                                        <div style="width: 26px; height: 26px; border-radius: 50%; background: linear-gradient(135deg, #f59e0b, #b45309); display: flex; align-items: center; justify-content: center; font-size: 0.68rem; font-weight: 800; color: white;">
                                            {{ strtoupper(substr($evidence->user->name ?? 'U', 0, 1)) }}
                                        </div>
                                        <span style="font-size: 0.825rem; color: #cbd5e1;">{{ $evidence->user->name ?? 'Sworn Deponent' }}</span>
                                    </div>
                                </td>
                                @endif
                                <td>
                                    <div style="font-size: 0.825rem; color: #e2e8f0;">{{ $evidence->created_at->format('d M Y') }}</div>
                                    <div style="font-size: 0.72rem; color: #64748b;">{{ $evidence->created_at->format('H:i T') }}</div>
                                </td>
                                <td>
                                    <span class="status-badge-verified">
                                        <i class="ti ti-shield-check"></i> Sealed
                                    </span>
                                </td>
                                <td style="text-align: right;">
                                    <a href="{{ route('evidence.show', $evidence->id) }}" class="btn-gold-ghost" style="padding: 0.35rem 0.85rem; font-size: 0.78rem;">
                                        <i class="ti ti-eye"></i> Inspect Exhibit
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Mobile Cards View -->
                <div class="mobile-view" style="display: flex; flex-direction: column; gap: 1px; background: rgba(71, 85, 105, 0.15);">
                    @foreach($evidenceList as $evidence)
                    <div style="padding: 1.25rem; background: rgba(10, 15, 26, 0.85); border-bottom: 1px solid rgba(71, 85, 105, 0.2);">
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 0.5rem;">
                            <div style="font-weight: 700; color: #ffffff; font-size: 0.95rem;">{{ $evidence->title }}</div>
                            <span class="status-badge-verified"><i class="ti ti-shield-check"></i> Sealed</span>
                        </div>
                        <p style="font-size: 0.8rem; color: #94a3b8; margin-bottom: 0.75rem; line-height: 1.4;">
                            {{ Str::limit($evidence->description ?? 'No narrative submitted.', 80) }}
                        </p>
                        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 0.5rem;">
                            <span class="hash-tag">{{ substr($evidence->file_hash, 0, 12) }}...</span>
                            <a href="{{ route('evidence.show', $evidence->id) }}" class="btn-gold-solid" style="padding: 0.35rem 0.85rem; font-size: 0.75rem;">
                                Inspect &rarr;
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Pagination if Paginated -->
                @if(method_exists($evidenceList, 'links'))
                    <div style="padding: 1.25rem 2rem; border-top: 1px solid rgba(71, 85, 105, 0.25); background: rgba(8, 12, 22, 0.5);">
                        {{ $evidenceList->links() }}
                    </div>
                @endif
            @else
                <div style="text-align: center; padding: 4.5rem 2rem;">
                    <div style="width: 60px; height: 60px; border-radius: 14px; background: rgba(245, 158, 11, 0.1); border: 1.5px solid var(--gold-border); display: flex; align-items: center; justify-content: center; font-size: 1.8rem; color: #fbbf24; margin: 0 auto 1.25rem;">
                        <i class="ti ti-archive"></i>
                    </div>
                    <h3 style="font-size: 1.25rem; font-weight: 800; color: #f1f5f9; margin-bottom: 0.4rem; font-family: var(--font-display);">
                        No Evidence Records in Vault
                    </h3>
                    <p style="font-size: 0.85rem; color: #94a3b8; max-width: 440px; margin: 0 auto 1.75rem;">
                        There are no electronic exhibits filed under your current authorization scope.
                    </p>
                    <a href="{{ route('upload') }}" class="btn-gold-solid" style="padding: 0.75rem 1.6rem;">
                        <i class="ti ti-cloud-upload"></i>
                        <span>File First Evidence Exhibit</span>
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Judicial Footer -->
    <footer style="border-top: 1px solid rgba(245, 158, 11, 0.18); background: rgba(6, 9, 17, 0.95); padding: 2rem 1.5rem; text-align: center; font-size: 0.8rem; color: #64748b;">
        <div style="max-width: 1380px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
            <div>&copy; {{ date('Y') }} eWitnessVault &mdash; Sovereign Judicial Evidence Registry.</div>
            <div style="display: flex; gap: 1rem; align-items: center;">
                <span style="color: #10b981;"><i class="ti ti-shield-check"></i> 256-Bit Vault Sealed</span>
                <span>Powered by <strong style="color: #fbbf24;">TinkaTech</strong></span>
            </div>
        </div>
    </footer>
</body>
</html>
