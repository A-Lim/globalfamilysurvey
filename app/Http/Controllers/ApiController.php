<?php

namespace App\Http\Controllers;

use DB;
use App\Question;
use App\Answer;
use App\Survey;
use App\Submission;
use Illuminate\Http\Request;

class ApiController extends Controller {

    public function store(Request $request) {
        $json = $request->getContent();
        $data = json_decode($json);

        DB::transaction(function() {
            Survey::saveFromJson($data);
            $submission = Submission::saveFromJson($data);
            Question::saveFromJson($data);
            Answer::saveFromJson($data, $submission);
        });

        return response()->json(['status' => 'success'], 200);
    }

    public function leaders(Request $request) {
        $json = $request->getContent();
        $contents = json_decode($json);

        DB::transaction(function() use ($contents){
            Survey::saveFromJson($contents, 'leader');
            $submission = Submission::saveFromJson($contents);
            Question::saveFromJson($contents);
            Answer::saveFromJson($contents, $submission);
        });

        return response()->json(['status' => 'success'], 200);
    }

    public function members(Request $request) {
        $json = $request->getContent();
        $contents = json_decode($json);

        DB::transaction(function() use ($contents){
            Survey::saveFromJson($contents, 'member');
            $submission = Submission::saveFromJson($contents);
            Question::saveFromJson($contents);
            Answer::saveFromJson($contents, $submission);
        });

        return response()->json(['status' => 'success'], 200);
    }

    public function registrations(Request $request) {
        return response()->json(['status' => 'success'], 200);
    }

    public function receiver(Request $request) {
        return response()->json(['status' => 'success'], 200);
    }
}
