<?php

namespace Amplify\System\Backend\Http\Requests;

use Amplify\System\Backend\Rules\CommaSeparatedEmails;
use Illuminate\Foundation\Http\FormRequest;

class EventActionRequest extends FormRequest
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
            'name' => 'required|min:3|max:255',
            'event_id' => 'required',
            'event_template_id' => 'required',
            'enabled' => ['nullable', 'boolean'],
            'is_get_admin' => ['nullable', 'boolean'],
            'is_get_customer' => ['nullable', 'boolean'],
            'is_get_customer_business_contact' => ['nullable', 'boolean'],
            'is_get_contact' => ['nullable', 'boolean'],
            'is_get_salesperson' => ['nullable', 'boolean'],
            'is_quote_sales_person' => ['nullable', 'boolean'],
            'recipient_emails' => ['nullable', 'string', new CommaSeparatedEmails],
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
            'event_id.required' => 'Please select an Event',
            'event_template_id.required' => 'Please select an Event Template',
        ];
    }
}
