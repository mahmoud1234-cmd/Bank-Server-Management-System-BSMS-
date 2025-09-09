<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MaintenanceTask extends Model
{
    protected $fillable = [
        'title',
        'description',
        'type',
        'status',
        'server_id',
        'assigned_to',
        'scheduled_at',
        'completed_at',
        'duration_minutes',
        'priority',
        'category',
        'maintenance_window_start',
        'maintenance_window_end',
        'estimated_duration',
        'actual_duration',
        'notes',
        'checklist_items',
        'required_approval',
        'approved_by',
        'approval_date'
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'completed_at' => 'datetime',
        'maintenance_window_start' => 'datetime',
        'maintenance_window_end' => 'datetime',
        'approval_date' => 'datetime',
        'checklist_items' => 'array',
        'required_approval' => 'boolean',
    ];

    /**
     * Get the server associated with this maintenance task
     */
    public function server(): BelongsTo
    {
        return $this->belongsTo(Server::class);
    }

    /**
     * Get the user assigned to this maintenance task
     */
    public function assignedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    /**
     * Get the user who approved this maintenance task
     */
    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Check if maintenance task is pending
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Check if maintenance task is in progress
     */
    public function isInProgress(): bool
    {
        return $this->status === 'in_progress';
    }

    /**
     * Check if maintenance task is completed
     */
    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    /**
     * Check if maintenance task is overdue
     */
    public function isOverdue(): bool
    {
        return $this->scheduled_at && $this->scheduled_at->isPast() && $this->status !== 'completed';
    }

    /**
     * Check if maintenance task is scheduled for today
     */
    public function isScheduledToday(): bool
    {
        return $this->scheduled_at && $this->scheduled_at->isToday();
    }

    /**
     * Get maintenance duration in minutes
     */
    public function getDuration(): ?int
    {
        if (!$this->scheduled_at) {
            return null;
        }

        $endTime = $this->completed_at ?? now();
        return $endTime->diffInMinutes($this->scheduled_at, true);
    }
}

