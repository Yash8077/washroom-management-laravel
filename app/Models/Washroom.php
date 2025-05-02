<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
// use Illuminate\Database\Eloquent\SoftDeletes;

class Washroom extends Model
{
    use HasFactory;
    // use SoftDeletes; // Optional

    protected $fillable = [
        'floor_id',
        'name',             // e.g., "Men's East Wing", "Accessible F1-03"
        'identifier',       // e.g., "BLDGA-F1-W01" (unique identifier)
        'capacity',         // Number of stalls/urinals
        'current_status',   // e.g., 'clean', 'dirty', 'needs_attention', 'out_of_order'
        'occupancy_status', // e.g., 'available', 'occupied', 'partially_occupied', 'unknown'
        'supply_status',    // e.g., 'ok', 'low_soap', 'low_paper', 'low_both'
        'last_cleaned_at',
        'latitude',
        'longitude',
        'notes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'last_cleaned_at' => 'datetime',
        'capacity' => 'integer',
        'latitude' => 'decimal:7', // Adjust precision as needed
        'longitude' => 'decimal:7', // Adjust precision as needed
    ];

    /**
     * Get the floor that owns the washroom.
     */
    public function floor(): BelongsTo
    {
        return $this->belongsTo(Floor::class);
    }

    /**
     * Get the tasks associated with the washroom.
     */
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    /**
     * Get the issues reported for the washroom.
     */
    public function issues(): HasMany
    {
        return $this->hasMany(Issue::class);
    }

    /**
     * The amenities that belong to the washroom.
     * Assumes a pivot table 'amenity_washroom'.
     */
    public function amenities(): BelongsToMany
    {
        // Assumes pivot table 'amenity_washroom' with 'amenity_id' and 'washroom_id'
        return $this->belongsToMany(Amenity::class);
    }

    // --- Accessor Example (like the one in controller example) ---
    public function getOverallStatusAttribute(): string
    {
        if ($this->current_status === 'out_of_order' || $this->issues()->whereIn('status', ['reported', 'acknowledged', 'in-progress'])->where('severity', 'high')->exists()) { // Assuming Issue has 'severity'
            return 'red';
        }
        if ($this->current_status !== 'clean' || $this->supply_status !== 'ok' || $this->issues()->whereIn('status', ['reported', 'acknowledged', 'in-progress'])->exists()) {
             return 'yellow';
        }
        if ($this->current_status === 'clean') {
             return 'green';
        }
        return 'gray'; // Default/Unknown
    }
}