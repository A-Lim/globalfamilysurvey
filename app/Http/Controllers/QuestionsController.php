<?php

namespace App\Http\Controllers;

use DB;
use DataTables;
use App\Question;
use App\Answer;
use App\Option;

use Illuminate\Http\Request;
use App\Repositories\QuestionRepositoryInterface;

class QuestionsController extends Controller {
    private $questionRepository;

    public function __construct(QuestionRepositoryInterface $questionRepositoryInterface) {
        $this->middleware('auth');
        $this->questionRepository = $questionRepositoryInterface;
    }

    public function index() {
        $this->authorize('view', Question::class);
        return view('questions.index');
    }

    public function show(Question $question) {
        $this->authorize('view', Question::class);
        return view('questions.show', compact('question'));
    }

    public function destroy(Question $question) {
        $this->authorize('delete', Question::class);
        $this->questionRepository->delete($question, true);
        session()->flash('success', 'Question successfully deleted');
        return back();
    }

    public function data(Request $request, Question $question) {
        return $this->questionRepository->chart_data($question, $request->filter);
    }

    public function datatable() {
        return Datatables::of($this->questionRepository->datatable_query())
            ->addIndexColumn()
            ->editColumn('title', function ($question) {
                return str_limit(strip_tags($question->title), 40);
            })
            ->editColumn('survey_type', function ($question) {
                return ucwords($question->survey_type);
            })
            ->addColumn('action', function($user) {
                $html = '';
                if (auth()->user()->can('view', Question::class)) {
                    $html .= view_button('questions', $user->id).' ';
                }
                if (auth()->user()->can('delete', Question::class)) {
                    $html .= delete_button('questions', $user->id);
                }
                return $html;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
