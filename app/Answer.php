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
    public function scopePermitted($query, $filter = null) {
        $church = auth()->user()->church;
        $roles = auth()->user()->roles;

        switch ($roles) {
            case $roles->contains('name', 'super_admin'):
                // no filter
                break;

            case $roles->contains('name', 'admin'):
                // no filter
                break;

            case $roles->contains('name', 'network_leader'):
                // $church = auth()->user()->church;
                if ($church == null || $church->network_uuid == null)
                    return dd("No church or network");

                // only filter by church
                if ($filter != null && $filter == 'church') {
                    $query->whereHas('submission', function ($query) use ($church) {
                        $query->whereHas('church', function ($query) use ($church) {
                            $query->where('id', $church->id);
                        });
                    });
                } else {
                    // if no filter
                    // default filter by network_id
                    $query->whereHas('submission', function ($query) use ($church) {
                        $query->whereHas('church', function ($query) use ($church) {
                            $query->where('network_uuid', $church->network_uuid);
                        });
                    });
                }
                break;

            case $roles->contains('name', 'church_pastor'):
                $church = auth()->user()->church;
                if ($church == null)
                    return dd("No church");

                $query->whereHas('submission', function ($query) use ($church) {
                    $query->whereHas('church', function ($query) use ($church) {
                        $query->where('id', $church->id);
                    });
                });
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
}
