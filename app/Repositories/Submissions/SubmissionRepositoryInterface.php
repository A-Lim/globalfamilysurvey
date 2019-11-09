<?php
namespace App\Repositories;

use App\Submission;
use Illuminate\Http\Request;

interface SubmissionRepositoryInterface
{
    /**
     * Retrieve all submissions
     *
     * @return [Submission]
     */
    public function all();

    /**
     * Retrieve all submissions by ids
     *
     * @param $ids - Array of ids
     * @return [Submission]
     */
    public function get_from_ids($ids);

    /**
     * Create a submission
     *
     * @param array $data
     * @return [Submission]
     */
    public function create($data);

    /**
     * Update a submission
     *
     * @param Submission $submission
     * @return null
     */
    public function update(Submission $submission);
}
