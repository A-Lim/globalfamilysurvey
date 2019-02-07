<?php

namespace App\Policies;

use App\User;
use App\Church;
use Illuminate\Auth\Access\HandlesAuthorization;

class ChurchPolicy {
    use HandlesAuthorization;

    public function view(User $user) {
        return $user->can('view_churches');
    }

    public function create(User $user) {
        return $user->can('create_churches');
    }

    public function update(User $user) {
        return $user->can('update_churches');
    }

    public function delete(User $user) {
        return $user->can('delete_churches');
    }

    public function before($user, $ability) {
        if ($user->hasRole('super_admin')) {
            return true;
        }
    }
}
