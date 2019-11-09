<?php

namespace App;

use App\Question;
use Illuminate\Database\Eloquent\Model;

class Report extends Model {
    protected $fillable = ['name', 'leader_question_id', 'member_question_id'];

    public const CACHE_KEY = 'report';

    public function leader_question() {
        return $this->hasOne(Question::class, 'id', 'leader_question_id');
    }

    public function member_question() {
        return $this->hasOne(Question::class, 'id', 'member_question_id');
    }

    // public function getLeaderPositiveValuesAttribute($value) {
    //     return unserialize($value);
    // }
    //
    // public function getLeaderNegativeValuesAttribute($value) {
    //     return unserialize($value);
    // }
    //
    // public function getMemberPositiveValuesAttribute($value) {
    //     return unserialize($value);
    // }
    //
    // public function getMemberNegativeValuesAttribute($value) {
    //     return unserialize($value);
    // }
}
