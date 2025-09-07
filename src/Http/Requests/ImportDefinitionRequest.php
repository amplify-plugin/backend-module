<?php

namespace Amplify\System\Backend\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImportDefinitionRequest extends FormRequest
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
        // dd(request()->all());
        $rules = [];
        $rules['name'] = 'required|string|min:3|max:255';
        $rules['file_type'] = 'required|string';
        $rules['import_type'] = 'required|string';
        $rules['column_mapping'] = 'required';
        if (request()->has_hierarchy) {
            $rules['import_file_field'] = 'required';
            $rules['import_type_field'] = 'required';
        }

        return $rules;
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
            'column_mapping.required' => 'Please insert demo file.',
        ];
    }
}
