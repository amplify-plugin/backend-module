<?php

namespace Amplify\System\Backend\Http\Controllers\Admin\Auth;

use Amplify\System\Backend\Models\User;
use Backpack\CRUD\app\Http\Controllers\Auth\LoginController as BackpackLoginController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Prologue\Alerts\Facades\Alert;

class LoginController extends BackpackLoginController
{

    /**
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    protected function authenticated(Request $request, $user)
    {
        if (!$user->enabled) {

            $response = $this->logout($request);

            Alert::warning("Your account is suspended. Please contact your administrator.")->flash();

            return $response;
        }

        return $request->wantsJson()
            ? new Response('', 204)
            : redirect()->intended($this->redirectPath());
    }
}
