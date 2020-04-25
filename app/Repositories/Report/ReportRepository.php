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

        $count = Submission::permitted($filter)->whereHas('answers', function($query) use ($question) {
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

    public function grouped_report_details($filter = null) {
        $church = auth()->user()->church;
        $roles = auth()->user()->roles;

        $reports = Report::all();
        $questions = Question::all();
        $options = Option::orderBy('position', 'asc')->get();
        
        $data = [];
        foreach ($reports as $report) {
            $answers = Answer::permitted($filter)
                ->whereIn('answers.question_id', [$report->leader_question_id, $report->member_question_id])
                ->join('options', 'options.id', 'answers.option_id')
                ->select('answers.option_id')
                ->get();

            $report_data = [];
            $report_data['report_id'] = $report->id;
            $leader_question_options = $options->filter(function ($option) use ($report) {
                return $option->question_id == $report->leader_question_id;
            });

            foreach($leader_question_options as $option) {
                $report_data['leader_data']['total'] = $answers->filter(function ($answer) use ($leader_question_options) {
                    return in_array($answer->option_id, $leader_question_options->pluck('id')->toArray()); 
                })->count();

                $report_data['leader_data']['keys'][] = $option->text;
                $report_data['leader_data']['values'][] = $answers->filter(function ($answer) use ($option) {
                    return $answer->option_id == $option->id;
                })->count();
            }

            $member_question_options = $options->filter(function ($option) use ($report) {
                return $option->question_id == $report->member_question_id;
            });

            foreach($member_question_options as $option) {
                $report_data['member_data']['total'] = $answers->filter(function ($answer) use ($member_question_options) {
                    return in_array($answer->option_id, $member_question_options->pluck('id')->toArray()); 
                })->count();

                $report_data['member_data']['keys'][] = $option->text;
                $report_data['member_data']['values'][] = $answers->filter(function ($answer) use ($option) {
                    return $answer->option_id == $option->id;
                })->count();
            }

            array_push($data, $report_data);
        }
        return $data;
    }
}
