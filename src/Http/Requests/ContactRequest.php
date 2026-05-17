<?php

namespace Amplify\System\Backend\Http\Requests;

use Amplify\System\Backend\Models\Contact;
use Amplify\System\Helpers\SecurityHelper;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class ContactRequest extends FormRequest
{
    private $rules = [];

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
        $this->rules = [
            'customer_id' => 'required|integer|exists:customers,id',
            'contact_code' => 'nullable',
            'name' => 'required|string',
            'phone' => 'nullable|string',
            'account_title_id' => 'nullable|integer|exists:account_titles,id',
            'order_limit' => 'nullable|integer|min:0',
            'daily_budget_limit' => 'nullable|integer|min:0',
            'monthly_budget_limit' => 'nullable|integer|min:0',
            'spend_today' => 'nullable|numeric|min:0',
            'spend_this_month' => 'nullable|numeric|min:0',
            'password_reset_required' => 'nullable',
            'redirect_route' => 'required',
            'roles' => config('amplify.basic.is_permission_system_enabled') ? ['required', 'array', 'min:1'] : ['nullable'],
            'roles.*' => config('amplify.basic.is_permission_system_enabled') ? ['integer', 'exists:roles,id'] : ['nullable'],
            'permissions' => 'nullable',
            'warehouse_id' => 'nullable|integer',
            'contactLogins' => 'nullable|array',
            'contactLogins.*.customer_id' => 'required|integer',
            'contactLogins.*.warehouse_id' => 'nullable|integer',
            'contactLogins.*.customer_address_id' => 'nullable|integer',
            'contactLogins.*.roles' => 'required_without:contactLogins.*.permissions',
            'is_admin' => 'nullable|boolean',
        ];

        $passLength = SecurityHelper::passwordLength();
        // on update statement
        if ($this->isMethod('PUT')) {
            $this->rules['password'] = "nullable|min:$passLength|confirmed";
            $this->rules['email'] = 'required|email|unique:contacts,email,' . $this->id;
        } else {
            $this->rules['email'] = 'required|email|unique:contacts';
            $this->rules['password'] = "required|min:$passLength|confirmed";
        }

        $this->rules['password_reset_required'] = ['required', 'boolean'];

        return $this->rules;
    }

    /**
     * Configure the validator instance to enforce admin contact rules:
     *  - A customer's only contact cannot be set as non-admin.
     *  - A customer can have at most one admin contact.
     *
     * @return void
     */
    public function withValidator(Validator $validator)
    {
        $validator->after(function (Validator $validator) {
            $customerId = $this->input('customer_id');

            if (empty($customerId)) {
                return;
            }

            $isAdmin = $this->boolean('is_admin');
            $contactId = $this->isMethod('PUT') ? $this->id : null;

            $otherContactsQuery = Contact::where('customer_id', $customerId);

            if ($contactId) {
                $otherContactsQuery->where('id', '!=', $contactId);
            }

            $otherContactsCount = (clone $otherContactsQuery)->count();
            $otherAdminExists = (clone $otherContactsQuery)->where('is_admin', true)->exists();

            if (! $isAdmin && $otherContactsCount === 0) {
                $message = $contactId
                    ? 'This is the only contact for the customer and must remain the admin.'
                    : 'The first contact for a customer must be set as admin.';

                $validator->errors()->add('is_admin', $message);
            }

            if ($isAdmin && $otherAdminExists) {
                $validator->errors()->add(
                    'is_admin',
                    'This customer already has an admin contact. Only one admin contact is allowed per customer.'
                );
            }
        });
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $roles = [];

        if (config('permission.teams')) {
            foreach ($this->input('roles', []) as $role) {
                $roles[$role]['team_id'] = $this->input('customer_id');
            }
        } else {
            $roles = $this->input('roles', []);
        }


        $permissions = [];

        if (config('permission.teams')) {
            foreach ($this->input('permissions', []) as $permission) {
                $permissions[$permission]['team_id'] = $this->input('customer_id');
            }
        } else {
            $permissions = $this->input('permissions', []);
        }

        $this->merge([
            'roles' => $roles,
            'permissions' => $permissions,
            'password_reset_required' => ($this->has('password') && $this->input('password') != null),
        ]);
    }
}
