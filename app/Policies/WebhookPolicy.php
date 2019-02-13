<?php

namespace App\Policies;

use App\User;
use App\Webhook;
use Illuminate\Auth\Access\HandlesAuthorization;

class WebhookPolicy {
    use HandlesAuthorization;

    public function view(User $user) {
        return $user->can('view_webhooks');
    }

    public function create(User $user) {
        return $user->can('create_webhooks');
    }

    public function update(User $user, Webhook $webhook) {
        return $user->can('update_webhooks');
    }

    public function delete(User $user, Webhook $webhook) {
        return $user->can('delete_webhooks');
    }

    public function before($user, $ability) {
        if ($user->hasRole('super_admin')) {
            return true;
        }
    }
}
