<?php

namespace Amplify\System\Backend\Http\Controllers\Admin;

use Amplify\System\Abstracts\BackpackCustomCrudController;
use Amplify\System\Backend\Http\Requests\UserRequest;
use Amplify\System\Backend\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;

/**
 * Class RoleCrudController
 *
 * @overwrite \Backpack\PermissionManager\app\Http\Controllers\UserCrudController
 *
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class UserCrudController extends BackpackCustomCrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation {
        store as traitStore;
    }
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation {
        update as traitUpdate;
    }

    public function setup()
    {
        $this->crud->setModel(config('backpack.permissionmanager.models.user'));
        $this->crud->setEntityNameStrings('user', trans('backpack::permissionmanager.users'));
        $this->crud->setRoute(backpack_url('user'));
    }

    public function setupListOperation()
    {
        $this->crud->column('id');

        $this->crud->addColumns([
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
                'label' => trans('backpack::permissionmanager.name'),
                'type' => 'text',
            ],
            [
                'name' => 'email',
                'label' => trans('backpack::permissionmanager.email'),
                'type' => 'email',
            ],
            [
                'name' => 'enabled',
                'type' => 'boolean',
                'label' => 'Enabled',
                'default' => true,
            ],
            [ // n-n relationship (with pivot table)
                'label' => trans('backpack::permissionmanager.roles'), // Table column heading
                'type' => 'select_multiple',
                'name' => 'roles', // the method that defines the relationship in your Model
                'entity' => 'roles', // the method that defines the relationship in your Model
                'attribute' => 'name', // foreign key attribute that is shown to user
                'model' => config('permission.models.role'), // foreign key model
            ],
        ]);

        // Role Filter
        $this->crud->addFilter(
            [
                'name' => 'role',
                'type' => 'dropdown',
                'label' => trans('backpack::permissionmanager.role'),
            ],
            config('permission.models.role')::all()->pluck('name', 'id')->toArray(),
            function ($value) { // if the filter is active
                $this->crud->addClause('whereHas', 'roles', function ($query) use ($value) {
                    $query->where('role_id', '=', $value);
                });
            }
        );

        $this->crud->addFilter(
            [
                'name' => 'type',
                'type' => 'dropdown',
                'label' => 'User Type',
            ],
            User::USER_TYPES,
            function ($value) {
                $this->crud->addClause(function ($query) use ($value) {
                    $query->where('type', '=', $value);
                });
            }
        );
    }

    public function setupCreateOperation()
    {
        $this->addUserFields();
        $this->crud->setCreateContentClass('col-md-12');
        $this->crud->setValidation(UserRequest::class);
    }

    public function setupUpdateOperation()
    {
        $this->addUserFields();
        $this->crud->setUpdateContentClass('col-md-12');
        $this->crud->setValidation(UserRequest::class);
    }

    /**
     * Store a newly created resource in the database.
     *
     * @return RedirectResponse
     */
    public function store()
    {
        $this->crud->setRequest($this->crud->validateRequest());
        $this->crud->setRequest($this->handlePasswordInput($this->crud->getRequest()));
        $this->crud->unsetValidation(); // validation has already been run

        return $this->traitStore();
    }

    /**
     * Update the specified resource in the database.
     *
     * @return RedirectResponse
     */
    public function update()
    {
        $this->crud->setRequest($this->crud->validateRequest());
        $this->crud->setRequest($this->handlePasswordInput($this->crud->getRequest()));
        $this->crud->unsetValidation(); // validation has already been run

        return $this->traitUpdate();
    }

    /**
     * Handle password input fields.
     */
    protected function handlePasswordInput($request)
    {
        // Remove fields not present on the user.
        $request->request->remove('password_confirmation');
        $request->request->remove('roles_show');
        $request->request->remove('permissions_show');

        // Encrypt password if specified.
        if ($request->input('password')) {
            $request->request->set('password', Hash::make($request->input('password')));

        } else {
            $request->request->remove('password');
            $request->request->remove('password_reset_required');
        }

        return $request;
    }

    protected function addUserFields()
    {
        $this->crud->addFields([
            [
                'name' => 'password_reset_required',
                'label' => trans('backpack::permissionmanager.name'),
                'type' => 'hidden',
                'value' => (request()->route()->getName() == 'user.edit' && request()->route('id') == backpack_user()->id) ? 0 : 1,
            ],
            [
                'name' => 'name',
                'label' => trans('backpack::permissionmanager.name'),
                'type' => 'text',
            ],
            [
                'name' => 'email',
                'label' => trans('backpack::permissionmanager.email'),
                'type' => 'email',
            ],
            [
                'name' => 'password',
                'label' => trans('backpack::permissionmanager.password'),
                'type' => 'password',
            ],
            [
                'name' => 'password_confirmation',
                'label' => trans('backpack::permissionmanager.password_confirmation'),
                'type' => 'password',
            ],
            [
                'label' => 'Type',
                'type' => 'select_from_array',
                'name' => 'type',
                'options' => User::USER_TYPES,
            ],
            [
                'label' => trans('backpack::permissionmanager.roles'),
                'type' => 'select2_multiple',
                'name' => 'roles',
                'options' => function () {
                    return config('permission.models.role')::where('team_id', 0)->whereIn('guard_name', ['web', 'api'])->get();
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
                'type' => 'boolean',
                'label' => 'Enabled?',
                'default' => true,
                'hint' => 'Note: If disabled, user will be restricted to login to system.',
            ],
        ]);
    }
}
