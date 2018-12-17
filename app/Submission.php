<?php

namespace App;
use App\Church;
use App\Survey;
use App\Answer;

use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    protected $guarded = [];

    public function survey() {
        return $this->belongsTo(Survey::class);
    }

    public function church() {
        return $this->belongsTo(Church::class);
    }

    public function answers() {
        return $this->hasMany(Answer::class);
    }

    // retrieve raw JSON and save it into database
    public static function saveFromJson($json) {
        $questions = $json->form_response->definition->fields;
        $answers = $json->form_response->answers;

        // question id that contains church code
        $question_id = '';
        // hidden field church code
        $church_code = $json->form_response->hidden->church;
        // check if church code is correct and already in database
        // if not do not save to database
        $church = Church::where('uuid', $church_code)->firstOrFail();

        if ($church != null) {
            return self::create([
                'survey_id' => $json->form_response->form_id,
                'church_id' => $church->id
            ]);
        }
        return null;
    }
}
