<?php

namespace Amplify\System\Backend\Http\Controllers\Admin;

use Amplify\System\Abstracts\BackpackCustomCrudController;
use Amplify\System\Backend\Http\Requests\DocumentTypeRequest;
use Amplify\System\Backend\Models\DocumentType;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanel;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class DocumentTypeCrudController
 *
 * @property-read CrudPanel $crud
 */
class DocumentTypeCrudController extends BackpackCustomCrudController
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
        CRUD::setModel(DocumentType::class);
        CRUD::setRoute(config('backpack.base.route_prefix').'/document-type');
        CRUD::setEntityNameStrings('document-type', 'document types');
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
            'name' => 'media_type',
            'label' => 'Media Types',
            'type' => 'custom_html',
            'value' => function ($entity) {
                $view = '<div>';
                if (! empty($entity->media_type)) {
                    $view .= '<span style="font-size: 15px;" class="badge badge-secondary">'
                             .DocumentType::MEDIA_TYPES[$entity->media_type].'</span>';
                } else {
                    $view .= '<span>-</span>';
                }

                return $view .= '</div>';
            },
        ]);
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
        CRUD::setValidation(DocumentTypeRequest::class);

        CRUD::field('name');
        CRUD::addField([
            'name' => 'media_type',
            'label' => 'Media Types',
            'type' => 'select_from_array',
            'options' => DocumentType::MEDIA_TYPES,
            'allows_null' => false,
            'default' => 'pdf',
        ]);
        CRUD::addField([
            'name' => 'description',
            'label' => 'Description',
            'allows_null' => true,
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
        $this->crud->set('show.setFromDb', false);

        CRUD::column('id')->type('number')->thousands_sep('');
        CRUD::column('name');
        CRUD::addColumn([
            'name' => 'media_type',
            'label' => 'Media Types',
            'type' => 'custom_html',
            'value' => function ($entity) {
                $view = '<div>';
                if (! empty($entity->media_type)) {
                    $view .= '<span style="font-size: 15px;" class="badge badge-secondary">'
                             .DocumentType::MEDIA_TYPES[$entity->media_type].'</span>';
                } else {
                    $view .= '<span>-</span>';
                }

                return $view .= '</div>';
            },
        ]);
        CRUD::column('description');
    }
}
