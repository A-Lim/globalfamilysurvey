<?php
namespace App\Http\Requests\Submission;

use App\Submission;
use Illuminate\Foundation\Http\FormRequest;

class PullSubmissionRequest extends FormRequest {

    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            'type' => 'required|in:'.implode(',', Submission::REQ_TYPES),
        ];
    }

    public function messages() {
        return [
            'type.required' => 'Please select a submission pull type.',
            'body.in'  => 'Submission pull type is invalid.',
        ];
    }
}
