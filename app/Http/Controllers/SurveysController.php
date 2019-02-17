<?php

namespace App\Http\Controllers;

use DB;
use App\Setting;
use App\Survey;
use App\Question;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use App\Http\Requests\UpdateSurveyRequest;

class SurveysController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {
        $this->authorize('view', Survey::class);
        $surveys = Survey::withCount('questions')->paginate(10);
        return view('surveys.index', compact('surveys'));
    }

    public function retrieve() {
        return view('surveys.retrieve');
    }

    public function get_survey_list() {
        $token = Setting::where('name', 'Survey Monkey Token')->first()->value;

        if ($token == '')
            return redirect('surveys/retrieve')->with('error', 'Please set up your Survey Monkey Api Key and Token in the settings page.');

        $result = $this->get_surveys_request($token);
        if ($result['status']) {
            session()->flash('success', 'Survey listing successful.');
            return redirect('surveys/retrieve')->with(['content' => $result['content']]);
        } else {
            return back()->with(['error' => $result['message']]);
        }
    }

    public function create_update_survey(UpdateSurveyRequest $request) {
        $token = Setting::where('name', 'Survey Monkey Token')->first()->value;

        if ($token == '')
            return redirect('surveys/retrieve')->with('error', 'Please set up your Survey Monkey Api Key and Token in the settings page.');

        $result = $this->get_survey_detail_request($token, request('survey_id'), request('name'));

        if ($result['status']) {
            $request->save($result['content']);
            session()->flash('success', 'Survey successfully updated.');
            return redirect('surveys');
        } else {
            return back()->with(['error' => $result['message']]);
        }
    }

    public function show(Survey $survey) {
        $this->authorize('view', Survey::class);
        return view('surveys.show', [
            'survey' => $survey,
            'questions' => Question::where(['survey_id' => $survey->id])
                            ->withCount('answers')
                            ->orderBy('page', 'asc')
                            ->orderBy('sequence', 'asc')
                            ->paginate(10)
        ]);
    }

    public function destroy(Survey $survey) {
        $this->authorize('delete', Survey::class);
        $this->deleteAllLinked($survey);
        session()->flash('success', 'Survey successfully deleted');
        return back();
    }

    protected function deleteAllLinked(Survey $survey) {
        DB::transaction(function() use ($survey) {
            $ids = DB::table('questions')->where(['survey_id' => $survey->id])->pluck('id')->toArray();
            DB::table('surveys')->where(['id' => $survey->id])->delete();
            DB::table('questions')->where(['survey_id' => $survey->id])->delete();
            DB::table('answers')->whereIn('question_id', $ids)->delete();
        });
    }

    protected function get_surveys_request($token) {
        $url = 'https://api.surveymonkey.net/v3/surveys';
        $client = new Client();
        try {
            $response = $client->get($url, [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer '.$token
                ]
            ]);
            $content = json_decode($response->getBody()->getContents());
            return ['status' => true, 'content' => $content];
        } catch(ClientException $exception) {
            $error = json_decode($exception->getResponse()->getBody()->getContents())->error;
            $contents = json_decode($exception->getResponse()->getBody());
            return ['status' => false, 'message' => 'Status Code ('.$error->http_status_code.'): '.$error->message, 'content' => $contents];
        }
    }

    protected function get_survey_detail_request($token, $id, $name) {
        $url = 'https://api.surveymonkey.net/v3/surveys/'.$id.'/details';
        $client = new Client();
        try {
            $response = $client->get($url, [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer '.$token
                ]
            ]);
            $content = json_decode($response->getBody()->getContents());
            return ['status' => true, 'content' => $content];
        } catch(ClientException $exception) {
            $status_code = $exception->getResponse()->getStatusCode();
            $error = json_decode($exception->getResponse()->getBody()->getContents())->error;
            $contents = json_decode($exception->getResponse()->getBody());
            return ['status' => false, 'message' => 'Status Code ('.$status_code.'): '.$error->message, 'content' => $contents];
        }
    }
}
