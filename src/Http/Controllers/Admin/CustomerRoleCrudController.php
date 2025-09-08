<?php

namespace Amplify\System\Backend\Http\Controllers\Admin;

use Amplify\System\Abstracts\BackpackCustomCrudController;
use Amplify\System\Backend\Http\Requests\CustomerRoleRequest;
use Amplify\System\Backend\Models\CustomerPermission;
use Amplify\System\Backend\Models\CustomerRole;

/**
 * Class CustomerRoleCrudController
 *
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class CustomerRoleCrudController extends BackpackCustomCrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;

    private string $guard_name;

    private string $permission_model;

    public function setup()
    {
        $this->permission_model = CustomerPermission::class;
        $this->guard_name = 'customer';

        $this->crud->setModel(CustomerRole::class);
        $this->crud->setEntityNameStrings('customer-role', 'customer role');
        $this->crud->setRoute(backpack_url('customer-role'));
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

        $this->crud->query->withCount('contacts');
        /**
         * Show a column for the name of the role.
         */
        $this->crud->addColumn([
            'name' => 'id',
            'label' => '#',
            'type' => 'custom_html',
            'value' => function (CustomerRole $customerRole) {
                return $customerRole->id.($customerRole->is_reserved ? '<sup class="text-warning font-weight-bold ml-1">Reserved</sup>' : '');
            },
        ]);

        $this->crud->addColumn([
            'name' => 'teams.customer_name',
            'label' => 'Customer',
            'type' => 'relationship',
        ]);

        $this->crud->addColumn([
            'name' => 'name',
            'label' => trans('backpack::permissionmanager.name'),
            'type' => 'text',
        ]);

        $this->crud->addColumn([
            'label' => 'Contact',
            'type' => 'text',
            'name' => 'contacts_count',
            'wrapper' => [
                'href' => function ($crud, $column, $entry, $related_key) {
                    return backpack_url('contact?role='.$entry->getKey().'-'.$entry->team_id);
                },
            ],
            'suffix' => ' contacts',
        ]);

        $this->crud->addFilter(
            [
                'name' => 'category_name',
                'type' => 'select2_ajax',
                'label' => 'Customer',
                'placeholder' => 'Type Name, Code, Email, Phone',
                'method' => 'POST',
                'select_attribute' => 'customer_name',
            ],
            backpack_url('contact/fetch/customer'),
            function ($value) { // if the filter is active
                $this->crud->query->whereHas('teams', function ($query) use ($value) {
                    $query->where('team_id', $value);
                });
            }
        );
    }

    public function setupCreateOperation()
    {
        $this->addFields();
        $this->crud->setValidation(CustomerRoleRequest::class);

        // otherwise, changes won't have effect
        \Cache::forget('spatie.permission.cache');
    }

    public function setupUpdateOperation()
    {
        $this->addFields();
        $this->crud->setValidation(CustomerRoleRequest::class);

        // otherwise, changes won't have effect
        \Cache::forget('spatie.permission.cache');
    }

    private function addFields()
    {
        $id = $this->crud->getCurrentEntryId();
        $isReserved = $id && CustomerRole::where(['id' => request()->id, 'is_reserved' => true])->exists();

        if (! $isReserved) {
            $this->crud->addFields([
                [
                    'name' => 'team_id',
                    'label' => 'Customer',
                    'type' => 'select2_from_ajax',
                    'entity' => 'teams',
                    'attribute' => 'customer_name',
                    'data_source' => backpack_url('contact/fetch/customer'),
                    'placeholder' => 'Type customer name',
                    'minimum_input_length' => 0,
                    'method' => 'POST',
                    'select_attribute' => 'customer_name',
                    'options' => (fn ($query) => $query->orderBy('customer_name')->get()),
                ],
                [
                    'name' => 'name',
                    'label' => trans('backpack::permissionmanager.name'),
                    'type' => 'text',
                ],
            ]);
        }

        $this->crud->addFields([
            [
                'name' => 'guard_name',
                'label' => trans('backpack::permissionmanager.guard_type'),
                'type' => 'hidden',
                'value' => 'customer',
            ],
            [
                'label' => mb_ucfirst(trans('backpack::permissionmanager.permission_plural')),
                'type' => 'permission',
                'name' => 'permissions',
                'model' => $this->permission_model,
                'options' => function () {
                    return $this->permission_model::where('guard_name', customer_guard())->orderBy('name', 'ASC')->pluck('name', 'id')->toArray();
                },
            ],
        ]);
    }

    public function destroy($id)
    {
        $this->crud->hasAccessOrFail('delete');

        // get entry ID from Request (makes sure its the last ID for nested resources)
        $entry = $this->crud->getCurrentEntry();

        if ($entry->is_reserved) {
            return false;
        }

        return $entry->delete($id);
    }
}
