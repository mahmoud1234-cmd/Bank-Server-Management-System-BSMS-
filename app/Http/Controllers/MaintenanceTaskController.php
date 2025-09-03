<?php

namespace App\Http\Controllers;

use App\Models\MaintenanceTask;
use App\Models\Server;
use App\Models\User;
use App\Services\AuditService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MaintenanceTaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = MaintenanceTask::with(['server', 'assignedTo', 'approvedBy']);

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

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('server_id')) {
            $query->where('server_id', $request->server_id);
        }

        // Tri
        $sortBy = $request->get('sort_by', 'scheduled_at');
        $sortOrder = $request->get('sort_order', 'asc');
        $query->orderBy($sortBy, $sortOrder);

        $maintenanceTasks = $query->paginate(15);
        $servers = Server::all();

        // Log de l'accès
        AuditService::log(
            'view',
            'Liste des maintenances consultée',
            'maintenance_task',
            null,
            null,
            'data_access',
            'low'
        );

        return view('maintenance-tasks.index', compact('maintenanceTasks', 'servers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $servers = Server::all();
        $users = User::all();
        
        return view('maintenance-tasks.create', compact('servers', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'type' => 'required|in:preventive,corrective,upgrade,backup',
            'status' => 'required|in:scheduled,in_progress,completed,cancelled',
            'server_id' => 'required|exists:servers,id',
            'assigned_to' => 'nullable|exists:users,id',
            'scheduled_at' => 'required|date|after:now',
            'priority' => 'required|in:low,medium,high,urgent',
            'category' => 'required|string|max:100',
            'maintenance_window_start' => 'nullable|date',
            'maintenance_window_end' => 'nullable|date|after:maintenance_window_start',
            'estimated_duration' => 'nullable|integer|min:1',
            'notes' => 'nullable|string|max:1000',
            'checklist_items' => 'nullable|array',
            'required_approval' => 'boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->all();
        $data['checklist_items'] = $request->checklist_items ? json_encode($request->checklist_items) : null;

        $maintenanceTask = MaintenanceTask::create($data);

        // Log de la création
        AuditService::log(
            'create',
            "Maintenance {$maintenanceTask->title} créée",
            $maintenanceTask,
            null,
            $maintenanceTask->toArray(),
            'data_modification',
            'medium'
        );

        return redirect()->route('maintenance-tasks.index')
            ->with('success', 'Maintenance créée avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(MaintenanceTask $maintenanceTask)
    {
        $maintenanceTask->load(['server', 'assignedTo', 'approvedBy']);

        // Log de l'accès
        AuditService::log(
            'view',
            "Maintenance {$maintenanceTask->title} consultée",
            $maintenanceTask,
            null,
            null,
            'data_access',
            'low'
        );

        return view('maintenance-tasks.show', compact('maintenanceTask'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MaintenanceTask $maintenanceTask)
    {
        $servers = Server::all();
        $users = User::where('role', 'technician')->orWhere('role', 'admin')->get();
        
        return view('maintenance-tasks.edit', compact('maintenanceTask', 'servers', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MaintenanceTask $maintenanceTask)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'type' => 'required|in:preventive,corrective,upgrade,backup',
            'status' => 'required|in:scheduled,in_progress,completed,cancelled',
            'server_id' => 'required|exists:servers,id',
            'assigned_to' => 'nullable|exists:users,id',
            'scheduled_at' => 'required|date',
            'priority' => 'required|in:low,medium,high,urgent',
            'category' => 'required|string|max:100',
            'maintenance_window_start' => 'nullable|date',
            'maintenance_window_end' => 'nullable|date|after:maintenance_window_start',
            'estimated_duration' => 'nullable|integer|min:1',
            'actual_duration' => 'nullable|integer|min:1',
            'notes' => 'nullable|string|max:1000',
            'checklist_items' => 'nullable|array',
            'required_approval' => 'boolean',
            'approved_by' => 'nullable|exists:users,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $oldValues = $maintenanceTask->toArray();
        $data = $request->all();
        $data['checklist_items'] = $request->checklist_items ? json_encode($request->checklist_items) : null;

        // Si la maintenance est terminée, ajouter la date de fin
        if ($request->status === 'completed' && $maintenanceTask->status !== 'completed') {
            $data['completed_at'] = now();
        }

        // Si une approbation est requise et fournie
        if ($request->filled('approved_by')) {
            $data['approval_date'] = now();
        }

        $maintenanceTask->update($data);

        // Log de la modification
        AuditService::log(
            'update',
            "Maintenance {$maintenanceTask->title} modifiée",
            $maintenanceTask,
            $oldValues,
            $maintenanceTask->toArray(),
            'data_modification',
            'medium'
        );

        return redirect()->route('maintenance-tasks.index')
            ->with('success', 'Maintenance mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MaintenanceTask $maintenanceTask)
    {
        $title = $maintenanceTask->title;
        $maintenanceTask->delete();

        // Log de la suppression
        AuditService::log(
            'delete',
            "Maintenance {$title} supprimée",
            'maintenance_task',
            null,
            null,
            'data_modification',
            'high'
        );

        return redirect()->route('maintenance-tasks.index')
            ->with('success', 'Maintenance supprimée avec succès.');
    }
}
