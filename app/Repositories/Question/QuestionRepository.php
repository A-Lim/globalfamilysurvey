<?php
namespace App\Repositories;

use App\Option;
use App\Question;

use Illuminate\Http\Request;

class QuestionRepository implements QuestionRepositoryInterface
{
    /**
    * {@inheritdoc}
    */
    public function all() {
        return \Cache::rememberForEver(Question::CACHE_KEY, function() {
            return Question::with('survey')->orderBy('sequence')->get();
        });
    }

    /**
    * {@inheritdoc}
    */
    public function find($id) {
        return Question::find($id);
    }

    /**
    * {@inheritdoc}
    */
    public function findBySurveyId($survey_id, $paginate = false) {
        $query = Question::where('survey_id', $survey_id)
            ->orderBy('page', 'asc')
            ->orderBy('sequence', 'asc');

        if ($paginate) {
            return $query->paginate(10);
        }

        return $query;
    }

    /**
    * {@inheritdoc}
    */
    public function members() {
        return \Cache::rememberForEver(Question::CACHE_KEY.':members', function() {
            return Question::whereHas('survey', function($query) {
                $query->where('type', 'member');
            })->orderBy('sequence')->get();
        });
    }

    /**
    * {@inheritdoc}
    */
    public function create($data) {
        $this->clear_cache();
        return Question::create($data);
    }

    /**
    * {@inheritdoc}
    */
    public function update(Question $question, $data) {
        $this->clear_cache();
        $question->update($data);
    }

    /**
    * {@inheritdoc}
    */
    public function saveFromJson($json) {
        $survey_id = $json->id;
        $data = [];
        $page_num = 0;
        foreach ($json->pages as $page) {
            $page_num++;
            foreach ($page->questions as $question_obj) {
                $question_data = [
                    'survey_id' => $survey_id,
                    'page' => $page_num,
                    'type' => $question_obj->family,
                    'subtype' => $question_obj->subtype,
                    'href' => $question_obj->href,
                    'title' => $question_obj->headings[0]->heading,
                    'sequence' => $question_obj->position
                ];

                // update if exists, else create
                if ($question = $this->find($question_obj->id)) {
                    $this->update($question, $question_data);
                } else {
                    $question_data['id'] = $question_obj->id;
                    $data[] = $question_data;
                }

                // Option::saveFromJson($question_obj->id, @$question_obj->answers->choices);
                $this->saveOptionFromJson($question_obj->id, @$question_obj->answers->choices);
                // if there are others option
                if (isset($question_obj->answers->other)) {
                    $this->saveOtherOptionFromJson($question_obj->id, $question_obj->answers->other);
                }
            }
        }

        // bulk insert
        Question::insert($data);
        $this->clear_cache();
    }

    /**
     * Save question options from json
     *
     * @param integer $question_id
     * @param integer $choices_json = null
     * @return null
     */
    private function saveOptionFromJson($question_id, $choices_json = null) {
        $data = [];
        if ($choices_json == null)
            return;

        foreach ($choices_json as $choice) {
            $choice_data = [
                'question_id' => $question_id,
                'text' => $choice->text,
                'visible' => $choice->visible,
                'position' => $choice->position
            ];

            // update if exists, else create
            if ($option = Option::where('id', $choice->id)->first()) {
                $option->update($choice_data);
            } else {
                $choice_data['id'] = $choice->id;
                $data[] = $choice_data;
            }
        }
        Option::insert($data);
    }

    /**
     * Save question other options from json
     *
     * @param integer $question_id
     * @param integer $other
     * @return null
     */
    private function saveOtherOptionFromJson($question_id, $other) {
        $other_data = [
            'question_id' => $question_id,
            'text' => $other->text,
            'visible' => $other->visible,
            'position' => $other->position
        ];

        // update if exists, else create
        if ($option = Option::where('id', $other->id)->first()) {
            $option->update($other_data);
        } else {
            $other_data['id'] = $other->id;
            $data[] = $other_data;
        }
        // bulk insert
        Option::insert($data);
    }

    // not added in interface cause other repository might not have cache implementation
    public function clear_cache() {
        \Cache::forget(Question::CACHE_KEY);
        \Cache::forget(Question::CACHE_KEY.':members');
    }
}
