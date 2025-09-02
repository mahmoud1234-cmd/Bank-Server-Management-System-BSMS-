<?php

namespace App\Services;

use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;

class AuditService
{
    /**
     * Log an action in the audit trail
     */
    public static function log(string $action, string $description = null, $model = null, array $oldValues = null, array $newValues = null, string $category = 'system', string $severity = 'medium'): void
    {
        $user = Auth::user();
        
        if (!$user) {
            return;
        }

        // Handle case where $model is a string (model type) instead of an object
        $modelType = null;
        $modelId = null;
        $serverId = null;

        if ($model) {
            if (is_string($model)) {
                // If $model is a string, treat it as model type
                $modelType = $model;
            } else {
                // If $model is an object, get its class
                $modelType = get_class($model);
                $modelId = $model->id;
                
                // Set server_id if it's a Server model
                if ($model instanceof \App\Models\Server) {
                    $serverId = $model->id;
                }
            }
        }

        AuditLog::create([
            'user_id' => $user->id,
            'action' => $action,
            'model_type' => $modelType,
            'model_id' => $modelId,
            'server_id' => $serverId,
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent(),
            'description' => $description,
            'category' => $category,
            'severity' => $severity,
            'session_id' => session()->getId(),
            'request_id' => uniqid(),
        ]);
    }

    /**
     * Log server creation
     */
    public static function logServerCreated($server): void
    {
        self::log(
            'create',
            "Serveur créé: {$server->name} ({$server->ip_address})",
            $server,
            null,
            $server->toArray(),
            'data_modification',
            'medium'
        );
    }

    /**
     * Log server update
     */
    public static function logServerUpdated($server, array $oldValues, array $newValues): void
    {
        self::log(
            'update',
            "Serveur modifié: {$server->name}",
            $server,
            $oldValues,
            $newValues,
            'data_modification',
            'medium'
        );
    }

    /**
     * Log server deletion
     */
    public static function logServerDeleted($server): void
    {
        self::log(
            'delete',
            "Serveur supprimé: {$server->name} ({$server->ip_address})",
            $server,
            $server->toArray(),
            null,
            'data_modification',
            'high'
        );
    }

    /**
     * Log incident creation
     */
    public static function logIncidentCreated($incident): void
    {
        self::log(
            'create',
            "Incident créé: {$incident->title} - Serveur: {$incident->server->name}",
            $incident,
            null,
            $incident->toArray(),
            'data_modification',
            $incident->severity
        );
    }

    /**
     * Log incident update
     */
    public static function logIncidentUpdated($incident, array $oldValues, array $newValues): void
    {
        self::log(
            'update',
            "Incident modifié: {$incident->title}",
            $incident,
            $oldValues,
            $newValues,
            'data_modification',
            $incident->severity
        );
    }

    /**
     * Log user login
     */
    public static function logUserLogin($user): void
    {
        self::log(
            'login',
            "Connexion utilisateur: {$user->name} ({$user->email})",
            $user,
            null,
            null,
            'authentication',
            'low'
        );
    }

    /**
     * Log user logout
     */
    public static function logUserLogout($user): void
    {
        self::log(
            'logout',
            "Déconnexion utilisateur: {$user->name} ({$user->email})",
            $user,
            null,
            null,
            'authentication',
            'low'
        );
    }

    /**
     * Log data export
     */
    public static function logDataExport($user, string $exportType, array $filters = []): void
    {
        self::log(
            'export',
            "Export de données: {$exportType}",
            $user,
            null,
            ['export_type' => $exportType, 'filters' => $filters],
            'data_access',
            'medium'
        );
    }

    /**
     * Log maintenance task creation
     */
    public static function logMaintenanceTaskCreated($task): void
    {
        self::log(
            'create',
            "Tâche de maintenance créée: {$task->title} - Serveur: {$task->server->name}",
            $task,
            null,
            $task->toArray(),
            'data_modification',
            'medium'
        );
    }

    /**
     * Log maintenance task completion
     */
    public static function logMaintenanceTaskCompleted($task): void
    {
        self::log(
            'update',
            "Tâche de maintenance terminée: {$task->title}",
            $task,
            null,
            ['status' => 'completed', 'completed_at' => now()],
            'data_modification',
            'medium'
        );
    }

    /**
     * Get audit logs with filters
     */
    public static function getAuditLogs(array $filters = []): \Illuminate\Database\Eloquent\Builder
    {
        $query = AuditLog::with(['user', 'server']);

        if (isset($filters['user_id'])) {
            $query->where('user_id', $filters['user_id']);
        }

        if (isset($filters['action'])) {
            $query->where('action', $filters['action']);
        }

        if (isset($filters['server_id'])) {
            $query->where('server_id', $filters['server_id']);
        }

        if (isset($filters['category'])) {
            $query->where('category', $filters['category']);
        }

        if (isset($filters['severity'])) {
            $query->where('severity', $filters['severity']);
        }

        if (isset($filters['date_from'])) {
            $query->where('created_at', '>=', $filters['date_from']);
        }

        if (isset($filters['date_to'])) {
            $query->where('created_at', '<=', $filters['date_to']);
        }

        return $query->orderBy('created_at', 'desc');
    }
}
