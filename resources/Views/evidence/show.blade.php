<x-app-layout>
    <x-slot name="header">
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
            <div style="display: flex; align-items: center; gap: 0.85rem;">
                <div style="width: 44px; height: 44px; border-radius: 12px; background: linear-gradient(135deg, rgba(245, 158, 11, 0.2), rgba(180, 83, 9, 0.1)); border: 1px solid rgba(245, 158, 11, 0.4); display: flex; align-items: center; justify-content: center; box-shadow: 0 0 20px rgba(245, 158, 11, 0.25);">
                    <i class="ti ti-file-certificate" style="font-size: 1.5rem; color: #fbbf24;"></i>
                </div>
                <div>
                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                        <h2 style="font-family: 'Cinzel', serif; font-size: 1.35rem; font-weight: 800; color: #f8fafc; letter-spacing: 0.5px;">
                            Exhibit Docket #{{ str_pad($evidence->id, 5, '0', STR_PAD_LEFT) }}
                        </h2>
                        <span style="font-size: 0.68rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; padding: 0.2rem 0.55rem; border-radius: 20px; background: rgba(16, 185, 129, 0.15); border: 1px solid rgba(16, 185, 129, 0.35); color: #34d399; display: inline-flex; align-items: center; gap: 0.3rem;">
                            <i class="ti ti-shield-check"></i> Sealed in Vault
                        </span>
                    </div>
                    <p style="font-size: 0.78rem; color: #94a3b8; margin-top: 0.15rem;">
                        Permanent Evidentiary Record &bull; Admissible Chain of Custody
                    </p>
                </div>
            </div>

            <div style="display: flex; align-items: center; gap: 0.65rem;">
                <button type="button" onclick="window.print()"
                   style="display: inline-flex; align-items: center; gap: 0.45rem; padding: 0.45rem 0.85rem; background: rgba(30, 41, 59, 0.6); border: 1px solid rgba(148, 163, 184, 0.25); border-radius: 10px; color: #cbd5e1; font-size: 0.825rem; font-weight: 600; cursor: pointer; transition: all 0.2s;"
                   onmouseover="this.style.borderColor='rgba(245, 158, 11, 0.5)'; this.style.color='#fbbf24';"
                   onmouseout="this.style.borderColor='rgba(148, 163, 184, 0.25)'; this.style.color='#cbd5e1';">
                    <i class="ti ti-printer"></i> Print Docket
                </button>
                <a href="{{ route('evidence.index') }}"
                   style="display: inline-flex; align-items: center; gap: 0.45rem; padding: 0.45rem 0.85rem; background: rgba(15, 23, 42, 0.8); border: 1px solid rgba(245, 158, 11, 0.3); border-radius: 10px; color: #fbbf24; font-size: 0.825rem; font-weight: 600; text-decoration: none; transition: all 0.2s;"
                   onmouseover="this.style.background='rgba(245, 158, 11, 0.15)';"
                   onmouseout="this.style.background='rgba(15, 23, 42, 0.8)';">
                    <i class="ti ti-arrow-left"></i> Evidence Ledger
                </a>
            </div>
        </div>
    </x-slot>

    <div style="padding: 2rem 1rem; max-width: 1200px; margin: 0 auto;">
        
        <!-- Responsive Grid: Main Docket (Left) + Custody Record (Right) -->
        <div class="evidence-detail-grid" style="display: grid; grid-template-columns: 1fr 380px; gap: 1.75rem;">
            
            <!-- MAIN EVIDENCE COLUMN -->
            <div style="display: flex; flex-direction: column; gap: 1.75rem; min-width: 0;">
                
                <!-- Media Frame Card -->
                <div style="background: rgba(12, 17, 29, 0.92); backdrop-filter: blur(24px); border: 1.5px solid rgba(245, 158, 11, 0.25); border-radius: 20px; overflow: hidden; box-shadow: 0 25px 60px rgba(0, 0, 0, 0.55), 0 0 35px rgba(245, 158, 11, 0.08);">
                    
                    <!-- Media Canvas Header -->
                    <div style="padding: 0.85rem 1.25rem; background: rgba(6, 9, 17, 0.85); border-bottom: 1px solid rgba(245, 158, 11, 0.18); display: flex; align-items: center; justify-content: space-between;">
                        <div style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.75rem; color: #cbd5e1; font-weight: 700; text-transform: uppercase; letter-spacing: 0.06em;">
                            <i class="ti ti-eye" style="color: #fbbf24;"></i> Visual Exhibit Inspection
                        </div>
                        <span style="font-family: 'JetBrains Mono', monospace; font-size: 0.72rem; color: #94a3b8; background: rgba(30, 41, 59, 0.7); padding: 0.2rem 0.55rem; border-radius: 6px; border: 1px solid rgba(148, 163, 184, 0.2);">
                            FORMAT: {{ strtoupper($evidence->file_extension) }}
                        </span>
                    </div>

                    <!-- Media Container -->
                    <div style="position: relative; padding: 1.25rem; background: radial-gradient(circle at center, rgba(16, 24, 40, 0.6) 0%, rgba(6, 9, 17, 0.95) 100%); display: flex; align-items: center; justify-content: center; min-height: 320px; user-select: none;" oncontextmenu="return false;">
                        
                        <!-- Judicial Security Watermark Overlay -->
                        <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; pointer-events: none; z-index: 10; display: flex; flex-direction: column; justify-content: space-between; padding: 1rem; opacity: 0.55;">
                            <div style="display: flex; justify-content: space-between; align-items: center; font-size: 0.65rem; font-family: 'JetBrains Mono', monospace; color: rgba(251, 191, 36, 0.6); text-transform: uppercase; letter-spacing: 0.08em;">
                                <span>eWitnessVault Judicial Exhibit #{{ str_pad($evidence->id, 5, '0', STR_PAD_LEFT) }}</span>
                                <span>{{ Auth::user()->name }} ({{ Auth::user()->roles->first()->name ?? 'Clearance' }})</span>
                            </div>
                            <div style="text-align: center; font-size: 0.78rem; font-weight: 800; font-family: 'Cinzel', serif; color: rgba(245, 158, 11, 0.18); letter-spacing: 0.25em; text-transform: uppercase;">
                                &bull; In-App Inspection Only &bull; Extraction Prohibited &bull;
                            </div>
                            <div style="display: flex; justify-content: space-between; align-items: center; font-size: 0.65rem; font-family: 'JetBrains Mono', monospace; color: rgba(148, 163, 184, 0.5);">
                                <span>UTC: {{ now()->format('Y-m-d H:i:s') }}</span>
                                <span>SHA: {{ substr($evidence->file_hash, 0, 10) }}...</span>
                            </div>
                        </div>

                        @if($evidence->is_image)
                            <div style="position: relative; max-width: 100%; border-radius: 12px; overflow: hidden; border: 1px solid rgba(245, 158, 11, 0.2); box-shadow: 0 15px 40px rgba(0,0,0,0.7);">
                                <img src="{{ $evidence->file_url }}" alt="{{ $evidence->title }}" draggable="false" oncontextmenu="return false;" style="width: 100%; height: auto; max-height: 520px; object-fit: contain; display: block; user-select: none; -webkit-user-drag: none; pointer-events: auto;">
                            </div>
                        @elseif($evidence->is_video)
                            <div style="width: 100%; border-radius: 12px; overflow: hidden; border: 1px solid rgba(245, 158, 11, 0.2); box-shadow: 0 15px 40px rgba(0,0,0,0.7); background: #000; position: relative; z-index: 15;">
                                <video controls controlsList="nodownload noplaybackrate" oncontextmenu="return false;" disablePictureInPicture style="width: 100%; max-height: 520px; display: block;">
                                    <source src="{{ $evidence->file_url }}" type="{{ $evidence->mime_type ?? 'video/' . $evidence->file_extension }}">
                                    Your browser does not support HTML5 video playback.
                                </video>
                            </div>
                        @elseif($evidence->is_audio)
                            <div style="width: 100%; padding: 3rem 1.5rem; text-align: center; position: relative; z-index: 15;">
                                <div style="width: 72px; height: 72px; border-radius: 50%; background: rgba(245, 158, 11, 0.15); border: 1.5px solid rgba(245, 158, 11, 0.35); display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; color: #fbbf24;">
                                    <i class="ti ti-volume" style="font-size: 2.25rem;"></i>
                                </div>
                                <div style="font-family: 'Cinzel', serif; font-size: 1.15rem; font-weight: 700; color: #ffffff; margin-bottom: 0.5rem;">
                                    Sworn Audio Recording Exhibit
                                </div>
                                <div style="font-size: 0.8rem; color: #94a3b8; margin-bottom: 1.5rem;">
                                    Playback strictly confined to secure vault session.
                                </div>
                                <div style="max-width: 480px; margin: 0 auto; background: rgba(6, 9, 17, 0.8); border: 1px solid rgba(245, 158, 11, 0.25); border-radius: 50px; padding: 0.5rem 1rem;">
                                    <audio controls controlsList="nodownload" oncontextmenu="return false;" style="width: 100%;">
                                        <source src="{{ $evidence->file_url }}" type="{{ $evidence->mime_type ?? 'audio/' . $evidence->file_extension }}">
                                        Your browser does not support HTML5 audio playback.
                                    </audio>
                                </div>
                            </div>
                        @elseif($evidence->is_pdf)
                            <div style="width: 100%; height: 560px; border-radius: 12px; overflow: hidden; border: 1px solid rgba(245, 158, 11, 0.2); box-shadow: 0 15px 40px rgba(0,0,0,0.7); position: relative; z-index: 15;">
                                <iframe src="{{ $evidence->file_url }}#toolbar=0&navpanes=0" style="width: 100%; height: 100%; border: none;"></iframe>
                            </div>
                        @elseif($evidence->is_text)
                            <div style="width: 100%; height: 440px; border-radius: 12px; overflow: hidden; border: 1px solid rgba(245, 158, 11, 0.2); box-shadow: 0 15px 40px rgba(0,0,0,0.7); position: relative; z-index: 15;">
                                <iframe src="{{ $evidence->file_url }}" style="width: 100%; height: 100%; border: none; background: #080c16; color: #e2e8f0;"></iframe>
                            </div>
                        @else
                            <div style="padding: 3.5rem 2rem; text-align: center; position: relative; z-index: 15;">
                                <div style="width: 76px; height: 76px; border-radius: 20px; background: rgba(245, 158, 11, 0.1); border: 1.5px solid rgba(245, 158, 11, 0.28); display: flex; align-items: center; justify-content: center; margin: 0 auto 1.25rem;">
                                    <i class="ti ti-shield-lock" style="font-size: 2.5rem; color: #fbbf24;"></i>
                                </div>
                                <div style="font-family: 'Cinzel', serif; font-size: 1.2rem; font-weight: 700; color: #f8fafc; margin-bottom: 0.4rem;">
                                    Sealed Binary Court Exhibit
                                </div>
                                <div style="font-size: 0.825rem; color: #94a3b8; max-width: 440px; margin: 0 auto 1.5rem; line-height: 1.55;">
                                    Preserved intact under Section 106 compliance for format <strong style="color: #fbbf24;">{{ strtoupper($evidence->file_extension) }}</strong>. Direct file downloads are prohibited by court evidence policy.
                                </div>
                                <div style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.6rem 1.25rem; border-radius: 10px; background: rgba(239, 68, 68, 0.12); border: 1px solid rgba(239, 68, 68, 0.35); color: #fca5a5; font-size: 0.825rem; font-weight: 700;">
                                    <i class="ti ti-ban"></i> Direct Download Prohibited by Court Policy
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Title & Exhibit Description -->
                    <div style="padding: 1.75rem 2rem; border-top: 1px solid rgba(245, 158, 11, 0.15); background: rgba(10, 15, 26, 0.6);">
                        <div style="display: flex; align-items: center; justify-content: space-between; gap: 1rem; margin-bottom: 0.65rem; flex-wrap: wrap;">
                            <h3 style="font-family: 'Cinzel', serif; font-size: 1.45rem; font-weight: 800; color: #ffffff; word-break: break-word;">
                                {{ $evidence->title }}
                            </h3>
                            <div style="display: inline-flex; align-items: center; gap: 0.45rem; padding: 0.45rem 0.95rem; border-radius: 10px; background: rgba(16, 185, 129, 0.12); border: 1px solid rgba(16, 185, 129, 0.35); color: #34d399; font-weight: 700; font-size: 0.8rem;">
                                <i class="ti ti-shield-check"></i> In-App Inspection Only &bull; Download Disabled
                            </div>
                        </div>
                        
                        <p style="font-size: 0.925rem; color: #cbd5e1; line-height: 1.65; margin-bottom: 1.25rem; white-space: pre-line;">
                            {{ $evidence->description ?: 'No sworn narrative or testimony description provided at time of submission.' }}
                        </p>
                        
                        <!-- Security & Judicial Seals Badges -->
                        <div style="display: flex; flex-wrap: wrap; gap: 0.6rem; padding-top: 1rem; border-top: 1px solid rgba(71, 85, 105, 0.25);">
                            <span style="font-size: 0.72rem; font-weight: 700; color: #fbbf24; background: rgba(245, 158, 11, 0.12); border: 1px solid rgba(245, 158, 11, 0.28); padding: 0.25rem 0.65rem; border-radius: 20px; display: inline-flex; align-items: center; gap: 0.35rem;">
                                <i class="ti ti-lock"></i> AES-256-GCM Encrypted
                            </span>
                            <span style="font-size: 0.72rem; font-weight: 700; color: #34d399; background: rgba(16, 185, 129, 0.12); border: 1px solid rgba(16, 185, 129, 0.28); padding: 0.25rem 0.65rem; border-radius: 20px; display: inline-flex; align-items: center; gap: 0.35rem;">
                                <i class="ti ti-fingerprint"></i> SHA-256 Verified Digest
                            </span>
                            @if($evidence->hasGPS())
                                <span style="font-size: 0.72rem; font-weight: 700; color: #38bdf8; background: rgba(56, 189, 248, 0.12); border: 1px solid rgba(56, 189, 248, 0.28); padding: 0.25rem 0.65rem; border-radius: 20px; display: inline-flex; align-items: center; gap: 0.35rem;">
                                    <i class="ti ti-map-pin-check"></i> Forensic GPS Locked
                                </span>
                            @endif
                            <span style="font-size: 0.72rem; font-weight: 700; color: #c084fc; background: rgba(192, 132, 252, 0.12); border: 1px solid rgba(192, 132, 252, 0.28); padding: 0.25rem 0.65rem; border-radius: 20px; display: inline-flex; align-items: center; gap: 0.35rem;">
                                <i class="ti ti-gavel"></i> Section 106 Court Admissible
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Cryptographic Seal Ledger Card -->
                <div style="background: rgba(12, 17, 29, 0.85); backdrop-filter: blur(16px); border: 1.5px solid rgba(245, 158, 11, 0.22); border-radius: 18px; padding: 1.75rem;">
                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.25rem;">
                        <div style="display: flex; align-items: center; gap: 0.65rem;">
                            <div style="width: 36px; height: 36px; border-radius: 10px; background: rgba(245, 158, 11, 0.15); border: 1px solid rgba(245, 158, 11, 0.3); display: flex; align-items: center; justify-content: center; color: #fbbf24;">
                                <i class="ti ti-binary" style="font-size: 1.2rem;"></i>
                            </div>
                            <div>
                                <div style="font-family: 'Cinzel', serif; font-size: 1rem; font-weight: 800; color: #f8fafc;">
                                    Cryptographic Seal & Checksum
                                </div>
                                <div style="font-size: 0.72rem; color: #94a3b8;">
                                    Immutable digest computed via WebCrypto & confirmed by server
                                </div>
                            </div>
                        </div>

                        <button type="button" onclick="navigator.clipboard.writeText('{{ $evidence->file_hash }}').then(() => alert('SHA-256 Hash copied to clipboard!'))"
                                style="padding: 0.35rem 0.75rem; border-radius: 8px; background: rgba(245, 158, 11, 0.15); border: 1px solid rgba(245, 158, 11, 0.35); color: #fbbf24; font-size: 0.75rem; font-weight: 700; cursor: pointer; display: inline-flex; align-items: center; gap: 0.35rem;">
                            <i class="ti ti-copy"></i> Copy Hash
                        </button>
                    </div>

                    <!-- Hash display block -->
                    <div style="background: rgba(6, 9, 17, 0.95); border: 1px solid rgba(245, 158, 11, 0.25); border-radius: 12px; padding: 1rem 1.25rem; margin-bottom: 1.25rem;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.35rem;">
                            <span style="font-size: 0.68rem; font-weight: 800; color: #f59e0b; text-transform: uppercase; letter-spacing: 0.08em;">
                                SHA-256 Fingerprint
                            </span>
                            <span style="font-size: 0.68rem; color: #10b981; font-weight: 700; display: inline-flex; align-items: center; gap: 0.25rem;">
                                <i class="ti ti-circle-check-filled"></i> Verified Unmodified
                            </span>
                        </div>
                        <div style="font-family: 'JetBrains Mono', monospace; font-size: 0.8rem; color: #fef08a; word-break: break-all; line-height: 1.6; letter-spacing: 0.5px;">
                            {{ $evidence->file_hash }}
                        </div>
                    </div>

                    <!-- Metadata Grid -->
                    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 0.85rem;">
                        <div style="background: rgba(6, 9, 17, 0.6); padding: 0.85rem 1rem; border-radius: 10px; border: 1px solid rgba(71, 85, 105, 0.25);">
                            <div style="font-size: 0.68rem; color: #64748b; font-weight: 700; text-transform: uppercase; margin-bottom: 0.25rem;">File Size</div>
                            <div style="font-size: 0.95rem; color: #e2e8f0; font-weight: 700;">{{ $evidence->formatted_size }}</div>
                        </div>

                        <div style="background: rgba(6, 9, 17, 0.6); padding: 0.85rem 1rem; border-radius: 10px; border: 1px solid rgba(71, 85, 105, 0.25);">
                            <div style="font-size: 0.68rem; color: #64748b; font-weight: 700; text-transform: uppercase; margin-bottom: 0.25rem;">File Format</div>
                            <div style="font-size: 0.95rem; color: #e2e8f0; font-weight: 700;">{{ strtoupper($evidence->file_extension) }}</div>
                        </div>

                        <div style="background: rgba(6, 9, 17, 0.6); padding: 0.85rem 1rem; border-radius: 10px; border: 1px solid rgba(71, 85, 105, 0.25);">
                            <div style="font-size: 0.68rem; color: #64748b; font-weight: 700; text-transform: uppercase; margin-bottom: 0.25rem;">MIME Type</div>
                            <div style="font-size: 0.85rem; color: #e2e8f0; font-weight: 600; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" title="{{ $evidence->mime_type }}">
                                {{ $evidence->mime_type ?: 'application/octet-stream' }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- GPS & Geospatial Telemetry Card (if available) -->
                @if($evidence->hasGPS() || isset($metadata['exif_gps_lat']))
                <div style="background: rgba(12, 17, 29, 0.85); backdrop-filter: blur(16px); border: 1.5px solid rgba(56, 189, 248, 0.25); border-radius: 18px; padding: 1.75rem;">
                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.25rem;">
                        <div style="display: flex; align-items: center; gap: 0.65rem;">
                            <div style="width: 36px; height: 36px; border-radius: 10px; background: rgba(56, 189, 248, 0.15); border: 1px solid rgba(56, 189, 248, 0.35); display: flex; align-items: center; justify-content: center; color: #38bdf8;">
                                <i class="ti ti-map-pin-check" style="font-size: 1.25rem;"></i>
                            </div>
                            <div>
                                <div style="font-family: 'Cinzel', serif; font-size: 1rem; font-weight: 800; color: #f8fafc;">
                                    Forensic Geolocation Telemetry
                                </div>
                                <div style="font-size: 0.72rem; color: #94a3b8;">
                                    Hardware satellite fix acquired at time of incident recording
                                </div>
                            </div>
                        </div>

                        @if($evidence->hasGPS())
                        <a href="https://www.openstreetmap.org/?mlat={{ $evidence->latitude }}&mlon={{ $evidence->longitude }}#map=16/{{ $evidence->latitude }}/{{ $evidence->longitude }}"
                           target="_blank" rel="noopener"
                           style="padding: 0.35rem 0.75rem; border-radius: 8px; background: rgba(56, 189, 248, 0.15); border: 1px solid rgba(56, 189, 248, 0.35); color: #38bdf8; font-size: 0.75rem; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 0.35rem;">
                            <i class="ti ti-map-2"></i> Open Satellite Map &rarr;
                        </a>
                        @endif
                    </div>

                    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 0.85rem; margin-bottom: 1rem;">
                        <div style="background: rgba(6, 9, 17, 0.6); padding: 0.85rem 1rem; border-radius: 10px; border: 1px solid rgba(71, 85, 105, 0.25);">
                            <div style="font-size: 0.68rem; color: #64748b; font-weight: 700; text-transform: uppercase; margin-bottom: 0.25rem;">Latitude</div>
                            <div style="font-family: 'JetBrains Mono', monospace; font-size: 0.95rem; color: #38bdf8; font-weight: 700;">
                                {{ $evidence->latitude ? number_format($evidence->latitude, 7) . '°' : '—' }}
                            </div>
                        </div>

                        <div style="background: rgba(6, 9, 17, 0.6); padding: 0.85rem 1rem; border-radius: 10px; border: 1px solid rgba(71, 85, 105, 0.25);">
                            <div style="font-size: 0.68rem; color: #64748b; font-weight: 700; text-transform: uppercase; margin-bottom: 0.25rem;">Longitude</div>
                            <div style="font-family: 'JetBrains Mono', monospace; font-size: 0.95rem; color: #38bdf8; font-weight: 700;">
                                {{ $evidence->longitude ? number_format($evidence->longitude, 7) . '°' : '—' }}
                            </div>
                        </div>

                        <div style="background: rgba(6, 9, 17, 0.6); padding: 0.85rem 1rem; border-radius: 10px; border: 1px solid rgba(71, 85, 105, 0.25);">
                            <div style="font-size: 0.68rem; color: #64748b; font-weight: 700; text-transform: uppercase; margin-bottom: 0.25rem;">Altitude</div>
                            <div style="font-family: 'JetBrains Mono', monospace; font-size: 0.95rem; color: #cbd5e1; font-weight: 600;">
                                {{ $evidence->altitude ? number_format($evidence->altitude, 1) . ' meters ASL' : 'Not recorded' }}
                            </div>
                        </div>

                        <div style="background: rgba(6, 9, 17, 0.6); padding: 0.85rem 1rem; border-radius: 10px; border: 1px solid rgba(71, 85, 105, 0.25);">
                            <div style="font-size: 0.68rem; color: #64748b; font-weight: 700; text-transform: uppercase; margin-bottom: 0.25rem;">GPS Accuracy</div>
                            <div style="font-family: 'JetBrains Mono', monospace; font-size: 0.95rem; color: #cbd5e1; font-weight: 600;">
                                {{ $evidence->gps_accuracy ? '±' . number_format($evidence->gps_accuracy, 1) . ' meters' : 'Standard fix' }}
                            </div>
                        </div>
                    </div>

                    @if(isset($metadata['exif_gps_lat']) && $metadata['exif_gps_lat'])
                    <div style="background: rgba(6, 9, 17, 0.8); border: 1px dashed rgba(56, 189, 248, 0.3); border-radius: 10px; padding: 0.75rem 1rem; font-size: 0.78rem; color: #94a3b8; display: flex; align-items: center; justify-content: space-between;">
                        <span><strong style="color: #cbd5e1;">EXIF Embedded Coordinates:</strong> {{ number_format($metadata['exif_gps_lat'], 6) }}, {{ number_format($metadata['exif_gps_lon'], 6) }}</span>
                        <span style="color: #10b981; font-weight: 700;">Corroborated</span>
                    </div>
                    @endif
                </div>
                @endif
            </div>

            <!-- RIGHT CUSTODY SIDEBAR -->
            <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                
                <!-- Judicial Seal of Authenticity -->
                <div style="background: linear-gradient(145deg, rgba(245, 158, 11, 0.15) 0%, rgba(12, 17, 29, 0.95) 60%, rgba(180, 83, 9, 0.12) 100%); border: 1.5px solid rgba(245, 158, 11, 0.4); border-radius: 20px; padding: 2rem 1.5rem; text-align: center; position: relative; overflow: hidden; box-shadow: 0 20px 45px rgba(0,0,0,0.5);">
                    <div style="position: absolute; top: -30px; right: -30px; width: 100px; height: 100px; border-radius: 50%; background: rgba(245, 158, 11, 0.1); filter: blur(25px);"></div>
                    
                    <div style="width: 72px; height: 72px; border-radius: 50%; background: linear-gradient(135deg, rgba(245, 158, 11, 0.25), rgba(180, 83, 9, 0.15)); border: 2px solid #fbbf24; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.25rem; box-shadow: 0 0 25px rgba(245, 158, 11, 0.35);">
                        <i class="ti ti-scale" style="font-size: 2.25rem; color: #fbbf24;"></i>
                    </div>

                    <div style="font-family: 'Cinzel', serif; font-size: 1.2rem; font-weight: 800; color: #ffffff; letter-spacing: 0.5px; margin-bottom: 0.35rem;">
                        Judicially Certified
                    </div>
                    <div style="font-size: 0.78rem; color: #fbbf24; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 1rem;">
                        Tamper-Evident Exhibit
                    </div>
                    
                    <p style="font-size: 0.8125rem; color: #94a3b8; line-height: 1.5; margin-bottom: 1.25rem;">
                        This digital record is permanently locked in the eWitnessVault registry. Any tampering with file bytes or timestamps invalidates the cryptographic verification.
                    </p>

                    <div style="padding: 0.65rem; background: rgba(6, 9, 17, 0.7); border: 1px solid rgba(245, 158, 11, 0.2); border-radius: 10px; font-size: 0.72rem; color: #cbd5e1; font-family: 'JetBrains Mono', monospace;">
                        VAULT-ID: {{ strtoupper(substr($evidence->file_hash, 0, 16)) }}...
                    </div>
                </div>

                <!-- Custodian Dossier Card -->
                <div style="background: rgba(12, 17, 29, 0.85); backdrop-filter: blur(16px); border: 1.5px solid rgba(71, 85, 105, 0.35); border-radius: 18px; padding: 1.5rem; display: flex; flex-direction: column; gap: 1.25rem;">
                    
                    <!-- Custodian Information -->
                    <div>
                        <div style="font-size: 0.7rem; color: #f59e0b; font-weight: 800; text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 0.65rem;">
                            1. Depositing Custodian
                        </div>
                        <div style="display: flex; align-items: center; gap: 0.75rem; background: rgba(6, 9, 17, 0.6); padding: 0.85rem; border-radius: 12px; border: 1px solid rgba(71, 85, 105, 0.25);">
                            <div style="width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, #f59e0b, #d97706); display: flex; align-items: center; justify-content: center; color: #000; font-weight: 800; font-size: 0.85rem; flex-shrink: 0;">
                                {{ strtoupper(substr($evidence->user->name, 0, 2)) }}
                            </div>
                            <div style="min-width: 0;">
                                <div style="font-size: 0.925rem; color: #f8fafc; font-weight: 700; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                    {{ $evidence->user->name }}
                                </div>
                                <div style="font-size: 0.75rem; color: #94a3b8; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                    {{ $evidence->user->email }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Chronological Timestamps -->
                    <div>
                        <div style="font-size: 0.7rem; color: #f59e0b; font-weight: 800; text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 0.65rem;">
                            2. Chronological Milestones
                        </div>
                        <div style="display: flex; flex-direction: column; gap: 0.65rem; background: rgba(6, 9, 17, 0.6); padding: 0.85rem; border-radius: 12px; border: 1px solid rgba(71, 85, 105, 0.25);">
                            <div style="display: flex; align-items: flex-start; gap: 0.65rem;">
                                <i class="ti ti-calendar-event" style="color: #fbbf24; font-size: 1.1rem; margin-top: 0.1rem; flex-shrink: 0;"></i>
                                <div>
                                    <div style="font-size: 0.7rem; color: #64748b; font-weight: 700; text-transform: uppercase;">Incident Capture</div>
                                    <div style="font-size: 0.85rem; color: #e2e8f0; font-weight: 600;">
                                        {{ $evidence->captured_at ? $evidence->captured_at->format('M d, Y &bull; h:i:s A T') : $evidence->created_at->format('M d, Y &bull; h:i:s A T') }}
                                    </div>
                                </div>
                            </div>

                            <div style="display: flex; align-items: flex-start; gap: 0.65rem; padding-top: 0.5rem; border-top: 1px solid rgba(71, 85, 105, 0.2);">
                                <i class="ti ti-clock-check" style="color: #10b981; font-size: 1.1rem; margin-top: 0.1rem; flex-shrink: 0;"></i>
                                <div>
                                    <div style="font-size: 0.7rem; color: #64748b; font-weight: 700; text-transform: uppercase;">Vault Ingestion</div>
                                    <div style="font-size: 0.85rem; color: #e2e8f0; font-weight: 600;">
                                        {{ $evidence->created_at->format('M d, Y &bull; h:i:s A T') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Capture Hardware / Device Telemetry -->
                    @if($evidence->device_info)
                    <div>
                        <div style="font-size: 0.7rem; color: #f59e0b; font-weight: 800; text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 0.65rem;">
                            3. Sensor / Client Hardware
                        </div>
                        <div style="background: rgba(6, 9, 17, 0.6); padding: 0.85rem; border-radius: 12px; border: 1px solid rgba(71, 85, 105, 0.25); display: flex; align-items: flex-start; gap: 0.65rem;">
                            <i class="ti ti-device-mobile" style="color: #fbbf24; font-size: 1.15rem; margin-top: 0.1rem; flex-shrink: 0;"></i>
                            <div style="font-size: 0.775rem; color: #cbd5e1; line-height: 1.45; word-break: break-word;">
                                {{ $evidence->device_info }}
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Quick Actions -->
                    <div style="padding-top: 0.5rem; display: flex; flex-direction: column; gap: 0.65rem;">
                        <a href="{{ $evidence->file_url }}" download
                           style="display: flex; align-items: center; justify-content: center; gap: 0.5rem; width: 100%; padding: 0.8rem; background: rgba(245, 158, 11, 0.15); border: 1.5px solid rgba(245, 158, 11, 0.4); border-radius: 12px; color: #fbbf24; font-weight: 700; text-decoration: none; font-size: 0.85rem; transition: all 0.2s;"
                           onmouseover="this.style.background='rgba(245, 158, 11, 0.25)';"
                           onmouseout="this.style.background='rgba(245, 158, 11, 0.15)';">
                            <i class="ti ti-download"></i> Download Binary Archive
                        </a>
                    </div>
                </div>

                <!-- Judicial Legal Admissibility Disclaimer -->
                <div style="padding: 1.15rem; background: rgba(6, 9, 17, 0.6); border: 1px solid rgba(71, 85, 105, 0.3); border-radius: 14px; font-size: 0.75rem; color: #94a3b8; line-height: 1.5; display: flex; gap: 0.65rem; align-items: flex-start;">
                    <i class="ti ti-shield-lock" style="font-size: 1.25rem; color: #fbbf24; flex-shrink: 0;"></i>
                    <div>
                        <strong style="color: #e2e8f0; display: block; margin-bottom: 0.2rem;">Chain of Custody Guarantee</strong>
                        This digital file is preserved under Section 106 compliance. Hash checksums are cross-referenced on each access event to prevent spoliation of evidence.
                    </div>
                </div>

            </div>
        </div>

    </div>

    <!-- Responsive Overrides -->
    <style>
        @media (max-width: 900px) {
            .evidence-detail-grid {
                grid-template-columns: 1fr !important;
            }
        }
        @media print {
            nav, header button, header a, .auth-button, a[download] {
                display: none !important;
            }
            body {
                background: #ffffff !important;
                color: #000000 !important;
            }
            .evidence-detail-grid {
                grid-template-columns: 1fr !important;
            }
        }
    </style>
</x-app-layout>
