<?php

namespace Amplify\System\Backend\Http\Controllers\Admin;

use Amplify\System\Abstracts\BackpackCustomCrudController;
use Amplify\System\Backend\Http\Requests\SitePricingRequest;
use Amplify\System\Backend\Models\Site;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class SitePricingCrudController
 *
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class SitePricingCrudController extends BackpackCustomCrudController
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
        CRUD::setModel(\Amplify\System\Backend\Models\SitePricing::class);
        CRUD::setRoute(config('backpack.base.route_prefix').'/site-pricing');
        CRUD::setEntityNameStrings('site-pricing', 'pricings');
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
        if (isset($_SERVER['HTTP_REFERER'])) {
            // Return to preview page
            header('Location: '.substr($_SERVER['HTTP_REFERER'], 0, -4).'show');
            exit();
        }
        $this->crud->setListView('crud::pages.nothing-to-show');

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
        CRUD::setValidation(SitePricingRequest::class);

        CRUD::addField([
            'label' => 'Site', // Table column heading
            'type' => 'select',
            'name' => 'site_id', // the column that contains the ID of that connected entity;
            'entity' => 'site', // the method that defines the relationship in your Model
            'attribute' => 'site_name', // foreign key attribute that is shown to user
            'model' => Site::class, // foreign key model
        ]);

        CRUD::addField([
            'name' => 'currency',
            'label' => 'Currency',
            'type' => 'select2_from_array',
            'options' => \Amplify\System\Helpers\UtilityHelper::currencyDropdown(),
            'allows_null' => false,
            'default' => config('amplify.basic.global_currency'),
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
        CRUD::addColumn(['name' => 'site', 'attribute' => 'site_name']);
        CRUD::column('currency');
        CRUD::removeButton('delete');
    }
}
