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

    // public function category() {
    //     return $this->morphTo();
    // }

    public function scopeFilter($query, $filters) {
        if (isset($filters['search'])) {
            $query->orWhere('title', 'like', '%'.$filters['search'].'%');
                    // ->orWhereHas('survey', function ($query) use ($filters) {
                    //     $query->whereType($filters['search']);
                    // });
        }
  }

    public static function saveFromJson($json) {
        $questions_json = $json->form_response->definition->fields;
        $sequence = 1;
        $questions_array =  array_map(function($obj) use (&$sequence, $json) {
            $sequence++;
            return [
                'id' => $obj->id,
                'survey_id' => $json->form_response->definition->id,
                'title' => $obj->title,
                'type'  => $obj->type,
                'type_label' => ucfirst(str_replace('_', ' ', $obj->type)),
                'choices'   => $obj->type == 'multiple_choice' ? serialize((array) $obj->choices) : null,
                'sequence' => $sequence
            ];

        }, $questions_json);

        self::insertOrUpdate($questions_array);
    }

    protected static function insertOrUpdate(array $rows) {
        $table = \DB::getTablePrefix().with(new self)->getTable();
        $first = reset($rows);

        $columns = implode( ',', array_map( function( $value ) { return "$value"; } , array_keys($first) ));

        $values = implode( ',', array_map( function( $row ) {
                        return '('.implode( ',', array_map( function( $value ) { return '"'.str_replace('"', '""', $value).'"'; } , $row ) ).')';
                    } , $rows ));

        $updates = implode( ',', array_map( function( $value ) { return "$value = VALUES($value)"; } , array_keys($first) ) );

        $sql = "INSERT INTO {$table}({$columns}) VALUES {$values} ON DUPLICATE KEY UPDATE {$updates}";

        return \DB::statement( $sql );
    }
}
