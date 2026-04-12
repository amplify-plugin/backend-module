<?php

namespace Amplify\System\Backend\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Backpack\CRUD\app\Library\Auth\AuthenticatesUsers;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Prologue\Alerts\Facades\Alert;

/**
 * @overwrite \Backpack\CRUD\app\Http\Controllers\Auth\LoginController
 */
class LoginController extends Controller
{
    protected $data = []; // the information we send to the view

    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    public string $loginPath;

    public string $redirectTo;

    public string $redirectAfterLogout;

    use AuthenticatesUsers {
        logout as defaultLogout;
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $guard = backpack_guard_name();

        $this->middleware("guest:$guard", ['except' => 'logout']);

        // ----------------------------------
        // Use the admin prefix in all routes
        // ----------------------------------

        // If not logged in redirect here.
        $this->loginPath = backpack_url('login');

        // Redirect here after successful login.
        $this->redirectTo = backpack_url('dashboard');

        // Redirect here after logout.
        $this->redirectAfterLogout = backpack_url('login');
    }

    /**
     * Return custom username for authentication.
     *
     * @return string
     */
    public function username()
    {
        return backpack_authentication_column();
    }

    /**
     * The user has logged out of the application.
     *
     * @return mixed
     */
    protected function loggedOut(Request $request)
    {
        return redirect($this->redirectAfterLogout);
    }

    /**
     * Get the guard to be used during logout.
     *
     * @return StatefulGuard
     */
    protected function guard()
    {
        return backpack_auth();
    }

    /**
     * The after user has been authenticated.
     *
     * @overwrite Backpack\CRUD\app\Library\Auth\AuthenticatesUsers::authenticated
     *
     * @param  mixed  $user
     * @return void|RedirectResponse
     */
    protected function authenticated(Request $request, $user)
    {
        if (! $user->enabled) {
            auth(backpack_guard_name())->logout();
            Alert::warning('This user is not permitted Login to system')->flash();

            return redirect()->route('backpack.auth.login');
        }

        if ($user->password_reset_required == '1') {
            return redirect()->route('admin.force-password.reset', $user);
        }
    }
}
