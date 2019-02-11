<?php

namespace App\Http\Controllers;

// use DB;
// use App\Question;
use App\Answer;
use App\Survey;
use App\Submission;
use Illuminate\Http\Request;

class ApiController extends Controller {

    // if survey does not exists, return 404 not found
    // if exists return 200
    public function verify_subscription_url(Request $request, Survey $survey) {
        return response(null, 200);
    }

    public function subscription(Request $request, Survey $survey) {
        $result = json_decode($request->getContent());

        $data = [];
        if (isset($result->pages))
            $this->parse_and_save($result);

        return response()->json(['status' => 'success'], 200)
                ->withHeaders(['Content-Type' => 'application/json']);
    }

    protected function parse_and_save($result) {
        // prevent same submission twice
        $submission = Submission::find($result->id);
        if ($submission)
            return response()->json(['status' => 'error', 'message' => 'Submission already exists.'], 200)
                ->withHeaders(['Content-Type' => 'application/json']);

        $submission = Submission::create([
            'id' => $result->id,
            'survey_id' => $survey->id,
            'church_id' => 1,
            'href' => $result->href,
            'total_time' => $result->total_time,
            'ip_address' => $result->ip_address,
            'analyze_url' => $result->analyze_url,
            'response_status' => $result->response_status
        ]);

        foreach ($result->pages as $pages) {
            foreach($pages->questions as $question) {
                foreach ($question->answers as $answer) {
                    $type = isset($answer->text) ? 'text' : 'choice';
                    $data[] = [
                        'submission_id' => $submission->id,
                        'question_id' => $question->id,
                        'type' => $type,
                        'choice_id' => @$answer->choice_id,
                        'row_id' => @$answer->row_id,
                        'text' => @$answer->text
                    ];
                }
            }
        }
        Answer::insert($data);
    }
}
