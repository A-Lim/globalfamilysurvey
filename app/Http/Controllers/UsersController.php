<?php

namespace App\Http\Controllers;

use App\User;
use App\Survey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\UserRequest;

class UsersController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $this->authorize('view', User::class);
        $users = User::latest()
                    ->permitted()
                    ->with(['roles', 'church'])
                    ->whereNotIn('id', [auth()->user()->id])
                    ->paginate(10);
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $this->authorize('create', User::class);
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request) {
        $this->authorize('create', User::class);
        $request->save();
        session()->flash('success', 'User successfully registered');
        return redirect('/users');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user) {
        $this->authorize('update', $user);
        return view('users.edit', [
            'user' => User::with('roles', 'level')->find($user->id),
            'surveys' => \App\Survey::all(),
            'church' => \App\Church::where('id', $user->church_id)->firstOrFail(),
            'survey_base_url' => \App\Setting::where('key', 'survey_base_url')->firstOrFail()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, User $user) {
        $this->authorize('update', $user);
        $request->save();
        session()->flash('success', 'User successfully updated');

        // means user is editing his own profile
        if (auth()->id() == $user->id) {
            return redirect('/dashboard');
        } else {
            return redirect('/users');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user) {
        $this->authorize('delete', $user);
        $user->delete();
        session()->flash('success', 'User successfully deleted');
        return back();
    }
}
