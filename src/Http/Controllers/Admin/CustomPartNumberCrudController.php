<?php

namespace Amplify\System\Backend\Http\Controllers\Admin;

use Amplify\System\Abstracts\BackpackCustomCrudController;
use Amplify\System\Backend\Http\Requests\CustomerProductRequest;
use Amplify\System\Backend\Models\Customer;
use Amplify\System\Backend\Models\CustomerAddress;
use Amplify\System\Backend\Models\CustomPartNumber;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use \Backpack\Pro\Http\Controllers\Operations\FetchOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanel;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Support\Facades\DB;

/**
 * Class CustomPartNumberCrudController
 *
 * @property-read CrudPanel $crud
 */
class CustomPartNumberCrudController extends BackpackCustomCrudController
{
    use CreateOperation;
    use DeleteOperation;
    use FetchOperation;
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
        CRUD::setModel(CustomPartNumber::class);
        CRUD::setRoute(config('backpack.base.route_prefix').'/custom-part-number');
        CRUD::setEntityNameStrings('custom-part-number', 'custom part numbers');
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
        CRUD::column('product_id')
            ->type('relationship')
            ->label('Product')
            ->entity('product')
            ->attribute('product_name');

        CRUD::column('customer_id')
            ->type('relationship')
            ->label('Customer')
            ->entity('customer')
            ->attribute('display_name');

        CRUD::column('customer_product_code')
            ->type('text')
            ->label('Product Code');

        CRUD::column('customer_product_uom')
            ->type('text')
            ->label('UOM');

        CRUD::column('customer_address_id')
            ->label('Customer Ship To')
            ->entity('customerAddress')
            ->attribute('display_name');

        CRUD::column('updated_at');
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
        CRUD::setValidation(CustomerProductRequest::class);

        CRUD::addField([
            'name' => 'customer_id',
            'label' => 'Customer',
            'type' => 'relationship',
            'attribute' => 'display_name',
            'ajax' => true,
            'entity' => 'customer',
            'model' => Customer::class,
            'placeholder' => 'Select Customer',
            'delay' => 200,
            'data_source' => backpack_url('contact/fetch/customer'),
            'method' => 'POST',
            'default' => old('customer_id', $this->crud->entry->customer_id ?? null),
        ]);

        CRUD::addField([
            'name' => 'customer_address_id',
            'label' => 'Customer Ship To Address',
            'type' => 'relationship',
            'ajax' => true,
            'attribute' => 'display_name',
            'entity' => 'customerAddress',
            'model' => CustomerAddress::class,
            'placeholder' => 'Select an Customer Ship To Address',
            'delay' => 200,
            'data_source' => backpack_url('custom-part-number/fetch/customer-address'),
            'minimum_input_length' => 0,
            'dependencies' => ['customer_id'],
            'method' => 'POST',
            'include_all_form_fields' => true,
            'default' => old('customer_address_id', $this->crud->entry->customer_address_id ?? null),
        ]);

        CRUD::addField([
            'label' => 'Product', // Table column heading
            'type' => 'easyask_product_search',
            'name' => 'product_id', // the column that contains the ID of that connected entity;
            'attribute' => 'display_name', // foreign key attribute that is shown to user
            'placeholder' => 'Select Product',
            'delay' => 200,
            'ajax' => true,
            'entity' => 'product',
            'default' => old('product_id', $this->crud->entry->product_id ?? null),
        ]);

        CRUD::field('customer_product_code')->type('text')->label('Customer Product Code');

        CRUD::field('customer_product_uom')->type('text')->label('Customer Product UOM');

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
        $this->setupCreateOperation();
    }

    public function fetchCustomerAddress()
    {
        $inputs = backpack_form_input();

        return $this->fetch([
            'model' => CustomerAddress::class,
            'searchable_attributes' => ['address_code', 'address_name', 'address_1', 'address_2', 'address_3', 'zip_code', 'city', 'country_code', 'state'],
            'paginate' => 10,
            'searchOperator' => 'LIKE',
            'query' => fn ($model) => $model
                ->select(
                    'id', 'address_code', 'address_name', 'customer_id', DB::raw('CONCAT(address_code," - ",address_name) AS display_name')
                )
                ->where('customer_id', $inputs['customer_id'])
                ->orderBy('updated_at', 'asc'),
        ]);
    }
}
