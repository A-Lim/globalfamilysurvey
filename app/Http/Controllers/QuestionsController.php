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
        return view('questions.index');
    }

    /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function show(Question $question) {
        $this->authorize('view', Question::class);
        // $grouped_answers = $this->groupData($question);
        return view('questions.show', compact('question'));
    }



    // private function groupData(Question $question) {
    //     $options = \App\Option::where('question_id', $question->id)->get();
    //     $answers = Answer::permitted()->where('answers.question_id', $question->id)
    //                 ->join('options', 'options.id', 'answers.option_id')
    //                 ->get();
    //
    //     $data = [];
    //     foreach ($options as $option) {
    //         $data[$option->text] = $answers->filter(function ($value, $key) use ($option) {
    //             return $value->option_id == $option->id;
    //         })->count();
    //     }
    //     // dd($options);
    //     return $data;
    // }

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

    public function data(Question $question) {
        $options = \App\Option::where('question_id', $question->id)->get();
        $answers = Answer::permitted()->where('answers.question_id', $question->id)
                    ->join('options', 'options.id', 'answers.option_id')
                    ->select('answers.option_id')
                    ->get();

        $data = [];



        foreach ($options as $option) {
            // $keys = $question->type == 'matrix' ? explode(' ', $option->text) : $option->text;
            // dd($keys);
            $data['type'] = $question->type;
            $data['keys'][] = splitWords($option->text, 3);
            $data['values'][] = $answers->filter(function ($value, $key) use ($option) {
                return $value->option_id == $option->id;
            })->count();
        }
        return $data;
    }

    public function datatable() {
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
            ->orderBy('surveys.id', 'asc')
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
