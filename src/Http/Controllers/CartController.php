<?php

namespace Amplify\System\Backend\Http\Controllers;

use Amplify\ErpApi\Facades\ErpApi;
use Amplify\ErpApi\Wrappers\ProductPriceAvailability;
use Amplify\System\Backend\Models\Cart;
use Amplify\System\Backend\Models\CartItem;
use Amplify\Widget\Components\CartSummary;
use App\Http\Controllers\Controller;
use ErrorException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CartController extends Controller
{
    public function __construct()
    {
        if (! config('amplify.frontend.guest_add_to_cart')) {
            $this->middleware('customers');
        }
    }

    private function getContactWarehouse()
    {
        $customer = ErpApi::getCustomerDetail();
        $warehouse_code = $customer->DefaultWarehouse ?: (customer_check() ? customer()?->warehouse?->code : config('amplify.frontend.guest_checkout_warehouse', null));

        if ($warehouse_code == null) {
            throw new ErrorException('Contact or Customer default warehouse is not configured.');
        }

        return $warehouse_code;
    }

    public function getCartSummary()
    {
        return response()->json([
            'html' => Blade::renderComponent(new CartSummary),
        ], 200);
    }

    public function removeCart(CartItem $cartItem)
    {
        $isOwnCart = $cartItem->whereHas('cart', function ($query) {
            $query->where('contact_id', customer(true)?->id)
                ->orWhere('session_id', Session::token());
        })->exists();

        if ($isOwnCart) {
            $cartItem->delete();

            return response()->json([
                'success' => true,
                'total_price' => getCart()->total,
                'message' => 'Successfully deleted cart item.',
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Something went wrong.',
        ], 200);
    }

    public function updateCart(CartItem $cartItem, Request $request)
    {
        $request->validate([
            'quantity' => 'required|numeric|min:1',
        ]);

        $warehouse = ErpApi::getWarehouses()->firstWhere('WarehouseNumber', '=', $request->product_warehouse_code);
        try {
            $isOwnCart = $cartItem->whereHas('cart', function ($query) {
                $query->where('contact_id', customer(true)?->id)
                    ->orWhere('session_id', Session::token());
            })->exists();

            if ($isOwnCart) {
                if ($cartItem->source_type == 'QUOTE') {
                    $quotation = ErpApi::getQuotationDetail(['quote_number' => $cartItem->source]);
                    $quotationItem = $quotation->QuoteDetail->where('ItemNumber', $cartItem->product_code)->first();
                    $cartItem->update([
                        'unitprice' => $quotationItem?->ActualSellPrice,
                        'expiry_date' => $quotation->ExpirationDate,
                        'product_warehouse_code' => $request->product_warehouse_code,
                        'warehouse_id' => $warehouse->InternalId ?? null,
                        'additional_info' => [
                            'minimum_quantity' => $quotationItem?->QuantityOrdered,
                        ],
                    ]);

                    if ($cartItem->expiry_date < date('Y-m-d')) {
                        return response()->json([
                            'success' => false,
                            'message' => 'Quotation was expired.',
                        ], 400);
                    }

                    if ($request->quantity < ($cartItem->additional_info['minimum_quantity'] ?? 1)) {
                        return response()->json([
                            'success' => false,
                            'message' => 'Please meet the minimum quantity to order.',
                        ], 400);
                    }
                } else {
                    $erpProduct = $this->getERPInfo($cartItem->product_code, $request->quantity, $cartItem->product_warehouse_code)->first();
                    $product_price = $erpProduct->Price;

                    for ($i = 1; $i <= 6; $i++) {
                        if (isset($erpProduct["QtyBreak_{$i}"]) && $erpProduct["QtyBreak_{$i}"] <= $request->quantity) {
                            $product_price = $erpProduct["QtyPrice_{$i}"];

                            continue;
                        }

                        break;
                    }
                }

                $cartItem->update([
                    'quantity' => $request->quantity,
                    'unitprice' => $product_price ?? $cartItem->unitprice,
                ]);

                return response()->json([
                    'success' => true,
                    'total_price' => getCart()->total,
                    'message' => 'Successfully updated cart item.',
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Permission forbidden.',
                ], 403);
            }

        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function removeCarts()
    {
        $cart = getCart();
        if ($cart instanceof Cart) {
            $cart->cartItems()->delete();
            $cart->delete();

            return response()->json([
                'success' => true,
                'message' => 'Cart removed successfully.',
                'redirect' => url('/shop'),
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Cart is empty.',
        ], 200);
    }

    /**
     * @return \Amplify\ErpApi\Collections\ProductPriceAvailabilityCollection
     */
    public static function getERPInfo(array|string $codes, int $quantity = 1, $warehouse = null)
    {
        $customer = ErpApi::getCustomerDetail();
        // get default warehouse
        $itemWarehouse = $customer?->DefaultWarehouse;
        // get selected shipping address from session or fallback to customer default
        $shipToAddress = session('ship_to_address.ShipToNumber') ?? $customer?->DefaultShipTo;

        if (is_array($codes)) {
            $items = array_map(function ($item) use (&$itemWarehouse) {
                if (! empty($item['product_warehouse_code'])) {
                    $itemWarehouse = $item['product_warehouse_code'];
                }

                return [
                    'item' => $item['product_code'],
                    'qty' => $item['qty'],
                    'uom' => $item['product_uom'] ?? 'EA',
                ];
            }, $codes);

        } else {
            $items = [
                [
                    'item' => $codes,
                    'qty' => $quantity,
                    'uom' => 'EA',
                ],
            ];

            if ($warehouse) {
                $itemWarehouse = $warehouse;
            }
        }

        return ErpApi::getProductPriceAvailability([
            'items' => $items,
            'warehouse' => $itemWarehouse,
            'ship_to_address' => $shipToAddress,
        ]);
    }

    public function generateProductPrice($cart_item, ProductPriceAvailability $erpProduct)
    {
        switch ($cart_item['source_type'] ?? null) {
            case 'CAMPAIGN':
                $campaign = ErpApi::getCampaignDetail(['promo' => $cart_item['source'], 'override_date' => '10/23/2017']);
                $campaignItem = $campaign->CampaignDetail?->where('Item', trim($cart_item['product_code']))->firstOrFail();
                $product_price = $campaignItem?->Price ?? 0.00;
                break;

            default:
                $product_price = customer_check() ? $erpProduct->Price : ($erpProduct->ListPrice ?? $erpProduct->Price);
                break;

                //            default:
                //                for ($i = 1; $i <= 6; $i++) {
                //                    if (isset($erpProduct["QtyBreak_{$i}"]) && $erpProduct["QtyBreak_{$i}"] <= $cart_item['qty']) {
                //                        $product_price = $erpProduct["QtyPrice_{$i}"];
                //
                //                        continue;
                //                    }
                //                    break;
                //                }
                //
                //                break;
        }

        return floatval(str_replace(',', '', $product_price));
    }

    /**
     * Build a standardized API JSON response.
     *
     * @param  int  $status  HTTP status code (default: 200)
     * @param  array  $extra  Additional data to merge into the response
     */
    protected function apiResponse(bool $success, string $message, int $status = 200, array $extra = []): \Illuminate\Http\JsonResponse
    {
        return response()->json(
            array_merge(
                [
                    'success' => $success,
                    'message' => $message,
                ],
                $extra,
            ),
            $status,
        );
    }

    public function checkShipping(Request $request)
    {
        // basic payload validation (keep minimal)
        $v = Validator::make($request->all(), [
            'customer_country' => 'required|string',
        ]);
        if ($v->fails()) {
            return response()->json(['message' => 'Invalid payload.', 'errors' => $v->errors()], 422);
        }

        $cart = getCart();
        if (! $cart instanceof Cart || $cart->cartItems()->count() === 0) {
            return response()->json(['restricted_items' => []], 200);
        }
        // Build warehouse string (same logic used in Checkout widget)
        $warehouses = ErpApi::getWarehouses([['enabled', '=', true]]);
        $warehouseString = $warehouses->pluck('WarehouseNumber')->implode(',');

        $customer = ErpApi::getCustomerDetail();
        if (! Str::contains($warehouseString, $customer->DefaultWarehouse)) {
            $warehouseString = "$warehouseString,{$customer->DefaultWarehouse}";
        }

        // Build items list for ERP call from cart items
        $items = [];
        foreach ($cart->cartItems as $ci) {
            $items[] = array_filter([
                'item' => $ci->product_code,
                'uom' => $ci->uom,
            ]);
        }

        // ship_to_address_code data sent to ERP
        $ship_to_address = $request->ship_to_number;

        // Call ERP
        $priceAvailability = ErpApi::getProductPriceAvailability([
            'items' => $items,
            'warehouse' => $warehouseString,
            'ship_to_address' => $ship_to_address,
        ]);

        // Determine restricted items
        $restricted = [];
        $addedItems = []; // track added product codes
        // Build a lookup from cart items keyed by product_code
        $cartItemMap = [];
        foreach ($cart->cartItems as $ci) {
            $info = is_array($ci->additional_info) ? $ci->additional_info : json_decode($ci->additional_info, true) ?? [];

            $cartItemMap[$ci->product_code] = [
                'cart_item_id' => $ci->id,
                'ship_restriction' => $info['ship_restriction'] ?? null,
            ];
        }

        // priceAvailability may contain one or more entries per item (grouped by warehouse/seq)
        foreach ($priceAvailability as $entry) {
            $itemCode = $entry['ItemNumber'] ?? null;
            // Skip if already added
            if (isset($addedItems[$itemCode])) {
                continue;
            }

            $isRestricted = isset($entry['ItemRestricted']) ? boolval($entry['ItemRestricted']) : false;

            if ($isRestricted) {
                $cartInfo = $cartItemMap[$itemCode] ?? [];

                $restricted[] = [
                    'cart_item_id' => $cartInfo['cart_item_id'] ?? null, // ✅ get id from cart
                    'product_code' => $itemCode,
                    'warehouse' => $entry['WarehouseID'] ?? null,
                    'price' => $entry['Price'] ?? null,
                    'uom' => $entry['UnitOfMeasure'] ?? null,
                    'quantity_available' => isset($entry['QuantityAvailable']) ? (int) $entry['QuantityAvailable'] : $entry['netavail'] ?? null,
                    'ship_restriction' => $cartInfo['ship_restriction'] ?? null,
                ];

                $addedItems[$itemCode] = true; // mark as added
            }
        }

        // Return response
        return response()->json(
            [
                'restricted_items' => $restricted,
                'price_availability' => $priceAvailability,
            ],
            200,
        );
    }
}
