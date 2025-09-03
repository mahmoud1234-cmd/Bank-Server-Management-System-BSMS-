<?php
require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

try {
    // Supprimer l'utilisateur existant s'il existe
    User::where('email', 'admin@bsms.com')->delete();
    
    // Créer un nouvel utilisateur admin
    $user = User::create([
        'name' => 'Admin User',
        'email' => 'admin@bsms.com',
        'password' => Hash::make('password'),
        'role' => 'admin',
        'email_verified_at' => now()
    ]);
    
    echo "✅ Utilisateur créé avec succès:\n";
    echo "Email: admin@bsms.com\n";
    echo "Password: password\n";
    echo "Role: admin\n";
    
    // Créer un utilisateur test supplémentaire
    User::where('email', 'test@bsms.com')->delete();
    $testUser = User::create([
        'name' => 'Test User',
        'email' => 'test@bsms.com',
        'password' => Hash::make('test123'),
        'role' => 'technician',
        'email_verified_at' => now()
    ]);
    
    echo "✅ Utilisateur test créé:\n";
    echo "Email: test@bsms.com\n";
    echo "Password: test123\n";
    echo "Role: technician\n";
    
    echo "\n📊 Total utilisateurs: " . User::count() . "\n";
    
} catch (Exception $e) {
    echo "❌ Erreur: " . $e->getMessage() . "\n";
}
?>
