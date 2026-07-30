<?php

namespace Amplify\System\Backend\Http\Requests;

use Amplify\System\Backend\Models\Attribute;
use Illuminate\Foundation\Http\FormRequest;

class AttributeRequest extends FormRequest
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
            'name_raw' => [
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    $normalizedName = is_array($this->input('name_raw'))
                        ? trim((string) collect($this->input('name_raw'))->first())
                        : trim((string) $this->input('name_raw', $value));

                    if ($normalizedName === '') {
                        return;
                    }

                    $locale = request()->get('locale', app()->getLocale());
                    $jsonPath = '$."'.$locale.'"';

                    $exists = Attribute::query()
                        ->when(request()->id, function ($query) {
                            $query->where('id', '!=', request()->id);
                        })
                        ->where(function ($query) use ($normalizedName, $jsonPath) {
                            $query->where('name', $normalizedName)
                                ->orWhere('name', json_encode($normalizedName))
                                ->orWhereRaw('JSON_UNQUOTE(JSON_EXTRACT(name, ?)) = ?', [$jsonPath, $normalizedName]);
                        })
                        ->exists();

                    if ($exists) {
                        $fail('The Name has already been taken.');
                    }
                },
            ],
            'slug' => 'required|alpha_dash|unique:attributes,slug,'.request()->id.',id,deleted_at,NULL',
            'type' => 'required',
        ];
    }

    protected function prepareForValidation()
    {
        $nameInput = $this->input('name');
        $slugInput = $this->input('slug');

        $this->merge([
            'name_raw' => $nameInput,
        ]);

        if (empty($slugInput) && ! empty($nameInput)) {
            $slugInput = $nameInput;
        }

        if (! empty($slugInput)) {
            $this->merge([
                'slug' => \Illuminate\Support\Str::slug($slugInput),
            ]);
        }

        $this->merge(['name' => json_encode($nameInput)]);
    }

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'name_raw' => 'Name',
            'slug' => 'Slug',
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
