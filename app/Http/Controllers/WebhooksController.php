<?php

namespace App\Http\Controllers;

use App\Setting;
use App\Webhook;
use App\Survey;
use Illuminate\Http\Request;
use App\Http\Requests\WebhookRequest;

class WebhooksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $webhooks = Webhook::with('survey')->paginate(10);
        return view('webhooks.index', compact('webhooks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $surveys = Survey::all();
        return view('webhooks.create', compact('surveys'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(WebhookRequest $request) {
        $token = Setting::where('name', 'Survey Monkey Token')->first()->value;

        if ($token == '')
            return redirect('surveys/retrieve')->with('error', 'Please set up your Survey Monkey Api Key and Token in the settings page.');

        $result = $request->save($token);

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
    public function show(Webhook $webhook)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Webhook  $webhook
     * @return \Illuminate\Http\Response
     */
    public function edit(Webhook $webhook)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Webhook  $webhook
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Webhook $webhook)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Webhook  $webhook
     * @return \Illuminate\Http\Response
     */
    public function destroy(Webhook $webhook)
    {
        //
    }
}
