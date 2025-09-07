<?php

namespace Amplify\System\Backend\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerProductRequest extends FormRequest
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
            'customer_id' => 'required|integer|min:1',
            'customer_address_id' => 'required|integer|min:1',
            'product_id' => 'required|integer|min:1',
            'customer_product_code' => 'required|string',
            'customer_product_uom' => 'required|string',
        ];
    }
}
