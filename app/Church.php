<?php

namespace App;

use Webpatser\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Church extends Model
{
    use SoftDeletes;

    protected $fillable = ['uuid', 'network_uuid', 'district', 'city', 'state', 'country_id'];

    public const CACHE_KEY = 'church';

    public function network() {
        return $this->belongsTo(Network::class, 'network_uuid');
    }
}
