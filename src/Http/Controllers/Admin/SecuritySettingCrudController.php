<?php

namespace Amplify\System\Backend\Http\Controllers\Admin;

use Amplify\System\Abstracts\BackpackCustomCrudController;
use Amplify\System\Backend\Models\SystemConfiguration;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Support\Str;

/**
 * Class SeoSettingCrudController
 *
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class SecuritySettingCrudController extends BackpackCustomCrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(SystemConfiguration::class);
        CRUD::setRoute(config('backpack.base.route_prefix').'/security-setting');
        CRUD::setEntityNameStrings('Security Setting', 'Security Settings');
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
        CRUD::addClause('where', 'name', '=', 'security');

        CRUD::addColumns([
            [
                'name' => 'option',
                'label' => 'Option',
                'type' => 'custom_html',
                'value' => function ($model) {
                    return Str::title(Str::replace(['_', '-'], ' ', $model->option));
                },
            ],
            [
                'name' => 'value',
                'label' => 'Value',
                'type' => 'text',
            ],
            [
                'name' => 'updated_at',
                'label' => 'Last Modified',
                'type' => 'datetime',
            ],
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
        CRUD::addFields([
            [
                'name' => 'name',
                'type' => 'hidden',
                'default' => 'seo',
            ],
            [
                'name' => 'option',
                'label' => 'Option',
                'type' => 'text',
            ],
            [
                'name' => 'value',
                'label' => 'Value',
                'type' => 'text',
            ],
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
        $entry = $this->crud->getCurrentEntry();

        $field = empty($entry->field) ? ['name' => 'value', 'label' => 'Value', 'type' => 'text'] : $entry->field;

        CRUD::addFields([
            [
                'name' => 'name',
                'type' => 'hidden',
                'default' => 'seo',
            ],
            [
                'name' => 'option',
                'label' => 'Option',
                'type' => 'text',
                'attributes' => [
                    'readonly' => 'readonly',
                ],
            ],
        ]);

        CRUD::addField($field);
    }
}
