<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Server;
use App\Models\Cluster;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class ApplicationController extends Controller
{
    /**
     * Affiche la liste des applications
     */
    public function index(Request $request)
    {
        $query = Application::with(['server']);

        // Recherche par application, éditeur, responsables, direction
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('application', 'like', "%{$search}%")
                  ->orWhere('editeur', 'like', "%{$search}%")
                  ->orWhere('resp_applicatif', 'like', "%{$search}%")
                  ->orWhere('resp_metier', 'like', "%{$search}%")
                  ->orWhere('direction', 'like', "%{$search}%");
            });
        }

        // Tri
        $sortBy = $request->get('sort_by', 'application');
        $sortOrder = $request->get('sort_order', 'asc');
        $query->orderBy($sortBy, $sortOrder);

        $applications = $query->paginate(15)->withQueryString();

        return view('applications.index', compact('applications'));
    }

    /**
     * Affiche le formulaire de création d'une application
     */
    public function create()
    {
        
        $servers = Server::all();
        
        return view('applications.create', compact('servers'));
    }
            
    /**
     * Enregistre une nouvelle application
     */
    public function store(Request $request)
    {
        Log::info('[Applications] Soumission du formulaire de création reçue', [
            'payload' => $request->except(['_token'])
        ]);
        $validated = $request->validate([
            'application' => 'required|string|max:255',
            'sous_application_module' => 'nullable|string|max:255',
            'editeur' => 'nullable|string|max:255',
            'descriptif' => 'nullable|string',
            'direction' => 'nullable|string|max:255',
            'resp_applicatif' => 'required|string|max:255',
            'resp_metier' => 'required|string|max:255',
            'server_id' => 'nullable|exists:servers,id',
        ]);

        // Compatibilité avec anciens schémas: certaines migrations exigent 'name' NOT NULL
        // On mappe donc 'application' vers 'name' pour satisfaire la contrainte existante
        $validated['name'] = $validated['application'];
        // Normaliser server_id vide ("" ou 0) en NULL si aucun serveur n'est sélectionné
        if (!isset($validated['server_id']) || empty($validated['server_id'])) {
            $validated['server_id'] = null;
        }

        DB::beginTransaction();
        
        try {
            $application = Application::create($validated);
            
            DB::commit();
            
            return redirect()
                ->route('applications.show', $application)
                ->with('success', 'Application créée avec succès.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('[Applications] Erreur lors de la création', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return back()
                ->withInput()
                ->with('error', "Une erreur est survenue lors de la création de l'application. Vérifiez que la table et les colonnes existent puis réessayez.");
        }
    }

    /**
     * Affiche les détails d'une application
     */
    public function show(Application $application)
    {
        $application->load(['server']);
        
        return view('applications.show', compact('application'));
    }
    
    /**
     * Affiche le formulaire de modification d'une application
     */
    public function edit(Application $application)
    {
        $servers = Server::all();
        
        return view('applications.edit', compact('application', 'servers'));
    }
    
    /**
     * Met à jour une application existante
     */
    public function update(Request $request, Application $application)
    {
        $validated = $request->validate([
            'application' => 'required|string|max:255',
            'sous_application_module' => 'nullable|string|max:255',
            'editeur' => 'nullable|string|max:255',
            'descriptif' => 'nullable|string',
            'direction' => 'nullable|string|max:255',
            'resp_applicatif' => 'required|string|max:255',
            'resp_metier' => 'required|string|max:255',
            'server_id' => 'nullable|exists:servers,id',
        ]);

        // Compatibilité avec anciens schémas
        $validated['name'] = $validated['application'];
        // Normaliser server_id vide en NULL
        if (!isset($validated['server_id']) || empty($validated['server_id'])) {
            $validated['server_id'] = null;
        }

        DB::beginTransaction();
        
        try {
            $application->update($validated);
            
            // Aucun mapping d'utilisateurs dans le schéma minimal
            
            DB::commit();
            
            return redirect()
                ->route('applications.show', $application)
                ->with('success', 'Application mise à jour avec succès.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erreur lors de la mise à jour de l\'application : ' . $e->getMessage());
            
            return back()
                ->withInput()
                ->with('error', 'Une erreur est survenue lors de la mise à jour de l\'application.');
        }
    }

    /**
     * Supprimer une application
     */
    public function destroy(Application $application)
    {
        $application->delete();

        return redirect()->route('applications.index')
            ->with('success', 'Application supprimée ❌');
    }
}
