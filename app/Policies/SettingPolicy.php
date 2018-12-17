<?php

namespace App\Policies;

use App\User;
use App\Setting;
use Illuminate\Auth\Access\HandlesAuthorization;

class SettingPolicy
{
    use HandlesAuthorization;

    public function view(User $user){
        return $user->can('view_settings');
    }

    public function update(User $user){
        return $user->can('update_settings');
    }

    public function before($user, $ability) {
        if ($user->hasRole('super_admin')) {
            return true;
        }
    }

}
