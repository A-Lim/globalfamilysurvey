<?php
namespace App\Repositories;

use App\Answer;
use App\Option;
use App\Report;
use App\Question;
use App\Submission;

use Illuminate\Http\Request;

class ReportRepository implements ReportRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function all() {
        return \Cache::rememberForEver(Report::CACHE_KEY, function() {
            return Report::all();
        });
    }

    /**
     * {@inheritdoc}
     */
    public function find($id) {
        return Report::find($id);
    }

    /**
     * {@inheritdoc}
     */
    public function create(Request $request) {
        $report = Report::create($request->all());
        \Cache::forget(Report::CACHE_KEY);
        return $report;
    }

    /**
     * {@inheritdoc}
     */
    public function update(Report $report, Request $request) {
        $report->update($request->all());
        \Cache::forget(Report::CACHE_KEY);
    }

    /**
     * {@inheritdoc}
     */
    public function delete(Report $report) {
        $report->delete();
        \Cache::forget(Report::CACHE_KEY);
    }

    /**
     * {@inheritdoc}
     */
     public function data(Report $report, $filter = null) {
         return [
             'leader_data' => $this->chart_data($report->leader_question, $filter),
             'member_data' => $this->chart_data($report->member_question, $filter)
         ];
     }

     private function chart_data(Question $question, $filter = null) {
         $options = Option::where('question_id', $question->id)
                         ->orderBy('position', 'asc')
                         ->get();

         $answers = Answer::permitted($filter)->where('answers.question_id', $question->id)
                     ->join('options', 'options.id', 'answers.option_id')
                     ->select('answers.option_id')
                     ->get();

         $count = Submission::permitted($filter)->where('survey_id', $question->survey_id)
             ->whereHas('answers', function($query) use ($question, $answers) {
                 $query->where('question_id', $question->id);
             })->count();

         $data = [];
         foreach ($options as $option) {
             $data['type'] = $question->type;
             $data['total'] = $count;
             $data['keys'][] = $option->text;
             $data['values'][] = $answers->filter(function ($value, $key) use ($option) {
                 return $value->option_id == $option->id;
             })->count();
         }
         return $data;
     }
}
