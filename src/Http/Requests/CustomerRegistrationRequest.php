<?php

namespace Amplify\System\Backend\Http\Requests;

use Amplify\System\Backend\Models\Customer;
use Amplify\System\Helpers\SecurityHelper;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CustomerRegistrationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return backpack_auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $minPassLen = SecurityHelper::passwordLength();

        $rules = [
            // customer validate
            'customer_code' => ['string'],
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
        ];

        if (config('amplify.erp.auto_create_cash_customer')) {
            $rules['customer_code'][] = 'nullable';
        } else {
            $rules['customer_code'][] = 'required';
        }

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
