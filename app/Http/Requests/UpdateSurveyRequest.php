<?php

namespace App\Http\Requests;

use DB;
use App\Survey;
use App\Question;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSurveyRequest extends FormRequest
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
            'survey_id' => 'required',
            'type' => 'required|string|in:'.implode(',', Survey::TYPES)
        ];
    }

    public function save($content) {
        DB::beginTransaction();
        $json = json_decode($content);
        Survey::saveFromJson(request('name'), request('type'), $json);
        Question::saveFromJson($json);
        DB::commit();
    }

    public function messages() {
        return [
        ];
    }
}
