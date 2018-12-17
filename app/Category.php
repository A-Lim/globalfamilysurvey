<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model {
    protected $guarded = [];
    public $timestamps = false;

    public function getQuestionIdsAttribute($value) {
        return unserialize($value);
    }

    public function questions() {
        return $this->belongsToMany(Question::class);
    }
}
