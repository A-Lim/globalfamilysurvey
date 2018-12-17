<?php

namespace App\Http\Controllers;

use App\Question;
use App\Report;
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
}
