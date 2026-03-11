<?php

namespace Amplify\System\Backend\Http\Controllers\Admin;

use Amplify\System\Abstracts\BackpackCustomCrudController;
use Amplify\System\Backend\Http\Requests\StateRequest;
use Amplify\System\Backend\Models\Country;
use Amplify\System\Backend\Models\State;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\FetchOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanel;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class StateCrudController
 *
 * @property-read CrudPanel $crud
 */
class StateCrudController extends BackpackCustomCrudController
{
    use CreateOperation;
    use DeleteOperation;
    use FetchOperation;
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
        CRUD::setModel(State::class);
        CRUD::setRoute(config('backpack.base.route_prefix').'/state');
        CRUD::setEntityNameStrings('state', 'states');
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
        CRUD::addFilter(
            [
                'name' => 'country',
                'type' => 'select2_ajax',
                'label' => 'Country',
                'placeholder' => 'Type Name, ISO2, ISO3',
                'method' => 'POST',
            ],
            backpack_url('state/fetch/country'),
            function ($value) {
                $this->crud->query->where('country_id', '=', $value);
            }
        );

        CRUD::column('id')->type('number')->thousands_sep('');
        CRUD::column('name');
        CRUD::column('iso2');
        CRUD::column('country_id');
        CRUD::column('enabled')->type('boolean');
        CRUD::column('type');
        CRUD::column('updated_at');

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
        CRUD::setValidation(StateRequest::class);

        CRUD::field('name');
        CRUD::field('iso2');
        CRUD::addField([
            'name' => 'country_id',
            'options' => (fn ($query) => $query->orderBy('name')->get()),
        ]);
        CRUD::field('country_code');
        CRUD::field('type');
        CRUD::field('latitude');
        CRUD::field('longitude');
        CRUD::column('enabled')->type('boolean');
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

    protected function fetchCountry()
    {
        return $this->fetch(Country::class);
    }
}
