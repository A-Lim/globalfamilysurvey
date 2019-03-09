<?php

namespace App;

use Webpatser\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;

class Church extends Model
{
    protected $guarded = [];

    public function network() {
        return $this->belongsTo(Network::class, 'network_uuid');
    }
}
