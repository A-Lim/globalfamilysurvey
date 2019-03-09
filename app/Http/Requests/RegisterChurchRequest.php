<?php
namespace App\Http\Requests;

use Mail;
use App\User;
use App\Network;
use App\Church;
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
        return [
            'network_uuid' => 'nullable|exists:networks,uuid',
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

    public function save() {
        $password = str_random(10);
        $network_uuid = request()->has('network_uuid') ? request('network_uuid') : null;

        // create church
        // link church to network
        $church = Church::create([
            'uuid' => (string) Uuid::generate(4),
            'network_uuid' => $network_uuid,
            'state' => request('state'),
            'district' => request('district'),
            'city' => request('city'),
            'country_id' => request('country_id')
        ]);

        // create user
        $user = User::create([
            'email' => request('email'),
            'password' => Hash::make($password),
            'church_id' => $church->id
        ]);
        // assign role church pastor
        $user->assignRoleById(4);
        // send mail
        Mail::to($user)->send(new WelcomeMail($user, $password));
    }
    //
    // protected function create_user($password) {
    //     return User::create([
    //
    //     ]);
    // }
}
