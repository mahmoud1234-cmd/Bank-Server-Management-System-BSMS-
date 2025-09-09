<?php

namespace App\Http\Controllers;

use App\Models\Server;
use App\Models\Incident;
use App\Models\MaintenanceTask;
use App\Models\Datacenter;
use App\Models\User;
use App\Models\Cluster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
{
    // Statistiques générales
    $stats = [
        'total_servers' => Server::count(),
        'active_servers' => Server::where('status', 'Actif')->count(),
        'maintenance_servers' => Server::where('status', 'Maintenance')->count(),
        'down_servers' => Server::where('status', 'Hors service')->count(),
        'critical_servers' => Server::where('critical_level', 'critical')->count(),
        'total_incidents' => Incident::count(),
        'open_incidents' => Incident::whereIn('status', ['open', 'in_progress'])->count(),
        'critical_incidents' => Incident::where('severity', 'critical')->count(),
        'pending_maintenance' => MaintenanceTask::where('status', 'pending')->count(),
        'today_maintenance' => MaintenanceTask::whereDate('scheduled_at', today())->count(),
        'total_datacenters' => Datacenter::count(),
        'total_users' => User::count(),
        'total_clusters' => Cluster::count(),
        'active_clusters' => Cluster::whereHas('servers', function($query) {
            $query->where('status', 'Actif');
        })->count(),
    ];

    // Calcul des pourcentages avec protection contre zéro
    $stats['servers_down_percentage'] = $stats['total_servers'] > 0
        ? round(($stats['down_servers'] / $stats['total_servers']) * 100, 2)
        : 0;

    $stats['servers_maintenance_percentage'] = $stats['total_servers'] > 0
        ? round(($stats['maintenance_servers'] / $stats['total_servers']) * 100, 2)
        : 0;

    // ... le reste du code reste identique

        // Graphiques serveurs
        $serversByOS = Server::select('operating_system', DB::raw('count(*) as count'))
            ->groupBy('operating_system')
            ->pluck('count', 'operating_system')
            ->toArray();

        $serversByRole = Server::select('role', DB::raw('count(*) as count'))
            ->groupBy('role')
            ->pluck('count', 'role')
            ->toArray();

        $serversByStatus = Server::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        $serversByDatacenter = Server::join('datacenters', 'servers.datacenter_id', '=', 'datacenters.id')
            ->select('datacenters.name', DB::raw('count(*) as count'))
            ->groupBy('datacenters.id', 'datacenters.name')
            ->pluck('count', 'name')
            ->toArray();

        // Statistiques des clusters
        $clustersByMode = Cluster::select('mode', DB::raw('count(*) as count'))
            ->groupBy('mode')
            ->pluck('count', 'mode')
            ->toArray();

        $clusteredServers = Server::whereNotNull('cluster_id')->count();
        $standaloneServers = Server::whereNull('cluster_id')->count();

        // Incidents
        $incidentsBySeverity = Incident::select('severity', DB::raw('count(*) as count'))
            ->groupBy('severity')
            ->pluck('count', 'severity')
            ->toArray();

        $incidentsByCategory = Incident::select('category', DB::raw('count(*) as count'))
            ->groupBy('category')
            ->pluck('count', 'category')
            ->toArray();

        $incidentsLast30Days = Incident::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count', 'date')
            ->toArray();

        // Maintenance
        $maintenanceNext30Days = MaintenanceTask::select(DB::raw('DATE(scheduled_at) as date'), DB::raw('count(*) as count'))
            ->whereBetween('scheduled_at', [now(), now()->addDays(30)])
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count', 'date')
            ->toArray();

        // Derniers incidents et maintenance
        $recentIncidents = Incident::with(['server', 'assignedUser', 'reportedBy'])
            ->latest()
            ->limit(10)
            ->get();

        $recentMaintenanceTasks = MaintenanceTask::with(['server', 'assignedUser'])
            ->orderBy('scheduled_at', 'asc')
            ->limit(10)
            ->get();

        // Serveurs critiques avec incidents ouverts/in progress
        $criticalServers = Server::where('critical_level', 'critical')
            ->with(['incidents' => function($q) {
                $q->whereIn('status', ['open', 'in_progress']);
            }])
            ->get();

        // Utilisation des datacenters
        $datacenterUtilization = Datacenter::withCount('servers')
            ->get()
            ->map(function($dc) {
                $utilization = $dc->capacity > 0
                    ? round(($dc->servers_count / $dc->capacity) * 100, 2)
                    : 0;
                return [
                    'name' => $dc->name,
                    'servers_count' => $dc->servers_count,
                    'capacity' => $dc->capacity,
                    'utilization' => $utilization,
                ];
            })
            ->toArray();

        // Performance techniciens (corrigé)
        $technicianPerformance = User::where('role', 'technician')
            ->withCount('assignedIncidents')
            ->withCount(['assignedIncidents as resolved_incidents' => function($q) {
                $q->where('status', 'resolved');
            }])
            ->get()
            ->map(function($user) {
                $resolutionRate = $user->assigned_incidents > 0
                    ? round(($user->resolved_incidents / $user->assigned_incidents) * 100, 2)
                    : 0;
                return [
                    'name' => $user->name,
                    'total_incidents' => $user->assigned_incidents,
                    'resolved_incidents' => $user->resolved_incidents,
                    'resolution_rate' => $resolutionRate,
                ];
            })
            ->toArray();

        return view('dashboard', compact(
            'stats',
            'serversByOS',
            'serversByRole',
            'serversByStatus',
            'serversByDatacenter',
            'clustersByMode',
            'clusteredServers',
            'standaloneServers',
            'incidentsBySeverity',
            'incidentsByCategory',
            'incidentsLast30Days',
            'maintenanceNext30Days',
            'recentIncidents',
            'recentMaintenanceTasks',
            'criticalServers',
            'datacenterUtilization',
            'technicianPerformance'
        ));
    }

    /**
     * Endpoint AJAX pour graphiques
     */
    public function getChartData(Request $request)
    {
        $charts = [
            'servers_by_os' => [Server::class, 'operating_system'],
            'servers_by_status' => [Server::class, 'status'],
            'incidents_by_severity' => [Incident::class, 'severity'],
            'incidents_timeline' => [Incident::class, 'created_at'],
            'maintenance_timeline' => [MaintenanceTask::class, 'scheduled_at'],
        ];

        $type = $request->get('chart_type');

        if (!isset($charts[$type])) {
            return response()->json([]);
        }

        [$model, $field] = $charts[$type];

        if (in_array($type, ['incidents_timeline', 'maintenance_timeline'])) {
            $query = $model::select(DB::raw('DATE(' . $field . ') as date'), DB::raw('count(*) as count'))
                ->where($field, '>=', now()->subDays(30))
                ->groupBy('date')
                ->orderBy('date')
                ->get();
        } else {
            $query = $model::select($field, DB::raw('count(*) as count'))
                ->groupBy($field)
                ->get();
        }

        return response()->json($query);
    }

    /**
     * Endpoint pour alertes temps réel
     */
    public function getAlerts()
    {
        $alerts = [];

        // Serveurs critiques en panne
        Server::where('critical_level', 'critical')
            ->where('status', 'Hors service')
            ->get()
            ->each(function($server) use (&$alerts) {
                $alerts[] = [
                    'type' => 'critical',
                    'title' => 'Serveur critique en panne',
                    'message' => "Le serveur {$server->name} est hors service",
                    'server_id' => $server->id,
                    'timestamp' => now()->toISOString(),
                ];
            });

        // Incidents critiques non assignés
        Incident::where('severity', 'critical')
            ->whereNull('assigned_to')
            ->whereIn('status', ['open', 'in_progress'])
            ->get()
            ->each(function($incident) use (&$alerts) {
                $alerts[] = [
                    'type' => 'warning',
                    'title' => 'Incident critique non assigné',
                    'message' => "L'incident '{$incident->title}' n'est pas encore assigné",
                    'incident_id' => $incident->id,
                    'timestamp' => now()->toISOString(),
                ];
            });

        // Maintenance en retard
        MaintenanceTask::where('scheduled_at', '<', now())
            ->where('status', 'pending')
            ->get()
            ->each(function($task) use (&$alerts) {
                $alerts[] = [
                    'type' => 'warning',
                    'title' => 'Maintenance en retard',
                    'message' => "La tâche '{$task->title}' est en retard",
                    'task_id' => $task->id,
                    'timestamp' => now()->toISOString(),
                ];
            });

        return response()->json($alerts);
    }
}
