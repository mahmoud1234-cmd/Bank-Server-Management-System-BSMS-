<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Datacenter extends Model
{
    protected $fillable = [
        'name',
        'code',
        'address',
        'city',
        'country',
        'capacity',
        'status',
        'manager',
        'contact_phone',
        'contact_email',
        'security_level',
        'environmental_controls',
        'backup_power',
        'network_connectivity',
        'description',
        'coordinates',
        'timezone'
    ];

    protected $casts = [
        'coordinates' => 'array',
        'environmental_controls' => 'array',
        'network_connectivity' => 'array',
    ];

    /**
     * Get the servers in this datacenter
     */
    public function servers(): HasMany
    {
        return $this->hasMany(Server::class);
    }

    /**
     * Get active servers count
     */
    public function getActiveServersCount(): int
    {
        return $this->servers()->where('status', 'Actif')->count();
    }

    /**
     * Get servers in maintenance count
     */
    public function getMaintenanceServersCount(): int
    {
        return $this->servers()->where('status', 'Maintenance')->count();
    }

    /**
     * Get down servers count
     */
    public function getDownServersCount(): int
    {
        return $this->servers()->where('status', 'Hors service')->count();
    }

    /**
     * Get critical servers count
     */
    public function getCriticalServersCount(): int
    {
        return $this->servers()->where('critical_level', 'critical')->count();
    }

    /**
     * Get servers by operating system
     */
    public function getServersByOS(): array
    {
        return $this->servers()
            ->selectRaw('operating_system, COUNT(*) as count')
            ->groupBy('operating_system')
            ->pluck('count', 'operating_system')
            ->toArray();
    }

    /**
     * Get servers by role
     */
    public function getServersByRole(): array
    {
        return $this->servers()
            ->selectRaw('role, COUNT(*) as count')
            ->groupBy('role')
            ->pluck('count', 'role')
            ->toArray();
    }

    /**
     * Check if datacenter is operational
     */
    public function isOperational(): bool
    {
        return $this->status === 'operational';
    }

    /**
     * Get utilization percentage
     */
    public function getUtilizationPercentage(): float
    {
        if ($this->capacity <= 0) {
            return 0;
        }

        $usedCapacity = $this->servers()->count();
        return round(($usedCapacity / $this->capacity) * 100, 2);
    }
}

