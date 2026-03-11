<?php

namespace Amplify\System\Backend\Http\Controllers\Admin;

use Amplify\System\Abstracts\BackpackCustomCrudController;
use Amplify\System\Backend\Http\Requests\EventActionRequest;
use Amplify\System\Backend\Models\Event;
use Amplify\System\Backend\Models\EventAction;
use Amplify\System\Backend\Models\EventRecipent;
use Amplify\System\Backend\Models\EventTemplate;
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
 * Class EventActionCrudController
 *
 * @property-read CrudPanel $crud
 */
class EventActionCrudController extends BackpackCustomCrudController
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
        CRUD::setModel(EventAction::class);
        CRUD::setRoute(config('backpack.base.route_prefix').'/event-action');
        CRUD::setEntityNameStrings('event-action', 'notifications');
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

        CRUD::addColumn([
            'name' => 'event',
            'label' => 'Trigger',
            'type' => 'relationship',
        ]);

        CRUD::addColumn([
            'name' => 'eventTemplate',
            'label' => 'Template',
            'type' => 'relationship',
        ]);

        CRUD::addColumn([
            'name' => 'eventTemplate.notification_type',
            'label' => 'Send Via',
            'type' => 'custom_html',
            'value' => function ($entry) {
                return ($entry->eventTemplate->notification_type == 'emailable') ? 'Email' : 'Message';
            },
        ]);

        CRUD::addColumn([
            'name' => 'enabled',
            'label' => 'Enabled',
            'type' => 'boolean']);

        CRUD::addFilter(
            [
                'name' => 'event',
                'type' => 'select2',
                'label' => 'Trigger',
                'styles' => [
                    'width' => 'width: 250px !important;',
                ],
            ],
            function () {
                return Event::all()->keyBy('id')->pluck('name', 'id')->toArray();
            },

            function ($value) {
                // if the filter is active
                $this->crud->addClause('where', 'event_id', $value);
            }
        );
        CRUD::addFilter(
            [
                'name' => 'template',
                'type' => 'select2',
                'label' => 'Template',
                'styles' => [
                    'width' => 'width: 250px !important;',
                ],
            ],
            function () {
                return EventTemplate::all()->keyBy('id')->pluck('name', 'id')->toArray();
            },

            function ($value) {
                // if the filter is active
                $this->crud->addClause('where', 'event_template_id', $value);
            }
        );
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
        CRUD::setValidation(EventActionRequest::class);
        $this->crud->setRequiredFields(EventActionRequest::class);
        $this->data['events'] = Event::get()->toArray();
        $this->crud->setCreateView('backend::pages.events.action');

        CRUD::field('name');
        CRUD::field('event_id');
        CRUD::field('event_template_id');
        CRUD::field('is_get_admin');
        CRUD::field('is_get_customer');
        CRUD::field('is_get_contact');
        CRUD::field('is_get_salesperson');
        CRUD::field('is_quote_sales_person');
        CRUD::field('recipient_emails');
    }

    public function setupShowOperation()
    {
        CRUD::column('name');
        CRUD::column('event.name')->label('Trigger');
        CRUD::column('eventTemplate.name')->type('relationship')->label('Template');
        CRUD::column('is_get_admin')->label('Admin')->type('boolean');
        CRUD::column('is_get_customer')->label('Customer')->type('boolean');
        CRUD::column('is_get_contact')->label('Business Contact')->type('boolean');
        CRUD::column('is_get_salesperson')->label('Sales Person')->type('boolean');
        CRUD::column('is_quote_sales_person')->label('Quotation Sales Person')->type('boolean');
        CRUD::column('recipient_emails')->type('text');
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
        $this->data['event_action_data'] = $this->crud->getCurrentEntry();
        $this->crud->setUpdateView('backend::pages.events.action');
        $this->setupCreateOperation();

        CRUD::addField([
            'name' => 'enabled',
            'label' => 'Enabled',
            'type' => 'boolean',
        ]);
    }

    public function getTemplates(Request $request): JsonResponse
    {
        $templates = EventTemplate::where(['event_id' => $request->input('event_id')])
            ->get();

        return response()->json($templates);
    }

    public function getRecipents(Request $request): JsonResponse
    {
        $recipents = EventRecipent::where(['event_id' => $request->input('event_id')])
            ->get();

        return response()->json($recipents);
    }
}
