<?php

namespace App\Http\Controllers;

use DB;
use App\Setting;
use App\Survey;
use App\Question;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
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
        session()->flash('success', 'Survey listing successful.');
        return redirect('surveys/retrieve')->with(['result' => $result]);
    }

    public function create_update_survey(UpdateSurveyRequest $request) {
        $token = Setting::where('name', 'Survey Monkey Token')->first()->value;

        if ($token == '')
            return redirect('surveys/retrieve')->with('error', 'Please set up your Survey Monkey Api Key and Token in the settings page.');

        $content = $this->get_survey_detail_request($token, request('survey_id'), request('name'));
        $request->save($content);
        session()->flash('success', 'Survey successfully updated.');
        return redirect('surveys');
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
        $client = new Client();
        $response = $client->get('https://api.surveymonkey.net/v3/surveys', [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer '.$token
            ]
        ]);
        return $response->getBody()->getContents();
    }

    protected function get_survey_detail_request($token, $id, $name) {
        $client = new Client();
        $response = $client->get('https://api.surveymonkey.net/v3/surveys/'.$id.'/details', [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer '.$token
            ]
        ]);
        return $response->getBody()->getContents();
    }












}
