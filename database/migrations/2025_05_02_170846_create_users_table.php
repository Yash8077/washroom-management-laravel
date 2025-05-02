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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('role')->default('staff'); // Or 'user'. Add index if frequently queried. Index added below.
            // Optional: If using a separate Role model/table
            // $table->foreignId('role_id')->nullable()->constrained('roles')->nullOnDelete();
            $table->string('staff_id')->nullable()->unique(); // Optional staff identifier
            $table->boolean('is_active')->default(true); // Optional activation flag
            $table->rememberToken();
            $table->timestamps(); // created_at, updated_at

            $table->index('role');
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};