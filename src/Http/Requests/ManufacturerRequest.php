<?php

namespace Amplify\System\Backend\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ManufacturerRequest extends FormRequest
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
            'code' => 'nullable|string|max:50|unique:manufacturers,code,'.request('id').',id',
            'name' => 'required|string',
            'featured' => 'nullable|integer',
            'image' => 'nullable',
            'contact_name' => 'nullable|string',
            'contact_email' => 'nullable|email:rfc,dns',
            'contact_phone' => 'nullable|string',
        ];
    }
}
