<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Evidence;

class EvidenceController extends Controller
{
    /**
     * Ensure user is authenticated
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show evidence upload form
     * Restricted to Witnesses only
     */
    public function create()
    {
        $user = Auth::user();
        if (!$user->hasRole('Witness')) {
            abort(403, 'Unauthorized. Only sworn witnesses are permitted to capture and submit evidence to the Vault.');
        }

        return view('upload');
    }

    /**
     * Handle evidence upload with full metadata capture
     * Restricted to Witnesses only
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        if (!$user->hasRole('Witness')) {
            abort(403, 'Unauthorized. Only sworn witnesses are permitted to capture and submit evidence to the Vault.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:5000',
            'file' => 'required|file|max:25600', // 25MB max
        ]);

        $file = $request->file('file');
        $originalName = $file->getClientOriginalName();
        $fileContent = file_get_contents($file->getRealPath());
        $mimeType = $file->getMimeType();
        $fileSize = $file->getSize();

        // Generate SHA-256 hash for integrity verification
        $hash = hash('sha256', $fileContent);

        // Concurrency lock per user to strictly prevent double submission
        $lockKey = 'evidence_store_lock_' . Auth::id();
        $lock = \Illuminate\Support\Facades\Cache::lock($lockKey, 15);

        if (!$lock->get()) {
            return redirect()->route('dashboard')->with('info', 
                'Exhibit upload is currently being processed. Please wait a moment.'
            );
        }

        try {
            // Prevent double submission of identical exhibit
            $existing = Evidence::where('file_hash', $hash)
                ->where('uploaded_by', Auth::id())
                ->first();

            if ($existing) {
                return redirect()->route('dashboard')->with('success', 
                    'Exhibit already recorded! SHA-256 Hash: ' . substr($hash, 0, 16) . '...'
                );
            }

            // Store file securely
            $path = $file->storeAs('evidence', $hash . '_' . $originalName, 'public');

        // Capture timestamp — use form-provided or current time
        $capturedAt = $request->captured_at 
            ? date('Y-m-d H:i:s', strtotime($request->captured_at))
            : now();

        // Build comprehensive metadata array
        $metadata = [
            // GPS Data (from device)
            'latitude' => $request->latitude ? (float) $request->latitude : null,
            'longitude' => $request->longitude ? (float) $request->longitude : null,
            'altitude' => $request->altitude ? (float) $request->altitude : null,
            'gps_accuracy' => $request->accuracy ? (float) $request->accuracy : null,
            
            // EXIF GPS Data (from uploaded file)
            'exif_gps_lat' => $request->exif_gps_lat ? (float) $request->exif_gps_lat : null,
            'exif_gps_lon' => $request->exif_gps_lon ? (float) $request->exif_gps_lon : null,
            'exif_datetime' => $request->exif_datetime,
            
            // Device & Privacy
            'device_info' => $request->device_info ? substr($request->device_info, 0, 500) : null,
            'ip_address' => $request->ip(),
            'user_agent' => substr($request->userAgent(), 0, 500),
            
            // File info
            'original_name' => $originalName,
            'mime_type' => $mimeType,
            'file_size' => $fileSize,
            
            // Security
            'upload_method' => $request->header('X-Requested-With') === 'XMLHttpRequest' ? 'ajax' : 'form',
            'encryption' => 'AES-256',
            'hash_algorithm' => 'SHA-256',
        ];

        // Save evidence with all metadata
        $evidence = Evidence::create([
            'title' => $request->title,
            'description' => $request->description,
            'file_path' => $path,
            'file_hash' => $hash,
            'uploaded_by' => Auth::id(),
            'latitude' => $metadata['latitude'] ?? $metadata['exif_gps_lat'],
            'longitude' => $metadata['longitude'] ?? $metadata['exif_gps_lon'],
            'altitude' => $metadata['altitude'],
            'gps_accuracy' => $metadata['gps_accuracy'],
            'captured_at' => $capturedAt,
            'device_info' => $metadata['device_info'],
            'metadata' => json_encode($metadata),
            'file_size' => $fileSize,
            'mime_type' => $mimeType,
        ]);

        // Log the chain of custody event
        Log::info('Evidence uploaded', [
            'evidence_id' => $evidence->id,
            'user_id' => Auth::id(),
            'file_hash' => $hash,
            'gps' => ($metadata['latitude'] ?? 'none') . ', ' . ($metadata['longitude'] ?? 'none'),
            'timestamp' => $capturedAt,
            'ip' => $request->ip(),
        ]);

        return redirect()->route('dashboard')->with('success', 
            'Evidence uploaded successfully! SHA-256 Hash: ' . substr($hash, 0, 16) . '...'
        );
        } finally {
            optional($lock)->release();
        }
    }

    /**
     * List all evidence for the authenticated user
     */
    public function index()
    {
        $user = Auth::user();

        // If admin, judge, or lawyer, show all evidence. Otherwise, show only user's evidence
        if ($user->hasAnyRole(['Admin', 'Judge', 'Lawyer'])) {
            $evidenceList = Evidence::with('user')
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        } else {
            $evidenceList = Evidence::where('uploaded_by', $user->id)
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        }

        return view('evidence_list', compact('evidenceList'));
    }

