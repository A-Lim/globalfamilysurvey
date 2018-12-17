<?php

namespace App\Traits;

use App\Role;

trait HasRoles {
    public function roles() {
        return $this->belongsToMany(Role::class);
    }

    public function assignRole($role) {
        return $this->roles()->save(
            Role::whereName($role)->firstOrFail()
        );
    }

    public function assignRoleById($id) {
        return $this->roles()->save(
            Role::findOrFail($id)
        );
    }

    public function hasRole($role) {
        // $user->hasRole('manager');
        if (is_string($role)) {
            return $this->roles->contains('name', $role);
        }

        return !! $role->intersect($this->roles)->count();
    }
}
