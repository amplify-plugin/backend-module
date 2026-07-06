<?php

namespace Amplify\System\Backend\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerGroupRequest extends FormRequest
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
        $rules['group_code'] = 'required|string|min:3|max:255';
        $rules['group_name'] = 'required|string|min:3|max:255';
        $rules['group_pricing_type'] = 'required|string';
        $rules['users'] = 'nullable|array';
        $rules['users.*'] = 'integer|exists:users,id';
        if (request()->pricing_rules && request()->pricing_rules['flat_discount']) {
            $rules['pricing_rules.flat_discount_pricing_rules.*.discount'] = 'required';
            $rules['pricing_rules.flat_discount_pricing_rules.*.categories'] = 'required';
        }
        if (request()->pricing_rules && request()->pricing_rules['volume_discount']) {
            $rules['pricing_rules.volume_discount_pricing_rules.*.discounts'] = 'required';
            $rules['pricing_rules.volume_discount_pricing_rules.*.categories'] = 'required';
            //            $rules['pricing_rules.volume_discount_pricing_rules.*.discounts.*.min']      = 'required';
            //            $rules['pricing_rules.volume_discount_pricing_rules.*.discounts.*.max']      = 'required';
            //            $rules['pricing_rules.volume_discount_pricing_rules.*.discounts.*.discount'] = 'required';
        }
        if (request()->pricing_rules && request()->pricing_rules['order_value_discount']) {
            $rules['pricing_rules.order_value_discount_pricing_rules'] = 'required';
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
