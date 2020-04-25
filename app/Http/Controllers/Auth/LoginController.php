<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Http\Request;
use App\Repositories\AuditRepositoryInterface;

class LoginController extends Controller
{
    use AuthenticatesUsers;
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    private $auditRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(AuditRepositoryInterface $auditRepositoryInterface)
    {
        $this->middleware('guest')->except('logout');
        $this->auditRepository = $auditRepositoryInterface;
    }

    public function login(Request $request) {
        // if too many login attemps
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }
        
        if ($this->attemptLogin($request)) {
            $this->clearLoginAttempts($request);
            $this->auditRepository->create($request, 'auth', 'login');
            return redirect()->intended('dashboard');
        }

        // if unsuccessful, increase login attempt count
        // lock user count limit reached
        $this->incrementLoginAttempts($request);
        return $this->sendFailedLoginResponse($request);
    }
}
