<?php

namespace Amplify\System\Backend\Http\Controllers\Admin;

use Amplify\ErpApi\Facades\ErpApi;
use Amplify\System\Abstracts\BackpackCustomCrudController;
use Amplify\System\Backend\Http\Requests\OrderRequest;
use Amplify\System\Backend\Models\Customer;
use Amplify\System\Backend\Models\CustomerOrder;
use Amplify\System\Backend\Models\CustomerOrderNote;
use Amplify\System\Backend\Models\Event;
use Amplify\System\Backend\Models\Product;
use Amplify\System\Backend\Models\Warehouse;
use Amplify\System\Factories\NotificationFactory;
use Backpack\CRUD\app\Exceptions\BackpackProRequiredException;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanel;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Backpack\Pro\Http\Controllers\Operations\FetchOperation;
use Exception;
use Illuminate\Http\Request;

/**
 * Class OrderCrudController
 *
 * @property-read CrudPanel $crud
 */
class OrderCrudController extends BackpackCustomCrudController
{
    use CreateOperation;
    use DeleteOperation;
    use FetchOperation;
    use ListOperation;
    use ShowOperation;
    use UpdateOperation {
        update as traitUpdate;
    }

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     *
     * @throws Exception
     */
    public function setup()
    {
        CRUD::setModel(CustomerOrder::class);
        CRUD::setRoute(config('backpack.base.route_prefix').'/order');
        CRUD::setEntityNameStrings('order', 'orders');
    }

