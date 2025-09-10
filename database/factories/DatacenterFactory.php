<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class DatacenterFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->city . ' ' . $this->faker->randomElement(['DC', 'Data Center', 'Campus']),
            'location' => $this->faker->address,
            'status' => $this->faker->randomElement(['operational', 'maintenance', 'degraded', 'offline']),
            'description' => $this->faker->paragraph,
            'created_at' => $this->faker->dateTimeThisYear(),
            'updated_at' => $this->faker->dateTimeThisYear(),
        ];
    }
}
