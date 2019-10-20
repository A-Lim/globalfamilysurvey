<?php
namespace App\Repositories;

use Illuminate\Http\Request;

interface QuestionRepositoryInterface
{
    /**
     * Retrieve all questions, with survey, ordered by sequence
     *
     * @return [Question]
     */
    public function all();

    /**
     * Retrieve all questions from member survey
     *
     * @return [Question]
     */
    public function members();

    /**
     * Save questions from json
     *
     * @param array $data
     * @return null
     */
    public function saveFromJson($data);

    /**
     * Retrieve question by id
     *
     * @param integer $id
     * @return Question
     */
    public function find($id);

    /**
     * Retrieve questions by survey id
     *
     * @param integer $survey_id
     * @param integer $paginate = false
     * @return [Question]
     */
    public function findBySurveyId($survey_id, $paginate = false);
}
