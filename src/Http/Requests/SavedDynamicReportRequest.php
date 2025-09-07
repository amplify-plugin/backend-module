<?php

namespace Amplify\System\Backend\Http\Requests;

use App\Models\SavedDynamicReport;
use Illuminate\Foundation\Http\FormRequest;

class SavedDynamicReportRequest extends FormRequest
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
            'report_category_id' => 'required|integer',
            'title' => 'required|max:255',
            'report_type' => 'required|in:'.implode(',', array_keys(SavedDynamicReport::REPORT_TYPE)),
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
