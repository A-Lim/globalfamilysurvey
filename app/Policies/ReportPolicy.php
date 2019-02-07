<?php

namespace App\Policies;

use App\User;
use App\Report;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReportPolicy
{
    use HandlesAuthorization;

    public function view(User $user){
        return $user->can('view_reports');
    }

    public function create(User $user){
        return $user->can('create_reports');
    }

    public function update(User $user){
        return $user->can('update_reports');
    }

    public function delete(User $user){
        return $user->can('delete_reports');
    }

    public function before($user, $ability) {
        if ($user->hasRole('super_admin')) {
            return true;
        }
    }

}
