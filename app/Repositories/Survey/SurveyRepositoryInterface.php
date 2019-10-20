<?php
namespace App\Repositories;

use App\Survey;
use Illuminate\Http\Request;

interface SurveyRepositoryInterface
{
    /**
     * Retrieve all surveys
     *
     * @return [Survey]
     */
    public function all();

    /**
     * Retrieve survey by id
     *
     * @param integer $id
     * @return Survey
     */
    public function find($id);

    /**
     * Create survey
     *
     * @param array $data
     * @return Survey
     */
    public function create($data);

    /**
     * Update survey
     *
     * @param Survey $survey
     * @param array $data
     * @return null
     */
    public function update(Survey $survey, $data);

    /**
     * Save surveys from json
     *
     * @param array $data
     * @param array $json
     * @return null
     */
     public function saveFromJson($data, $json);
}
