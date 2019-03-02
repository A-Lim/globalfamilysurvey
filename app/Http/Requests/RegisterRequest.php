<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        // check if user is admin
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'email' => 'required|unique:users,email',
            'city' => 'required',
            'district' => 'required',
            'state' => 'required',
            'country_id' => 'required|exists:countries,id',
            'g-recaptcha-response'=>'required|recaptcha'
        ];
    }

    public function messages() {
        return [
            'g-recaptcha-response.required' => 'The recaptcha field is required.'
        ];
    }
}
