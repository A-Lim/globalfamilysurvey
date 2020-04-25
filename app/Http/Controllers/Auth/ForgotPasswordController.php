<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

use App\Repositories\AuditRepositoryInterface;

class ForgotPasswordController extends Controller
{
    use SendsPasswordResetEmails;

    private $auditRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(AuditRepositoryInterface $auditRepositoryInterface)
    {
        $this->middleware('guest');
        $this->auditRepository = $auditRepositoryInterface;
    }

    public function sendResetLinkEmail(Request $request)
    {
        $this->validateEmail($request);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $response = $this->broker()->sendResetLink(
            $request->only('email')
        );

        if ($response == Password::RESET_LINK_SENT) {
            $this->auditRepository->create($request, 'auth', 'forgot-password');
            return $this->sendResetLinkResponse($request, $response);
        }

        return $this->sendResetLinkFailedResponse($request, $response);
    }
}
