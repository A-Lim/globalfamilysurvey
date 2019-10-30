<?php
namespace App\Repositories;

use DB;
use App\Answer;
use App\Submission;
use Illuminate\Support\Arr;

use Illuminate\Http\Request;

class SubmissionRepository implements SubmissionRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function all() {

    }

    /**
     * {@inheritdoc}
     */
    public function get_from_ids($ids) {
        return Submission::whereIn('id', $ids)->get();
    }

    /**
     * {@inheritdoc}
     */
    public function create($data) {

    }

    /**
     * {@inheritdoc}
     */
    public function create_from_json($json, $churches) {
        $valid_churches_uuid = $churches->pluck('uuid')->toArray();
        // retrieve ids of submissions which are already saved in db from the json
        $existing_submission_ids = $this->get_existing_submssion_ids($json);

        $submission_data = [];
        $answer_data = [];
        foreach ($json->data as $submission) {
            $church_uuid = @$submission->custom_variables->ch;
            // check if submission belongs to a church
            // or submission is already saved inside db
            // if not, skip to the next loop
            if ($church_uuid == null || !in_array($church_uuid, $valid_churches_uuid) || in_array($submission->id, $existing_submission_ids)) {
                continue;
            }

            $submission_data[] = $this->parse_submission($submission, $church_uuid);
            // parse_answer returns an array
            // merge result from 'parse_answer' into existing $answer_data array
            $answer_data = array_merge($answer_data, $this->parse_answer($submission));
        }

        // if any error occurs within beginTransaction and commit, the query will be rolled back
        DB::beginTransaction();
        Submission::insert($submission_data);
        Answer::insert($answer_data);
        DB::commit();
    }

    /**
     * {@inheritdoc}
     */
    public function update(Submission $submission) {

    }

    // from the json, return ids of submissions which are already inside db
    private function get_existing_submssion_ids($json) {
        // retrive all submission id from json
        $submission_ids = collect($json->data)->pluck('id');
        $submissions = $this->get_from_ids($submission_ids);

        return $submissions->pluck('id')->toArray();
    }

    private function parse_submission($json, $church_uuid) {
        return [
            'id' => $json->id,
            'survey_id' => $json->survey_id,
            'church_id' => $church_uuid,
            'href' => $json->href,
            'total_time' => $json->total_time,
            'ip_address' => $json->ip_address,
            'analyze_url' => $json->analyze_url,
            'response_status' => $json->response_status,
            'language' => @$json->metadata->respondent->language->value
        ];
    }

    private function parse_answer($json) {
        $answer_data = [];
        foreach ($json->pages as $page) {
            foreach ($page->questions as $question) {
                foreach ($question->answers as $answer) {
                    $answer_data[] = [
                        'submission_id' => $json->id,
                        'question_id' => $question->id,
                        'option_id' => $answer->choice_id ?? $answer->other_id,
                        'row_id' => @$answer->row_id,
                        'text' => @$answer->text
                    ];
                }
            }
        }
        return $answer_data;
    }
}
