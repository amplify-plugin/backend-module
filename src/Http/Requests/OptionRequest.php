<?php

namespace Amplify\System\Backend\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OptionRequest extends FormRequest
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
        $rules = [];
        $rules['option_name'] = 'required|string|min:3|max:255';
        $rules['is_required'] = 'required|boolean';
        $rules['description'] = 'required|string';
        $rules['option_type'] = 'required';
        $rules['default_value'] = 'nullable';
        $rules['limit_max'] = 'nullable|numeric|min:0';
        $rules['limit_min'] = 'nullable|numeric|min:0';
        $rules['limit_choices'] = 'nullable';
        if (request()->option_type === 'boolean') {
            $rules['value_type'] = 'required';
        }

        return $rules;
    }

    protected function prepareForValidation()
    {
        $this->merge(['option_name' => json_encode($this->input('option_name'))]);
    }

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            //
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            //
        ];
    }
}
