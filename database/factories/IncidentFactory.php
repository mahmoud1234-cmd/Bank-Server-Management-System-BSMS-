<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Server;
use Illuminate\Database\Eloquent\Factories\Factory;

class IncidentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'severity' => $this->faker->randomElement(['low', 'medium', 'high', 'critical']),
            'status' => $this->faker->randomElement(['open', 'in_progress', 'resolved', 'closed']),
            'reported_by' => User::factory(),
            'assigned_to' => User::factory(),
            'server_id' => Server::factory(),
            'resolved_at' => $this->faker->optional()->dateTimeThisMonth(),
            'created_at' => $this->faker->dateTimeThisYear(),
            'updated_at' => $this->faker->dateTimeThisYear(),
        ];
    }
}
