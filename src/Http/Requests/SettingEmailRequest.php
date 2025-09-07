<?php

namespace Amplify\System\Backend\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingEmailRequest extends FormRequest
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
        $rules['email_type'] = 'required';
        $rules['name'] = 'required';
        $rules['email_body'] = 'required';
        $rules['show_button'] = 'nullable';
        $rules['is_messageable'] = 'required_without:is_emailable';
        $rules['is_emailable'] = 'required_without:is_messageable';
        if (request('show_button') === 1 || request('show_button') === true) {
            $rules['button_text'] = 'required';
            $rules['button_url'] = 'required';
        }

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
        return [
            //
        ];
    }
}
