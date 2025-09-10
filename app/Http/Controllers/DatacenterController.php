<?php

namespace App\Http\Controllers;

use App\Models\Datacenter;
use App\Services\AuditService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DatacenterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Datacenter::query();

        // Filtres
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%")
                  ->orWhere('city', 'like', "%{$search}%")
                  ->orWhere('country', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('country')) {
            $query->where('country', $request->country);
        }

        // Tri
        $sortBy = $request->get('sort_by', 'name');
        $sortOrder = $request->get('sort_order', 'asc');
        $query->orderBy($sortBy, $sortOrder);

        $datacenters = $query->paginate(15);

        // Log de l'accès
        AuditService::log(
            'view',
            'Liste des datacenters consultée',
            'datacenter',
            null,
            null,
            'data_access',
            'low'
        );

        return view('datacenters.index', compact('datacenters'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('datacenters.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:datacenters',
            'address' => 'required|string|max:500',
            'city' => 'required|string|max:100',
            'country' => 'required|string|max:100',
            'capacity' => 'required|integer|min:1',
            // Aligné sur la migration: enum(['operational','maintenance','offline'])
            'status' => 'required|in:operational,maintenance,offline',
            // Champs de contact optionnels (le formulaire ne les force pas)
            'manager' => 'nullable|string|max:255',
            'contact_phone' => 'nullable|string|max:20',
            'contact_email' => 'nullable|email|max:255',
            // Aligné sur la migration: enum(['low','medium','high','critical'])
            'security_level' => 'required|in:low,medium,high,critical',
            'description' => 'nullable|string|max:1000',
            // Optionnel, présent dans le formulaire avec valeurs suggérées
            'timezone' => 'nullable|string|max:100',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $datacenter = Datacenter::create($request->all());

        // Log de la création
        AuditService::log(
            'create',
            "Datacenter {$datacenter->name} créé",
            $datacenter,
            null,
            $datacenter->toArray(),
            'data_modification',
            'medium'
        );

        return redirect()->route('datacenters.index')
            ->with('success', 'Datacenter créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Datacenter $datacenter)
    {
        $datacenter->load(['servers']);

        // Log de l'accès
        AuditService::log(
            'view',
            "Datacenter {$datacenter->name} consulté",
            $datacenter,
            null,
            null,
            'data_access',
            'low'
        );

        return view('datacenters.show', compact('datacenter'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Datacenter $datacenter)
    {
        return view('datacenters.edit', compact('datacenter'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Datacenter $datacenter)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:datacenters,code,' . $datacenter->id,
            'address' => 'required|string|max:500',
            'city' => 'required|string|max:100',
            'country' => 'required|string|max:100',
            'capacity' => 'required|integer|min:1',
            'status' => 'required|in:operational,maintenance,offline',
            'manager' => 'nullable|string|max:255',
            'contact_phone' => 'nullable|string|max:20',
            'contact_email' => 'nullable|email|max:255',
            'security_level' => 'required|in:low,medium,high,critical',
            'description' => 'nullable|string|max:1000',
            'timezone' => 'nullable|string|max:100',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $oldValues = $datacenter->toArray();
        $datacenter->update($request->all());

        // Log de la modification
        AuditService::log(
            'update',
            "Datacenter {$datacenter->name} modifié",
            $datacenter,
            $oldValues,
            $datacenter->toArray(),
            'data_modification',
            'medium'
        );

        return redirect()->route('datacenters.index')
            ->with('success', 'Datacenter mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Datacenter $datacenter)
    {
        $name = $datacenter->name;
        $datacenter->delete();

        // Log de la suppression
        AuditService::log(
            'delete',
            "Datacenter {$name} supprimé",
            'datacenter',
            null,
            null,
            'data_modification',
            'high'
        );

        return redirect()->route('datacenters.index')
            ->with('success', 'Datacenter supprimé avec succès.');
    }
}
