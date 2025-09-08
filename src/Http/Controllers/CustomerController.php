<?php

namespace Amplify\System\Backend\Http\Controllers;

use Amplify\System\Helpers\SecurityHelper;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    /**
     * @return Application|RedirectResponse|Redirector
     */
    public function customerLogout()
    {
        $customer_number = customer()->customer_code;

        if (Cache::has("getCustomerDetails-{$customer_number}")) {
            Cache::forget("getCustomerDetails-{$customer_number}");
        }

        if (Cache::has("getCustomerShippingLocationList-{$customer_number}")) {
            Cache::forget("getCustomerShippingLocationList-{$customer_number}");
        }

        auth('customer')->logout();

        return redirect('/');
    }

    public function forceResetPassword(Request $request)
    {
        $passLength = SecurityHelper::passwordLength();
        $request->validate([
            'password' => "required|min:$passLength|confirmed",
        ]);

        $contact = customer(true);

        $contact->password = Hash::make($request->password);
        $contact->password_reset_required = false;

        $contact->update();

        Artisan::call('optimize:clear');

        return redirect()->intended(route('frontend.dashboard'));
    }
}
