<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
// use Illuminate\Database\Eloquent\SoftDeletes;

class Building extends Model
{
    use HasFactory;
    // use SoftDeletes; // Optional

    protected $fillable = [
        'name',
        'address', // Optional
        'notes',   // Optional
    ];

    /**
     * Get the floors associated with the building.
     */
    public function floors(): HasMany
    {
        return $this->hasMany(Floor::class);
    }

    /**
      * Get all washrooms within this building through floors.
      */
    public function washrooms(): \Illuminate\Database\Eloquent\Relations\HasManyThrough
    {
        return $this->hasManyThrough(Washroom::class, Floor::class);
    }
}