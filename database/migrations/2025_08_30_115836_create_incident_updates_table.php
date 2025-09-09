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
        Schema::create('incident_updates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('incident_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('status', ['open', 'in_progress', 'resolved', 'closed'])->nullable();
            $table->text('description');
            $table->enum('update_type', ['status_change', 'assignment', 'priority_change', 'progress', 'resolution', 'escalation', 'comment'])->default('comment');
            $table->enum('priority_change', ['low', 'medium', 'high', 'urgent'])->nullable();
            $table->enum('severity_change', ['low', 'medium', 'high', 'critical'])->nullable();
            $table->foreignId('assigned_to_change')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('estimated_resolution_time')->nullable();
            $table->json('attachments')->nullable();
            $table->text('internal_notes')->nullable();
            $table->text('public_notes')->nullable();
            $table->timestamps();

            $table->index(['incident_id', 'created_at']);
            $table->index(['user_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incident_updates');
    }
};
