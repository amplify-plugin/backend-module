<?php

namespace Amplify\System\Backend\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventTemplateRequest extends FormRequest
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
            'email_body' => 'required|string',
            'notification_type' => 'required',
            'button_text' => 'required_if:show_button,true|max:255',
            'button_url' => 'required_if:show_button,true|max:255',
            'subject' => 'required_if:notification_type,==,emailable|string|max:255',
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
            'event_id.required' => 'Please select an event',
            'button_text.required_if' => 'The button text field is required when show button is selected.',
            'button_url.required_if' => 'The button url field is required when show button is selected.',
            'subject.required_if' => 'The subject field is required when sending via email.',
        ];
    }
}
