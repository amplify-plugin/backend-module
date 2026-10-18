<?php

namespace Amplify\System\Backend\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;

class SecuritySettingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return backpack_auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $rules = [
            'name' => ['required', 'string'],
            'option' => ['required', 'string'],
            'value' => ['nullable'],
        ];

        if ($this->input('option') === 'use_email_as_login_id'
            && filter_var($this->input('value'), FILTER_VALIDATE_BOOLEAN)) {
            $rules['value'][] = function (string $attribute, mixed $value, \Closure $fail) {
                $duplicates = DB::table('contacts')
                    ->selectRaw('email, COUNT(*) AS total')
                    ->whereNotNull('email')
                    ->where('email', '<>', '')
                    ->groupBy('email')
                    ->havingRaw('COUNT(*) > 1')
                    ->limit(5)
                    ->pluck('total', 'email');

                if ($duplicates->isNotEmpty()) {
                    $preview = $duplicates->map(fn (int $count, string $email) => "\"{$email}\" x{$count}")->implode(', ');

                    $fail("Cannot enable \"Use e-mail as login id\": duplicate contact emails exist ({$preview}"
                        .($duplicates->count() === 5 ? ' …' : '')
                        .'). Every duplicate email would produce an invalid login ID. Resolve the duplicate emails first.');
                }
            };
        }

        return $rules;
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        if ($this->input('option') === 'use_email_as_login_id') {
            $this->merge([
                'value' => filter_var($this->input('value'), FILTER_VALIDATE_BOOLEAN) ? '1' : '0',
            ]);
        }
    }

    /**
     * Custom error messages for validation.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'The setting group is missing.',
            'option.required' => 'The setting option is missing.',
        ];
    }
}
