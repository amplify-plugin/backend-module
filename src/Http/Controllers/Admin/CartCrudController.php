<?php

namespace Amplify\System\Backend\Http\Controllers\Admin;

use Amplify\System\Backend\Models\Cart;
use Backpack\CRUD\app\Http\Controllers\CrudController;

use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class CartCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class CartCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\BulkDeleteOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(Cart::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/cart');
        CRUD::setEntityNameStrings('cart', 'carts');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        $this->crud->addFilter([
            'name' => 'status',
            'type' => 'dropdown',
            'label' => 'Status',
        ],
            function () {
                return ['1' => 'Yes', '0' => 'No'];
            },
            function ($value) {
                $this->crud->addClause('where', 'status', $value);
            });

        CRUD::column('contact_id');
        CRUD::column('status');
        CRUD::column('cartItems_count')->label('Items');
        CRUD::column('sub_total');
        CRUD::column('tax_amount');
        CRUD::column('ship_charge');
        CRUD::column('total');
        CRUD::column('currency');
        CRUD::column('created_at');
        CRUD::column('updated_at');
    }

    /**
     * Define what happens when the Show operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-show
     * @return void
     */
    protected function setupShowOperation()
    {
        CRUD::addColumns([
            [
                'name' => 'contact_id',
                'label' => 'Contact',
                'type' => 'relationship',
                'entity' => 'contact',
                'attribute' => 'name',
            ],
            [
                'name' => 'status',
                'label' => 'Status',
                'type' => 'boolean',
            ],
            [
                'name' => 'sub_total',
                'label' => 'Sub Total',
                'type' => 'money',
                'view_namespace' => 'backend'
            ],
            [
                'name' => 'tax_amount',
                'label' => 'Tax Amount',
                'type' => 'money',
                'view_namespace' => 'backend'
            ],
            [
                'name' => 'ship_charge',
                'label' => 'Ship Charge',
                'type' => 'money',
                'view_namespace' => 'backend'
            ],
            [
                'name' => 'total',
                'label' => 'Total',
                'type' => 'money',
                'view_namespace' => 'backend'
            ],
            [
                'name' => 'created_at',
                'label' => 'Created At',
                'type' => 'datetime',
            ],
            [
                'name' => 'updated_at',
                'label' => 'Last Modified',
                'type' => 'datetime',
            ],
            [
            'name' => 'cartItems',
            'type' => 'table-related',
            'label' => 'Items',
            'view_namespace' => 'backend::columns',
            'columns' => [
                [
                    'name' => 'id',
                    'type' => 'text',
                    'label' => '#',
                ],
                [
                    'name' => 'product_id',
                    'type' => 'text',
                    'label' => 'Product ID',
                ],
                [
                    'name' => 'product_code',
                    'type' => 'text',
                    'label' => 'Product Code',
                ],
                [
                    'name' => 'warehouse_id',
                    'type' => 'text',
                    'label' => 'Warehouse ID',
                ],
                [
                    'name' => 'product_warehouse_code',
                    'type' => 'text',
                    'label' => 'Warehouse Code',
                ],
                [
                    'name' => 'quantity',
                    'type' => 'text',
                    'label' => 'Quantity',
                ],
                [
                    'name' => 'uom',
                    'type' => 'text',
                    'label' => 'UoM',
                ],
                [
                    'name' => 'unitprice',
                    'type' => 'text',
                    'label' => 'Unit Price',
                ],
                [
                    'name' => 'subtotal',
                    'type' => 'text',
                    'label' => 'SubTotal',
                ],
                [
                    'name' => 'address_id',
                    'type' => 'text',
                    'label' => 'Address Id',
                ],
                [
                    'name' => 'product_name',
                    'type' => 'text',
                    'label' => 'Product Name',
                ],
                [
                    'name' => 'product_back_order',
                    'type' => 'text',
                    'label' => 'Back Ordered',
                ],
                [
                    'name' => 'product_image',
                    'type' => 'text',
                    'label' => 'Product Image',
                ],
                [
                    'name' => 'source_type',
                    'type' => 'text',
                    'label' => 'Source Type',
                ],
                [
                    'name' => 'source',
                    'type' => 'text',
                    'label' => 'Source',
                ],
                [
                    'name' => 'expiry_date',
                    'type' => 'text',
                    'label' => 'Expiry Date',
                ],
                [
                    'name' => 'additional_info',
                    'type' => 'text',
                    'label' => 'Additional',
                ],
                [
                    'name' => 'error',
                    'type' => 'text',
                    'label' => 'Error',
                ],
                [
                    'name' => 'created_at',
                    'type' => 'text',
                    'label' => 'Created',
                ],
                [
                    'name' => 'updated_at',
                    'type' => 'text',
                    'label' => 'Updated',
                ],
            ],
        ]
        ]);
    }

}
