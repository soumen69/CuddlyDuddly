<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\HasRoles;

class AdminUser extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $guard = 'admin';
    protected $table = 'admin_users';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'session_id',
        'role_id',
        'is_active',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'is_active' => 'boolean',
        'email_verified_at' => 'datetime',
    ];

    // Auto-hash passwords
    public function setPasswordAttribute($value)
    {
        if ($value && Hash::needsRehash($value)) {
            $this->attributes['password'] = Hash::make($value);
        } else {
            $this->attributes['password'] = $value;
        }
    }

    public function isActive(): bool
    {
        return (bool) $this->is_active;
    }

    /** Relation: one role (simple FK approach) */
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    /** Access all permissions through role */
    public function permissions()
    {
        return $this->role ? $this->role->permissions : collect();
    }

    public function hasPermission($permissionSlug)
    {
        if ($this->role && $this->role->slug === 'super-admin') {
            return true;
        }

        // Check if the user has a role and the role has the given permission
        return $this->role && $this->role->permissions->contains('slug', $permissionSlug);
    }
}
