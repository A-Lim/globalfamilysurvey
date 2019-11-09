<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model {
    protected $fillable = ['name', 'sequence'];
    public $timestamps = false;

    const CACHE_KEY = 'category';

    public function getQuestionIdsAttribute($value) {
        return unserialize($value);
    }

    public function questions() {
        return $this->belongsToMany(Question::class);
    }
}
