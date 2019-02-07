<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function view(User $user) {
        return $user->can('view_users');
    }

    public function create(User $user) {
        return $user->can('create_users');
    }

    public function update(User $user, User $userEdit)  {
        // a user should be able to edit his own profile
        if ($user->id === $userEdit->id) {
            return true;
        }
        return $user->can('update_users');
    }

    public function delete(User $user, User $userDelete) {
        return $user->can('delete_users');
    }

    public function before($user, $ability) {
        if ($user->hasRole('super_admin')) {
            return true;
        }
    }
}
