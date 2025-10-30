<?php

namespace Amplify\System\Backend\Http\Controllers;

use Amplify\ErpApi\Facades\ErpApi;
use Amplify\ErpApi\Wrappers\ProductPriceAvailability;
use Amplify\Frontend\Http\Resources\CartResource;
use Amplify\System\Backend\Http\Requests\Orders\QuickOrderAddToOrderRequest;
use Amplify\System\Backend\Models\Cart;
use Amplify\System\Backend\Models\CartItem;
use Amplify\System\Backend\Models\Product;
use Amplify\Widget\Components\CartSummary;
use App\Http\Controllers\Controller;
use ErrorException;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

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

    /**
     * @throws \Throwable
     */
    public function addToCart(QuickOrderAddToOrderRequest $request)
    {
        abort_if(! haveAnyPermissions(['shop.add-to-cart', 'order.add-to-cart']), 403, 'You don\'t have permission to add to cart.');

        if (! ErpApi::enabled()) {
            return $this->apiResponse(false, 'ERP service not enabled.');
        }

        DB::beginTransaction();

        try {
            $is_added_to_cart = false;
            $erpProductDetails = $this->getERPInfo($request->input('products', []));

            if ($erpProductDetails->isEmpty()) {
                return $this->apiResponse(false, product_not_avail_message(), 404);
            }

            $warehouses = ErpApi::getWarehouses();

            $cart = getOrCreateCart();

            foreach ($request->input('products', []) as $product) {
                $source_info = [];
                $product_code = $product['product_code'];
                $product_warehouse_code = $product['product_warehouse_code'] ?? $this->getContactWarehouse();
                $warehouse = $warehouses->firstWhere('WarehouseNumber', '=', $product_warehouse_code);
                $warehouse_id = ($warehouse) ? $warehouse->InternalId : null;
                $warehouse_code = ($warehouse) ? $warehouse->WarehouseNumber : null;
                $product_qty = $product['qty'];
                $dbProduct = Product::with('productImage')->whereProductCode($product_code)->first();

                if (! $dbProduct) {
                    return $this->apiResponse(false, "Product with code {$product_code} is not available.", 404);
                }

                $minQty = (int) ($dbProduct->min_order_qty ?? 0);
                if ($minQty > 0 && $product_qty < $minQty) {
                    return $this->apiResponse(false, "Product {$product_code} requires a minimum order quantity of {$minQty}. You entered {$product_qty}.", 422);
                }

                $erpProduct = $erpProductDetails->firstWhere('ItemNumber', '=', $product_code);

                $product_price = $this->generateProductPrice($product, $erpProduct);

                $cart_item_identifier = [
                    'product_id' => $dbProduct->id,
                    'product_code' => $product_code,
                ];

                if (isset($product['source_type'])) {
                    $source_info['source_type'] = $product['source_type'] ?? null;
                    $source_info[''] = $product['source'] ?? null;
                    $source_info['expiry_date'] = $product['expiry_date'] ?? null;
                    $source_info['additional_info'] = $product['additional_info'] ?? null;
                } elseif (config('amplify.pim.use_minimum_order_quantity')) {
                    $source_info['additional_info'] = [
                        'minimum_quantity' => $dbProduct->min_order_qty,
                        'quantity_interval' => $dbProduct->qty_interval,
                    ];
                }

                $source_info['additional_info']['own_truck_only'] = $erpProduct->OwnTruckOnly ?? false;
                $source_info['additional_info']['in_stock'] = $dbProduct->in_stock ?? false;
                $source_info['additional_info']['is_ncnr'] = $dbProduct->is_ncnr ?? false;
                $source_info['additional_info']['ship_restriction'] = $dbProduct->ship_restriction ?? null;

                $cart->cartItems()->where($cart_item_identifier)->delete();

                throw_if((ErpApi::useSingleWarehouseInCart() && $cart->cartItems->count())
                    && ! $cart->cartItems()->whereProductWarehouseCode($product_warehouse_code)->exists(),
                    new Exception('Sorry, you cannot add multiple item orders to multiple warehouses at once. Please order separately.')
                );

                $cart->cartItems()->create($cart_item_identifier + $source_info + [
                    'quantity' => $product_qty,
                    'unitprice' => $product_price,
                    'product_warehouse_code' => $warehouse_code,
                    'warehouse_id' => $warehouse_id,
                    'address_id' => customer_check() ? customer(true)->customer_address_id : null,
                    'product_name' => $dbProduct->product_name,
                    'product_image' => $dbProduct->productImage->main ?? null,
                ]);

                if (! $is_added_to_cart) {
                    $is_added_to_cart = true;
                }
            }

            DB::commit();

            return response()->json([
                'success' => $is_added_to_cart,
                'message' => $is_added_to_cart ? 'Added to the order successfully.' : 'Product not available, Try again later.',
            ], $is_added_to_cart ? 200 : 500);
        } catch (\Throwable $th) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function getCarts()
    {
        $cart = getCart();
        if ($cart instanceof Cart) {
            $cart->load(['cartItems', 'cartItems.product.manufacturerRelation']);

            return new CartResource($cart);
        }

        return ['data' => ['products' => [], 'total_price' => 0]];
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
        $itemWarehouse = ErpApi::getCustomerDetail()?->DefaultWarehouse ?? null;

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
        return response()->json(array_merge([
            'success' => $success,
            'message' => $message,
        ], $extra), $status);
    }
}
