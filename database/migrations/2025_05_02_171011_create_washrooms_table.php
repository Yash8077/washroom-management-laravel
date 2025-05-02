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
        Schema::create('washrooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('floor_id')
                  ->constrained('floors') // Assumes table name is 'floors'
                  ->onDelete('cascade');
            $table->string('name'); // User-friendly name
            $table->string('identifier')->unique(); // Unique code like BLDGA-F1-W01
            $table->unsignedInteger('capacity')->nullable();
            $table->string('current_status')->default('unknown')->index(); // clean, dirty, needs_attention, out_of_order
            $table->string('occupancy_status')->default('unknown')->index(); // available, occupied, unknown
            $table->string('supply_status')->default('unknown')->index(); // ok, low_soap, low_paper, low_both
            $table->timestamp('last_cleaned_at')->nullable();
            $table->decimal('latitude', 10, 7)->nullable(); // Adjust precision if needed
            $table->decimal('longitude', 10, 7)->nullable();// Adjust precision if needed
            $table->text('notes')->nullable();
            $table->timestamps();
            // $table->softDeletes(); // Optional
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('washrooms');
    }
};