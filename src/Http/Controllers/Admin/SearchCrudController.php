<?php

namespace Amplify\System\Backend\Http\Controllers\Admin;

use Amplify\System\Abstracts\BackpackCustomCrudController;
use Amplify\System\Backend\Http\Requests\SearchRequest;
use Amplify\System\Backend\Models\Search;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanel;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class SearchCrudController
 *
 * @property-read CrudPanel $crud
 */
class SearchCrudController extends BackpackCustomCrudController
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
        CRUD::setModel(Search::class);
        CRUD::setRoute(config('backpack.base.route_prefix').'/search');
        CRUD::setEntityNameStrings('search', 'site config searches');
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
        abort(404);

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
        CRUD::setValidation(SearchRequest::class);

        //        CRUD::addField([
        //            'label'     => "Site", // Table column heading
        //            'type'      => "select",
        //            'name'      => 'site_id', // the column that contains the ID of that connected entity;
        //            'entity'    => 'site', // the method that defines the relationship in your Model
        //            'attribute' => "site_name", // foreign key attribute that is shown to user
        //            'model'     => Site::class // foreign key model
        //        ]);
        CRUD::addField([
            'name' => 'site_id',
            'type' => 'hidden',
        ]);

        CRUD::addField([
            'name' => 'easyask_url',
            'label' => 'Easyask Url',
            'type' => 'url',
            'tab' => 'EasyAsk',
        ]);
        CRUD::addField([
            'name' => 'dictionary_name',
            'label' => 'Dictionary Name',
            'type' => 'text',
            'tab' => 'EasyAsk',
        ]);
        CRUD::field('protocol')
            ->type('enum')
            ->tab('EasyAsk');
        CRUD::field('port')
            ->type('number')
            ->tab('EasyAsk');
        /* SAYT options */
        $this->crud->addFields([
            [
                'label' => 'Easyask Url',
                'type' => 'text',
                'name' => 'easyask_url',
                'tab' => 'SAYT',
            ],
        ]);

        CRUD::addField([
            'name' => 'dictionary_name',
            'label' => 'Dictionary Name',
            'type' => 'text',
            'tab' => 'SAYT',
        ]);
        CRUD::addField([
            'name' => 'protocol',
            'label' => 'Protocol',
            'type' => 'select2_from_array',
            'options' => ['HTTP', 'HTTPS'],
            'allows_null' => false,
            'tab' => 'SAYT',
        ]);

        CRUD::addField([
            'name' => 'port',
            'label' => 'Port',
            'type' => 'number',
            'tab' => 'SAYT',
        ]);

        CRUD::addField([
            'name' => 'sayt_product_id',
            'label' => 'Product ID',
            'type' => 'text',
            'tab' => 'SAYT',
        ]);
        CRUD::addField([
            'name' => 'sayt_product_image',
            'label' => 'Product Image',
            'type' => 'text',
            'tab' => 'SAYT',
        ]);
        CRUD::addField([
            'name' => 'sayt_product_name',
            'label' => 'Product Name',
            'type' => 'text',
            'tab' => 'SAYT',
        ]);
        CRUD::addField([
            'name' => 'sayt_product_price',
            'label' => 'Product Price',
            'type' => 'text',
            'tab' => 'SAYT',
        ]);
        CRUD::addField([
            'name' => 'sayt_product_description',
            'label' => 'Product Description',
            'type' => 'text',
            'tab' => 'SAYT',
        ]);
        CRUD::addField([
            'name' => 'sayt_product_type',
            'label' => 'Product Type',
            'type' => 'text',
            'tab' => 'SAYT',
        ]);
        CRUD::addField([
            'name' => 'sayt_product_sizes',
            'label' => 'Product Sizes',
            'type' => 'text',
            'tab' => 'SAYT',
        ]);

        /* EasyAsk Config */
        CRUD::addField([
            'name' => 'product_search_by_id_prefix',
            'label' => 'Easyask Product Search By Id Prefix',
            'type' => 'text',
            'tab' => 'EasyAsk',
        ]);

        CRUD::addField([
            'name' => 'easyask_host',
            'label' => 'EasyAsk Host',
            'type' => 'text',
            'tab' => 'EasyAsk',
        ]);

        CRUD::addField([
            'name' => 'easyask_port',
            'label' => 'EasyAsk Port',
            'type' => 'text',
            'tab' => 'EasyAsk',
        ]);

        CRUD::addField([
            'name' => 'easyask_dictionary',
            'label' => 'EasyAsk Dictionary',
            'type' => 'text',
            'tab' => 'EasyAsk',
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
        CRUD::addColumn(['name' => 'easyask_url', 'label' => 'Easyask Url']);
        CRUD::addColumn(['name' => 'dictionary_name', 'label' => 'Dictionary Name']);
        CRUD::column('protocol');
        CRUD::column('port');
        CRUD::removeButton('delete');
    }
}
