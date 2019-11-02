<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    protected $fillable = ['id', 'question_id', 'text', 'visible', 'position'];
    public $incrementing = false;
    public $timestamps = false;

    public function question() {
        return $this->belongsTo(Question::class);
    }

    public static function formatFromJson($question_id, $json) {
        return [
            'question_id' => $question_id,
            'text' => $json->text,
            'visible' => $json->visible,
            'position' => $json->position
        ];
    }
}
