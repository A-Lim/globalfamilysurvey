<?php
namespace App\Repositories;

use DB;
use App\Option;
use App\Question;
use App\Answer;

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
    public function delete(Question $question, $linked = false) {
        DB::beginTransaction();
        $question->delete();
        if ($linked) {
            $question->answers()->delete();
        }
        DB::commit();
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
        return $question->update($data);
    }

    /**
    * {@inheritdoc}
    */
    public function chart_data(Question $question, $filter = null) {
        $options = Option::where('question_id', $question->id)
                    ->orderBy('position', 'asc')
                    ->get();

        $answers = Answer::permitted($filter)->where('answers.question_id', $question->id)
                    ->join('options', 'options.id', 'answers.option_id')
                    ->select('answers.option_id')
                    ->get();

        $data = [];

        foreach ($options as $option) {
            $data['type'] = $question->type;
            // $data['keys'][] = splitWords($option->text, 3);
            $data['keys'][] = $option->text;
            $data['values'][] = $answers->filter(function ($value, $key) use ($option) {
                return $value->option_id == $option->id;
            })->count();
        }
        return $data;
    }

    /**
    * {@inheritdoc}
    */
    public function datatable_query() {
        return Question::join('surveys', 'questions.survey_id', '=', 'surveys.id')
            ->orderBy('surveys.id', 'asc')
            ->orderBy('questions.sequence', 'asc')
            ->select('questions.*', 'surveys.type as survey_type')
            ->withCount('answers');
    }

    /**
    * {@inheritdoc}
    */
    public function saveFromJson($json) {
        $survey_id = $json->id;
        $data = [];

        $existing = $this->getIfExist($json);
        // dd($exist);

        foreach ($json->pages as $page) {
            foreach ($page->questions as $question_json) {
                $question_data = Question::formatFromJson($survey_id, $page->position, $question_json);
                // update if exists, else create
                if ($question = $existing['questions']->where('id', $question_json->id)->first()) {
                    $this->update($question, $question_data);
                } else {
                    $question_data['id'] = $question_json->id;
                    $data[] = $question_data;
                }

                $this->saveOptionFromJson($question_json->id, @$question_json->answers, $existing['options']);
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
     * @param [Option]
     * @return null
     */
    private function saveOptionFromJson($question_id, $answers_json, $existing_options) {
        $data = [];

        $choices_json = $answers_json->choices;
        foreach ($choices_json as $choice_json) {
            $choice_data = Option::formatFromJson($question_id, $choice_json);
            // update if exists, else create
            if ($option = $existing_options->where('id', $choice_json->id)->first()) {
                $option->update($choice_data);
            } else {
                $choice_data['id'] = $choice_json->id;
                $data[] = $choice_data;
            }
        }

        if (isset($answers_json->other)) {
            $choice_data = Option::formatFromJson($question_id, $answers_json->other);
            // update if exists, else create
            if ($option = Option::where('id', $answers_json->other->id)->first()) {
                $option->update($choice_data);
            } else {
                $choice_data['id'] = $answers_json->other->id;
                $data[] = $choice_data;
            }
        }
        Option::insert($data);
    }

    /**
     * Retrieve all existing questions and options
     * Query all questions, options one go to prevent having to check db multiple times inside loop
     *
     * @param object $json
     * @return array of collections
     */
    private function getIfExist($json) {
        $question_ids = [];
        $options_ids = [];

        foreach ($json->pages as $page) {
            foreach ($page->questions as $question) {
                $question_ids[] = $question->id;

                foreach ($question->answers->choices as $choice) {
                    $options_ids[] = $choice->id;
                }

                if (isset($question->answers->other)) {
                    $options_ids[] = $question->answers->other->id;
                }
            }
        }

        $questions = Question::whereIn('id', $question_ids)->get();
        $options = Option::whereIn('id', $options_ids)->get();
        return [
            'questions' => $questions,
            'options' => $options
        ];
    }

    // /**
    //  * Save question other options from json
    //  *
    //  * @param integer $question_id
    //  * @param integer $other
    //  * @return null
    //  */
    // private function saveOtherOptionFromJson($question_id, $other) {
    //     $other_data = [
    //         'question_id' => $question_id,
    //         'text' => $other->text,
    //         'visible' => $other->visible,
    //         'position' => $other->position
    //     ];
    //
    //     // update if exists, else create
    //     if ($option = Option::where('id', $other->id)->first()) {
    //         $option->update($other_data);
    //     } else {
    //         $other_data['id'] = $other->id;
    //         $data[] = $other_data;
    //     }
    //     // bulk insert
    //     Option::insert($data);
    // }

    // not added in interface cause other repository might not have cache implementation
    private function clear_cache() {
        \Cache::forget(Question::CACHE_KEY);
        \Cache::forget(Question::CACHE_KEY.':members');
    }
}
