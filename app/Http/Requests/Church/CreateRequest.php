<?php
namespace App\Http\Requests\Church;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest {

    public function authorize() {
        // check if user is admin
        return true;
    }

    public function rules() {
        return [
            'district' => 'required|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'country_id' => 'required'
        ];
    }

    public function attributes() {
        return [
            'country_id' => 'country',
        ];
    }
}
