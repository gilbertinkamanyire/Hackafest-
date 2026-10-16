<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class Evidence extends Model
{
    use HasFactory;

    protected $table = 'evidence';

    /**
     * Fillable fields for mass assignment
     * Includes all GPS, timestamp, device, and privacy metadata
     */
    protected $fillable = [
        'title',
        'description',
        'file_path',
        'file_hash',
        'file_size',
        'mime_type',
        'uploaded_by',
        'status',
        'assigned_to',
        'reviewed_by',
        'latitude',
        'longitude',
        'altitude',
        'gps_accuracy',
        'captured_at',
        'device_info',
        'metadata',
    ];

    /**
     * Type casting for proper data handling
     */
    protected $casts = [
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'altitude' => 'decimal:2',
        'gps_accuracy' => 'decimal:2',
        'file_size' => 'integer',
        'captured_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Evidence belongs to a user (uploaded_by)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    /**
     * Relationship: Evidence is assigned to a user
     */
    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    /**
     * Relationship: Evidence is reviewed by a user (Judge)
     */
    public function reviewedBy()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    /**
     * Accessor for file URL — routed exclusively through the secure in-app preview stream
     * (Direct downloads are forbidden; access requires authentication and role verification)
     */
    public function getFileUrlAttribute()
    {
        return route('evidence.preview', $this->id);
    }
    
    /**
     * Get the full storage path
     */
    public function getStoragePath()
    {
        return storage_path('app/public/' . $this->file_path);
    }

    /**
     * Locate the physical file artifact across storage disks
     */
    public function getAbsolutePath(): ?string
    {
        $possiblePaths = [
            storage_path('app/public/' . $this->file_path),
            storage_path('app/' . $this->file_path),
            storage_path('app/private/' . $this->file_path),
            public_path('storage/' . $this->file_path),
        ];

        foreach ($possiblePaths as $p) {
            if (file_exists($p)) {
                return $p;
            }
        }

        return null;
    }

    /**
     * Check if evidence has GPS coordinates
     */
    public function hasGPS(): bool
    {
        return !is_null($this->latitude) && !is_null($this->longitude);
    }

    /**
     * Get formatted GPS string
     */
    public function getFormattedGPSAttribute(): string
    {
        if (!$this->hasGPS()) return 'No GPS data';
        return number_format($this->latitude, 6) . ', ' . number_format($this->longitude, 6);
    }

    /**
     * Get file extension
     */
    public function getFileExtensionAttribute(): string
    {
        return strtolower(pathinfo($this->file_path, PATHINFO_EXTENSION));
    }

    /**
     * Check if the file is an image
     */
    public function getIsImageAttribute(): bool
    {
        return in_array($this->file_extension, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp', 'svg']);
    }

    /**
     * Check if the file is a video
     */
    public function getIsVideoAttribute(): bool
    {
        return in_array($this->file_extension, ['mp4', 'webm', 'ogg', 'avi', 'mov', 'm4v']);
    }

    /**
     * Check if the file is an audio recording
     */
    public function getIsAudioAttribute(): bool
    {
        return in_array($this->file_extension, ['mp3', 'wav', 'ogg', 'm4a', 'aac', 'flac', 'weba']);
    }

    /**
     * Check if the file is plain text / document
     */
    public function getIsTextAttribute(): bool
    {
        return in_array($this->file_extension, ['txt', 'csv', 'json', 'log', 'xml', 'md']);
    }

    /**
     * Check if the file is a PDF
     */
    public function getIsPdfAttribute(): bool
    {
        return $this->file_extension === 'pdf';
    }

    /**
     * Get human-readable file size
     */
    public function getFormattedSizeAttribute(): string
    {
        $size = $this->file_size;
        if (!$size) return 'Unknown';
        if ($size < 1024) return $size . ' B';
        if ($size < 1048576) return round($size / 1024, 1) . ' KB';
        return round($size / 1048576, 1) . ' MB';
    }

    /**
     * Get decoded metadata as array
     */
    public function getDecodedMetadataAttribute(): array
    {
        return $this->metadata ? json_decode($this->metadata, true) : [];
    }
}
