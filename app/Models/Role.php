<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
    ];

    /** Role has many permissions */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_permission', 'role_id', 'permission_id');
    }

    /** Role is assigned to many admin users */
    public function adminUsers()
    {
        return $this->hasMany(AdminUser::class, 'role_id');
    }

    /** Role is assigned to many sellers */
    public function sellers()
    {
        return $this->hasMany(Sellers::class, 'role_id');
    }
}
