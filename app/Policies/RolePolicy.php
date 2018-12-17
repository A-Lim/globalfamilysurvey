<?php

namespace App\Policies;

use App\User;
use App\Role;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicy
{
    use HandlesAuthorization;

    public function view(User $user){
        return $user->can('view_roles');
    }

    public function create(User $user){
        return $user->can('create_role');
    }

    public function update(User $user){
        return $user->can('update_role');
    }

    public function delete(User $user){
        return $user->can('delete_role');
    }

    public function before($user, $ability) {
        if ($user->hasRole('super_admin')) {
            return true;
        }
    }

}
