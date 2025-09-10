<?php

namespace Database\Seeders;

use App\Models\Incident;
use Illuminate\Database\Seeder;

class IncidentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer des incidents de test si nécessaire
        if (Incident::count() === 0) {
            Incident::factory()->count(5)->create();
        }
    }
}
