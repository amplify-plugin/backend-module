<?php

namespace Amplify\System\Backend\Http\Requests;

use Amplify\System\Helpers\ProductHelper;
use Amplify\System\Rules\SizeInValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
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
        $rules['product_type'] = 'required';
        if (ProductHelper::isRequiredFields()) {
            if (in_array('product_name', ProductHelper::getProductMandatoryFields(), true)) {
                $rules['product_name'] = 'required|min:2|max:255|string';
            }

            if (in_array('product_code', ProductHelper::getProductMandatoryFields(), true)) {
                $rules['product_code'] =
                    'required|max:255|unique:products,product_code,'.request()->id.',id,deleted_at,NULL';
            }

            if (in_array('description', ProductHelper::getProductMandatoryFields(), true)) {
                $rules['description'] = 'required|string';
            }

            if (
                in_array('categories', ProductHelper::getProductMandatoryFields(), true)
                && ProductHelper::checkIfCategoryIsRequired()
            ) {
                $rules['categories'] = 'required';
            }

            if (
                in_array('product_classification_id', ProductHelper::getProductMandatoryFields(), true)
                && request()->product_type !== 'bundle'
            ) {
                $rules['product_classification_id'] = 'required|integer';
            }
        }

        if (request()->has_sku) {
            $rules['sku_default_attributes'] = 'required';
        }

        if (request()->status !== 'published') {
            request('ean_number') and $rules['ean_number'] = 'min:13|max:13';
            request('gtin_number') and $rules['gtin_number'] = new SizeInValidationRule(8, 12, 13, 14);
            request('upc_number') and $rules['upc_number'] = new SizeInValidationRule(12, 14);
            request('asin') and $rules['asin'] = 'min:10|max:10';
            request('manufacturer') and $rules['manufacturer'] = 'min:2|max:80';
            request('model_code') and $rules['model_code'] = 'min:2|max:80';
            request('model_name') and $rules['model_name'] = 'min:2|max:120';
        }

        if (request()->status === 'published') {
            $rules['selling_price'] = 'nullable|numeric';
            $rules['msrp'] = 'nullable|numeric';

            if (ProductHelper::checkIfUseClassifications()) {
                // productAttributes
                $rules['pivot.productAttributes'] = 'present|array';
                $rules['pivot.productAttributes.*.attribute_id'] = 'integer';
                $rules['pivot.productAttributes.*.attribute_value'] = 'required';

                // optionalSelectedAttributes
                $rules['pivot.optionalSelectedAttributes'] = 'present|array';

                $rules['pivot.optionalSelectedAttributes.*.min'] = 'sometimes|integer|gt:0';
                $rules['pivot.optionalSelectedAttributes.*.max'] = 'sometimes|integer|gt:0';

                $rules['pivot.optionalSelectedAttributes.*.boolean_titles.true'] = 'sometimes|required';
                $rules['pivot.optionalSelectedAttributes.*.boolean_titles.false'] = 'sometimes|required';

                $rules['pivot.optionalSelectedAttributes.*.enums'] = 'sometimes|required';
            }

            // new requirement field
            $rules['ean_number'] = 'nullable|string|min:13|max:13';
            $rules['gtin_number'] = ['nullable', 'string', new SizeInValidationRule(8, 12, 13, 14)];
            $rules['upc_number'] = 'nullable|string|min:12|max:12';
            $rules['asin'] = 'nullable|string|min:10|max:10';
            $rules['manufacturer'] = 'nullable|string|min:2|max:80';
            $rules['model_code'] = 'nullable|string|min:5|max:80';
            $rules['model_name'] = 'nullable|string|min:5|max:80';

            // product images
            $rules['main'] = 'nullable|string';
            $rules['thumbnail'] = 'nullable|string';
            $rules['additional'] = 'nullable|array';
            $rules['own_truck_only'] = 'nullable|boolean';

            request('product_type') === 'bundle'
                ? $rules['products_list'] = 'required'
                : null;
        }

        /* New fields */
        $rules['uom'] = 'sometimes|max:20';
        $rules['pack_size'] = 'sometimes|nullable|integer|gt:0';
        $rules['product_slug'] = 'unique:products,product_slug,null,id,deleted_at,NULL';
        if ($this->method() === 'PUT') {
            $rules['product_slug'] = Rule::unique('products', 'product_slug')->ignore(request()->route('id'), 'id');
        }
        $rules['meta_description'] = 'nullable|string|min:10|max:65535';
        $rules['features'] = 'nullable|array';
        $rules['specifications'] = 'nullable|array';
        $rules['meta_keywords'] = 'nullable|min:10|max:255';
        $rules['in_stock'] = 'nullable|boolean';
        $rules['is_ncnr'] = 'nullable|boolean';

        if (isset(request()->productDocuments) && count(request()->productDocuments) > 0) {
            $rules['productDocuments.*.order'] = 'required';
            $rules['productDocuments.*.media_type'] = 'required';
            $rules['productDocuments.*.document_type_id'] = 'required';
            $rules['productDocuments.*.file_path'] = 'required_unless:productDocuments.*.media_type,embedded';
            $rules['productDocuments.*.content'] = 'required_if:productDocuments.*.media_type,embedded';
        }

        return $rules;
    }

    protected function prepareForValidation()
    {
        //
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
        $rules = [];
        $rules['product_name.required'] = 'The product name field is required.';
        $rules['product_code.required'] = 'The product code field is required.';
        $rules['product_classification_id.required'] = 'The classification id field is required.';
        $rules['categories.required'] = 'The categories field is required.';
        $rules['ean_number.required'] = 'The EAN number field is required.';
        $rules['ean_number.min'] = 'The EAN number must be 13 digits.';
        $rules['ean_number.max'] = 'The EAN number must  be 13 digits.';
        // $rules['gtin_number.required'] = 'The GTIN number field is required.';
        // $rules['gtin_number.min'] = 'The GTIN number must be 14 characters.';
        // $rules['gtin_number.max'] = 'The GTIN number must be 14 characters.';
        $rules['upc_number.required'] = 'The UPC number field is required.';
        $rules['upc_number.min'] = 'The UPC number must be 12 digits.';
        $rules['upc_number.max'] = 'The UPC number must be 12 digits.';
        $rules['asin.required'] = 'The ASIN field is required.';
        $rules['asin.min'] = 'The ASIN number must be 10 characters.';
        $rules['asin.max'] = 'The ASIN number must be 10 characters.';
        $rules['manufacturer.required'] = 'The manufacturer part number field is required.';
        $rules['manufacturer.min'] = 'The manufacturer part number must be at least 2 characters.';
        $rules['manufacturer.max'] = 'Maximum manufacturer part number length is 80 characters.';
        $rules['model_code.required'] = 'The model code field is required.';
        $rules['model_name.required'] = 'The model name field is required.';
        $rules['sku_default_attributes.required'] = 'Please select sku default attributes.';

        if (request()->status === 'published') {
            $rules['selling_price.required'] = 'The selling price field is required.';
            $rules['msrp.required'] = 'The MSRP price field is required.';

            // productAttributes
            $rules['pivot.productAttributes.required'] = 'present|array';
            $rules['pivot.productAttributes.*.attribute_id.required'] = 'The attribute id field is required.';
            $rules['pivot.productAttributes.*.attribute_value.required'] = 'The attribute value field is required.';

            // optionalSelectedAttributes
            $rules['pivot.optionalSelectedAttributes.required'] = 'present|array';
            $rules['pivot.optionalSelectedAttributes.*.min.required'] = 'The min field is required.';
            $rules['pivot.optionalSelectedAttributes.*.max.required'] = 'The max field is required.';

            $rules['pivot.optionalSelectedAttributes.*.boolean_titles.true.required'] =
                'The affirmative field is required.';
            $rules['pivot.optionalSelectedAttributes.*.boolean_titles.false.required'] =
                'The negative field is required.';

            $rules['pivot.optionalSelectedAttributes.*.enums.required'] = 'The options field is required.';

            // product images
            $rules['main.required'] = 'The main field is required.';
            $rules['thumbnail.required'] = 'The thumbnail field is required.';
            $rules['additional.required'] = 'The additional field is required.';
        }

        $rules['productDocuments.*.order.required'] = 'Please put order serial.';
        $rules['productDocuments.*.document_type_id.required'] = 'Please select a document type.';
        $rules['productDocuments.*.file_path.required_unless'] = 'Please upload a document or enter file path.';
        $rules['productDocuments.*.content.required_if'] = 'Please add the embedded script for the video';

        return $rules;
    }
}
