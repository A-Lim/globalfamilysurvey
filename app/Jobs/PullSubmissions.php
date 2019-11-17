<?php

namespace App\Jobs;

use App\RequestLog;
use App\Submission;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use App\Repositories\SubmissionRepositoryInterface;
use App\Repositories\RequestLogRepositoryInterface;

class PullSubmissions implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $survey_id;
    private $status;
    private $start_date;
    private $end_date;
    private $page;
    private $token;
    private $churches;
    private $submissionRepository;
    private $requestLogRepository;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($survey_id, $status, $start_date, $end_date, $page, $token, $churches)
    {
        $this->survey_id = $survey_id;
        $this->status = $status;
        $this->start_date = $start_date;
        $this->end_date = $end_date;
        $this->page = $page;
        $this->token = $token;
        $this->churches = $churches;
        $this->submissionRepository = resolve(SubmissionRepositoryInterface::class);
        $this->requestLogRepository = resolve(RequestLogRepositoryInterface::class);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->pull_submission();
    }

    private function pull_submission() {
        $client = new Client();
        $query = $this->build_query();

        try {
            $url = Submission::API_URL.$this->survey_id.'/responses/bulk';
            $request = $client->get($url, [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer '.$this->token
                ],
                'query' => $query,
            ]);

            $contents = $request->getBody()->getContents();
            $result = json_decode($contents);
            $this->submissionRepository->create_from_json($result, $this->churches);
            // log result
            $this->requestLogRepository->create(RequestLog::STATUS_SUCCESS, $query, $contents);
        } catch (ClientException $exception) {
            // log error
            $this->requestLogRepository->create(RequestLog::STATUS_ERROR, $query, $exception->getResponse()->getBody()->getContents());
        }
    }

    private function build_query() {
        $query = [
            'per_page' => Submission::PER_PAGE,
            'status' => $this->status,
            'page' => $this->page,
        ];

        if ($this->start_date != null && $this->end_date != null) {
            $query['start_created_at'] = $this->start_date;
            $query['end_created_at'] = $this->end_date;
        }

        return $query;
    }
}
