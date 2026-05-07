<?php

namespace Amplify\System\Backend\Http\Requests;

use Amplify\System\Backend\Models\User;
use Amplify\System\Helpers\SecurityHelper;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
            'email' => ['required',
                Rule::unique('users', 'email')
                    ->ignore($this->get('id', request()->route('id')))
            ],
            'name' => 'required|string|min:2|max:255',
            'password' => ((request()->route()->getName() == 'user.update') ? 'nullable' : 'required').'|confirmed|min:'.$passLength,
            'password_reset_required' => 'nullable|boolean',
            'roles' => ['nullable', 'array', 'min:1'],
            'roles.*' => ['integer', Rule::exists('roles', 'id')->where(function ($query) {
                $query->where('guard_name', User::AUTH_GUARD);
            })],
            'permissions' => 'nullable',
            'type' => 'string|nullable',
            'image' => 'nullable|image|max:1024',
        ];

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
        ]);

        if (empty($this->input('password'))) {
            $this->offsetUnset('password');
            $this->offsetUnset('password_confirmation');
        }
    }
}
