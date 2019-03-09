<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Network extends Model
{
    protected $guarded = [];
    
    public function churches() {
        return $this->hasMany(Church::class, 'network_uuid', 'uuid');
    }
}
