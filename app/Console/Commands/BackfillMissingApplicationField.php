<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class BackfillMissingApplicationField extends Command
{
    protected $signature = 'applications:backfill-missing-application {--dry-run : Show what would change without writing}';

    protected $description = 'Fill applications.application with name when application is NULL or empty';

    public function handle(): int
    {
        $dry = (bool)$this->option('dry-run');

        $total = DB::table('applications')->count();
        $missing = DB::table('applications')
            ->whereNull('application')
            ->orWhere('application', '=','')
            ->count();

        $this->info("Applications total: {$total}");
        $this->info("Missing application field: {$missing}");

        if ($missing === 0) {
            $this->info('Nothing to backfill.');
            return self::SUCCESS;
        }

        if ($dry) {
            $preview = DB::table('applications')
                ->select('id','name','application')
                ->whereNull('application')
                ->orWhere('application', '=','')
                ->limit(10)
                ->get();
            $this->table(['id','name','application'], $preview->map(fn($r)=>[(string)$r->id,(string)$r->name,(string)($r->application ?? '')])->toArray());
            $this->warn('Dry-run only. Re-run without --dry-run to apply.');
            return self::SUCCESS;
        }

        $affected = DB::table('applications')
            ->where(function($q){
                $q->whereNull('application')->orWhere('application','=','');
            })
            ->whereNotNull('name')
            ->where('name','<>','')
            ->update(['application' => DB::raw('name')]);

        $this->info("Updated rows: {$affected}");
        return self::SUCCESS;
    }
}
