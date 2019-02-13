<?php

namespace App\Http\Controllers;

// use DB;
// use App\Question;
use App\Church;
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

        $validation = $this->validation_json($result);
        if ($validation['status'] == 'error') {
            return response()->json(['status' => 'error', 'message' => $validation['message']], 422)
                    ->withHeaders(['Content-Type' => 'application/json']);
            exit();
        }

        $this->parse_and_save($survey, $result);

        return response()->json(['status' => 'success'], 200)
                ->withHeaders(['Content-Type' => 'application/json']);
    }

    protected function validation_json($result) {
        $submission = Submission::find($result->id);
        if ($submission)
            return ['status' => 'error', 'message' => 'Submission already exists.'];

        $church = Church::where('uuid', $result->custom_variables->church)->first();
        if (!$church)
            return ['status' => 'error', 'message' => 'Invalid church uuid.'];

        if (!isset($result->pages))
            return ['status' => 'error', 'message' => 'Invalid json format.'];

        return true;
    }

    protected function parse_and_save(Survey $survey, $result) {
        $submission = Submission::create([
            'id' => $result->id,
            'survey_id' => $survey->id,
            'church_id' => $result->custom_variables->church,
            'href' => $result->href,
            'total_time' => $result->total_time,
            'ip_address' => $result->ip_address,
            'analyze_url' => $result->analyze_url,
            'response_status' => $result->response_status,
            'language' => $result->metadata->respondent->language->value
        ]);

        foreach ($result->pages as $pages) {
            foreach($pages->questions as $question) {
                foreach ($question->answers as $answer) {
                    if (isset($answer->choice_id)) {
                        $data[] = [
                            'submission_id' => $submission->id,
                            'question_id' => $question->id,
                            'type' => 'choice',
                            'choice_id' => @$answer->choice_id,
                            'row_id' => @$answer->row_id,
                            'text' => @$answer->text
                        ];
                    } else {
                        $type = isset($answer->other_id) ? 'other' : 'text';
                        $data[] = [
                            'submission_id' => $submission->id,
                            'question_id' => $question->id,
                            'type' => 'choice',
                            'choice_id' => @$answer->other_id,
                            'row_id' => @$answer->row_id,
                            'text' => @$answer->text
                        ];
                    }
                }
            }
        }
        Answer::insert($data);
    }
}
