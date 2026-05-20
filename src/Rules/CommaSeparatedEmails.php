<?php

namespace Amplify\System\Backend\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Str;

class CommaSeparatedEmails implements ValidationRule
{
    /**
     * @param \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (empty($value)) {
            return;
        }

        foreach (array_filter(array_map('trim', explode(',', $value))) as $email) {
            if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
                $fail('The ' . Str::replace('_', ' ', $attribute) . ' must contain valid email addresses separated by commas.');

                return;
            }
        }
    }
}
