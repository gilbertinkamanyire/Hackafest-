<x-guest-layout :wide="true">
    <div class="auth-split">
        <aside class="auth-split__sidebar">
            <div>
                <div class="flex items-center gap-3 mb-6">
                    <div style="width: 48px; height: 48px; border-radius: 14px; background: linear-gradient(135deg, rgba(99, 102, 241, 0.25), rgba(168, 85, 247, 0.2)); border: 1px solid rgba(168, 85, 247, 0.5); display: flex; align-items: center; justify-content: center; box-shadow: 0 0 25px rgba(168, 85, 247, 0.35);">
                        <i class="ti ti-sparkles" style="font-size: 1.75rem; color: #c084fc;"></i>
                    </div>
                    <div>
                        <div style="font-family: 'Cinzel', serif; font-size: 1.4rem; font-weight: 800; background: linear-gradient(to right, #ffffff, #c084fc); -webkit-background-clip: text; -webkit-text-fill-color: transparent; letter-spacing: 0.5px;">
                            Gemma AI Hub
                        </div>
                        <div style="font-size: 0.68rem; color: #a78bfa; letter-spacing: 0.1em; text-transform: uppercase; font-weight: 700;">
                            Forensic &amp; Judicial Intelligence
                        </div>
                    </div>
                </div>

                <div style="margin-bottom: 2rem;">
                    <h3 style="font-family: 'Cinzel', serif; font-size: 1.15rem; font-weight: 700; color: #f8fafc; margin-bottom: 0.5rem;">
                        Next-Gen Evidentiary AI
                    </h3>
                    <p style="font-size: 0.8125rem; color: #94a3b8; line-height: 1.55;">
                        Harness Google's Gemma LLM to assist Judges and Lawyers in rapidly extracting insights from digital evidence.
                    </p>
                </div>

                {{-- Live API Status Panel --}}
                <div style="padding: 1rem; background: rgba(30, 41, 59, 0.6); border: 1px solid {{ $connectionOk ? 'rgba(52, 211, 153, 0.35)' : ($configured ? 'rgba(251, 191, 36, 0.35)' : 'rgba(239, 68, 68, 0.35)') }}; border-radius: 14px; margin-bottom: 1.5rem;">
                    <div style="font-size: 0.68rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #c084fc; margin-bottom: 0.75rem;">
                        API Status
                    </div>

                    {{-- Connection indicator --}}
                    <div style="display: flex; align-items: center; gap: 0.6rem; margin-bottom: 0.75rem;">
                        <span style="display: inline-block; width: 10px; height: 10px; border-radius: 50%; background: {{ $connectionOk ? '#34d399' : ($configured ? '#fbbf24' : '#f87171') }}; box-shadow: 0 0 10px {{ $connectionOk ? '#34d399aa' : ($configured ? '#fbbf24aa' : '#f87171aa') }};"></span>
                        <span style="font-size: 0.8125rem; font-weight: 600; color: {{ $connectionOk ? '#34d399' : ($configured ? '#fbbf24' : '#f87171') }};">
                            @if($connectionOk)
                                Connected &amp; Ready
                            @elseif($configured && $connectionError && str_contains(strtolower($connectionError), 'invalid'))
                                Key Invalid / Rejected
                            @elseif($configured)
                                High Demand / Fallback Mode
                            @else
                                Not Configured
                            @endif
                        </span>
                    </div>

                    <div style="font-size: 0.72rem; color: #94a3b8; line-height: 1.7;">
                        <div>Backend: <code style="color: #cbd5e1; background: rgba(15,23,42,0.6); padding: 0.15rem 0.4rem; border-radius: 4px;">{{ $backend }}</code></div>
                        <div style="margin-top: 0.3rem;">Model: <code style="color: #cbd5e1; background: rgba(15,23,42,0.6); padding: 0.15rem 0.4rem; border-radius: 4px;">{{ $activeModel ?? config('gemma.model', 'gemini-flash-lite-latest') }}</code></div>
                        @if($apiKeyHint)
                        <div style="margin-top: 0.3rem;">Key: <code style="color: #cbd5e1; background: rgba(15,23,42,0.6); padding: 0.15rem 0.4rem; border-radius: 4px;">{{ $apiKeyHint }}</code></div>
                        @endif
                    </div>
                </div>

                <div style="padding-top: 1rem; border-top: 1px solid rgba(71, 85, 105, 0.3); display: flex; align-items: center; justify-content: space-between;">
                    <div style="font-size: 0.75rem; color: #64748b; display: flex; align-items: center; gap: 0.35rem;">
                        <i class="ti ti-shield-lock" style="color: #c084fc;"></i> Judges &amp; Lawyers Only
                    </div>
                    <a href="{{ route('dashboard') }}" class="auth-link" style="font-size: 0.78rem;">
                        Dashboard &rarr;
                    </a>
                </div>
            </div>
        </aside>

        <main class="auth-split__content" style="display: flex; flex-direction: column; justify-content: center; padding: 2.5rem; overflow-y: auto;">

            @php
                $isHardKeyError = !$configured || ($connectionError && str_contains(strtolower($connectionError), 'invalid'));
            @endphp

            @if($isHardKeyError)
                {{-- ═══════════ SETUP GUIDE ═══════════ --}}
                <div style="max-width: 540px; margin: 0 auto; width: 100%;">
                    <div style="display: inline-flex; align-items: center; gap: 0.4rem; padding: 0.25rem 0.65rem; border-radius: 50px; background: rgba(239, 68, 68, 0.12); border: 1px solid rgba(239, 68, 68, 0.35); color: #f87171; font-size: 0.72rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.06em; margin-bottom: 0.75rem;">
                        <i class="ti ti-alert-triangle"></i> Setup Required
                    </div>

                    <h2 style="font-size: 1.65rem; font-weight: 800; color: #f8fafc; letter-spacing: -0.02em; margin-bottom: 0.5rem;">
                        AI Not Connected
                    </h2>
                    <p style="font-size: 0.85rem; color: #94a3b8; line-height: 1.55; margin-bottom: 1.75rem;">
                        @if($configured && $connectionError)
                            The key in your <code style="background: rgba(15,23,42,0.8); padding: 0.1rem 0.4rem; border-radius: 4px; color: #c084fc;">.env</code> is <strong style="color: #f87171;">rejected</strong> by the API: <em style="color: #fca5a5;">{{ $connectionError }}</em>
                        @else
                            No API key found. Follow the steps below to get your free key.
                        @endif
                    </p>

                    {{-- Step 1 --}}
                    <div style="background: rgba(15, 23, 42, 0.7); border: 1px solid rgba(168, 85, 247, 0.25); border-radius: 14px; padding: 1.25rem 1.5rem; margin-bottom: 1rem;">
                        <div style="display: flex; align-items: flex-start; gap: 1rem;">
                            <div style="width: 32px; height: 32px; border-radius: 50%; background: linear-gradient(135deg, #7c3aed, #9333ea); color: #fff; font-weight: 800; font-size: 0.85rem; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">1</div>
                            <div>
                                <div style="font-weight: 700; color: #e2e8f0; margin-bottom: 0.25rem;">Get a Free API Key</div>
                                <p style="font-size: 0.8rem; color: #94a3b8; line-height: 1.55; margin-bottom: 0.5rem;">
                                    Choose <strong style="color: #c084fc;">Option A</strong> (Hugging Face) or <strong style="color: #60a5fa;">Option B</strong> (Google AI Studio).
                                </p>
                                <div style="display: flex; gap: 0.75rem; flex-wrap: wrap;">
                                    <a href="https://huggingface.co/settings/tokens" target="_blank"
                                       style="display: inline-flex; align-items: center; gap: 0.4rem; padding: 0.45rem 0.9rem; border-radius: 8px; background: linear-gradient(135deg, #7c3aed, #9333ea); color: #fff; font-size: 0.78rem; font-weight: 700; text-decoration: none;">
                                        <i class="ti ti-external-link"></i> Hugging Face (Free)
                                    </a>
                                    <a href="https://aistudio.google.com/app/apikey" target="_blank"
                                       style="display: inline-flex; align-items: center; gap: 0.4rem; padding: 0.45rem 0.9rem; border-radius: 8px; background: linear-gradient(135deg, #2563eb, #1d4ed8); color: #fff; font-size: 0.78rem; font-weight: 700; text-decoration: none;">
                                        <i class="ti ti-external-link"></i> Google AI Studio (Free)
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Step 2 --}}
                    <div style="background: rgba(15, 23, 42, 0.7); border: 1px solid rgba(168, 85, 247, 0.25); border-radius: 14px; padding: 1.25rem 1.5rem; margin-bottom: 1rem;">
                        <div style="display: flex; align-items: flex-start; gap: 1rem;">
                            <div style="width: 32px; height: 32px; border-radius: 50%; background: linear-gradient(135deg, #7c3aed, #9333ea); color: #fff; font-weight: 800; font-size: 0.85rem; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">2</div>
                            <div style="flex: 1;">
                                <div style="font-weight: 700; color: #e2e8f0; margin-bottom: 0.25rem;">Add Key to <code style="color: #c084fc;">.env</code></div>
                                <p style="font-size: 0.8rem; color: #94a3b8; margin-bottom: 0.6rem;">Open <code style="background: rgba(15,23,42,0.8); padding: 0.1rem 0.4rem; border-radius: 4px; color: #c084fc;">C:\xampp\htdocs\eWitnessVault\.env</code> and set:</p>
                                <div style="background: rgba(8, 12, 22, 0.9); border: 1px solid rgba(168, 85, 247, 0.3); border-radius: 8px; padding: 0.75rem 1rem; font-family: monospace; font-size: 0.8rem; color: #c084fc; line-height: 1.8;">
                                    <span style="color: #64748b;"># For Hugging Face (key starts with hf_)</span><br>
                                    GEMINI_API_KEY=<span style="color: #34d399;">hf_xxxxxxxxxxxxxxxx</span><br>
                                    GEMINI_MODEL=<span style="color: #60a5fa;">gemma-3-1b-it</span><br><br>
                                    <span style="color: #64748b;"># For Google AI Studio (key starts with AIza)</span><br>
                                    GEMINI_API_KEY=<span style="color: #34d399;">AIzaSyxxxxxxxxxx</span><br>
                                    GEMINI_MODEL=<span style="color: #60a5fa;">gemini-2.0-flash</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Step 3 --}}
                    <div style="background: rgba(15, 23, 42, 0.7); border: 1px solid rgba(168, 85, 247, 0.25); border-radius: 14px; padding: 1.25rem 1.5rem; margin-bottom: 1.75rem;">
                        <div style="display: flex; align-items: flex-start; gap: 1rem;">
                            <div style="width: 32px; height: 32px; border-radius: 50%; background: linear-gradient(135deg, #7c3aed, #9333ea); color: #fff; font-weight: 800; font-size: 0.85rem; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">3</div>
                            <div>
                                <div style="font-weight: 700; color: #e2e8f0; margin-bottom: 0.25rem;">Clear Config Cache</div>
                                <p style="font-size: 0.8rem; color: #94a3b8; margin-bottom: 0.6rem;">Run this in your terminal (inside the project folder):</p>
                                <div style="background: rgba(8, 12, 22, 0.9); border: 1px solid rgba(168, 85, 247, 0.3); border-radius: 8px; padding: 0.6rem 1rem; font-family: monospace; font-size: 0.82rem; color: #34d399;">
                                    php artisan config:clear
                                </div>
                                <p style="font-size: 0.78rem; color: #64748b; margin-top: 0.5rem;">Then reload this page.</p>
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('ai.index') }}"
                       style="display: flex; align-items: center; justify-content: center; gap: 0.5rem; padding: 0.75rem 1.5rem; border-radius: 12px; background: linear-gradient(135deg, #7c3aed, #9333ea); color: #fff; font-size: 0.9rem; font-weight: 700; text-decoration: none; box-shadow: 0 4px 20px rgba(124, 58, 237, 0.45); width: 100%;">
                        <i class="ti ti-refresh"></i> I've Added the Key — Retry
                    </a>
                </div>

            @else
                {{-- ═══════════ AI FEATURES GRID ═══════════ --}}
                @if(!$connectionOk && $configured)
                    <div style="padding: 0.85rem 1.25rem; border-radius: 12px; background: rgba(245, 158, 11, 0.12); border: 1px solid rgba(245, 158, 11, 0.35); color: #fbbf24; margin-bottom: 1.5rem; display: flex; align-items: center; justify-content: space-between; gap: 1rem;">
                        <div style="display: flex; align-items: center; gap: 0.65rem; font-size: 0.825rem;">
                            <i class="ti ti-info-circle" style="font-size: 1.15rem;"></i>
                            <span>{{ $connectionError ?? 'Upstream provider is experiencing temporary demand spikes. Automatic model failover is active.' }}</span>
                        </div>
                        <a href="{{ route('ai.index') }}" style="font-size: 0.78rem; color: #fbbf24; text-decoration: underline; white-space: nowrap;">Refresh Status</a>
                    </div>
                @endif

                <div class="mb-6">
                    <div style="display: inline-flex; align-items: center; gap: 0.4rem; padding: 0.25rem 0.65rem; border-radius: 50px; background: {{ $connectionOk ? 'rgba(52, 211, 153, 0.12)' : 'rgba(251, 191, 36, 0.12)' }}; border: 1px solid {{ $connectionOk ? 'rgba(52, 211, 153, 0.35)' : 'rgba(251, 191, 36, 0.35)' }}; color: {{ $connectionOk ? '#34d399' : '#fbbf24' }}; font-size: 0.72rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.06em; margin-bottom: 0.75rem;">
                        <i class="ti ti-{{ $connectionOk ? 'check' : 'bolt' }}"></i> AI Ready &mdash; {{ $backend }} ({{ $activeModel ?? config('gemma.model') }})
                    </div>
                    <h2 style="font-size: 1.75rem; font-weight: 800; color: #f8fafc; letter-spacing: -0.02em; margin-bottom: 0.5rem;">
                        Evidentiary AI Tools
                    </h2>
                    <p style="font-size: 0.875rem; color: #94a3b8; line-height: 1.55;">
                        Select an AI capability below. Restricted to <strong style="color: #c084fc;">Judges &amp; Lawyers</strong> only.
                    </p>
                </div>

                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.25rem;">
                    {{-- Evidence Analysis --}}
                    <div style="background: rgba(15, 23, 42, 0.75); border: 1px solid rgba(168, 85, 247, 0.25); border-radius: 16px; padding: 1.5rem; display: flex; flex-direction: column; justify-content: space-between; transition: all 0.25s;"
                         onmouseover="this.style.borderColor='rgba(168, 85, 247, 0.55)'; this.style.transform='translateY(-2px)';"
                         onmouseout="this.style.borderColor='rgba(168, 85, 247, 0.25)'; this.style.transform='translateY(0)';">
                        <div>
                            <div style="width: 44px; height: 44px; border-radius: 12px; background: rgba(168, 85, 247, 0.15); border: 1px solid rgba(168, 85, 247, 0.4); display: flex; align-items: center; justify-content: center; margin-bottom: 1rem;">
                                <i class="ti ti-file-analysis" style="font-size: 1.4rem; color: #c084fc;"></i>
                            </div>
                            <h3 style="font-size: 1.15rem; font-weight: 700; color: #f8fafc; margin-bottom: 0.5rem;">
                                Evidence Analysis
                            </h3>
                            <p style="font-size: 0.825rem; color: #94a3b8; line-height: 1.55; margin-bottom: 1.25rem;">
                                Forensic AI evaluation of digital evidence — metadata, chain of custody, file integrity, and evidentiary value.
                            </p>
                        </div>
                        <a href="{{ route('ai.evidence-analysis') }}"
                           style="display: inline-flex; align-items: center; justify-content: center; gap: 0.5rem; padding: 0.65rem 1rem; border-radius: 10px; background: linear-gradient(135deg, #7c3aed, #9333ea); color: #ffffff; font-size: 0.85rem; font-weight: 600; text-decoration: none; box-shadow: 0 4px 15px rgba(124, 58, 237, 0.35);">
                            <i class="ti ti-scan"></i> Analyze Evidence &rarr;
                        </a>
                    </div>

                    {{-- Case Summary --}}
                    <div style="background: rgba(15, 23, 42, 0.75); border: 1px solid rgba(59, 130, 246, 0.25); border-radius: 16px; padding: 1.5rem; display: flex; flex-direction: column; justify-content: space-between; transition: all 0.25s;"
                         onmouseover="this.style.borderColor='rgba(59, 130, 246, 0.55)'; this.style.transform='translateY(-2px)';"
                         onmouseout="this.style.borderColor='rgba(59, 130, 246, 0.25)'; this.style.transform='translateY(0)';">
                        <div>
                            <div style="width: 44px; height: 44px; border-radius: 12px; background: rgba(59, 130, 246, 0.15); border: 1px solid rgba(59, 130, 246, 0.4); display: flex; align-items: center; justify-content: center; margin-bottom: 1rem;">
                                <i class="ti ti-file-text" style="font-size: 1.4rem; color: #60a5fa;"></i>
                            </div>
                            <h3 style="font-size: 1.15rem; font-weight: 700; color: #f8fafc; margin-bottom: 0.5rem;">
                                Case Docket Summary
                            </h3>
                            <p style="font-size: 0.825rem; color: #94a3b8; line-height: 1.55; margin-bottom: 1.25rem;">
                                AI-generated executive case briefs from all linked evidence — key facts, evidence strength, gaps, and judicial focus areas.
                            </p>
                        </div>
                        <a href="{{ route('ai.case-summary') }}"
                           style="display: inline-flex; align-items: center; justify-content: center; gap: 0.5rem; padding: 0.65rem 1rem; border-radius: 10px; background: linear-gradient(135deg, #2563eb, #1d4ed8); color: #ffffff; font-size: 0.85rem; font-weight: 600; text-decoration: none; box-shadow: 0 4px 15px rgba(37, 99, 235, 0.35);">
                            <i class="ti ti-briefcase"></i> Summarize Case &rarr;
                        </a>
                    </div>
                </div>
            @endif

        </main>
    </div>
</x-guest-layout>
