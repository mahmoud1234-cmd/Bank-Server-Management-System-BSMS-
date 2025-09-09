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
        Schema::create('datacenters', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->text('address');
            $table->string('city');
            $table->string('country');
            $table->integer('capacity')->default(0);
            $table->enum('status', ['operational', 'maintenance', 'offline'])->default('operational');
            $table->string('manager')->nullable();
            $table->string('contact_phone')->nullable();
            $table->string('contact_email')->nullable();
            $table->enum('security_level', ['low', 'medium', 'high', 'critical'])->default('medium');
            $table->json('environmental_controls')->nullable();
            $table->json('backup_power')->nullable();
            $table->json('network_connectivity')->nullable();
            $table->text('description')->nullable();
            $table->json('coordinates')->nullable();
            $table->string('timezone')->default('UTC');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('datacenters');
    }
};
