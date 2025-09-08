<?php

namespace Amplify\System\Backend\Http\Controllers\Admin;

use Amplify\System\Abstracts\BackpackCustomCrudController;
use Amplify\System\Backend\Http\Requests\EventRecipentRequest;
use Amplify\System\Backend\Models\Event;
use Amplify\System\Backend\Models\EventRecipent;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class EventRecipentCrudController
 *
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class EventRecipentCrudController extends BackpackCustomCrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
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
        CRUD::setModel(\Amplify\System\Backend\Models\EventRecipent::class);
        CRUD::setRoute(config('backpack.base.route_prefix').'/event-recipent');
        CRUD::setEntityNameStrings('event-recipent', 'event recipents');
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
        CRUD::addColumn([
            'name' => 'event',
            'label' => 'Trigger',
            'type' => 'custom_html',
            'value' => function ($entry) {
                return $entry->event->name;
            },
        ]);
        CRUD::column('name');

        CRUD::addColumn([
            'name' => 'event_action_field',
            'label' => 'Trigger Action Map',
            'type' => 'custom_html',
            'value' => function ($er) {
                return EventRecipent::EVENT_ACTION_FIELDS[$er->event_action_field] ?? 'N/A';
            },
        ]);

        CRUD::column('enabled')->type('boolean');
        CRUD::column('description');
        CRUD::column('created_at');

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']);
         */
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
        CRUD::setValidation(EventRecipentRequest::class);

        CRUD::addField([
            'label' => 'Trigger',
            'type' => 'select',
            'name' => 'event_id',
            'model' => Event::class,
            'attribute' => 'name',
        ]);

        CRUD::addField([
            'name' => 'event_action_field',
            'type' => 'select_from_array',
            'label' => 'Trigger Action Map',
            'options' => EventRecipent::EVENT_ACTION_FIELDS,
            'allows_null' => false,
        ]);

        CRUD::addField([
            'name' => 'name',
            'type' => 'text',
            'label' => 'Name',
        ]);

        CRUD::addField([
            'name' => 'description',
            'type' => 'text',
            'label' => 'Description',
        ]);

        CRUD::addField([
            'name' => 'enabled',
            'type' => 'boolean',
            'label' => 'Enabled',
        ]);
    }

    protected function SetupShowOperation()
    {
        CRUD::addColumn([
            'name' => 'event_id',
            'label' => 'Trigger',
        ]);

        CRUD::addColumn([
            'name' => 'event_action_field',
            'type' => 'select_from_array',
            'label' => 'Trigger Action Map',
        ]);

        CRUD::addColumn([
            'name' => 'name',
            'type' => 'text',
            'label' => 'Name',
        ]);

        CRUD::addColumn([
            'name' => 'description',
            'type' => 'text',
            'label' => 'Description',
        ]);

        CRUD::addColumn([
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
}
