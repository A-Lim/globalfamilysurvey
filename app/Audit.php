<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Audit extends Model {
    protected $fillable = [
        'user_id', 
        'module', 
        'action', 
        'request_header', 
        'request_ip', 
        'input', 
        'old', 
        'new'
    ];

    const CACHE_KEY = 'audit';

    public function user() {
        return $this->belongsTo(User::class);
    }
}
