<?php

namespace Amplify\System\Backend\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SiteRequest extends FormRequest
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
     */
    public function rules(): array
    {
        $regex = '/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/';

        return [
            'site_name' => 'required',
            'site_description' => 'nullable',
            //            'url'              => 'nullable|regex:' . $regex,
            'template_id' => 'required',
            'front_page_id' => 'required',
            'shop_page_id' => 'required',
            'product_page_id' => 'required',
            'search_config' => 'array',
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
            'template_id.required' => 'Please select a template.',
            'front_page_id.required' => 'Please select a home page.',
            'shop_page_id.required' => 'Please select a category list page.',
            'product_page_id.required' => 'Please select a default template for product.',
        ];
    }
}
