<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Mahmoud',
            'email' => 'mahmoudhasnaoui223@gmail.com',
            'password' => Hash::make('mahmoud2001'),
            'role' => 'admin',
        ]);
    }
}
