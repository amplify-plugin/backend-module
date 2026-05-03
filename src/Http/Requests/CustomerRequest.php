<?php

namespace Amplify\System\Backend\Http\Requests;

use Amplify\System\Backend\Models\Customer;
use Amplify\System\Backend\Rules\ErpCustomerExist;
use Amplify\System\Helpers\SecurityHelper;
use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
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
        $minPassLen = SecurityHelper::passwordLength();

        $rules = [
            // customer validate
            'customer_code' => ['string', (config('amplify.erp.auto_create_cash_customer')) ? 'nullable' : 'required', new ErpCustomerExist],
            'customer_name' => 'required|string',
            'email' => 'nullable|email',
            'phone' => 'nullable|numeric',
            'punch_out' => 'nullable',
            'customer_type' => 'nullable',
            'is_suspended' => 'boolean|nullable',
            'warehouse_seq_code' => 'string|nullable',
            'address_1' => 'required|string',
            'address_2' => 'nullable|string',
            'address_3' => 'nullable|string',
            'city' => 'nullable|string',
            'state' => 'nullable|string',
            'country_code' => 'nullable|string',
            'zip_code' => 'nullable|string',
            'list_price' => 'nullable|string|in:' . implode(array_keys(Customer::LIST_PRICES)),
        ];

        return $rules;
    }
}
