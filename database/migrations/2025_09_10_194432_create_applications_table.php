<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Exécute les migrations.
     */
    public function up(): void
    {
        // La table 'applications' a déjà été créée par une migration précédente (112803)
        // On ajoute ici les colonnes nécessaires conformément au nouveau schéma demandé
        Schema::table('applications', function (Blueprint $table) {
            // Colonnes fonctionnelles (seulement si absentes)
            if (!Schema::hasColumn('applications', 'application')) {
                $table->string('application')->after('id');
            }
            if (!Schema::hasColumn('applications', 'sous_application_module')) {
                $table->string('sous_application_module')->nullable()->after('application');
            }
            if (!Schema::hasColumn('applications', 'editeur')) {
                $table->string('editeur')->nullable()->after('sous_application_module');
            }
            if (!Schema::hasColumn('applications', 'descriptif')) {
                $table->text('descriptif')->nullable()->after('editeur');
            }
            if (!Schema::hasColumn('applications', 'direction')) {
                $table->string('direction')->nullable()->after('descriptif');
            }
            if (!Schema::hasColumn('applications', 'resp_applicatif')) {
                $table->string('resp_applicatif')->after('direction');
            }
            if (!Schema::hasColumn('applications', 'resp_metier')) {
                $table->string('resp_metier')->after('resp_applicatif');
            }

            // Relation serveur (seulement si absente)
            if (!Schema::hasColumn('applications', 'server_id')) {
                $table->foreignId('server_id')->nullable()->constrained('servers')->onDelete('set null')->after('resp_metier');
            }
        });
    }

    /**
     * Annule les migrations.
     */
    public function down(): void
    {
        // On retire uniquement les colonnes ajoutées par cette migration
        Schema::table('applications', function (Blueprint $table) {
            // FK server_id
            if (Schema::hasColumn('applications', 'server_id')) {
                try { $table->dropConstrainedForeignId('server_id'); } catch (\Throwable $e) {}
            }
            // Colonnes (seulement si présentes)
            foreach (['application','sous_application_module','editeur','descriptif','direction','resp_applicatif','resp_metier'] as $col) {
                if (Schema::hasColumn('applications', $col)) {
                    try { $table->dropColumn($col); } catch (\Throwable $e) {}
                }
            }
        });
    }
};
