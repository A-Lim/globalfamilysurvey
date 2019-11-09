<?php

namespace App\Http\Requests\Report;

use App\Report;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            'name' => 'required|string',
            'leader_question_id'  => 'required|exists:questions,id',
            'member_question_id' => 'required|exists:questions,id',
        ];
    }

    public function attributes() {
        return [
            'leader_question_id' => 'leaders\'s question',
            'member_question_id' => 'member\'s question'
        ];
    }
}
