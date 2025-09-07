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
            'code' => 'required|string|min:2|max:50|unique:manufacturers,code,'.request('id').',id',
            'name' => 'required|string',
            'featured' => 'nullable|integer',
            'image' => 'nullable',
            'contact_name' => 'nullable|string',
            //            'contact_address' => 'nullable|array',
            //            'contact_address.*.address_name' => 'nullable|string',
            //            'contact_address.*.address' => 'nullable|string',
            //            'contact_address.*.zip_code' => 'nullable|numeric',
            'contact_email' => 'nullable|email:rfc,dns',
            'contact_phone' => 'nullable|string',
        ];
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
            'contact_address.*.address_name' => 'Address Name should be a text for contact address #:position.',
            'contact_address.*.address' => 'Address should be a text for contact address #:position.',
            'contact_address.*.zip_code' => 'Zip code should be numeric for contact address #:position.',
        ];
    }

    //    protected function prepareForValidation()
    //    {
    //        $this->merge([
    //            'contact_address' => array_filter(json_decode($this->input('contact_address'), true)),
    //        ]);
    //    }
    //
    //    protected function passedValidation()
    //    {
    //        $this->merge([
    //            'contact_address' => json_encode($this->input('contact_address'))
    //        ]);
    //    }
}
