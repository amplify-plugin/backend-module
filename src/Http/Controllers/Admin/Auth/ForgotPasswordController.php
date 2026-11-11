<?php

namespace Amplify\System\Backend\Http\Controllers\Admin\Auth;

use Amplify\System\Backend\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Backpack\CRUD\app\Http\Controllers\Auth\ForgotPasswordController as BackpackForgotPasswordController;
use Prologue\Alerts\Facades\Alert;

class ForgotPasswordController extends BackpackForgotPasswordController
{
    /**
     * Send a reset link to the given user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function sendResetLinkEmail(Request $request)
    {
        $this->validateEmail($request);

        $user = User::query()
            ->whereEmail($request->input('email'))
            ->whereEnabled(true)
            ->first();

        if (!$user) {
            return $this->sendResetLinkFailedResponse(
                $request,
                'No account found or account suspended. Please contact your administrator.'
            );
        }


        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $response = $this->broker()->sendResetLink(
            $this->credentials($request)
        );

        return $response == Password::RESET_LINK_SENT
                    ? $this->sendResetLinkResponse($request, $response)
                    : $this->sendResetLinkFailedResponse($request, $response);
    }

    /**
     * Validate the email for the given request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function validateEmail(Request $request)
    {
        $request->validate(['email' => 'required|email:dns,rfc|exists:users,email']);
    }
}