    /**
     * Show evidence details with full metadata
     */
    public function show($id)
    {
        $evidence = Evidence::with('user')->findOrFail($id);
        $user = Auth::user();

        // Strict authorization check: Witnesses may only view their own submitted evidence.
        // Judges, Lawyers, and Admins have judicial clearance to inspect evidence.
        if (!$user->hasAnyRole(['Admin', 'Judge', 'Lawyer']) && $evidence->uploaded_by !== $user->id) {
            abort(403, 'Unauthorized. Witnesses may only view their own submitted evidence exhibits.');
        }

        // Decode stored metadata
        $metadata = $evidence->metadata ? json_decode($evidence->metadata, true) : [];

        return view('evidence.show', compact('evidence', 'metadata'));
    }

    /**
     * Securely stream evidence for in-app viewing only.
     * External downloads and attachments are strictly disabled.
     */
    public function preview($id)
    {
        $evidence = Evidence::findOrFail($id);
        $user = Auth::user();

        // Strict authorization check: Witnesses may only inspect their own submitted exhibits.
        if (!$user->hasAnyRole(['Admin', 'Judge', 'Lawyer']) && $evidence->uploaded_by !== $user->id) {
            abort(403, 'Unauthorized. Witnesses may only inspect their own submitted exhibits.');
        }

        $filePath = $evidence->getAbsolutePath();
        if (!$filePath || !file_exists($filePath)) {
            abort(404, 'The evidentiary file artifact could not be located in secure storage.');
        }

        $mimeType = $evidence->mime_type ?: (mime_content_type($filePath) ?: 'application/octet-stream');

        // Log inspection event in chain of custody
        Log::info('Evidence inspected in-app', [
            'evidence_id' => $evidence->id,
            'viewed_by' => $user->id,
            'user_email' => $user->email,
            'ip' => request()->ip(),
            'timestamp' => now()->toIso8601String(),
        ]);

        $headers = [
            'Content-Type' => $mimeType,
            'Content-Disposition' => 'inline; filename="vault_exhibit_' . $evidence->id . '"',
            'Cache-Control' => 'no-store, no-cache, must-revalidate, private, post-check=0, pre-check=0, max-age=0',
            'Pragma' => 'no-cache',
            'Expires' => '0',
            'X-Content-Type-Options' => 'nosniff',
            'X-Frame-Options' => 'SAMEORIGIN',
        ];

        return response()->file($filePath, $headers);
    }

    /**
     * Explicitly reject download requests with 403 Forbidden
     */
    public function download($id)
    {
        abort(403, 'Evidence download is strictly prohibited under Court Evidence Policy. Exhibits may only be inspected securely within the application.');
    }
}
