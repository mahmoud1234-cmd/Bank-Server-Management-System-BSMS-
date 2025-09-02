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
     Schema::table('servers', function (Blueprint $table) {
    if (!Schema::hasColumn('servers', 'cpu')) {
        $table->integer('cpu')->default(0);
    }
    if (!Schema::hasColumn('servers', 'ram')) {
        $table->integer('ram')->default(0);
    }
    if (!Schema::hasColumn('servers', 'storage')) {
        $table->integer('storage')->default(0);
    }
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('servers', function (Blueprint $table) {
        $table->dropColumn(['cpu', 'ram', 'storage']);
        });
    }
};
