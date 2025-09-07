<?php

namespace Amplify\System\Backend\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductClassificationsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        //        dd($this->request->all());
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
            'title' => 'required|min:3|max:255|string',
            'attributes' => 'nullable|array',
            'attributes.*' => 'nullable|integer',
            'options' => 'nullable|array',
            'options.*' => 'nullable|integer',
            'products' => 'nullable|array',
        ];

    }

    protected function prepareForValidation()
    {
        $this->merge(['title' => json_encode($this->input('title'))]);
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
