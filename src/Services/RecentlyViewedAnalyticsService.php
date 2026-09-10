<?php

namespace Amplify\System\Backend\Services;

use Amplify\System\Backend\Models\Contact;
use Amplify\System\Backend\Models\RecentlyViewedProduct;
use Illuminate\Support\Carbon;

class RecentlyViewedAnalyticsService
{
    /**
     * Record a product view for an authenticated contact.
     * Same-session revisits increment `repeat`; a new session updates `session`.
     */
    public function recordView(Contact $contact, int $productId): void
    {
        $sessionId = (string) session()->getId();
        $now = now();

        $existing = RecentlyViewedProduct::query()
            ->where('contact_id', $contact->id)
            ->where('product_id', $productId)
            ->first();

        if ($existing === null) {
            RecentlyViewedProduct::query()->create([
                'customer_id' => $contact->customer_id,
                'contact_id' => $contact->id,
                'product_id' => $productId,
                'session' => $sessionId,
                'repeat' => 1,
                'viewed_at' => $now,
            ]);

            return;
        }

        $updates = [
            'customer_id' => $contact->customer_id,
            'viewed_at' => $now,
        ];

        if ($existing->session === $sessionId) {
            $updates['repeat'] = ((int) $existing->repeat) + 1;
        } else {
            $updates['session'] = $sessionId;
            // Keep lifetime repeat across sessions; only bump on same-session revisit.
        }

        $existing->update($updates);
    }

    /**
     * @param  array<int|string|null>  $productIds
     */
    public function markAddedToCart(Contact $contact, array $productIds): void
    {
        $this->stampFunnelColumn($contact, $productIds, 'add_to_cart_at');
    }

    /**
     * @param  array<int|string|null>  $productIds
     */
    public function markQuoted(Contact $contact, array $productIds): void
    {
        $this->stampFunnelColumn($contact, $productIds, 'rfq_at');
    }

    /**
     * @param  array<int|string|null>  $productIds
     */
    public function markOrdered(Contact $contact, array $productIds): void
    {
        $this->stampFunnelColumn($contact, $productIds, 'ordered_at');
    }

    /**
     * First-touch funnel stamp: only set when the column is still null.
     *
     * @param  array<int|string|null>  $productIds
     */
    protected function stampFunnelColumn(Contact $contact, array $productIds, string $column): void
    {
        $productIds = array_values(array_unique(array_filter(array_map(
            static fn ($id) => (int) $id,
            $productIds,
        ))));

        if ($productIds === [] || ! in_array($column, ['add_to_cart_at', 'rfq_at', 'ordered_at'], true)) {
            return;
        }

        RecentlyViewedProduct::query()
            ->where('contact_id', $contact->id)
            ->where('customer_id', $contact->customer_id)
            ->whereIn('product_id', $productIds)
            ->whereNull($column)
            ->update([
                $column => Carbon::now(),
            ]);
    }
}
