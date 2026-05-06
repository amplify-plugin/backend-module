<?php

namespace Amplify\System\Backend\Http\Requests;

use Amplify\System\Backend\Models\Contact;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CustomerPermissionRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255',
                Rule::unique('permissions')
                    ->ignore($this->route('id'))
                    ->where(function ($query) {
                        return $query->where('guard_name', Contact::AUTH_GUARD)
                            ->when(config('permission.teams'),
                                fn($query) => $query->where('team_id', $this->input('team_id'))
                            );
                    }),
            ],
            'is_default' => 'boolean',
            'team_id' => (config('permission.teams')) ? 'required|exists:customers,id' : 'nullable',
        ];
    }
}
