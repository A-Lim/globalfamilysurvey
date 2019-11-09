<?php

namespace App\Http\Requests\Surveys;

use DB;
use App\Survey;
use App\Question;
use Illuminate\Foundation\Http\FormRequest;

class RetrieveRequest extends FormRequest
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
            'url' => 'sometimes|required|string',
            'survey_id' => 'sometimes|required',
            'type' => 'sometimes|required|string|in:'.implode(',', Survey::TYPES)
        ];
    }

    public function attributes() {
        return [
        ];
    }
}
