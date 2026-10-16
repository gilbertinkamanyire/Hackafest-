@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&family=Cinzel:wght@600;700&display=swap');

    * { box-sizing: border-box; }

    .create-page {
        min-height: 100vh;
        background: #070a12;
        font-family: 'Outfit', sans-serif;
        padding: 2rem 1.5rem 5rem;
    }

    .create-container {
        max-width: 960px;
        margin: 0 auto;
    }

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
    .breadcrumb i { font-size: 0.75rem; }

    /* Page header */
    .page-label {
        font-size: 0.7rem;
        font-weight: 700;
        letter-spacing: 0.18em;
        color: #a78bfa;
        text-transform: uppercase;
        margin-bottom: 0.35rem;
    }

    h1.page-title {
        font-family: 'Cinzel', serif;
        font-size: 1.9rem;
        font-weight: 700;
        color: #f1f5f9;
        margin: 0 0 0.4rem;
    }

    .page-sub {
        color: #64748b;
        font-size: 0.875rem;
        margin: 0 0 2.5rem;
    }

    /* Card */
    .form-card {
        background: rgba(12, 18, 32, 0.85);
        border: 1px solid rgba(71, 85, 105, 0.3);
        border-radius: 18px;
        overflow: hidden;
        margin-bottom: 1.5rem;
    }

    .form-card-header {
        padding: 1.25rem 1.75rem;
        border-bottom: 1px solid rgba(71, 85, 105, 0.2);
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .form-card-header .header-icon {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        background: rgba(124, 58, 237, 0.15);
        border: 1px solid rgba(124, 58, 237, 0.3);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #a78bfa;
        font-size: 1.1rem;
    }

    .form-card-header h2 {
        font-size: 1rem;
        font-weight: 700;
        color: #f1f5f9;
        margin: 0;
    }

    .form-card-header p {
        font-size: 0.8rem;
        color: #64748b;
        margin: 0;
    }

    .form-card-body {
        padding: 1.75rem;
    }

    /* Form grid */
    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.25rem;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 0.45rem;
    }

    .form-group.full { grid-column: 1 / -1; }

    label {
        font-size: 0.8rem;
        font-weight: 700;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: 0.06em;
    }

    label .req { color: #f87171; margin-left: 2px; }

    input[type="text"],
    input[type="date"],
    textarea,
    select {
        background: rgba(7, 10, 18, 0.75);
        border: 1px solid rgba(71, 85, 105, 0.4);
        border-radius: 10px;
        padding: 0.75rem 1rem;
        font-family: 'Outfit', sans-serif;
        font-size: 0.9rem;
        color: #f1f5f9;
        outline: none;
        transition: border-color 0.2s, box-shadow 0.2s;
        width: 100%;
    }

    input:focus, textarea:focus, select:focus {
        border-color: rgba(124, 58, 237, 0.6);
        box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.12);
    }

    textarea { resize: vertical; min-height: 100px; }

    select option { background: #0c1220; }

    .field-hint {
        font-size: 0.76rem;
        color: #475569;
    }

    .error-msg {
        font-size: 0.76rem;
        color: #f87171;
    }

    /* Evidence picker */
    .evidence-search-box {
        background: rgba(7, 10, 18, 0.75);
        border: 1px solid rgba(71, 85, 105, 0.4);
        border-radius: 10px;
        padding: 0.7rem 1rem;
        font-family: 'Outfit', sans-serif;
        font-size: 0.875rem;
        color: #f1f5f9;
        width: 100%;
        outline: none;
        margin-bottom: 1rem;
        transition: border-color 0.2s;
    }

    .evidence-search-box:focus {
        border-color: rgba(124, 58, 237, 0.6);
        box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.1);
    }

    .evidence-picker-list {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
        max-height: 380px;
        overflow-y: auto;
        padding-right: 0.25rem;
    }

    .evidence-picker-list::-webkit-scrollbar { width: 4px; }
    .evidence-picker-list::-webkit-scrollbar-track { background: transparent; }
    .evidence-picker-list::-webkit-scrollbar-thumb { background: rgba(124, 58, 237, 0.4); border-radius: 2px; }

    .evidence-item-check {
        display: flex;
        align-items: center;
        gap: 0.85rem;
        padding: 0.85rem 1rem;
        border-radius: 10px;
        border: 1px solid rgba(71, 85, 105, 0.2);
        background: rgba(7, 10, 18, 0.5);
        cursor: pointer;
        transition: all 0.2s;
        user-select: none;
    }

    .evidence-item-check:hover {
        border-color: rgba(124, 58, 237, 0.35);
        background: rgba(124, 58, 237, 0.06);
    }

    .evidence-item-check.selected {
        border-color: rgba(124, 58, 237, 0.5);
        background: rgba(124, 58, 237, 0.12);
    }

    .evidence-item-check input[type="checkbox"] {
        width: 16px;
        height: 16px;
        accent-color: #7c3aed;
        flex-shrink: 0;
        margin: 0;
        padding: 0;
        border: none;
    }

    .ev-icon {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        background: rgba(124, 58, 237, 0.12);
        border: 1px solid rgba(124, 58, 237, 0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #a78bfa;
        font-size: 1rem;
        flex-shrink: 0;
    }

    .ev-info { flex: 1; min-width: 0; }

    .ev-title {
        font-size: 0.85rem;
        font-weight: 700;
        color: #f1f5f9;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        margin-bottom: 0.15rem;
    }

    .ev-meta {
        font-size: 0.73rem;
        color: #64748b;
        display: flex;
        gap: 0.6rem;
        flex-wrap: wrap;
    }

    .selected-count-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0.35rem 0.85rem;
        border-radius: 20px;
        background: rgba(124, 58, 237, 0.15);
        border: 1px solid rgba(124, 58, 237, 0.3);
        color: #c084fc;
        font-size: 0.8rem;
        font-weight: 700;
        margin-bottom: 0.85rem;
    }

    /* Submit area */
    .submit-bar {
        display: flex;
        justify-content: flex-end;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .btn-cancel {
        padding: 0.7rem 1.5rem;
        border-radius: 10px;
        font-family: 'Outfit', sans-serif;
        font-size: 0.9rem;
        font-weight: 600;
        color: #94a3b8;
        background: transparent;
        border: 1px solid rgba(71, 85, 105, 0.4);
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        transition: all 0.2s;
    }

    .btn-cancel:hover {
        border-color: rgba(71, 85, 105, 0.7);
        color: #f1f5f9;
    }

    .btn-create {
        padding: 0.7rem 2rem;
        border-radius: 10px;
        font-family: 'Outfit', sans-serif;
        font-size: 0.9rem;
        font-weight: 700;
        color: white;
        background: linear-gradient(135deg, #7c3aed, #a855f7);
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        box-shadow: 0 4px 20px rgba(124, 58, 237, 0.4);
        transition: all 0.25s;
    }

    .btn-create:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 28px rgba(124, 58, 237, 0.6);
    }

    @media (max-width: 640px) {
        .form-grid { grid-template-columns: 1fr; }
        .form-group.full { grid-column: 1; }
    }
</style>

<div class="create-page">
    <div class="create-container">

        <!-- Breadcrumb -->
        <div class="breadcrumb">
            <a href="{{ route('cases.index') }}">Case Dockets</a>
            <i class="ti ti-chevron-right"></i>
            <span>Open New Docket</span>
        </div>

        <div class="page-label"><i class="ti ti-folder-plus"></i> New Case Deposit</div>
        <h1 class="page-title">Open Case Docket</h1>
        <p class="page-sub">Create a structured case deposit and align related evidence exhibits for comprehensive judicial analysis.</p>

        <form method="POST" action="{{ route('cases.store') }}" id="caseForm">
            @csrf

            <!-- Case Details Card -->
            <div class="form-card">
                <div class="form-card-header">
                    <div class="header-icon"><i class="ti ti-file-description"></i></div>
                    <div>
                        <h2>Docket Details</h2>
                        <p>Define the case identity and classification</p>
                    </div>
                </div>
                <div class="form-card-body">
                    <div class="form-grid">
                        <div class="form-group full">
                            <label for="title">Case Title <span class="req">*</span></label>
                            <input type="text" id="title" name="title" placeholder="e.g. State v. John Doe — Assault Case 2026" 
                                   value="{{ old('title') }}" required>
                            @error('title')<span class="error-msg">{{ $message }}</span>@enderror
                        </div>

                        <div class="form-group full">
                            <label for="description">Case Synopsis</label>
                            <textarea id="description" name="description" 
                                      placeholder="Brief summary of the case background, charges, and relevant context...">{{ old('description') }}</textarea>
                            @error('description')<span class="error-msg">{{ $message }}</span>@enderror
                        </div>

                        <div class="form-group">
                            <label for="court_reference">Court Reference No.</label>
                            <input type="text" id="court_reference" name="court_reference" 
                                   placeholder="e.g. CR-2026-00142" value="{{ old('court_reference') }}">
                            <span class="field-hint">External docket or court case number</span>
                            @error('court_reference')<span class="error-msg">{{ $message }}</span>@enderror
                        </div>

                        <div class="form-group">
                            <label for="hearing_date">Scheduled Hearing Date</label>
                            <input type="date" id="hearing_date" name="hearing_date" 
                                   value="{{ old('hearing_date') }}" min="{{ date('Y-m-d') }}">
                            @error('hearing_date')<span class="error-msg">{{ $message }}</span>@enderror
                        </div>

                        <div class="form-group">
                            <label for="assigned_judge_id">Presiding Judge (Docket Clearance)</label>
                            <select id="assigned_judge_id" name="assigned_judge_id">
                                <option value="">— Unassigned (Private to Counsel) —</option>
                                @foreach($judges as $judge)
                                <option value="{{ $judge->id }}" {{ old('assigned_judge_id') == $judge->id ? 'selected' : '' }}>
                                    Hon. {{ $judge->name }} ({{ $judge->email }})
                                </option>
                                @endforeach
                            </select>
                            <span class="field-hint">Select the presiding Judge authorized to view this docket</span>
                            @error('assigned_judge_id')<span class="error-msg">{{ $message }}</span>@enderror
                        </div>

                        <div class="form-group">
                            <label for="status">Docket Status</label>
                            <select id="status" name="status">
                                <option value="open" {{ old('status') == 'open' ? 'selected' : '' }}>Open</option>
                                <option value="under_review" {{ old('status') == 'under_review' ? 'selected' : '' }}>Under Review</option>
                                <option value="closed" {{ old('status') == 'closed' ? 'selected' : '' }}>Closed</option>
                                <option value="archived" {{ old('status') == 'archived' ? 'selected' : '' }}>Archived</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Evidence Picker Card -->
            <div class="form-card">
                <div class="form-card-header">
                    <div class="header-icon"><i class="ti ti-files"></i></div>
                    <div>
                        <h2>Link Evidence Exhibits</h2>
                        <p>Select evidence items to align into this case deposit (optional — you can add more later)</p>
                    </div>
                </div>
                <div class="form-card-body">
                    <div id="selectedBadge" class="selected-count-badge" style="display: none;">
                        <i class="ti ti-check"></i>
                        <span id="selectedCountText">0 exhibits selected</span>
                    </div>

                    @if($availableEvidence->count() > 0)
                    <input type="text" class="evidence-search-box" id="evidenceSearch" 
                           placeholder="&#128269;  Search evidence by title, uploader..." autocomplete="off">

                    <div class="evidence-picker-list" id="evidenceList">
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
                        <label class="evidence-item-check" data-search="{{ strtolower($ev->title . ' ' . ($ev->user->name ?? '')) }}">
                            <input type="checkbox" name="evidence_ids[]" value="{{ $ev->id }}"
                                   {{ in_array($ev->id, old('evidence_ids', [])) ? 'checked' : '' }}
                                   onchange="updateSelectedCount()">
                            <div class="ev-icon"><i class="ti {{ $mimeIcon }}"></i></div>
                            <div class="ev-info">
                                <div class="ev-title">{{ $ev->title }}</div>
                                <div class="ev-meta">
                                    <span><i class="ti ti-user" style="font-size: 0.7rem;"></i> {{ $ev->user->name ?? 'Unknown' }}</span>
                                    <span><i class="ti ti-clock" style="font-size: 0.7rem;"></i> {{ $ev->created_at->format('d M Y') }}</span>
                                    @if($ev->latitude && $ev->longitude)
                                    <span><i class="ti ti-map-pin" style="font-size: 0.7rem; color: #4ade80;"></i> GPS</span>
                                    @endif
                                </div>
                            </div>
                        </label>
                        @endforeach
                    </div>
                    @else
                    <div style="text-align: center; padding: 2.5rem; color: #64748b; font-size: 0.875rem;">
                        <i class="ti ti-files" style="font-size: 2rem; display: block; margin-bottom: 0.75rem; color: #334155;"></i>
                        No evidence items available to link. You can add exhibits after creating the docket.
                    </div>
                    @endif
                </div>
            </div>

            <!-- Submit -->
            <div class="submit-bar">
                <a href="{{ route('cases.index') }}" class="btn-cancel">
                    <i class="ti ti-x"></i> Cancel
                </a>
                <button type="submit" class="btn-create">
                    <i class="ti ti-folder-plus"></i>
                    Open Case Docket
                </button>
            </div>
        </form>

    </div>
</div>

<script>
function updateSelectedCount() {
    const checked = document.querySelectorAll('input[name="evidence_ids[]"]:checked').length;
    const badge   = document.getElementById('selectedBadge');
    const text    = document.getElementById('selectedCountText');

    // Update parent label classes
    document.querySelectorAll('.evidence-item-check').forEach(label => {
        const cb = label.querySelector('input[type="checkbox"]');
        if (cb) label.classList.toggle('selected', cb.checked);
    });

    if (checked > 0) {
        badge.style.display = 'inline-flex';
        text.textContent = checked + ' exhibit' + (checked !== 1 ? 's' : '') + ' selected';
    } else {
        badge.style.display = 'none';
    }
}

// Live search filter
document.getElementById('evidenceSearch')?.addEventListener('input', function () {
    const q = this.value.toLowerCase().trim();
    document.querySelectorAll('.evidence-item-check').forEach(item => {
        const searchText = item.dataset.search || '';
        item.style.display = searchText.includes(q) ? '' : 'none';
    });
});

// Init count on page load
updateSelectedCount();

// Prevent double submission
const caseForm = document.getElementById('caseForm');
const createBtn = caseForm ? caseForm.querySelector('.btn-create') : null;
if (caseForm && createBtn) {
    caseForm.addEventListener('submit', function(e) {
        if (caseForm.dataset.submitting === 'true') {
            e.preventDefault();
            return false;
        }
        caseForm.dataset.submitting = 'true';
        createBtn.disabled = true;
        createBtn.style.opacity = '0.7';
        createBtn.style.cursor = 'not-allowed';
        createBtn.innerHTML = '<i class="ti ti-loader ti-spin"></i> Registering Case Docket...';
    });
}
</script>
@endsection
