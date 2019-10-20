<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    public const CACHE_KEY = 'permission';

    public function roles() {
        return $this->belongsToMany(Role::class);
    }
}
