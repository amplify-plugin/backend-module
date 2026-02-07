<?php

namespace Amplify\System\Backend\Http\Controllers\Admin;

use Amplify\System\Abstracts\BackpackCustomCrudController;
use Amplify\System\Backend\Http\Requests\WarehouseRequest;
use Amplify\System\Backend\Models\Warehouse;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class WarehouseCrudController
 *
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class WarehouseCrudController extends BackpackCustomCrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\FetchOperation;
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
        CRUD::setModel(\Amplify\System\Backend\Models\Warehouse::class);
        CRUD::setRoute(config('backpack.base.route_prefix').'/warehouse');
        CRUD::setEntityNameStrings('warehouse', 'warehouses');
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
                'name' => 'enabled',
                'type' => 'dropdown',
                'label' => 'Is Enabled',
            ],
            function () {
                return [
                    '1' => 'Yes',
                    '0' => 'No',
                ];
            },
            function ($value) {
                if ($value == '1') {
                    $this->crud->addClause('where', 'enabled', true);
                }

                if ($value == '0') {
                    $this->crud->addClause('where', 'enabled', false);
                }
            }
        );

        CRUD::addFilter(
            [
                'name' => 'pickup_location',
                'type' => 'dropdown',
                'label' => 'Is PickUp Location',
            ],
            function () {
                return [
                    '1' => 'Yes',
                    '0' => 'No',
                ];
            },
            function ($value) {
                if ($value == '1') {
                    $this->crud->addClause('where', 'pickup_location', true);
                }

                if ($value == '0') {
                    $this->crud->addClause('where', 'pickup_location', false);
                }
            }
        );

        CRUD::column('id')->type('number')->thousands_sep('');
        CRUD::column('name');
        CRUD::column('code')->type('text');
        CRUD::column('email');
        CRUD::column('telephone');
        CRUD::column('enabled')->type('boolean');
        CRUD::column('pickup_location')->type('boolean');
        CRUD::column('created_at');
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
        CRUD::setValidation(WarehouseRequest::class);

        CRUD::field('name');
        CRUD::field('code');
        CRUD::field('ship_via');
        CRUD::field('email');
        CRUD::field('address');
        CRUD::field('telephone');
        CRUD::field('zip_code');
        CRUD::field('enabled')
            ->type('boolean')
            ->default(true);
        CRUD::field('pickup_location')
            ->type('boolean')
            ->default(false)
            ->label('Is a Pick Up Location')
            ->hint('Warehouse can be used for pickup delivery');

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

    /**
     * This method return all warehouse list for dropdown in frontend setting
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function fetchWarehouseDropdown()
    {
        return $this->fetch([
            'paginate' => false,
            'model' => Warehouse::class,
        ]);
    }
}
