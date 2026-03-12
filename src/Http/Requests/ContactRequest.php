<?php

namespace Amplify\System\Backend\Http\Requests;

use Amplify\System\Helpers\SecurityHelper;
use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{
    private $rules = [
        'customer_id' => 'required',
        'contact_code' => 'nullable|string',
        'name' => 'required|string',
        'phone' => 'nullable|string',
        'order_limit' => 'required|integer|min:0',
        'daily_budget_limit' => 'required|integer|min:0',
        'monthly_budget_limit' => 'required|integer|min:0',
        'spend_today' => 'nullable',
        'spend_this_month' => 'nullable',
        'password_reset_required' => 'nullable',
        'redirect_route' => 'required',
        'roles' => 'nullable',
        'permissions' => 'nullable',
        'warehouse_id' => 'nullable|integer',
        'contactLogins' => 'nullable|array',
        'contactLogins.*.customer_id' => 'required|integer',
        'contactLogins.*.warehouse_id' => 'nullable|integer',
        'contactLogins.*.customer_address_id' => 'nullable|integer',
        'contactLogins.*.roles' => 'required_without:contactLogins.*.permissions',
    ];

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
        // on update statement
        if ($this->isMethod('PUT')) {
            $this->rules['password'] = "nullable|min:$passLength|confirmed";
            $this->rules['email'] = 'required|email|unique:contacts,email,'.$this->id;
        } else {
            $this->rules['email'] = 'required|email|unique:contacts';
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
        ]);
    }
}
