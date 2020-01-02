<?php
namespace App\Console\Commands;

use Carbon\Carbon;
use App\Submission;
use App\Jobs\RequestSubmissions;

use Illuminate\Console\Command;
use App\Repositories\SurveyRepositoryInterface;
use App\Repositories\ChurchRepositoryInterface;
use App\Repositories\SettingsRepositoryInterface;

class PullSubmissions extends Command
{
    private $settingsRepository;
    private $surveyRepository;
    private $churchRepository;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'submissions:pull';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Pull submissions from survey monkey';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(SettingsRepositoryInterface $settingsRepositoryInterface,
        SurveyRepositoryInterface $surveyRespositoryInterface,
        ChurchRepositoryInterface $churchRepositoryInterface) {
        parent::__construct();
        $this->settingsRepository = $settingsRepositoryInterface;
        $this->surveyRepository = $surveyRespositoryInterface;
        $this->churchRepository = $churchRepositoryInterface;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {
        $start_date = Carbon::yesterday()->toDateString();
        $end_date = Carbon::today()->toDateString();
        $token = $this->settingsRepository->get('token')->value;
        // $request_interval = $this->settingsRepository->get('request_interval')->value;
        $request_interval = '0 0 * * *';

        // if token does not exist dont proceed
        if ($token == '')
            return;

        $surveys = $this->surveyRepository->all();
        $churches = $this->churchRepository->all();
        foreach ($surveys as $survey) {
            RequestSubmissions::dispatch($survey->id, Submission::STATUS_COMPLETED, $start_date, $end_date, $token, $churches);
        }
    }
}
