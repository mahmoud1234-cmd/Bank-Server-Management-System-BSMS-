<?php

namespace App\Http\Controllers;

use App\Models\Cluster;
use App\Models\Server;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClusterController extends Controller
{
    public function index()
    {
        $clusters = Cluster::with('servers')->get();
        return view('clusters.index', compact('clusters'));
    }

    public function create()
    {
        $availableServers = Server::whereNull('cluster_id')->get();
        return view('clusters.create', compact('availableServers'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100|unique:clusters',
            'mode' => 'required|in:actif_actif,actif_passif',
            'server_ids' => 'required|array|min:2',
            'server_ids.*' => 'exists:servers,id'
        ]);

        // Validation nombre pair obligatoire
        if (count($request->server_ids) % 2 !== 0) {
            return back()->withErrors(['server_ids' => 'Le nombre de serveurs doit être pair pour former un cluster.'])->withInput();
        }

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Vérifier que les serveurs ne sont pas déjà dans un cluster
        $serversInCluster = Server::whereIn('id', $request->server_ids)
                                 ->whereNotNull('cluster_id')
                                 ->exists();

        if ($serversInCluster) {
            return back()->withErrors(['server_ids' => 'Certains serveurs sont déjà assignés à un cluster.'])->withInput();
        }

        // Créer le cluster
        $cluster = Cluster::create([
            'name' => $request->name,
            'mode' => $request->mode
        ]);

        // Assigner les serveurs au cluster
        Server::whereIn('id', $request->server_ids)->update(['cluster_id' => $cluster->id]);

        return redirect()->route('clusters.index')->with('success', 'Cluster créé avec succès!');
    }

    public function show(Cluster $cluster)
    {
        $cluster->load('servers');
        return view('clusters.show', compact('cluster'));
    }

    public function edit(Cluster $cluster)
    {
        $availableServers = Server::whereNull('cluster_id')
                                 ->orWhere('cluster_id', $cluster->id)
                                 ->get();
        return view('clusters.edit', compact('cluster', 'availableServers'));
    }

    public function update(Request $request, Cluster $cluster)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100|unique:clusters,name,' . $cluster->id,
            'mode' => 'required|in:actif_actif,actif_passif',
            'server_ids' => 'required|array|min:2',
            'server_ids.*' => 'exists:servers,id'
        ]);

        // Validation nombre pair obligatoire
        if (count($request->server_ids) % 2 !== 0) {
            return back()->withErrors(['server_ids' => 'Le nombre de serveurs doit être pair pour former un cluster.'])->withInput();
        }

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Vérifier que les serveurs ne sont pas déjà dans un autre cluster
        $serversInOtherCluster = Server::whereIn('id', $request->server_ids)
                                      ->where('cluster_id', '!=', $cluster->id)
                                      ->whereNotNull('cluster_id')
                                      ->exists();

        if ($serversInOtherCluster) {
            return back()->withErrors(['server_ids' => 'Certains serveurs sont déjà assignés à un autre cluster.'])->withInput();
        }

        // Libérer les anciens serveurs
        Server::where('cluster_id', $cluster->id)->update(['cluster_id' => null]);

        // Mettre à jour le cluster
        $cluster->update([
            'name' => $request->name,
            'mode' => $request->mode
        ]);

        // Assigner les nouveaux serveurs
        Server::whereIn('id', $request->server_ids)->update(['cluster_id' => $cluster->id]);

        return redirect()->route('clusters.index')->with('success', 'Cluster mis à jour avec succès!');
    }

    public function destroy(Cluster $cluster)
    {
        // Libérer les serveurs du cluster
        Server::where('cluster_id', $cluster->id)->update(['cluster_id' => null]);
        
        $cluster->delete();

        return redirect()->route('clusters.index')->with('success', 'Cluster supprimé avec succès!');
    }

    /**
     * Obtenir les statistiques des clusters pour le dashboard
     */
    public function getClusterStats()
    {
        $totalClusters = Cluster::count();
        $activeClusters = Cluster::whereHas('servers', function($query) {
            $query->where('status', 'Actif');
        })->count();
        
        $clustersByMode = Cluster::selectRaw('mode, COUNT(*) as count')
                                ->groupBy('mode')
                                ->pluck('count', 'mode')
                                ->toArray();

        return [
            'total_clusters' => $totalClusters,
            'active_clusters' => $activeClusters,
            'clusters_by_mode' => $clustersByMode
        ];
    }
}
