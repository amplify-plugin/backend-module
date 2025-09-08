<?php

namespace Amplify\System\Backend\Http\Controllers\Admin;

use Amplify\System\Abstracts\BackpackCustomCrudController;
use Amplify\System\Backend\Http\Requests\EventRequest;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class EventCrudController
 *
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class TriggerCrudController extends BackpackCustomCrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\Amplify\System\Backend\Models\Event::class);
        CRUD::setRoute(config('backpack.base.route_prefix').'/trigger');
        CRUD::setEntityNameStrings('trigger', 'triggers');

        CRUD::denyAccess(['create', 'delete']);
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
        CRUD::column('name');
        CRUD::column('enabled')->type('boolean');
        CRUD::column('created_at');

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']);
         */
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(EventRequest::class);

        CRUD::addField([
            'name' => 'name',
            'type' => 'text',
            'label' => 'Name',
        ]);

        CRUD::addField([
            'name' => 'description',
            'type' => 'textarea',
            'label' => 'Description',
        ]);

        CRUD::addField([
            'name' => 'enabled',
            'type' => 'boolean',
            'label' => 'Enabled',
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

    public function setupShowOperation()
    {
        $this->crud->setShowContentClass('col-md-12');

        CRUD::column('name');
        CRUD::column('code');
        CRUD::column('name');
        $this->crud->addColumn([
            'name' => 'enabled',
            'label' => 'Enabled',
            'type' => 'boolean',
            'options' => [0 => 'No', 1 => 'Yes'],
        ]);
        CRUD::column('description');
        CRUD::column('name');
        CRUD::addColumn([
            'name' => 'created_at',
            'type' => 'custom_html',
            'label' => 'Created',
            'value' => function ($entry) {
                return date('d M Y, h:iA', strtotime($entry->created_at));
            },
        ]);
        CRUD::addColumn([
            'name' => 'updated_at',
            'type' => 'custom_html',
            'label' => 'Updated',
            'value' => function ($entry) {
                return date('d M Y, h:iA', strtotime($entry->updated_at));
            },
        ]);
        CRUD::addColumn([
            'name' => 'eventVariables',
            'type' => 'table-related',
            'columns' => [
                [
                    'name' => 'name',
                    'label' => 'Name',
                    'type' => 'text',
                ],
                [
                    'name' => 'description',
                    'label' => 'Description',
                    'type' => 'text',
                ],
            ],
        ]);
        CRUD::addColumn([
            'name' => 'eventRecipents',
            'type' => 'table-related',
            'columns' => [
                [
                    'name' => 'name',
                    'label' => 'Name',
                    'type' => 'text',
                ],
                [
                    'name' => 'description',
                    'label' => 'Description',
                    'type' => 'text',
                ],
                [
                    'name' => 'enabled',
                    'label' => 'Enabled',
                    'type' => 'boolean',
                ],
            ],
        ]);
    }
}
