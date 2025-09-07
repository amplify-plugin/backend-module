<?php

namespace Amplify\System\Backend\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WebinarRequest extends FormRequest
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
            'code' => 'required|min:2|max:255|unique:webinars,code,'.request('id', 'null'),
            'slug' => 'nullable|string',
            'title' => 'required|min:2|max:255',
            'page_id' => 'required|integer',
            'banner_zone_id' => 'required|integer',
            'short_description' => 'nullable|string',
            'start_date_time' => 'nullable|date',
            'end_date_time' => 'nullable|date',
            'cover_photo' => 'nullable',
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
            //
        ];
    }
}
