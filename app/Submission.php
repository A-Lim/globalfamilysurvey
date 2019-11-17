<?php

namespace App;
use App\Church;
use App\Survey;
use App\Answer;

use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    protected $fillable = ['survey_id', 'church_id', 'total_time', 'href', 'analyze_url', 'ip_address', 'response_status', 'language', 'created_at', 'updated_at'];
    const API_URL = 'https://api.surveymonkey.net/v3/surveys/';

    const REQ_TYPE_EVERYTHING = 'everything';
    const REQ_TYPE_TODAY = 'today';

    const REQ_TYPES = [
        self::REQ_TYPE_EVERYTHING,
        self::REQ_TYPE_TODAY,
    ];

    const PER_PAGE = 100;
    const STATUS_COMPLETED = 'completed';

    public function survey() {
        return $this->belongsTo(Survey::class);
    }

    public function church() {
        return $this->belongsTo(Church::class);
    }

    public function answers() {
        return $this->hasMany(Answer::class);
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
                $church = auth()->user()->church;
                if ($church == null || $church->network_uuid == null)
                    return dd("No church or network");

                // only filter by church
                if ($filter != null && $filter == 'church') {
                    $query->whereHas('church', function ($query) use ($church) {
                        $query->where('id', $church->id);
                    });
                } else {
                    // if no filter
                    // default filter by network_id
                    $query->whereHas('church', function ($query) use ($church) {
                        $query->where('network_uuid', $church->network_uuid);
                    });
                }
                break;

            case $roles->contains('name', 'church_pastor'):
                $church = auth()->user()->church;
                if ($church == null)
                    return dd("No church");

                $query->whereHas('church', function ($query) use ($church) {
                    $query->where('id', $church->id);
                });
                break;
        }
    }
}
