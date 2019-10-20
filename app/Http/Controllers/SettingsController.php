<?php

namespace App\Http\Controllers;

use App\Setting;
use Illuminate\Http\Request;
use App\Http\Requests\Settings\UpdateRequest;
use App\Repositories\SettingsRepositoryInterface;

class SettingsController extends Controller {
    private $settingsRepository;

    public function __construct(SettingsRepositoryInterface $settingsRepositoryInterface) {
        $this->middleware('auth');
        $this->settingsRepository = $settingsRepositoryInterface;
    }

    public function index() {
        $this->authorize('update', Setting::class);
        $settings = $this->settingsRepository->all();
        return view('settings.index', compact('settings'));
    }

    public function update(UpdateRequest $request) {
        $this->authorize('update', Setting::class);
        $this->settingsRepository->update_all($request);
        session()->flash('success', 'Settings successfully updated');
        return back();
    }
}
