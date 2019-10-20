<?php

namespace App\Http\Requests\Categories;

use App\Category;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
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
            'question_ids'  => 'required|exists:questions,id',
            'sequence' => 'required|numeric'
        ];
    }

    public function attributes() {
        return [
            'question_ids' => 'questions',
        ];
    }

    public function messages() {
        return [
            'questions.exists' => 'The selected question(s) is/are invalid.'
        ];
    }
}
