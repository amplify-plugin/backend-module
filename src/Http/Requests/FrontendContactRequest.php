<?php

namespace Amplify\System\Backend\Http\Requests;

use Amplify\System\Helpers\SecurityHelper;
use Illuminate\Foundation\Http\FormRequest;

class FrontendContactRequest extends FormRequest
{
    private $rules = [
        'customer_id' => 'required',
        'name' => 'required|string',
        'phone' => 'required|max:50',
        'order_limit' => 'required|integer|min:0',
        'daily_budget_limit' => 'required|integer|min:0',
        'monthly_budget_limit' => 'required|integer|min:0',
        'spend_today' => 'nullable',
        'spend_this_month' => 'nullable',
        'password_reset_required' => 'nullable',
        'roles' => 'nullable',
        'permissions' => 'nullable',
        'customer_address_id' => 'nullable',
        'redirect_route' => 'nullable',
    ];

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return customer(true)->canAny('contact.create', 'contact.update');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $passLength = SecurityHelper::passwordLength();
        // on update statement
        if ($this->isMethod('PUT')) {
            $this->rules['password'] = "nullable|min:$passLength|confirmed";
            $this->rules['email'] = 'required|email:rfc,dns|unique:contacts,email,'.request('contact')->id;
        } else {
            $this->rules['email'] = 'required|email:rfc,dns|unique:contacts';
            $this->rules['password'] = "required|min:$passLength|confirmed";
        }

        $this->rules['password_reset_required'] = ['required', 'boolean'];

        return $this->rules;
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'roles' => $this->roles ?? [],
            'permissions' => $this->permissions ?? [],
            'password_reset_required' => ($this->has('password') && $this->input('password') != null),
            'customer_id' => customer(true)->customer_id,
        ]);
    }
}
