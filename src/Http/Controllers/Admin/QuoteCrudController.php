<?php

namespace Amplify\System\Backend\Http\Controllers\Admin;

use Amplify\System\Abstracts\BackpackCustomCrudController;
use Amplify\System\Backend\Http\Requests\QuoteRequest;
use Amplify\System\Backend\Models\CustomerOrder;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanel;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class QuoteCrudController
 *
 * @property-read CrudPanel $crud
 */
class QuoteCrudController extends BackpackCustomCrudController
{
    use CreateOperation;
    use DeleteOperation;
    use ListOperation;
    use ShowOperation;
    use UpdateOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(CustomerOrder::class);
        CRUD::setRoute(config('backpack.base.route_prefix').'/quote');
        CRUD::setEntityNameStrings('quote', 'quotes');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     *
     * @return void
     */
    protected function setupListOperation()
    {
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
                'Draft' => 'Draft',
            ],
            function ($value) {
                // if the filter is active
                $this->crud->addClause('where', 'order_status', $value);
            },
        );

        $this->crud->removeButtons(['create']);

        $this->crud->addClause('isRfqType');

        CRUD::column('id')->type('number')->thousands_sep('');

        CRUD::addColumn([
            'name' => 'customer',
            'attribute' => 'customer_name',
            'type' => 'custom_html',
            'value' => function ($order) {
                return $order->customer ? '<a href="'.route('customer.show', $order->customer->id).'" target="_blank" class="text-dark">'.$order->customer->customer_name.' - '.$order->customer->customer_code.'</a>' : '';
            },
        ]);

        CRUD::addColumn([
            'name' => 'web_order_number',
            'label' => 'Web Order No',
            'type' => 'custom_html',
            'value' => function ($value) {
                return config('amplify.basic.web_order_prefix').$value->web_order_number;
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

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     *
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(QuoteRequest::class);

        CRUD::setFromDb(); // fields
        CRUD::removeField('order_type');

        CRUD::addField(['name' => 'price', 'type' => 'number']);

        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number']));
         */
    }

    protected function setupShowOperation()
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
                'name' => 'customer_name',
                'label' => 'Customer',
                'entity' => 'customer', // the relationship name in your Model
                'attribute' => 'customer_name', // attribute on Article that is shown to admin
            ],
            [
                'name' => 'contact_name',
                'label' => 'Contact',
                'entity' => 'contact', // the relationship name in your Model
                'attribute' => 'name', // attribute on Article that is shown to admin
            ],
            [
                'name' => 'customer_order_number',
                'type' => 'text',
                'label' => 'Customer Order Number',
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
                'view_namespace' => 'backend::columns',
                'columns' => [
                    [
                        'name' => 'product_code',
                        'label' => 'Product Code',
                        'type' => 'text',
                    ],
                    [
                        'name' => 'product_name',
                        'label' => 'Name',
                        'type' => 'text',
                        'entity' => 'product', // the relationship name in Model
                        'attribute' => 'product_name', // attribute on Product that is shown to admin
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
                'name' => 'ship_to_address',
                'type' => 'textarea',
                'label' => 'Shipping Address',
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
                'name' => 'total_amount',
                'type' => 'number',
                'label' => 'Total Amount',
                'decimals' => 2,
            ],
            [
                'name' => 'orderNotes',
                'label' => 'Order Notes',
                'type' => 'table-related',
                'columns' => [
                    [
                        'name' => 'subject',
                        'label' => 'Subject',
                        'type' => 'text',
                    ],
                    [
                        'name' => 'formatted_date',
                        'label' => 'Date',
                        'type' => 'model_function',
                        'function_name' => 'getFormattedDateValue',
                    ],
                    [
                        'name' => 'note',
                        'label' => 'Note',
                        'type' => 'text',
                    ],
                ],
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

        $this->crud->removeFields(['order_type']);
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
        CRUD::field('customer_id')->type('select2')->model('Amplify\System\Backend\Models\Contact')->attribute('name');

        $this->crud->addField([   // select2_from_array
            'name' => 'order_status',
            'label' => 'Status',
            'type' => 'select2_from_array',
            'options' => ['Approved' => 'Approved', 'Pending' => 'Pending'],
            'allows_null' => false,
            'default' => 'one',
            // 'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
        ]);

        $this->setupCreateOperation();
    }
}
