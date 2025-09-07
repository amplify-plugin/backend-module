<?php

namespace Amplify\System\Backend\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AttributeRequest extends FormRequest
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
            'name' => 'required|string|unique:attributes,name,'.request()->id.',id,deleted_at,NULL',
            'slug' => 'required|alpha_dash|unique:attributes,slug,'.request()->id.',id,deleted_at,NULL',
            'type' => 'required',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge(['name' => json_encode($this->input('name'))]);
    }

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'name' => 'Display Name',
            'slug' => 'Attribute Name',
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
