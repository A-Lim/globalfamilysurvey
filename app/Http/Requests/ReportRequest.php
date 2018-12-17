<?php

namespace App\Http\Requests;

use App\Report;
use Illuminate\Foundation\Http\FormRequest;

class ReportRequest extends FormRequest
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
            'leader_question'  => 'required|exists:questions,id',
            'member_question' => 'required|exists:questions,id',
        ];
    }

    public function save() {
        $data = array(
            'name' => request('name'),
            'leader_question_id' => request('leader_question'),
            'member_question_id' => request('member_question'),
        );

        switch ($this->method()) {
            case 'POST':
                $report = Report::create($data);
                break;

            case 'PATCH':
                $this->report->update($data);
                break;

            default:
                break;
        }
    }
}
