<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Server extends Model
{
    protected $table = 'servers';
    protected $fillable = [
        'name',
        'ip_address',
        'password',
        'operating_system',
        'role',
        'location',
        'owner',
        'status',
        'specifications',
        'last_maintenance_date',
        'next_maintenance_date',
        'datacenter_id',
        'environment',
        'critical_level',
        'notes',
        'cluster_id',
        'hostname',
        'cpu',
        'ram',
        'storage'
    ];

    protected $casts = [
        'last_maintenance_date' => 'datetime',
        'next_maintenance_date' => 'datetime',
        'specifications' => 'array',
    ];

    protected $hidden = [
        'password',
    ];

    /**
     * Get the users assigned to this server
     */
    public function assignedUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'server_user', 'server_id', 'user_id')
                    ->withTimestamps();
    }

    /**
     * Get the incidents for this server
     */
    public function incidents(): HasMany
    {
        return $this->hasMany(Incident::class);
    }

    /**
     * Get the maintenance tasks for this server
     */
    public function maintenanceTasks(): HasMany
    {
        return $this->hasMany(MaintenanceTask::class);
    }

    /**
     * Get the datacenter for this server
     */
    public function datacenter(): BelongsTo
    {
        return $this->belongsTo(Datacenter::class);
    }

    /**
     * Get the audit logs for this server
     */
    public function auditLogs(): HasMany
    {
        return $this->hasMany(AuditLog::class, 'server_id');
    }

    /**
     * Check if server is active
     */
    public function isActive(): bool
    {
        return $this->status === 'Actif';
    }

    /**
     * Check if server is in maintenance
     */
    public function isInMaintenance(): bool
    {
        return $this->status === 'Maintenance';
    }

    /**
     * Check if server is down
     */
    public function isDown(): bool
    {
        return $this->status === 'Hors service';
    }

    /**
     * Check if server is critical
     */
    public function isCritical(): bool
    {
        return $this->critical_level === 'critical';
    }

    /**
     * Get active incidents count
     */
    public function getActiveIncidentsCount(): int
    {
        return $this->incidents()->whereIn('status', ['open', 'in_progress'])->count();
    }

    /**
     * Get pending maintenance tasks count
     */
    public function getPendingMaintenanceCount(): int
    {
        return $this->maintenanceTasks()->where('status', 'pending')->count();
    }

    public function cluster() {
        return $this->belongsTo(Cluster::class);
    }

    /**
     * Test connection to server using IP and password
     */
    public function testConnection(): bool
    {
        // Simple ping test to check if server is reachable
        $output = [];
        $returnVar = 0;
        exec("ping -n 1 -w 1000 {$this->ip_address}", $output, $returnVar);
        return $returnVar === 0;
    }

    /**
     * Check if server can be managed (connected)
     */
    public function canManage(): bool
    {
        return $this->testConnection() && !empty($this->password);
    }

    /**
     * Get server resource usage as formatted string
     */
    public function getResourcesFormatted(): string
    {
        $cpu = $this->cpu ? $this->cpu . ' cores' : 'N/A';
        $ram = $this->ram ? $this->ram . ' GB' : 'N/A';
        $storage = $this->storage ? $this->storage . ' GB' : 'N/A';
        
        return "CPU: {$cpu}, RAM: {$ram}, Storage: {$storage}";
    }

    /**
     * Pause server (set status to maintenance)
     */
    public function pause(): bool
    {
        if ($this->canManage()) {
            $this->status = 'Maintenance';
            return $this->save();
        }
        return false;
    }

    /**
     * Resume server (set status to active)
     */
    public function resume(): bool
    {
        if ($this->canManage()) {
            $this->status = 'Actif';
            return $this->save();
        }
        return false;
    }
}

