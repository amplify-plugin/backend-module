<?php

namespace Amplify\System\Backend\Http\Requests;

use Amplify\System\Backend\Models\Product;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SKUProductRequest extends FormRequest
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
        $productCodeRules = ['required', 'min:5', 'max:20'];

        if (config('amplify.pim.use_product_code_unique_check', true) && $this->shouldValidateProductCodeUniqueness()) {
            $uniqueRule = Rule::unique(Product::class, 'product_code')
                ->whereNull('deleted_at');

            if ($this->filled('id')) {
                $uniqueRule->ignore($this->input('id'));
            }

            $productCodeRules[] = $uniqueRule;
        }

        return [
            'product_name' => 'required|min:5|max:255',
            'product_type' => 'required',
            'product_code' => $productCodeRules,
            'selling_price' => 'nullable|numeric|gt:0',
        ];
    }

    /**
     * Enforce uniqueness on create, or when product_code is actually changing.
     * Existing duplicate codes in the DB should not block updating other SKU fields.
     */
    private function shouldValidateProductCodeUniqueness(): bool
    {
        if (! $this->filled('id')) {
            return true;
        }

        $currentCode = Product::where('id', $this->input('id'))->value('product_code');

        return $currentCode !== $this->input('product_code');
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
            'sku_id.required' => 'The SKU Id field is required.',
            'product_name.required' => 'The SKU name field is required.',
            'product_name.min' => 'The SKU name field must be at least 5 characters.',
            'product_name.max' => 'The SKU name field must not be greater than 255 characters.',
            'product_type.required' => 'The SKU type field is required.',
            'product_code.required' => 'The SKU code field is required.',
            'product_code.unique' => 'The SKU code has already been taken.',
            'product_code.min' => 'The SKU code field must be at least 5 characters.',
            'product_code.max' => 'The SKU code field must not be greater than 20 characters.',
            'selling_price.gt' => 'The Price must not be negative number.',
        ];
    }
}
