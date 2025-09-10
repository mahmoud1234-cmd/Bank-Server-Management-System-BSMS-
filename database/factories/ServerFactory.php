<?php

namespace Database\Factories;

use App\Models\Datacenter;
use App\Models\Cluster;
use Illuminate\Database\Eloquent\Factories\Factory;

class ServerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->word . '-server-' . $this->faker->randomNumber(3),
            'ip_address' => $this->faker->unique()->ipv4,
            'operating_system' => $this->faker->randomElement(['Windows Server 2022', 'Ubuntu 22.04', 'CentOS 8', 'Debian 11']),
            'cpu_cores' => $this->faker->numberBetween(1, 32),
            'memory_gb' => $this->faker->numberBetween(2, 256),
            'disk_gb' => $this->faker->numberBetween(50, 2048),
            'status' => $this->faker->randomElement(['online', 'offline', 'maintenance', 'error']),
            'last_seen' => $this->faker->dateTimeThisMonth(),
            'datacenter_id' => Datacenter::factory(),
            'cluster_id' => $this->faker->optional()->randomElement(Cluster::pluck('id')->toArray()),
            'created_at' => $this->faker->dateTimeThisYear(),
            'updated_at' => $this->faker->dateTimeThisYear(),
        ];
    }
}
