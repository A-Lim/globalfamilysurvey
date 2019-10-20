<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model {
    protected $fillable = ['name', 'label'];

    public const SUPER_ADMIN = 1;
    public const ADMIN = 2;
    public const NETWORK_LEADER = 3;
    public const CHURCH_PASTOR = 4;

    public const CACHE_KEY = 'role';

    public const ALL = [
        self::SUPER_ADMIN,
        self::ADMIN,
        self::NETWORK_LEADER,
        self::CHURCH_PASTOR
    ];

    public function permissions() {
        return $this->belongsToMany(Permission::class);
    }

    // block delete all user created roles
    public function isDeletable() {
        return $this->id > 4;
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
