<?php

namespace Database\Seeders;

use App\Models\Server;
use App\Models\Datacenter;
use App\Models\User;
use Illuminate\Database\Seeder;

class ServerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datacenters = Datacenter::all();
        $users = User::where('role', 'technician')->get();

        $servers = [
            // Serveurs critiques - Production
            [
                'name' => 'SRV-DB-PRINCIPAL',
                'ip_address' => '192.168.1.10',
                'operating_system' => 'Linux',
                'role' => 'Base de données',
                'location' => 'Datacenter Principal',
                'owner' => 'DBA Team',
                'status' => 'Actif',
                'specifications' => json_encode([
                    'cpu' => 'Intel Xeon E5-2680 v4',
                    'ram' => '128 GB',
                    'storage' => '2 TB SSD',
                    'network' => '10 Gbps'
                ]),
                'datacenter_id' => $datacenters->where('code', 'DC-PRINCIPAL')->first()->id,
                'environment' => 'production',
                'critical_level' => 'critical',
                'notes' => 'Serveur de base de données principal - Critique pour les opérations bancaires'
            ],
            [
                'name' => 'SRV-APP-WEB',
                'ip_address' => '192.168.1.20',
                'operating_system' => 'Linux',
                'role' => 'Application',
                'location' => 'Datacenter Principal',
                'owner' => 'DevOps Team',
                'status' => 'Actif',
                'specifications' => json_encode([
                    'cpu' => 'Intel Xeon E5-2640 v4',
                    'ram' => '64 GB',
                    'storage' => '1 TB SSD',
                    'network' => '10 Gbps'
                ]),
                'datacenter_id' => $datacenters->where('code', 'DC-PRINCIPAL')->first()->id,
                'environment' => 'production',
                'critical_level' => 'critical',
                'notes' => 'Serveur d\'application web principal'
            ],
            [
                'name' => 'SRV-SECURITY-FW',
                'ip_address' => '192.168.1.30',
                'operating_system' => 'Linux',
                'role' => 'Sécurité',
                'location' => 'Datacenter Principal',
                'owner' => 'Security Team',
                'status' => 'Actif',
                'specifications' => json_encode([
                    'cpu' => 'Intel Xeon E5-2620 v4',
                    'ram' => '32 GB',
                    'storage' => '500 GB SSD',
                    'network' => '10 Gbps'
                ]),
                'datacenter_id' => $datacenters->where('code', 'DC-PRINCIPAL')->first()->id,
                'environment' => 'production',
                'critical_level' => 'critical',
                'notes' => 'Firewall principal - Sécurité critique'
            ],
            [
                'name' => 'SRV-BACKUP-STORAGE',
                'ip_address' => '192.168.1.40',
                'operating_system' => 'Linux',
                'role' => 'Backup',
                'location' => 'Datacenter Principal',
                'owner' => 'Backup Team',
                'status' => 'Actif',
                'specifications' => json_encode([
                    'cpu' => 'Intel Xeon E5-2680 v4',
                    'ram' => '64 GB',
                    'storage' => '10 TB HDD',
                    'network' => '10 Gbps'
                ]),
                'datacenter_id' => $datacenters->where('code', 'DC-PRINCIPAL')->first()->id,
                'environment' => 'production',
                'critical_level' => 'high',
                'notes' => 'Serveur de stockage de sauvegarde'
            ],

            // Serveurs secondaires - Redondance
            [
                'name' => 'SRV-DB-SECONDAIRE',
                'ip_address' => '192.168.2.10',
                'operating_system' => 'Linux',
                'role' => 'Base de données',
                'location' => 'Datacenter Secondaire',
                'owner' => 'DBA Team',
                'status' => 'Actif',
                'specifications' => json_encode([
                    'cpu' => 'Intel Xeon E5-2680 v4',
                    'ram' => '128 GB',
                    'storage' => '2 TB SSD',
                    'network' => '5 Gbps'
                ]),
                'datacenter_id' => $datacenters->where('code', 'DC-SECONDAIRE')->first()->id,
                'environment' => 'production',
                'critical_level' => 'critical',
                'notes' => 'Serveur de base de données secondaire - Redondance'
            ],
            [
                'name' => 'SRV-APP-WEB-SEC',
                'ip_address' => '192.168.2.20',
                'operating_system' => 'Linux',
                'role' => 'Application',
                'location' => 'Datacenter Secondaire',
                'owner' => 'DevOps Team',
                'status' => 'Actif',
                'specifications' => json_encode([
                    'cpu' => 'Intel Xeon E5-2640 v4',
                    'ram' => '64 GB',
                    'storage' => '1 TB SSD',
                    'network' => '5 Gbps'
                ]),
                'datacenter_id' => $datacenters->where('code', 'DC-SECONDAIRE')->first()->id,
                'environment' => 'production',
                'critical_level' => 'high',
                'notes' => 'Serveur d\'application web secondaire'
            ],

            // Serveurs en maintenance
            [
                'name' => 'SRV-MONITORING',
                'ip_address' => '192.168.1.50',
                'operating_system' => 'Linux',
                'role' => 'Monitoring',
                'location' => 'Datacenter Principal',
                'owner' => 'Monitoring Team',
                'status' => 'Maintenance',
                'specifications' => json_encode([
                    'cpu' => 'Intel Xeon E5-2620 v4',
                    'ram' => '32 GB',
                    'storage' => '500 GB SSD',
                    'network' => '1 Gbps'
                ]),
                'datacenter_id' => $datacenters->where('code', 'DC-PRINCIPAL')->first()->id,
                'environment' => 'production',
                'critical_level' => 'medium',
                'notes' => 'Serveur de monitoring - Maintenance planifiée'
            ],

            // Serveurs hors service
            [
                'name' => 'SRV-LEGACY-APP',
                'ip_address' => '192.168.1.60',
                'operating_system' => 'Windows Server 2012',
                'role' => 'Application',
                'location' => 'Datacenter Principal',
                'owner' => 'Legacy Team',
                'status' => 'Hors service',
                'specifications' => json_encode([
                    'cpu' => 'Intel Xeon E5-2609',
                    'ram' => '16 GB',
                    'storage' => '500 GB HDD',
                    'network' => '1 Gbps'
                ]),
                'datacenter_id' => $datacenters->where('code', 'DC-PRINCIPAL')->first()->id,
                'environment' => 'production',
                'critical_level' => 'low',
                'notes' => 'Ancienne application legacy - Hors service'
            ],

            // Serveurs de développement
            [
                'name' => 'SRV-DEV-WEB',
                'ip_address' => '192.168.3.10',
                'operating_system' => 'Linux',
                'role' => 'Application',
                'location' => 'Datacenter de Développement',
                'owner' => 'Dev Team',
                'status' => 'Actif',
                'specifications' => json_encode([
                    'cpu' => 'Intel Xeon E5-2620',
                    'ram' => '16 GB',
                    'storage' => '250 GB SSD',
                    'network' => '1 Gbps'
                ]),
                'datacenter_id' => $datacenters->where('code', 'DC-DEV')->first()->id,
                'environment' => 'development',
                'critical_level' => 'low',
                'notes' => 'Serveur de développement web'
            ],
            [
                'name' => 'SRV-TEST-DB',
                'ip_address' => '192.168.3.20',
                'operating_system' => 'Linux',
                'role' => 'Base de données',
                'location' => 'Datacenter de Développement',
                'owner' => 'QA Team',
                'status' => 'Actif',
                'specifications' => json_encode([
                    'cpu' => 'Intel Xeon E5-2620',
                    'ram' => '32 GB',
                    'storage' => '500 GB SSD',
                    'network' => '1 Gbps'
                ]),
                'datacenter_id' => $datacenters->where('code', 'DC-DEV')->first()->id,
                'environment' => 'testing',
                'critical_level' => 'low',
                'notes' => 'Base de données de test'
            ],

            // Serveurs Windows
            [
                'name' => 'SRV-AD-DOMAIN',
                'ip_address' => '192.168.1.70',
                'operating_system' => 'Windows Server 2019',
                'role' => 'Sécurité',
                'location' => 'Datacenter Principal',
                'owner' => 'Security Team',
                'status' => 'Actif',
                'specifications' => json_encode([
                    'cpu' => 'Intel Xeon E5-2620 v4',
                    'ram' => '32 GB',
                    'storage' => '500 GB SSD',
                    'network' => '1 Gbps'
                ]),
                'datacenter_id' => $datacenters->where('code', 'DC-PRINCIPAL')->first()->id,
                'environment' => 'production',
                'critical_level' => 'high',
                'notes' => 'Contrôleur de domaine Active Directory'
            ],
            [
                'name' => 'SRV-EXCHANGE',
                'ip_address' => '192.168.1.80',
                'operating_system' => 'Windows Server 2019',
                'role' => 'Application',
                'location' => 'Datacenter Principal',
                'owner' => 'Infrastructure Team',
                'status' => 'Actif',
                'specifications' => json_encode([
                    'cpu' => 'Intel Xeon E5-2640 v4',
                    'ram' => '64 GB',
                    'storage' => '1 TB SSD',
                    'network' => '1 Gbps'
                ]),
                'datacenter_id' => $datacenters->where('code', 'DC-PRINCIPAL')->first()->id,
                'environment' => 'production',
                'critical_level' => 'high',
                'notes' => 'Serveur Exchange pour les emails'
            ]
        ];

        foreach ($servers as $serverData) {
            $server = Server::create($serverData);
            
            // Assigner des techniciens aléatoirement aux serveurs
            $randomTechnicians = $users->random(rand(1, 3));
            $server->assignedUsers()->attach($randomTechnicians->pluck('id')->toArray());
        }
    }
}
