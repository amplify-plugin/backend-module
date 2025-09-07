<?php

namespace Amplify\System\Backend\Http\Requests\Orders;

use Illuminate\Foundation\Http\FormRequest;

class QuickOrderAddToOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'products' => 'required|array',
            'products.*.product_code' => 'required',
            'products.*.product_warehouse_code' => 'nullable',
            'products.*.qty' => 'required|numeric|min:1',
            'products.*.source_type' => 'nullable|in:Quote,Promo',
            'products.*.source' => 'required_if:source_type,Quote,Promo',
            'products.*.expiry_date' => 'required_if:source_type,Quote,Promo',
            'products.*.additional_info' => 'required_if:source_type,Quote,Promo|array',
        ];
    }
}
