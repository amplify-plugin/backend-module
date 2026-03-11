<?php

namespace Amplify\System\Backend\Http\Controllers\Admin;

use Amplify\System\Abstracts\BackpackCustomCrudController;
use Amplify\System\Backend\Http\Requests\WebinarRequest;
use Amplify\System\Backend\Models\Webinar;
use Amplify\System\Cms\Models\Page;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanel;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class WebinarCrudController
 *
 * @property-read CrudPanel $crud
 */
class WebinarCrudController extends BackpackCustomCrudController
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
        CRUD::setModel(Webinar::class);
        CRUD::setRoute(config('backpack.base.route_prefix').'/event');
        CRUD::setEntityNameStrings('event', 'events');
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
        CRUD::column('code');
        CRUD::column('title');
        CRUD::column('address_name');
        CRUD::column('start_date_time')->type('datetime')->format('D MMM YYYY | ha');
        CRUD::column('end_date_time')->type('datetime')->format('D MMM YYYY | ha');
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
        CRUD::setValidation(WebinarRequest::class);

        CRUD::addFields([
            [
                'name' => 'title',
            ],
            [
                'name' => 'code',
            ],
            [
                'name' => 'page_id',
                'type' => 'select2_from_array',
                'options' => Page::wherePageType('event_details')->orderBy('name')->pluck('name', 'id'),
                'allows_null' => false,
            ],
            [
                'label' => 'Banner Zone',
                'type' => 'relationship',
                'entity' => 'bannerZone',
                'name' => 'banner_zone_id',
                'options' => (fn ($query) => $query->orderBy('name')->get()),
            ],
            [
                'name' => 'short_description',
                'type' => 'textarea',
            ],
            [
                'name' => 'start_date_time',
                'type' => 'datetime',
                'wrapper' => [
                    'class' => 'col-md-6',
                ],
            ],
            [
                'name' => 'end_date_time',
                'type' => 'datetime',
                'wrapper' => [
                    'class' => 'col-md-6',
                ],
            ],
            [
                'label' => 'Event type',
                'name' => 'webinar_type_id',
                'type' => 'select2',
                'entity' => 'webinarType',
                'wrapper' => [
                    'class' => 'my-3 col-12',
                ],
                'options' => (fn ($query) => $query->orderBy('name')->get()),
            ],
            [
                'label' => 'Filter location',
                'name' => 'address_name',
            ],
            [
                'label' => 'Map location',
                'name' => 'address_url',
                'type' => 'text',
            ],
            [
                'name' => 'booking_label',
                'type' => 'text',
                'wrapper' => [
                    'class' => 'col-md-4',
                ],
            ],
            [
                'name' => 'booking_url',
                'type' => 'url',
                'wrapper' => [
                    'class' => 'col-md-8',
                ],
            ],
            [
                'name' => 'content',
                'type' => 'wysiwyg',
                'wrapper' => [
                    'class' => 'mt-3 col-12',
                ],
            ],
        ]);

        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number']));
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
        $this->setupCreateOperation();
    }

    protected function setupShowOperation()
    {
        CRUD::column('code');
        CRUD::column('title');
        CRUD::column('cover_photo')->type('image');
        CRUD::column('additional_photos')->type('upload_multiple');
        CRUD::column('start_date_time');
        CRUD::column('end_date_time');
        CRUD::column('address_name');
        CRUD::column('created_at');
    }
}
