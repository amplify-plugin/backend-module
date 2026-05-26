<?php

namespace Amplify\System\Backend\Http\Requests;

use Amplify\System\Backend\Models\Contact;
use Amplify\System\Backend\Rules\DefaultCustomerRole;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CustomerRoleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return backpack_auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('roles')
                    ->ignore($this->route('id'))
                    ->where(function ($query) {
                        return $query->where('guard_name', Contact::AUTH_GUARD)
                            ->where('team_id', $this->input('team_id'));
                    }),
            ],
            'is_default' => ['nullable', 'boolean', new DefaultCustomerRole($this->route('id'))],
            'team_id' => (config('permission.teams')) ? ['required', "exists:customers,id"] : ['nullable'],
        ];
    }
}
