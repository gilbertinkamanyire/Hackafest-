@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&family=Cinzel:wght@600;700&display=swap');
    * { box-sizing: border-box; }

    .edit-page {
        min-height: 100vh;
        background: #070a12;
        font-family: 'Outfit', sans-serif;
        padding: 2rem 1.5rem 5rem;
    }

    .edit-container { max-width: 820px; margin: 0 auto; }

    .breadcrumb {
        display: flex; align-items: center; gap: 0.5rem;
        font-size: 0.8rem; color: #64748b; margin-bottom: 1.75rem;
    }
    .breadcrumb a { color: #94a3b8; text-decoration: none; }
    .breadcrumb a:hover { color: #c084fc; }

    .page-label {
        font-size: 0.7rem; font-weight: 700; letter-spacing: 0.18em;
        color: #a78bfa; text-transform: uppercase; margin-bottom: 0.35rem;
    }

    h1.page-title {
        font-family: 'Cinzel', serif; font-size: 1.8rem; font-weight: 700;
        color: #f1f5f9; margin: 0 0 0.4rem;
    }

    .page-sub { color: #64748b; font-size: 0.875rem; margin: 0 0 2.5rem; }

    .form-card {
        background: rgba(12, 18, 32, 0.85);
        border: 1px solid rgba(71, 85, 105, 0.3);
        border-radius: 18px; overflow: hidden; margin-bottom: 1.5rem;
    }

    .form-card-header {
        padding: 1.25rem 1.75rem;
        border-bottom: 1px solid rgba(71, 85, 105, 0.2);
        display: flex; align-items: center; gap: 0.75rem;
    }

    .header-icon {
        width: 38px; height: 38px; border-radius: 10px;
        background: rgba(124, 58, 237, 0.15);
        border: 1px solid rgba(124, 58, 237, 0.3);
        display: flex; align-items: center; justify-content: center;
        color: #a78bfa; font-size: 1.1rem;
    }

    .form-card-header h2 { font-size: 1rem; font-weight: 700; color: #f1f5f9; margin: 0; }
    .form-card-header p { font-size: 0.8rem; color: #64748b; margin: 0; }

    .form-card-body { padding: 1.75rem; }

    .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; }
    .form-group { display: flex; flex-direction: column; gap: 0.45rem; }
    .form-group.full { grid-column: 1 / -1; }

    label {
        font-size: 0.8rem; font-weight: 700; color: #94a3b8;
        text-transform: uppercase; letter-spacing: 0.06em;
    }

    label .req { color: #f87171; margin-left: 2px; }

    input[type="text"], input[type="date"], textarea, select {
        background: rgba(7, 10, 18, 0.75);
        border: 1px solid rgba(71, 85, 105, 0.4);
        border-radius: 10px; padding: 0.75rem 1rem;
        font-family: 'Outfit', sans-serif; font-size: 0.9rem;
        color: #f1f5f9; outline: none; width: 100%;
        transition: border-color 0.2s, box-shadow 0.2s;
    }

    input:focus, textarea:focus, select:focus {
        border-color: rgba(124, 58, 237, 0.6);
        box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.12);
    }

    textarea { resize: vertical; min-height: 100px; }
    select option { background: #0c1220; }

    .error-msg { font-size: 0.76rem; color: #f87171; }

    .submit-bar {
        display: flex; justify-content: flex-end;
        gap: 1rem; flex-wrap: wrap;
    }

    .btn-cancel {
        padding: 0.7rem 1.5rem; border-radius: 10px;
        font-family: 'Outfit', sans-serif; font-size: 0.9rem; font-weight: 600;
        color: #94a3b8; background: transparent;
        border: 1px solid rgba(71, 85, 105, 0.4);
        cursor: pointer; text-decoration: none;
        display: inline-flex; align-items: center; gap: 0.45rem;
        transition: all 0.2s;
    }

    .btn-cancel:hover { border-color: rgba(71, 85, 105, 0.7); color: #f1f5f9; }

    .btn-save {
        padding: 0.7rem 2rem; border-radius: 10px;
        font-family: 'Outfit', sans-serif; font-size: 0.9rem; font-weight: 700;
        color: white;
        background: linear-gradient(135deg, #7c3aed, #a855f7);
        border: none; cursor: pointer;
        display: inline-flex; align-items: center; gap: 0.5rem;
        box-shadow: 0 4px 20px rgba(124, 58, 237, 0.4);
        transition: all 0.25s;
    }

    .btn-save:hover { transform: translateY(-1px); box-shadow: 0 6px 28px rgba(124, 58, 237, 0.6); }

    @media (max-width: 640px) {
        .form-grid { grid-template-columns: 1fr; }
        .form-group.full { grid-column: 1; }
    }
</style>

<div class="edit-page">
    <div class="edit-container">

        <div class="breadcrumb">
            <a href="{{ route('cases.index') }}">Case Dockets</a>
            <i class="ti ti-chevron-right"></i>
            <a href="{{ route('cases.show', $case->id) }}">{{ $case->case_number }}</a>
            <i class="ti ti-chevron-right"></i>
            <span>Edit Docket</span>
        </div>

        <div class="page-label"><i class="ti ti-edit"></i> Edit Case Docket</div>
        <h1 class="page-title">Update Docket Details</h1>
        <p class="page-sub">Modify the details for docket <strong style="color: #c084fc;">{{ $case->case_number }}</strong>. Evidence exhibits are managed from the docket view.</p>

        <form method="POST" action="{{ route('cases.update', $case->id) }}">
            @csrf
            @method('PUT')

            <div class="form-card">
                <div class="form-card-header">
                    <div class="header-icon"><i class="ti ti-file-description"></i></div>
                    <div>
                        <h2>Docket Details</h2>
                        <p>Update case identity and classification</p>
                    </div>
                </div>
                <div class="form-card-body">
                    <div class="form-grid">
                        <div class="form-group full">
                            <label for="title">Case Title <span class="req">*</span></label>
                            <input type="text" id="title" name="title" 
                                   value="{{ old('title', $case->title) }}" required>
                            @error('title')<span class="error-msg">{{ $message }}</span>@enderror
                        </div>

                        <div class="form-group full">
                            <label for="description">Case Synopsis</label>
                            <textarea id="description" name="description">{{ old('description', $case->description) }}</textarea>
                            @error('description')<span class="error-msg">{{ $message }}</span>@enderror
                        </div>

                        <div class="form-group">
                            <label for="court_reference">Court Reference No.</label>
                            <input type="text" id="court_reference" name="court_reference"
                                   value="{{ old('court_reference', $case->court_reference) }}"
                                   placeholder="e.g. CR-2026-00142">
                            @error('court_reference')<span class="error-msg">{{ $message }}</span>@enderror
                        </div>

                        <div class="form-group">
                            <label for="hearing_date">Scheduled Hearing Date</label>
                            <input type="date" id="hearing_date" name="hearing_date"
                                   value="{{ old('hearing_date', $case->hearing_date?->format('Y-m-d')) }}">
                            @error('hearing_date')<span class="error-msg">{{ $message }}</span>@enderror
                        </div>

                        <div class="form-group">
                            <label for="assigned_judge_id">Presiding Judge (Docket Clearance)</label>
                            <select id="assigned_judge_id" name="assigned_judge_id">
                                <option value="">— Unassigned (Private to Counsel) —</option>
                                @foreach($judges as $judge)
                                <option value="{{ $judge->id }}" {{ old('assigned_judge_id', $case->assigned_judge_id) == $judge->id ? 'selected' : '' }}>
                                    Hon. {{ $judge->name }} ({{ $judge->email }})
                                </option>
                                @endforeach
                            </select>
                            <span class="field-hint" style="font-size: 0.76rem; color: #475569;">Select the presiding Judge authorized to inspect this docket</span>
                            @error('assigned_judge_id')<span class="error-msg">{{ $message }}</span>@enderror
                        </div>

                        <div class="form-group">
                            <label for="status">Docket Status</label>
                            <select id="status" name="status">
                                @foreach(['open' => 'Open', 'under_review' => 'Under Review', 'closed' => 'Closed', 'archived' => 'Archived'] as $val => $label)
                                <option value="{{ $val }}" {{ old('status', $case->status) === $val ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="submit-bar">
                <a href="{{ route('cases.show', $case->id) }}" class="btn-cancel">
                    <i class="ti ti-x"></i> Cancel
                </a>
                <button type="submit" class="btn-save">
                    <i class="ti ti-check"></i>
                    Save Changes
                </button>
            </div>
        </form>

    </div>
</div>

<script>
const editForm = document.querySelector('form[action*="cases"]');
const saveBtn = editForm ? editForm.querySelector('.btn-save') : null;
if (editForm && saveBtn) {
    editForm.addEventListener('submit', function(e) {
        if (editForm.dataset.submitting === 'true') {
            e.preventDefault();
            return false;
        }
        editForm.dataset.submitting = 'true';
        saveBtn.disabled = true;
        saveBtn.style.opacity = '0.7';
        saveBtn.style.cursor = 'not-allowed';
        saveBtn.innerHTML = '<i class="ti ti-loader ti-spin"></i> Saving...';
    });
}
</script>
@endsection
