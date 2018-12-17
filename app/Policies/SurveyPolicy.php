<?php

namespace App\Policies;

use App\User;
use App\Survey;
use Illuminate\Auth\Access\HandlesAuthorization;

class SurveyPolicy
{
    use HandlesAuthorization;

    public function view(User $user) {
        return $user->can('view_surveys');
    }

    public function delete(User $user) {
        return $user->can('delete_survey');
    }

    public function before($user, $ability) {
        if ($user->hasRole('super_admin')) {
            return true;
        }
    }
}
