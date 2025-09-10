<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            // Champs
            if (!Schema::hasColumn('applications', 'name')) {
                $table->string('name')->nullable();
            }
            if (!Schema::hasColumn('applications', 'version')) {
                $table->string('version')->nullable();
            }
            if (!Schema::hasColumn('applications', 'editeur')) {
                $table->string('editeur')->nullable();
            }
            if (!Schema::hasColumn('applications', 'description')) {
                $table->text('description')->nullable();
            }
            if (!Schema::hasColumn('applications', 'direction')) {
                $table->string('direction')->nullable();
            }
            if (!Schema::hasColumn('applications', 'resp_applicatif')) {
                $table->string('resp_applicatif')->nullable();
            }
            if (!Schema::hasColumn('applications', 'resp_metier')) {
                $table->string('resp_metier')->nullable();
            }
            if (!Schema::hasColumn('applications', 'status')) {
                $table->string('status')->default('Actif');
            }
            if (!Schema::hasColumn('applications', 'environment')) {
                $table->string('environment')->nullable();
            }
            if (!Schema::hasColumn('applications', 'critical_level')) {
                $table->string('critical_level')->default('Moyenne');
            }
            if (!Schema::hasColumn('applications', 'notes')) {
                $table->text('notes')->nullable();
            }

            // Relations
            if (!Schema::hasColumn('applications', 'server_id')) {
                $table->foreignId('server_id')->nullable()->constrained()->onDelete('set null');
            }
            if (!Schema::hasColumn('applications', 'cluster_id')) {
                $table->foreignId('cluster_id')->nullable()->constrained('clusters')->onDelete('set null');
            }

            // Métadonnées
            if (!Schema::hasColumn('applications', 'documentation_url')) {
                $table->string('documentation_url')->nullable();
            }
            if (!Schema::hasColumn('applications', 'support_contact')) {
                $table->string('support_contact')->nullable();
            }
            if (!Schema::hasColumn('applications', 'last_updated')) {
                $table->date('last_updated')->nullable();
            }
            if (!Schema::hasColumn('applications', 'next_update')) {
                $table->date('next_update')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            // Drop FKs if columns exist
            if (Schema::hasColumn('applications', 'server_id')) {
                try { $table->dropForeign(['server_id']); } catch (\Throwable $e) {}
            }
            if (Schema::hasColumn('applications', 'cluster_id')) {
                try { $table->dropForeign(['cluster_id']); } catch (\Throwable $e) {}
            }

            $columns = [
                'name', 'version', 'editeur', 'description', 'direction',
                'resp_applicatif', 'resp_metier', 'status', 'environment',
                'critical_level', 'notes', 'server_id', 'cluster_id',
                'documentation_url', 'support_contact', 'last_updated', 'next_update'
            ];

            foreach ($columns as $column) {
                if (Schema::hasColumn('applications', $column)) {
                    try { $table->dropColumn($column); } catch (\Throwable $e) {}
                }
            }
        });
    }
};
