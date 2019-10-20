<?php

namespace App\Http\Controllers;

use App\Question;
use App\Report;
use App\Answer;
use App\Option;
use App\Submission;
use Illuminate\Http\Request;
use App\Http\Requests\Report\CreateRequest;
use App\Http\Requests\Report\UpdateRequest;

use App\Repositories\ReportRepositoryInterface;
use App\Repositories\QuestionRepositoryInterface;

class ReportsController extends Controller
{
    private $questionRepository;
    private $reportRepository;

    public function __construct(QuestionRepositoryInterface $questionRepositoryInterface,
        ReportRepositoryInterface $reportRepositoryInterface) {
        $this->middleware('auth');
        $this->questionRepository = $questionRepositoryInterface;
        $this->reportRepository = $reportRepositoryInterface;
    }

    public function index() {
        $this->authorize('view', Report::class);
        $reports = $this->reportRepository->all();
        return view('reports.index', compact('reports'));
    }

    public function create() {
        $this->authorize('create', Report::class);
        $questions = $this->questionRepository->all();
        return view('reports.create', compact('questions'));
    }

    public function store(CreateRequest $request) {
        $this->authorize('create', Report::class);
        $this->reportRepository->create($request);
        session()->flash('success', 'Report successfully created.');
        return redirect('reports');
    }

    public function edit(Report $report) {
        $this->authorize('update', Report::class);
        $questions = $this->questionRepository->all();
        return view('reports.edit', compact('report', 'questions'));
    }

    public function update(UpdateRequest $request, Report $report) {
        $this->authorize('update', Report::class);
        $this->reportRepository->update($report, $request);
        session()->flash('success', 'Report successfully updated.');
        return redirect('reports');
    }

    public function destroy(Report $report) {
        $this->authorize('delete', Report::class);
        $this->reportRepository->delete($report);
        session()->flash('success', 'Report successfully deleted');
        return back();
    }

    // TODO::move to repository
    public function data(Request $request, Report $report) {
        // if (!auth()->check())
        //     abort(404);

        // if ($request->has('filter')) {
        //     return response()->json([
        //         'leader_data' => $this->group_data($report->leader_question, $request->filter),
        //         'member_data' => $this->group_data($report->member_question, $request->filter)
        //     ], 200);
        // }
        $result = $this->reportRepository->data($report, $request->filter);
        return response()->json($result, 200);
    }

    // TODO::move to repository
    // public function group_data(Question $question, $filter = null) {
    //     $options = Option::where('question_id', $question->id)
    //                     ->orderBy('position', 'asc')
    //                     ->get();
    //
    //     $answers = Answer::permitted($filter)->where('answers.question_id', $question->id)
    //                 ->join('options', 'options.id', 'answers.option_id')
    //                 ->select('answers.option_id')
    //                 ->get();
    //
    //     $count = Submission::permitted($filter)->where('survey_id', $question->survey_id)
    //         ->whereHas('answers', function($query) use ($question, $answers) {
    //             $query->where('question_id', $question->id);
    //         })->count();
    //
    //     $data = [];
    //     foreach ($options as $option) {
    //         $data['type'] = $question->type;
    //         $data['total'] = $count;
    //         $data['keys'][] = $option->text;
    //         $data['values'][] = $answers->filter(function ($value, $key) use ($option) {
    //             return $value->option_id == $option->id;
    //         })->count();
    //     }
    //     return $data;
    // }
}
