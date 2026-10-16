@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&family=Cinzel:wght@600;700&display=swap');

    * { box-sizing: border-box; }

    .show-page {
        min-height: 100vh;
        background: #070a12;
        font-family: 'Outfit', sans-serif;
        padding: 2rem 1.5rem 5rem;
    }

    .show-container { max-width: 1280px; margin: 0 auto; }

    /* Breadcrumb */
    .breadcrumb {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.8rem;
        color: #64748b;
        margin-bottom: 1.75rem;
    }
    .breadcrumb a { color: #94a3b8; text-decoration: none; }
    .breadcrumb a:hover { color: #c084fc; }

    /* Case Hero */
    .case-hero {
        background: rgba(12, 18, 32, 0.9);
        border: 1px solid rgba(124, 58, 237, 0.2);
        border-radius: 20px;
        padding: 2rem;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
    }

    .case-hero::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 3px;
        background: linear-gradient(90deg, #7c3aed, #a855f7, #c084fc);
    }

    .hero-top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        flex-wrap: wrap;
        gap: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .case-docket-num {
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 0.15em;
        color: #a78bfa;
        text-transform: uppercase;
        margin-bottom: 0.4rem;
    }

    .case-hero-title {
        font-family: 'Cinzel', serif;
        font-size: 1.65rem;
        font-weight: 700;
        color: #f1f5f9;
        margin: 0;
        line-height: 1.3;
    }

    .hero-actions {
        display: flex;
        gap: 0.65rem;
        flex-wrap: wrap;
        flex-shrink: 0;
    }

    .btn-action {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0.5rem 1.1rem;
        border-radius: 9px;
        font-family: 'Outfit', sans-serif;
        font-size: 0.82rem;
        font-weight: 700;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.2s;
        border: 1px solid;
    }

    .btn-edit {
        background: rgba(124, 58, 237, 0.12);
        color: #c084fc;
        border-color: rgba(124, 58, 237, 0.3);
    }

    .btn-edit:hover {
        background: rgba(124, 58, 237, 0.22);
        border-color: rgba(124, 58, 237, 0.5);
    }

    .btn-delete {
        background: rgba(239, 68, 68, 0.1);
        color: #f87171;
        border-color: rgba(239, 68, 68, 0.25);
    }

    .btn-delete:hover {
        background: rgba(239, 68, 68, 0.18);
        border-color: rgba(239, 68, 68, 0.4);
    }

    /* Status Badge */
    .status-badge {
        padding: 0.3rem 0.9rem;
        border-radius: 20px;
        font-size: 0.72rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        border: 1px solid;
    }

    /* Meta row */
    .hero-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 1.5rem;
        padding-top: 1.25rem;
        border-top: 1px solid rgba(71, 85, 105, 0.2);
    }

    .meta-pill {
        display: flex;
        align-items: center;
        gap: 0.45rem;
        font-size: 0.82rem;
        color: #94a3b8;
    }

    .meta-pill i { color: #7c3aed; font-size: 1rem; }
    .meta-pill strong { color: #f1f5f9; }

    /* Layout grid */
    .content-grid {
        display: grid;
        grid-template-columns: 1fr 340px;
        gap: 1.5rem;
        align-items: start;
    }

    /* Section card */
    .section-card {
        background: rgba(12, 18, 32, 0.85);
        border: 1px solid rgba(71, 85, 105, 0.25);
        border-radius: 16px;
        overflow: hidden;
        margin-bottom: 1.5rem;
    }

    .section-header {
        padding: 1.1rem 1.5rem;
        border-bottom: 1px solid rgba(71, 85, 105, 0.2);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
    }

    .section-header-left {
        display: flex;
        align-items: center;
        gap: 0.65rem;
    }

    .section-icon {
        width: 34px;
        height: 34px;
        border-radius: 9px;
        background: rgba(124, 58, 237, 0.12);
        border: 1px solid rgba(124, 58, 237, 0.25);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #a78bfa;
        font-size: 1rem;
    }

    .section-title {
        font-size: 0.95rem;
        font-weight: 700;
        color: #f1f5f9;
        margin: 0;
    }

    .section-sub {
        font-size: 0.75rem;
        color: #64748b;
        margin: 0;
    }

    .section-body { padding: 1.5rem; }

    /* Exhibit row */
    .exhibit-row {
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        padding: 1rem;
        border-radius: 12px;
        border: 1px solid rgba(71, 85, 105, 0.18);
        background: rgba(7, 10, 18, 0.5);
        margin-bottom: 0.75rem;
        transition: all 0.2s;
        position: relative;
    }

    .exhibit-row:hover {
        border-color: rgba(124, 58, 237, 0.3);
        background: rgba(124, 58, 237, 0.04);
    }

    .exhibit-num {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background: rgba(124, 58, 237, 0.15);
        border: 1px solid rgba(124, 58, 237, 0.3);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.7rem;
        font-weight: 800;
        color: #c084fc;
        flex-shrink: 0;
    }

    .exhibit-icon {
        width: 42px;
        height: 42px;
        border-radius: 10px;
        background: rgba(124, 58, 237, 0.1);
        border: 1px solid rgba(124, 58, 237, 0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #a78bfa;
        font-size: 1.2rem;
        flex-shrink: 0;
    }

    .exhibit-body { flex: 1; min-width: 0; }

    .exhibit-title {
        font-size: 0.88rem;
        font-weight: 700;
        color: #f1f5f9;
        margin-bottom: 0.25rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .exhibit-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 0.65rem;
        margin-bottom: 0.5rem;
    }

    .exhibit-meta-item {
        display: flex;
        align-items: center;
        gap: 0.3rem;
        font-size: 0.73rem;
        color: #64748b;
    }

    .exhibit-meta-item i { font-size: 0.8rem; }

    .exhibit-note {
        font-size: 0.78rem;
        color: #94a3b8;
        background: rgba(124, 58, 237, 0.06);
        border: 1px solid rgba(124, 58, 237, 0.15);
        border-radius: 6px;
        padding: 0.4rem 0.6rem;
        line-height: 1.5;
        margin-top: 0.4rem;
    }

    .exhibit-actions {
        display: flex;
        gap: 0.4rem;
        flex-shrink: 0;
    }

    .exhibit-btn {
        padding: 0.35rem 0.65rem;
        border-radius: 7px;
        font-size: 0.75rem;
        font-weight: 600;
        border: 1px solid;
        cursor: pointer;
        font-family: 'Outfit', sans-serif;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        transition: all 0.2s;
        background: transparent;
    }

    .exhibit-btn-view {
        color: #a78bfa;
        border-color: rgba(124, 58, 237, 0.25);
    }

    .exhibit-btn-view:hover {
        background: rgba(124, 58, 237, 0.12);
        border-color: rgba(124, 58, 237, 0.45);
    }

    .exhibit-btn-remove {
        color: #f87171;
        border-color: rgba(239, 68, 68, 0.2);
    }

    .exhibit-btn-remove:hover {
        background: rgba(239, 68, 68, 0.1);
        border-color: rgba(239, 68, 68, 0.4);
    }

    /* Note edit inline */
    .note-form {
        margin-top: 0.5rem;
        display: none;
    }

    .note-form.open { display: block; }

    .note-input {
        width: 100%;
        background: rgba(7, 10, 18, 0.75);
        border: 1px solid rgba(124, 58, 237, 0.3);
        border-radius: 7px;
        padding: 0.45rem 0.65rem;
        font-family: 'Outfit', sans-serif;
        font-size: 0.78rem;
        color: #f1f5f9;
        outline: none;
        resize: none;
        min-height: 55px;
    }

    .note-submit-btn {
        margin-top: 0.35rem;
        padding: 0.3rem 0.8rem;
        border-radius: 7px;
        font-size: 0.75rem;
        font-weight: 700;
        background: rgba(124, 58, 237, 0.2);
        color: #c084fc;
        border: 1px solid rgba(124, 58, 237, 0.35);
        cursor: pointer;
        font-family: 'Outfit', sans-serif;
        transition: all 0.2s;
    }

    .note-submit-btn:hover { background: rgba(124, 58, 237, 0.35); }

    /* Empty exhibits */
    .exhibits-empty {
        text-align: center;
        padding: 3rem 1.5rem;
        color: #64748b;
    }

    .exhibits-empty i {
        font-size: 2.5rem;
        display: block;
        margin-bottom: 0.75rem;
        color: #334155;
    }

    /* Add Evidence Sidebar Form */
    .add-evidence-form {
        padding: 1.25rem;
    }

    .add-evidence-search {
        background: rgba(7, 10, 18, 0.75);
        border: 1px solid rgba(71, 85, 105, 0.4);
        border-radius: 9px;
        padding: 0.6rem 0.85rem;
        font-family: 'Outfit', sans-serif;
        font-size: 0.82rem;
        color: #f1f5f9;
        width: 100%;
        outline: none;
        margin-bottom: 0.85rem;
        transition: border-color 0.2s;
    }

    .add-evidence-search:focus {
        border-color: rgba(124, 58, 237, 0.5);
    }

    .add-ev-list {
        max-height: 300px;
        overflow-y: auto;
        display: flex;
        flex-direction: column;
        gap: 0.4rem;
        margin-bottom: 1rem;
    }

    .add-ev-list::-webkit-scrollbar { width: 3px; }
    .add-ev-list::-webkit-scrollbar-thumb { background: rgba(124, 58, 237, 0.4); border-radius: 2px; }

    .add-ev-item {
        display: flex;
        align-items: center;
        gap: 0.65rem;
        padding: 0.65rem 0.75rem;
        border-radius: 8px;
        border: 1px solid rgba(71, 85, 105, 0.18);
        cursor: pointer;
        transition: all 0.2s;
        user-select: none;
    }

    .add-ev-item:hover, .add-ev-item.selected {
        border-color: rgba(124, 58, 237, 0.35);
        background: rgba(124, 58, 237, 0.08);
    }

    .add-ev-item input[type="checkbox"] {
        accent-color: #7c3aed;
        width: 14px;
        height: 14px;
        flex-shrink: 0;
        margin: 0;
        padding: 0;
        border: none;
    }

    .add-ev-text {
        flex: 1;
        min-width: 0;
    }

    .add-ev-title {
        font-size: 0.78rem;
        font-weight: 700;
        color: #f1f5f9;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .add-ev-by {
        font-size: 0.68rem;
        color: #64748b;
    }

    .add-notes-area {
        width: 100%;
        background: rgba(7, 10, 18, 0.75);
        border: 1px solid rgba(71, 85, 105, 0.4);
        border-radius: 9px;
        padding: 0.6rem 0.85rem;
        font-family: 'Outfit', sans-serif;
        font-size: 0.8rem;
        color: #f1f5f9;
        outline: none;
        resize: none;
        min-height: 70px;
        margin-bottom: 0.85rem;
        transition: border-color 0.2s;
    }

    .add-notes-area:focus {
        border-color: rgba(124, 58, 237, 0.5);
    }

    .btn-add-evidence {
        width: 100%;
        padding: 0.65rem;
        border-radius: 9px;
        font-family: 'Outfit', sans-serif;
        font-size: 0.85rem;
        font-weight: 700;
        color: white;
        background: linear-gradient(135deg, #7c3aed, #a855f7);
        border: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.4rem;
        box-shadow: 0 3px 12px rgba(124, 58, 237, 0.35);
        transition: all 0.2s;
    }

    .btn-add-evidence:hover {
        box-shadow: 0 5px 20px rgba(124, 58, 237, 0.55);
        transform: translateY(-1px);
    }

    /* Summary sidebar */
    .summary-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.65rem 0;
        border-bottom: 1px solid rgba(71, 85, 105, 0.15);
        font-size: 0.83rem;
    }

    .summary-item:last-child { border-bottom: none; }

    .summary-label { color: #64748b; }

    .summary-val {
        font-weight: 700;
        color: #f1f5f9;
        text-align: right;
    }

    /* Flash */
    .flash-alert {
        padding: 0.85rem 1.1rem;
        border-radius: 10px;
        font-size: 0.85rem;
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

    .no-avail {
        text-align: center;
        font-size: 0.8rem;
        color: #475569;
        padding: 1.5rem 0;
    }

    @media (max-width: 900px) {
        .content-grid { grid-template-columns: 1fr; }
    }
</style>

<div class="show-page">
    <div class="show-container">

        @if(session('success'))
        <div class="flash-alert success">
            <i class="ti ti-circle-check" style="font-size: 1.1rem;"></i>
            {{ session('success') }}
        </div>
        @endif

        <!-- Breadcrumb -->
        <div class="breadcrumb">
            <a href="{{ route('cases.index') }}">Case Dockets</a>
            <i class="ti ti-chevron-right" style="font-size: 0.75rem;"></i>
            <span>{{ $case->case_number }}</span>
        </div>

        <!-- Case Hero -->
        @php
            $sc = match($case->status) {
                'open'         => ['bg' => 'rgba(34,197,94,0.12)',  'text' => '#4ade80',  'border' => 'rgba(34,197,94,0.3)'],
                'under_review' => ['bg' => 'rgba(245,158,11,0.12)', 'text' => '#fbbf24',  'border' => 'rgba(245,158,11,0.3)'],
                'closed'       => ['bg' => 'rgba(100,116,139,0.12)','text' => '#94a3b8',  'border' => 'rgba(100,116,139,0.3)'],
                'archived'     => ['bg' => 'rgba(71,85,105,0.12)',  'text' => '#64748b',  'border' => 'rgba(71,85,105,0.3)'],
                default        => ['bg' => 'rgba(100,116,139,0.12)','text' => '#94a3b8',  'border' => 'rgba(100,116,139,0.3)'],
            };
        @endphp

        <div class="case-hero">
            <div class="hero-top">
                <div>
                    <div class="case-docket-num">{{ $case->case_number }}</div>
                    <h1 class="case-hero-title">{{ $case->title }}</h1>
                </div>
                <div class="hero-actions">
                    <span class="status-badge" style="background: {{ $sc['bg'] }}; color: {{ $sc['text'] }}; border-color: {{ $sc['border'] }};">
                        {{ $case->statusLabel() }}
                    </span>
                    @if(Auth::user()->hasAnyRole(['Lawyer', 'Admin']) && ($case->created_by === Auth::id() || Auth::user()->hasRole('Admin')))
                    <a href="{{ route('cases.edit', $case->id) }}" class="btn-action btn-edit">
                        <i class="ti ti-edit"></i> Edit Docket
                    </a>
                    <form method="POST" action="{{ route('cases.destroy', $case->id) }}" 
                          onsubmit="return confirm('Permanently close and remove docket {{ $case->case_number }}? This cannot be undone.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-action btn-delete">
                            <i class="ti ti-trash"></i> Delete
                        </button>
                    </form>
                    @endif
                </div>
            </div>

            @if($case->description)
            <p style="color: #94a3b8; font-size: 0.9rem; line-height: 1.7; margin: 0 0 1.25rem;">{{ $case->description }}</p>
            @endif

            <div class="hero-meta">
                <div class="meta-pill">
                    <i class="ti ti-user"></i>
                    <span>Assigned to <strong>{{ $case->lawyer->name }}</strong></span>
                </div>
                @if($case->court_reference)
                <div class="meta-pill">
                    <i class="ti ti-hash"></i>
                    <span>Court Ref: <strong>{{ $case->court_reference }}</strong></span>
                </div>
                @endif
                @if($case->hearing_date)
                <div class="meta-pill">
                    <i class="ti ti-calendar-event"></i>
                    <span>Hearing: <strong>{{ $case->hearing_date->format('d M Y') }}</strong></span>
                </div>
                @endif
                <div class="meta-pill">
                    <i class="ti ti-files"></i>
                    <span><strong>{{ $case->evidence->count() }}</strong> Exhibit{{ $case->evidence->count() !== 1 ? 's' : '' }} Linked</span>
                </div>
                <div class="meta-pill">
                    <i class="ti ti-clock"></i>
                    <span>Opened {{ $case->created_at->format('d M Y') }}</span>
                </div>
            </div>
        </div>

        <!-- Content Grid -->
        <div class="content-grid">

            <!-- Left: Evidence Exhibit List -->
            <div>
                <div class="section-card">
                    <div class="section-header">
                        <div class="section-header-left">
                            <div class="section-icon"><i class="ti ti-files"></i></div>
                            <div>
                                <div class="section-title">Evidence Exhibits</div>
                                <div class="section-sub">{{ $case->evidence->count() }} item(s) aligned to this docket</div>
                            </div>
                        </div>
                    </div>
                    <div class="section-body">
                        @forelse($case->evidence as $i => $ev)
                        @php
                            $mimeIcon = match(true) {
                                str_starts_with($ev->mime_type ?? '', 'image/') => 'ti-photo',
                                str_starts_with($ev->mime_type ?? '', 'video/') => 'ti-video',
                                str_starts_with($ev->mime_type ?? '', 'audio/') => 'ti-music',
                                str_starts_with($ev->mime_type ?? '', 'application/pdf') => 'ti-file-type-pdf',
                                default => 'ti-file',
                            };
                        @endphp
                        <div class="exhibit-row" id="exhibit-{{ $ev->id }}">
                            <div class="exhibit-num">{{ $i + 1 }}</div>
                            <div class="exhibit-icon"><i class="ti {{ $mimeIcon }}"></i></div>
                            <div class="exhibit-body">
                                <div class="exhibit-title">{{ $ev->title }}</div>
                                <div class="exhibit-meta">
                                    <div class="exhibit-meta-item">
                                        <i class="ti ti-user"></i>
                                        <span>{{ $ev->user->name ?? 'Unknown' }}</span>
                                    </div>
                                    <div class="exhibit-meta-item">
                                        <i class="ti ti-calendar"></i>
                                        <span>{{ $ev->created_at->format('d M Y') }}</span>
                                    </div>
                                    @if($ev->latitude && $ev->longitude)
                                    <div class="exhibit-meta-item" style="color: #4ade80;">
                                        <i class="ti ti-map-pin"></i>
                                        <span>GPS: {{ number_format($ev->latitude, 4) }}, {{ number_format($ev->longitude, 4) }}</span>
                                    </div>
                                    @endif
                                    @if($ev->pivot->added_by)
                                    <div class="exhibit-meta-item" style="color: #a78bfa;">
                                        <i class="ti ti-link"></i>
                                        <span>Added {{ \Carbon\Carbon::parse($ev->pivot->created_at)->diffForHumans() }}</span>
                                    </div>
                                    @endif
                                </div>

                                @if($ev->pivot->notes)
                                <div class="exhibit-note">
                                    <i class="ti ti-notes" style="font-size: 0.8rem; color: #7c3aed; margin-right: 4px;"></i>
                                    {{ $ev->pivot->notes }}
                                </div>
                                @endif

                                <!-- Inline note form -->
                                @if(Auth::user()->hasAnyRole(['Lawyer', 'Admin']) && ($case->created_by === Auth::id() || Auth::user()->hasRole('Admin')))
                                <div class="note-form" id="noteForm-{{ $ev->id }}">
                                    <form method="POST" action="{{ route('cases.evidence.notes', [$case->id, $ev->id]) }}">
                                        @csrf
                                        @method('PATCH')
                                        <textarea class="note-input" name="notes" 
                                                  placeholder="Add case notes about this exhibit...">{{ $ev->pivot->notes }}</textarea>
                                        <button type="submit" class="note-submit-btn">
                                            <i class="ti ti-check"></i> Save Notes
                                        </button>
                                    </form>
                                </div>
                                @endif
                            </div>

                            <div class="exhibit-actions">
                                <a href="{{ route('evidence.show', $ev->id) }}" class="exhibit-btn exhibit-btn-view" title="View Exhibit">
                                    <i class="ti ti-eye"></i>
                                </a>
                                @if(Auth::user()->hasAnyRole(['Lawyer', 'Admin']) && ($case->created_by === Auth::id() || Auth::user()->hasRole('Admin')))
                                <button class="exhibit-btn exhibit-btn-view" title="Add / Edit Notes"
                                        onclick="toggleNoteForm({{ $ev->id }})">
                                    <i class="ti ti-notes"></i>
                                </button>
                                <form method="POST" 
                                      action="{{ route('cases.evidence.remove', [$case->id, $ev->id]) }}"
                                      onsubmit="return confirm('Remove this exhibit from the docket?')"
                                      style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="exhibit-btn exhibit-btn-remove" title="Remove from Docket">
                                        <i class="ti ti-unlink"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </div>
                        @empty
                        <div class="exhibits-empty">
                            <i class="ti ti-files"></i>
                            <p style="margin: 0 0 0.3rem; font-size: 0.9rem; font-weight: 600; color: #94a3b8;">No exhibits linked yet</p>
                            <p style="font-size: 0.8rem; margin: 0;">
                                @if(Auth::user()->hasAnyRole(['Lawyer', 'Admin']))
                                    Use the panel on the right to add evidence exhibits to this docket.
                                @else
                                    No evidence has been aligned to this docket yet.
                                @endif
                            </p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Right: Sidebar -->
            <div>
                <!-- Docket Summary -->
                <div class="section-card" style="margin-bottom: 1.5rem;">
                    <div class="section-header">
                        <div class="section-header-left">
                            <div class="section-icon"><i class="ti ti-chart-pie"></i></div>
                            <div>
                                <div class="section-title">Docket Summary</div>
                            </div>
                        </div>
                    </div>
                    <div style="padding: 1.25rem;">
                        <div class="summary-item">
                            <span class="summary-label">Total Exhibits</span>
                            <span class="summary-val" style="color: #c084fc;">{{ $case->evidence->count() }}</span>
                        </div>
                        <div class="summary-item">
                            <span class="summary-label">Images</span>
                            <span class="summary-val">{{ $case->evidence->filter(fn($e) => str_starts_with($e->mime_type ?? '', 'image/'))->count() }}</span>
                        </div>
                        <div class="summary-item">
                            <span class="summary-label">Videos</span>
                            <span class="summary-val">{{ $case->evidence->filter(fn($e) => str_starts_with($e->mime_type ?? '', 'video/'))->count() }}</span>
                        </div>
                        <div class="summary-item">
                            <span class="summary-label">Documents</span>
                            <span class="summary-val">{{ $case->evidence->filter(fn($e) => str_starts_with($e->mime_type ?? '', 'application/'))->count() }}</span>
                        </div>
                        <div class="summary-item">
                            <span class="summary-label">GPS-Tagged</span>
                            <span class="summary-val" style="color: #4ade80;">{{ $case->evidence->filter(fn($e) => $e->latitude && $e->longitude)->count() }}</span>
                        </div>
                        @if($case->hearing_date)
                        <div class="summary-item">
                            <span class="summary-label">Days to Hearing</span>
                            <span class="summary-val" style="color: #fbbf24;">
                                {{ max(0, now()->diffInDays($case->hearing_date, false)) }}
                            </span>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Judge Assignment Panel (Lawyer/Admin only) -->
                @if(Auth::user()->hasAnyRole(['Lawyer', 'Admin']) && ($case->created_by === Auth::id() || Auth::user()->hasRole('Admin')))
                <div class="section-card" style="margin-bottom: 1.5rem;">
                    <div class="section-header">
                        <div class="section-header-left">
                            <div class="section-icon" style="background: rgba(245,158,11,0.12); border-color: rgba(245,158,11,0.25);">
                                <i class="ti ti-gavel" style="color: #fbbf24;"></i>
                            </div>
                            <div>
                                <div class="section-title">Assign to Judge</div>
                                <div class="section-sub">Push this docket to a presiding judicial officer</div>
                            </div>
                        </div>
                    </div>
                    <div style="padding: 1.25rem;">
                        @if($case->assignedJudge)
                        {{-- Currently assigned judge --}}
                        <div style="display: flex; align-items: center; gap: 0.75rem; padding: 0.85rem 1rem; background: rgba(245,158,11,0.08); border: 1px solid rgba(245,158,11,0.25); border-radius: 10px; margin-bottom: 1rem;">
                            <div style="width: 36px; height: 36px; border-radius: 50%; background: linear-gradient(135deg, #f59e0b, #b45309); display: flex; align-items: center; justify-content: center; font-size: 0.8rem; font-weight: 800; color: white; flex-shrink: 0;">
                                {{ strtoupper(substr($case->assignedJudge->name, 0, 2)) }}
                            </div>
                            <div style="flex: 1; min-width: 0;">
                                <div style="font-size: 0.85rem; font-weight: 700; color: #fbbf24;">{{ $case->assignedJudge->name }}</div>
                                <div style="font-size: 0.72rem; color: #78716c;">Presiding Judge · Assigned</div>
                            </div>
                            <i class="ti ti-check-circle" style="color: #4ade80; font-size: 1.1rem;"></i>
                        </div>
                        <form method="POST" action="{{ route('cases.unassign.judge', $case->id) }}"
                              onsubmit="return confirm('Remove judge assignment from this docket?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="width: 100%; padding: 0.55rem; border-radius: 9px; font-family: 'Outfit', sans-serif; font-size: 0.82rem; font-weight: 600; color: #f87171; background: rgba(239,68,68,0.08); border: 1px solid rgba(239,68,68,0.2); cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 0.4rem; transition: all 0.2s;"
                                    onmouseover="this.style.background='rgba(239,68,68,0.15)';"
                                    onmouseout="this.style.background='rgba(239,68,68,0.08)';">
                                <i class="ti ti-unlink"></i> Revoke Assignment
                            </button>
                        </form>
                        @else
                        {{-- No judge assigned yet --}}
                        @if($judges->count() > 0)
                        <form method="POST" action="{{ route('cases.assign.judge', $case->id) }}">
                            @csrf
                            @error('judge_id')
                            <div style="padding: 0.6rem 0.75rem; background: rgba(239,68,68,0.1); border: 1px solid rgba(239,68,68,0.25); border-radius: 8px; color: #f87171; font-size: 0.78rem; margin-bottom: 0.85rem;">
                                {{ $message }}
                            </div>
                            @enderror
                            <select name="judge_id" style="width: 100%; background: rgba(7,10,18,0.75); border: 1px solid rgba(71,85,105,0.4); border-radius: 9px; padding: 0.65rem 0.85rem; font-family: 'Outfit', sans-serif; font-size: 0.85rem; color: #f1f5f9; outline: none; margin-bottom: 0.85rem; transition: border-color 0.2s;"
                                   onfocus="this.style.borderColor='rgba(245,158,11,0.5)';"
                                   onblur="this.style.borderColor='rgba(71,85,105,0.4)';">
                                <option value="">— Select a Judge —</option>
                                @foreach($judges as $judge)
                                <option value="{{ $judge->id }}">{{ $judge->name }}</option>
                                @endforeach
                            </select>
                            <button type="submit" style="width: 100%; padding: 0.65rem; border-radius: 9px; font-family: 'Outfit', sans-serif; font-size: 0.85rem; font-weight: 700; color: #0b0f19; background: linear-gradient(135deg, #f59e0b, #fbbf24); border: none; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 0.4rem; box-shadow: 0 3px 12px rgba(245,158,11,0.35); transition: all 0.2s;"
                                    onmouseover="this.style.boxShadow='0 5px 20px rgba(245,158,11,0.55)'; this.style.transform='translateY(-1px)';"
                                    onmouseout="this.style.boxShadow='0 3px 12px rgba(245,158,11,0.35)'; this.style.transform='translateY(0)';">
                                <i class="ti ti-gavel"></i>
                                Push to Judge
                            </button>
                        </form>
                        @else
                        <div style="text-align: center; color: #64748b; font-size: 0.82rem; padding: 1rem 0;">
                            <i class="ti ti-gavel" style="font-size: 1.5rem; display: block; margin-bottom: 0.5rem; color: #334155;"></i>
                            No verified judges are available in the system yet.
                        </div>
                        @endif
                        @endif
                    </div>
                </div>
                @endif

                <!-- Add Evidence (Lawyer/Admin only) -->
                @if(Auth::user()->hasAnyRole(['Lawyer', 'Admin']) && ($case->created_by === Auth::id() || Auth::user()->hasRole('Admin')))
                <div class="section-card">
                    <div class="section-header">
                        <div class="section-header-left">
                            <div class="section-icon"><i class="ti ti-link"></i></div>
                            <div>
                                <div class="section-title">Add Exhibits</div>
                                <div class="section-sub">Align more evidence to this docket</div>
                            </div>
                        </div>
                    </div>

                    @if($availableEvidence->count() > 0)
                    <form method="POST" action="{{ route('cases.evidence.add', $case->id) }}" class="add-evidence-form">
                        @csrf
                        <input type="text" class="add-evidence-search" id="sidebarSearch"
                               placeholder="&#128269; Search evidence..." autocomplete="off">

                        <div class="add-ev-list" id="sidebarList">
                            @foreach($availableEvidence as $ev)
                            @php
                                $mimeIcon = match(true) {
                                    str_starts_with($ev->mime_type ?? '', 'image/') => 'ti-photo',
                                    str_starts_with($ev->mime_type ?? '', 'video/') => 'ti-video',
                                    str_starts_with($ev->mime_type ?? '', 'audio/') => 'ti-music',
                                    str_starts_with($ev->mime_type ?? '', 'application/pdf') => 'ti-file-type-pdf',
                                    default => 'ti-file',
                                };
                            @endphp
                            <label class="add-ev-item" data-search="{{ strtolower($ev->title . ' ' . ($ev->user->name ?? '')) }}">
                                <input type="checkbox" name="evidence_ids[]" value="{{ $ev->id }}"
                                       onchange="this.closest('.add-ev-item').classList.toggle('selected', this.checked)">
                                <div style="font-size: 1rem; color: #a78bfa; width: 18px; text-align: center; flex-shrink: 0;">
                                    <i class="ti {{ $mimeIcon }}"></i>
                                </div>
                                <div class="add-ev-text">
                                    <div class="add-ev-title">{{ $ev->title }}</div>
                                    <div class="add-ev-by">{{ $ev->user->name ?? 'Unknown' }} · {{ $ev->created_at->format('d M Y') }}</div>
                                </div>
                            </label>
                            @endforeach
                        </div>

                        <label style="font-size: 0.75rem; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.06em; display: block; margin-bottom: 0.4rem;">
                            Exhibit Notes (optional)
                        </label>
                        <textarea class="add-notes-area" name="notes" 
                                  placeholder="Notes about these exhibits in the context of this case..."></textarea>

                        <button type="submit" class="btn-add-evidence">
                            <i class="ti ti-link"></i>
                            Link Selected Exhibits
                        </button>
                    </form>
                    @else
                    <div class="no-avail">
                        <i class="ti ti-check-circle" style="font-size: 1.5rem; color: #4ade80; display: block; margin-bottom: 0.5rem;"></i>
                        All available evidence is already linked to this docket.
                    </div>
                    @endif
                </div>
                @endif

            </div>
        </div>

    </div>
</div>

<script>
function toggleNoteForm(evidenceId) {
    const form = document.getElementById('noteForm-' + evidenceId);
    if (form) {
        form.classList.toggle('open');
    }
}

// Sidebar search
document.getElementById('sidebarSearch')?.addEventListener('input', function () {
    const q = this.value.toLowerCase().trim();
    document.querySelectorAll('#sidebarList .add-ev-item').forEach(item => {
        item.style.display = (item.dataset.search || '').includes(q) ? '' : 'none';
    });
});
</script>
@endsection
