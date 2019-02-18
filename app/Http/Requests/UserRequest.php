<?php

namespace App\Http\Requests;

use Mail;
use App\User;
use App\Role;
use App\Mail\WelcomeMail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        switch ($this->method()) {
            case 'POST':
                return [
                    'name' => 'required|string',
                    'email' => 'required|string|email|max:255|unique:users',
                    'role'  => 'required|exists:roles,id',
                    'level' => 'required|string',
                    'church' => 'required|exists:churches,id'
                ];
                break;

            case 'PATCH':
                return [
                    'name' => 'required|string|max:255',
                    'email' => 'required|string|email|max:255|unique:users,email,'.$this->user->id,
                    'role'  => 'sometimes|exists:roles,id',
                    'level' => 'sometimes|string',
                    'church' => 'sometimes|exists:churches,id',
                    'password' => 'nullable|sometimes|string|min:6|confirmed'
                ];
                break;

            default:
                break;
        }
    }

    /**
     * Store or Update user base on request method.
     */
    public function save() {
        switch (request()->method()) {
            case 'POST':
                $this->createUser();
                break;

            case 'PATCH':
                $this->updateUser();
                break;

            default:
                break;
        }
    }

    protected function createUser() {
        // random generate password
        $password = str_random(8);

        $user = User::create([
            'name' => request('name'),
            'email' => request('email'),
            'church_id' => request('church'),
            'level_id' => request('level'),
            'password' => Hash::make($password),
        ]);
        $user->assignRoleById(request('role'));
        Mail::to($user)->send(new WelcomeMail($user, $password));
    }

    protected function updateUser() {
        $user = User::findOrFail($this->user->id);
        $user->name = request('name');
        $user->email = request('email');

        if (request('church') != '') {
            $user->church_id = request('church');
        }

        if (request('password') != '') {
            $user->password = Hash::make(request('password'));
        }

        if (request('level') != '') {
            $user->level_id = request('level');
        }

        $user->update();

        if (request('role') != '') {
            $user->roles()->sync([request('role')]);
        }
    }
}
