<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class TestUserSeeder extends Seeder
{
    public function run()
    {
        // Créer un utilisateur de test avec des identifiants simples
        User::updateOrCreate(
            ['email' => 'admin@bsms.com'],
            [
                'name' => 'Admin BSMS',
                'email' => 'admin@bsms.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'department' => 'IT',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        // Créer l'utilisateur Mahmoud avec le bon format
        User::updateOrCreate(
            ['email' => 'mahmoudhasnaoui223@gmail.com'],
            [
                'name' => 'Mahmoud',
                'email' => 'mahmoudhasnaoui223@gmail.com',
                'password' => Hash::make('mahmoud2001'),
                'role' => 'admin',
                'department' => 'IT',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        $this->command->info('Utilisateurs de test créés:');
        $this->command->info('Email: admin@bsms.com | Password: password');
        $this->command->info('Email: mahmoudhasnaoui223@gmail.com | Password: mahmoud2001');
    }
}
