<?php

namespace App;

use DB;
use App\Result;
use App\Submission;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model {
    protected $guarded = [];
    public $timestamps = false;

    public function question() {
        return $this->belongsTo(Question::class);
    }

    public function submission() {
        return $this->belongsTo(Submission::class);
    }

    public function getValueAttribute($value) {
        return unserialize($value);
    }

    // filter answers based on the user's level
    // only the level of all can see all the answers
    // the rest will be filtered based on their country or church
    public function scopePermitted($query) {
        $level = auth()->user()->level->name;
        $church = auth()->user()->church;

        switch ($level) {
            case 'all':
            break;

            case 'national':
            $query->whereHas('submission', function ($query) use ($church) {
                $query->whereHas('church', function ($query) use ($church) {
                    $query->where('country', $church->country);
                });
            });
            break;

            case 'denominational':
            $query->whereHas('submission', function ($query) use ($church) {
                $query->whereHas('church', function ($query) use ($church) {
                    $query->where([
                        'country' => $church->country,
                        'denomination' => $church->denomination
                    ]);
                });
            });
            break;

            case 'church pastor':
            $query->whereHas('submission', function ($query) use ($church) {
                $query->whereHas('church', function ($query) use ($church) {
                    $query->where([
                        'id' => $church->id
                    ]);
                });
            });
            break;

            default:
            break;
        }
    }

    public static function insertOrUpdate(array $rows){
        $table = \DB::getTablePrefix().with(new self)->getTable();
        $first = reset($rows);

        $columns = implode(',', array_map(function($value) {
            return "$value";
        } , array_keys($first)));

        $values = implode(',', array_map(function($row) {
                return '('.implode( ',', array_map( function( $value ) { return '"'.str_replace('"', '""', $value).'"'; } , $row )).')';
            } , $rows )
        );

        $updates = implode(',', array_map(function($value) {
            return "$value = VALUES($value)";
        } , array_keys($first)));

        $sql = "INSERT INTO {$table}({$columns}) VALUES {$values} ON DUPLICATE KEY UPDATE {$updates}";

        return \DB::statement( $sql );
    }



// public static function saveFromJson($json, \App\Submission $submission) {
//     foreach ($json->form_response->answers as $json_answer) {
//         $type = $json_answer->type;
//         $values = [];
//
//         if ($json_answer->type == 'choices') {
//             foreach ($json_answer->{$type}->labels as $label) {
//                 array_push($values, $label);
//             }
//         } else if ($json_answer->type == 'choice') {
//             array_push($values, $json_answer->{$type}->label);
//         } else {
//             array_push($values, $json_answer->{$type});
//         }
//
//         self::create([
//             'question_id'   => $json_answer->field->id,
//             'type'          => $json_answer->type,
//             'submission_id' => $submission->id,
//             'value'         => serialize($values)
//         ]);
//     }
// }
}
