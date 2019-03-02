<?php
namespace App\Http\Controllers\Auth;

use App\User;
use App\Survey;
use App\Country;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;

class RegisterController extends Controller {

    public function __construct() {
        // $this->middleware('guest');
    }

    public function index() {
        $countries = Country::select('id', 'name')->get();
        return view('auth.register', compact('countries'));
    }

    public function register(RegisterRequest $request) {
        dd("OK");
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
