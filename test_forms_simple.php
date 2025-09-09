<?php
// Test simple pour diagnostiquer les formulaires

echo "=== DIAGNOSTIC FORMULAIRES BSMS ===\n";

// Test connexion base de données
try {
    $pdo = new PDO('mysql:host=127.0.0.1;dbname=bank_servers', 'root', '');
    echo "✓ Connexion base de données OK\n";
    
    // Compter les enregistrements
    $servers = $pdo->query("SELECT COUNT(*) FROM servers")->fetchColumn();
    $users = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
    $clusters = $pdo->query("SELECT COUNT(*) FROM clusters")->fetchColumn();
    $availableServers = $pdo->query("SELECT COUNT(*) FROM servers WHERE cluster_id IS NULL")->fetchColumn();
    
    echo "Serveurs: $servers\n";
    echo "Utilisateurs: $users\n"; 
    echo "Clusters: $clusters\n";
    echo "Serveurs disponibles: $availableServers\n";
    
    // Libérer quelques serveurs pour les clusters
    if ($availableServers < 4) {
        $pdo->exec("UPDATE servers SET cluster_id = NULL LIMIT 8");
        echo "✓ Serveurs libérés pour les clusters\n";
    }
    
} catch (Exception $e) {
    echo "✗ Erreur base de données: " . $e->getMessage() . "\n";
}

echo "=== FIN DIAGNOSTIC ===\n";
