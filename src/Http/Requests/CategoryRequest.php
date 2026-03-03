<?php

namespace Amplify\System\Backend\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
        $rules = [
            'category_code' => 'required|unique:categories,category_code,'.request('id').',id,deleted_at,NULL|regex:/^[a-zA-Z0-9-]+$/',
            'category_name' => 'required|string',
            'category_slug' => 'required|unique:categories,category_slug,'.request('id').',id,deleted_at,NULL',
            'parent_id' => 'nullable',
            'level' => 'nullable',
            'is_top_nav' => 'required',
            'image' => 'nullable|string|url',
        ];

        $rules['pim_category_id'] = (config('amplify.pim.categorization_required', false)) ? 'required' : 'nullable';

        return $rules;
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'category_name' => json_encode($this->input('category_name')),
            'catalog_id' => config('amplify.sayt.default_catalog'),
        ]);
    }
}
