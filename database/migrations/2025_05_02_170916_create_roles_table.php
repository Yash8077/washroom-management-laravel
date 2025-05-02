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
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // e.g., 'admin', 'staff', 'facility_user'
            $table->string('description')->nullable();
            $table->timestamps();
        });

        // --- Seed initial roles ---
        // It's often better to do this in a Seeder, but can be done here for simplicity
        // \App\Models\Role::create(['name' => 'admin', 'description' => 'System Administrator']);
        // \App\Models\Role::create(['name' => 'staff', 'description' => 'Cleaning/Maintenance Staff']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};