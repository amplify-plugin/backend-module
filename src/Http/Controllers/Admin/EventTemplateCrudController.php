<?php

namespace Amplify\System\Backend\Http\Controllers\Admin;

use Amplify\System\Abstracts\BackpackCustomCrudController;
use Amplify\System\Backend\Http\Requests\EventTemplateRequest;
use Amplify\System\Backend\Models\Event;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class EventTemplateCrudController
 *
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class EventTemplateCrudController extends BackpackCustomCrudController
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
        CRUD::setModel(\Amplify\System\Backend\Models\EventTemplate::class);
        CRUD::setRoute(config('backpack.base.route_prefix').'/event-template');
        CRUD::setEntityNameStrings('template', 'templates');
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
        $this->crud->query->orderBy('updated_at', 'desc');

        CRUD::column('id')->type('text');

        CRUD::addColumn([
            'name' => 'name',
            'type' => 'custom_html',
            'value' => fn ($model) => $model->name,
        ]);

        $this->crud->addColumn([
            'name' => 'event.name',
            'label' => 'Trigger',
            'type' => 'relationship',
        ]);
        $this->crud->addColumn([
            'name' => 'notification_type',
            'label' => 'Send Via',
            'type' => 'custom_html',
            'value' => function ($entry) {
                return ($entry->notification_type == 'emailable') ? 'Email' : 'Message';
            },
        ]);

        $this->crud->addColumn([
            'name' => 'updated_at',
            'label' => 'Updated',
            'type' => 'datetime',
        ]);

        CRUD::addFilter(
            [
                'name' => 'id',
                'type' => 'select2',
                'label' => 'Trigger',
            ],
            function () {
                return Event::all()->keyBy('id')->pluck('name', 'id')->toArray();
            },

            function ($value) {
                // if the filter is active
                $this->crud->addClause('where', 'event_id', $value);
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
        CRUD::setValidation(EventTemplateRequest::class);
        $this->crud->setRequiredFields(EventTemplateRequest::class);

        $this->data['events'] = Event::get()->toArray();

        $this->crud->setCreateView('backend::pages.event-template.create');

        CRUD::field('name');
        CRUD::field('event_id')->label('trigger');
        CRUD::field('subject');
        CRUD::field('email_body');
        CRUD::field('show_button');
        CRUD::field('notification_type');
        CRUD::field('button_text');
        CRUD::field('button_url');
    }

    protected function SetupShowOperation()
    {
        CRUD::column('name');
        CRUD::column('event_id');
        CRUD::column('subject');
        CRUD::column('email_body')->label('Content');
        CRUD::column('show_button')->label('Show Button')->type('boolean');
        CRUD::column('notification_type')->label('Send Via');
        CRUD::column('button_text');
        CRUD::column('button_url');
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
        $this->data['email_data'] = $this->crud->getCurrentEntry();
        $this->crud->setUpdateView('backend::pages.event-template.create');

        $this->setupCreateOperation();
    }

    public function destroy($id)
    {
        $this->crud->hasAccessOrFail('delete');
        /**
         * @var \Amplify\System\Backend\Models\EventTemplate $model
         */
        $model = $this->crud->model->findOrFail($id);

        if ($model->eventAction()->doesntExist()) {
            return $model->delete();
        }

        return ['error' => ["Notification template has {$model->eventAction->count()} notification attached."]];
    }
}
