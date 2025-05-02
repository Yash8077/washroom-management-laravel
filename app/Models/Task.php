<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    use HasFactory;

    // Assuming roles are predefined and not frequently changed,
    // mass assignment might not be needed.
    // protected $fillable = ['name', 'description'];
    protected $guarded = []; // Allow mass assignment if needed for seeding/management


    /**
     * Get the users associated with the role.
     */
    public function users(): HasMany
    {
        // Assumes 'role_id' foreign key on the users table
        return $this->hasMany(User::class);

        // OR: If using a pivot table (user_role) for many-to-many:
        // return $this->belongsToMany(User::class);
    }
}