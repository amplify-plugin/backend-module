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

        CRUD::column('contact_id')->type('relationship');
        CRUD::column('customer_id')->type('relationship');
        CRUD::column('warehouse_id')->type('relationship');
        CRUD::column('customer_address_id')->type('relationship');
        CRUD::column('ship_to_name')->type('relationship');
        CRUD::column('last_logged_in')->type('datetime');
        CRUD::column('last_logged_out')->type('datetime');
        CRUD::column('created_at')->type('datetime');
        CRUD::column('updated_at')->type('datetime');
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
}
