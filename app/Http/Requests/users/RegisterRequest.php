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
        $data = request()->input();
        // level_id 4 (none)
        $data['level_id'] = 4;
        $data['password'] = Hash::make($password);
        $data['verified'] = false;

        $user = User::create($data);

        // assign role user
        $user->assignRoleById(3);
        // Mail::to($user)->send(new WelcomeMail($user, $password));
    }
}
