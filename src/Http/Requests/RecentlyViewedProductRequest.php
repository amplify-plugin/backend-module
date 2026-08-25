<?php

namespace Amplify\System\Backend\Http\Requests;

use Amplify\System\Backend\Models\Contact;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RecentlyViewedProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return backpack_auth()->check();
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $nullableKeys = ['customer_id', 'contact_id', 'last_viewed_at'];

        foreach ($nullableKeys as $key) {
            if ($this->exists($key) && $this->input($key) === '') {
                $this->merge([$key => null]);
            }
        }

        $contactId = $this->input('contact_id');
        $customerId = $this->input('customer_id');

        if ($contactId && ! $customerId) {
            $contact = Contact::query()->find($contactId);

            if ($contact?->customer_id) {
                $this->merge([
                    'customer_id' => $contact->customer_id,
                ]);
            }
        }

        if (! $this->filled('last_viewed_at')) {
            $this->merge([
                'last_viewed_at' => now()->format('Y-m-d H:i:s'),
            ]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $entryId = $this->route('id')
            ?? $this->route('recently_viewed_product')
            ?? $this->id
            ?? null;

        return [
            'product_id' => [
                'required',
                'integer',
                'exists:products,id',
                Rule::unique('recently_viewed_products', 'product_id')
                    ->where(function ($query) {
                        if ($this->filled('contact_id')) {
                            $query->where('contact_id', $this->input('contact_id'));
                        } else {
                            $query->whereNull('contact_id');
                        }
                    })
                    ->ignore($entryId),
            ],
            'customer_id' => [
                'nullable',
                'integer',
                'exists:customers,id',
            ],
            'contact_id' => [
                'nullable',
                'integer',
                'exists:contacts,id',
            ],
            'last_viewed_at' => [
                'nullable',
                'date',
            ],
        ];
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            if (! $this->filled('contact_id') || ! $this->filled('customer_id')) {
                return;
            }

            $belongsToCustomer = Contact::query()
                ->whereKey($this->input('contact_id'))
                ->where('customer_id', $this->input('customer_id'))
                ->exists();

            if (! $belongsToCustomer) {
                $validator->errors()->add(
                    'contact_id',
                    'The selected contact does not belong to the selected customer.'
                );
            }
        });
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'product_id' => 'product',
            'customer_id' => 'customer',
            'contact_id' => 'contact',
            'last_viewed_at' => 'last viewed at',
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'product_id.unique' => 'This product is already in recently viewed for the selected contact.',
            'contact_id.exists' => 'The selected contact is invalid or does not belong to the selected customer.',
        ];
    }
}
