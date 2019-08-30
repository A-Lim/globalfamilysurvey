<?php
namespace App\Http\Controllers\Auth;

use App\User; 
use App\Survey;
use App\Country;
use App\Network;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterNetworkRequest;
use App\Http\Requests\RegisterChurchRequest;

class RegisterController extends Controller {

    public function __construct() {
        $this->middleware('guest');
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
        // if there is no survey currently, dont allow registration
        $is_opened = Survey::count() > 0;
        $countries = Country::select('id', 'name')->get();
        return view('auth.register_church', compact('countries', 'is_opened'));
    }

    public function network_registration() {
        // if there is no survey currently, dont allow registration
        $is_opened = Survey::count() > 0;
        $countries = Country::select('id', 'name')->get();
        return view('auth.register_network', compact('countries', 'is_opened'));
    }

    public function network_register(RegisterNetworkRequest $request) {
        $request->save();
        return back()->with('success', 'Registration success! An email will be sent to you.');
    }

    public function church_register(RegisterChurchRequest $request) {
        $request->save();
        return back()->with('success', 'Registration success! An email will be sent to you.');
    }

    // public function registration() {
    //     $churches = Church::all();
    //     return view('users.register', compact('churches'));
    // }
    //
    // public function register(RegisterRequest $request) {
    //     $request->save();
    //     session()->flash('success', 'Registration submitted. You will be notified when registration is approved.');
    //     return back();
    // }

}
