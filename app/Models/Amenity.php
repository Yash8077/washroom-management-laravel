<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Amenity extends Model
{
    use HasFactory;

    // Assuming amenities are predefined
    // protected $fillable = ['name', 'icon']; // e.g., icon class name
     protected $guarded = []; // Allow mass assignment if needed


    /**
     * The washrooms that have this amenity.
     * Assumes a pivot table 'amenity_washroom'.
     */
    public function washrooms(): BelongsToMany
    {
         // Assumes pivot table 'amenity_washroom' with 'amenity_id' and 'washroom_id'
        return $this->belongsToMany(Washroom::class);
    }
}