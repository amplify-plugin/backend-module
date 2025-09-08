<?php

namespace Amplify\System\Backend\Http\Controllers;

use Amplify\System\Backend\Models\Contact;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PunchOutController extends Controller
{
    public function login(Request $request)
    {
        $contact = Contact::where('hashkey', $request->auth_key)->first();
        if ($contact) {
            Auth::guard('customer')->login($contact);
            $token = Str::random(32);
            $contact->hashkey = $token;
            $contact->save();

            return redirect()->intended(route('frontend.index'));
        } else {
            return 'No token found';
        }
    }
}
