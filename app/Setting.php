<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['value', 'created_at', 'updated_at'];
    
    const TYPE_TEXT = 'text';
    const TYPE_TEXTAREA = 'textarea';
    const TYPE_CHECKBOX = 'checkbox';
    const TYPE_SELECT = 'select';

    const CACHE_KEY = 'settings';

    const TYPES = [
        self::TYPE_TEXT,
        self::TYPE_TEXTAREA,
        self::TYPE_CHECKBOX,
        self::TYPE_SELECT
    ];
}
