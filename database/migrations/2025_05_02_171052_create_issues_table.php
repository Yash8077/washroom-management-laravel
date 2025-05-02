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
        Schema::create('issues', function (Blueprint $table) {
            $table->id();
            $table->foreignId('washroom_id')->constrained('washrooms')->onDelete('cascade');
            $table->foreignId('reported_by_user_id')->nullable()->constrained('users')->nullOnDelete(); // User who reported
            $table->foreignId('resolved_by_user_id')->nullable()->constrained('users')->nullOnDelete(); // User who resolved
            // linked_task_id foreign key will be added in tasks migration if needed, or here referencing tasks
            $table->string('issue_type'); // e.g., Spill, Clogged, Out of Soap
            $table->string('severity')->nullable()->index(); // e.g., low, medium, high
            $table->text('description')->nullable();
            $table->string('reporter_info')->nullable(); // For public reports (e.g., email)
            $table->string('status')->default('reported')->index(); // reported, acknowledged, in_progress, resolved, rejected
            $table->timestamp('reported_at')->nullable();
            $table->timestamp('resolved_at')->nullable();
            $table->text('resolution_notes')->nullable();
            // Add columns for photo paths if implementing uploads
            // $table->string('photo_path_1')->nullable();
            $table->timestamps();
            // $table->softDeletes(); // Optional
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('issues');
    }
};