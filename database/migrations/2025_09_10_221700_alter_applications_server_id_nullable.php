<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('applications') && Schema::hasColumn('applications', 'server_id')) {
            Schema::table('applications', function (Blueprint $table) {
                // Tenter de supprimer la contrainte si elle existe
                try { $table->dropForeign(['server_id']); } catch (\Throwable $e) {}
                // Supprimer la colonne pour la recréer en nullable (évite la dépendance à doctrine/dbal)
                try { $table->dropColumn('server_id'); } catch (\Throwable $e) {}
            });
        }

        // Recréer server_id en nullable et FK set null on delete
        Schema::table('applications', function (Blueprint $table) {
            if (!Schema::hasColumn('applications', 'server_id')) {
                $table->foreignId('server_id')->nullable()->constrained('servers')->onDelete('set null');
            }
        });
    }

    public function down(): void
    {
        if (Schema::hasTable('applications') && Schema::hasColumn('applications', 'server_id')) {
            Schema::table('applications', function (Blueprint $table) {
                try { $table->dropForeign(['server_id']); } catch (\Throwable $e) {}
                try { $table->dropColumn('server_id'); } catch (\Throwable $e) {}
            });
        }

        // Recréer server_id en non-nullable (ancienne contrainte)
        Schema::table('applications', function (Blueprint $table) {
            if (!Schema::hasColumn('applications', 'server_id')) {
                $table->foreignId('server_id')->constrained('servers');
            }
        });
    }
};
