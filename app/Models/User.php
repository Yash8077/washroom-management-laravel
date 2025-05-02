<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
// use Illuminate\Database\Eloquent\SoftDeletes; // Optional: if you want to soft delete users

class User extends Authenticatable // implements MustVerifyEmail // Optional email verification
{
    use HasFactory, Notifiable;
    // use SoftDeletes; // Optional

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // Simple role management via a string column
        'role_id', // Alternative: Foreign key if using Role model/table
        'staff_id', // Optional: Specific ID for staff members
        'is_active', // Optional: To deactivate users instead of deleting
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean', // Optional
        ];
    }

    // --- Relationships ---

    /**
     * Get the role associated with the user (if using Role model).
     */
    public function role(): BelongsTo
    {
        // Assumes 'role_id' foreign key exists on the users table
        return $this->belongsTo(Role::class);
    }

    /**
     * Get the tasks assigned TO this user (staff).
     */
    public function assignedTasks(): HasMany
    {
        return $this->hasMany(Task::class, 'assigned_user_id');
    }

    /**
     * Get the tasks created BY this user (admin).
     */
    public function createdTasks(): HasMany
    {
        return $this->hasMany(Task::class, 'created_by_user_id');
    }

    /**
     * Get the issues reported BY this user.
     */
    public function reportedIssues(): HasMany
    {
        return $this->hasMany(Issue::class, 'reported_by_user_id');
    }

    /**
     * Get the issues resolved BY this user.
     */
    public function resolvedIssues(): HasMany
    {
        return $this->hasMany(Issue::class, 'resolved_by_user_id');
    }

    // --- Helper Methods for Role Checking (if using string 'role' column) ---

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isStaff(): bool
    {
        return $this->role === 'staff';
    }
}