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
        $church_code = $json->form_response->hidden->ch;
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
