<?php

namespace Amplify\System\Backend\Http\Controllers\Admin;

use Amplify\System\Abstracts\BackpackCustomCrudController;
use Amplify\System\Backend\Http\Requests\RoleCrudRequest;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class RoleCrudController
 *
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class RoleCrudController extends BackpackCustomCrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;

    /**
     * @var \Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed
     */
    private $permission_model;

    private string $guard_name;

    public function setup()
    {
        $this->permission_model = config('backpack.permissionmanager.models.permission');
        $this->guard_name = 'web';

        $this->crud->setModel(config('backpack.permissionmanager.models.role'));
        $this->crud->setEntityNameStrings(trans('backpack::permissionmanager.role'), trans('backpack::permissionmanager.roles'));
        $this->crud->setRoute(config('backpack.base.route_prefix').'/role');
        $this->crud->addClause('where', 'guard_name', $this->guard_name);

        // deny access according to configuration file
        if (config('backpack.permissionmanager.allow_role_create') == false) {
            $this->crud->denyAccess('create');
        }
        if (config('backpack.permissionmanager.allow_role_update') == false) {
            $this->crud->denyAccess('update');
        }
        if (config('backpack.permissionmanager.allow_role_delete') == false) {
            $this->crud->denyAccess('delete');
        }
    }

    public function setupListOperation()
    {
        /**
         * Show a column for the name of the role.
         */
        CRUD::column('id')->type('number')->thousands_sep('');

        $this->crud->addColumn([
            'name' => 'name',
            'label' => trans('backpack::permissionmanager.name'),
            'type' => 'text',
        ]);

        /**
         * Show a column with the number of users that have that particular role.
         *
         * Note: To account for the fact that there can be thousands or millions
         * of users for a role, we did not use the `relationship_count` column,
         * but instead opted to append a fake `user_count` column to
         * the result, using Laravel's `withCount()` method.
         * That way, no users are loaded.
         */
        $this->crud->query->withCount('users');
        $this->crud->addColumn([
            'label' => trans('backpack::permissionmanager.users'),
            'type' => 'text',
            'name' => 'users_count',
            'wrapper' => [
                'href' => function ($crud, $column, $entry, $related_key) {
                    return backpack_url('user?role='.$entry->getKey());
                },
            ],
            'suffix' => ' '.strtolower(trans('backpack::permissionmanager.users')),
        ]);

        /**
         * Show the exact permissions that role has.
         */
        $this->crud->addColumn([
            // n-n relationship (with pivot table)
            'label' => mb_ucfirst(trans('backpack::permissionmanager.permission_plural')),
            'type' => 'select_multiple',
            'name' => 'permissions', // the method that defines the relationship in your Model
            'entity' => 'permissions', // the method that defines the relationship in your Model
            'attribute' => 'name', // foreign key attribute that is shown to user
            'model' => $this->permission_model, // foreign key model
            'pivot' => true, // on create&update, do you need to add/delete pivot table entries?
        ]);
    }

    public function setupCreateOperation()
    {
        $this->addFields();
        $this->crud->setCreateContentClass('col-md-12');
        $this->crud->setValidation(RoleCrudRequest::class);

        // otherwise, changes won't have effect
        \Cache::forget('spatie.permission.cache');
    }

    public function setupUpdateOperation()
    {
        $this->addFields();
        $this->crud->setUpdateContentClass('col-md-12');
        $this->crud->setValidation(RoleCrudRequest::class);

        // otherwise, changes won't have effect
        \Cache::forget('spatie.permission.cache');
    }

    private function addFields()
    {
        $this->crud->addField([
            'name' => 'name',
            'label' => trans('backpack::permissionmanager.name'),
            'type' => 'text',
        ]);

        $this->crud->addField([
            'name' => 'guard_name',
            'label' => trans('backpack::permissionmanager.guard_type'),
            'type' => 'hidden',
            'value' => 'web',
        ]);
        $this->crud->addField([
            'name' => 'team_id',
            'type' => 'hidden',
            'value' => '0',
        ]);

        $this->crud->addField([
            'label' => mb_ucfirst(trans('backpack::permissionmanager.permission_plural')),
            'type' => 'permission',
            'name' => 'permissions',
            'model' => $this->permission_model,
            'options' => function () {
                return $this->permission_model::where('guard_name', 'web')->orderBy('name', 'ASC')->pluck('name', 'id')->toArray();
            },
        ]);
    }
}
