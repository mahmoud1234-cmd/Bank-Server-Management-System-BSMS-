<?php

namespace Database\Seeders;

use App\Models\Cluster;
use App\Models\Server;
use Illuminate\Database\Seeder;

class ClusterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Récupérer les serveurs disponibles (sans cluster assigné)
        $servers = Server::whereNull('cluster_id')->get();
        
        if ($servers->count() < 4) {
            $this->command->info('Pas assez de serveurs disponibles pour créer des clusters');
            return;
        }

        // Cluster 1: Production Critical (Actif/Passif)
        $cluster1 = Cluster::create([
            'name' => 'Cluster Production Critical',
            'mode' => 'actif_passif'
        ]);

        // Assigner 4 serveurs critiques au premier cluster
        $criticalServers = $servers->where('critical_level', 'critical')->take(4);
        if ($criticalServers->count() >= 4) {
            $criticalServers->each(function ($server) use ($cluster1) {
                $server->update(['cluster_id' => $cluster1->id]);
            });
        }

        // Cluster 2: Load Balancing Web (Actif/Actif)
        $cluster2 = Cluster::create([
            'name' => 'Cluster Web Load Balancing',
            'mode' => 'actif_actif'
        ]);

        // Assigner 4 serveurs d'application au deuxième cluster
        $remainingServers = Server::whereNull('cluster_id')
                                 ->where('role', 'Application')
                                 ->orWhere('role', 'Infrastructure')
                                 ->take(4)
                                 ->get();
        
        if ($remainingServers->count() >= 4) {
            $remainingServers->each(function ($server) use ($cluster2) {
                $server->update(['cluster_id' => $cluster2->id]);
            });
        }

        $this->command->info('2 clusters créés avec succès!');
        $this->command->info("Cluster 1: {$cluster1->name} - Mode: {$cluster1->mode} - Serveurs: " . $cluster1->servers()->count());
        $this->command->info("Cluster 2: {$cluster2->name} - Mode: {$cluster2->mode} - Serveurs: " . $cluster2->servers()->count());
    }
}
