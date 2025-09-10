<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'application',
        'sous_application_module',
        'editeur',
        'descriptif',
        'direction',
        'resp_applicatif',
        'resp_metier',
        'server_id'
    ];

    // Pas de casts spécifiques requis pour le nouveau schéma minimal

    /**
     * Relation avec le serveur hôte
     */
    public function server(): BelongsTo
    {
        return $this->belongsTo(Server::class);
    }

    /**
     * Relation avec le cluster
     */
    public function cluster(): BelongsTo
    {
        return $this->belongsTo(Cluster::class);
    }

    /**
     * Utilisateurs assignés à cette application
     */
    public function assignedUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'application_user')
            ->withTimestamps()
            ->withPivot(['role', 'notes']);
    }

    /**
     * Incidents liés à cette application
     */
    public function incidents()
    {
        return $this->hasMany(Incident::class);
    }

    /**
     * Tâches de maintenance liées à cette application
     */
    public function maintenanceTasks()
    {
        return $this->hasMany(MaintenanceTask::class);
    }

    /**
     * Récupère le niveau de criticité formaté pour l'affichage
     */
    public function getFormattedCriticalLevelAttribute(): string
    {
        return ucfirst(strtolower($this->critical_level));
    }

    /**
     * Vérifie si l'application est critique
     */
    public function isCritical(): bool
    {
        return in_array(strtolower($this->critical_level), ['haute', 'critique']);
    }
}
