<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IncidentUpdate extends Model
{
    protected $fillable = [
        'incident_id',
        'user_id',
        'status',
        'description',
        'update_type',
        'priority_change',
        'severity_change',
        'assigned_to_change',
        'estimated_resolution_time',
        'attachments',
        'internal_notes',
        'public_notes'
    ];

    protected $casts = [
        'attachments' => 'array',
        'estimated_resolution_time' => 'datetime',
    ];

    /**
     * Get the incident this update belongs to
     */
    public function incident(): BelongsTo
    {
        return $this->belongsTo(Incident::class);
    }

    /**
     * Get the user who made this update
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get formatted update type
     */
    public function getFormattedUpdateType(): string
    {
        $types = [
            'status_change' => 'Changement de statut',
            'assignment' => 'Réassignation',
            'priority_change' => 'Changement de priorité',
            'progress' => 'Progression',
            'resolution' => 'Résolution',
            'escalation' => 'Escalade',
            'comment' => 'Commentaire',
        ];

        return $types[$this->update_type] ?? ucfirst($this->update_type);
    }

    /**
     * Check if this is a status change update
     */
    public function isStatusChange(): bool
    {
        return $this->update_type === 'status_change';
    }

    /**
     * Check if this is a resolution update
     */
    public function isResolution(): bool
    {
        return $this->update_type === 'resolution';
    }
}

