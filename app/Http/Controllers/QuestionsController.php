<?php

namespace App\Http\Controllers;

use DB;
use DataTables;
use App\Question;
use App\Answer;
use Illuminate\Http\Request;

class QuestionsController extends Controller {
    public function __construct() {
        $this->middleware('auth');
    }

    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index() {
        $this->authorize('view', Question::class);
        $questions = Question::orderBy('sequence', 'asc')
        // ->filter(request(['search']))
        ->with('survey')
        ->withCount('answers')
        ->get();
        // ->paginate(10);
        return view('questions.index', compact('questions'));
    }

    /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function show(Question $question) {
        $this->authorize('view', Question::class);
        $grouped_answers = $this->groupData($question);
        return view('questions.show', compact('question', 'grouped_answers'));
    }

    private function groupData($question) {
        // initialize empty array
        $data = $values = [];
        $hasBoolean = false;

        $answers = Answer::permitted()->where('question_id', $question->id)->get();

        // $values = $question->answers->pluck('value')->toArray();
        // // dd($values);
        // $data = array_count_values($values);
        // //
        // dd($data);

        // group all answer values
        foreach ($question->answers as $answer) {
            foreach ($answer->value as $value) {
                $hasBoolean = is_bool($value);
                array_push($values, $value);
            }
        }

        // array_count_values only work for integer and string
        // if array has boolean, do manual counting
        if ($hasBoolean) {
            $data['yes'] = count(array_filter($values));
            $data['no'] = count($values) - $data['yes'];
        } else {
            $data = array_count_values($values);
        }
        return $data;
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function destroy(Question $question) {
        $this->authorize('delete', Question::class);
        $this->deleteAllLinked($question);
        session()->flash('success', 'Question successfully deleted');
        return back();
    }

    public function datatable() {
        // $query = Question::orderBy('sequence', 'asc')
        //             ->with('survey')
        //             ->withCount('answers');
        return Datatables::of($this->datatable_query())
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

    protected function datatable_query() {
        return Question::join('surveys', 'questions.survey_id', '=', 'surveys.id')
            ->orderBy('questions.sequence', 'asc')
            ->select('questions.*', 'surveys.type as survey_type')
            ->withCount('answers');
    }

    protected function deleteAllLinked(Question $question) {
        DB::transaction(function() use ($question) {
            DB::table('questions')->where(['id' => $question->id])->delete();
            DB::table('answers')->where(['question_id' => $question->id])->delete();
        });
    }
}
