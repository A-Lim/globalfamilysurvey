<?php
namespace App\Http\Requests\Auth;

use Mail;
use App\User;
use App\Network;
use App\Church;
use App\Role;
use App\Mail\WelcomeMail;

use Webpatser\Uuid\Uuid;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Http\FormRequest;

class RegisterChurchRequest extends FormRequest {
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
        $rules = [
            'network_uuid' => 'nullable|exists:networks,uuid',
            'email' => 'required|email|max:255|unique:users,email,NULL,id,deleted_at,NULL',
            'city' => 'required',
            'district' => 'required',
            'state' => 'required',
            'country_id' => 'required|exists:countries,id',
        ];

        if (env('ACTIVATE_RECAPTCHA', false)) {
            $rules['g-recaptcha-response'] = 'required|recaptcha';
        }

        return $rules;
    }

    public function messages() {
        return [
            'g-recaptcha-response.required' => 'The recaptcha field is required.'
        ];
    }
}
