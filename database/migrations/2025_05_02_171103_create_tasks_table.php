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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('washroom_id')->constrained('washrooms')->onDelete('cascade');
            $table->foreignId('assigned_user_id')->nullable()->constrained('users')->nullOnDelete(); // Staff assigned
            $table->foreignId('created_by_user_id')->nullable()->constrained('users')->nullOnDelete(); // Admin who created
            $table->foreignId('linked_issue_id')->nullable()->constrained('issues')->nullOnDelete(); // Optional link to issue
            $table->string('type'); // e.g., Routine Cleaning, Refill Supplies
            $table->string('priority')->default('medium')->index(); // low, medium, high, urgent
            $table->string('status')->default('pending')->index(); // unassigned, pending, in-progress, completed, blocked, cancelled
            $table->text('description')->nullable(); // Instructions
            $table->timestamp('due_at')->nullable();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
             // $table->softDeletes(); // Optional
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};