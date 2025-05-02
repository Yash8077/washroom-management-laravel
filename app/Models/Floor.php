<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
// use Illuminate\Database\Eloquent\SoftDeletes;

class Floor extends Model
{
    use HasFactory;
    // use SoftDeletes; // Optional

    protected $fillable = [
        'building_id',
        'name', // e.g., "Ground Floor", "Level 1", "Basement"
        'level_number', // Optional: Numerical level for sorting
        'notes', // Optional
    ];

    /**
     * Get the building that owns the floor.
     */
    public function building(): BelongsTo
    {
        return $this->belongsTo(Building::class);
    }

    /**
     * Get the washrooms associated with the floor.
     */
    public function washrooms(): HasMany
    {
        return $this->hasMany(Washroom::class);
    }
}