<?php

namespace Database\Seeders;

use App\Models\MaintenanceTask;
use Illuminate\Database\Seeder;

class MaintenanceTaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer des tâches de maintenance de test si nécessaire
        if (MaintenanceTask::count() === 0) {
            MaintenanceTask::factory()->count(5)->create();
        }
    }
}
