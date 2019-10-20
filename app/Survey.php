<?php

namespace App;

use App\Question;
use App\Survey;
use Illuminate\Database\Eloquent\Model;

class Survey extends Model {
    protected $fillable = ['id', 'type', 'title', 'url', 'preview_url', 'language', 'analyze_url'];
    public $incrementing = false;
    public $timestamps = false;

    const CACHE_KEY = 'survey';

    const TYPE_LEADER = 'leader';
    const TYPE_MEMBER = 'member';

    const TYPES = [
        self::TYPE_LEADER,
        self::TYPE_MEMBER
    ];

    public function questions() {
        return $this->hasMany(Question::class);
    }

    public function submissions() {
        return $this->hasMany(Survey::class);
    }

    public function webhook() {
        return $this->belongsTo(Webhook::class);
    }

    // retrieve raw JSON and save it into database
    // public static function saveFromJson($name, $type, $url, $json) {
    //     $submission = self::find($json->id);
    //     if (!$submission) {
    //         self::create([
    //             'id'    => $json->id,
    //             'title' => $name,
    //             'type'  => $type,
    //             'url' => $url,
    //             'preview_url' => $json->preview,
    //             'language' => $json->language,
    //             'analyze_url' => $json->analyze_url,
    //         ]);
    //     } else {
    //         $submission->update([
    //             'title' => $name,
    //             'type'  => $type,
    //             'url' => $url,
    //             'preview_url' => $json->preview,
    //             'language' => $json->language,
    //             'analyze_url' => $json->analyze_url,
    //         ]);
    //     };
    // }
}
