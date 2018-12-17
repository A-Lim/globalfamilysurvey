<?php

namespace App\Http\Controllers;

use DB;
use App\Survey;
use App\Question;
use Illuminate\Http\Request;

class SurveysController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {
        $this->authorize('view', Survey::class);
        $surveys = Survey::withCount('questions')->paginate(10);
        return view('surveys.index', compact('surveys'));
    }

    public function show(Survey $survey) {
        $this->authorize('view', Survey::class);
        return view('surveys.show', [
            'survey' => $survey,
            'questions' => Question::where(['survey_id' => $survey->id])
                            ->withCount('answers')
                            ->orderBy('sequence', 'asc')
                            ->paginate(10)
        ]);
    }

    public function destroy(Survey $survey) {
        $this->authorize('delete', Survey::class);
        $this->deleteAllLinked($survey);
        session()->flash('success', 'Survey successfully deleted');
        return back();
    }

    protected function deleteAllLinked(Survey $survey) {
        DB::transaction(function() use ($survey) {
            $ids = DB::table('questions')->where(['survey_id' => $survey->id])->pluck('id')->toArray();
            DB::table('surveys')->where(['id' => $survey->id])->delete();
            DB::table('questions')->where(['survey_id' => $survey->id])->delete();
            DB::table('answers')->whereIn('question_id', $ids)->delete();
        });
    }
}
