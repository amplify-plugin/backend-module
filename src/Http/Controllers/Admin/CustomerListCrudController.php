<?php

namespace Amplify\System\Backend\Http\Controllers\Admin;

use Amplify\System\Abstracts\BackpackCustomCrudController;
use Amplify\System\Backend\Models\Contact;
use Amplify\System\Backend\Models\OrderList;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanel;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class ListsCrudController
 *
 * @property-read CrudPanel $crud
 */
class CustomerListCrudController extends BackpackCustomCrudController
{
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
        CRUD::setModel(OrderList::class);
        CRUD::setRoute(config('backpack.base.route_prefix').'/customer-list');
        CRUD::setEntityNameStrings('customer-list', 'customer lists');
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
        CRUD::column('id')->type('number')->thousands_sep('');

        CRUD::addColumn([
            'name' => 'customer_name',
            'label' => 'Customer',
            'type' => 'model_function',
            'function_name' => 'getCustomerName',
        ]);

        CRUD::addColumn([
            'name' => 'name',
            'label' => 'Name',
        ]);

        CRUD::addColumn([
            'name' => 'list_type',
            'label' => 'Type',
            'type' => 'select_from_array',
            'options' => [
                'personal' => 'Personal',
                'global' => 'Global',
            ],
        ]);

        CRUD::addColumn([
            'name' => 'contact_name',
            'label' => 'Contact',
            'entity' => 'contact', // the relationship name in your Model
            'attribute' => 'name', // attribute on Article that is shown to admin
        ]);

        $this->crud->addFilter([
            'type' => 'dropdown',
            'name' => 'list_type',
            'label' => 'Type',
        ], [
            'personal' => 'Personal',
            'global' => 'Global',
        ], function ($value) { // if the filter is active
            $this->crud->addClause('where', 'list_type', $value);
        });

        $this->crud->addFilter([
            'name' => 'contact_name',
            'type' => 'select2',
            'label' => 'Contact',
        ], function () {
            $customers = Contact::orderBy('name')->pluck('name', 'id')->toArray();

            return $customers;
        }, function ($value) { // if the filter is active
            $this->crud->addClause('whereHas', 'contact', function ($query) use ($value) {
                $query->where('id', '=', $value);
            });
        });

        // Filtering with customer
        CRUD::addFilter(
            [
                'name' => 'customer_name',
                'type' => 'select2_ajax',
                'label' => 'Customer',
                'placeholder' => 'Type Name, Code, Email, Phone',
                'method' => 'POST',
                'select_attribute' => 'customer_name',
            ],
            backpack_url('contact/fetch/customer'),
            function ($value) { // if the filter is active
                $this->crud->addClause('whereHas', 'contact', function ($query) use ($value) {
                    $query->whereHas('customer', function ($q) use ($value) {
                        $q->where('id', $value);
                    });
                });
            }
        );

        $this->crud->removeButtons(['create']);

        // CRUD::column('email');

        // CRUD::column('phone');

        // CRUD::addColumn([
        //     'name'  => 'punch_out',
        //     'label' => 'Punch Out',
        //     'type'  => 'boolean'
        // ]);

        // CRUD::addColumn([
        //     'name'  => 'customer_type',
        //     'label' => 'Customer Type',
        // ]);

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']);
         */
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
        CRUD::field('name')->type('text');
        CRUD::field('description')->type('textarea');
        CRUD::addField([
            'name' => 'list_type',
            'label' => 'List Type',
            'type' => 'select_from_array',
            'options' => ['personal' => 'Personal', 'global' => 'Global'],
            'allows_null' => false,
            'allows_multiple' => false,
        ]);

        CRUD::addField([
            'name' => 'orderListItems',
            'label' => 'List Items',
            'type' => 'relationship',
            'subfields' => [
                [
                    'name' => 'product',
                    'label' => 'Product Name',
                    'type' => 'relationship',
                    'entity' => 'product',
                    'attribute' => 'product_name',
                    'wrapper' => [
                        'class' => 'form-group col-md-9',
                    ],
                    'options' => (fn ($query) => $query->orderBy('product_name')->get()),
                ],
                [
                    'name' => 'qty',
                    'label' => 'Quantity',
                    'type' => 'text',
                    'wrapper' => [
                        'class' => 'form-group col-md-3',
                    ],
                ],
            ],
        ]);

    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     *
     * @return void
     */
    protected function setupShowOperation()
    {
        CRUD::column('id')->type('number')->thousands_sep('');

        CRUD::addColumn([
            'name' => 'name',
            'label' => 'Name',
        ]);
        CRUD::addColumn([
            'name' => 'description',
            'label' => 'Description',
        ]);
        CRUD::addColumn([
            'name' => 'list_type',
            'label' => 'List Type',
            'type' => 'select_from_array',
            'options' => [
                'personal' => 'Personal',
                'global' => 'Global',
            ],
        ]);
        CRUD::addColumn([
            'name' => 'customer.customer_name',
            'label' => 'Customer',
            'type' => 'relationship',
        ]);

        CRUD::addColumn([
            'name' => 'contact.name',
            'label' => 'Contact',
            'type' => 'relationship',
        ]);
        CRUD::addColumn([
            'name' => 'orderListItems',
            'label' => 'List Items',
            'type' => 'table-related',
            'columns' => [
                [
                    'name' => 'product',
                    'label' => 'Name',
                    'type' => 'relationship',
                    'entity' => 'product',
                    'attribute' => 'product_name',
                ],
                [
                    'name' => 'qty',
                    'label' => 'Quantity',
                    'type' => 'text',
                ],
            ],
        ]);
    }
}
