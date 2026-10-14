<?php

namespace Amplify\System\Backend\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Database\Seeder;

class ValidSeeder implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString $fail
     * @throws \ErrorException
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!is_string($value) || !class_exists($value)) {
            $fail("The {$attribute} must be a valid Seeder class.");
            return;
        }

        if (!is_subclass_of($value, Seeder::class)) {
            $fail("The {$attribute} class must extend " . Seeder::class . '.');
            return;
        }

        if (!method_exists($value, 'run')) {
            $fail("The {$attribute} class must have a run method.");
        }
    }
}
