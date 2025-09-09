<?php

namespace App\Http\Controllers;

use App\Models\Incident;
use App\Models\Server;
use App\Models\User;
use App\Services\AuditService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class IncidentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Incident::with(['server', 'assignedTo', 'reportedBy']);

        // Filtres
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('severity')) {
            $query->where('severity', $request->severity);
        }

        if ($request->filled('server_id')) {
            $query->where('server_id', $request->server_id);
        }

        // Tri
        $sortBy = $request->get('sort_by', 'detected_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $incidents = $query->paginate(15);
        $servers = Server::all();

        // Log de l'accès
        AuditService::log(
            'view',
            'Liste des incidents consultée',
            'incident',
            null,
            null,
            'data_access',
            'low'
        );

        return view('incidents.index', compact('incidents', 'servers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $servers = Server::all();
        $users = User::all(); // Récupérer tous les utilisateurs
        
        return view('incidents.create', compact('servers', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'severity' => 'required|in:low,medium,high,critical',
            'status' => 'required|in:open,in_progress,resolved,closed',
            'server_id' => 'required|exists:servers,id',
            'assigned_to' => 'nullable|exists:users,id',
            'category' => 'required|in:hardware,software,network,security,power,environmental,other',
            'priority' => 'required|in:low,medium,high,urgent',
            'impact_level' => 'required|in:minimal,minor,major,critical',
            'affected_services' => 'nullable|array',
            'root_cause' => 'nullable|string|max:500',
            'prevention_measures' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->all();
        $data['reported_by'] = auth()->id();
        $data['detected_at'] = now();

        $incident = Incident::create($data);

        // Log de la création
        AuditService::log(
            'create',
            "Incident {$incident->title} créé",
            $incident,
            null,
            $incident->toArray(),
            'data_modification',
            'medium'
        );

        return redirect()->route('incidents.index')
            ->with('success', 'Incident créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Incident $incident)
    {
        $incident->load(['server', 'assignedTo', 'reportedBy', 'updates']);

        // Log de l'accès
        AuditService::log(
            'view',
            "Incident {$incident->title} consulté",
            $incident,
            null,
            null,
            'data_access',
            'low'
        );

        return view('incidents.show', compact('incident'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Incident $incident)
    {
        $servers = Server::all();
        $users = User::where('role', 'technician')->orWhere('role', 'admin')->get();
        
        return view('incidents.edit', compact('incident', 'servers', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Incident $incident)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'severity' => 'required|in:low,medium,high,critical',
            'status' => 'required|in:open,in_progress,resolved,closed',
            'server_id' => 'required|exists:servers,id',
            'assigned_to' => 'nullable|exists:users,id',
            'category' => 'required|in:hardware,software,network,security,power,environmental,other',
            'priority' => 'required|in:low,medium,high,urgent',
            'impact_level' => 'required|in:minimal,minor,major,critical',
            'affected_services' => 'nullable|array',
            'root_cause' => 'nullable|string|max:500',
            'prevention_measures' => 'nullable|string|max:500',
            'resolution_notes' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $oldValues = $incident->toArray();
        $data = $request->all();

        // Si l'incident est résolu, ajouter la date de résolution
        if ($request->status === 'resolved' && $incident->status !== 'resolved') {
            $data['resolved_at'] = now();
        }

        $incident->update($data);

        // Log de la modification
        AuditService::log(
            'update',
            "Incident {$incident->title} modifié",
            $incident,
            $oldValues,
            $incident->toArray(),
            'data_modification',
            'medium'
        );

        return redirect()->route('incidents.index')
            ->with('success', 'Incident mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Incident $incident)
    {
        $title = $incident->title;
        $incident->delete();

        // Log de la suppression
        AuditService::log(
            'delete',
            "Incident {$title} supprimé",
            'incident',
            null,
            null,
            'data_modification',
            'high'
        );

        return redirect()->route('incidents.index')
            ->with('success', 'Incident supprimé avec succès.');
    }
}
