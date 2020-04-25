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

    public function data(Request $request, Report $report) {
        $result = $this->reportRepository->data($report, $request->filter);
        return response()->json($result, 200);
    }

    public function grouped_data(Request $request) {
        $result = $this->reportRepository->grouped_report_details($request->filter);
        return response()->json($result, 200);
    }
}
