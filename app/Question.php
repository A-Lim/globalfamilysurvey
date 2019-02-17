<?php

namespace App;

use App\Survey;
use App\Report;
use App\QuestionType;
use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Model;

class Question extends Model {
    protected $guarded = [];
    public $incrementing = false;
    public $timestamps = false;

    public function leader_report() {
        return $this->belongsTo(Report::class);
    }

    public function member_report() {
        return $this->belongsTo(Report::class);
    }

    public function survey() {
        return $this->belongsTo(Survey::class);
    }

    public function answers() {
        return $this->hasMany(Answer::class);
    }

    public function categories() {
        return $this->belongsToMany(Category::class);
    }

    public function scopeFilter($query, $filters) {
        if (isset($filters['search'])) {
            $query->orWhere('title', 'like', '%'.$filters['search'].'%');
                    // ->orWhereHas('survey', function ($query) use ($filters) {
                    //     $query->whereType($filters['search']);
                    // });
        }
  }

    public static function saveFromJson($json) {
        $survey_id = $json->id;
        $data = [];
        $page_num = 0;
        foreach ($json->pages as $page) {
            $page_num++;
            foreach ($page->questions as $question_obj) {
                if ($question = self::where('id', $question_obj->id)->first()) {
                    $question->update([
                        'survey_id' => $survey_id,
                        'page' => $page_num,
                        'type' => $question_obj->family,
                        'subtype' => $question_obj->subtype,
                        'href' => $question_obj->href,
                        'title' => $question_obj->headings[0]->heading,
                        'sequence' => $question_obj->position
                    ]);
                } else {
                    $data[] = [
                        'id' => $question_obj->id,
                        'survey_id' => $survey_id,
                        'page' => $page_num,
                        'type' => $question_obj->family,
                        'subtype' => $question_obj->subtype,
                        'href' => $question_obj->href,
                        'title' => $question_obj->headings[0]->heading,
                        'sequence' => $question_obj->position
                    ];
                }
                Option::saveFromJson($question_obj->id, @$question_obj->answers->choices);
            }
        }
        Question::insert($data);
    }
}
