<?php

namespace Amplify\System\Backend\Http\Requests;

use Amplify\System\Backend\Models\Customer;
use Amplify\System\Helpers\SecurityHelper;
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $contactId = Customer::find(request()->route('id'))->contact?->id;
        $passLength = SecurityHelper::passwordLength();

        return [
            // Customer validate
            'customer_code' => ! config('amplify.basic.enable_erp_customer_create') ? 'required|string' : 'nullable',
            'customer_name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
            'punch_out' => 'nullable',
            'customer_type' => 'nullable',
            'is_suspended' => 'boolean|nullable',
            'warehouse_seq_code' => 'string|nullable',

            // Contact validate.
            'contact' => 'required|array|min:1',
            'contact.name' => 'required|string',
            'contact.email' => 'required|email|unique:contacts,email,'.$contactId,
            'contact.phone' => 'required|string',
            'contact.profile_image' => 'nullable|string',
            'contact.password' => "required|min:$passLength|same:contact.password_confirmation",
            'contact.password_confirmation' => "required|min:$passLength",
            'contact.order_limit' => 'required|numeric|min:0',
            'contact.daily_budget_limit' => 'required|numeric|min:0',
            'contact.monthly_budget_limit' => 'required|numeric|min:0',

            // Address validation.
            'addresses' => 'nullable|array',
            'addresses.*.address_name' => 'required|string',
            'addresses.*.address_code' => 'nullable|string',
            'addresses.*.address_1' => 'required|string',
            'addresses.*.address_2' => 'nullable|string',
            'addresses.*.address_3' => 'nullable|string',
            'addresses.*.city' => 'required|string',
            'addresses.*.state' => 'required|string',
            'addresses.*.country_code' => 'nullable|string',
            'addresses.*.zip_code' => 'required|string',
        ];
    }
}
