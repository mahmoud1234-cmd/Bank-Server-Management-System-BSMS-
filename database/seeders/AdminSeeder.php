<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer un utilisateur admin par défaut s'il n'existe pas déjà
        $adminExists = User::where('email', 'admin@bsms.com')->exists();

        if (!$adminExists) {
            User::create([
                'name' => 'Administrateur BSMS',
                'email' => 'admin@bsms.com',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'department' => 'Administration',
                'email_verified_at' => now(),
            ]);

            $this->command->info('Utilisateur admin créé avec succès!');
            $this->command->info('Email: admin@bsms.com');
            $this->command->info('Mot de passe: admin123');
        } else {
            $this->command->info('Un utilisateur admin existe déjà.');
        }
    }
}
