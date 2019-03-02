<?php
namespace App\Http\Controllers\Auth;

use App\User;
use App\Survey;

use App\Http\Controllers\Controller;

class RegisterController extends Controller {

    public function index() {
        return view('auth.register');
    }

    public function register() {

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
