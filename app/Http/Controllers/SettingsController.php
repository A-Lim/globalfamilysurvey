<?php

namespace App\Http\Controllers;

use DataTables;
use Carbon\Carbon;
use App\Setting;
use App\RequestLog;
use Illuminate\Http\Request;
use App\Http\Requests\Settings\UpdateRequest;

use App\Repositories\SurveyRepositoryInterface;
use App\Repositories\SettingsRepositoryInterface;
use App\Repositories\RequestLogRepositoryInterface;

class SettingsController extends Controller {
    private $settingsRepository;
    private $requestLogRepository;
    private $surveyRepository;

    public function __construct(SettingsRepositoryInterface $settingsRepositoryInterface,
        RequestLogRepositoryInterface $requestLogRepositoryInterface,
        SurveyRepositoryInterface $surveyRespositoryInterface) {
        $this->middleware('auth');
        $this->settingsRepository = $settingsRepositoryInterface;
        $this->requestLogRepository = $requestLogRepositoryInterface;
        $this->surveyRepository = $surveyRespositoryInterface;
    }

    public function index() {
        $this->authorize('update', Setting::class);
        $settings = $this->settingsRepository->all();
        return view('settings.index', compact('settings'));
    }

    public function update(UpdateRequest $request) {
        $this->authorize('update', Setting::class);
        $this->settingsRepository->update_all($request);
        session()->flash('success', 'Settings successfully updated');
        return back();
    }

    public function dashboard() {
        $this->authorize('view', Setting::class);
        $survey_count = $this->surveyRepository->all_count();
        return view('settings.dashboard', compact('survey_count'));
    }

    public function jobs() {
        $jobs = \DB::table('jobs')->get();
        return response()->json($jobs);
    }
}
