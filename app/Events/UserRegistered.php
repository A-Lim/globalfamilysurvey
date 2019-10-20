<?php
namespace App\Events;

use App\User;

class UserRegistered {
    public $user;
    public $password;

    public function __construct(User $user, $password) {
        $this->user = $user;
        $this->password = $password;
    }
}
