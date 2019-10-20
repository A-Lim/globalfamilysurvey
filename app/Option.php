<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    protected $fillabe = ['id', 'question_id', 'text', 'visible', 'position'];
    public $incrementing = false;
    public $timestamps = false;

    public function question() {
        return $this->belongsTo(Question::class);
    }

    // public static function saveFromJson($question_id, $choices_json = null) {
    //     // dd($choices_json);
    //     $data = [];
    //     if ($choices_json == null)
    //         return;
    //
    //     foreach ($choices_json as $choice) {
    //         if ($option = self::where('id', $choice->id)->first()) {
    //             $option->update([
    //                 'question_id' => $question_id,
    //                 'text' => $choice->text,
    //                 'visible' => $choice->visible,
    //                 'position' => $choice->position
    //             ]);
    //         } else {
    //             $data[] = [
    //                 'id' => $choice->id,
    //                 'question_id' => $question_id,
    //                 'text' => $choice->text,
    //                 'visible' => $choice->visible,
    //                 'position' => $choice->position
    //             ];
    //         }
    //     }
    //     Option::insert($data);
    // }
    //
    // public static function saveOtherFromJson($question_id, $other = null) {
    //     if ($option = self::where('id', $other->id)->first()) {
    //         $option->update([
    //             'question_id' => $question_id,
    //             'text' => $other->text,
    //             'visible' => $other->visible,
    //             'position' => $other->position
    //         ]);
    //     } else {
    //         $data[] = [
    //             'id' => $other->id,
    //             'question_id' => $question_id,
    //             'text' => $other->text,
    //             'visible' => $other->visible,
    //             'position' => $other->position
    //         ];
    //     }
    //     Option::insert($data);
    // }
}
