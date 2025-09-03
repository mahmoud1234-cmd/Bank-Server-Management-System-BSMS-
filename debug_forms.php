<?php
// Script de débogage pour tester les formulaires BSMS

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== ANALYSE COMPLÈTE DES FORMULAIRES BSMS ===\n\n";

// Test 1: Vérifier les données de base
echo "1. DONNÉES DE BASE:\n";
echo "   - Serveurs: " . App\Models\Server::count() . "\n";
echo "   - Utilisateurs: " . App\Models\User::count() . "\n";
echo "   - Clusters: " . App\Models\Cluster::count() . "\n";
echo "   - Serveurs disponibles pour clusters: " . App\Models\Server::whereNull('cluster_id')->count() . "\n\n";

// Test 2: Vérifier les contrôleurs
echo "2. CONTRÔLEURS:\n";
try {
    $incidentController = new App\Http\Controllers\IncidentController();
    echo "   ✓ IncidentController accessible\n";
} catch (Exception $e) {
    echo "   ✗ IncidentController erreur: " . $e->getMessage() . "\n";
}

try {
    $clusterController = new App\Http\Controllers\ClusterController();
    echo "   ✓ ClusterController accessible\n";
} catch (Exception $e) {
    echo "   ✗ ClusterController erreur: " . $e->getMessage() . "\n";
}

// Test 3: Vérifier les vues
echo "\n3. VUES:\n";
$incidentCreatePath = 'resources/views/incidents/create.blade.php';
$clusterCreatePath = 'resources/views/clusters/create.blade.php';

echo "   - Incident create: " . (file_exists($incidentCreatePath) ? "✓ Existe" : "✗ Manquant") . "\n";
echo "   - Cluster create: " . (file_exists($clusterCreatePath) ? "✓ Existe" : "✗ Manquant") . "\n";

// Test 4: Simuler les méthodes create des contrôleurs
echo "\n4. SIMULATION DES MÉTHODES CREATE:\n";

try {
    // Test IncidentController::create()
    $servers = App\Models\Server::all();
    $users = App\Models\User::all();
    echo "   - IncidentController::create() - Serveurs: " . $servers->count() . ", Utilisateurs: " . $users->count() . "\n";
    
    // Test ClusterController::create()
    $availableServers = App\Models\Server::whereNull('cluster_id')->get();
    echo "   - ClusterController::create() - Serveurs disponibles: " . $availableServers->count() . "\n";
    
    if ($availableServers->count() === 0) {
        echo "   ⚠️  PROBLÈME: Aucun serveur disponible pour les clusters!\n";
    }
    
} catch (Exception $e) {
    echo "   ✗ Erreur lors de la simulation: " . $e->getMessage() . "\n";
}

echo "\n=== FIN DE L'ANALYSE ===\n";
