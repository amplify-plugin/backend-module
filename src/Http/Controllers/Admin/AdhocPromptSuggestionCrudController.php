<?php

namespace Amplify\System\Backend\Http\Controllers\Admin;

use Amplify\System\Abstracts\BackpackCustomCrudController;
use Amplify\System\Backend\Http\Requests\AdhocPromptSuggestionRequest;
use Amplify\System\Backend\Models\AdhocPromptSuggestion;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanel;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class AdhocPromptSuggestionCrudController
 *
 * @property-read CrudPanel $crud
 */
class AdhocPromptSuggestionCrudController extends BackpackCustomCrudController
{
    use CreateOperation;
    use DeleteOperation;
    use ListOperation;
    use UpdateOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(AdhocPromptSuggestion::class);
        CRUD::setRoute(config('backpack.base.route_prefix').'/saved-query');
        CRUD::setEntityNameStrings('saved-query', 'saved queries');
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
        CRUD::addButtonFromModelFunction('line', 'execute', 'viewReport', 'beginning');

        CRUD::column('prompt')->label('Query')->limit(200);
        CRUD::addColumn([
            'label' => 'Category',
            'name' => 'report_category_id',
            'type' => 'select',
            'entity' => 'category',
            'attribute' => 'title',
        ]);
        CRUD::addColumn([
            'type' => 'boolean',
            'name' => 'status',
            'options' => [1 => 'Active', 0 => 'Inactive'],
        ]);
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
        CRUD::setValidation(AdhocPromptSuggestionRequest::class);

        CRUD::field('prompt')->label('Query');
        CRUD::addField([
            'label' => 'Category',
            'name' => 'report_category_id',
            'type' => 'select2',
            'entity' => 'category',
            'attribute' => 'title',
        ]);
        CRUD::field('status')->type('switch')->default(true);
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
