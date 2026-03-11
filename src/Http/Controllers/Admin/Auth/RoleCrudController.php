<?php

namespace Amplify\System\Backend\Http\Controllers\Admin\Auth;

use Amplify\System\Abstracts\BackpackCustomCrudController;
use Amplify\System\Backend\Http\Requests\RoleCrudRequest;
use Amplify\System\Backend\Models\Permission;
use Amplify\System\Backend\Models\Role;
use Amplify\System\Backend\Models\User;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanel;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Config\Repository;
use Illuminate\Contracts\Foundation\Application;

/**
 * Class RoleCrudController
 *
 * @property-read CrudPanel $crud
 */
class RoleCrudController extends BackpackCustomCrudController
{
    use CreateOperation;
    use DeleteOperation;
    use ListOperation;
    use UpdateOperation;

    /**
     * @var Repository|Application|mixed
     */
    private $permission_model;

    private string $guard_name;

    public function setup()
    {
        $this->permission_model = Permission::class;
        $this->guard_name = User::AUTH_GUARD;

        CRUD::setModel(Role::class);
        CRUD::setEntityNameStrings('role', 'roles');
        CRUD::setRoute(backpack_url('role'));
    }

    public function setupListOperation()
    {
        CRUD::addBaseClause('where', 'guard_name', '=', $this->guard_name);
        CRUD::addBaseClause('where', 'team_id', '=', User::SYSTEM_TEAM_ID);
        $this->crud->query->withCount('users');

        CRUD::addColumns([
            [
                'name' => 'name',
                'label' => 'Name',
                'type' => 'text',
            ], [
                'label' => 'Users',
                'type' => 'text',
                'name' => 'users_count',
                'wrapper' => [
                    'href' => function ($crud, $column, $entry, $related_key) {
                        return backpack_url('user?role='.$entry->getKey());
                    },
                ],
                'suffix' => ' users',
            ],
            [
                'label' => 'Entry Date',
                'type' => 'datetime',
                'name' => 'created_at',
            ],
            [
                'label' => 'Last Modified',
                'type' => 'datetime',
                'name' => 'updated_at',
            ],
        ]);
    }

    public function setupCreateOperation()
    {
        CRUD::setCreateContentClass('col-md-12');

        CRUD::setValidation(RoleCrudRequest::class);

        CRUD::addFields([
            [
                'name' => 'name',
                'label' => 'Name',
                'type' => 'text',
            ],
            [
                'name' => 'guard_name',
                'type' => 'hidden',
                'value' => 'web',
            ],
            [
                'name' => 'team_id',
                'type' => 'hidden',
                'value' => User::SYSTEM_TEAM_ID,
            ],
            [
                'label' => 'Permissions',
                'type' => 'permission',
                'name' => 'permissions',
                'model' => $this->permission_model,
                'options' => function () {
                    return $this->permission_model::where('guard_name', 'web')->orderBy('name', 'ASC')->pluck('name', 'id')->toArray();
                },
            ],
        ]);

        // otherwise, changes won't have effect
        \Cache::forget('spatie.permission.cache');
    }

    public function setupUpdateOperation()
    {
        CRUD::setUpdateContentClass('col-md-12');

        $this->setupCreateOperation();
    }
}
