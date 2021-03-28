<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Carbon\Carbon;
use App\Submission;
use App\Jobs\RequestSubmissions;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use App\Http\Requests\Submission\PullSubmissionRequest;

use App\Repositories\SurveyRepositoryInterface;
use App\Repositories\SubmissionRepositoryInterface;
use App\Repositories\ChurchRepositoryInterface;
use App\Repositories\SettingsRepositoryInterface;

class SubmissionsController extends Controller {
    private $submissionRepository;
    private $churchRepository;
    private $settingsRepository;
    private $requestLogRepository;
    private $surveyRepository;

    public function __construct(SubmissionRepositoryInterface $submissionRepositoryInterface,
        ChurchRepositoryInterface $churchRepositoryInterface,
        SettingsRepositoryInterface $settingsRepositoryInterface,
        SurveyRepositoryInterface $surveyRespositoryInterface) {
        $this->submissionRepository = $submissionRepositoryInterface;
        $this->churchRepository = $churchRepositoryInterface;
        $this->settingsRepository = $settingsRepositoryInterface;
        $this->surveyRepository = $surveyRespositoryInterface;
    }

    public function pull(PullSubmissionRequest $request) {
        $churches = $this->churchRepository->all();
        $token = $this->settingsRepository->get('token')->value;
        $surveys = $this->surveyRepository->all();

        $start_date = null;
        $end_date = null;

        switch ($request->type) {
            case Submission::REQ_TYPE_DATE:
                $dates = explode(' - ', $request->daterange);
                $start_date = Carbon::createFromFormat('d/m/Y', $dates[0])->toDateString();
                $end_date = Carbon::createFromFormat('d/m/Y', $dates[1])->toDateString();
                break;

            case Submission::REQ_TYPE_TODAY:
                $start_date = Carbon::today()->toDateString();
                $end_date = Carbon::tomorrow()->toDateString();
                break;
        }
        
        foreach ($surveys as $survey) {
            RequestSubmissions::dispatch($survey->id, Submission::STATUS_COMPLETED, $start_date, $end_date, $token, $churches);
        }

        session()->flash('success', 'Pull request for submission initiated. Please wait for a few minutes for submissions to be updated.');
        return back();
    }
}
