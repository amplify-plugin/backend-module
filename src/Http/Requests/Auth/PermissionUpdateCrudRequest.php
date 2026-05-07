<?php

namespace Amplify\System\Backend\Http\Requests\Auth;

use Amplify\System\Backend\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PermissionUpdateCrudRequest extends FormRequest
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
        return [
            'name' => [
                'required', 'string', 'max:255',
                Rule::unique(config('permission.table_names.permissions', 'permissions'), 'name')
                    ->ignore($this->route('id'))
                    ->where(fn($query) => $query->where('guard_name', User::AUTH_GUARD))
            ]
        ];
    }
}
