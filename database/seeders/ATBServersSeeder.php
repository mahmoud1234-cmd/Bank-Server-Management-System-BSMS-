<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Server;
use App\Models\Datacenter;

class ATBServersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure target datacenters exist
        $tunis = Datacenter::where('code', 'ATB-TUNIS-DC')->first();
        $bizerte = Datacenter::where('code', 'ATB-BIZERTE-DC')->first();
        $djerba = Datacenter::where('code', 'ATB-DJERBA-DC')->first();

        if (!$tunis || !$bizerte || !$djerba) {
            $this->command->warn('ATB datacenters not found. Run ATBDatacentersSeeder first.');
            return;
        }

        $targets = [
            ['dc' => $tunis,  'count' => 40, 'prefix' => 'tns'],
            ['dc' => $bizerte,'count' => 30, 'prefix' => 'bzt'],
            ['dc' => $djerba, 'count' => 30, 'prefix' => 'djb'],
        ];

        $oses  = ['Windows Server 2022', 'Ubuntu 22.04', 'Debian 12', 'CentOS 7', 'RHEL 9'];
        $roles = ['Web', 'App', 'DB', 'Cache', 'Backup'];
        $envs  = ['production','staging','development','testing'];
        $crit  = ['low','medium','high','critical'];

        foreach ($targets as $t) {
            $dc = $t['dc'];
            $count = $t['count'];
            $prefix = $t['prefix'];

            // generate non-conflicting IPs per site: 10.X.Y.Z
            // Tunis  -> 10.10.x.x, Bizerte -> 10.20.x.x, Djerba -> 10.30.x.x
            $ipOctet = $prefix === 'tns' ? 10 : ($prefix === 'bzt' ? 20 : 30);

            for ($i = 1; $i <= $count; $i++) {
                $num = str_pad((string)$i, 3, '0', STR_PAD_LEFT);
                $name = strtoupper($prefix) . "-SRV-{$num}";

                // Spread IPs to avoid uniqueness conflicts
                $octet3 = intdiv($i - 1, 250) + 1; // usually 1
                $octet4 = (($i - 1) % 250) + 1;   // 1..250
                $ip = "10.{$ipOctet}.{$octet3}.{$octet4}";

                $payload = [
                    'name' => $name,
                    'ip_address' => $ip,
                    'operating_system' => $oses[array_rand($oses)],
                    'role' => $roles[array_rand($roles)],
                    'location' => $dc->city . ', ' . $dc->country,
                    'owner' => 'ATB IT',
                    'status' => 'Actif',
                    'specifications' => json_encode([
                        'cpu' => rand(4, 32) . ' vCPU',
                        'ram' => rand(8, 128) . ' GB',
                        'disk' => rand(100, 2000) . ' GB SSD'
                    ]),
                    'datacenter_id' => $dc->id,
                    'environment' => $envs[array_rand($envs)],
                    'critical_level' => $crit[array_rand($crit)],
                    'notes' => 'Seeded server'
                ];

                Server::updateOrCreate(
                    ['ip_address' => $ip],
                    $payload
                );
            }
        }

        $this->command->info('ATB 100 servers seeded across Tunis (40), Bizerte (30), Djerba (30).');
    }
}
