<?php

namespace App\Http\Controllers;

use App\Setting;
use App\Webhook;
use App\Survey;
use Illuminate\Http\Request;

use App\Http\Requests\Webhooks\CreateRequest;
use App\Http\Requests\Webhooks\UpdateRequest;
use App\Http\Requests\Webhooks\DeleteRequest;

class WebhooksController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $this->authorize('view', Webhook::class);
        $webhooks = Webhook::with('survey')->paginate(10);
        return view('webhooks.index', compact('webhooks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $this->authorize('create', Webhook::class);
        $surveys = Survey::all();
        return view('webhooks.create', compact('surveys'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequest $request) {
        $this->authorize('create', Webhook::class);
        $token = $this->check_token_exists();
        $result = $request->create_webhook($token);

        if ($result['status']) {
            session()->flash('success', 'Webhook successfully created.');
            return back()->with(['result' => $result['content']]);
        } else {
            return back()->with(['result' => $result['content'], 'error' => $result['message']]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Webhook  $webhook
     * @return \Illuminate\Http\Response
     */
    public function show(Webhook $webhook) {
        //
    }

    public function edit(Webhook $webhook) {
        $this->authorize('update', $webhook);
        $surveys = Survey::all();
        return view('webhooks.edit', compact('surveys', 'webhook'));
    }

    public function update(UpdateRequest $request, Webhook $webhook) {
        $this->authorize('update', $webhook);
        $token = $this->check_token_exists();
        $result = $request->update_webhook($token);

        if ($result['status']) {
            session()->flash('success', 'Webhook successfully updated.');
            return back()->with(['result' => $result['content']]);
        } else {
            return back()->with(['result' => $result['content'], 'error' => $result['message']]);
        }
    }

    public function destroy(DeleteRequest $request, Webhook $webhook)
    {
        $this->authorize('delete', $webhook);
        $token = $this->check_token_exists();
        $result = $request->delete_webhook($token);

        if ($result['status']) {
            session()->flash('success', 'Webhook successfully deleted.');
            return back()->with(['result' => $result['content']]);
        } else {
            return back()->with(['result' => $result['content'], 'error' => $result['message']]);
        }
    }

    protected function check_token_exists() {
        $token = Setting::where('name', 'Survey Monkey Token')->first()->value;
        if ($token == '') {
            return redirect('surveys/retrieve')->with('error', 'Please set up your Survey Monkey Api Key and Token in the settings page.');
            exit();
        }
        return $token;
    }
}
