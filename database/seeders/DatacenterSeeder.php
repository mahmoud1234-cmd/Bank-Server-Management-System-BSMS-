<?php

namespace Database\Seeders;

use App\Models\Datacenter;
use Illuminate\Database\Seeder;

class DatacenterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datacenters = [
            [
                'name' => 'Datacenter Principal',
                'code' => 'DC-PRINCIPAL',
                'address' => '123 Rue de la Banque, 75001 Paris',
                'city' => 'Paris',
                'country' => 'France',
                'capacity' => 500,
                'status' => 'operational',
                'manager' => 'Jean Dupont',
                'contact_phone' => '+33 1 23 45 67 89',
                'contact_email' => 'dc.principal@banque.fr',
                'security_level' => 'critical',
                'environmental_controls' => json_encode([
                    'temperature' => '18-22°C',
                    'humidity' => '40-60%',
                    'fire_suppression' => 'FM-200',
                    'access_control' => 'Biométrique'
                ]),
                'backup_power' => json_encode([
                    'ups' => '2N Redundant',
                    'generators' => 'N+1 Configuration',
                    'fuel_capacity' => '72 hours'
                ]),
                'network_connectivity' => json_encode([
                    'bandwidth' => '10 Gbps',
                    'redundancy' => 'Dual ISP',
                    'latency' => '< 5ms'
                ]),
                'description' => 'Datacenter principal de la banque avec infrastructure critique',
                'coordinates' => json_encode(['lat' => 48.8566, 'lng' => 2.3522]),
                'timezone' => 'Europe/Paris'
            ],
            [
                'name' => 'Datacenter Secondaire',
                'code' => 'DC-SECONDAIRE',
                'address' => '456 Avenue des Affaires, 69000 Lyon',
                'city' => 'Lyon',
                'country' => 'France',
                'capacity' => 300,
                'status' => 'operational',
                'manager' => 'Marie Martin',
                'contact_phone' => '+33 4 78 12 34 56',
                'contact_email' => 'dc.secondaire@banque.fr',
                'security_level' => 'high',
                'environmental_controls' => json_encode([
                    'temperature' => '18-22°C',
                    'humidity' => '40-60%',
                    'fire_suppression' => 'FM-200',
                    'access_control' => 'Badge + Code'
                ]),
                'backup_power' => json_encode([
                    'ups' => 'N+1 Redundant',
                    'generators' => 'N Configuration',
                    'fuel_capacity' => '48 hours'
                ]),
                'network_connectivity' => json_encode([
                    'bandwidth' => '5 Gbps',
                    'redundancy' => 'Dual ISP',
                    'latency' => '< 10ms'
                ]),
                'description' => 'Datacenter secondaire pour la redondance et le backup',
                'coordinates' => json_encode(['lat' => 45.7578, 'lng' => 4.8320]),
                'timezone' => 'Europe/Paris'
            ],
            [
                'name' => 'Datacenter de Développement',
                'code' => 'DC-DEV',
                'address' => '789 Boulevard de l\'Innovation, 13000 Marseille',
                'city' => 'Marseille',
                'country' => 'France',
                'capacity' => 100,
                'status' => 'operational',
                'manager' => 'Pierre Durand',
                'contact_phone' => '+33 4 91 23 45 67',
                'contact_email' => 'dc.dev@banque.fr',
                'security_level' => 'medium',
                'environmental_controls' => json_encode([
                    'temperature' => '18-25°C',
                    'humidity' => '30-70%',
                    'fire_suppression' => 'Sprinkler',
                    'access_control' => 'Badge'
                ]),
                'backup_power' => json_encode([
                    'ups' => 'N Configuration',
                    'generators' => 'None',
                    'fuel_capacity' => '0 hours'
                ]),
                'network_connectivity' => json_encode([
                    'bandwidth' => '1 Gbps',
                    'redundancy' => 'Single ISP',
                    'latency' => '< 20ms'
                ]),
                'description' => 'Datacenter pour les environnements de développement et test',
                'coordinates' => json_encode(['lat' => 43.2965, 'lng' => 5.3698]),
                'timezone' => 'Europe/Paris'
            ]
        ];

        foreach ($datacenters as $datacenter) {
            Datacenter::create($datacenter);
        }
    }
}
