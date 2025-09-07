<?php

namespace Amplify\System\Backend\Http\Requests;

use Amplify\System\Helpers\SecurityHelper;
use Illuminate\Foundation\Http\FormRequest;

class CustomerLoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return ! customer_check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $passLength = SecurityHelper::passwordLength();
        $rule = [
            'email' => 'required|email:rfc|exists:contacts,email',
            'password' => "required|min:$passLength",
        ];

        return $rule;
    }
}
