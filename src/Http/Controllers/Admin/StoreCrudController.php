<?php

namespace Amplify\System\Backend\Http\Controllers\Admin;

use Amplify\System\Abstracts\BackpackCustomCrudController;
use Amplify\System\Backend\Http\Requests\StoreRequest;
use Amplify\System\Backend\Models\Store;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanel;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class StoreCrudController
 *
 * @property-read CrudPanel $crud
 */
class StoreCrudController extends BackpackCustomCrudController
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
        CRUD::setModel(Store::class);
        CRUD::setRoute(config('backpack.base.route_prefix').'/store');
        CRUD::setEntityNameStrings('store', 'stores');
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
        CRUD::column('code');
        CRUD::column('warehouse_id');
        CRUD::column('email');
        CRUD::column('address');
        CRUD::column('telephone');
        CRUD::column('zip_code');
        //        CRUD::column('created_at');
        //        CRUD::column('updated_at');

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
        CRUD::setValidation(StoreRequest::class);

        //        CRUD::field('id');
        CRUD::field('name');
        CRUD::field('code');
        $this->crud->addField([
            'label' => 'Warehouse', // Table column heading
            'type' => 'select',
            'name' => 'warehouse_id', // the column that contains the ID of that connected entity;
            'entity' => 'warehouse', // the method that defines the relationship in your Model
            'attribute' => 'id', // foreign key attribute that is shown to user
        ]);
        // CRUD::field('warehouse_id');
        CRUD::field('email');
        CRUD::field('address');
        CRUD::field('telephone');
        CRUD::field('zip_code');
        //        CRUD::field('created_at');
        //        CRUD::field('updated_at');

        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number']));
         */
    }

    public function setupShowOperation()
    {
        CRUD::column('id')->type('number')->thousands_sep('');
        CRUD::column('name');
        CRUD::column('code');
        CRUD::addColumn([
            'label' => 'Warehouse', // Table column heading
            'type' => 'select',
            'name' => 'warehouse_id', // the column that contains the ID of that connected entity;
            'entity' => 'warehouse', // the method that defines the relationship in your Model
            'attribute' => 'id', // foreign key attribute that is shown to user
        ]);
        CRUD::column('email');
        CRUD::column('address');
        CRUD::column('telephone');
        CRUD::column('zip_code');
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
