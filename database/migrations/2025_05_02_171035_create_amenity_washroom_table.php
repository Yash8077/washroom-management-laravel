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
        Schema::create('amenity_washroom', function (Blueprint $table) {
            // No primary key needed usually, use composite primary key
            $table->foreignId('amenity_id')->constrained('amenities')->onDelete('cascade');
            $table->foreignId('washroom_id')->constrained('washrooms')->onDelete('cascade');

            // Define composite primary key
            $table->primary(['amenity_id', 'washroom_id']);

            // No timestamps needed unless you want to track when an amenity was added/removed
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('amenity_washroom');
    }
};