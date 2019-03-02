<?php

namespace App\Http\Controllers;

use App\Question;
use App\Report;
use App\Answer;
use App\Submission;
use Illuminate\Http\Request;
use App\Http\Requests\ReportRequest;

class ReportsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $this->authorize('view', Report::class);
        $reports = Report::all();
        return view('reports.index', compact('reports'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $this->authorize('create', Report::class);
        $questions = Question::with('survey')->orderBy('sequence')->get();
        return view('reports.create', compact('questions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\ReportRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ReportRequest $request) {
        $this->authorize('create', Report::class);
        $request->save();
        session()->flash('success', 'Report successfully created.');
        return redirect('reports');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Report $report) {
        $this->authorize('update', Report::class);
        $questions = Question::with('survey')->get();
        return view('reports.edit', compact('report', 'questions'));
        // return $report;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\ReportRequest  $request
     * @param  \App\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function update(ReportRequest $request, Report $report) {
        $this->authorize('update', Report::class);
        $request->save();
        session()->flash('success', 'Report successfully updated.');
        return redirect('reports');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Report  $report
     * @return \Illuminate\Http\Response
     */
    public function destroy(Report $report) {
        $this->authorize('delete', Report::class);
        $report->delete();
        session()->flash('success', 'Report successfully deleted');
        return back();
    }

    public function data(Report $report) {
        if (!auth()->check())
            abort(404);

        return response()->json([
            'leader_data' => $this->group_data($report->leader_question),
            'member_data' => $this->group_data($report->member_question)
        ], 200);
    }

    public function group_data(Question $question) {
        $options = \App\Option::where('question_id', $question->id)
                        ->orderBy('position', 'asc')
                        ->get();
        $answers = Answer::permitted()->where('answers.question_id', $question->id)
                    ->join('options', 'options.id', 'answers.option_id')
                    ->select('answers.option_id')
                    ->get();

        // dd($question->survey_id);
        $count = Submission::where('survey_id', $question->survey_id)->whereHas('answers', function($query) use ($question) {
            $query->where('question_id', $question->id);
        })->count();

        $data = [];
        $total = $answers->count();
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
