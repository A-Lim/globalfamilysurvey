<?php
namespace App\Repositories;

use App\Question;
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
     * Delete questions
     *
     * @param Question $question
     * @param bool $linked - If true delete questions with answers and options linked to it
     * @return [Question]
     */
    public function delete(Question $question, $linked = false);

    /**
     * Retrieve all questions from member survey
     *
     * @return [Question]
     */
    public function members();

    /**
     * Create question
     *
     * @param array $data
     * @return [Question]
     */
    public function create($data);


    /**
     * Update question
     *
     * @param Question $question
     * @param array $data
     * @return null
     */
    public function update(Question $question, $data);


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

    /**
     * Retrieve answers for question in chart format
     *
     * @param Question $question
     * @param string church
     * @return [Question]
     */
    public function chart_data(Question $question, $filter);

    /**
     * Retrieve query for datatable
     *
     * @return QueryBuilder
     */
    public function datatable_query();
}
