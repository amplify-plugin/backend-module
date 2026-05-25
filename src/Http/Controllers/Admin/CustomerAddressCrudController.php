<?php

namespace Amplify\System\Backend\Http\Controllers\Admin;

use Amplify\System\Abstracts\BackpackCustomCrudController;
use Amplify\System\Backend\Http\Requests\CustomerAddressRequest;
use Amplify\System\Backend\Models\Country;
use Amplify\System\Backend\Models\CustomerAddress;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanel;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class CustomerAddressCrudController
 *
 * @property-read CrudPanel $crud
 */
class CustomerAddressCrudController extends BackpackCustomCrudController
{
    use CreateOperation {
        store as traitStore;
    }

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
        CRUD::setModel(CustomerAddress::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/customer-address');
        CRUD::setEntityNameStrings('customer-address', 'customer addresses');
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
        CRUD::removeButton('show');

        $this->crud->addFilter([
            'name' => 'synced_at',
            'type' => 'dropdown',
            'label' => 'Is Synced',
        ],
            function () {
                return [
                    '1' => 'Yes',
                    '0' => 'No',
                ];
            },
            function ($value) {
                if ($value == '1') {
                    $this->crud->addClause('whereNotNull', 'synced_at');
                }

                if ($value == '0') {
                    $this->crud->addClause('whereNull', 'synced_at');
                }
            });

        // Filtering with customer
        CRUD::addFilter(
            [
                'name' => 'customer_id',
                'type' => 'select2_ajax',
                'label' => 'Customer',
                'placeholder' => 'Type Name, Code, Email, Phone',
                'method' => 'POST',
                'select_attribute' => 'customer_name',
            ],
            backpack_url('contact/fetch/customer'),
            function ($value) { // if the filter is active
                $this->crud->query->where('customer_id', '=', $value);
            }
        );

        if (!config('amplify.erp.auto_create_ship_to')) {
            $this->crud->removeButton('create');
        }

        CRUD::column('id');
        CRUD::column('address_code');
        CRUD::column('address_name');
        CRUD::column('address_1');
        CRUD::column('address_2');
        CRUD::column('address_3');
        CRUD::column('zip_code');
        CRUD::column('city');
        CRUD::column('state');
        CRUD::column('country_code');
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
        CRUD::setValidation(CustomerAddressRequest::class);

        $countries = Country::enabled()->get()->pluck('name', 'iso2')->toArray();

        CRUD::addFields([
            [
                'label' => 'Customer', // Table column heading
                'type' => 'select2_from_ajax',
                'name' => 'customer_id', // the column that contains the ID of that connected entity;
                'attribute' => 'display_name', // foreign key attribute that is shown to user
                'data_source' => backpack_url('contact/fetch/customer'),
                'method' => 'POST',
                'default' => old('customer_id', $this->crud->entry->customer_id ?? null),
            ],
            [
                'name' => 'address_code',
                'type' => 'text',
                'label' => 'Address Code',
                'allows_null' => false,
            ],
            [
                'name' => 'address_1',
                'type' => 'text',
                'label' => 'Address Line 1',
                'allows_null' => false,
            ],
            [
                'name' => 'address_2',
                'type' => 'text',
                'label' => 'Address Line 2',
            ],
            [
                'name' => 'address_3',
                'type' => 'text',
                'label' => 'Address Line 3',
            ],
            [
                'name' => 'city',
                'type' => 'text',
                'label' => 'City',
                'wrapper' => [
                    'class' => 'form-group col-md-6',
                ],
            ],
            [
                'name' => 'country_code',
                'type' => 'select2_from_array',
                'options' => $countries,
                'label' => 'Country',
                'wrapper' => [
                    'class' => 'form-group col-md-6',
                ],
            ],
            [
                'model' => \Amplify\System\Backend\Models\State::class,
                'attribute' => 'name',
                'data_source' => backpack_url('state/fetch/state-by-country-code'),
                'placeholder' => 'Select an state',
                'include_all_form_fields' => true,
                'method' => 'POST',
                'minimum_input_length' => 0,
                'dependencies' => ['country_code'],
                'name' => 'state',
                'type' => 'select2_from_ajax',
                'label' => 'State',
                'wrapper' => [
                    'class' => 'form-group col-md-6',
                ],
            ],
            [
                'name' => 'zip_code',
                'type' => 'text',
                'label' => 'Zip Code',
                'wrapper' => [
                    'class' => 'form-group col-md-6',
                ],
            ],
            [
                'name' => 'phone',
                'type' => 'text',
                'label' => 'Phone',
            ],
        ]);
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
}
