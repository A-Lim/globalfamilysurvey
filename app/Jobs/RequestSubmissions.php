<?php

namespace App\Jobs;

use App\Submission;
use App\RequestLog;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use App\Repositories\SubmissionRepositoryInterface;
use App\Repositories\RequestLogRepositoryInterface;

use App\Jobs\PullSubmissions;

class RequestSubmissions implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $survey_id;
    private $status;
    private $start_date;
    private $end_date;
    private $token;
    private $churches;
    private $submissionRepository;
    private $requestLogRepository;

    /**
     * Create a new job instance.
     *
     * @return void
     */
     public function __construct($survey_id, $status, $start_date, $end_date, $token, $churches)
     {
         $this->survey_id = $survey_id;
         $this->status = $status;
         $this->start_date = $start_date;
         $this->end_date = $end_date;
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
        // build query params
        $query = $this->build_query();

        try {
            $url = Submission::API_URL.$this->survey_id.'/responses/bulk';
            $request = $client->get($url, [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer '.$this->token
                ],
                'query' => $query
            ]);

            $contents = $request->getBody()->getContents();
            $result = json_decode($contents);
            $this->submissionRepository->create_from_json($result, $this->churches);
            // log result
            $this->requestLogRepository->create(RequestLog::STATUS_SUCCESS, $query, $contents);

            // calculate total pages
            $total_pages = ceil($result->total / $result->per_page);
            // add additional pages to queue
            if ($total_pages > 1) {
                // $i starts at 2 because page 1 is already processed
                for ($i = 2; $i <= $total_pages; $i++) {
                    PullSubmissions::dispatch($this->survey_id, Submission::STATUS_COMPLETED, $this->start_date, $this->end_date, $i, $this->token, $this->churches);
                }
            }
        } catch (ClientException $exception) {
            // log error
            $this->requestLogRepository->create(RequestLog::STATUS_ERROR, $query, $exception->getResponse()->getBody()->getContents());
        }
    }

    private function build_query() {
        $query = [
            'per_page' => Submission::PER_PAGE,
            'status' => 'completed',
        ];

        if ($this->start_date != null && $this->end_date != null) {
            $query['start_created_at'] = $this->start_date;
            $query['end_created_at'] = $this->end_date;
        }

        return $query;
    }
}
