<?php

namespace Amplify\System\Backend\Http\Controllers;

use Amplify\ErpApi\Facades\ErpApi;
use Amplify\System\Backend\Facades\CenPos;
use Amplify\System\Backend\Http\Requests\CustomerOrderRequest;
use Amplify\System\Backend\Http\Requests\OrderFileRequest;
use Amplify\System\Backend\Models\Cart;
use Amplify\System\Backend\Models\CustomerOrder;
use Amplify\System\Backend\Models\CustomerOrderLine;
use Amplify\System\Backend\Models\Event;
use Amplify\System\Backend\Models\OrderList;
use Amplify\System\Backend\Models\OrderListItem;
use Amplify\System\Backend\Models\Product;
use Amplify\System\Backend\Models\SystemConfiguration;
use Amplify\System\Cms\Models\Page;
use Amplify\System\Factories\NotificationFactory;
use Amplify\System\OrderRule\Facades\OrderRuleCheck;
use Illuminate\Routing\Controller;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;

class CustomerOrderController extends Controller
{
    public function quickOrderFileUpload(OrderFileRequest $request): JsonResponse
    {
        $file = request()->file('file');
        $fileName = time().'_'.$file->getClientOriginalName();
        $filePath = $file->storeAs('public/quick_order/', $fileName);

        $fileExtension = strtoupper($file->getClientOriginalExtension());

        $readerType = match ($fileExtension) {
            'CSV' => \Maatwebsite\Excel\Excel::CSV,
            'XLS' => \Maatwebsite\Excel\Excel::XLS,
            'XLSX' => \Maatwebsite\Excel\Excel::XLSX,
            default => null
        };

        $fileData = Excel::toArray((object) [], $filePath, 'local', $readerType);

        $firstSheet = array_shift($fileData);

        if (empty($firstSheet) || count($firstSheet) == 1) {
            throw ValidationException::withMessages(['file' => 'The file is empty or only have headers.']);
        }

        // Remove Header
        if (isset($firstSheet[0][0])) {
            unset($firstSheet[0]);
        }

        // Merge Quantity for Duplicate Product
        $products = [];

        foreach ($firstSheet as $row) {
            $code = strval($row[0]);
            if (! isset($products[$code])) {
                $products[$code] = ['code' => $code, 'qty' => floatval($row[1])];

                continue;
            }
            $products[$code]['qty'] += floatval($row[1]);
        }

        $products = array_values($products);

        if (count($products) > 100) {
            throw ValidationException::withMessages(['file' => 'The file has more than 100 items.']);
        }

        if (! empty($products)) {
            Storage::delete($filePath);

            $all_products = array_map(fn ($item) => [$item['code'], $item['qty']], $products);

            $data = $this->validateAndGetProducts($all_products, $fileExtension);

            if ($data['success'] == false) {
                return response()->json([
                    'success' => false,
                    'data' => [],
                    'message' => $data['message'],
                ]);
            } else {
                return response()->json([
                    'success' => true,
                    'data' => $data['products'],
                    'message' => $data['message'],
                ]);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'File has no products',
            ]);
        }
    }

    private function validateAndGetProducts($all_products, $fileExtension = null): array
    {
        $products = [];
        $error_products = [];

        try {
            $warehouses = \ErpApi::getWarehouses([['enabled', '=', true]]);
            $warehouseString = $warehouses->pluck('WarehouseNumber')->implode(',');
            $product_code = array_map(function ($item) {
                return ['item' => $item[0], 'qty' => $item[1]];
            }, $all_products);

            $getProductPriceAvailability = \ErpApi::getProductPriceAvailability([
                'items' => [...$product_code],
                'warehouse' => $warehouseString,
            ]);

            $ERP = $getProductPriceAvailability->map(function ($item) use ($warehouses) {
                $item['WarehouseName'] = optional($warehouses->firstWhere('WarehouseNumber', $item['WarehouseID']))->WarehouseName ?? $item['WarehouseID'];

                return $item->toArray();
            });

            foreach ($all_products as $product) {
                $product_code = $product[0];
                $product_exist = Product::where('product_code', $product_code)->first();
                $new_structure = [];

                if (! $product_exist) {
                    $new_structure['product_code'] = $product_code;
                    $new_structure['product_name'] = 'N/A';
                    $new_structure['qty'] = $product[1];
                    $new_structure['address_id'] = '';
                    $new_structure['error'] = 'Product code is not valid';
                    $products[] = $new_structure;
                    $error_products[] = $product_code;
                } else {
                    $product_already_exist_in_products = false;
                    foreach ($products as $key => $product_data) {
                        if ($product_data['product_code'] === $product_code) {
                            $products[$key]['qty'] = $product[1];
                            $products[$key]['ERP'] = $ERP->filter(function ($item) use ($product_code) {
                                return $item['ItemNumber'] == $product_code;
                            });

                            $product_already_exist_in_products = true;
                        }
                    }
                    if (! $product_already_exist_in_products) {
                        $new_structure['product_code'] = $product_code;
                        $new_structure['product_id'] = $product_exist->id;
                        $new_structure['product_back_order'] = $product_exist->allow_back_order ? 'Y' : 'N';
                        $new_structure['product_name'] = $product_exist->product_name;
                        $new_structure['qty'] = $product[1];
                        $new_structure['ERP'] = $ERP->filter(function ($item) use ($product_code) {
                            return $item['ItemNumber'] == $product_code;
                        });

                        $arr = array_values($new_structure['ERP']->toArray());

                        $new_structure['ERP'] = $arr;
                        $new_structure['address_id'] = '';
                        $new_structure['error'] = '';
                        $products[] = $new_structure;
                    }
                }
            }

            return [
                'success' => true,
                'products' => $products,
                'message' => count($error_products) > 0
                    ? 'Product not found for: '.implode(', ', $error_products)
                    : '',
            ];
        } catch (\Exception $e) {
            Log::error($e);

            return [
                'success' => false,
                'message' => 'Invalid '.$fileExtension.' file',
            ];
        }
    }

    //    public function quickOrderAddToOrder(): JsonResponse
    //    {
    //        $address_id = '';
    //        if ($authenticated = customer_check()) {
    //            $address_id = customer(true)->customer_address_id;
    //        }
    //
    //        $all_products = request()->products;
    //
    //        $products = [];
    //
    //        $total_price = 0;
    //
    //        foreach ($all_products as $product) {
    //            $product_code = $product['product_code'];
    //            $product_id = $product['product_id'] ?? null;
    //            $warehouse_code = $product['product_warehouse_code'] ?? '';
    //            $product_exist = Product::with('productImage')->where('product_code', $product_code)->first();
    //            // $warehouses = \ErpApi::getWarehouses()->firstWhere('WarehouseNumber', $warehouse_code);
    //            $ERPInfo = $this->getERPInfo($product_code, $warehouse_code);
    //            $new_structure = [];
    //
    //            if ($product_exist) {
    //                if (\ErpApi::enabled()) {
    //                    if (((
    //                        ! $ERPInfo || ! $product['qty'] ||
    //                        ! $ERPInfo[0]->QuantityAvailable ||
    //                        ! ($ERPInfo[0]->QuantityAvailable >= $product['qty'])))
    //                    ) {
    //                        if (((! empty($product['customer_back_order_code'])
    //                                    && $product['customer_back_order_code'] !== 'Y')
    //                                || (! empty($product['product_back_order'])
    //                                    && $product['product_back_order'] !== 'Y'))
    //                            || ! ($product['qty'] > 0)) {
    //                            continue;
    //                        }
    //                    }
    //                }
    //
    //                $product_already_exist_in_products = false;
    //                foreach ($products as $key => $product_data) {
    //                    if ($product_data['product_code'] === $product_code) {
    //                        $products[$key]['qty'] = $product['qty'];
    //                        $products[$key]['product_warehouse_code'] = $warehouse_code;
    //                        $product_already_exist_in_products = true;
    //                    }
    //                }
    //                if (! $product_already_exist_in_products) {
    //                    $new_structure['product_code'] = $product_code;
    //                    $new_structure['product_id'] = $product_id ?? $product_exist->id;
    //                    $new_structure['url'] = frontendSingleProductURL($product_exist->id);
    //                    $new_structure['product_name'] = $product_exist->product_name;
    //                    $new_structure['qty'] = $product['qty'];
    //                    $new_structure['product_warehouse_code'] = $warehouse_code;
    //                    $new_structure['product_back_order'] = (! empty($product['product_back_order'])) ? $product['product_back_order'] : 'N';
    //                    $new_structure['product_image'] = $product_exist->productImage->main ?? null;
    //                    $new_structure['address_id'] = $address_id;
    //                    if (ErpApi::enabled()) {
    //                        $new_structure['price'] = $ERPInfo[0]->Price ?? 0;
    //                    } else {
    //                        $new_structure['price'] = $product_exist->selling_price ?? 0;
    //                    }
    //
    //                    $products[] = $new_structure;
    //                    $total_price += getPriceOfItem($new_structure['price'], $new_structure['qty']);
    //                }
    //            }
    //        }
    //
    //        $data = [
    //            'products' => $products,
    //            'total_price' => round($total_price, 2),
    //        ];
    //
    //        $total_products = count($products);
    //
    //        return response()->json([
    //            'success' => $total_products > 0,
    //            'data' => $data,
    //            'message' => $total_products > 0
    //                ? 'Added to the order successfully'
    //                : 'Quantity is invalid',
    //        ]);
    //    }

    private function getERPInfo(string $productCode, string $productUom, string $warehouseString)
    {
        return ErpApi::getProductPriceAvailability([
            'items' => [
                [
                    'item' => $productCode,
                    'uom' => $productUom,
                    'qty' => 1,
                ],
            ],
            'warehouse' => $warehouseString,
        ]);
    }

    /**
     * This function gets the product name from a given product code
     */
    public function getProductNameByCode(): JsonResponse
    {
        $product_code = request('product_code');
        $product_exist = Product::where('product_code', $product_code)->first();
        $product_uom = $product_exist->UoM ?? 'EA';
        $data = [];
        $data['ERP'] = [];

        if ($product_exist) {
            $warehouses = \ErpApi::getWarehouses([['enabled', '=', true]]);
            $warehouseString = $warehouses->pluck('WarehouseNumber')->implode(',');
            $ERP = $this->getERPInfo($product_code, $product_uom, $warehouseString);

            foreach ($ERP as $productPriceAvailability) {
                $productPriceAvailability['WarehouseName'] = optional($warehouses->firstWhere('WarehouseNumber', $productPriceAvailability['WarehouseID']))->WarehouseName ?? $productPriceAvailability['WarehouseID'];
                $data['ERP'][] = $productPriceAvailability->toArray();
            }

            $data['product_name'] = $product_exist->product_name;
            $data['product_id'] = $product_exist->id;
            $data['product_back_order'] = $product_exist->allow_back_order ? 'Y' : 'N';
            $data['error'] = '';
            $success = true;
        } else {
            $data['product_name'] = 'N/A';
            $data['error'] = 'Product code is not valid.';
            $success = false;
        }
        $data['multiple_warehouse'] = \ErpApi::allowMultiWarehouse();

        return response()->json([
            'success' => $success,
            'data' => $data,
        ]);
    }

    /**
     * This function submits the order & quotation
     */
    public function submitOrder(CustomerOrderRequest $request): JsonResponse
    {
        $cart = getCart();
        $customerDetails = ErpApi::getCustomerDetail();
        $order_data = $request->all();
        $order_quote = $this->getOrderPricing();

        $jsonResponse = [
            'success' => false,
            'message' => 'Something went wrong. Please try again later.',
            'redirect_to' => null,
        ];

        try {
            $order_lines = [];

            foreach ($cart->cartItems as $product) {
                $order_lines[] = new CustomerOrderLine([
                    'product_id' => $product->product_id,
                    'product_code' => $product->product_code,
                    'warehouse_id' => $product->warehouse_id ?? null,
                    'qty' => (int) $product->quantity,
                    'customer_price' => (float) $product->unitprice,
                    'ship_to_address_id' => $product->address_id,
                    'source_type' => $product->source_type ?? null,
                    'source' => $product->source ?? null,
                    'additional_info' => $product->additional_info ?? null,
                ]);
            }

            $order = new CustomerOrder;
            $order->total_net_price = $order_quote['order_subtotal'] ?? 0;
            $order->total_tax_amount = $order_quote['order_tax'] ?? 0;
            $order->total_amount = $order_quote['order_total'] ?? 0;
            $order->order_type = ($order_data['order_type'] == 'draft' || $order_data['order_type'] == 'order') ? CustomerOrder::IS_ORDER_TYPE : CustomerOrder::IS_RFQ_TYPE;
            $order->web_order_number = $this->getFormattedWebOrderNumber();
            $order->customer_id = customer()?->id;
            $order->contact_id = customer(true)?->id;
            $order->draft_name = $request->input('draft_name');
            $order->customer_order_number = $order_data['customer_order_ref'];
            // $order->user_id = customer(true)->id;
            $order->shipping_method = $request->input('shipping_method');
            $order->shipping_number = $request->input('shipping_number');
            if ($request->filled('address_name')) {
                $order->temp_address = [
                    'address_name' => $request->input('address_name'),
                    'address_1' => $request->input('address_1'),
                    'address_2' => $request->input('address_2'),
                    'address_3' => $request->input('address_3'),
                    'address_city' => $request->input('address_city'),
                    'address_country_code' => $request->input('address_country_code'),
                    'address_state' => $request->input('address_state'),
                    'address_zip_code' => $request->input('address_zip_code'),
                ];
            }

            if ($order_data['order_type'] == 'draft') {
                $order->order_status = 'Draft';

            } elseif ($order_data['order_type'] == 'quote') {
                $order->order_status = 'Pending';
            } else {
                if ($customerDetails->CreditCardOnly == 'Y') {
                    $order->order_status = 'Payment Pending';
                } elseif ($this->checkCustomerOrderLimit($order->total_amount)) {
                    $order->order_status = 'Approved';
                } else {
                    $order->order_status = 'Pending';
                }
            }

            if ($order->save() && $order->orderLines()->saveMany($order_lines)) {

                if ($request->filled('order_note')) {
                    $order->orderNotes()->create([
                        'note' => $request->input('order_note'),
                    ]);
                }

                $jsonResponse['success'] = true;

                $nxt_available_web_order_number = (int) config('amplify.basic.nxt_available_web_order_number');

                SystemConfiguration::setValue('basic', 'nxt_available_web_order_number', str_pad(
                    ++$nxt_available_web_order_number, 7, '0', STR_PAD_LEFT
                ));

                // create an order with standard payment type
                switch ($order_data['order_type']) {
                    case 'order' :

                        if (customer_check() && config('amplify.order.order_rule_check', false)) {
                            $order->approval_status = OrderRuleCheck::check($order);

                            if ($order->approval_status == 'need_approver') {
                                $order->order_status = 'Awaiting Approval';
                                $order->save();

                                $this->customerCartUpdate($cart);

                                $jsonResponse['redirect_to'] = route(('frontend.order-awaiting-approvals.index'));
                                $jsonResponse['message'] = 'Your Order Is Waiting For Approval';
                                $jsonResponse['success'] = true;

                                return response()->json($jsonResponse, 200);
                            }
                        }

                        $erp_order_data = $order_data[''];
                        $erp_order_data['order_type'] = 'O';
                        $apiResponse = $order->createOrderOrQuoteERP($erp_order_data);

                        if (! $apiResponse['success']) {
                            throw new \ErrorException('Order submission failed');
                        }

                        $jsonResponse['redirect_to'] = $request->boolean('redirect_to_order_complete', false) ? route('frontend.orders.completed', $order->id) : route('frontend.orders.index');
                        $jsonResponse['message'] = 'Order submitted successfully';

                        break;

                    case 'quote' :
                        $order_data['order_type'] = 'T';
                        $apiResponse = $order->createOrderOrQuoteERP($order_data);

                        if (! $apiResponse['success']) {
                            throw new \ErrorException('Quotation submission failed');
                        }

                        $jsonResponse['message'] = 'Quotation submitted successfully';
                        $jsonResponse['redirect_to'] = route('frontend.quotations.index');

                        NotificationFactory::call([Event::QUOTATION_RECEIVED], [
                            'order_id' => $order->id,
                            'customer_id' => $order->customer_id,
                        ]);
                        break;

                    case 'draft' :

                        $jsonResponse['message'] = 'Order Draft submitted successfully';
                        $jsonResponse['redirect_to'] = route('frontend.drafts.index');

                        NotificationFactory::call([Event::DRAFT_RECEIVED], [
                            'order_id' => $order->id,
                            'customer_id' => $order->customer_id,
                        ]);
                        break;

                    default:
                        $jsonResponse['message'] = 'Something went wrong.';
                        $jsonResponse['redirect_to'] = null;
                        break;

                }

                $this->customerCartUpdate($cart);

            } else {
                throw new \PDOException(($order_data['order_type'] === 'order') ? 'Order submission failed' : 'Quotation submission failed');
            }

            $cart->update(['status' => false]);

            return response()->json($jsonResponse, 200);

        } catch (\Exception $exception) {
            $class = basename(get_class($exception));

            Log::error("Create Order {$class} : ".$exception->getMessage());

            $jsonResponse['success'] = false;
            $jsonResponse['message'] = $exception->getMessage();
            $jsonResponse['redirect_to'] = null;

            return response()->json($jsonResponse, 500);
        }
    }

    public function submitPendingOrder(Request $request, $order_id)
    {
        $customerDetails = ErpApi::getCustomerDetail();
        $request->validate(['card_token' => $customerDetails->CreditCardOnly == 'Y' ? 'required' : 'nullable']);

        $customerOrder = CustomerOrder::where('contact_id', customer(true)->id)
            ->where('order_status', 'Pending')
            ->with('contact')
            ->findOrFail($order_id);

        $apiResponse = $customerOrder->createOrderOrQuoteERP([
            'order_type' => 'O',
            'customer_email' => $customerOrder->contact->email,
            'customer_phone' => $customerDetails->CustomerPhone,
            'card_token' => $request->input('card_token', null),
            'shipping_number' => $customerOrder->shipping_number,
        ] + (array) $customerOrder->temp_address);

        if ($apiResponse['success']) {
            $customerOrder->update([
                'customer_order_number' => $request->input('customer_order_ref', null),
                'order_status' => 'Approved',
            ]);
            if ($request->filled('order_note')) {
                $customerOrder->orderNotes()->create(['note' => $request->input('order_note')]);
            }

            NotificationFactory::call([Event::ORDER_RECEIVED], [
                'order_id' => $customerOrder->id,
                'customer_id' => $customerOrder->customer_id,
            ]);

            return [
                'success' => true,
                'message' => 'Successfully created order.',
                'redirect_to' => route('frontend.orders.index'),
            ];
        } else {
            return [
                'success' => false,
                'message' => 'Something went wrong.',
                'redirect_to' => null,
            ];
        }
    }

    /**
     * customerCartUpdate
     *
     * @param  mixed  $cart
     */
    public function customerCartUpdate(Cart $cart): void
    {
        $cart->update([
            'status' => 0,
            'tax',
        ]);
    }

    public function orderSubmitRedirect($message = null)
    {

        $order_list_page = Page::published()->find(config('amplify.frontend.order_page_id'));
        $jsonResponse['redirect_to'] = url()->to(($order_list_page->slug ?? 'orders'));
        $jsonResponse['message'] = $message ? $message : 'Order submitted successfully';
        $jsonResponse['success'] = true;

        return $jsonResponse;
    }

    /**
     * The purpose of this function is get formatted web number in case the prefix and/or the naxt available web order number is not set from the backend.
     */
    private function getFormattedWebOrderNumber()
    {
        $web_order_prefix = config('amplify.basic.web_order_prefix');

        if (config('amplify.basic.nxt_available_web_order_number') == null) {
            SystemConfiguration::setValue('basic', 'basic.nxt_available_web_order_number', '0000001');
        }

        // get the prefix of the customer set in the admin panel then concat with it the available web_order_number
        return $web_order_prefix.config('amplify.basic.nxt_available_web_order_number');
    }

    /**
     * This function structures the order list items and returns an array that can be stored with insert method
     */
    private function getOrderListItemsArray($request, $orderList)
    {
        $order_items = getCart()->cartItems->map(function ($item) use ($orderList) {
            $orderItem['product_id'] = $item->product_id;
            $orderItem['qty'] = $item->quantity;
            $orderItem['list_id'] = $orderList->id;

            return $orderItem;
        });

        return $order_items->toArray();
    }

    /**
     * This function checks if there exists similar list name for the logged in user
     */
    public function checkOrderListName(Request $request)
    {
        $list_name = $request->list_name;
        $match_found = false;

        $orderList = OrderList::where('name', 'like', $list_name)
            ->where('contact_id', customer(true)->id)->first();

        if (! is_null($orderList)) {
            $splitNumberFromName = explode('-', $list_name);
            $list_name = $this->getProperListName($splitNumberFromName);

            $match_found = true;
        }

        return response()->json([
            'success' => true,
            'list_name' => $list_name,
            'match_found' => $match_found,
        ]);
    }

    /**
     * The purpose of this function is generate proper list name for a list in the database
     */
    public function getProperListName($splitNumberFromName)
    {
        if (count($splitNumberFromName) < 2) {
            return $splitNumberFromName[0].'-1';
        }

        $listNumber = ++$splitNumberFromName[count($splitNumberFromName) - 1];
        $list_name = "{$splitNumberFromName[0]}"."-{$listNumber}";

        return $list_name;
    }

    /**
     * This checks customer order limit daily, monthly and for a single order
     */
    private function checkCustomerOrderLimit($order_amount): bool
    {
        $contact = optional(customer(true));
        $customer_orders = CustomerOrder::where('contact_id', $contact->id)->where('order_type', '0');

        $this_months_purchase = $customer_orders->whereMonth('created_at', Carbon::today()->month)->sum('total_amount'); // get the sum of all orders of the current month
        $todays_purchase = $customer_orders->whereDate('created_at', Carbon::today())->sum('total_amount'); // get the sum of the orders made today

        return $order_amount < $contact->order_limit
            && $contact->monthly_budget_limit > $this_months_purchase + $order_amount
            && $contact->daily_budget_limit > $todays_purchase + $order_amount;
    }

    /**
     * This will delete the items inside an order list
     *
     * @return Application|Redirector|RedirectResponse
     */
    public function deleteSavedOrderItem(OrderListItem $item)
    {
        try {
            $item->delete();
            if ($item->isLastItem()) {
                $item->list()->delete();
                Session::flash('success', 'List Item deleted, also list deleted because it was empty!');

                return redirect(url('/order-list'));
            } else {
                Session::flash('success', 'You have successfully deleted the Order List Item!');
            }
        } catch (\Exception $e) {
            Session::flash('error', 'Sorry! Something went wrong...');
        }

        return back();
    }

    /**
     * This will delete the product from a quotation
     */
    public function deleteQuotationItem(CustomerOrderLine $item): RedirectResponse
    {
        try {
            $order = $item->order();

            $item->delete();

            $current_total = $this->getTotalPriceForCustomerOrder($item->order->orderLines);

            $order->update([
                'total_amount' => $current_total,
            ]);

            if ($item->isLastItem()) {
                $item->order()->delete();
                Session::flash('success', 'Quote Item deleted, also quote deleted because it was empty!');

                return redirect()->route('frontend.quotations');
            } else {
                Session::flash('success', 'You have successfully deleted the Item!');
            }

            Session::flash('success', 'You have successfully deleted the Item!');
        } catch (\Exception $e) {
            Session::flash('error', 'Sorry! Something went wrong...');
        }

        return back();
    }

    /**
     * This function submits the quotes as orders
     */
    public function submitQuoteAsOrder(Request $request)
    {
        $order = CustomerOrder::findOrFail($request->order_id);

        $order->order_status = $this->checkCustomerOrderLimit($order->total_amount) ? 'Approved' : 'Pending';
        $order->order_type = '0';

        $order->save();

        Session::flash('success', 'You have successfully submitted quote as order!');

        return redirect()->to('orders');
    }

    /**
     * The purpose of this function is to delete a single quote by the customer
     */
    public function deleteQuote(CustomerOrder $quote)
    {
        try {
            $quote->orderLines()->delete(); // delete the orderLines first

            $quote->delete(); // Then delete the quote

            Session::flash('success', 'You have successfully deleted the quote!');
        } catch (\Throwable $th) {
            Session::flash('error', 'Sorry! Something went wrong...');
        }

        return back();
    }

    /**
     * This method submits a saved order list as an order
     */
    public function submitListAsOrder(Request $request, OrderList $list)
    {
        $request->validate([
            'customer_order_reference' => 'required',
            'order_type' => 'required|in:0,1',
        ]);

        $contact = customer(true);
        $customer = optional($contact)->customer;

        DB::beginTransaction();
        try {
            $order = new CustomerOrder;
            $order->order_type = $request->order_type;
            $order->web_order_number = rand(1, 99999);
            $order->customer_id = $customer->id;
            $order->contact_id = $contact->id;
            $order->customer_order_number = $request->customer_order_reference;
            $order->user_id = rand(1, 99999);
            $order->total_amount = (float) $this->getTotalPriceForSavedList(optional($list)->orderListItems); // Get the total price of the items saved in the list
            $order->order_status = $this->checkCustomerOrderLimit($order->total_amount) // Check if the logged in contact reached his/her order daily, monthly limits or not
                ? 'Approved'
                : 'Pending';

            $order->save();

            $order_lines = [];
            foreach ($list->orderListItems as $item) {
                $order_lines[] = [
                    'customer_order_id' => $order->id,
                    'product_code' => optional($item->product)->product_code,
                    'qty' => (int) $item->qty,
                    'customer_price' => (float) optional($item->product)->selling_price,
                    'ship_to_address_id' => $customer->default_address_id,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
            }

            CustomerOrderLine::insert($order_lines);

            DB::commit();

            $this->sendEmailNotification($order->customer_id, $order->id);

            Session::flash('success', 'You have successfully submitted quote as order!');
        } catch (\Exception $e) {
            DB::rollBack();

            Session::flash('error', 'Sorry! Something went wrong.');
        }

        $redirect = $request->order_type == '0' ? route('frontend.orders') : route('frontend.quotations');

        return redirect($redirect);
    }

    /**
     * This method adds all the saved list items to the draft order which customer created or the current order
     */
    public function addAllListItemsToLatestOrder(Request $request, OrderList $list)
    {
        $contact = customer(true);
        $customer = optional($contact)->customer;

        DB::beginTransaction();
        try {
            $order = CustomerOrder::findOrFail($request->order_id); // gets the customer order that logged in user selected from the <select> list

            $order_lines = [];
            foreach ($list->orderListItems as $item) {
                $product_code = optional($item->product)->product_code;
                $existingProduct = CustomerOrderLine::where('customer_order_id', $order->id) // this code finds out if the saved list item is already existing in the order
                    ->where('product_code', $product_code)->first();

                if (is_null($existingProduct)) {
                    // if the saved list item is not existing in the order then adds it as an order item
                    $order_lines[] = [
                        'customer_order_id' => $order->id,
                        'product_code' => optional($item->product)->product_code,
                        'qty' => (int) $item->qty,
                        'customer_price' => (float) optional($item->product)->selling_price,
                        'ship_to_address_id' => $customer->default_address_id,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]; // Creates the $order_lines array so that all the list items can inserted to the customer_order_lines table in one go
                } else {
                    // if the saved list item is existing in the order then adds the saved list item's quantity to the quantity of the order item and then updates
                    $existingProduct->update([
                        'qty' => $existingProduct->qty + $item->qty,
                    ]);
                }
            }

            CustomerOrderLine::insert($order_lines);

            $current_total = $this->getTotalPriceForCustomerOrder($order->orderLines);

            $order->update([
                'total_amount' => $current_total,
                'order_status' => $this->checkCustomerOrderLimit($current_total)
                    ? 'Approved'
                    : 'Pending',
            ]);

            DB::commit();

            $this->sendEmailNotification($order->customer_id, $order->id);

            Session::flash('success', 'You have successfully added the items of the list to your latest order!');
        } catch (\Exception $e) {
            DB::rollBack();

            Session::flash('error', 'Sorry! Something went wrong.');
        }

        return redirect(route('frontend.orders'));
    }

    /**
     * This method adds single list item to draft orders or current order
     */
    public function addSingleListItemsToLatestOrder(Request $request, OrderListItem $item)
    {
        $contact = customer(true);
        $customer = optional($contact)->customer;

        try {
            $order = CustomerOrder::findOrFail($request->order_id); // gets the customer order that logged in user selected from the <select> list

            $product_code = optional($item->product)->product_code;
            $existingProduct = CustomerOrderLine::where('customer_order_id', $order->id)
                ->where('product_code', $product_code)->first();

            if (is_null($existingProduct)) {
                $order_lines = [
                    'customer_order_id' => $order->id,
                    'product_code' => optional($item->product)->product_code,
                    'qty' => (int) $item->qty,
                    'customer_price' => (float) optional($item->product)->selling_price,
                    'ship_to_address_id' => $customer->default_address_id,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];

                CustomerOrderLine::create($order_lines);
            } else {
                $existingProduct->update([
                    'qty' => $existingProduct->qty + $item->qty,
                ]);
            }

            $current_total = $this->getTotalPriceForCustomerOrder($order->orderLines);

            $order->update([
                'total_amount' => $current_total,
                'order_status' => $this->checkCustomerOrderLimit($current_total)
                    ? 'Approved'
                    : 'Pending',
            ]);

            $this->sendEmailNotification($order->customer_id, $order->id); // Send mail to customer after all of the order details has been stored in a Database

            Session::flash('success', 'You have successfully added the item to your latest order!');
        } catch (\Exception $e) {
            Session::flash('error', 'Sorry! Something went wrong.');
        }

        return redirect(route('frontend.orders'));
    }

    /**
     * The purpose of this method is to calculate the total price of a saved order list and return the calculated value.
     */
    private function getTotalPriceForSavedList($orderListItems)
    {
        $total = 0;
        foreach ($orderListItems as $item) {
            $total += $item->qty * optional($item->product)->selling_price;
        }

        return $total;
    }

    /**
     * The purpose of this method is to calculate the total price of customer order lines and return the calculated value.
     */
    private function getTotalPriceForCustomerOrder($items)
    {
        $total = 0;
        foreach ($items as $item) {
            $total += $item->qty * $item->customer_price;
        }

        return $total;
    }

    /**
     * The purpose of this function is to let an approver approve of a certain order, if it has not been approved yet.
     */
    public function approveOrder(CustomerOrder $order)
    {
        $order->update([
            'order_status' => 'Approved',
            'approver_id' => customer(true)->id,
        ]);

        Session::flash('success', 'You have successfully approved of the order!');

        return redirect()->route('frontend.orders');
    }

    /**
     * The purpose of this function is to update order note
     */
    public function updateOrderNote(Request $request)
    {
        $request->validate([
            'noteNumber' => 'nullable|integer',
            'orderNumber' => 'required',
            'note' => 'required|string',
        ]);

        $erpResponse = \ErpApi::createOrUpdateNote([
            'noteNumber' => $request->input('noteNumber'),
            'orderNumber' => $request->input('orderNumber'),
            'note' => $request->input('note'),
        ]);

        if ($erpResponse->Status == 'Complete') {
            if (config('amplify.erp.default') === 'default') {
                $this->sendNoteUpdateNotification($erpResponse->NoteNum);
            } else {
                $order = CustomerOrder::where('erp_order_id', $request->input('orderNumber'))->first();

                if (! $order) {
                    return response()->json([
                        'message' => 'Order not found!',
                    ], 404);
                }

                $this->updateCustomerOrderNote($order, $erpResponse, $request->input('note'));
            }

            return response()->json([
                'redirect_to' => route('frontend.orders.show', $request->input('orderNumber')),
                'message' => 'You have successfully updated the order note for this order!',
            ], 200);
        }

        return response()->json([
            'message' => 'Something Went Wrong!',
        ], 500);
    }

    /**
     * The purpose of this function is to update draft order note
     */
    public function updateDraftNote(Request $request)
    {
        $request->validate([
            'orderNumber' => 'required|integer',
            'noteNumber' => 'nullable|integer',
            'note' => 'required|string',
        ]);

        $order = CustomerOrder::find($request->input('orderNumber'));

        if (! $order) {
            return response()->json([
                'message' => 'Order not found!',
            ], 404);
        }

        $orderNote = $order->orderNotes()->updateOrCreate([
            'id' => $request->input('noteNumber'),
        ], [
            'note' => $request->input('note'),
        ]);

        NotificationFactory::call(Event::ORDER_NOTES_UPDATED, [
            'customer_order_note_id' => $orderNote->id,
        ]);

        return response()->json([
            'redirect_to' => url('/draft-order-details/'.$request->input('orderNumber')),
            'message' => 'You have successfully updated the order note for this order!',
        ], 200);
    }

    /**
     * The purpose of this function is to submit the chosen order,
     * having the order_status of 'Draft' to either 'pending' or 'approved' based on the order limit conditions
     */
    public function submitDraftAsOrder(CustomerOrder $order)
    {
        $order_status = ($this->checkCustomerOrderLimit($order->total_amount)
            ? 'Approved'
            : 'Pending');

        $order->update([
            'order_status' => $order_status,
        ]);

        Session::flash('success', 'You have successfully submitted the draft as an order!');

        return back();
    }

    public function getOrderPricing()
    {
        try {
            $customerDetails = ErpApi::getCustomerDetail();
            $products = getCart()->cartItems->map(function ($item) {
                return [
                    'ItemNumber' => $item->product_code,
                    'WarehouseID' => customer()->warehouse->code ?? null,
                    'OrderQty' => $item->quantity,
                ];
            });

            $order_infos = [
                'customer_number' => $customerDetails->CustomerNumber,
                'ship_to_number' => $customerDetails->DefaultShipTo,
                'payment_type' => $customerDetails->CreditCardOnly === 'Y' ? 'CreditCard' : 'Standard',
                'order_type' => 'T',
                'return_type' => 'D',
            ];

            $quote = ErpApi::createQuotation([
                'order' => $order_infos, 'items' => $products->toArray(),
            ])->first();

            return [
                'order_subtotal' => $quote->TotalOrderValue,
                'order_tax' => $quote->SalesTaxAmount,
                'order_ship' => $quote->FreightAmount,
                'order_total' => $quote->TotalOrderValue + $quote->SalesTaxAmount + $quote->FreightAmount,
                'threshold_limit' => $customerDetails->FreightOptionAmount ?? config('amplify.marketing.free_ship_threshold'),
                'threshold_message' => config('amplify.marketing.checkout_threshold_replace'),

            ];

        } catch (\Exception $exception) {
            return [
                'order_subtotal' => null,
                'order_tax' => null,
                'order_ship' => null,
                'order_total' => null,
                'threshold_limit' => config('amplify.marketing.free_ship_threshold'),
                'threshold_message' => customer()->free_shipment_amount ?? config('amplify.marketing.checkout_threshold_replace'),
            ];
        }
    }

    /**
     * @throws \Throwable
     */
    public function getOrderSummary()
    {
        $cart = getCart();
        $customer_details = ErpApi::getCustomerDetail();
        $products = $cart->cartItems->map(function ($item) {
            return [
                'ItemNumber' => $item->product_code,
                'WarehouseID' => customer()->warehouse->code ?? null,
                'OrderQty' => $item->quantity,
            ];
        });

        $order_infos = [
            'customer_number' => $customer_details->CustomerNumber,
            'ship_to_number' => $customer_details->DefaultShipTo,
            'payment_type' => $customer_details->CreditCardOnly === 'Y' ? 'CreditCard' : 'Standard',
            'order_type' => 'T',
            'return_type' => 'D',
        ];

        $order_summary = ErpApi::createQuotation([
            'order' => $order_infos, 'items' => $products,
        ])->first();

        return response()->json([
            'html' => view('widget::partials.order-summary', [
                'cart' => $cart,
                'order_summary' => $order_summary,
            ])->render(),
        ], 200);
    }

    public function getCenposToken(Request $request)
    {
        // $orderSummary = $this->getOrderPricing();

        return CenPos::getVerifyingPost(
            $request->input('email', ''),
            $request->input('amount', 0.00),
            $request->input('token_id', ''),
            $request->input('invoice_number', ''),
            $request->input('type', 'Auth'),
            $request->input('address', null),
            $request->input('zipcode', null),
            $request->input('method', 'credit_card'),
        );
    }

    private function sendNoteUpdateNotification($orderNoteId)
    {
        NotificationFactory::call(Event::ORDER_NOTES_UPDATED, [
            'customer_order_note_id' => $orderNoteId,
        ]);
    }

    private function updateCustomerOrderNote($order, $erpResponse, $notes)
    {
        $orderNote = $order->orderNotes()
            ->updateOrCreate(['erp_note_id' => $erpResponse->NoteNum], ['note' => $notes]);

        $this->sendNoteUpdateNotification($orderNote->id);
    }
}
