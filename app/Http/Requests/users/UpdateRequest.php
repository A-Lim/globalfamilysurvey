<?php
namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest {

    public function authorize() {
        return true;
    }

    public function rules() {
        // 'name'=>'required|unique:form_types,name,'.$id.',id,deleted_at,NULL',
        // 'email' => 'required|string|email|max:255|unique:users,email,NULL,id,deleted_at,NULL',
        return [
            'name' => 'nullable|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$this->user->id.',id,deleted_at,NULL',
            'role_id'  => 'sometimes|exists:roles,id',
            'church_id' => 'sometimes|exists:churches,id',
            'password' => 'nullable|sometimes|string|min:6|confirmed'
        ];
    }

    public function attributes() {
        return [
            'role_id' => 'role',
            'church_id' => 'church'
        ];
    }
}
