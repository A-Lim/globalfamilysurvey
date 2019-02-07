<?php

namespace App\Policies;

use App\User;
use App\Question;
use Illuminate\Auth\Access\HandlesAuthorization;

class QuestionPolicy
{
    use HandlesAuthorization;

    public function view(User $user) {
        return $user->can('view_questions');
    }

    public function delete(User $user) {
        return $user->can('delete_questions');
    }

    public function before($user, $ability) {
        if ($user->hasRole('super_admin')) {
            return true;
        }
    }
}
