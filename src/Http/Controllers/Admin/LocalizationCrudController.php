<?php

namespace Amplify\System\Backend\Http\Controllers\Admin;

use Amplify\System\Abstracts\BackpackCustomCrudController;
use Amplify\System\Backend\Http\Requests\LocalizationRequest;
use Amplify\System\Backend\Models\Localization;
use Amplify\System\Support\Language;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanel;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class LocalizationCrudController
 *
 * @property-read CrudPanel $crud
 */
class LocalizationCrudController extends BackpackCustomCrudController
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
        CRUD::setModel(Localization::class);
        CRUD::setRoute(config('backpack.base.route_prefix').'/localization');
        CRUD::setEntityNameStrings('Localization', 'Localizations');
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
        CRUD::addColumn('key');
        CRUD::addColumn([
            'name' => 'lang',
            'visibleInTable' => false,
            'visibleInShow' => false,
        ]);

        $languages = new Language;

        foreach ($languages->take(3) as $key => $language) {
            CRUD::addColumn([
                'name' => "lang.{$language->code}",
                'label' => $language->name,
            ]);
        }
    }

    protected function setupShowOperation()
    {
        $this->setupListOperation();

        $languages = new Language;
        foreach ($languages as $key => $language) {
            CRUD::addColumn([
                'name' => "lang.{$language->code}",
                'label' => $language->name,
            ]);
        }
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
        CRUD::setValidation(LocalizationRequest::class);

        $languages = new Language;

        CRUD::field('key')->type('text');
        foreach ($languages as $key => $language) {
            CRUD::addField([
                'name' => "lang[{$language->code}]",
                'label' => $language->name,
                'type' => 'text',
            ]);
        }
    }

    public function store(LocalizationRequest $request)
    {
        $this->crud->model->create($request->only('key', 'lang'));

        \Alert::success(trans('backpack::crud.insert_success'))->flash();
        $this->crud->setSaveAction($request->save_action);

        return $this->crud->performSaveAction($this->crud->model->getKey());
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
        CRUD::setValidation(LocalizationRequest::class);

        $languages = new Language;

        $savedLangs = $this->crud->getCurrentEntry()->lang;

        CRUD::field('key')->type('text');

        foreach ($languages as $key => $language) {
            CRUD::addField([
                'name' => "lang[{$language->code}]",
                'label' => $language->name,
                'type' => 'text',
                'value' => $savedLangs[$language->code] ?? '',
            ]);
        }
    }

    public function update(LocalizationRequest $request)
    {
        $this->crud->getCurrentEntry()->update($request->only('key', 'lang'));

        \Alert::success(trans('backpack::crud.update_success'))->flash();
        $this->crud->setSaveAction($request->save_action);

        return $this->crud->performSaveAction($this->crud->model->getKey());
    }
}
