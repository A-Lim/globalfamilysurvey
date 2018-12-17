<?php

namespace App\Http\Controllers;

use DB;
use App\Result;
use App\Question;
use App\Answer;
use App\Survey;
use App\Submission;
use Illuminate\Http\Request;

class ResultsController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function index() {
    //     $path = storage_path('app/public/json/survey.json');
    //     $contents = json_decode(file_get_contents($path));
    //     $json_answers = $contents->form_response->answers;
    //
    //     $json_questions = $contents->form_response->definition->fields;
    //
    //     DB::transaction(function() use ($contents){
    //         Survey::saveFromJson($contents);
    //         $submission = Submission::saveFromJson($contents);
    //         Question::saveFromJson($contents);
    //         Answer::saveFromJson($contents, $submission);
    //     });
    //
    //     return Survey::with(['questions', 'questions.answers'])->get();
    // }


    public function leaders() {
        $path = storage_path('app/public/json/leadersample.json');
        $contents = json_decode(file_get_contents($path));

        DB::transaction(function() use ($contents){
            Survey::saveFromJson($contents, 'leader');
            $submission = Submission::saveFromJson($contents);
            Question::saveFromJson($contents);
            Answer::saveFromJson($contents, $submission);
        });

        return Survey::with(['questions', 'questions.answers'])->get();
    }

    public function members() {
        $path = storage_path('app/public/json/sample.json');
        $contents = json_decode(file_get_contents($path));

        DB::transaction(function() use ($contents){
            Survey::saveFromJson($contents, 'member');
            $submission = Submission::saveFromJson($contents);
            Question::saveFromJson($contents);
            Answer::saveFromJson($contents, $submission);
        });

        return Survey::with(['questions', 'questions.answers'])->get();
    }

   //  public function api(Request $request) {
   //     $json = $request->getContent();
   //     // return Request::instance()->getContent();
   //     // var_dump($request);
   //     // $data = $request->input();
   //     // return $request;
   //     $data = json_decode($json);
   //     // var_dump($request->getContent());
   //     Survey::saveFromJson($data);
   //     Question::saveFromJson($data);
   //     Answer::saveFromJson($data);
   //     return response()->json(['status' => 'success'], 200);
   //     // return $request;
   // }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
