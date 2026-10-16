@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&family=Cinzel:wght@600;700&display=swap');

    * { box-sizing: border-box; }

    .cases-page {
        min-height: 100vh;
        background: #070a12;
        font-family: 'Outfit', sans-serif;
        padding: 2rem 1.5rem 4rem;
    }

    .cases-container {
        max-width: 1280px;
        margin: 0 auto;
    }

    /* Header */
    .cases-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        flex-wrap: wrap;
        gap: 1.5rem;
        margin-bottom: 2.5rem;
    }

    .cases-header-left .page-label {
        font-size: 0.7rem;
        font-weight: 700;
        letter-spacing: 0.18em;
        color: #a78bfa;
        text-transform: uppercase;
        margin-bottom: 0.35rem;
    }

    .cases-header-left h1 {
        font-family: 'Cinzel', serif;
        font-size: 2rem;
        font-weight: 700;
        color: #f1f5f9;
        margin: 0 0 0.5rem;
        line-height: 1.2;
    }

    .cases-header-left p {
        color: #64748b;
        font-size: 0.9rem;
        margin: 0;
    }

    .btn-open-case {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.65rem 1.5rem;
        background: linear-gradient(135deg, #7c3aed, #a855f7);
        color: white;
        font-family: 'Outfit', sans-serif;
        font-weight: 700;
        font-size: 0.9rem;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        text-decoration: none;
        box-shadow: 0 4px 20px rgba(124, 58, 237, 0.4);
        transition: all 0.25s ease;
        white-space: nowrap;
    }

    .btn-open-case:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 30px rgba(124, 58, 237, 0.6);
    }

    /* Stats Strip */
    .stats-strip {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
        gap: 1rem;
        margin-bottom: 2.5rem;
    }

    .stat-card {
        background: rgba(16, 23, 38, 0.7);
        border: 1px solid rgba(71, 85, 105, 0.3);
        border-radius: 12px;
        padding: 1rem 1.25rem;
        text-align: center;
    }

    .stat-card .stat-num {
        font-size: 1.75rem;
        font-weight: 800;
        color: #c084fc;
        line-height: 1;
        margin-bottom: 0.3rem;
    }

    .stat-card .stat-label {
        font-size: 0.75rem;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        font-weight: 600;
    }

    /* Filter bar */
    .filter-bar {
        display: flex;
        gap: 0.5rem;
        margin-bottom: 2rem;
        flex-wrap: wrap;
    }

    .filter-btn {
        padding: 0.4rem 1rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        border: 1px solid rgba(71, 85, 105, 0.4);
        background: transparent;
        color: #64748b;
        cursor: pointer;
        font-family: 'Outfit', sans-serif;
        transition: all 0.2s;
    }

    .filter-btn.active,
    .filter-btn:hover {
        background: rgba(168, 85, 247, 0.15);
        border-color: rgba(168, 85, 247, 0.4);
        color: #c084fc;
    }

    /* Cases Grid */
    .cases-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
        gap: 1.5rem;
    }

    .case-card {
        background: rgba(12, 18, 32, 0.85);
        border: 1px solid rgba(71, 85, 105, 0.25);
        border-radius: 16px;
        padding: 1.5rem;
        transition: all 0.25s ease;
        position: relative;
        overflow: hidden;
        cursor: pointer;
        text-decoration: none;
        display: block;
    }

    .case-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 2px;
        background: linear-gradient(90deg, #7c3aed, #a855f7, transparent);
        opacity: 0;
        transition: opacity 0.25s;
    }

    .case-card:hover {
        border-color: rgba(168, 85, 247, 0.35);
        box-shadow: 0 8px 30px rgba(124, 58, 237, 0.2);
        transform: translateY(-2px);
    }

    .case-card:hover::before {
        opacity: 1;
    }

    .case-card-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .case-number {
        font-size: 0.7rem;
        font-weight: 700;
        letter-spacing: 0.12em;
        color: #a78bfa;
        text-transform: uppercase;
        margin-bottom: 0.3rem;
    }

    .case-title {
        font-size: 1rem;
        font-weight: 700;
        color: #f1f5f9;
        line-height: 1.35;
    }

    .status-badge {
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        white-space: nowrap;
        flex-shrink: 0;
    }

    .case-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 0.85rem;
        margin-bottom: 1rem;
    }

    .meta-item {
        display: flex;
        align-items: center;
        gap: 0.4rem;
        font-size: 0.78rem;
        color: #64748b;
    }

    .meta-item i {
        font-size: 0.9rem;
        color: #7c3aed;
    }

    .case-desc {
        font-size: 0.83rem;
        color: #94a3b8;
        line-height: 1.6;
        margin-bottom: 1.1rem;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .case-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 1rem;
        border-top: 1px solid rgba(71, 85, 105, 0.2);
    }

    .evidence-count {
        display: flex;
        align-items: center;
        gap: 0.4rem;
        font-size: 0.8rem;
        font-weight: 600;
        color: #7c3aed;
    }

    .evidence-thumbs {
        display: flex;
        gap: -4px;
    }

    .thumb-dot {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background: linear-gradient(135deg, #7c3aed, #a855f7);
        border: 2px solid #070a12;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.6rem;
        font-weight: 700;
        color: white;
        margin-left: -6px;
    }

    .thumb-dot:first-child {
        margin-left: 0;
    }

    /* Empty state */
    .empty-state {
        grid-column: 1 / -1;
        text-align: center;
        padding: 5rem 2rem;
        background: rgba(12, 18, 32, 0.5);
        border: 1px dashed rgba(124, 58, 237, 0.25);
        border-radius: 20px;
    }

    .empty-icon {
        width: 80px;
        height: 80px;
        margin: 0 auto 1.5rem;
        border-radius: 20px;
        background: rgba(124, 58, 237, 0.1);
        border: 1px solid rgba(124, 58, 237, 0.25);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        color: #7c3aed;
    }

    .empty-state h3 {
        font-size: 1.2rem;
        font-weight: 700;
        color: #f1f5f9;
        margin: 0 0 0.5rem;
    }

    .empty-state p {
        font-size: 0.875rem;
        color: #64748b;
        margin: 0 0 1.5rem;
    }

    /* Alert */
    .flash-alert {
        padding: 1rem 1.25rem;
        border-radius: 10px;
        font-size: 0.875rem;
        font-weight: 600;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.6rem;
    }

    .flash-alert.success {
        background: rgba(34, 197, 94, 0.1);
        border: 1px solid rgba(34, 197, 94, 0.3);
        color: #4ade80;
    }

    @media (max-width: 640px) {
        .cases-header { flex-direction: column; }
        .cases-grid { grid-template-columns: 1fr; }
    }
</style>

<div class="cases-page">
    <div class="cases-container">

        @if(session('success'))
        <div class="flash-alert success">
            <i class="ti ti-circle-check" style="font-size: 1.1rem;"></i>
            {{ session('success') }}
        </div>
        @endif

        <!-- Page Header -->
        <div class="cases-header">
            <div class="cases-header-left">
                <div class="page-label">
                    <i class="ti ti-briefcase"></i> Case Docket Registry
                </div>
                <h1>Legal Case Dockets</h1>
                <p>Bundle and organise related evidence exhibits into structured case deposits for judicial analysis.</p>
            </div>
            @if(Auth::user()->hasAnyRole(['Lawyer', 'Admin']))
            <a href="{{ route('cases.create') }}" class="btn-open-case">
                <i class="ti ti-folder-plus"></i>
                Open New Docket
            </a>
            @endif
        </div>

        <!-- Stats Strip -->
        @php
            $totalCases    = $cases->total();
            $openCases     = $cases->getCollection()->where('status', 'open')->count();
            $reviewCases   = $cases->getCollection()->where('status', 'under_review')->count();
            $closedCases   = $cases->getCollection()->where('status', 'closed')->count();
        @endphp
        <div class="stats-strip">
            <div class="stat-card">
                <div class="stat-num">{{ $totalCases }}</div>
                <div class="stat-label">Total Dockets</div>
            </div>
            <div class="stat-card">
                <div class="stat-num" style="color: #4ade80;">{{ $cases->getCollection()->where('status', 'open')->count() }}</div>
                <div class="stat-label">Open</div>
            </div>
            <div class="stat-card">
                <div class="stat-num" style="color: #fbbf24;">{{ $cases->getCollection()->where('status', 'under_review')->count() }}</div>
                <div class="stat-label">Under Review</div>
            </div>
            <div class="stat-card">
                <div class="stat-num" style="color: #94a3b8;">{{ $cases->getCollection()->where('status', 'closed')->count() + $cases->getCollection()->where('status', 'archived')->count() }}</div>
                <div class="stat-label">Closed / Archived</div>
            </div>
            <div class="stat-card">
                <div class="stat-num">{{ $cases->getCollection()->sum(fn($c) => $c->evidence->count()) }}</div>
                <div class="stat-label">Total Exhibits</div>
            </div>
        </div>

        <!-- Cases Grid -->
        <div class="cases-grid">
            @forelse($cases as $case)
            @php
                $statusColor = match($case->status) {
                    'open'         => ['bg' => 'rgba(34,197,94,0.12)',  'text' => '#4ade80',  'border' => 'rgba(34,197,94,0.3)'],
                    'under_review' => ['bg' => 'rgba(245,158,11,0.12)', 'text' => '#fbbf24',  'border' => 'rgba(245,158,11,0.3)'],
                    'closed'       => ['bg' => 'rgba(100,116,139,0.12)','text' => '#94a3b8',  'border' => 'rgba(100,116,139,0.3)'],
                    'archived'     => ['bg' => 'rgba(71,85,105,0.12)',  'text' => '#64748b',  'border' => 'rgba(71,85,105,0.3)'],
                    default        => ['bg' => 'rgba(100,116,139,0.12)','text' => '#94a3b8',  'border' => 'rgba(100,116,139,0.3)'],
                };
                $evidenceCount = $case->evidence->count();
            @endphp
            <a href="{{ route('cases.show', $case->id) }}" class="case-card">
                <div class="case-card-header">
                    <div>
                        <div class="case-number">{{ $case->case_number }}</div>
                        <div class="case-title">{{ $case->title }}</div>
                    </div>
                    <span class="status-badge" style="background: {{ $statusColor['bg'] }}; color: {{ $statusColor['text'] }}; border: 1px solid {{ $statusColor['border'] }};">
                        {{ $case->statusLabel() }}
                    </span>
                </div>

                @if($case->description)
                <p class="case-desc">{{ $case->description }}</p>
                @endif

                <div class="case-meta">
                    <div class="meta-item">
                        <i class="ti ti-user"></i>
                        <span>{{ $case->lawyer->name }}</span>
                    </div>
                    @if($case->court_reference)
                    <div class="meta-item">
                        <i class="ti ti-hash"></i>
                        <span>{{ $case->court_reference }}</span>
                    </div>
                    @endif
                    @if($case->assignedJudge)
                    <div class="meta-item" style="color: #fbbf24;">
                        <i class="ti ti-gavel" style="color: #fbbf24;"></i>
                        <span>Judge: {{ $case->assignedJudge->name }}</span>
                    </div>
                    @elseif(Auth::user()->hasAnyRole(['Lawyer', 'Admin']))
                    <div class="meta-item" style="color: #475569;">
                        <i class="ti ti-gavel"></i>
                        <span>Not assigned</span>
                    </div>
                    @endif
                    @if($case->hearing_date)
                    <div class="meta-item">
                        <i class="ti ti-calendar-event"></i>
                        <span>{{ $case->hearing_date->format('d M Y') }}</span>
                    </div>
                    @endif
                    <div class="meta-item">
                        <i class="ti ti-clock"></i>
                        <span>{{ $case->created_at->diffForHumans() }}</span>
                    </div>
                </div>

                <div class="case-footer">
                    <div class="evidence-count">
                        <i class="ti ti-files" style="font-size: 1rem;"></i>
                        {{ $evidenceCount }} Exhibit{{ $evidenceCount !== 1 ? 's' : '' }}
                    </div>
                    <div style="display: flex; align-items: center; gap: 0.4rem; font-size: 0.78rem; color: #7c3aed; font-weight: 600;">
                        View Docket
                        <i class="ti ti-arrow-right" style="font-size: 0.85rem;"></i>
                    </div>
                </div>
            </a>
            @empty
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="ti ti-folders"></i>
                </div>
                <h3>No Case Dockets Found</h3>
                <p>
                    @if(Auth::user()->hasAnyRole(['Lawyer', 'Admin']))
                        Open your first case docket to begin organising evidence exhibits.
                    @else
                        No case dockets have been created yet.
                    @endif
                </p>
                @if(Auth::user()->hasAnyRole(['Lawyer', 'Admin']))
                <a href="{{ route('cases.create') }}" class="btn-open-case">
                    <i class="ti ti-folder-plus"></i>
                    Open First Docket
                </a>
                @endif
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($cases->hasPages())
        <div style="margin-top: 2rem; display: flex; justify-content: center;">
            {{ $cases->links() }}
        </div>
        @endif

    </div>
</div>
@endsection
