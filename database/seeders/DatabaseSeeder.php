<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        {
        $roles = ['admin', 'manager', 'auditor'];
        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }

        // Assigner le rôle "admin" au premier utilisateur
        $user = User::first();
        if ($user) {
            $user->assignRole('admin');
        }
        // Exécuter les seeders dans l'ordre
        $this->call([
            AdminUserSeeder::class,
            DatacenterSeeder::class,
            ServerSeeder::class,
            IncidentSeeder::class,
            MaintenanceTaskSeeder::class,
            ClusterSeeder::class,
        ]);

        // Créer un utilisateur de test par défaut si nécessaire
        if (!User::where('email', 'test@example.com')->exists()) {
            User::factory()->create([
                'name' => 'Test User',
                'email' => 'test@example.com',
                'role' => 'admin',
                'department' => 'IT',
                'is_active' => true,
            ]);
        }

    }
}
}
