<?php

namespace Amplify\System\Backend\Http\Controllers\Admin\Auth;

use Illuminate\Http\Request;
use Backpack\CRUD\app\Http\Controllers\Auth\ForgotPasswordController as BackpackForgotPasswordController;

class ForgotPasswordController extends BackpackForgotPasswordController
{
    /**
     * Validate the email for the given request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function validateEmail(Request $request)
    {
        $request->validate(['email' => 'required|email:dns,rfc|exists:users,email,enabled,1']);
    }
}
