<?php

namespace Amplify\System\Backend\Http\Controllers\Admin;

use Amplify\System\Abstracts\BackpackCustomCrudController;
use Amplify\System\Backend\Http\Requests\CustomProductRequest;
use Amplify\System\Backend\Models\CustomProduct;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Backpack\CRUD\app\Library\Widget;

/**
 * Class CustomProductCrudController
 *
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class CustomProductCrudController extends BackpackCustomCrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;

    public function setup()
    {
        CRUD::setModel(CustomProduct::class);
        CRUD::setRoute(config('backpack.base.route_prefix').'/custom-product');
        CRUD::setEntityNameStrings('custom product', 'custom products');

        CRUD::denyAccess('create');
    }

    protected function setupListOperation()
    {
        CRUD::column('name');
        CRUD::column('type')->type('select_from_array')->options(CustomProduct::PRODUCT_TYPE);
        CRUD::column('created_at');
        CRUD::column('updated_at');
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(CustomProductRequest::class);

        CRUD::addFields([
            ['name' => 'name'],
            [
                'name' => 'value',
                'attributes' => [
                    'rows' => '20',
                    'style' => 'background: antiquewhite',
                ],
                'hint' => '
                    Click <a id="product-ref-link" target="_blank" href="javascript::void(0)">here</a> to open the standard json file for the custom product.
                    <p id="json-validation-error" class="text-danger"></p>
                ',
            ],
            ['name' => 'ref_link', 'type' => 'hidden'],
        ]);

        Widget::add()->type('script')->content('vendor/backend/js/forms/custom-product.js');
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
