<?php

namespace Amplify\System\Backend\Http\Requests;

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
        $id = $this->get('id') ?? request()->route('id');
        $passLength = SecurityHelper::passwordLength();

        return [
            'email' => ['required', Rule::unique(config('permission.table_names.users', 'users'), 'email')->ignore($id)],
            'name' => 'required|string|min:2|max:255',
            'password' => ((request()->route()->getName() == 'user.update') ? 'nullable' : 'required').'|confirmed|min:'.$passLength,
            'password_reset_required' => 'nullable|boolean',
            'roles' => 'nullable',
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
