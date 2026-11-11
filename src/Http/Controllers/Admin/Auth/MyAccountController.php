<?php

namespace Amplify\System\Backend\Http\Controllers\Admin\Auth;

use Alert;
use Backpack\CRUD\app\Http\Requests\AccountInfoRequest;
use Backpack\CRUD\app\Http\Controllers\MyAccountController as BackpackMyAccountController;
use Illuminate\Foundation\Validation\ValidatesRequests;

class MyAccountController extends BackpackMyAccountController
{
    use ValidatesRequests;

    /**
     * Save the modified personal information for a user.
     */
    public function postAccountInfoForm(AccountInfoRequest $request)
    {
        $request->validate([
            'image' => 'image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        $result = $this->guard()->user()->update($request->except('_token', '_method', 'current_password'));

        ($result)
            ? Alert::success(trans('backpack::base.account_updated'))->flash()
            : Alert::error(trans('backpack::base.error_saving'))->flash();

        return redirect()->back();
    }
}
