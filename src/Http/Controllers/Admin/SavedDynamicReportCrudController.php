<?php

namespace Amplify\System\Backend\Http\Controllers\Admin;

use Amplify\System\Abstracts\BackpackCustomCrudController;
use Amplify\System\Backend\Http\Requests\SavedDynamicReportRequest;
use Amplify\System\Backend\Models\SavedDynamicReport;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class SavedDynamicReportCrudController
 *
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class SavedDynamicReportCrudController extends BackpackCustomCrudController
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
        CRUD::setModel(SavedDynamicReport::class);
        CRUD::setRoute(config('backpack.base.route_prefix').'/saved-report');
        CRUD::setEntityNameStrings('saved-report', 'saved reports');

        CRUD::denyAccess(['create', 'show']);
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
        CRUD::addButtonFromModelFunction('line', 'view_report', 'viewReport', 'beginning');

        CRUD::column('title');
        CRUD::addColumn([
            'label' => 'Category',
            'name' => 'report_category_id',
            'type' => 'select',
            'entity' => 'category',
            'attribute' => 'title',
        ]);
        CRUD::column('prompt')->label('Query')->limit(200);
        CRUD::column('report_type')->label('Default Type');
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
        CRUD::setValidation(SavedDynamicReportRequest::class);

        CRUD::field('title');
        CRUD::addField([
            'label' => 'Category',
            'name' => 'report_category_id',
            'type' => 'select2',
            'entity' => 'category',
            'attribute' => 'title',
        ]);
        CRUD::field('description');
        CRUD::addField([
            'label' => 'Query',
            'name' => 'prompt',
            'attributes' => [
                'readonly' => 'readonly',
                'disabled' => 'disabled',
            ],
        ]);
        CRUD::addField([
            'label' => 'Default Type',
            'name' => 'report_type',
            'type' => 'select_from_array',
            'options' => SavedDynamicReport::REPORT_TYPE,
            'attributes' => (function () {
                if ($id = request()->id) {
                    $entry = SavedDynamicReport::findOrFail($id);
                    if (isset($entry->report['show_chart']) && $entry->report['show_chart']) {
                        return [];
                    }
                }

                return [
                    'readonly' => 'readonly',
                    'disabled' => 'disabled',
                ];
            })(),
        ]);
        CRUD::field('schedule');
        CRUD::addField([
            'label' => 'Last Run',
            'name' => 'updated_at',
            'attributes' => [
                'readonly' => 'readonly',
                'disabled' => 'disabled',
            ],
        ]);
        CRUD::field('report_sequence');
        CRUD::field('status')->type('switch')->default(true);

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
}
