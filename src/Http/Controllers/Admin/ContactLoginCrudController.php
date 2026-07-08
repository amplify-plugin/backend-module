<?php

namespace Amplify\System\Backend\Http\Controllers\Admin;

use Amplify\System\Abstracts\BackpackCustomCrudController;
use Amplify\System\Backend\Models\ContactLogin;
use Backpack\CRUD\app\Exceptions\BackpackProRequiredException;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanel;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class ContactLoginCrudController
 *
 * @property-read CrudPanel $crud
 */
class ContactLoginCrudController extends BackpackCustomCrudController
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
        CRUD::setModel(ContactLogin::class);
        CRUD::setRoute(config('backpack.base.route_prefix').'/contact-login');
        CRUD::setEntityNameStrings('contact login', 'contact logins');

        if (! backpack_user()?->is_admin) {
            CRUD::denyAccess(['create', 'update']);
        }

        $this->crud->query->with([
            'contact',
            'customer',
            'warehouse',
            'customerAddress',
            'impersonator',
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

        CRUD::addFilter([
            'name' => 'row_type',
            'type' => 'dropdown',
            'label' => 'Row Type',
        ], function () {
            return [
                ContactLogin::ROW_TYPE_ASSIGNMENT => 'Assignment',
                ContactLogin::ROW_TYPE_SESSION => 'Session',
            ];
        }, function ($value) {
            $this->crud->addClause('where', 'row_type', $value);
        });

        CRUD::addFilter([
            'name' => 'created_between',
            'type' => 'date_range',
            'label' => 'Created/Registered',
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

        CRUD::addFilter([
            'name' => 'session_status',
            'type' => 'dropdown',
            'label' => 'Session Status',
        ], function () {
            return [
                'open' => 'Open',
                'closed' => 'Closed',
            ];
        }, function ($value) {
            $this->crud->addClause('where', 'row_type', ContactLogin::ROW_TYPE_SESSION);

            if ($value === 'open') {
                $this->crud->addClause('whereNull', 'last_logged_out');
            }

            if ($value === 'closed') {
                $this->crud->addClause('whereNotNull', 'last_logged_out');
            }
        });

        CRUD::addColumn([
            'name' => 'row_type',
            'label' => 'Type',
            'type' => 'enum',
            'options' => [
                ContactLogin::ROW_TYPE_ASSIGNMENT => 'Assignment',
                ContactLogin::ROW_TYPE_SESSION => 'Session',
            ],
        ]);

        CRUD::addColumn([
            'name' => 'contact_display',
            'label' => 'Contact',
            'type' => 'model_function',
            'function_name' => 'getContactDisplayLabel',
        ]);

        CRUD::addColumn([
            'name' => 'customer_display',
            'label' => 'Customer',
            'type' => 'model_function',
            'function_name' => 'getCustomerDisplayLabel',
        ]);

        CRUD::addColumn([
            'name' => 'impersonator_name',
            'label' => 'Initiated By',
            'type' => 'model_function',
            'function_name' => 'getImpersonatorDisplayName',
        ]);

        CRUD::addColumn([
            'name' => 'warehouse_id',
            'label' => 'Warehouse',
            'type' => 'model_function',
            'function_name' => 'getWarehouseDisplayLabel',
        ]);

        CRUD::addColumn([
            'name' => 'customer_address_display',
            'label' => 'Customer address',
            'type' => 'model_function',
            'function_name' => 'getCustomerAddressDisplayLabel',
        ]);

        CRUD::column('ship_to_name');

        CRUD::column('last_logged_in')->type('datetime');
        CRUD::column('last_logged_out')->type('datetime');
        CRUD::column('active')->type('boolean');

        $this->addTimestampColumnsForSuperAdmin();
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
        CRUD::addField([
            'name' => 'row_type',
            'type' => 'enum',
            'options' => [
                ContactLogin::ROW_TYPE_ASSIGNMENT => 'Assignment',
                ContactLogin::ROW_TYPE_SESSION => 'Session',
            ],
            'default' => ContactLogin::ROW_TYPE_ASSIGNMENT,
        ]);
        CRUD::addField([
            'name' => 'contact_id',
            'options' => (fn ($query) => $query->orderBy('name')->get()),
        ]);
        CRUD::addField([
            'name' => 'customer_id',
        ]);
        CRUD::addField([
            'name' => 'warehouse_id',
            'options' => (fn ($query) => $query->orderBy('name')->get()),
        ]);
        CRUD::field('customer_address_id');
        CRUD::field('ship_to_name');
        CRUD::field('last_logged_in');
        CRUD::field('last_logged_out');
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

    /**
     * Define what happens when the Show operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-show
     *
     * @return void
     */
    protected function setupShowOperation()
    {
        $this->crud->set('show.setFromDb', false);

        CRUD::column('id');

        CRUD::addColumn([
            'name' => 'row_type',
            'label' => 'Type',
            'type' => 'enum',
            'options' => [
                ContactLogin::ROW_TYPE_ASSIGNMENT => 'Assignment',
                ContactLogin::ROW_TYPE_SESSION => 'Session',
            ],
        ]);

        CRUD::addColumn([
            'name' => 'contact_display',
            'label' => 'Contact',
            'type' => 'model_function',
            'function_name' => 'getContactDisplayLabel',
            'limit' => 9999,
        ]);

        CRUD::addColumn([
            'name' => 'customer_display',
            'label' => 'Customer',
            'type' => 'model_function',
            'function_name' => 'getCustomerDisplayLabel',
            'limit' => 9999,
        ]);

        CRUD::addColumn([
            'name' => 'impersonator_name',
            'label' => 'Initiated By',
            'type' => 'model_function',
            'function_name' => 'getImpersonatorDisplayName',
            'limit' => 9999,
        ]);

        CRUD::addColumn([
            'name' => 'warehouse_display',
            'label' => 'Warehouse',
            'type' => 'model_function',
            'function_name' => 'getWarehouseDisplayLabel',
            'limit' => 9999,
        ]);

        CRUD::addColumn([
            'name' => 'customer_address_display',
            'label' => 'Customer address',
            'type' => 'model_function',
            'function_name' => 'getCustomerAddressDisplayLabel',
            'limit' => 9999,
        ]);

        CRUD::addColumn([
            'name' => 'ship_to_name',
            'limit' => 9999,
        ]);

        CRUD::column('last_logged_in')->type('datetime');
        CRUD::column('last_logged_out')->type('datetime');
        CRUD::column('active')->type('boolean');

        $this->addTimestampColumnsForSuperAdmin();
    }

    protected function addTimestampColumnsForSuperAdmin(): void
    {
        if (! backpack_user()?->is_admin) {
            return;
        }

        CRUD::column('created_at')->type('datetime');
        CRUD::column('updated_at')->type('datetime');
    }
}