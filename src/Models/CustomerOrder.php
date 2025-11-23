<?php

namespace Amplify\System\Backend\Models;

use Amplify\ErpApi\Facades\ErpApi;
use Amplify\System\Factories\NotificationFactory;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Log;
use OwenIt\Auditing\Contracts\Auditable;

class CustomerOrder extends Model implements Auditable
{
    use CrudTrait;
    use \OwenIt\Auditing\Auditable;

    const IS_ORDER_TYPE = '0';

    /**
     * rfq stands for Request for quotation
     */
    const IS_RFQ_TYPE = '1';

    protected $table = 'customer_orders';

    protected $casts = ['temp_address' => 'array'];

    protected $guarded = ['id'];

    /**
     * Relations
     */
    public function orderLines(): HasMany
    {
        return $this->hasMany(CustomerOrderLine::class, 'customer_order_id', 'id');
    }

    public function orderNotes()
    {
        return $this->hasMany(CustomerOrderNote::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class, 'order_id', 'id');
    }

    public function contact()
    {
        return $this->belongsTo(Contact::class, 'contact_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(Contact::class, 'user_id', 'id');
    }

    public function approver()
    {
        return $this->belongsTo(Contact::class, 'approver_id', 'id');
    }

    public function orderRule()
    {
        return $this->hasOne(\Amplify\System\OrderRule\Models\CustomerOrderRuleTrack::class, 'customer_order_id', 'id');
    }

    /**
     * Functions
     */
    public function getFormattedCreatedAtValue()
    {
        return carbon_datetime($this->created_at);
    }

    public function getFormattedUpdatedAtValue()
    {
        return carbon_datetime($this->updated_at);
    }

    public function getFormattedSubmittedAtValue()
    {
        return carbon_datetime($this->submitted_at);
    }

    public function getShipAddressAttribute()
    {
        // $shipToAddress = $this->customer?->addresses()->where('address_code', $this->shipping_number)->first() ?? null;
        // return $this->customer;
        // if ($shipToAddress) {
        //     $address = "{$shipToAddress->address_code} - {$shipToAddress->address_1} {$shipToAddress->address_2} {$shipToAddress->address_3}";
        //     if (strlen($shipToAddress->city) > 0) {
        //         $address .= ", {$shipToAddress->city}";
        //     }

        //     if (strlen($shipToAddress->city) > 0) {
        //         $address .= ", {$shipToAddress->state}";
        //     }

        //     if (strlen($shipToAddress->zip_code) > 0) {
        //         $address .= "-{$shipToAddress->zip_code}";
        //     }

        //     return $address;
        // }

        $addressParts = [
            $this->ship_to_address,
            $this->ship_to_country_code,
            $this->ship_to_city,
            $this->ship_to_state,
            $this->ship_to_zip_code,
        ];

        $filteredAddressParts = array_filter($addressParts, function ($part) {
            return ! empty($part);
        });

        $address = implode(', ', $filteredAddressParts);

        return ! empty($address) ? $address : 'N/A';
    }

    /**
     * Button function for Backend OrderList menu
     */
    public function buttonOrderLines()
    {
        return '<a class="btn btn-sm btn-link" href="'.route('order-line.index')
            .'?order_line_id='.$this->id.'" data-toggle="tooltip" title="Order Items"><i class="la la-list mr-2"></i>View Details</a>';
    }

    public function buttonQuoteLines()
    {
        return '<a class="btn btn-sm btn-link" href="'.route('quote-line.index')
            .'?order_line_id='.$this->id.'" data-toggle="tooltip" title="Quote Items"><i class="la la-list mr-2"></i>View Items</a>';
    }

    public function webOrderSettingsButton()
    {
        return '<a class="btn btn-sm btn-primary" href="'.route('web-order-number.create')
            .'?order_line_id='.$this->id.'" data-toggle="tooltip" title="Web Order Number config"><i class="nav-icon las la-cog"></i> Web Order Number config</a>';
    }

    /**
     * Scopes
     */
    public function scopeIsOrderType($q)
    {
        $q->where('order_type', self::IS_ORDER_TYPE)->get();
    }

    public function scopeIsRfqType($q)
    {
        $q->where('order_type', self::IS_RFQ_TYPE)->get();
    }

    public function createOrderOrQuoteERP(array $data): array
    {
        try {
            if (isset($data['customer_number'])) {
                $CustomerDetails = ErpApi::getCustomerDetail(['customer_number' => $data['customer_number']]);
            } else {
                $CustomerDetails = ErpApi::getCustomerDetail();
            }

            $this->load(['orderLines', 'orderLines.warehouse']);

            $products = $this->orderLines->map(function ($orderLine) use ($CustomerDetails) {
                $additionalInfo = collect();
                if ($orderLine->source_type == 'custom_item') {
                    $additionalInfo = json_decode($orderLine->additional_info);
                    $price = $additionalInfo->total_price;
                } elseif ($orderLine->source_type == 'Quote' || $orderLine->source_type == 'Promo') {
                    $price = $orderLine->customer_price;
                } else {
                    $price = $orderLine->customer_price;
                }

                return [
                    'ItemNumber' => $orderLine->product_code,
                    'WarehouseID' => $orderLine?->warehouse->code ?? $CustomerDetails->DefaultWarehouse,
                    // @TODO: warehouse set from customer default
                    // 'WarehouseID' => customer()->warehouse->code ?? $CustomerDetails->DefaultWarehouse,
                    'OrderQty' => $orderLine->qty,
                    'SourceType' => $orderLine->source_type ?? null,
                    'Source' => $orderLine->source ?? null,
                    'Price' => $price,
                    'ItemComment' => ! empty($additionalInfo) && ! empty($additionalInfo?->OrderSpec) ? $additionalInfo?->OrderSpec : '',
                    'UnitOfMeasure' => $orderLine->unit_code ?? null,
                ];
            });

            if (! empty($data['shipping_option']) && config('amplify.client_code') === 'RHS') {
                $products->push([
                    'ItemNumber' => $data['shipping_option'],
                    'WarehouseID' => $CustomerDetails->DefaultWarehouse,
                    'OrderQty' => '1',
                    'UnitOfMeasure' => 'EA',
                ]);
            }

            $order_infos = [
                // 'contact_id' => customer(true)?->contact_code ?? '',
                'contact_code' => customer(true)?->contact_code ?? '',
                'customer_name' => $data['customer_name'] ?? $CustomerDetails->CustomerName,
                'customer_number' => $CustomerDetails->CustomerNumber,
                'customer_email' => $data['customer_email'] ?? '',
                'phone_number' => $data['customer_phone'] ?? '',
                'order_type' => $data['order_type'] ?? 'O', /** O order Create && T for Quotation Create */
                'card_token' => $data['card_token'] ?? '',
                'order_note' => $data['order_notes'] ?? $this->notes,
                'internal_note' => $data['internal_notes'] ?? '',
                'customer_order_ref' => $this->customer_order_number,
                'shipping_method' => $data['shipping_method'] ?? '',
                'ship_to_number' => $data['shipping_number'] ?? '',
                'ship_to_name' => $data['customer_name'] ?? '',
                'freight_amount' => $data['freight_amount'] ?? '',
                'warehouse_id' => $products->first()['WarehouseID'] ?? '',
                'po_number' => $data['po_number'] ?? '',
                'merchant_id' => $data['merchant_id'] ?? '',
                'card_number' => $data['card_number'] ?? '',
                'card_type' => $data['card_type'] ?? '',
                'total_order_value' => $data['total_order_value'] ?? '',
                'freight_account_number' => $data['freight_account_number'] ?? '',
                'wtdo_note' => isset($data['wtdo_note']) ? $data['wtdo_note'] : '',
                'freight_terms_type' => isset($data['freight_terms_type']) ? $data['freight_terms_type'] : '',
                'payment_method' => isset($data['payment_method']) ? $data['payment_method'] : '',
                'request' => request()->all(),
            ];

            if (isset($data['address_name'])) {

                $order_infos['ship_to_address1'] = $data['address_name'] != 'TEMP' ? '' : ($data['address_1'] ?? '');
                $order_infos['ship_to_address2'] = $data['address_name'] != 'TEMP' ? '' : ($data['address_2'] ?? '');
                $order_infos['ship_to_address3'] = $data['address_name'] != 'TEMP' ? '' : ($data['address_3'] ?? '');
                $order_infos['ship_to_city'] = $data['address_name'] != 'TEMP' ? '' : ($data['address_city'] ?? '');
                $order_infos['ship_to_country_code'] = $data['address_name'] != 'TEMP' ? '' : ($data['address_country_code'] ?? '');
                $order_infos['ship_to_state'] = $data['address_name'] != 'TEMP' ? '' : ($data['address_state'] ?? '');
                $order_infos['ship_to_zip_code'] = $data['address_name'] != 'TEMP' ? '' : ($data['address_zip_code'] ?? '');
                $order_infos['ship_to_phone'] = $data['address_name'] != 'TEMP' ? '' : ($data['shipping_phone'] ?? '');
            }

            if (isset($data['order_type'])) {

                if ($data['order_type'] == 'O') {
                    $order_infos['payment_type'] = $CustomerDetails->CreditCardOnly === 'Y' ? 'CreditCard' : 'Standard';
                    $orderResponse = ErpApi::createOrder([
                        'order' => $order_infos,
                        'items' => $products->toArray(),
                    ]);

                    if (isset($orderResponse->Message) && !empty($orderResponse->Message)) {
                        return [
                            'success' => false,
                            'message' => $orderResponse->Message,
                        ];
                    }


                    if (isset($orderResponse->OrderStatus) && $orderResponse->OrderStatus === 'Accepted') {

                        $this->update([
                            'erp_order_id' => $orderResponse?->OrderNumber ?? null,
                            'order_status' => 'Pending',
                        ]);

                        NotificationFactory::call([Event::ORDER_RECEIVED], [
                            'order_id' => $this->id,
                            'customer_id' => $this->customer_id,
                            'guest_customer_email' => ! customer_check() ? $order_infos['customer_email'] : null,
                            'guest_customer_name' => ! customer_check() ? $order_infos['customer_name'] : null,
                            'contact_id' => $this->contact_id ?? null,
                        ]);

                        NotificationFactory::call([Event::ORDER_ACCEPTED], [
                            'order_id' => $this->id,
                            'customer_id' => $this->customer_id,
                            'guest_customer_email' => ! customer_check() ? $order_infos['customer_email'] : null,
                            'guest_customer_name' => ! customer_check() ? $order_infos['customer_name'] : null,
                        ]);

                        return [
                            'success' => true,
                            'message' => 'Order Received',
                            'order_id' => $orderResponse->OrderNumber,
                        ];
                    }

                    $this->update([
                        'order_status' => 'Rejected',
                    ]);

                    NotificationFactory::call([Event::ORDER_REJECTED], [
                        'order_id' => $this->id,
                        'customer_id' => $this->customer_id,
                    ]);

                    return [
                        'success' => false,
                        'message' => 'Order Rejected',
                    ];
                } elseif ($data['order_type'] == 'T') {
                    $order_infos['payment_type'] = 'Standard';
                    $orderResponse = ErpApi::createQuotation(['order' => $order_infos, 'items' => $products->toArray()]);

                    return [
                        'success' => true,
                        'message' => 'Quotation Received',
                    ];
                } elseif ($data['order_type'] == 'Q') {
                    $orderResponse = ErpApi::createOrder([
                        'order' => $order_infos,
                        'items' => $products->toArray(),
                    ]);
                    
                    if (isset($orderResponse->Message) && !empty($orderResponse->Message)) {
                        return [
                            'success' => false,
                            'message' => $orderResponse->Message,
                        ];
                    }

                    if (isset($orderResponse->OrderStatus) && $orderResponse->OrderStatus === 'Accepted') {

                        $this->update([
                            'erp_order_id' => $orderResponse?->OrderNumber ?? null,
                            'order_status' => 'Quotation',
                        ]);

                        NotificationFactory::call([Event::QUOTATION_RECEIVED], [
                            'order_id' => $this->id,
                            'customer_id' => $this->customer_id,
                            'guest_customer_email' => ! customer_check() ? $order_infos['customer_email'] : null,
                            'guest_customer_name' => ! customer_check() ? $order_infos['customer_name'] : null,
                            'contact_id' => $this->contact_id ?? null,
                        ]);

                        return [
                            'success' => true,
                            'message' => 'Quotation Received',
                            'order_id' => $orderResponse->OrderNumber,
                        ];
                    }

                    $this->update([
                        'order_status' => 'Rejected',
                    ]);

                    return [
                        'success' => false,
                        'message' => 'Quotation Rejected',
                    ];
                }
            }

            return [
                'success' => false,
                'message' => 'Order Received Failed',
            ];
        } catch (\Exception $exception) {
            Log::error($exception);

            return [
                'success' => false,
                'message' => $exception->getMessage(),
            ];
        }
    }

    public function getErpInfoAttribute()
    {
        if ($this->erp_order_id) {
            return ErpApi::getOrderDetail(['order_number' => $this->erp_order_id]);
        }

        return null;
    }

    public function getHazmatChargeFromJson()
    {
        $spare = json_decode($this->spare_1, true);

        return isset($spare['hazmat_charge']) ? (float) $spare['hazmat_charge'] : null;
    }
}
