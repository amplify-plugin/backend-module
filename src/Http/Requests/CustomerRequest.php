<?php

namespace Amplify\System\Backend\Http\Requests;

use Amplify\System\Backend\Models\Customer;
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
            'customer_code' => 'required|string',
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

            // contact validate
            'contact' => 'required|array|min:1',
            'contact.*.name' => 'required|string',
            'contact.*.phone' => 'required|string',
            'contact.*.profile_image' => 'nullable|string',
            'contact.*.password' => "required|min:$minPassLen|same:contact.*.password_confirmation",
            'contact.*.password_confirmation' => "required|min:$minPassLen",
            'contact.*.order_limit' => 'required|numeric|min:0',
            'contact.*.daily_budget_limit' => 'required|numeric|min:0',
            'contact.*.monthly_budget_limit' => 'required|numeric|min:0',
            'contact.*.spend_today' => 'required|numeric|min:0',
            'contact.*.spend_this_month' => 'required|numeric|min:0',
            'addresses' => 'nullable|array',
            'addresses.*.address_name' => 'required|string',
            'addresses.*.address_code' => 'required|string',
            'addresses.*.address_1' => 'required|string',
            'addresses.*.address_2' => 'nullable|string',
            'addresses.*.address_3' => 'nullable|string',
            'addresses.*.city' => 'required|string',
            'addresses.*.state' => 'required|string',
            'addresses.*.country_code' => 'nullable|string',
            'addresses.*.zip_code' => 'required|string',
        ];

        // on update statement
        if ($this->method() == 'PUT') {
            $rules['contact.*.password'] = "nullable|min:$minPassLen|same:contact.*.password_confirmation";
            $rules['contact.*.password_confirmation'] = "nullable|min:$minPassLen";
            $contactId = Customer::find(request()->route('id'))->contact->id ?? 'null';
            $rules['contact.*.email'] = 'required|email|unique:contacts,email,'.$contactId;
        } else {
            $rules['contact.*.email'] = 'required|email|unique:contacts,email';
        }

        return $rules;
    }
}
