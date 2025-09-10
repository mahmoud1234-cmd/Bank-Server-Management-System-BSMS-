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
            $table->string('application');
            $table->string('sous_application_module')->nullable();
            $table->string('editeur')->nullable();
            $table->text('descriptif')->nullable();
            $table->string('direction')->nullable();
            $table->string('resp_applicatif')->nullable();
            $table->string('resp_metier')->nullable();
            $table->foreignId('server_id')->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->dropForeign(['server_id']);
            $table->dropColumn([
                'application',
                'sous_application_module',
                'editeur',
                'descriptif',
                'direction',
                'resp_applicatif',
                'resp_metier',
                'server_id'
            ]);
        });
    }
};
