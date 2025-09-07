<?php

namespace Amplify\System\Backend\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
            'orderLines.*.backpackProduct' => 'required',
            'orderLines.*.warehouse_id' => 'required',
            'orderLines.*.qty' => 'required|numeric',
            'orderLines.*.customer_price' => 'required|numeric',
            'orderLines.*.subTotal' => 'required|numeric',
            'draft_name' => 'nullable|string|max:255',
            'customer_id' => 'nullable|string|max:255',
            'contact_id' => 'nullable|string|max:255',
            'erp_order_id' => 'nullable|string|max:255',
            'orderNotes.*.note' => 'nullable|string|max:255',
            'orderNotes.*.subject' => 'nullable|string|max:255',
            'web_order_number' => 'required|numeric',
            'customer_order_number' => 'nullable|string|max:255',
            'total_net_price' => 'nullable|numeric',
            'total_tax_amount' => 'nullable|numeric',
            'total_shipping_cost' => 'nullable|numeric',
            'total_shipping_cost' => 'nullable|numeric',
            'total_amount' => 'nullable|numeric',
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
            'orderLines.*.qty' => 'The orderLines Quantity must be a number.',
            'orderLines.*.customer_price' => 'The orderLines Unit Price must be a number.',
            'orderLines.*.subTotal' => 'The orderLines Sub Total must be a number.',
        ];
    }
}
