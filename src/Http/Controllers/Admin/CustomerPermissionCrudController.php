<?php

namespace Amplify\System\Backend\Http\Controllers\Admin;

use Amplify\System\Abstracts\BackpackCustomCrudController;
use Amplify\System\Backend\Models\CustomerPermission;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\PermissionManager\app\Http\Requests\PermissionStoreCrudRequest as StoreRequest;
use Backpack\PermissionManager\app\Http\Requests\PermissionUpdateCrudRequest as UpdateRequest;

// VALIDATION

class CustomerPermissionCrudController extends BackpackCustomCrudController
{
    use CreateOperation;
    use DeleteOperation;
    use ListOperation;
    use UpdateOperation;

    public function setup()
    {
        $this->crud->setModel(CustomerPermission::class);
        $this->crud->setEntityNameStrings('customer-permission', 'customer permissions');
        $this->crud->setRoute(backpack_url('customer-permission'));

        $this->guard_name = 'customer';
        $this->crud->addClause('where', 'guard_name', $this->guard_name);
    }

    public function setupListOperation()
    {
        $this->crud->addColumn([
            'name' => 'name',
            'label' => 'Name',
            'type' => 'text',
        ]);
    }

    public function setupCreateOperation()
    {
        $this->addFields();
        $this->crud->setValidation(StoreRequest::class);

        // otherwise, changes won't have effect
        \Cache::forget('spatie.permission.cache');
    }

    public function setupUpdateOperation()
    {
        $this->addFields();
        $this->crud->setValidation(UpdateRequest::class);

        // otherwise, changes won't have effect
        \Cache::forget('spatie.permission.cache');
    }

    private function addFields()
    {
        $this->crud->addField([
            'name' => 'name',
            'label' => 'Name',
            'type' => 'text',
        ]);

        $this->crud->addField([
            'label' => '',
            'name' => 'guard_name',
            'type' => 'hidden',
            'default' => $this->guard_name,
        ]);
    }
}
