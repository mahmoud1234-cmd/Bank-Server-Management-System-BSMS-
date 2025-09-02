<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Incident extends Model
{
    protected $table = 'incidents';
    protected $fillable = [
        'title',
        'description',
        'severity',
        'status',
        'server_id',
        'assigned_to',
        'reported_by',
        'detected_at',
        'resolved_at',
        'resolution_notes',
        'category',
        'priority',
        'estimated_resolution_time',
        'actual_resolution_time',
        'impact_level',
        'affected_services',
        'root_cause',
        'prevention_measures'
    ];

    protected $casts = [
        'affected_services' => 'array',
        'detected_at' => 'datetime',
        'resolved_at' => 'datetime',
        'estimated_resolution_time' => 'datetime',
        'actual_resolution_time' => 'datetime',

    ];

    /**
     * Get the server associated with this incident
     */
    public function server(): BelongsTo
    {
        return $this->belongsTo(Server::class);
    }


    /**
     * Get the user assigned to this incident
     */
    public function assignedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    /**
     * Get the user who reported this incident
     */
    public function reportedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reported_by');
    }
    public function reporter()
    {
        return $this->belongsTo(User::class, 'reported_by');
    }

    public function assignee()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    /**
     * Get the updates for this incident
     */
    public function updates(): HasMany
    {
        return $this->hasMany(IncidentUpdate::class);
    }

    /**
     * Check if incident is open
     */
    public function isOpen(): bool
    {
        return in_array($this->status, ['open', 'in_progress']);
    }

    /**
     * Check if incident is resolved
     */
    public function isResolved(): bool
    {
        return $this->status === 'resolved';
    }

    /**
     * Check if incident is critical
     */
    public function isCritical(): bool
    {
        return $this->severity === 'critical';
    }

    /**
     * Get incident duration in hours
     */
    public function getDuration(): ?float
    {
        if (!$this->detected_at) {
            return null;
        }

        $endTime = $this->resolved_at ?? now();
        return $endTime->diffInHours($this->detected_at, true);
    }
}

