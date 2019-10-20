<?php
namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest {

    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            'name' => 'required|string',
            'email' => 'required|email|max:255|unique:users,email,NULL,id,deleted_at,NULL',
            'role_id'  => 'required|exists:roles,id',
            'church_id' => 'nullable|exists:churches,id'
        ];
    }

    public function attributes() {
        return [
            'role_id' => 'role',
            'church_id' => 'church'
        ];
    }
}
