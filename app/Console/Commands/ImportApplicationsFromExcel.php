<?php

namespace App\Console\Commands;

use App\Models\Application;
use App\Models\Server;
use Illuminate\Console\Command;

class ImportApplicationsFromExcel extends Command
{
    protected $signature = 'applications:import-excel {path? : Absolute or relative path to the Excel file} {--update-existing : Update existing applications matched by application name}';

    protected $description = 'Import applications from an Excel file into the applications table';

    public function handle(): int
    {
        $path = $this->argument('path') ?: base_path('Inventaire_Applicatifs25-06_2018.xlsx');

        if (!file_exists($path)) {
            $this->error("File not found: {$path}");
            return self::FAILURE;
        }

        if (!class_exists('PhpOffice\\PhpSpreadsheet\\IOFactory')) {
            $this->error('PhpSpreadsheet is not installed. Please run: composer require phpoffice/phpspreadsheet');
            return self::FAILURE;
        }

        $this->info("Reading Excel: {$path}");

        try {
            $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReaderForFile($path);
            $spreadsheet = $reader->load($path);
            $sheet = $spreadsheet->getActiveSheet();
        } catch (\Throwable $e) {
            $this->error('Failed to read Excel: ' . $e->getMessage());
            return self::FAILURE;
        }

        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();
        $highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn);

        if ($highestRow < 2) {
            $this->warn('No data rows found.');
            return self::SUCCESS;
        }

        // Read headers (row 1)
        $headers = [];
        for ($col = 1; $col <= $highestColumnIndex; $col++) {
            $val = trim((string) $sheet->getCellByColumnAndRow($col, 1)->getValue());
            $headers[$col] = $this->normalizeHeader($val);
        }

        $inserted = 0; $updated = 0; $skipped = 0; $errors = 0;

        for ($row = 2; $row <= $highestRow; $row++) {
            $rowData = [];
            for ($col = 1; $col <= $highestColumnIndex; $col++) {
                $header = $headers[$col] ?? null;
                if (!$header) continue;
                $rowData[$header] = trim((string) $sheet->getCellByColumnAndRow($col, $row)->getCalculatedValue());
            }

            // Map to our fields
            $payload = [
                'application' => $rowData['application'] ?? $rowData['nom_application'] ?? $rowData['app'] ?? null,
                'sous_application_module' => $rowData['sous_application_module'] ?? $rowData['sous_application'] ?? $rowData['module'] ?? null,
                'editeur' => $rowData['editeur'] ?? $rowData['éditeur'] ?? $rowData['vendor'] ?? null,
                'descriptif' => $rowData['descriptif'] ?? $rowData['description'] ?? null,
                'direction' => $rowData['direction'] ?? $rowData['departement'] ?? $rowData['department'] ?? null,
                'resp_applicatif' => $rowData['resp_applicatif'] ?? $rowData['responsable_applicatif'] ?? null,
                'resp_metier' => $rowData['resp_metier'] ?? $rowData['responsable_metier'] ?? null,
            ];

            // Basic validation
            if (empty($payload['application']) || empty($payload['resp_applicatif']) || empty($payload['resp_metier'])) {
                $skipped++; continue;
            }

            // Map name for legacy NOT NULL constraint
            $payload['name'] = $payload['application'];

            // Try to resolve server_id if present
            $server_id = null;
            $serverKey = $rowData['serveur'] ?? $rowData['server'] ?? $rowData['ip'] ?? null;
            if ($serverKey) {
                $server = Server::query()
                    ->where('name', $serverKey)
                    ->orWhere('ip_address', $serverKey)
                    ->first();
                if ($server) { $server_id = $server->id; }
            }
            $payload['server_id'] = $server_id;

            try {
                if ($this->option('update-existing')) {
                    $existing = Application::query()->where('application', $payload['application'])->first();
                    if ($existing) {
                        $existing->update($payload);
                        $updated++;
                        continue;
                    }
                }
                Application::create($payload);
                $inserted++;
            } catch (\Throwable $e) {
                $errors++;
                $this->warn("Row {$row} failed: " . $e->getMessage());
            }
        }

        $this->info("Imported: {$inserted}, Updated: {$updated}, Skipped: {$skipped}, Errors: {$errors}");
        return self::SUCCESS;
    }

    private function normalizeHeader(string $h): ?string
    {
        $h = mb_strtolower(trim($h));
        $map = [
            'application' => ['application','app','nom application','nom_application','nom-app'],
            'sous_application_module' => ['sous application','sous_application','module','sous-application','sous application / module'],
            'editeur' => ['editeur','éditeur','vendor','éditeur / editeur'],
            'descriptif' => ['descriptif','description','desc'],
            'direction' => ['direction','departement','département','department'],
            'resp_applicatif' => ['resp applicatif','responsable applicatif','resp_applicatif'],
            'resp_metier' => ['resp metier','responsable metier','resp_metier','responsable métier'],
            'serveur' => ['serveur','server','ip','ip_address','adresse ip'],
        ];
        foreach ($map as $norm => $variants) {
            if (in_array($h, $variants, true)) return $norm;
        }
        return $h ?: null;
    }
}
