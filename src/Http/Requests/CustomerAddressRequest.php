<?php

namespace Amplify\System\Backend\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerAddressRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return customer_check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'address.*.address_name' => 'required|string',
            // 'address.*.address' => 'required|string',
            'address.*.city' => 'required',
            'address.*.country_code' => 'required',
            'address.*.state' => 'required',
            'address.*.zip_code' => 'required',
        ];
    }
}
