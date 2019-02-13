<?php
namespace App\Http\Controllers;

use App\Setting;
use App\Church;
use App\Answer;
use App\Survey;
use App\Submission;
use App\Webhook;

use Illuminate\Http\Request;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class ApiController extends Controller {
    // if survey does not exists, return 404 not found
    // if exists return 200
    public function verify_subscription_url(Request $request, Survey $survey) {
        return response(null, 200);
    }

    public function subscription(Request $request, Survey $survey) {
        $result = json_decode($request->getContent());
        $respondent_id = $result->resources->respondent_id;
        $this->retrieve_response($survey, $respondent_id);
    }

    protected function retrieve_response(Survey $survey, $respondent_id) {
        $token = Setting::where('name', 'Survey Monkey Token')->first()->value;
        if ($token == '') {
            // do logging here
            return;
        }

        $client = new Client();
        try {
            $get_survey_response_url = Webhook::URL_SURVEY_MONKEY.'/surveys/'.$survey->id.'/responses/'.$respondent_id.'/details';
            $response = $client->get($get_survey_response_url, [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer '.$token
                ]
            ]);

            $contents = $response->getBody()->getContents();
            $result = json_decode($contents);

            $validation = $this->validation_json($result);
            if ($validation['status'] == 'error') {
                // do logging here
                return;
            }

            $this->parse_and_save($survey, $result);
        } catch (ClientException $exception) {
            $error = json_decode($exception->getResponse()->getBody()->getContents())->error;
            $contents = json_decode($exception->getResponse()->getBody());
            // do logging here
        }
    }

    // do logging
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
                            'type' => $type,
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
