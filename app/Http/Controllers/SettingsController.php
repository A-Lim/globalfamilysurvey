<?php

namespace App\Http\Controllers;

use App\Setting;
use Illuminate\Http\Request;
use App\Http\Requests\SettingsRequest;

class SettingsController extends Controller {
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {
        $this->authorize('update', Setting::class);
        $settings = \App\Setting::all();
        return view('settings.index', compact('settings'));
    }

    public function update(SettingsRequest $request) {
        $this->authorize('update', Setting::class);
        $request->save();
        session()->flash('success', 'Settings successfully updated');
        return back();
    }
}
