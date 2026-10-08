<?php

namespace Amplify\System\Backend\Traits;

use Amplify\System\Backend\Rules\ValidSeeder;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Prologue\Alerts\Facades\Alert;

trait SettingOperation
{
    use ListOperation;
    use UpdateOperation;

    /**
     * Configure the setting group name. Apply settings to all operations.
     */
    abstract public function getSettingName(): string;

    /**
     * Configure the setting group name. Apply settings to all operations.
     */
    public function getSeederClass(): ?string
    {
        return null;
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::addBaseClause('where', 'name', '=', $this->getSettingName());

        if ($this->getSeederClass()) {
            CRUD::addButton('top', 'seed', 'view', 'backend::settings.seed');
            CRUD::modifyButton('seed', ['params' => ['class' => $this->getSeederClass()]]);
        }

        //        CRUD::addButton('line', 'active', 'view', 'backend::settings.toggle_active', 'end');

        CRUD::addColumns([
            [
                'name' => 'option',
                'label' => 'Option',
                'type' => 'view',
                'view' => 'backend::settings.label',
                'wrapper' => [
                    'element' => 'span',
                ]
            ],
            [
                'name' => 'value',
                'label' => 'Value',
                'type' => 'view',
                'view' => 'backend::settings.value',
                'orderable' => false,
            ],
            [
                'name' => 'active',
                'label' => 'Active?',
                'type' => 'boolean',
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

    /**
     * Register a Seeder execution controller routes
     */
    protected function setupCustomRoutes($segment, $routeName, $controller): void
    {
        Route::get($segment . '/seed', [
            'as' => $routeName . '.seed',
            'uses' => $controller . '@seedOperation',
            'operation' => 'seed',
        ]);
    }

    public function seedOperation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'class' => ['required', 'string', new ValidSeeder]
        ]);

        if ($validator->fails()) {
            Alert::error($validator->errors()->first('class'))->flash();
            return Redirect::back();
        }

        try {

            $seeder = app($request->query('class'));

            $seeder->run();

            Alert::success("The " . strtolower($this->crud->entity_name_plural) . " has been synchronized successfully.")->flash();

        } catch (\Throwable $exception) {
            Alert::error($exception->getMessage())->flash();
        }

        return Redirect::back();
    }
}
