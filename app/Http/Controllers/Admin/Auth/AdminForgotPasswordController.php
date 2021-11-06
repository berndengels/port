<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Models\AdminUser;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class AdminForgotPasswordController extends ForgotPasswordController
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Only guests for "admin" guard are allowed except
     * for logout.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:admin');
    }

    /**
     * Get the broker to be used during password reset.
     *
     * @return PasswordBroker
     */

    public function broker()
    {
        return Password::broker('admin_users');
    }

    public function showLinkRequestForm()
    {
        return view('admin.auth.passwords.email');
    }

    /**
     * Get the response for a successful password reset link.
     *
     * @param  Request $request
     * @param  string  $response
     * @return RedirectResponse|JsonResponse
     */
    protected function sendResetLinkResponse(Request $request, $response)
    {
        return $request->wantsJson()
            ? new JsonResponse(['message' => trans($response)], 200)
            : back()->with('info', trans($response));
    }

    /**
     * Send a reset link to the given user.
     *
     * @param  Request $request
     * @return RedirectResponse|JsonResponse
     */

    public function sendResetLinkEmail(Request $request)
    {
        $this->validateEmail($request);
        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $response = $this->broker()->sendResetLink(
            $this->credentials($request), function (AdminUser $user, $token) {
                return $user->sendPasswordResetNotification($token);
            }
        );

        if($response == Password::RESET_THROTTLED) {
            return redirect()->back()->with('error', Password::RESET_THROTTLED);
        }

        return $response == Password::RESET_LINK_SENT
            ? $this->sendResetLinkResponse($request, $response)
            : $this->sendResetLinkFailedResponse($request, $response);
    }


}
