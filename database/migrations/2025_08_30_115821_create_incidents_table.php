<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::create('incidents', function (Blueprint $table) {
        $table->id();
        $table->string('title')->nullable(); // Nom de l’incident peut être null
        $table->text('description')->nullable(); // Détails peuvent être null
        $table->enum('severity', ['low', 'medium', 'high', 'critical'])->default('medium');
        $table->enum('status', ['open', 'in_progress', 'resolved', 'closed'])->default('open');
        $table->foreignId('server_id')->constrained()->onDelete('cascade');
        $table->foreignId('assigned_to')->nullable()->constrained('users')->onDelete('set null');
        $table->foreignId('reported_by')->constrained('users')->onDelete('cascade');
        $table->timestamp('detected_at')->nullable();
        $table->timestamp('resolved_at')->nullable();
        $table->text('resolution_notes')->nullable();
        $table->enum('category', ['hardware', 'software', 'network', 'security', 'power', 'environmental', 'other'])->default('other');
        $table->enum('priority', ['low', 'medium', 'high', 'urgent'])->default('medium');
        $table->timestamp('estimated_resolution_time')->nullable();
        $table->timestamp('actual_resolution_time')->nullable();
        $table->enum('impact_level', ['minimal', 'minor', 'major', 'critical'])->default('minor');
        $table->json('affected_services')->nullable();
        $table->text('root_cause')->nullable();
        $table->text('prevention_measures')->nullable();
        $table->timestamps();
    });
}


    public function down(): void
    {
        Schema::dropIfExists('incidents');
    }
};
