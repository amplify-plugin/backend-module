<?php

namespace Amplify\System\Backend\Rules;

use Amplify\ErpApi\Facades\ErpApi;
use Amplify\System\Backend\Models\Customer;
use Closure;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Str;

class ErpContactExist implements ValidationRule, DataAwareRule
{
    private array $data;

    /**
     * Set the data under validation.
     *
     * @param array $data
     * @return $this
     */
    public function setData(array $data): static
    {
        $this->data = $data;

        return $this;
    }

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

        $customer = Customer::find($this->data['customer_id']);

        $filters = [
            'customer_number' => $customer->erp_id,
            'contact_code' => $this->data['contact_code'],
            'limit'=> 1
        ];


        $erpContact = ErpApi::getContactDetail($filters);

        if (!empty($erpContact->Message)) {
            $fail('The ' . Str::replace('_', ' ', $attribute) . ' is invalid or does not exist. ERP Error: ' . $erpContact->Message);
            return;
        }

        if (empty($erpContact->ContactNumber) || $erpContact->ContactNumber != $this->data['contact_code']) {
            $fail('The ' . Str::replace('_', ' ', $attribute) . ' is invalid or does not exist in erp.');
        }
    }
}
