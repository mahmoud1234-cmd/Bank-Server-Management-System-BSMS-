<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Datacenter;

class ATBDatacentersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rows = [
            [
                'name' => 'ATB Tunis Datacenter',
                'code' => 'ATB-TUNIS-DC',
                'address' => 'Siège ATB, Centre Urbain Nord, Tunis',
                'city' => 'Tunis',
                'country' => 'Tunisia',
                'capacity' => 300,
                'status' => 'operational',
                'manager' => 'ATB Ops Tunis',
                'contact_phone' => '+216 71 000 000',
                'contact_email' => 'dc.tunis@atb.tn',
                'security_level' => 'high',
                'environmental_controls' => json_encode([
                    'temperature' => '18-22°C',
                    'humidity' => '40-60%',
                    'fire_suppression' => 'FM-200',
                    'access_control' => 'Biometric'
                ]),
                'backup_power' => json_encode([
                    'ups' => '2N Redundant',
                    'generators' => 'N+1',
                    'fuel_capacity' => '72 hours'
                ]),
                'network_connectivity' => json_encode([
                    'bandwidth' => '10 Gbps',
                    'redundancy' => 'Dual ISP',
                    'latency' => '< 5ms'
                ]),
                'description' => 'Datacenter principal ATB (Tunis).',
                'coordinates' => json_encode(['lat' => 36.8460, 'lng' => 10.2060]),
                'timezone' => 'Africa/Tunis',
            ],
            [
                'name' => 'ATB Bizerte Datacenter',
                'code' => 'ATB-BIZERTE-DC',
                'address' => 'Zone Industrielle, Bizerte',
                'city' => 'Bizerte',
                'country' => 'Tunisia',
                'capacity' => 180,
                'status' => 'operational',
                'manager' => 'ATB Ops Bizerte',
                'contact_phone' => '+216 72 000 000',
                'contact_email' => 'dc.bizerte@atb.tn',
                'security_level' => 'medium',
                'environmental_controls' => json_encode([
                    'temperature' => '18-22°C',
                    'humidity' => '40-60%',
                    'fire_suppression' => 'CO2',
                    'access_control' => 'Badge + PIN'
                ]),
                'backup_power' => json_encode([
                    'ups' => 'N+1',
                    'generators' => 'N',
                    'fuel_capacity' => '48 hours'
                ]),
                'network_connectivity' => json_encode([
                    'bandwidth' => '5 Gbps',
                    'redundancy' => 'Dual ISP',
                    'latency' => '< 10ms'
                ]),
                'description' => 'Site secondaire ATB (Bizerte).',
                'coordinates' => json_encode(['lat' => 37.2746, 'lng' => 9.8739]),
                'timezone' => 'Africa/Tunis',
            ],
            [
                'name' => 'ATB Djerba Datacenter',
                'code' => 'ATB-DJERBA-DC',
                'address' => 'Houmt Souk, Djerba',
                'city' => 'Djerba',
                'country' => 'Tunisia',
                'capacity' => 150,
                'status' => 'operational',
                'manager' => 'ATB Ops Djerba',
                'contact_phone' => '+216 75 000 000',
                'contact_email' => 'dc.djerba@atb.tn',
                'security_level' => 'medium',
                'environmental_controls' => json_encode([
                    'temperature' => '18-24°C',
                    'humidity' => '35-65%',
                    'fire_suppression' => 'Sprinkler',
                    'access_control' => 'Badge'
                ]),
                'backup_power' => json_encode([
                    'ups' => 'N',
                    'generators' => 'N',
                    'fuel_capacity' => '24 hours'
                ]),
                'network_connectivity' => json_encode([
                    'bandwidth' => '2 Gbps',
                    'redundancy' => 'Single ISP',
                    'latency' => '< 20ms'
                ]),
                'description' => 'Site régional ATB (Djerba).',
                'coordinates' => json_encode(['lat' => 33.8076, 'lng' => 10.8451]),
                'timezone' => 'Africa/Tunis',
            ],
        ];

        foreach ($rows as $row) {
            Datacenter::updateOrCreate(
                ['code' => $row['code']],
                $row
            );
        }
    }
}
