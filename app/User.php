<?php

namespace App;

use App\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable {
    use Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'church_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function church() {
        return $this->belongsTo(Church::class);
    }
    
    // public function level() {
    //     return $this->belongsTo(Level::class);
    // }

    // filter the users to the ones that are permitted by the current user to see and edit
    // public function scopePermitted($query) {
    //     $user = auth()->user();
    //     switch ($user->roles()->first()->name) {
    //         case 'normal':
    //             $query->whereHas('roles', function ($query) {
    //                 $query->where('name', 'normal');
    //             });
    //             break;
    //
    //         case 'registrar':
    //             $query->whereHas('roles', function ($query) {
    //                 $query->where('name', 'normal');
    //             });
    //             break;
    //
    //         default:
    //             break;
    //     }
    // }
}
