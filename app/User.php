<?php

namespace App;

use App\Traits\HasRoles;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable {
    use Notifiable, HasRoles, HasApiTokens, SoftDeletes;

    protected $fillable = [
        'name', 'email', 'church_id', 'level_id', 'password'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function church() {
        return $this->belongsTo(Church::class);
    }
}
