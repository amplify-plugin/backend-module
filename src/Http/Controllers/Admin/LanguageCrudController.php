<?php

namespace Amplify\System\Backend\Http\Controllers\Admin;

use Amplify\System\Abstracts\BackpackCustomCrudController;
use Amplify\System\Backend\Http\Requests\LanguageRequest;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

class LanguageCrudController extends BackpackCustomCrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;

    public function setup()
    {
        $this->crud->setModel("Amplify\System\Backend\Models\Language");
        $this->crud->setRoute(config('backpack.base.route_prefix').'/language');
        $this->crud->setEntityNameStrings('language', 'languages');
    }

    protected function setupListOperation()
    {
        CRUD::column('id')->type('number')->thousands_sep('');
        $this->crud->addColumn([
            'name' => 'flag',
            'type' => 'image',
            'width' => '80px',
            'height' => 'auto',
        ]);
        $this->crud->column('code');
        $this->crud->column('name');
    }

    public function setupShowOperation()
    {
        CRUD::column('id')->type('number')->thousands_sep('');
        CRUD::addColumn([
            'name' => 'flag',
            'type' => 'image',
            'width' => '80px',
            'height' => 'auto',
        ]);
        CRUD::column('name');
        CRUD::column('code');
    }

    protected function setupCreateOperation()
    {
        $this->crud->setValidation(LanguageRequest::class);

        $this->crud->addField(['name' => 'name', 'type' => 'text']);
        $this->crud->addField(['name' => 'code', 'type' => 'text']);
        $this->crud->addField(['name' => 'flag', 'type' => 'image']);
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
