<?php

namespace App\Http\Controllers;

use App\Models\Server;
use App\Models\Datacenter;
use App\Models\User;
use App\Services\AuditService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServerController extends Controller
{
    public function index(Request $request)
    {
        $query = Server::with(['datacenter', 'assignedUsers']);

        // Recherche par nom, IP, rôle, propriétaire
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('ip_address', 'like', "%{$search}%")
                  ->orWhere('role', 'like', "%{$search}%")
                  ->orWhere('owner', 'like', "%{$search}%");
            });
        }

        // Filtre par statut
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filtre par système d'exploitation
        if ($request->filled('os')) {
            $query->where('operating_system', $request->os);
        }

        // Filtre par niveau de criticité
        if ($request->filled('critical_level')) {
            $query->where('critical_level', $request->critical_level);
        }

        // Filtre par datacenter
        if ($request->filled('datacenter_id')) {
            $query->where('datacenter_id', $request->datacenter_id);
        }

        // Tri
        $sortBy = $request->get('sort_by', 'name');
        $sortOrder = $request->get('sort_order', 'asc');
        $query->orderBy($sortBy, $sortOrder);

        $servers = $query->paginate(15)->withQueryString();

        // Log de l'accès
        AuditService::log('access', 'Consultation de la liste des serveurs', null, null, null, 'data_access', 'low');

        return view('servers.index', compact('servers'));
    }

    public function create()
    {
        $datacenters = Datacenter::all();
        $users = User::where('role', 'technician')->orWhere('role', 'admin')->get();
        
        return view('servers.create', compact('datacenters', 'users'));
    }

    public function addToSite()
    {
        return view('servers.add-to-site');
    }

    public function storeToSite(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:servers',
            'ip_address' => 'required|ip|unique:servers',
            'password' => 'required|string|min:6',
        ]);

        // Valeurs par défaut pour l'ajout rapide
        $serverData = array_merge($validated, [
            'operating_system' => 'Linux',
            'role' => 'Serveur Web',
            'location' => 'Site Principal',
            'owner' => auth()->user()->name,
            'status' => 'Actif',
            'environment' => 'production',
            'critical_level' => 'medium',
            'notes' => 'Serveur ajouté via formulaire rapide',
            'password' => bcrypt($validated['password']) // Chiffrer le mot de passe
        ]);

        $server = Server::create($serverData);

        // Log de la création
        AuditService::logServerCreated($server);

        return redirect()->route('servers.index')
            ->with('success', "Serveur {$server->name} ajouté au site avec succès !");
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:servers',
            'ip_address' => 'required|ip|unique:servers',
            'password' => 'nullable|string|min:6',
            'operating_system' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'owner' => 'required|string|max:255',
            'status' => 'required|in:Actif,Maintenance,Hors service',
            'specifications' => 'nullable|array',
            'datacenter_id' => 'nullable|exists:datacenters,id',
            'environment' => 'required|in:production,staging,development,testing',
            'critical_level' => 'required|in:low,medium,high,critical',
            'notes' => 'nullable|string',
            'assigned_users' => 'nullable|array',
            'assigned_users.*' => 'exists:users,id'
        ]);

        // Chiffrer le mot de passe s'il est fourni
        if (isset($validated['password'])) {
            $validated['password'] = bcrypt($validated['password']);
        }

        $server = Server::create($validated);

        // Assigner les utilisateurs
        if ($request->filled('assigned_users')) {
            $server->assignedUsers()->attach($request->assigned_users, [
                'access_level' => 'read',
                'assigned_at' => now()
            ]);
        }

        // Log de la création
        AuditService::logServerCreated($server);

        return redirect()->route('servers.index')
            ->with('success', 'Serveur créé avec succès !');
    }

    public function show(Server $server)
    {
        $server->load(['datacenter', 'assignedUsers', 'incidents', 'maintenanceTasks']);
        
        // Statistiques du serveur
        $stats = [
            'total_incidents' => $server->incidents()->count(),
            'open_incidents' => $server->incidents()->whereIn('status', ['open', 'in_progress'])->count(),
            'critical_incidents' => $server->incidents()->where('severity', 'critical')->count(),
            'total_maintenance_tasks' => $server->maintenanceTasks()->count(),
            'pending_maintenance_tasks' => $server->maintenanceTasks()->where('status', 'pending')->count(),
            'uptime_percentage' => $this->calculateUptimePercentage($server),
        ];

        // Log de l'accès
        AuditService::log('access', "Consultation du serveur: {$server->name}", $server, null, null, 'data_access', 'low');

        return view('servers.show', compact('server', 'stats'));
    }

    public function edit(Server $server)
    {
        $datacenters = Datacenter::all();
        $users = User::where('role', 'technician')->orWhere('role', 'admin')->get();
        
        return view('servers.edit', compact('server', 'datacenters', 'users'));
    }

    public function update(Request $request, Server $server)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:servers,name,' . $server->id,
            'ip_address' => 'required|ip|unique:servers,ip_address,' . $server->id,
            'operating_system' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'owner' => 'required|string|max:255',
            'status' => 'required|in:Actif,Maintenance,Hors service',
            'specifications' => 'nullable|array',
            'datacenter_id' => 'nullable|exists:datacenters,id',
            'environment' => 'required|in:production,staging,development,testing',
            'critical_level' => 'required|in:low,medium,high,critical',
            'notes' => 'nullable|string',
            'assigned_users' => 'nullable|array',
            'assigned_users.*' => 'exists:users,id'
        ]);

        $oldValues = $server->toArray();
        $server->update($validated);

        // Mettre à jour les utilisateurs assignés
        if ($request->has('assigned_users')) {
            $server->assignedUsers()->sync($request->assigned_users);
        } else {
            $server->assignedUsers()->detach();
        }

        // Log de la modification
        AuditService::logServerUpdated($server, $oldValues, $validated);

        return redirect()->route('servers.index')
            ->with('success', 'Serveur mis à jour avec succès !');
    }

    public function destroy(Server $server)
    {
        $serverName = $server->name;
        $server->delete();

        // Log de la suppression
        AuditService::logServerDeleted($server);

        return redirect()->route('servers.index')
            ->with('success', "Serveur {$serverName} supprimé avec succès !");
    }

    public function assignUsers(Request $request, Server $server)
    {
        $validated = $request->validate([
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id',
            'access_level' => 'required|in:read,write,admin'
        ]);

        $server->assignedUsers()->sync($validated['user_ids']);

        AuditService::log('update', "Utilisateurs assignés au serveur: {$server->name}", $server);

        return redirect()->back()->with('success', 'Utilisateurs assignés avec succès !');
    }

    public function getServerStatus(Server $server)
    {
        return response()->json([
            'id' => $server->id,
            'name' => $server->name,
            'status' => $server->status,
            'last_check' => now()->toISOString(),
            'incidents_count' => $server->getActiveIncidentsCount(),
            'maintenance_tasks_count' => $server->getPendingMaintenanceCount()
        ]);
    }

    private function calculateUptimePercentage(Server $server)
    {
        // Logique simplifiée pour calculer le pourcentage de disponibilité
        $totalIncidents = $server->incidents()->count();
        $resolvedIncidents = $server->incidents()->where('status', 'resolved')->count();
        
        if ($totalIncidents === 0) {
            return 100;
        }

        return round(($resolvedIncidents / $totalIncidents) * 100, 2);
    }

    public function export(Request $request)
    {
        $query = Server::with(['datacenter', 'assignedUsers']);

        // Appliquer les mêmes filtres que pour l'index
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('ip_address', 'like', "%{$search}%")
                  ->orWhere('role', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $servers = $query->get();

        // Log de l'export
        AuditService::logDataExport(auth()->user(), 'servers', $request->all());

        if ($request->format === 'csv') {
            return $this->exportToCsv($servers);
        }

        return $this->exportToPdf($servers);
    }

    private function exportToCsv($servers)
    {
        $filename = 'servers_' . now()->format('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$filename}",
        ];

        $callback = function() use ($servers) {
            $file = fopen('php://output', 'w');
            
            // En-têtes
            fputcsv($file, [
                'Nom', 'IP', 'OS', 'Rôle', 'Localisation', 'Propriétaire', 
                'Statut', 'Niveau Critique', 'Datacenter', 'Environnement'
            ]);

            // Données
            foreach ($servers as $server) {
                fputcsv($file, [
                    $server->name,
                    $server->ip_address,
                    $server->operating_system,
                    $server->role,
                    $server->location,
                    $server->owner,
                    $server->status,
                    $server->critical_level,
                    $server->datacenter?->name ?? 'N/A',
                    $server->environment
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    private function exportToPdf($servers)
    {
        // Implémentation de l'export PDF (nécessite un package comme DomPDF)
        return response()->json(['message' => 'Export PDF non implémenté']);
    }
}
