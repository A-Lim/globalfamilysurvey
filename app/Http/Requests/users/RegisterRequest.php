<?php

namespace App\Http\Requests\Users;

use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest {
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
        return [
            'name' => 'required|string',
            'email' => 'required|string|email|max:255|unique:users',
            'church' => 'required|exists:churches,id'
        ];
    }

    /**
     * Store or Update user base on request method.
     */
    public function save() {
        $this->createUser();
    }

    protected function createUser() {
        // random generate password
        $password = str_random(8);

        $user = User::create([
            'name' => request('name'),
            'email' => request('email'),
            'church_id' => request('church'),
            // level_id 4 (none)
            'level_id' => 4,
            'password' => Hash::make($password),
            'verified' => false,
        ]);

        // assign role user
        $user->assignRoleById(3);
        // Mail::to($user)->send(new WelcomeMail($user, $password));
    }
}
