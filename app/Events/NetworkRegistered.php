<?php
namespace App\Events;

use App\User;

class NetworkRegistered {
    public $user;
    public $password;

    public function __construct(User $user, $password) {
        $this->user = $user;
        $this->password = $password;
    }
}
