<?php
namespace App\Http\Controllers;

use App\RequestLog;
use App\Survey;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use App\Http\Requests\Surveys\RetrieveRequest;

use App\Repositories\RequestLogRepositoryInterface;
use App\Repositories\QuestionRepositoryInterface;
use App\Repositories\SurveyRepositoryInterface;
use App\Repositories\SettingsRepositoryInterface;

class SurveysController extends Controller {
    private $settingsRepository;
    private $surveyRepository;
    private $questionRepository;
    private $requestLogRepository;

    public function __construct(SettingsRepositoryInterface $settingsRepositoryInterface,
        SurveyRepositoryInterface $surveyRepositoryInterface,
        QuestionRepositoryInterface $questionRepositoryInterface,
        RequestLogRepositoryInterface $requestLogRepositoryInterface) {
        $this->middleware('auth');
        $this->settingsRepository = $settingsRepositoryInterface;
        $this->surveyRepository = $surveyRepositoryInterface;
        $this->questionRepository = $questionRepositoryInterface;
        $this->requestLogRepository = $requestLogRepositoryInterface;
    }

    public function index() {
        $this->authorize('view', Survey::class);
        $surveys = $this->surveyRepository->all();
        return view('surveys.index', compact('surveys'));
    }

    public function create() {
        $this->authorize('retrieve', Survey::class);
        return view('surveys.retrieve');
    }

    public function retrieve() {
        $this->authorize('retrieve', Survey::class);
        // check if token exists, if not redirect back
        $token = $this->get_token();

        $result = $this->get_surveys_request($token->value);
        if ($result['status']) {
            session()->flash('success', 'Survey listing successful.');
            return back()->with(['content' => $result['content']]);
        } else {
            session()->flash('error', $result['message']);
            return back();
        }
    }

    public function save(RetrieveRequest $request, Survey $survey = null) {
        $this->authorize('retrieve', Survey::class);
        // check if token exists, if not redirect back
        $token = $this->get_token();

        $survey_id = $survey->id ?? $request->survey_id;

        $result = $this->get_survey_detail_request($token->value, $survey_id);
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

    // public function refresh(Request $request, Survey $survey) {
    //     $this->authorize('retrieve', Survey::class);
    //     // check if token exists, if not redirect back
    //     $this->check_token();
    //
    //     $result = $this->get_survey_detail_request($token->value, $survey->id);
    //     if ($result['status']) {
    //         // save survey
    //         $this->surveyRepository->saveFromJson($request->all(), $result['content']);
    //         // save questions
    //         $this->questionRepository->saveFromJson($result['content']);
    //         session()->flash('success', 'Survey successfully updated.');
    //         return redirect('surveys');
    //     } else {
    //         return back()->with(['error' => $result['message']]);
    //     }
    // }

    public function show(Survey $survey) {
        $this->authorize('view', Survey::class);
        $questions = $this->questionRepository->findBySurveyId($survey->id, true);
        return view('surveys.show', [
            'survey' => $survey,
            'questions' => $questions
        ]);
    }

    public function destroy(Survey $survey) {
        $this->authorize('delete', Survey::class);
        $this->surveyRepository->delete($survey, true);
        session()->flash('success', 'Survey successfully deleted');
        return back();
    }

    // external api calls
    protected function get_surveys_request($token) {
        $client = new Client();
        try {
            $response = $client->get(Survey::API_URL, [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer '.$token
                ]
            ]);
            $contents = $response->getBody()->getContents();
            $contents_obj = json_decode($contents);

            // log result
            $this->requestLogRepository->create(RequestLog::STATUS_SUCCESS, $contents);
            return ['status' => true, 'content' => $contents_obj];
        } catch(ClientException $exception) {
            $body = $exception->getResponse()->getBody();
            $status_code = $exception->getResponse()->getStatusCode();
            $error = json_decode($body->getContents())->error;
            $content = json_decode($body);
            // log error result
            $this->requestLogRepository->create(RequestLog::STATUS_ERROR, $body->getContents());
            return ['status' => false, 'message' => 'Status Code ('.$status_code.'): '.$error->message, 'content' => $content];
        }
    }

    protected function get_survey_detail_request($token, $id) {
        $url = Survey::API_URL.$id.'/details';
        $client = new Client();
        try {
            $response = $client->get($url, [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer '.$token
                ]
            ]);
            $contents = $response->getBody()->getContents();
            $contents_obj = json_decode($contents);
            // log result
            $this->requestLogRepository->create(RequestLog::STATUS_SUCCESS, $contents);
            return ['status' => true, 'content' => $contents_obj];
        } catch(ClientException $exception) {
            $body = $exception->getResponse()->getBody();
            $status_code = $exception->getResponse()->getStatusCode();
            $error = json_decode($body->getContents())->error;
            $contents_obj = json_decode($body);

            // log error result
            $this->requestLogRepository->create(RequestLog::STATUS_ERROR, $body->getContents());
            return ['status' => false, 'message' => 'Status Code ('.$status_code.'): '.$error->message, 'content' => $contents_obj];
        }
    }

    private function get_token() {
        $token = $this->settingsRepository->get('token');

        if (!$token || $token->value == '')
            return redirect('surveys/retrieve')->with('error', 'Please set up your Survey Monkey Api Key and Token in the settings page.');
        else
            return $token;
    }
}
