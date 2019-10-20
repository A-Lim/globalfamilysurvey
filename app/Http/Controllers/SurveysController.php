<?php

namespace App\Http\Controllers;

use DB;
// use App\Setting;
use App\Survey;
use App\Question;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use App\Http\Requests\UpdateSurveyRequest;

use App\Repositories\QuestionRepositoryInterface;
use App\Repositories\SurveyRepositoryInterface;
use App\Repositories\SettingsRepositoryInterface;

class SurveysController extends Controller {
    private $settingsRepository;
    private $surveyRepository;
    private $questionRepository;

    public function __construct(SettingsRepositoryInterface $settingsRepositoryInterface,
        SurveyRepositoryInterface $surveyRepositoryInterface,
        QuestionRepositoryInterface $questionRepositoryInterface) {
        $this->middleware('auth');
        $this->settingsRepository = $settingsRepositoryInterface;
        $this->surveyRepository = $surveyRepositoryInterface;
        $this->questionRepository = $questionRepositoryInterface;
    }

    public function index() {
        $this->authorize('view', Survey::class);
        $surveys = $this->surveyRepository->all();
        return view('surveys.index', compact('surveys'));
    }

    public function create() {
        return view('surveys.retrieve');
    }

    public function retrieve() {
        $token = $this->settingsRepository->get('token');

        if (!$token || $token->value == '')
            return redirect('surveys/retrieve')->with('error', 'Please set up your Survey Monkey Api Key and Token in the settings page.');

        $result = $this->get_surveys_request($token->value);
        if ($result['status']) {
            session()->flash('success', 'Survey listing successful.');
            return back()->with(['content' => $result['content']]);
        } else {
            session()->flash('error', $result['message']);
            return back();
        }
    }

    public function save(UpdateSurveyRequest $request) {
        $token = $this->settingsRepository->get('token');

        if (!$token || $token->value == '')
            return redirect('surveys/retrieve')->with('error', 'Please set up your Survey Monkey Api Key and Token in the settings page.');

        $result = $this->get_survey_detail_request($token->value, $request->survey_id, $request->name);
        if ($result['status']) {
            // save survey
            $this->surveyRepository->saveFromJson($request->all(), $result['content']);
            // save questions
            $this->questionRepository->saveFromJson($result['content']);
            session()->flash('success', 'Survey successfully updated.');
            return redirect('surveys');
        } else {
            return back()->with(['error' => $result['message']]);
        }
    }

    public function show(Survey $survey) {
        $questions = $this->questionRepository->findBySurveyId($survey->id, true);
        return view('surveys.show', [
            'survey' => $survey,
            'questions' => $questions
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
            DB::table('questions')->where('survey_id', $survey->id)->delete();
            DB::table('answers')->whereIn('question_id', $ids)->delete();
            DB::table('options')->whereIn('question_id', $ids)->delete();
            DB::table('submissions')->where('survey_id', $survey->id)->delete();
        });
    }

    // external api calls

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
