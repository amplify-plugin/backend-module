<?php

namespace Amplify\System\Backend\Http\Controllers;

use Amplify\System\Backend\Models\Contact;
use Amplify\System\Backend\Models\Event;
use Amplify\System\Factories\NotificationFactory;
use Amplify\System\Helpers\SecurityHelper;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PasswordResetController extends Controller
{
    //

    public function sendOtp(Request $request)
    {
        try {

            $contact = Contact::where('email', $request->email)->first();
            if ($contact) {
                $otp = mt_rand(100000, 999999);
                NotificationFactory::call(Event::RESET_PASSWORD, [
                    'otp' => $otp,
                    'contact_id' => $contact->id,
                ]);
                $contact->otp = $otp;
                $contact->save();

                return response([
                    'message' => 'OTP Send To Your Mail',
                ]);
            } else {
                return response([
                    'message' => 'Email Is Not Registered',
                ], 210);
            }

        } catch (Exception $ex) {
            return response()->json(['exception' => $ex->errorInfo ?? $ex->getMessage()], 422);
        }

    }

    public function otpCheck(Request $request)
    {

        $contact = Contact::where([['email', $request->email], ['otp', $request->otp]])->first();
        if ($contact) {
            return response([
                'message' => 'Valid OTP',
            ]);
        } else {
            return response([
                'message' => 'Invalid OTP',
            ], 210);
        }
    }

    public function resetPassword(Request $request)
    {
        $passLength = SecurityHelper::passwordLength();
        $request->validate([
            'password' => "required|min:$passLength",
        ]);

        $contact = Contact::where([['email', $request->email], ['otp', $request->otp]])->first();

        if ($contact) {
            $contact->password = $request->password;
            $contact->save();

            return response([
                'success' => true,
                'message' => 'Your Password Reset is successful.',
            ]);
        } else {
            Session::flash('error', 'Your Password Reset is failed.');

            return response([
                'success' => false,
                'message' => 'Contact Not Found',
            ], 210);

        }
    }
}
