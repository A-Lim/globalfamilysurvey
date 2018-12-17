<?php

namespace App;

use App\Question;
use App\Survey;
use Illuminate\Database\Eloquent\Model;

class Survey extends Model {
    protected $guarded = [];
    public $incrementing = false;
    public $timestamps = false;

    public function questions() {
        return $this->hasMany(Question::class);
    }

    public function submissions() {
        return $this->hasMany(Survey::class);
    }

    // retrieve raw JSON and save it into database
    public static function saveFromJson($json, $type) {
        self::firstOrCreate([
            'id'    => $json->form_response->definition->id,
            'title' => $json->form_response->definition->title,
            'type'  => $type
        ]);
    }
}
