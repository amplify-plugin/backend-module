<?php

namespace Amplify\System\Backend\Http\Controllers\Admin\Auth;

use Amplify\System\Abstracts\BackpackCustomCrudController;
use Amplify\System\Backend\Http\Requests\CustomerRoleRequest;
use Amplify\System\Backend\Models\Contact;
use Amplify\System\Backend\Models\Permission;
use Amplify\System\Backend\Models\Role;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanel;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class CustomerRoleCrudController
 *
 * @property-read CrudPanel $crud
 */
class CustomerRoleCrudController extends BackpackCustomCrudController
{
    use CreateOperation;
    use DeleteOperation;
    use ListOperation;
    use UpdateOperation;

    private string $permission_model;

    public function setup()
    {
        $this->permission_model = Permission::class;

        CRUD::setModel(Role::class);
        CRUD::setEntityNameStrings('customer-role', 'customer role');
        CRUD::setRoute(backpack_url('customer-role'));
    }

    public function setupListOperation()
    {
        CRUD::addBaseClause('where', 'guard_name', Contact::AUTH_GUARD);

        $this->crud->query->withCount('users');

        $columns = [
            [
                'name' => 'name',
                'label' => 'Name',
                'type' => 'text',
            ],
            [
                'label' => 'Contact',
                'type' => 'text',
                'name' => 'contacts_count',
                'wrapper' => [
                    'href' => function ($crud, $column, $entry, $related_key) {
                        return backpack_url('contact?role=' . $entry->getKey());
                    },
                ],
                'suffix' => ' contacts',
            ],
            [
                'label' => 'Default?',
                'type' => 'boolean',
                'name' => 'is_default',
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
        ];

        if (config('permission.teams')) {

            CRUD::addFilter([
                'name' => 'team',
                'type' => 'select2_ajax',
                'label' => 'Customer',
                'placeholder' => 'Type Name, Code, Email, Phone',
                'method' => 'POST',
                'select_attribute' => 'customer_name',
            ],
                backpack_url('contact/fetch/customer'),
                function ($value) {
                    $this->crud->query->whereHas('teams', function ($query) use ($value) {
                        $query->where('team_id', $value);
                    });
                });


            array_unshift($columns, [
                'name' => 'teams.customer_name',
                'label' => 'Customer',
                'type' => 'relationship',
            ]);
        }

        CRUD::addColumns($columns);
    }

    public function setupCreateOperation()
    {
        CRUD::setValidation(CustomerRoleRequest::class);

        $fields = [
            [
                'name' => 'name',
                'label' => 'Name',
                'type' => 'text',
            ],
            [
                'name' => 'guard_name',
                'label' => 'Guard Name',
                'type' => 'hidden',
                'value' => 'customer',
            ],
            [
                'label' => 'Permissions',
                'type' => 'permission',
                'name' => 'permissions',
                'model' => $this->permission_model,
                'options' => function () {
                    return $this->permission_model::where('guard_name', Contact::AUTH_GUARD)
                        ->orderBy('name', 'ASC')
                        ->get()
                        ->pluck('name', 'id')
                        ->toArray();
                },
            ],
            [
                'label' => 'Default role for new contacts?',
                'type' => 'boolean',
                'name' => 'is_default',
            ],
        ];

        if (config('permission.teams')) {
            array_unshift($fields, [
                'name' => 'team_id',
                'label' => 'Customer',
                'type' => 'select2_from_ajax',
                'entity' => 'teams',
                'attribute' => 'display_name',
                'data_source' => backpack_url('contact/fetch/customer'),
                'placeholder' => 'Type customer name',
                'minimum_input_length' => 0,
                'method' => 'POST',
                'select_attribute' => 'display_name',
            ]);
        }

        CRUD::addFields($fields);

        // otherwise, changes won't have effect
        \Cache::forget('spatie.permission.cache');
    }

    public function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
