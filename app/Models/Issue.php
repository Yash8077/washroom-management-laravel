<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
// use Illuminate\Database\Eloquent\SoftDeletes;

class Issue extends Model
{
    use HasFactory;
    // use SoftDeletes; // Optional

    protected $fillable = [
        'washroom_id',
        'reported_by_user_id', // Can be null for public reports
        'resolved_by_user_id', // User who marked it resolved
        'linked_task_id',      // Optional: Task created to resolve this issue
        'issue_type',          // e.g., 'Spill', 'Broken Fixture', 'Out of Soap', 'Clogged', 'Cleanliness'
        'severity',            // Optional: e.g., 'low', 'medium', 'high'
        'description',
        'reporter_info',       // Optional: e.g., email from public reporter
        'status',              // e.g., 'reported', 'acknowledged', 'in_progress', 'resolved', 'rejected'
        'reported_at',
        'resolved_at',
        'resolution_notes',
        // Add fields for photo paths if implementing uploads
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'reported_at' => 'datetime',
        'resolved_at' => 'datetime',
    ];

    /**
     * Get the washroom where the issue was reported.
     */
    public function washroom(): BelongsTo
    {
        return $this->belongsTo(Washroom::class);
    }

    /**
     * Get the user who reported the issue (if not public).
     */
    public function reportedByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reported_by_user_id');
    }

    /**
     * Get the user who resolved the issue.
     */
    public function resolvedByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'resolved_by_user_id');
    }

    /**
     * Get the task linked to resolve this issue.
     */
    public function linkedTask(): BelongsTo // Or HasOne if a task can only link to one issue
    {
        return $this->belongsTo(Task::class, 'linked_task_id');
    }
}