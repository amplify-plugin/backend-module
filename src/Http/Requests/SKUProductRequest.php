<?php

namespace Amplify\System\Backend\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SKUProductRequest extends FormRequest
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
        // $rules['sku_id'] = 'required|alpha_dash|unique:products,sku_id,'.request()->id.',id,deleted_at,NULL';
        $rules['product_name'] = 'required|min:5|max:255';
        $rules['product_type'] = 'required';
        $rules['product_code'] = 'required|
        min:5|
        max:20|
        unique:products,product_code,'.request()->id.',id,deleted_at,NULL';
        $rules['selling_price'] = 'nullable|numeric|gt:0';

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
        $rules = [];
        $rules['sku_id.required'] = 'The SKU Id field is required.';
        $rules['product_name.required'] = 'The SKU name field is required.';
        $rules['product_name.min'] = 'The SKU name field must be at least 5 characters.';
        $rules['product_name.max'] = 'The SKU name field must not be greater than 255 characters.';
        $rules['product_type.required'] = 'The SKU type field is required.';
        $rules['product_code.required'] = 'The SKU code field is required.';
        $rules['product_code.unique'] = 'TThe SKU code has already been taken.';
        $rules['product_code.min'] = 'The SKU code field must be at least 5 characters.';
        $rules['product_code.max'] = 'The SKU code field must not be greater than 20 characters.';
        $rules['selling_price.gt'] = 'The Price must not be negative number.';

        return $rules;
    }
}
