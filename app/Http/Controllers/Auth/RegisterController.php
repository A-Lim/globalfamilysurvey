<?php
namespace App\Http\Controllers\Auth;

use App\Survey;
use App\Country;
use App\Network;
use App\Events\ChurchRegistered;
use App\Events\NetworkRegistered;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\AuthRepositoryInterface;
use App\Repositories\SettingsRepositoryInterface;

use App\Http\Requests\Auth\RegisterNetworkRequest;
use App\Http\Requests\Auth\RegisterChurchRequest;

class RegisterController extends Controller {
    private $authRepository;
    private $settingsRepository;

    public function __construct(AuthRepositoryInterface $authRepositoryInterface, SettingsRepositoryInterface $settingsRepository) {
        $this->middleware('guest');
        $this->authRepository = $authRepositoryInterface;
        $this->settingsRepository = $settingsRepository;
    }

    public function index() {
        return view('auth.register');
    }

    public function church_registration() {
        // check if network_uuid is valid
        if (request()->has('network_uuid')) {
            $network = Network::where('uuid', request('network_uuid'))->first();
            if (!$network)
                return redirect('register/church')->with('error', 'Invalid network uuid.');
        }

        $is_opened = $this->settingsRepository->registration_is_opened();
        $countries = Country::select('id', 'name')->get();
        return view('auth.register_church', compact('countries', 'is_opened'));
    }

    public function network_registration() {
        $is_opened = $this->settingsRepository->registration_is_opened();
        $countries = Country::select('id', 'name')->get();
        return view('auth.register_network', compact('countries', 'is_opened'));
    }

    public function network_register(RegisterNetworkRequest $request) {
        $password = str_random(10);
        $user = $this->authRepository->register_network($request, $password);
        // send mail
        event(new NetworkRegistered($user, $password));
        return back()->with('success', 'Registration success! An email will be sent to you.');
    }

    public function church_register(RegisterChurchRequest $request) {
        // randomly generated password
        $password = str_random(10);
        $user = $this->authRepository->register_church($request, $password);
        // send mail
        event(new ChurchRegistered($user, $password));
        return back()->with('success', 'Registration success! An email will be sent to you.');
    }
}
