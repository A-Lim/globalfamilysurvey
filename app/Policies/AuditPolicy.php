<?php

namespace App\Policies;

use App\User;
use App\Audit;
use Illuminate\Auth\Access\HandlesAuthorization;

class AuditPolicy {
    use HandlesAuthorization;

    public function view(User $user) {
        return $user->can('view_audits');
    }

    public function before($user, $ability) {
        if ($user->hasRole('super_admin')) {
            return true;
        }
    }
}
