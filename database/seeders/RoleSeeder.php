<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer les rôles s'ils n'existent pas déjà
        $roles = ['admin', 'manager', 'auditor'];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }

        // Assigner le rôle "admin" à l'utilisateur avec ID = 1
        $user = User::find(1);

        if ($user) {
            $user->assignRole('admin');
            $this->command->info("Le rôle 'admin' a été assigné à l'utilisateur ID=1 ({$user->email})");
        } else {
            $this->command->warn("Aucun utilisateur avec ID=1 trouvé.");
        }
    }
}
