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
                            Forensic & Judicial Intelligence
                        </div>
                    </div>
                </div>

                <div style="margin-bottom: 2rem;">
                    <h3 style="font-family: 'Cinzel', serif; font-size: 1.15rem; font-weight: 700; color: #f8fafc; margin-bottom: 0.5rem;">
                        Next-Gen Evidentiary AI
                    </h3>
                    <p style="font-size: 0.8125rem; color: #94a3b8; line-height: 1.55;">
                        Harness Google's Gemma LLM model to assist legal professionals, investigators, and court officials in rapidly extracting insights from vaulted digital evidence.
                    </p>
                </div>

                <div style="padding: 1rem; background: rgba(30, 41, 59, 0.6); border: 1px solid rgba(168, 85, 247, 0.25); border-radius: 14px; margin-bottom: 1.5rem;">
                    <div style="font-size: 0.68rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #c084fc; margin-bottom: 0.6rem;">
                        System Status
                    </div>
                    <div style="display: flex; align-items: center; gap: 0.6rem; margin-bottom: 0.5rem;">
                        <span style="display: inline-block; width: 10px; height: 10px; border-radius: 50%; background: {{ $configured ? '#34d399' : '#f87171' }}; box-shadow: 0 0 10px {{ $configured ? '#34d399' : '#f87171' }};"></span>
                        <span style="font-size: 0.8125rem; font-weight: 600; color: {{ $configured ? '#34d399' : '#f87171' }};">
                            {{ $configured ? 'Gemma API Connected' : 'API Key Not Set' }}
                        </span>
                    </div>
                    <div style="font-size: 0.72rem; color: #94a3b8; line-height: 1.5;">
                        Model: <code style="color: #cbd5e1; background: rgba(15,23,42,0.6); padding: 0.15rem 0.4rem; border-radius: 4px;">{{ config('gemma.model', 'gemma-3-1b-it') }}</code>
                    </div>
                </div>

                <div style="padding-top: 1rem; border-top: 1px solid rgba(71, 85, 105, 0.3); display: flex; align-items: center; justify-content: space-between;">
                    <div style="font-size: 0.75rem; color: #64748b; display: flex; align-items: center; gap: 0.35rem;">
                        <i class="ti ti-shield-lock" style="color: #c084fc;"></i> Legal Grade
                    </div>
                    <a href="{{ route('dashboard') }}" class="auth-link" style="font-size: 0.78rem;">
                        Back to Dashboard &rarr;
                    </a>
                </div>
            </div>
        </aside>

        <main class="auth-split__content" style="display: flex; flex-direction: column; justify-content: center; padding: 2.5rem;">
            <div class="mb-6">
                <div style="display: inline-flex; align-items: center; gap: 0.4rem; padding: 0.25rem 0.65rem; border-radius: 50px; background: rgba(168, 85, 247, 0.12); border: 1px solid rgba(168, 85, 247, 0.3); color: #c084fc; font-size: 0.72rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.06em; margin-bottom: 0.75rem;">
                    <i class="ti ti-brain"></i> AI Intelligence Suite
                </div>
                <h2 style="font-size: 1.75rem; font-weight: 800; color: #f8fafc; letter-spacing: -0.02em; margin-bottom: 0.5rem;">
                    Evidentiary AI Tools
                </h2>
                <p style="font-size: 0.875rem; color: #94a3b8; line-height: 1.55;">
                    Select an AI capability below to analyze vault evidence, generate executive case summaries, or evaluate evidentiary admissibility.
                </p>
            </div>

            @if(!$configured)
                <div style="padding: 1rem 1.25rem; background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.3); border-radius: 12px; margin-bottom: 1.75rem; display: flex; align-items: flex-start; gap: 0.75rem;">
                    <i class="ti ti-alert-triangle" style="color: #f87171; font-size: 1.25rem; margin-top: 0.1rem;"></i>
                    <div style="font-size: 0.8125rem; color: #fca5a5; line-height: 1.5;">
                        <strong>API Key Required:</strong> Add <code>GEMMA_API_KEY=your_key_here</code> to your <code>.env</code> file to enable live AI generation from Google AI Studio.
                    </div>
                </div>
            @endif

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.25rem;">
                <!-- Feature 1: Evidence Analysis -->
                <div style="background: rgba(15, 23, 42, 0.75); border: 1px solid rgba(168, 85, 247, 0.25); border-radius: 16px; padding: 1.5rem; display: flex; flex-direction: column; justify-content: space-between; transition: all 0.25s;"
                     onmouseover="this.style.borderColor='rgba(168, 85, 247, 0.55)'; this.style.transform='translateY(-2px)';"
                     onmouseout="this.style.borderColor='rgba(168, 85, 247, 0.25)'; this.style.transform='translateY(0)';" >
                    <div>
                        <div style="width: 44px; height: 44px; border-radius: 12px; background: rgba(168, 85, 247, 0.15); border: 1px solid rgba(168, 85, 247, 0.4); display: flex; align-items: center; justify-content: center; margin-bottom: 1rem;">
                            <i class="ti ti-file-analysis" style="font-size: 1.4rem; color: #c084fc;"></i>
                        </div>
                        <h3 style="font-size: 1.15rem; font-weight: 700; color: #f8fafc; margin-bottom: 0.5rem;">
                            Evidence Analysis
                        </h3>
                        <p style="font-size: 0.825rem; color: #94a3b8; line-height: 1.55; margin-bottom: 1.25rem;">
                            Automated forensic evaluation of individual digital evidence exhibits, metadata consistency, GPS timeline, and chain of custody.
                        </p>
                    </div>
                    <a href="{{ route('ai.evidence-analysis') }}"
                       style="display: inline-flex; align-items: center; justify-content: center; gap: 0.5rem; padding: 0.65rem 1rem; border-radius: 10px; background: linear-gradient(135deg, #7c3aed, #9333ea); color: #ffffff; font-size: 0.85rem; font-weight: 600; text-decoration: none; box-shadow: 0 4px 15px rgba(124, 58, 237, 0.35);">
                        <i class="ti ti-scan"></i> Analyze Evidence &rarr;
                    </a>
                </div>

                <!-- Feature 2: Case Summarization -->
                <div style="background: rgba(15, 23, 42, 0.75); border: 1px solid rgba(59, 130, 246, 0.25); border-radius: 16px; padding: 1.5rem; display: flex; flex-direction: column; justify-content: space-between; transition: all 0.25s;"
                     onmouseover="this.style.borderColor='rgba(59, 130, 246, 0.55)'; this.style.transform='translateY(-2px)';"
                     onmouseout="this.style.borderColor='rgba(59, 130, 246, 0.25)'; this.style.transform='translateY(0)';" >
                    <div>
                        <div style="width: 44px; height: 44px; border-radius: 12px; background: rgba(59, 130, 246, 0.15); border: 1px solid rgba(59, 130, 246, 0.4); display: flex; align-items: center; justify-content: center; margin-bottom: 1rem;">
                            <i class="ti ti-file-text" style="font-size: 1.4rem; color: #60a5fa;"></i>
                        </div>
                        <h3 style="font-size: 1.15rem; font-weight: 700; color: #f8fafc; margin-bottom: 0.5rem;">
                            Case Docket Summary
                        </h3>
                        <p style="font-size: 0.825rem; color: #94a3b8; line-height: 1.55; margin-bottom: 1.25rem;">
                            Synthesize entire legal case dockets, review all linked evidentiary exhibits, and generate executive summaries with key strengths and gaps.
                        </p>
                    </div>
                    <a href="{{ route('ai.case-summary') }}"
                       style="display: inline-flex; align-items: center; justify-content: center; gap: 0.5rem; padding: 0.65rem 1rem; border-radius: 10px; background: linear-gradient(135deg, #2563eb, #1d4ed8); color: #ffffff; font-size: 0.85rem; font-weight: 600; text-decoration: none; box-shadow: 0 4px 15px rgba(37, 99, 235, 0.35);">
                        <i class="ti ti-briefcase"></i> Summarize Case &rarr;
                    </a>
                </div>
            </div>
        </main>
    </div>
</x-guest-layout>
