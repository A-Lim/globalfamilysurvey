<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model {
    protected $guarded = [];

    public function permissions() {
        return $this->belongsToMany(Permission::class);
    }

    // give permission to the role to do something
    public function givePermissionTo(Permission $permission) {
        return $this->permissions()->save($permission);
    }

    // give multiple permissions one go
    public function givePermissions($ids) {
        $this->permissions()->sync($ids);
    }
}
