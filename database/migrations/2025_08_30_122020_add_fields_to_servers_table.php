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
            $table->json('specifications')->nullable()->after('status');
            $table->timestamp('last_maintenance_date')->nullable()->after('specifications');
            $table->timestamp('next_maintenance_date')->nullable()->after('last_maintenance_date');
            $table->foreignId('datacenter_id')->nullable()->after('next_maintenance_date')->constrained()->onDelete('set null');
            $table->enum('environment', ['production', 'staging', 'development', 'testing'])->default('production')->after('datacenter_id');
            $table->enum('critical_level', ['low', 'medium', 'high', 'critical'])->default('medium')->after('environment');
            $table->text('notes')->nullable()->after('critical_level');

            $table->index(['status', 'critical_level']);
            $table->index(['datacenter_id', 'status']);
            $table->index(['operating_system', 'role']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('servers', function (Blueprint $table) {
            $table->dropForeign(['datacenter_id']);
            $table->dropIndex(['status', 'critical_level']);
            $table->dropIndex(['datacenter_id', 'status']);
            $table->dropIndex(['operating_system', 'role']);
            
            $table->dropColumn([
                'specifications',
                'last_maintenance_date',
                'next_maintenance_date',
                'datacenter_id',
                'environment',
                'critical_level',
                'notes'
            ]);
        });
    }
};
