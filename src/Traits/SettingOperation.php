<?php

namespace Amplify\System\Backend\Traits;

use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

trait SettingOperation
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;

    /**
     * Configure the setting group name. Apply settings to all operations.
     *
     * @return string
     */
    abstract public function getSettingName(): string;

    /**
     * Define what happens when the List operation is loaded.
     *
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::addClause('where', 'name', '=', $this->getSettingName());

        CRUD::addColumns([
            [
                'name' => 'option',
                'label' => 'Option',
                'type' => 'view',
                'view' => 'backend::settings.label',
            ],
            [
                'name' => 'value',
                'label' => 'Value',
                'type' => 'view',
                'view' => 'backend::settings.value',
                'orderable' => false,
            ],
            [
                'name' => 'updated_at',
                'label' => 'Last Modified',
                'type' => 'datetime',
            ],
        ]);
    }

    /**
     * Define what happens when the Update operation is loaded.
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
                'default' => $this->getSettingName(),
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