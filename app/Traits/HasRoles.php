<?php

namespace App\Traits;

use App\Models\Role;
use App\Models\Permission;


trait HasRoles
{
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function permissions()
    {
        return $this->role ? $this->role->permissions : collect();
    }

    public function hasRole(string $slug): bool
    {
        return optional($this->role)->slug === $slug;
    }

    public function hasPermission(string $slug): bool
    {
        if ($this->role && $this->role->slug === 'super-admin') {
            return true;
        }

        return $this->permissions()->contains('slug', $slug);
    }

    public function hasAnyPermission(array $slugs): bool
    {
        // Super admin can access everything
        if ($this->role && $this->role->slug === 'super-admin') {
            return true;
        }

        return $this->permissions()->whereIn('slug', $slugs)->isNotEmpty();
    }
}
