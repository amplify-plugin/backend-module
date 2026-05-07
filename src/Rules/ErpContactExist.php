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
        ];

        if (!empty($this->data['contact_code'])) {
            $filters['contact_code'] = $this->data['contact_code'];
        }

        $erpContactList = ErpApi::getContactList($filters);

        if($erpContactList->firstWhere('ContactEmail', $this->data['email']) == null) {
            $fail('The ' . Str::replace('_', ' ', $attribute) . ' is invalid or does not exist in erp.');
        }
    }
}
