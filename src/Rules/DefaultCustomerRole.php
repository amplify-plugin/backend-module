<?php

namespace Amplify\System\Backend\Rules;

use Amplify\System\Backend\Models\Contact;
use Amplify\System\Backend\Models\CustomerRole;
use Closure;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\ValidationRule;

class DefaultCustomerRole implements ValidationRule, DataAwareRule
{
    private array $data = [];

    public function __construct(
        protected int|string|null $roleId = null
    )
    {
    }

    /**
     * Run the validation rule.
     *
     * @param \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $isDefault = boolval($value);

        match (config('permission.teams')) {
            true => $this->validateIfTeamsEnabled($isDefault, $fail),
            false => $this->validateIfTeamsDisabled($isDefault, $fail),
        };
    }

    private function validateIfTeamsEnabled(bool $isDefault, Closure $fail): void
    {
        if (empty($this->data['customer_id'])) {
            $fail('The customer field is required.');
        }

        $roleCheckQuery = CustomerRole::where('guard_name', Contact::AUTH_GUARD)
            ->where('customer_id', $this->data['customer_id'])
            ->where('is_default', true);

        //create
        if ($this->roleId === null || $this->roleId === '') {

            $defaultAlreadyExists = (clone $roleCheckQuery)->exists();

            if ($isDefault && $defaultAlreadyExists) {
                $fail('Only one role can be set as default for this customer.');
            }

            return;
        }

        //update
        if ($isDefault) {
            $defaultRoleExistsExceptCurrent = (clone $roleCheckQuery)
                ->where('id', '!=', $this->roleId)
                ->exists();

            if ($defaultRoleExistsExceptCurrent) {
                $fail('A default role already exist for this customer. Only one role can be set as default.');
            }
        }
    }

    private function validateIfTeamsDisabled(bool $isDefault, Closure $fail): void
    {
        $roleCheckQuery = CustomerRole::where('guard_name', Contact::AUTH_GUARD)
            ->where('is_default', true);

        //create
        if ($this->roleId === null || $this->roleId === '') {

            $defaultAlreadyExists = (clone $roleCheckQuery)->exists();

            if ($isDefault && $defaultAlreadyExists) {
                $fail('Only one role can be set as default.');
            }

            return;
        }

        //update
        if ($isDefault) {
            $defaultRoleExistsExceptCurrent = (clone $roleCheckQuery)
                ->where('id', '!=', $this->roleId)
                ->exists();

            if ($defaultRoleExistsExceptCurrent) {
                $fail('A default role already exist. Only one role can be set as default.');
            }
        }
    }

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
}
