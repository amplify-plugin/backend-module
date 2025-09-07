<?php

namespace Amplify\System\Backend\Http\Requests;

use Amplify\System\Helpers\SecurityHelper;
use Illuminate\Foundation\Http\FormRequest;

class ForceUpdatePasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // only allow updates if the user is logged in
        return backpack_auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $passLength = SecurityHelper::passwordLength();

        return [
            'password' => "required|confirmed|min:$passLength",
        ];
    }

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            //
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        $passLength = SecurityHelper::passwordLength();

        return [
            'password.confirmed' => 'Passwords did not match !',
            'password.min' => "Password must be at least $passLength characters long!",
            'password.required' => 'The password field is required!',
        ];
    }
}
