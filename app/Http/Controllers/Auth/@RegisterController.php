<?php
//
// namespace App\Http\Controllers\Auth;
//
// use Mail;
// use App\User;
// use App\Mail\Welcome;
// use App\Http\Controllers\Controller;
// use Illuminate\Support\Facades\Hash;
// use Illuminate\Support\Facades\Validator;
// use Illuminate\Foundation\Auth\RegistersUsers;
// use Illuminate\Http\Request;
// use Illuminate\Auth\Events\Registered;
//
// class RegisterController extends Controller
// {
//     /*
//     |--------------------------------------------------------------------------
//     | Register Controller
//     |--------------------------------------------------------------------------
//     |
//     | This controller handles the registration of new users as well as their
//     | validation and creation. By default this controller uses a trait to
//     | provide this functionality without requiring any additional code.
//     |
//     */
//
//     use RegistersUsers;
//
//     /**
//     * Where to redirect users after registration.
//     *
//     * @var string
//     */
//     protected $redirectTo = '/users';
//
//     /**
//     * Create a new controller instance.
//     *
//     * @return void
//     */
//     public function __construct()
//     {
//         $this->middleware('auth');
//     }
//
//     /**
//     * Get a validator for an incoming registration request.
//     *
//     * @param  array  $data
//     * @return \Illuminate\Contracts\Validation\Validator
//     */
//     protected function validator(array $data)
//     {
//         return Validator::make($data, [
//             'name' => 'required|string|max:255',
//             'email' => 'required|string|email|max:255|unique:users',
//             // 'password' => 'required|string|min:6|confirmed',
//         ]);
//     }
//
//     /**
//     * Create a new user instance after a valid registration.
//     *
//     * @param  array  $data
//     * @return \App\User
//     */
//     protected function create(array $data)
//     {
//         // randomize password
//         $password = str_random(8);
//         $user = User::create([
//             'name' => $data['name'],
//             'email' => $data['email'],
//             'password' => Hash::make($password),
//         ]);
//
//         // send mail
//         Mail::to($user)->send(new Welcome($user, $password));
//
//         return $user;
//     }
//
//     public function register(Request $request)
//     {
//         $this->validator($request->all())->validate();
//
//         event(new Registered($user = $this->create($request->all())));
//         session()->flash('success', 'User successfully registered');
//         return $this->registered($request, $user) ?: redirect($this->redirectPath());
//     }
// }
