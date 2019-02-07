<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $guarded = [];

    const TYPE_TEXT = 'text';
    const TYPE_TEXTAREA = 'textarea';

    const TYPES = [
        self::TYPE_TEXT,
        self::TYPE_TEXTAREA
    ];
}
