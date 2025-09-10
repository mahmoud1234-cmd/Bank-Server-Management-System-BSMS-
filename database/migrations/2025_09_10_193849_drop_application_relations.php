<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Exécute les migrations.
     */
    public function up(): void
    {
        // Neutralisé volontairement pendant le développement pour éviter
        // de casser les relations avec la table 'applications'.
        return;
    }

    /**
     * Annule les migrations.
     */
    public function down(): void
    {
        // Cette migration est destructrice, donc la méthode down() ne peut pas tout restaurer
        // car nous ne pouvons pas recréer les données supprimées
    }

    /**
     * Supprime les clés étrangères des autres tables pointant vers la table applications
     */
    private function dropForeignKeysToApplicationsTable(): void
    {
        $tables = [
            'incidents',
            'maintenance_tasks',
            'servers',
            'clusters'
            // Ajoutez d'autres tables qui pourraient avoir des relations avec applications
        ];

        foreach ($tables as $tableName) {
            if (Schema::hasTable($tableName)) {
                Schema::table($tableName, function (Blueprint $table) use ($tableName) {
                    $sm = Schema::getConnection()->getDoctrineSchemaManager();
                    $tableDetails = $sm->listTableDetails($tableName);
                    
                    foreach ($tableDetails->getForeignKeys() as $foreignKey) {
                        if ($foreignKey->getForeignTableName() === 'applications') {
                            $table->dropForeign([$foreignKey->getLocalColumns()[0]]);
                        }
                    }
                });
            }
        }
    }
};
