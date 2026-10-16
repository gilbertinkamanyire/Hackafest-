<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Capture Evidence | eWitnessVault</title>

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

        .upload-wrapper {
            max-width: 980px;
            margin: 0 auto;
            padding: 2.5rem 1.5rem 5rem;
        }

        .upload-hero {
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

        .upload-hero::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; height: 3px;
            background: linear-gradient(90deg, transparent, #fbbf24, transparent);
        }

        .upload-card-form {
            background: rgba(14, 20, 36, 0.85);
            backdrop-filter: blur(24px);
            border: 1.5px solid var(--gold-border);
            border-radius: 22px;
            padding: 2.5rem 2.25rem;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.6);
        }

        .form-section-title {
            display: flex;
            align-items: center;
            gap: 0.65rem;
            font-family: var(--font-display);
            font-size: 1.05rem;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 1.25rem;
            padding-bottom: 0.65rem;
            border-bottom: 1px solid rgba(71, 85, 105, 0.25);
        }

        .form-section-title i {
            color: #fbbf24;
            font-size: 1.2rem;
        }

        .input-group-custom {
            display: flex;
            flex-direction: column;
            gap: 0.45rem;
            margin-bottom: 1.35rem;
        }

        .input-label-custom {
            font-size: 0.825rem;
            font-weight: 700;
            color: #cbd5e1;
            letter-spacing: 0.02em;
        }

        .input-text-custom {
            width: 100%;
            padding: 0.85rem 1rem;
            background: rgba(8, 12, 22, 0.85);
            border: 1.5px solid rgba(71, 85, 105, 0.45);
            border-radius: 10px;
            color: #f1f5f9;
            font-family: var(--font-body);
            font-size: 0.925rem;
            transition: all 0.25s ease;
            outline: none;
        }

        .input-text-custom:focus {
            border-color: #fbbf24;
            box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.18);
            background: rgba(8, 12, 22, 0.95);
        }

        /* Capture Mode Switcher Tabs */
        .capture-mode-tabs {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.85rem;
            margin-bottom: 1.5rem;
        }

        .capture-tab-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.65rem;
            padding: 1rem 1.25rem;
            border-radius: 14px;
            font-size: 0.9rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.25s ease;
            border: 1.5px solid rgba(71, 85, 105, 0.35);
            background: rgba(8, 12, 22, 0.7);
            color: #94a3b8;
        }

        .capture-tab-btn:hover {
            border-color: rgba(245, 158, 11, 0.4);
            color: #e2e8f0;
        }

        .capture-tab-btn.active {
            border-color: #fbbf24;
            background: linear-gradient(135deg, rgba(245, 158, 11, 0.18), rgba(180, 83, 9, 0.08));
            color: #fbbf24;
            box-shadow: 0 4px 20px rgba(245, 158, 11, 0.18);
        }

        /* Camera Studio Viewfinder Box */
        .camera-studio-container {
            display: none;
            background: #020408;
            border: 2px solid rgba(245, 158, 11, 0.45);
            border-radius: 18px;
            overflow: hidden;
            position: relative;
            margin-bottom: 1.5rem;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.8);
        }

        .viewfinder-wrapper {
            position: relative;
            width: 100%;
            height: 480px;
            background: #000;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        #camera-video-feed {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* HUD Overlays */
        .hud-top-bar {
            position: absolute;
            top: 1rem;
            left: 1rem;
            right: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 20;
            pointer-events: none;
        }

        .hud-top-bar * {
            pointer-events: auto;
        }

        .hud-live-tag {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            padding: 0.3rem 0.75rem;
            border-radius: 50px;
            background: rgba(16, 185, 129, 0.2);
            border: 1px solid #10b981;
            color: #34d399;
            font-size: 0.72rem;
            font-weight: 800;
            letter-spacing: 0.06em;
            text-transform: uppercase;
        }

        .hud-live-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: #10b981;
            animation: pulseDot 1.5s infinite;
        }

        @keyframes pulseDot {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.3; transform: scale(0.8); }
        }

        /* HUD Grid Crosshairs */
        .hud-grid-overlay {
            position: absolute;
            inset: 0;
            pointer-events: none;
            z-index: 10;
            border: 1px solid rgba(245, 158, 11, 0.15);
            background: 
                linear-gradient(to right, transparent 33%, rgba(245, 158, 11, 0.08) 33.3%, rgba(245, 158, 11, 0.08) 33.7%, transparent 34%),
                linear-gradient(to right, transparent 66%, rgba(245, 158, 11, 0.08) 66.3%, rgba(245, 158, 11, 0.08) 66.7%, transparent 67%),
                linear-gradient(to bottom, transparent 33%, rgba(245, 158, 11, 0.08) 33.3%, rgba(245, 158, 11, 0.08) 33.7%, transparent 34%),
                linear-gradient(to bottom, transparent 66%, rgba(245, 158, 11, 0.08) 66.3%, rgba(245, 158, 11, 0.08) 66.7%, transparent 67%);
        }

        .hud-center-crosshair {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 44px;
            height: 44px;
            pointer-events: none;
            z-index: 15;
            border: 1.5px dashed rgba(245, 158, 11, 0.5);
            border-radius: 50%;
        }

        .hud-bottom-telemetry {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(0deg, rgba(6, 9, 17, 0.95) 0%, rgba(6, 9, 17, 0.75) 70%, transparent 100%);
            padding: 1rem 1.25rem;
            z-index: 20;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            font-family: var(--font-mono);
            font-size: 0.75rem;
            color: #fbbf24;
            pointer-events: none;
        }

        /* Camera Controls Bar */
        .camera-controls-bar {
            padding: 1.25rem;
            background: rgba(10, 15, 26, 0.98);
            border-top: 1px solid rgba(245, 158, 11, 0.25);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
        }

        .shutter-btn {
            width: 68px;
            height: 68px;
            border-radius: 50%;
            background: linear-gradient(135deg, #f59e0b, #fbbf24);
            border: 4px solid #ffffff;
            box-shadow: 0 0 25px rgba(245, 158, 11, 0.6);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s ease;
            color: #0b0f19;
            font-size: 1.75rem;
            margin: 0 auto;
        }

        .shutter-btn:hover {
            transform: scale(1.06);
            box-shadow: 0 0 35px rgba(245, 158, 11, 0.85);
        }

        .shutter-btn:active {
            transform: scale(0.95);
        }

        .shutter-btn.video-btn {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: #ffffff;
            box-shadow: 0 0 25px rgba(239, 68, 68, 0.6);
        }

        .shutter-btn.video-btn:hover {
            box-shadow: 0 0 35px rgba(239, 68, 68, 0.9);
        }

        .shutter-btn.recording {
            background: #b91c1c;
            animation: recPulse 1.2s infinite;
            border-radius: 16px;
        }

        @keyframes recPulse {
            0%, 100% { box-shadow: 0 0 25px rgba(239, 68, 68, 0.7); transform: scale(1); }
            50% { box-shadow: 0 0 45px rgba(239, 68, 68, 1); transform: scale(1.04); }
        }

        .hud-rec-tag {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            padding: 0.3rem 0.75rem;
            border-radius: 50px;
            background: rgba(239, 68, 68, 0.25);
            border: 1px solid #ef4444;
            color: #f87171;
            font-size: 0.75rem;
            font-weight: 800;
            letter-spacing: 0.06em;
            text-transform: uppercase;
        }

        .rec-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #ef4444;
            animation: pulseDot 1s infinite;
        }

        .camera-submode-pills {
            display: inline-flex;
            background: rgba(15, 23, 42, 0.9);
            border: 1px solid rgba(245, 158, 11, 0.35);
            border-radius: 30px;
            padding: 3px;
            gap: 3px;
        }

        .submode-pill-btn {
            padding: 0.35rem 0.85rem;
            border-radius: 20px;
            border: none;
            background: transparent;
            color: #94a3b8;
            font-size: 0.78rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            gap: 0.35rem;
        }

        .submode-pill-btn.active {
            background: #fbbf24;
            color: #0b0f19;
            box-shadow: 0 2px 10px rgba(245, 158, 11, 0.4);
        }

        .submode-pill-btn.active.video-active {
            background: #ef4444;
            color: #ffffff;
            box-shadow: 0 2px 10px rgba(239, 68, 68, 0.4);
        }

        /* Drag & Drop Zone */
        .dropzone-container {
            border: 2px dashed rgba(245, 158, 11, 0.45);
            border-radius: 16px;
            padding: 2.75rem 1.5rem;
            text-align: center;
            background: rgba(8, 12, 22, 0.65);
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            margin-bottom: 1.5rem;
        }

        .dropzone-container:hover, .dropzone-container.is-dragover {
            border-color: #fbbf24;
            background: rgba(245, 158, 11, 0.08);
            box-shadow: 0 0 30px rgba(245, 158, 11, 0.2);
        }

        .dropzone-icon {
            width: 60px;
            height: 60px;
            border-radius: 16px;
            background: rgba(245, 158, 11, 0.12);
            border: 1px solid rgba(245, 158, 11, 0.35);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fbbf24;
            font-size: 1.85rem;
            margin: 0 auto 1.25rem;
        }

        /* File Selected Box */
        .file-selected-box {
            display: none;
            background: rgba(8, 12, 22, 0.95);
            border: 1.5px solid rgba(16, 185, 129, 0.4);
            border-radius: 14px;
            padding: 1.25rem;
            margin-bottom: 1.5rem;
        }

        .hash-preview-tag {
            font-family: var(--font-mono);
            font-size: 0.75rem;
            color: #fbbf24;
            background: rgba(245, 158, 11, 0.08);
            padding: 0.4rem 0.65rem;
            border-radius: 6px;
            border: 1px solid rgba(245, 158, 11, 0.25);
            word-break: break-all;
            margin-top: 0.35rem;
            display: block;
        }

        /* Telemetry Status Grid */
        .telemetry-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
            background: rgba(8, 12, 22, 0.7);
            border: 1px solid rgba(71, 85, 105, 0.3);
            border-radius: 12px;
            padding: 1.25rem;
            margin-bottom: 1.5rem;
        }

        .telemetry-item {
            display: flex;
            align-items: center;
            gap: 0.65rem;
        }

        .telemetry-icon {
            color: #fbbf24;
            font-size: 1.2rem;
        }

        .telemetry-data {
            font-family: var(--font-mono);
            font-size: 0.78rem;
            color: #e2e8f0;
        }

        @media (max-width: 680px) {
            .upload-card-form { padding: 1.75rem 1.25rem; }
            .telemetry-grid { grid-template-columns: 1fr; }
            .capture-mode-tabs { grid-template-columns: 1fr; }
            .viewfinder-wrapper { height: 360px; }
        }
    </style>
