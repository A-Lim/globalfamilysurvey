<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    protected $guarded = [];
    public $incrementing = false;
    public $timestamps = false;

    public static function saveFromJson($question_id, $choices_json = null) {
        $data = [];
        if ($choices_json == null)
            return;

        foreach ($choices_json as $choice) {
            if ($option = self::where('id', $choice->id)->first()) {
                $option->update([
                    'question_id' => $question_id,
                    'text' => $choice->text,
                    'visible' => $choice->visible,
                    'position' => $choice->position
                ]);
            } else {
                $data[] = [
                    'id' => $choice->id,
                    'question_id' => $question_id,
                    'text' => $choice->text,
                    'visible' => $choice->visible,
                    'position' => $choice->position
                ];
            }
        }
        Option::insert($data);
    }
}
