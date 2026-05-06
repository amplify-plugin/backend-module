<?php

namespace Amplify\System\Backend\Http\Controllers\Admin\Auth;

use Amplify\System\Abstracts\BackpackCustomCrudController;
use Amplify\System\Backend\Http\Requests\UserRequest;
use Amplify\System\Backend\Models\Role;
use Amplify\System\Backend\Models\User;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanel;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class UserCrudController
 *
 * @property-read CrudPanel $crud
 */
class UserCrudController extends BackpackCustomCrudController
{
    use CreateOperation;
    use DeleteOperation;
    use ListOperation;
    use UpdateOperation;

    public function setup()
    {
        CRUD::setModel(User::class);
        CRUD::setEntityNameStrings('user', 'users');
        CRUD::setRoute(backpack_url('user'));
    }

    public function setupListOperation()
    {
        CRUD::column('id');

        CRUD::addColumns([
            [
                'name' => 'image',
                'label' => 'Image',
                'type' => 'image',
                'width' => '60px',
                'height' => '60px',
                'border' => '2px solid #ed6816a1',
                'border-radius' => '50% !imoprtant',
            ],
            [
                'name' => 'name',
                'label' => 'Name',
                'type' => 'text',
            ],
            [
                'name' => 'email',
                'label' => 'Email',
                'type' => 'email',
            ],
            [
                'name' => 'enabled',
                'type' => 'boolean',
                'label' => 'Enabled',
                'default' => true,
            ],
            [ // n-n relationship (with pivot table)
                'label' => 'Role(s)', // Table column heading
                'type' => 'select_multiple',
                'name' => 'roles', // the method that defines the relationship in your Model
                'entity' => 'roles', // the method that defines the relationship in your Model
                'attribute' => 'name', // foreign key attribute that is shown to user
                'model' => config('permission.models.role'), // foreign key model
            ],
        ]);

        CRUD::addFilter(
            [
                'name' => 'role',
                'type' => 'dropdown',
                'label' => 'Role',
            ],
            Role::where('team_id', '=', getPermissionsTeamId())
                ->where('guard_name', '=', User::AUTH_GUARD)
                ->get()
                ->pluck('name', 'id')
                ->toArray(),
            function ($value) { // if the filter is active
                CRUD::addClause('whereHas', 'roles', function ($query) use ($value) {
                    $query->where('role_id', '=', $value);
                });
            }
        );

        CRUD::addFilter(
            [
                'name' => 'type',
                'type' => 'dropdown',
                'label' => 'User Type',
            ],
            User::USER_TYPES,
            function ($value) {
                CRUD::addClause(function ($query) use ($value) {
                    $query->where('type', '=', $value);
                });
            }
        );
    }

    public function setupCreateOperation()
    {
        CRUD::addFields([
            [
                'name' => 'password_reset_required',
                'label' => 'Name',
                'type' => 'hidden',
                'value' => (request()->route()->getName() == 'user.edit' && request()->route('id') == backpack_user()->id) ? '0' : '1',
            ],
            [
                'name' => 'name',
                'label' => 'Name',
                'type' => 'text',
            ],
            [
                'name' => 'email',
                'label' => 'Email',
                'type' => 'email',
            ],
            [
                'name' => 'password',
                'label' => 'Password',
                'type' => 'password',
            ],
            [
                'name' => 'password_confirmation',
                'label' => 'Retype Password',
                'type' => 'password',
            ],
            [
                'label' => 'Type',
                'type' => 'select_from_array',
                'name' => 'type',
                'options' => User::USER_TYPES,
            ],
            [
                'label' => 'Role(s)',
                'placeholder' => 'Select Roles',
                'type' => 'select2_multiple',
                'name' => 'roles',
                'options' => function () {
                    return Role::where('guard_name', '=', User::AUTH_GUARD)->get();
                },
            ],
            [
                'name' => 'image',
                'label' => 'Profile Image',
                'type' => 'upload',
                'upload' => true,
                'withFiles' => true,
            ],
            [
                'name' => 'api_token',
                'label' => 'API Token',
                'type' => 'show_hide_token',
            ],
            [
                'name' => 'enabled',
                'type' => 'checkbox',
                'label' => 'Enabled?',
                'value' => true,
                'hint' => 'Note: If disabled, user will be restricted to login to system.',
            ],
        ]);

        CRUD::setCreateContentClass('col-md-12');

        CRUD::setValidation(UserRequest::class);
    }

    public function setupUpdateOperation()
    {
        CRUD::setUpdateContentClass('col-md-12');

        $this->setupCreateOperation();
    }
}
