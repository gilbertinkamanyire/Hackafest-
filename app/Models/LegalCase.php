<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LegalCase extends Model
{
    use HasFactory;

    /**
     * Map to the 'cases' table (avoids PHP reserved word conflict)
     */
    protected $table = 'cases';

    protected $fillable = [
        'case_number',
        'title',
        'description',
        'created_by',
        'assigned_judge_id',
        'status',
        'court_reference',
        'hearing_date',
    ];

    protected $casts = [
        'hearing_date' => 'date',
    ];

    /**
     * The lawyer who created this case
     */
    public function lawyer()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * The judge this case has been pushed to by the lawyer
     */
    public function assignedJudge()
    {
        return $this->belongsTo(User::class, 'assigned_judge_id');
    }

    /**
     * Evidence items linked to this case (via pivot)
     */
    public function evidence()
    {
        return $this->belongsToMany(
            Evidence::class,
            'case_evidence',
            'case_id',
            'evidence_id'
        )->withPivot(['notes', 'sort_order', 'added_by'])->withTimestamps()->orderByPivot('sort_order');
    }

    /**
     * Auto-generate a unique docket number before creating
     */
    protected static function booted()
    {
        static::creating(function ($case) {
            if (empty($case->case_number)) {
                $year = date('Y');
                $sequence = str_pad(static::whereYear('created_at', $year)->count() + 1, 4, '0', STR_PAD_LEFT);
                $case->case_number = 'EWV-' . $year . '-' . $sequence;
            }
        });
    }

    /**
     * Status badge colour helper
     */
    public function statusColor(): string
    {
        return match($this->status) {
            'open'         => '#22c55e',
            'under_review' => '#f59e0b',
            'closed'       => '#94a3b8',
            'archived'     => '#64748b',
            default        => '#94a3b8',
        };
    }

    /**
     * Human-readable status label
     */
    public function statusLabel(): string
    {
        return match($this->status) {
            'open'         => 'Open',
            'under_review' => 'Under Review',
            'closed'       => 'Closed',
            'archived'     => 'Archived',
            default        => 'Unknown',
        };
    }
}
