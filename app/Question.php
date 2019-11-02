<?php

namespace App;

use App\Survey;
use App\Report;
use App\QuestionType;
use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Model;

class Question extends Model {
    protected $fillable = ['id', 'survey_id', 'page', 'type', 'subtype', 'title', 'href', 'sequence'];
    public $incrementing = false;
    public $timestamps = false;

    const CACHE_KEY = 'question';

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

    public static function formatFromJson($survey_id, $page, $json) {
        return [
            'survey_id' => $survey_id,
            'page' => $page,
            'type' => $json->family,
            'subtype' => $json->subtype,
            'href' => $json->href,
            'title' => $json->headings[0]->heading,
            'sequence' => $json->position
        ];
    }

    public function scopeFilter($query, $filters) {
        if (isset($filters['search'])) {
            $query->orWhere('title', 'like', '%'.$filters['search'].'%');
                    // ->orWhereHas('survey', function ($query) use ($filters) {
                    //     $query->whereType($filters['search']);
                    // });
        }
    }
}
