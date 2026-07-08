<?php

namespace Amplify\System\Backend\Http\Controllers\Admin\Auth;

use Amplify\System\Backend\Http\Requests\ForceUpdatePasswordRequest;
use Amplify\System\Backend\Models\User;
use Illuminate\Routing\Controller;
use Backpack\CRUD\app\Library\Auth\RedirectsUsers;
use Prologue\Alerts\Facades\Alert;

class ForceUpdatePasswordController extends Controller
{
    use RedirectsUsers;

    public function edit(User $user)
    {
        if ($user->id != backpack_user()->id) {
            auth(backpack_guard_name())->logout();

            return redirect()->intended('/');
        }

        return view(backpack_view('base.password_update'), ['user' => backpack_user()]);
    }

    public function update(User $user, ForceUpdatePasswordRequest $request)
    {
        if ($user->update(['password' => \Hash::make($request->input('password')), 'password_reset_required' => false])) {

            Alert::success('Password Update successful.');

            return redirect()->intended($this->redirectPath());
        }

        return redirect('admin/dashboard');
    }

    public function redirectTo()
    {
        return backpack_url();
    }
}
