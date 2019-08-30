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

class RegisterNetworkRequest extends FormRequest {
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

    public function save() {
        $password = str_random(10);
        // create network
        $network = Network::create(['uuid' => (string) Uuid::generate(4)]);

        // create church
        // link church to network
        // $church = Church::create([
        //     'uuid' => (string) Uuid::generate(4),
        //     'network_uuid' => $network->uuid,
        //     'state' => request('state'),
        //     'district' => request('district'),
        //     'city' => request('city'),
        //     'country_id' => request('country_id')
        // ]);

        // create user
        $user = User::create([
            'email' => request('email'),
            'password' => Hash::make($password),
            'church_id' => $church->id
        ]);
        // assign role network leader
        $user->assignRoleById(3);
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
