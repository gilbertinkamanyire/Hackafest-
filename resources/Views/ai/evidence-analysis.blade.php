<x-guest-layout :wide="true">
    <div class="auth-split">
        <aside class="auth-split__sidebar">
            <div>
                <div class="flex items-center gap-3 mb-6">
                    <div style="width: 48px; height: 48px; border-radius: 14px; background: linear-gradient(135deg, rgba(168, 85, 247, 0.25), rgba(139, 92, 246, 0.15)); border: 1px solid #c084fc; display: flex; align-items: center; justify-content: center; box-shadow: 0 0 25px rgba(168, 85, 247, 0.35);">
                        <i class="ti ti-file-analysis" style="font-size: 1.75rem; color: #c084fc;"></i>
                    </div>
                    <div>
                        <div style="font-family: 'Cinzel', serif; font-size: 1.4rem; font-weight: 800; background: linear-gradient(to right, #ffffff, #c084fc); -webkit-background-clip: text; -webkit-text-fill-color: transparent; letter-spacing: 0.5px;">
                            Evidence Analysis
                        </div>
                        <div style="font-size: 0.68rem; color: #a78bfa; letter-spacing: 0.1em; text-transform: uppercase; font-weight: 700;">
                            Forensic AI Review
                        </div>
                    </div>
                </div>

                <div style="margin-bottom: 2rem;">
                    <h3 style="font-family: 'Cinzel', serif; font-size: 1.15rem; font-weight: 700; color: #f8fafc; margin-bottom: 0.5rem;">
                        Select Evidence for Analysis
                    </h3>
                    <p style="font-size: 0.8125rem; color: #94a3b8; line-height: 1.55;">
                        Choose an evidence submission to generate a forensic analysis report using Gemma AI.
                    </p>
                </div>

                <div style="padding: 0.85rem 1rem; background: rgba(30, 41, 59, 0.6); border: 1px solid rgba(168, 85, 247, 0.25); border-radius: 12px; margin-bottom: 1.5rem;">
                    <div style="font-size: 0.68rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #c084fc; margin-bottom: 0.5rem;">Analysis Scope</div>
                    <div style="font-size: 0.75rem; color: #cbd5e1; line-height: 1.6;">
                        &#8226; Title and description<br>
                        &#8226; File metadata (MIME type, size, hash)<br>
                        &#8226; GPS and EXIF data<br>
                        &#8226; Device and capture information<br>
                        &#8226; Chain-of-custody considerations
                    </div>
                </div>

                <div style="padding-top: 1rem; border-top: 1px solid rgba(71, 85, 105, 0.3); display: flex; align-items: center; justify-content: space-between;">
                    <div style="font-size: 0.75rem; color: #64748b; display: flex; align-items: center; gap: 0.35rem;">
                        <i class="ti ti-shield" style="color: #c084fc;"></i> Judicial Review
                    </div>
                    <a href="{{ route('ai.index') }}" class="auth-link" style="font-size: 0.78rem;">
                        Back to AI Hub &rarr;
                    </a>
                </div>
            </div>
        </aside>

        <main class="auth-split__content" style="display: flex; flex-direction: column; justify-content: center;">
            <div class="mb-5">
                <div style="display: inline-flex; align-items: center; gap: 0.4rem; padding: 0.25rem 0.65rem; border-radius: 50px; background: rgba(168, 85, 247, 0.12); border: 1px solid rgba(168, 85, 247, 0.3); color: #c084fc; font-size: 0.72rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.06em; margin-bottom: 0.75rem;">
                    <i class="ti ti-file-analysis"></i> Select Evidence
                </div>
                <h2 style="font-size: 1.65rem; font-weight: 800; color: #f8fafc; letter-spacing: -0.02em; margin-bottom: 0.35rem;">
                    Evidence Analysis Form
                </h2>
                <p style="font-size: 0.85rem; color: #94a3b8; line-height: 1.5;">
                    Select an evidence submission from your recent uploads, or specify an evidence ID directly.
                </p>
            </div>

            @if ($errors->any())
                <div class="auth-alert auth-alert--error" style="margin-bottom: 1.35rem;">
                    <i class="ti ti-alert-circle" style="font-size: 1.25rem; flex-shrink: 0; color: #f87171;"></i>
                    <div style="font-size: 0.8125rem; color: #fca5a5;">{{ $errors->first() }}</div>
                </div>
            @endif

            @if($evidence)
                <div style="margin-bottom: 1.5rem; padding: 1rem; background: rgba(168, 85, 247, 0.1); border: 1px solid rgba(168, 85, 247, 0.3); border-radius: 8px;">
                    <div style="font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #c084fc; margin-bottom: 0.5rem;">Selected Evidence</div>
                    <div style="font-size: 0.8125rem; color: #e2e8f0;">{{ $evidence->title }}</div>
                    <div style="font-size: 0.75rem; color: #94a3b8; margin-top: 0.25rem;">ID: {{ $evidence->id }} &#8226; Uploaded by: {{ $evidence->user->name }} &#8226; {{ $evidence->mime_type }}</div>
                </div>
            @endif

            <form method="POST" action="{{ route('ai.evidence.analyze') }}" class="auth-form" style="gap: 1.25rem;">
                @csrf

                <div class="auth-form__field">
                    <label for="evidence_id" class="auth-label">Evidence ID</label>
                    <div class="input-icon-wrapper">
                        <i class="ti ti-file input-icon"></i>
                        <input id="evidence_id" class="auth-input" type="number" name="evidence_id"
                            value="{{ old('evidence_id', $evidence?->id ?? '') }}" required
                            placeholder="Enter evidence ID">
                    </div>
                    <span style="font-size: 0.72rem; color: #64748b; margin-top: 0.35rem; display: block;">
                        The numeric ID of the evidence submission to analyze.
                    </span>
                    @error('evidence_id')
                        <p class="auth-error"><i class="ti ti-alert-circle"></i> {{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="auth-button" style="display: flex; align-items: center; justify-content: center; gap: 0.5rem;">
                    <i class="ti ti-sparkles" style="font-size: 1.15rem;"></i>
                    <span>Generate Forensic Analysis</span>
                </button>
            </form>

            <div style="margin-top: 2rem;">
                <h3 style="font-size: 1rem; font-weight: 700; color: #e2e8f0; margin-bottom: 1rem;">Recent Evidence</h3>
                <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                    @foreach($recentEvidence as $item)
                        <a href="{{ route('ai.evidence-analysis', ['evidence_id' => $item->id]) }}" style="display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem; border-radius: 8px; border: 1px solid rgba(71, 85, 105, 0.2); background: rgba(8, 12, 22, 0.4); text-decoration: none; font-size: 0.8125rem; color: #cbd5e1; transition: all 0.2s;"
                           onmouseover="this.style.borderColor='rgba(168, 85, 247, 0.4)'; this.style.background='rgba(8, 12, 22, 0.6)';"
                           onmouseout="this.style.borderColor='rgba(71, 85, 105, 0.2)'; this.style.background='rgba(8, 12, 22, 0.4)';">
                            <div style="width: 36px; height: 36px; border-radius: 6px; background: rgba(168, 85, 247, 0.15); border: 1px solid rgba(168, 85, 247, 0.3); display: flex; align-items: center; justify-content: center; color: #c084fc; flex-shrink: 0; font-size: 1rem;">
                                <i class="ti ti-file"></i>
                            </div>
                            <div style="flex: 1;">
                                <div style="font-weight: 600; color: #e2e8f0;">{{ $item->title }}</div>
                                <div style="font-size: 0.7rem; color: #94a3b8;">ID: {{ $item->id }} &#8226; {{ $item->mime_type }} &#8226; {{ $item->user->name }}</div>
                            </div>
                            <i class="ti ti-chevron-right" style="color: #64748b; font-size: 0.75rem;"></i>
                        </a>
                    @empty
                        <div style="padding: 1rem; text-align: center; color: #94a3b8; font-size: 0.8125rem;">
                            No recent evidence found.
                        </div>
                    @endforeach
                </div>
            </div>
        </main>
    </div>
</x-guest-layout>