    /**
     * Fetch product for order line
     *
     * @return object
     */
    public function fetchProducts()
    {
        return $this->fetch([
            'model' => Product::class,
            'query' => fn ($model) => $model->orderBy('product_name'),
        ]);
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     *
     * @return void
     *
     * @throws BackpackProRequiredException
     */
    protected function setupListOperation()
    {
        $this->crud->enableExportButtons();
        $this->crud->addClause('where', 'order_status', '!=', 'Draft');
        // Filtering with customer
        CRUD::addFilter(
            [
                'name' => 'category_name',
                'type' => 'select2_ajax',
                'label' => 'Customer',
                'placeholder' => 'Type Name, Code, Email, Phone',
                'method' => 'POST',
                'select_attribute' => 'customer_name',
            ],
            backpack_url('contact/fetch/customer'),
            function ($value) {
                // if the filter is active
                $this->crud->query->whereHas('customer', function ($query) use ($value) {
                    $query->where('customer_id', $value);
                });
            },
        );

        CRUD::addFilter([
            'name' => 'created_between',
            'type' => 'date_range',
            'label' => 'Entry Date',
            'date_range_options' => [
                'timePicker' => false,
                'minYear' => now()->subYears(20)->format('Y'),
                'maxYear' => now()->format('Y'),
                'locale' => [
                    'format' => 'DD MMM, YYYY',
                ],
            ],
        ], false, function ($value) {
            $dates = json_decode($value);
            $this->crud->addClause('where', 'created_at', '>=', $dates->from);
            $this->crud->addClause('where', 'created_at', '<=', $dates->to.' 23:59:59');
        });

        $this->crud->addFilter(
            [
                'type' => 'date_range',
                'name' => 'from_to',
                'label' => 'Start Date',
            ],
            false,
            function ($value) {
                // if the filter is active, apply these constraints
                $dates = json_decode($value);
                $this->crud->addClause('where', 'created_at', '>=', $dates->from);
                $this->crud->addClause('where', 'created_at', '<=', $dates->to.' 23:59:59');
            },
        );

        $this->crud->addFilter(
            [
                'type' => 'date_range',
                'name' => 'to_from',
                'label' => 'End Date',
            ],
            false,
            function ($value) {
                // if the filter is active, apply these constraints
                $dates = json_decode($value);
                $this->crud->addClause('where', 'updated_at', '>=', $dates->from);
                $this->crud->addClause('where', 'updated_at', '<=', $dates->to.' 23:59:59');
            },
        );

        $this->crud->addFilter(
            [
                'type' => 'dropdown',
                'name' => 'order_status',
                'label' => 'Status',
            ],
            [
                'Pending' => 'Pending',
                'Approved' => 'Approved',
            ],
            function ($value) {
                // if the filter is active
                $this->crud->addClause('where', 'order_status', $value);
            },
        );

        //        $this->crud->addButtonFromModelFunction('line', 'add_menus', 'buttonOrderLines', 'beginning');
        $this->crud->removeButtons(['create']);
        $this->crud->addClause('isOrderType');

        CRUD::column('id')->type('number')->thousands_sep('');

        CRUD::addColumn([
            'name' => 'order_status',
            'label' => 'Status',
        ]);

        CRUD::addColumn([
            'name' => 'customer',
            'attribute' => 'customer_name',
            'type' => 'custom_html',
            'value' => function ($order) {
                return $order->customer ? '<a href="'.route('customer.show', $order->customer->id).'" target="_blank" class="text-dark">'.$order->customer->customer_name.' - '.$order->customer->customer_code.'</a>' : 'Guest Customer - '.config('amplify.frontend.guest_default');
            },
        ]);
        CRUD::addColumn([
            'name' => 'web_order_number',
            'label' => 'Web Order No',
            'type' => 'custom_html',
            'value' => function ($value) {
                return $value->web_order_number;
            },
        ]);

        CRUD::addColumn([
            'name' => 'customer_order_number',
            'label' => 'Customer Order',
        ]);

        CRUD::addColumn([
            'name' => 'total_amount',
            'label' => 'Total',
            'type' => 'custom_html',
            'value' => function ($order) {
                return "<span class='text-right'>".currency_format($order->total_amount).'</span>';
            },
        ]);

        CRUD::addColumn([
            'name' => 'erp_order_id',
            'label' => 'ERP Order',
        ]);
        if (config('amplify.order.order_rule_check', false)) {
            CRUD::addColumn([
                'name' => 'approval_status',
                'label' => 'Approval',
                'type' => 'select_from_array',
                'options' => config('amplify.constant.order-rule-approval-status'),
            ]);
        }
        CRUD::addColumn([
            'name' => 'warehouses',
            'label' => 'Warehouse',
            'type' => 'closure',
            'function' => function ($entry) {
                $warehouse_ids = $entry->orderLines()->select('warehouse_id')->distinct()->pluck('warehouse_id')->toArray();
                $warehouses = Warehouse::select('name')->whereIn('id', $warehouse_ids)->pluck('name')->toArray();

                return implode('; ', $warehouses);
            },
        ]);
        CRUD::addColumn([
            'name' => 'created_at',
            'label' => 'Created At', // Table column heading
            'type' => 'datetime',
        ]);

        CRUD::addColumn([
            'name' => 'updated_at',
            'label' => 'Last Changed', // Table column heading
            'type' => 'datetime',
        ]);
    }

    protected function setupShowOperation()
    {
        $this->addShowColumns();
    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     *
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $warehouses = Warehouse::orderBy('name')->get()->pluck('name', 'id')->toArray();

        CRUD::setValidation(OrderRequest::class);

        CRUD::removeField('order_type');

        CRUD::removeSaveAction('save_and_new');

        CRUD::addFields([
            [
                'label' => 'Customer', // Table column heading
                'type' => 'select2',
                'name' => 'customer_id', // the column that contains the ID of that connected entity;
                'attribute' => 'customer_name', // foreign key attribute that is shown to user
                'model' => Customer::class, // foreign key model
                'default' => request()->query()['category_name'] ?? '',
                'attributes' => ['disabled' => true],
                'tab' => 'Customer',
            ],
            [
                'name' => 'orderLines',
                'label' => 'Order Lines',
                'type' => 'relationship',
                'tab' => 'Order Line',
                'subfields' => [
                    [
                        'data_source' => backpack_url('order/fetch/products'),
                        'include_all_form_fields' => false,
                        function ($value) {
                            dd($value);
                        },
                        'name' => 'backpackProduct',
                        'label' => 'Product Name',
                        'type' => 'relationship',
                        'entity' => 'backpackProduct', // the relationship name in Model
                        'attribute' => 'product_name', // attribute on Product that is shown to admin,
                        'wrapper' => [
                            'class' => 'form-group col-md-12',
                        ],
                    ],
                    [
                        'name' => 'warehouse_id',
                        'label' => 'Warehouse',
                        'type' => 'select_from_array',
                        'options' => $warehouses,
                        'wrapper' => [
                            'class' => 'form-group col-md-4',
                        ],

                    ],
                    [
                        'name' => 'customer_price',
                        'label' => 'Unit Price',
                        'type' => 'text',
                        'wrapper' => [
                            'class' => 'form-group col-md-3',
                        ],
                        'attributes' => ['class' => 'form-control text-right'],
                    ],
                    [
                        'name' => 'qty',
                        'label' => 'Quantity',
                        'type' => 'text',
                        'wrapper' => [
                            'class' => 'form-group col-md-2',
                        ],
                        'attributes' => ['class' => 'form-control text-right'],
                    ],
                    [
                        'name' => 'subTotal',
                        'label' => 'Sub Total', // Table column heading
                        // 'entity' => 'getSubTotal',
                        'type' => 'text',
                        // 'function_name' => 'getSubTotal', // the method in your Model,
                        'wrapper' => [
                            'class' => 'form-group col-md-3',
                        ],
                        'attributes' => ['class' => 'form-control text-right'],
                    ],
                ],
            ],
            [
                'name' => 'quote_price_update',
                'type' => 'boolean',
                'label' => 'Quote Price Update',
                'tab' => 'Other',
            ],
            [
                'name' => 'web_order_number',
                'type' => 'text',
                'label' => 'Web Order Number',
                'tab' => 'Order Line',
            ],
            [
                'label' => 'Contact',
                'type' => 'select2',
                'name' => 'contact_id',
                'entity' => 'contact',
                'attribute' => 'name',
                'options' => function ($query) {
                    return $query->where('customer_id', $this->crud->getCurrentEntry()->customer_id)->get();
                },
                'tab' => 'Customer',
            ],
            [
                // select2_from_array
                'name' => 'order_status',
                'label' => 'Status',
                'type' => 'select2_from_array',
                'options' => ['Approved' => 'Approved', 'Pending' => 'Pending'],
                'allows_null' => false,
                'default' => 'one',
                'tab' => 'Other',
            ],
            [
                'name' => 'customer_order_number',
                'type' => 'text',
                'label' => 'Customer Order Number',
                'tab' => 'Order Line',
            ],
            [
                'name' => 'submitted_at',
                'label' => 'Submitted At',
                'type' => 'datetime',
                'tab' => 'Other',
            ],
            [
                'name' => 'total_net_price',
                'type' => 'text',
                'label' => 'Total Net Price',
                'tab' => 'Order Line',
            ],
            [
                'name' => 'total_tax_amount',
                'type' => 'text',
                'label' => 'Total Tax Amount',
                'tab' => 'Order Line',
            ],
            [
                'name' => 'total_shipping_cost',
                'type' => 'text',
                'label' => 'Total Shipping Cost',
                'tab' => 'Order Line',
            ],
            [
                'name' => 'total_amount',
                'type' => 'text',
                'label' => 'Total Amount',
                'tab' => 'Order Line',
            ],
            [
                'name' => 'shipping_method',
                'type' => 'select_from_array',
                'label' => 'Shipping Method',
                'placeholder' => 'Select an option',
                'allows_null' => false,
                'options' => (function () {
                    $shipping_methods = [];
                    ErpApi::getShippingOption()->map(function ($sh_method) use (&$shipping_methods) {
                        $shipping_methods[$sh_method->CarrierCode] = $sh_method->CarrierDescription;
                    });

                    return $shipping_methods;
                })(),
                'tab' => 'Notes',
            ],
            [
                'name' => 'draft_name',
                'type' => 'text',
                'label' => 'Draft Name',
                'tab' => 'Notes',
            ],
            [
                'name' => 'erp_order_id',
                'type' => 'text',
                'label' => 'Erp Order Id',
                'tab' => 'Notes',
            ],
            [
                'label' => 'Approver',
                'type' => 'select2',
                'name' => 'approver_id',
                'attribute' => 'name',
                'entity' => 'approver',
                'options' => function ($query) {
                    return $query->where('customer_id', $this->crud->getCurrentEntry()->customer_id)->get();
                },
                'tab' => 'Customer',
            ],
            [
                'name' => 'created_at',
                'label' => 'Created At',
                'type' => 'datetime',
                'tab' => 'Other',
            ],
            [
                'name' => 'updated_at',
                'label' => 'Last Changed',
                'type' => 'datetime',
                'tab' => 'Other',
            ],
            [
                'name' => 'orderNotes',
                'label' => 'Order Notes',
                'type' => 'relationship',
                'tab' => 'Notes',
                'subfields' => [
                    [
                        'name' => 'note',
                        'type' => 'text',
                        'wrapper' => [
                            'class' => 'form-group col-md-6',
                        ],
                    ],
                    [
                        'name' => 'subject',
                        'type' => 'text',
                        'wrapper' => [
                            'class' => 'form-group col-md-6',
                        ],
                    ],
                ],
            ],
        ]);

        if (config('amplify.order.order_rule_check', false)) {
            CRUD::addField([
                'name' => 'approval_status',
                'label' => 'Approval',
                'tab' => 'Other',
                'type' => 'select_from_array',
                'options' => config('amplify.constant.order-rule-approval-status'),
            ]);
        }

    }

    public function update(Request $request)
    {
        $oldOrderNotes = CustomerOrderNote::select(['id', 'note', 'erp_note_id'])->where('customer_order_id', $request->id)->get();
        $redirect_location = $this->traitUpdate();
        $newOrderNotes = $this->crud->entry->orderNotes()->select(['id', 'note', 'erp_note_id'])->get();
        $diffOrderNotes = $newOrderNotes->diffAssoc($oldOrderNotes);

        foreach ($diffOrderNotes as $orderNote) {
            $resErp = \ErpApi::createOrUpdateNote([
                'orderNumber' => $this->crud->entry->erp_order_id,
                'noteNumber' => $orderNote->erp_note_id,
                'note' => $orderNote->note,
            ]);

            if ($resErp->Status == 'Complete') {
                $orderNote->update([
                    'erp_note_id' => $resErp->NoteNum,
                ]);
            }

            NotificationFactory::call(Event::ORDER_NOTES_UPDATED, [
                'customer_order_note_id' => $orderNote->id,
            ]);
        }

        return $redirect_location;
    }

    private function addShowColumns()
    {
        CRUD::addColumns([
            [
                'name' => 'order_status',
                'type' => 'text',
                'label' => 'Order Status',
            ],
            [
                'name' => 'web_order_number',
                'type' => 'text',
                'label' => 'Web Order Number',
            ],
            [
                'name' => 'customer',
                'attribute' => 'customer_name',
                'type' => 'custom_html',
                'value' => function ($order) {
                    return $order->customer ? '<a href="'.route('customer.show', $order->customer->id).'" target="_blank" class="text-dark">'.$order->customer->customer_name.' - '.$order->customer->customer_code.'</a>' : 'Guest Customer - '.config('amplify.frontend.guest_default');
                },
            ],
            [
                'name' => 'contact',
                'attribute' => 'contact_name',
                'type' => 'custom_html',
                'value' => function ($order) {
                    return $order->contact ? '<a href="'.route('contact.show', $order->contact->id).'" target="_blank" class="text-dark">'.$order->contact->name.' - '.$order->contact->email.'</a>' : 'Guest Customer';
                },
            ],
            [
                'name' => 'customer_order_number',
                'type' => 'text',
                'label' => 'Customer Order Number',
            ],
            [
                'name' => 'customer_name',
                'type' => 'text',
                'label' => 'Customer Name',
            ],
            [
                'name' => 'email',
                'type' => 'text',
                'label' => 'Email',
            ],
            [
                'name' => 'phone',
                'type' => 'text',
                'label' => 'Phone',
            ],
            [
                'name' => 'ship_address',
                'type' => 'textarea',
                'label' => 'Shipping Address',
            ],
            [
                'name' => 'erp_order_id',
                'type' => 'text',
                'label' => 'Erp Order Id',
            ],
            [
                'name' => 'created_at',
                'label' => 'Created At', // Table column heading
                'type' => 'model_function',
                'function_name' => 'getFormattedCreatedAtValue',
            ],
            [
                'name' => 'updated_at',
                'label' => 'Last Changed', // Table column heading
                'type' => 'model_function',
                'function_name' => 'getFormattedUpdatedAtValue',
            ],
            [
                'name' => 'orderLines',
                'label' => 'Order Lines',
                'type' => 'table-related',
                'columns' => [
                    [
                        'name' => 'local_product_name',
                        'label' => 'Name',
                        'type' => 'text',
                        'entity' => 'product', // the relationship name in Model
                        'attribute' => 'local_product_name', // attribute on Product that is shown to admin
                    ],
                    [
                        'name' => 'customer_price',
                        'label' => 'Unit Price',
                        'type' => 'text',
                    ],
                    [
                        'name' => 'qty',
                        'label' => 'Quantity',
                        'type' => 'text',
                    ],
                    [
                        'name' => 'sub_total',
                        'label' => 'Sub Total', // Table column heading
                        'type' => 'model_function',
                        'function_name' => 'getSubTotal', // the method in your Model
                    ],
                    [
                        'name' => 'warehouse',
                        'label' => 'Warehouse',
                        'type' => 'relationship',
                        'entity' => 'warehouse',
                        'attribute' => 'name',
                    ],
                ],
            ],
            [
                'name' => 'total_net_price',
                'type' => 'number',
                'label' => 'Total Net Price',
                'decimals' => 2,
            ],
            [
                'name' => 'shipping_method',
                'type' => 'text',
                'label' => 'Shipping Option',
            ],
            [
                'name' => 'total_tax_amount',
                'type' => 'number',
                'label' => 'Total Tax Amount',
                'decimals' => 2,
            ],
            [
                'name' => 'total_shipping_cost',
                'type' => 'number',
                'label' => 'Total Shipping Cost',
                'decimals' => 2,
            ],
            [
                'name' => 'hazmat_charge_from_json',
                'label' => 'Hazmat Charge',
                'type' => 'model_function',
                'function_name' => 'getHazmatChargeFromJson',
                'decimals' => 2,
            ],
            [
                'name' => 'total_amount',
                'type' => 'number',
                'label' => 'Total Amount',
                'decimals' => 2,
            ],
            [
                'name' => 'notes',
                'type' => 'textarea',
                'label' => 'Notes',
            ],
            [
                'name' => 'draft_name',
                'type' => 'text',
                'label' => 'Draft Name',
            ],
            [
                'name' => 'approver_name',
                'label' => 'Approver',
                'entity' => 'approver',
                'attribute' => 'name',
            ],
            [
                'name' => 'submitted_at',
                'label' => 'Submitted At',
                'type' => 'model_function',
                'function_name' => 'getFormattedSubmittedAtValue',
            ],
        ]);
    }

    public function destroy($id)
    {
        $this->crud->hasAccessOrFail('delete');

        $this->crud->getCurrentEntry()->orderLines()->delete();

        $id = $this->crud->getCurrentEntryId() ?? $id;

        return $this->crud->delete($id);
    }
}
