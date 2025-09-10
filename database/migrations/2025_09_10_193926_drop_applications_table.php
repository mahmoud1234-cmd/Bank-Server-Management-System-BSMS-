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
        // la suppression de la table 'applications'.
        // Laissez cette migration vide ou déplacez sa logique en down().
        return; 
    }

    /**
     * Annule les migrations.
     * Note: Cette opération est destructrice, la méthode down() ne peut pas restaurer les données supprimées
     */
    public function down(): void
    {
        // Cette migration est destructrice, donc la méthode down() ne peut pas restaurer les données
        // car nous ne pouvons pas recréer les données supprimées
        
        // Si nécessaire, vous pourriez recréer la table avec sa structure ici
        // Mais sans les données d'origine
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
            'clusters',
            'application_user'
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