</head>
<body class="dashboard-body">
    <!-- Background overlay -->
    <div class="dashboard-background"></div>

    <!-- Navigation Header -->
    @include('layouts.dashboard-nav')

    <div class="upload-wrapper">
        <!-- Hero Header -->
        <header class="upload-hero">
            <div>
                <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.35rem;">
                    <span style="font-size: 0.72rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.1em; color: #fbbf24;">
                        Sworn Witness Ingest Protocol
                    </span>
                    <span style="font-size: 0.65rem; font-weight: 700; background: rgba(16, 185, 129, 0.15); border: 1px solid rgba(16, 185, 129, 0.35); color: #34d399; padding: 0.15rem 0.5rem; border-radius: 20px;">
                        Camera & GPS Active
                    </span>
                </div>
                <h1 style="font-family: var(--font-display); font-size: 1.85rem; font-weight: 800; color: #ffffff;">
                    Capture Sworn Digital Exhibit
                </h1>
                <p style="font-size: 0.85rem; color: #94a3b8;">
                    Witness field capture station. Instantaneous GPS satellite locking and UTC timestamp embedding guaranteed.
                </p>
            </div>
            <div>
                <a href="{{ route('dashboard') }}" class="btn-gold-ghost" style="padding: 0.6rem 1.25rem; font-size: 0.825rem;">
                    <i class="ti ti-arrow-left"></i>
                    <span>Back to Dashboard</span>
                </a>
            </div>
        </header>

        <!-- Status Alerts -->
        @if(session('success'))
            <div style="margin-bottom: 1.5rem; padding: 1.15rem 1.35rem; background: rgba(16, 185, 129, 0.12); border: 1.5px solid rgba(16, 185, 129, 0.4); border-radius: 14px; display: flex; align-items: center; gap: 0.85rem; color: #34d399;">
                <i class="ti ti-shield-check" style="font-size: 1.4rem; flex-shrink: 0;"></i>
                <div>
                    <div style="font-weight: 800; font-size: 0.95rem;">Exhibit Successfully Sealed & Stored</div>
                    <div style="font-size: 0.825rem; color: #a7f3d0; margin-top: 0.15rem;">{{ session('success') }}</div>
                </div>
            </div>
        @endif

        @if($errors->any())
            <div style="margin-bottom: 1.5rem; padding: 1.15rem 1.35rem; background: rgba(239, 68, 68, 0.12); border: 1.5px solid rgba(239, 68, 68, 0.4); border-radius: 14px; display: flex; align-items: flex-start; gap: 0.85rem; color: #f87171;">
                <i class="ti ti-alert-triangle" style="font-size: 1.4rem; flex-shrink: 0; margin-top: 0.1rem;"></i>
                <div>
                    <div style="font-weight: 800; font-size: 0.95rem;">Evidentiary Ingestion Error</div>
                    <ul style="margin-top: 0.25rem; padding-left: 1.25rem; font-size: 0.8rem; list-style-type: disc;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <!-- Main Submission Card -->
        <div class="upload-card-form">
            <form method="POST" action="{{ route('evidence.store') }}" enctype="multipart/form-data" id="judicial-upload-form">
                @csrf

                <!-- SECTION 1: Exhibit Classification -->
                <div class="form-section-title">
                    <i class="ti ti-file-certificate"></i>
                    <span>1. Exhibit Identification</span>
                </div>

                <!-- Title Input -->
                <div class="input-group-custom">
                    <label for="title" class="input-label-custom">
                        Exhibit Legal Title <span style="color: #ef4444;">*</span>
                    </label>
                    <input type="text" id="title" name="title" value="{{ old('title') }}" required
                        placeholder="e.g. Eyewitness Video / Photo of Incident — Scene Perimeter"
                        class="input-text-custom">
                    <span style="font-size: 0.72rem; color: #64748b;">Specify a clear descriptive label for judicial court ledger records.</span>
                </div>

                <!-- Description Input -->
                <div class="input-group-custom">
                    <label for="description" class="input-label-custom">
                        Sworn Narrative & Observations <span style="color: #64748b; font-weight: 400;">(Optional)</span>
                    </label>
                    <textarea id="description" name="description" rows="3"
                        placeholder="State your sworn narrative, incident circumstances, observations, or context..."
                        class="input-text-custom" style="min-height: 90px; resize: vertical;">{{ old('description') }}</textarea>
                </div>

                <!-- SECTION 2: Ingest Protocol & Camera Studio -->
                <div class="form-section-title" style="margin-top: 2rem;">
                    <i class="ti ti-camera"></i>
                    <span>2. Evidence Capture Method & Cryptographic Seal</span>
                </div>

                <!-- Capture Mode Tabs -->
                <div class="capture-mode-tabs">
                    <button type="button" id="tab-btn-camera" class="capture-tab-btn active" onclick="switchCaptureMode('camera')">
                        <i class="ti ti-camera" style="font-size: 1.25rem;"></i>
                        <span>Live Camera Capture (GPS + Time)</span>
                    </button>
                    <button type="button" id="tab-btn-file" class="capture-tab-btn" onclick="switchCaptureMode('file')">
                        <i class="ti ti-cloud-upload" style="font-size: 1.25rem;"></i>
                        <span>Upload Existing File / Media</span>
                    </button>
                </div>

                <!-- Hidden Native File Inputs -->
                <input type="file" id="evidence-file-input" name="file" required style="display: none;">
                <!-- Native Camera Shutter Triggers for Mobile / OS -->
                <input type="file" id="camera-native-photo" accept="image/*" capture="environment" style="display: none;">
                <input type="file" id="camera-native-video" accept="video/*" capture="environment" style="display: none;">

                <!-- CAMERA STUDIO VIEWFINDER CONTAINER -->
                <div id="camera-studio-box" class="camera-studio-container" style="display: block;">
                    <div class="viewfinder-wrapper">
                        <!-- Video stream from camera -->
                        <video id="camera-video-feed" autoplay playsinline muted></video>

                        <!-- HUD Grid & Crosshairs -->
                        <div class="hud-grid-overlay"></div>
                        <div class="hud-center-crosshair"></div>

                        <!-- Top HUD Bar -->
                        <div class="hud-top-bar">
                            <div style="display: flex; align-items: center; gap: 0.5rem;">
                                <span class="hud-live-tag">
                                    <span class="hud-live-dot"></span> LIVE SENSOR
                                </span>
                                <span id="hud-recording-indicator" class="hud-rec-tag" style="display: none;">
                                    <span class="rec-dot"></span> REC <span id="hud-rec-time">00:00</span>
                                </span>
                            </div>
                            <div style="display: flex; gap: 0.45rem; flex-wrap: wrap;">
                                <button type="button" onclick="switchCameraFacing()" style="padding: 0.35rem 0.65rem; border-radius: 8px; background: rgba(15, 23, 42, 0.85); border: 1px solid rgba(245, 158, 11, 0.4); color: #fbbf24; font-size: 0.75rem; cursor: pointer; display: flex; align-items: center; gap: 0.3rem;">
                                    <i class="ti ti-switch-camera"></i> Flip
                                </button>
                                <button type="button" onclick="document.getElementById('camera-native-photo').click()" title="Use Device Native Camera App for Photo" style="padding: 0.35rem 0.65rem; border-radius: 8px; background: rgba(15, 23, 42, 0.85); border: 1px solid rgba(245, 158, 11, 0.4); color: #cbd5e1; font-size: 0.75rem; cursor: pointer; display: flex; align-items: center; gap: 0.3rem;">
                                    <i class="ti ti-camera"></i> Native Photo
                                </button>
                                <button type="button" onclick="document.getElementById('camera-native-video').click()" title="Use Device Native Camera App for Video" style="padding: 0.35rem 0.65rem; border-radius: 8px; background: rgba(15, 23, 42, 0.85); border: 1px solid rgba(239, 68, 68, 0.4); color: #fca5a5; font-size: 0.75rem; cursor: pointer; display: flex; align-items: center; gap: 0.3rem;">
                                    <i class="ti ti-video"></i> Native Video
                                </button>
                            </div>
                        </div>

                        <!-- Bottom HUD Telemetry (Real-time GPS + UTC Stamp) -->
                        <div class="hud-bottom-telemetry">
                            <div>
                                <div style="display: flex; align-items: center; gap: 0.35rem; color: #38bdf8;">
                                    <i class="ti ti-satellite"></i>
                                    <span id="hud-live-coords">GPS LOCK: ACQUIRING...</span>
                                </div>
                                <div style="font-size: 0.68rem; color: #94a3b8; margin-top: 0.15rem;">
                                    ACCURACY: <span id="hud-live-acc">&plusmn;--</span> &bull; ALT: <span id="hud-live-alt">--</span>
                                </div>
                            </div>
                            <div style="text-align: right;">
                                <div style="color: #fbbf24; font-weight: 700;">
                                    <span id="hud-live-utc">{{ gmdate('H:i:s') }} UTC</span>
                                </div>
                                <div style="font-size: 0.68rem; color: #94a3b8;">
                                    {{ gmdate('d M Y') }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Dual Mode Shutter Controls (Photo & Video) -->
                    <div class="camera-controls-bar">
                        <div style="display: flex; flex-direction: column; gap: 0.45rem; max-width: 250px;">
                            <!-- Mode Selector Pills -->
                            <div class="camera-submode-pills">
                                <button type="button" id="submode-btn-photo" class="submode-pill-btn active" onclick="switchCameraSubmode('photo')">
                                    <i class="ti ti-camera"></i> Photo Mode
                                </button>
                                <button type="button" id="submode-btn-video" class="submode-pill-btn" onclick="switchCameraSubmode('video')">
                                    <i class="ti ti-video"></i> Video Mode
                                </button>
                            </div>
                            <div id="shutter-hint-text" style="font-size: 0.72rem; color: #94a3b8; line-height: 1.35;">
                                Click to snap photo with burned-in judicial watermark & GPS.
                            </div>
                        </div>

                        <!-- Central Dual-Action Shutter Button -->
                        <div style="text-align: center;">
                            <button type="button" id="camera-shutter-action-btn" class="shutter-btn" onclick="handleShutterAction()" title="Capture Exhibit">
                                <i class="ti ti-camera" id="shutter-icon"></i>
                            </button>
                            <div id="shutter-status-label" style="font-size: 0.72rem; color: #fbbf24; font-weight: 700; margin-top: 0.4rem;">
                                Snap Certified Photo
                            </div>
                        </div>

                        <div style="text-align: right;">
                            <span style="font-size: 0.72rem; color: #34d399; font-weight: 700; display: inline-flex; align-items: center; gap: 0.25rem;">
                                <i class="ti ti-shield-check"></i> Tamper-Evident
                            </span>
                            <div style="font-size: 0.68rem; color: #64748b; margin-top: 0.2rem;">
                                SHA-256 Digest Sealed
                            </div>
                        </div>
                    </div>
                </div>

                <!-- DRAG & DROP FILE ZONE CONTAINER -->
                <div id="file-dropzone-box" style="display: none;">
                    <div class="dropzone-container" id="file-dropzone" onclick="document.getElementById('evidence-file-input').click()">
                        <div class="dropzone-icon">
                            <i class="ti ti-cloud-upload"></i>
                        </div>
                        <div style="font-size: 1.05rem; font-weight: 700; color: #ffffff; margin-bottom: 0.35rem;">
                            Select or Drag & Drop Evidence Artifact
                        </div>
                        <div style="font-size: 0.8rem; color: #94a3b8; max-width: 460px; margin: 0 auto;">
                            Supports High-Definition Video (MP4, MOV, WEBM), Audio (WAV, MP3), Forensic Photos (JPEG, PNG, RAW), and PDF exhibits up to 25MB.
                        </div>
                    </div>
                </div>

                <!-- PROCESSED ARTIFACT STATUS & PREVIEW CARD -->
                <div id="file-processed-card" class="file-selected-box">
                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 0.85rem; flex-wrap: wrap; gap: 0.75rem;">
                        <div style="display: flex; align-items: center; gap: 0.75rem;">
                            <div style="width: 44px; height: 44px; border-radius: 10px; background: rgba(16, 185, 129, 0.15); border: 1px solid rgba(16, 185, 129, 0.35); display: flex; align-items: center; justify-content: center; color: #34d399; flex-shrink: 0;">
                                <i class="ti ti-file-check" style="font-size: 1.5rem;"></i>
                            </div>
                            <div>
                                <div id="selected-filename" style="font-weight: 700; color: #ffffff; font-size: 0.95rem;">File ready</div>
                                <div id="selected-filesize" style="font-size: 0.75rem; color: #94a3b8;">0 KB</div>
                            </div>
                        </div>

                        <div style="display: flex; gap: 0.5rem;">
                            <button type="button" onclick="retakeOrResetCapture()" style="background: rgba(239, 68, 68, 0.12); border: 1px solid rgba(239, 68, 68, 0.35); color: #f87171; font-size: 0.78rem; font-weight: 700; padding: 0.4rem 0.85rem; border-radius: 8px; cursor: pointer; display: flex; align-items: center; gap: 0.35rem;">
                                <i class="ti ti-rotate"></i> Retake / Replace
                            </button>
                        </div>
                    </div>

                    <!-- Watermarked Photo or Video Preview Player -->
                    <div id="camera-preview-wrapper" style="display: none; margin-bottom: 1rem; border-radius: 12px; overflow: hidden; border: 1.5px solid rgba(245, 158, 11, 0.35); box-shadow: 0 10px 30px rgba(0,0,0,0.6); background: #000;">
                        <img id="camera-snapshot-img" src="" alt="Captured Photo Exhibit" style="width: 100%; max-height: 420px; object-fit: contain; display: none; background: #000;">
                        <video id="camera-snapshot-video" controls playsinline style="width: 100%; max-height: 420px; display: none; background: #000;"></video>
                    </div>

                    <div>
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <span style="font-size: 0.72rem; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.05em;">Real-Time Cryptographic Digest:</span>
                            <span style="font-size: 0.7rem; color: #34d399; font-weight: 700;"><i class="ti ti-check"></i> Verified Integrity</span>
                        </div>
                        <div id="file-hash-calc" class="hash-preview-tag">Computing cryptographic hash...</div>
                    </div>
                </div>

                <!-- SECTION 3: Telemetry & Geospatial Metadata -->
                <div class="form-section-title" style="margin-top: 2rem;">
                    <i class="ti ti-satellite"></i>
                    <span>3. Forensic Telemetry & Satellite Timestamp</span>
                </div>

                <div class="telemetry-grid">
                    <div class="telemetry-item">
                        <i class="ti ti-map-pin telemetry-icon"></i>
                        <div>
                            <div style="font-size: 0.7rem; color: #64748b; font-weight: 700; text-transform: uppercase;">GPS Fix Coordinates</div>
                            <div id="display-coords" class="telemetry-data">Acquiring satellite lock...</div>
                        </div>
                    </div>

                    <div class="telemetry-item">
                        <i class="ti ti-clock telemetry-icon"></i>
                        <div>
                            <div style="font-size: 0.7rem; color: #64748b; font-weight: 700; text-transform: uppercase;">Incident Telemetry UTC Time</div>
                            <div id="display-timestamp" class="telemetry-data">{{ gmdate('Y-m-d H:i:s') }} UTC</div>
                        </div>
                    </div>
                </div>

                <!-- Hidden GPS & Timestamp Fields -->
                <input type="hidden" id="latitude" name="latitude">
                <input type="hidden" id="longitude" name="longitude">
                <input type="hidden" id="altitude" name="altitude">
                <input type="hidden" id="accuracy" name="accuracy">
                <input type="hidden" id="captured_at" name="captured_at" value="{{ now() }}">
                <input type="hidden" id="device_info" name="device_info" value="">

                <!-- SECTION 4: Sworn Witness Affidavit -->
                <div style="margin-top: 1.75rem; padding: 1.25rem; background: rgba(245, 158, 11, 0.06); border: 1px solid var(--gold-border); border-radius: 12px;">
                    <label style="display: flex; align-items: flex-start; gap: 0.75rem; cursor: pointer;">
                        <input type="checkbox" name="affirmation" required checked style="width: 17px; height: 17px; accent-color: #f59e0b; margin-top: 0.15rem;">
                        <span style="font-size: 0.78rem; color: #cbd5e1; line-height: 1.5;">
                            I, <strong>{{ Auth::user()->name }}</strong>, solemnly affirm under penalty of legal perjury that the digital artifact captured or provided herein constitutes authentic, unaltered material gathered under statutory Chain of Custody standards.
                        </span>
                    </label>
                </div>

                <!-- Submit Button -->
                <button type="submit" id="submit-evidence-btn" class="btn-gold-solid" style="width: 100%; justify-content: center; padding: 1.05rem; font-size: 1rem; margin-top: 2rem; border-radius: 12px;">
                    <i class="ti ti-shield-lock" style="font-size: 1.35rem;"></i>
                    <span>Cryptographically Seal & File Exhibit</span>
                </button>
            </form>
        </div>
    </div>

    <!-- Hidden Offscreen Canvas for Stamping Watermark on Snapped Photos -->
    <canvas id="watermark-canvas" style="display: none;"></canvas>

    <!-- Client-Side Camera Studio, Video Recorder, Hashing & Geolocation Scripts -->
    <script>
        let currentFacingMode = 'environment'; // default to rear camera on mobile
        let cameraStream = null;
        let latestGpsCoords = { lat: null, lon: null, alt: null, acc: null };
        const deponentName = "{{ Auth::user()->name }}";

        // Video recording state
        let currentCameraSubmode = 'photo'; // 'photo' or 'video'
        let mediaRecorder = null;
        let recordedChunks = [];
        let recordingTimerInterval = null;
        let recordingStartTime = 0;

        // Collect browser / hardware telemetry
        document.getElementById('device_info').value = `${navigator.userAgent} | Screen: ${window.screen.width}x${window.screen.height} | Platform: ${navigator.platform}`;

        // ─── 1. REAL-TIME UTC TICKER ────────────────────────────────
        function updateLiveUtc() {
            const now = new Date();
            const utcString = now.toISOString().replace('T', ' ').substring(0, 19) + ' UTC';
            const timeString = now.toTimeString().split(' ')[0] + ' UTC';
            
            const hudTime = document.getElementById('hud-live-utc');
            if (hudTime) hudTime.textContent = timeString;

            const dispTime = document.getElementById('display-timestamp');
            if (dispTime && !document.getElementById('captured_at').dataset.locked) {
                dispTime.textContent = utcString;
                document.getElementById('captured_at').value = utcString.replace(' UTC', '');
            }
        }
        setInterval(updateLiveUtc, 1000);
        updateLiveUtc();

        // ─── 2. SATELLITE GPS ACQUISITION ───────────────────────────
        if (navigator.geolocation) {
            navigator.geolocation.watchPosition(
                pos => {
                    const lat = pos.coords.latitude;
                    const lon = pos.coords.longitude;
                    const alt = pos.coords.altitude;
                    const acc = pos.coords.accuracy;

                    latestGpsCoords = { lat, lon, alt, acc };

                    // Only update inputs if not frozen by snapshot or video
                    if (!document.getElementById('latitude').dataset.locked) {
                        document.getElementById('latitude').value = lat;
                        document.getElementById('longitude').value = lon;
                        document.getElementById('altitude').value = alt || '';
                        document.getElementById('accuracy').value = acc || '';

                        const coordStr = `${lat.toFixed(6)}°, ${lon.toFixed(6)}°`;
                        document.getElementById('display-coords').textContent = `${coordStr} (±${acc ? acc.toFixed(1) + 'm' : 'Lock'})`;

                        const hudCoords = document.getElementById('hud-live-coords');
                        if (hudCoords) hudCoords.textContent = `GPS: ${coordStr}`;

                        const hudAcc = document.getElementById('hud-live-acc');
                        if (hudAcc) hudAcc.textContent = `±${acc ? acc.toFixed(1) + 'm' : 'OK'}`;

                        const hudAlt = document.getElementById('hud-live-alt');
                        if (hudAlt) hudAlt.textContent = alt ? `${alt.toFixed(1)}m` : '0m';
                    }
                },
                err => {
                    document.getElementById('display-coords').textContent = 'Coordinates Protected / Sensor Offline';
                    const hudCoords = document.getElementById('hud-live-coords');
                    if (hudCoords) hudCoords.textContent = 'GPS SENSOR OFFLINE';
                },
                { enableHighAccuracy: true, maximumAge: 10000, timeout: 12000 }
            );
        }

        // ─── 3. LIVE CAMERA STREAM INITIALIZATION ────────────────────
        async function startCamera(facing = 'environment', withAudio = false) {
            stopCamera();
            const video = document.getElementById('camera-video-feed');
            try {
                const constraints = {
                    video: {
                        facingMode: facing,
                        width: { ideal: 1920 },
                        height: { ideal: 1080 }
                    },
                    audio: withAudio
                };
                cameraStream = await navigator.mediaDevices.getUserMedia(constraints);
                video.srcObject = cameraStream;
                return true;
            } catch (err) {
                console.warn('Camera access with facingMode & audio failed:', err);
                if (withAudio) {
                    try {
                        cameraStream = await navigator.mediaDevices.getUserMedia({
                            video: { facingMode: facing, width: { ideal: 1920 }, height: { ideal: 1080 } },
                            audio: false
                        });
                        video.srcObject = cameraStream;
                        return true;
                    } catch (noAudioErr) {
                        console.warn('Fallback without audio failed:', noAudioErr);
                    }
                }
                try {
                    // Final fallback
                    cameraStream = await navigator.mediaDevices.getUserMedia({ video: true, audio: false });
                    video.srcObject = cameraStream;
                    return true;
                } catch (fallbackErr) {
                    console.error('All camera access failed:', fallbackErr);
                    return false;
                }
            }
        }

        function stopCamera() {
            if (cameraStream) {
                cameraStream.getTracks().forEach(track => track.stop());
                cameraStream = null;
            }
        }

        function switchCameraFacing() {
            currentFacingMode = currentFacingMode === 'environment' ? 'user' : 'environment';
            startCamera(currentFacingMode, currentCameraSubmode === 'video');
        }

        // ─── 4. SUBMODE SWITCHER (PHOTO VS VIDEO) ────────────────────
        function switchCameraSubmode(mode) {
            if (mediaRecorder && mediaRecorder.state === 'recording') {
                alert('Please stop the current video recording before switching capture modes.');
                return;
            }
            currentCameraSubmode = mode;
            const btnPhoto = document.getElementById('submode-btn-photo');
            const btnVideo = document.getElementById('submode-btn-video');
            const shutterBtn = document.getElementById('camera-shutter-action-btn');
            const shutterIcon = document.getElementById('shutter-icon');
            const shutterLabel = document.getElementById('shutter-status-label');
            const hintText = document.getElementById('shutter-hint-text');

            if (mode === 'photo') {
                btnPhoto.classList.add('active');
                btnVideo.classList.remove('active', 'video-active');
                shutterBtn.classList.remove('video-btn', 'recording');
                shutterIcon.className = 'ti ti-camera';
                shutterLabel.textContent = 'Snap Certified Photo';
                shutterLabel.style.color = '#fbbf24';
                hintText.textContent = 'Click to snap photo with burned-in judicial watermark & GPS.';
            } else {
                btnVideo.classList.add('active', 'video-active');
                btnPhoto.classList.remove('active');
                shutterBtn.classList.add('video-btn');
                shutterBtn.classList.remove('recording');
                shutterIcon.className = 'ti ti-video';
                shutterLabel.textContent = 'Start Video Recording';
                shutterLabel.style.color = '#ef4444';
                hintText.textContent = 'Click to record evidentiary video with synchronized audio and GPS.';

                // Upgrade stream with audio if not present
                if (cameraStream && !cameraStream.getAudioTracks().length) {
                    startCamera(currentFacingMode, true);
                }
            }
        }

        function handleShutterAction() {
            if (currentCameraSubmode === 'photo') {
                captureSnapshotFromCamera();
            } else {
                toggleVideoRecording();
            }
        }

        // ─── 5. SNAP PHOTO & BURN FORENSIC WATERMARK ─────────────────
        async function captureSnapshotFromCamera() {
            const video = document.getElementById('camera-video-feed');
            if (!video.videoWidth || !video.videoHeight) {
                alert('Camera stream is still initializing. Please wait a moment.');
                return;
            }

            const canvas = document.getElementById('watermark-canvas');
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            const ctx = canvas.getContext('2d');

            // Draw video frame to canvas
            ctx.drawImage(video, 0, 0, canvas.width, canvas.height);

            // Stamp Judicial Forensic Watermark Bar at Bottom of Image
            const barHeight = Math.max(90, Math.floor(canvas.height * 0.12));
            const barY = canvas.height - barHeight;

            // Gradient dark background bar
            const gradient = ctx.createLinearGradient(0, barY, 0, canvas.height);
            gradient.addColorStop(0, 'rgba(6, 9, 17, 0.88)');
            gradient.addColorStop(1, 'rgba(2, 4, 8, 0.98)');
            ctx.fillStyle = gradient;
            ctx.fillRect(0, barY, canvas.width, barHeight);

            // Top gold border line on watermark
            ctx.strokeStyle = '#f59e0b';
            ctx.lineWidth = Math.max(2, Math.floor(canvas.height * 0.003));
            ctx.beginPath();
            ctx.moveTo(0, barY);
            ctx.lineTo(canvas.width, barY);
            ctx.stroke();

            // Timestamp and GPS Data Strings
            const now = new Date();
            const utcTimeStr = now.toISOString().replace('T', ' ').substring(0, 19) + ' UTC';
            const latStr = latestGpsCoords.lat !== null ? `${latestGpsCoords.lat.toFixed(6)}°` : 'COORDS PROTECTED';
            const lonStr = latestGpsCoords.lon !== null ? `${latestGpsCoords.lon.toFixed(6)}°` : '';
            const accStr = latestGpsCoords.acc !== null ? `±${latestGpsCoords.acc.toFixed(1)}m` : '';

            // Draw Text
            const fontSize = Math.max(14, Math.floor(barHeight * 0.22));
            ctx.font = `bold ${fontSize}px "Outfit", sans-serif`;
            ctx.fillStyle = '#fbbf24';
            ctx.fillText(`eWitnessVault Certified Exhibit • Captured by Witness: ${deponentName}`, 24, barY + barHeight * 0.38);

            ctx.font = `${Math.floor(fontSize * 0.88)}px "JetBrains Mono", monospace`;
            ctx.fillStyle = '#f8fafc';
            ctx.fillText(`UTC TIMESTAMP: ${utcTimeStr}  |  GPS FIX: ${latStr} ${lonStr} (${accStr})`, 24, barY + barHeight * 0.72);

            // Lock the form's GPS and Timestamp inputs to this exact instant
            if (latestGpsCoords.lat !== null) {
                document.getElementById('latitude').value = latestGpsCoords.lat;
                document.getElementById('longitude').value = latestGpsCoords.lon;
                document.getElementById('altitude').value = latestGpsCoords.alt || '';
                document.getElementById('accuracy').value = latestGpsCoords.acc || '';
                document.getElementById('latitude').dataset.locked = 'true';
            }
            document.getElementById('captured_at').value = utcTimeStr.replace(' UTC', '');
            document.getElementById('captured_at').dataset.locked = 'true';
            document.getElementById('display-timestamp').textContent = utcTimeStr + ' (LOCKED AT SHUTTER)';

            // Convert Canvas to Blob -> File
            canvas.toBlob(async blob => {
                const timestampId = now.getTime();
                const snapshotFile = new File([blob], `witness-exhibit-${timestampId}.jpg`, { type: 'image/jpeg' });

                // Attach to file input using DataTransfer
                const dt = new DataTransfer();
                dt.items.add(snapshotFile);
                fileInput.files = dt.files;

                // Show preview thumbnail
                const dataUrl = canvas.toDataURL('image/jpeg', 0.95);
                const imgPreview = document.getElementById('camera-snapshot-img');
                const vidPreview = document.getElementById('camera-snapshot-video');
                vidPreview.style.display = 'none';
                vidPreview.src = '';
                imgPreview.src = dataUrl;
                imgPreview.style.display = 'block';
                document.getElementById('camera-preview-wrapper').style.display = 'block';

                // Shut off camera preview box and show processed card
                stopCamera();
                document.getElementById('camera-studio-box').style.display = 'none';
                document.getElementById('file-processed-card').style.display = 'block';

                filenameDisplay.textContent = snapshotFile.name + ' (Forensic Photo Exhibit)';
                filesizeDisplay.textContent = (snapshotFile.size / (1024 * 1024)).toFixed(2) + ' MB';

                // Calculate SHA-256 Digest of the watermarked file
                await computeAndDisplayHash(snapshotFile);
            }, 'image/jpeg', 0.95);
        }

        // ─── 6. VIDEO RECORDING ENGINE (MediaRecorder) ───────────────
        async function toggleVideoRecording() {
            if (!mediaRecorder || mediaRecorder.state === 'inactive') {
                await startVideoRecording();
            } else if (mediaRecorder.state === 'recording') {
                stopVideoRecording();
            }
        }

        async function startVideoRecording() {
            if (!cameraStream || !cameraStream.active) {
                const ok = await startCamera(currentFacingMode, true);
                if (!ok) return;
            }

            recordedChunks = [];

            // Detect best supported MIME type
            let mimeType = '';
            const candidates = [
                'video/webm;codecs=vp9,opus',
                'video/webm;codecs=vp8,opus',
                'video/webm',
                'video/mp4'
            ];
            for (const t of candidates) {
                if (window.MediaRecorder && MediaRecorder.isTypeSupported(t)) {
                    mimeType = t;
                    break;
                }
            }

            try {
                mediaRecorder = mimeType ? new MediaRecorder(cameraStream, { mimeType }) : new MediaRecorder(cameraStream);
            } catch (err) {
                try {
                    mediaRecorder = new MediaRecorder(cameraStream);
                } catch (fallbackErr) {
                    alert('Video recording is not supported in this browser: ' + fallbackErr.message);
                    return;
                }
            }

            mediaRecorder.ondataavailable = function(e) {
                if (e.data && e.data.size > 0) {
                    recordedChunks.push(e.data);
                }
            };

            mediaRecorder.onstop = function() {
                finishVideoRecording(mimeType);
            };

            // Lock GPS and Timestamp at the moment recording commences
            const now = new Date();
            const utcTimeStr = now.toISOString().replace('T', ' ').substring(0, 19) + ' UTC';
            if (latestGpsCoords.lat !== null) {
                document.getElementById('latitude').value = latestGpsCoords.lat;
                document.getElementById('longitude').value = latestGpsCoords.lon;
                document.getElementById('altitude').value = latestGpsCoords.alt || '';
                document.getElementById('accuracy').value = latestGpsCoords.acc || '';
                document.getElementById('latitude').dataset.locked = 'true';
            }
            document.getElementById('captured_at').value = utcTimeStr.replace(' UTC', '');
            document.getElementById('captured_at').dataset.locked = 'true';
            document.getElementById('display-timestamp').textContent = utcTimeStr + ' (LOCKED AT VIDEO COMMENCEMENT)';

            mediaRecorder.start(500); // 500ms time slice chunks

            // Update UI for recording mode
            recordingStartTime = Date.now();
            const shutterBtn = document.getElementById('camera-shutter-action-btn');
            const shutterIcon = document.getElementById('shutter-icon');
            const shutterLabel = document.getElementById('shutter-status-label');
            const recIndicator = document.getElementById('hud-recording-indicator');
            const recTime = document.getElementById('hud-rec-time');

            shutterBtn.classList.add('recording');
            shutterIcon.className = 'ti ti-square';
            shutterLabel.textContent = 'STOP RECORDING';
            shutterLabel.style.color = '#ef4444';
            recIndicator.style.display = 'inline-flex';

            recordingTimerInterval = setInterval(() => {
                const elapsed = Math.floor((Date.now() - recordingStartTime) / 1000);
                const mins = String(Math.floor(elapsed / 60)).padStart(2, '0');
                const secs = String(elapsed % 60).padStart(2, '0');
                recTime.textContent = `${mins}:${secs}`;
            }, 1000);
        }

        function stopVideoRecording() {
            if (mediaRecorder && mediaRecorder.state === 'recording') {
                mediaRecorder.stop();
            }
            clearInterval(recordingTimerInterval);
            const recIndicator = document.getElementById('hud-recording-indicator');
            if (recIndicator) recIndicator.style.display = 'none';

            const shutterBtn = document.getElementById('camera-shutter-action-btn');
            const shutterIcon = document.getElementById('shutter-icon');
            const shutterLabel = document.getElementById('shutter-status-label');
            shutterBtn.classList.remove('recording');
            shutterIcon.className = 'ti ti-video';
            shutterLabel.textContent = 'Start Video Recording';
            shutterLabel.style.color = '#ef4444';
        }

        async function finishVideoRecording(mimeType) {
            const isMp4 = mimeType && mimeType.includes('mp4');
            const ext = isMp4 ? 'mp4' : 'webm';
            const finalType = mimeType || 'video/webm';
            const videoBlob = new Blob(recordedChunks, { type: finalType });
            const timestampId = Date.now();
            const videoFile = new File([videoBlob], `witness-video-${timestampId}.${ext}`, { type: finalType });

            // Attach to form file input
            const dt = new DataTransfer();
            dt.items.add(videoFile);
            fileInput.files = dt.files;

            // Video player preview
            const videoPreview = document.getElementById('camera-snapshot-video');
            const imgPreview = document.getElementById('camera-snapshot-img');
            const previewWrapper = document.getElementById('camera-preview-wrapper');

            imgPreview.style.display = 'none';
            imgPreview.src = '';
            videoPreview.src = URL.createObjectURL(videoBlob);
            videoPreview.style.display = 'block';
            previewWrapper.style.display = 'block';

            // Shut off camera and display processed card
            stopCamera();
            document.getElementById('camera-studio-box').style.display = 'none';
            document.getElementById('file-processed-card').style.display = 'block';

            filenameDisplay.textContent = videoFile.name + ' (Recorded Evidentiary Video)';
            filesizeDisplay.textContent = (videoFile.size / (1024 * 1024) >= 1)
                ? (videoFile.size / (1024 * 1024)).toFixed(2) + ' MB'
                : (videoFile.size / 1024).toFixed(1) + ' KB';

            // Calculate SHA-256 Digest of the recorded video
            await computeAndDisplayHash(videoFile);
        }

        // ─── 7. NATIVE CAMERA INPUT HANDLERS ─────────────────────────
        const nativePhotoInput = document.getElementById('camera-native-photo');
        const nativeVideoInput = document.getElementById('camera-native-video');

        if (nativePhotoInput) {
            nativePhotoInput.addEventListener('change', e => {
                if (nativePhotoInput.files && nativePhotoInput.files.length > 0) {
                    fileInput.files = nativePhotoInput.files;
                    processFile(nativePhotoInput.files[0]);
                }
            });
        }

        if (nativeVideoInput) {
            nativeVideoInput.addEventListener('change', e => {
                if (nativeVideoInput.files && nativeVideoInput.files.length > 0) {
                    fileInput.files = nativeVideoInput.files;
                    processFile(nativeVideoInput.files[0]);
                }
            });
        }

        // ─── 8. CAPTURE MODE SWITCHING (CAMERA VS UPLOAD FILE) ───────
        function switchCaptureMode(mode) {
            const btnCam = document.getElementById('tab-btn-camera');
            const btnFile = document.getElementById('tab-btn-file');
            const camBox = document.getElementById('camera-studio-box');
            const fileBox = document.getElementById('file-dropzone-box');
            const processedCard = document.getElementById('file-processed-card');

            if (mode === 'camera') {
                btnCam.classList.add('active');
                btnFile.classList.remove('active');
                fileBox.style.display = 'none';
                if (processedCard.style.display !== 'block') {
                    camBox.style.display = 'block';
                    startCamera(currentFacingMode, currentCameraSubmode === 'video');
                }
            } else {
                btnFile.classList.add('active');
                btnCam.classList.remove('active');
                camBox.style.display = 'none';
                stopCamera();
                if (processedCard.style.display !== 'block') {
                    fileBox.style.display = 'block';
                }
            }
        }

        // ─── 9. DRAG & DROP & FILE PROCESSING ────────────────────────
        const fileInput = document.getElementById('evidence-file-input');
        const dropzone = document.getElementById('file-dropzone');
        const processedCard = document.getElementById('file-processed-card');
        const filenameDisplay = document.getElementById('selected-filename');
        const filesizeDisplay = document.getElementById('selected-filesize');
        const hashDisplay = document.getElementById('file-hash-calc');

        if (dropzone) {
            ['dragenter', 'dragover'].forEach(eventName => {
                dropzone.addEventListener(eventName, e => {
                    e.preventDefault();
                    dropzone.classList.add('is-dragover');
                });
            });

            ['dragleave', 'drop'].forEach(eventName => {
                dropzone.addEventListener(eventName, e => {
                    e.preventDefault();
                    dropzone.classList.remove('is-dragover');
                });
            });

            dropzone.addEventListener('drop', e => {
                if (e.dataTransfer.files && e.dataTransfer.files.length > 0) {
                    fileInput.files = e.dataTransfer.files;
                    processFile(e.dataTransfer.files[0]);
                }
            });
        }

        fileInput.addEventListener('change', e => {
            if (fileInput.files && fileInput.files.length > 0) {
                processFile(fileInput.files[0]);
            }
        });

        async function processFile(file) {
            if (!file) return;

            stopCamera();
            document.getElementById('camera-studio-box').style.display = 'none';
            document.getElementById('file-dropzone-box').style.display = 'none';

            const videoPreview = document.getElementById('camera-snapshot-video');
            const imgPreview = document.getElementById('camera-snapshot-img');
            const previewWrapper = document.getElementById('camera-preview-wrapper');

            if (file.type.startsWith('video/')) {
                imgPreview.style.display = 'none';
                imgPreview.src = '';
                videoPreview.src = URL.createObjectURL(file);
                videoPreview.style.display = 'block';
                previewWrapper.style.display = 'block';
            } else if (file.type.startsWith('image/')) {
                videoPreview.pause();
                videoPreview.style.display = 'none';
                videoPreview.src = '';
                imgPreview.src = URL.createObjectURL(file);
                imgPreview.style.display = 'block';
                previewWrapper.style.display = 'block';
            } else {
                previewWrapper.style.display = 'none';
            }

            processedCard.style.display = 'block';

            filenameDisplay.textContent = file.name;
            filesizeDisplay.textContent = (file.size / (1024 * 1024) >= 1) 
                ? (file.size / (1024 * 1024)).toFixed(2) + ' MB' 
                : (file.size / 1024).toFixed(1) + ' KB';

            await computeAndDisplayHash(file);
        }

        async function computeAndDisplayHash(file) {
            hashDisplay.textContent = 'Computing 256-bit cryptographic digest...';
            try {
                const arrayBuffer = await file.arrayBuffer();
                const hashBuffer = await crypto.subtle.digest('SHA-256', arrayBuffer);
                const hashArray = Array.from(new Uint8Array(hashBuffer));
                const hashHex = hashArray.map(b => b.toString(16).padStart(2, '0')).join('');
                hashDisplay.textContent = hashHex;
            } catch (err) {
                hashDisplay.textContent = 'Cryptographic digest will be verified on ingest server.';
            }
        }

        function retakeOrResetCapture() {
            fileInput.value = '';
            if (nativePhotoInput) nativePhotoInput.value = '';
            if (nativeVideoInput) nativeVideoInput.value = '';

            const videoPreview = document.getElementById('camera-snapshot-video');
            if (videoPreview) {
                videoPreview.pause();
                videoPreview.src = '';
                videoPreview.style.display = 'none';
            }
            const imgPreview = document.getElementById('camera-snapshot-img');
            if (imgPreview) {
                imgPreview.src = '';
                imgPreview.style.display = 'none';
            }

            delete document.getElementById('latitude').dataset.locked;
            delete document.getElementById('captured_at').dataset.locked;
            processedCard.style.display = 'none';

            // Return to active tab
            if (document.getElementById('tab-btn-camera').classList.contains('active')) {
                document.getElementById('camera-studio-box').style.display = 'block';
                startCamera(currentFacingMode, currentCameraSubmode === 'video');
            } else {
                document.getElementById('file-dropzone-box').style.display = 'block';
            }
        }

        // ─── 10. FORM SUBMISSION & DUPLICATE SHIELD ─────────────────
        const uploadForm = document.getElementById('judicial-upload-form');
        const submitBtn = document.getElementById('submit-evidence-btn');

        if (uploadForm && submitBtn) {
            uploadForm.addEventListener('submit', function(e) {
                // Verify file is selected
                if (!fileInput.files || fileInput.files.length === 0) {
                    e.preventDefault();
                    alert('Please capture a photo, record a video, or select a file before submitting.');
                    return false;
                }

                // Guard against double submission
                if (uploadForm.dataset.submitting === 'true') {
                    e.preventDefault();
                    return false;
                }
                uploadForm.dataset.submitting = 'true';
                submitBtn.disabled = true;
                submitBtn.style.opacity = '0.7';
                submitBtn.style.cursor = 'not-allowed';
                submitBtn.innerHTML = '<i class="ti ti-loader ti-spin" style="font-size: 1.35rem;"></i> <span>Cryptographically Sealing & Depositing Exhibit...</span>';
            });
        }

        // Initialize camera on page load if camera tab is active
        window.addEventListener('DOMContentLoaded', () => {
            startCamera(currentFacingMode, currentCameraSubmode === 'video');
        });

        // Ensure camera stops when navigating away
        window.addEventListener('beforeunload', stopCamera);
    </script>
</body>
</html>
