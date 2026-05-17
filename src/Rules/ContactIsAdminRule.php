<?php

namespace Amplify\System\Backend\Rules;

use Amplify\System\Backend\Models\Contact;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ContactIsAdminRule implements ValidationRule
{
    public function __construct(
        protected int|string|null $editingContactId = null
    ) {}

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $customerId = request()->input('customer_id');

        if (empty($customerId)) {
            return;
        }

        $isAdmin = request()->boolean('is_admin');

        $otherContactsQuery = Contact::where('customer_id', $customerId);

        if ($this->editingContactId !== null && $this->editingContactId !== '') {
            $otherContactsQuery->where('id', '!=', $this->editingContactId);
        }

        $otherContactsCount = (clone $otherContactsQuery)->count();
        $otherAdminExists = (clone $otherContactsQuery)->where('is_admin', true)->exists();

        if (! $isAdmin && $otherContactsCount === 0) {
            $fail(
                $this->editingContactId !== null && $this->editingContactId !== ''
                    ? 'This is the only contact for the customer and must remain the admin.'
                    : 'The first contact for a customer must be set as admin.'
            );

            return;
        }

        if ($isAdmin && $otherAdminExists) {
            $fail('This customer already has an admin contact. Only one admin contact is allowed per customer.');
        }
    }
}
