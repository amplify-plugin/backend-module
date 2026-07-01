<?php

namespace Amplify\System\Backend\Http\Requests;

use Amplify\System\Backend\Rules\ContactIsAdminRule;
use Amplify\System\Helpers\SecurityHelper;
use Illuminate\Foundation\Http\FormRequest;

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
            'is_admin' => [
                'nullable',
                'boolean',
                new ContactIsAdminRule($this->isMethod('PUT') ? $this->id : null),
            ],
            'enabled' => 'nullable|boolean',
            'enabled_at' => 'nullable',
        ];

        $passLength = SecurityHelper::passwordLength();
        $isUpdating = $this->isMethod('PUT')
            || $this->isMethod('PATCH')
            || (bool) $this->route('id');

        if ($isUpdating) {
            $contactId = $this->route('id') ?? $this->id;
            $this->rules['password'] = "nullable|min:$passLength|confirmed";
            $this->rules['email'] = 'required|email|unique:contacts,email,' . $contactId;
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
        $roles = [];
        $inputRoles = ! empty($this->input('roles')) ? $this->input('roles') : [];
        $inputPermissions = ! empty($this->input('permissions')) ? $this->input('permissions') : [];

        if (config('permission.teams')) {
            foreach ($inputRoles as $role) {
                $roles[$role]['team_id'] = $this->input('customer_id');
            }
        } else {
            $roles = $inputRoles;
        }


        $permissions = [];

        if (config('permission.teams')) {
            foreach ($inputPermissions as $permission) {
                $permissions[$permission]['team_id'] = $this->input('customer_id');
            }
        } else {
            $permissions = $inputPermissions;
        }

        $this->merge([
            'roles' => $roles,
            'permissions' => $permissions,
            'password_reset_required' => ($this->has('password') && $this->input('password') != null),
        ]);
    }
}
