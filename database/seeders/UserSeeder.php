<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Admin Principal',
                'email' => 'admin@banque.fr',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'department' => 'IT Management',
                'phone' => '+33 1 23 45 67 89',
                'is_active' => true,
            ],
            [
                'name' => 'Technicien Senior',
                'email' => 'tech.senior@banque.fr',
                'password' => Hash::make('password'),
                'role' => 'technician',
                'department' => 'Infrastructure',
                'phone' => '+33 1 23 45 67 90',
                'is_active' => true,
            ],
            [
                'name' => 'Technicien Junior',
                'email' => 'tech.junior@banque.fr',
                'password' => Hash::make('password'),
                'role' => 'technician',
                'department' => 'Infrastructure',
                'phone' => '+33 1 23 45 67 91',
                'is_active' => true,
            ],
            [
                'name' => 'Manager IT',
                'email' => 'manager@banque.fr',
                'password' => Hash::make('password'),
                'role' => 'manager',
                'department' => 'IT Management',
                'phone' => '+33 1 23 45 67 92',
                'is_active' => true,
            ],
            [
                'name' => 'Auditeur Sécurité',
                'email' => 'auditor@banque.fr',
                'password' => Hash::make('password'),
                'role' => 'auditor',
                'department' => 'Audit & Compliance',
                'phone' => '+33 1 23 45 67 93',
                'is_active' => true,
            ],
            [
                'name' => 'Technicien Réseau',
                'email' => 'network@banque.fr',
                'password' => Hash::make('password'),
                'role' => 'technician',
                'department' => 'Réseau',
                'phone' => '+33 1 23 45 67 94',
                'is_active' => true,
            ],
            [
                'name' => 'Technicien Sécurité',
                'email' => 'security@banque.fr',
                'password' => Hash::make('password'),
                'role' => 'technician',
                'department' => 'Sécurité',
                'phone' => '+33 1 23 45 67 95',
                'is_active' => true,
            ],
            [
                'name' => 'Manager Datacenter',
                'email' => 'dc.manager@banque.fr',
                'password' => Hash::make('password'),
                'role' => 'manager',
                'department' => 'Datacenter',
                'phone' => '+33 1 23 45 67 96',
                'is_active' => true,
            ]
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
