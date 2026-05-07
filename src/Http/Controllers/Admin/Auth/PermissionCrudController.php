<?php

namespace Amplify\System\Backend\Http\Controllers\Admin\Auth;

use Amplify\System\Abstracts\BackpackCustomCrudController;
use Amplify\System\Backend\Http\Requests\Auth\PermissionStoreCrudRequest;
use Amplify\System\Backend\Http\Requests\Auth\PermissionUpdateCrudRequest;
use Amplify\System\Backend\Models\Permission;
use Amplify\System\Backend\Models\User;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;

// VALIDATION

class PermissionCrudController extends BackpackCustomCrudController
{
    use CreateOperation;
    use DeleteOperation;
    use ListOperation;
    use UpdateOperation;

    public array $permissions = [];

    private array $permission;

    private string $guard_name;

    public function setup()
    {
        $this->crud->setModel(Permission::class);
        $this->crud->setRoute(backpack_url('permission'));
        $this->crud->setEntityNameStrings('permission', 'permissions');

        $this->guard_name = User::AUTH_GUARD;

        $this->crud->addBaseClause('where', 'guard_name', $this->guard_name);

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
        $this->crud->setValidation(PermissionStoreCrudRequest::class);

        // otherwise, changes won't have effect
        \Cache::forget('spatie.permission.cache');
    }

    public function setupUpdateOperation()
    {
        $this->crud->setValidation(PermissionUpdateCrudRequest::class);
        $this->addFields();

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
            'name' => 'guard_name',
            'label' => 'Guard Name',
            'type' => 'hidden',
            'default' => $this->guard_name,
        ]);
    }
}
