<?php

namespace Amplify\System\Backend\Rules;

use Amplify\ErpApi\Facades\ErpApi;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Str;

class ErpCustomerExist implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString $fail
     * @throws \ErrorException
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (empty($value)) {
            return;
        }

        $erpCustomer = ErpApi::getCustomerDetail(['customer_number' => $value]);

        if (!empty($erpCustomer->Message)) {
            $fail('The ' . Str::replace('_', ' ', $attribute) . ' is invalid or does not exist. ERP Error: ' . $erpCustomer->Message);
            return;
        }

        if (empty($erpCustomer->CustomerNumber)) {
            $fail('The ' . Str::replace('_', ' ', $attribute) . ' is invalid or does not exist in erp.');
            return;
        }
    }
}
