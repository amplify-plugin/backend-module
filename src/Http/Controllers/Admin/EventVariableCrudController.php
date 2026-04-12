<?php

namespace Amplify\System\Backend\Http\Controllers\Admin;

use Amplify\System\Abstracts\BackpackCustomCrudController;
use Amplify\System\Backend\Http\Requests\EventVariableRequest;
use Amplify\System\Backend\Models\Event;
use Amplify\System\Backend\Models\EventVariable;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanel;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class EventVariableCrudController
 *
 * @property-read CrudPanel $crud
 */
class EventVariableCrudController extends BackpackCustomCrudController
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
        CRUD::setModel(EventVariable::class);
        CRUD::setRoute(config('backpack.base.route_prefix').'/event-variable');
        CRUD::setEntityNameStrings('event-variable', 'event variables');
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
        CRUD::column('value');
        CRUD::column('for_admin')->type('boolean');
        CRUD::column('description');
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
        CRUD::setValidation(EventVariableRequest::class);

        CRUD::addField([
            'label' => 'Trigger',
            'type' => 'select',
            'name' => 'event_id',
            'model' => Event::class,
            'attribute' => 'name',
        ]);

        CRUD::addField([
            'name' => 'name',
            'type' => 'text',
            'label' => 'Name',
        ]);

        CRUD::addField([
            'name' => 'value',
            'type' => 'text',
            'label' => 'Value',
        ]);

        CRUD::addField([
            'name' => 'description',
            'type' => 'text',
            'label' => 'Description',
        ]);

        CRUD::addField([
            'name' => 'for_admin',
            'type' => 'boolean',
            'label' => 'Only for Admin',
        ]);
    }

    protected function SetupShowOperation()
    {
        CRUD::addColumn([
            'label' => 'Event',
            'type' => 'select',
            'name' => 'event_id',
        ]);

        CRUD::addColumn([
            'name' => 'name',
            'type' => 'text',
            'label' => 'Name',
        ]);

        CRUD::addColumn([
            'name' => 'value',
            'type' => 'text',
            'label' => 'Value',
        ]);

        CRUD::addColumn([
            'name' => 'description',
            'type' => 'text',
            'label' => 'Description',
        ]);

        CRUD::addColumn([
            'name' => 'for_admin',
            'type' => 'boolean',
            'label' => 'Only for Admin',
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

    /**
     * return all event variable for a specific event
     */
    public function getVariables(Request $request): JsonResponse
    {
        $variables = [];

        EventVariable::where(['event_id' => $request->input('event_id'), 'for_admin' => $request->input('for_admin', 0)])
            ->get()->each(function ($eventVariable) use (&$variables) {
                $variables[] = [
                    'key' => $eventVariable->name,
                    'value' => $eventVariable->description,
                    'description' => $eventVariable->description,
                ];
            });

        return response()->json($variables);
    }
}
