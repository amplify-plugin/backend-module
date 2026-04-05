<?php

namespace Amplify\System\Backend\Http\Controllers\Admin;

use Amplify\Frontend\Helpers\CustomerHelper;
use Amplify\System\Abstracts\BackpackCustomCrudController;
use Amplify\System\Backend\Http\Requests\ContactRequest;
use Amplify\System\Backend\Models\Contact;
use Amplify\System\Backend\Models\ContactLogin;
use Amplify\System\Backend\Models\Customer;
use Amplify\System\Backend\Models\CustomerAddress;
use Amplify\System\Backend\Models\CustomerGroup;
use Amplify\System\Backend\Models\CustomerPermission;
use Amplify\System\Backend\Models\Event;
use Amplify\System\Factories\NotificationFactory;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanel;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Support\Facades\DB;

/**
 * Class ContactRegistrationCrudController
 *
 * @property-read CrudPanel $crud
 */
class ContactRegistrationCrudController extends BackpackCustomCrudController
{
    use CreateOperation;
    use DeleteOperation;
    use ListOperation;
    use ShowOperation;
    use UpdateOperation {
        update as traitUpdate;
    }

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(Contact::class);
        CRUD::setRoute(config('backpack.base.route_prefix').'/contact-registration');
        CRUD::setEntityNameStrings('contact-registration', 'contact register requests');

        CRUD::denyAccess('create');
        CRUD::addBaseClause('unapproved');
        CRUD::addBaseClause('orWhereNull', 'enabled_at');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     *
     * @return void
     */
    protected function setupListOperation()
    {
        // Filtering with customer
        CRUD::addFilter(
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
                $this->crud->query->whereHas('customer', function ($query) use ($value) {
                    $query->where('customer_id', $value);
                });
            }
        );

        if (config('amplify.api.contact_detail', false)) {
            CRUD::addColumn([
                'name' => 'contact_code',
                'label' => 'Contact Code',
                'type' => 'text',
            ]);
        }

        CRUD::addColumn([
            'name' => 'customer_id',
            'attribute' => 'customer_name',
            'type' => 'custom_html',
            'value' => function ($contact) {
                return '<a href="'.route('customer.show', $contact->customer->id).'" target="_blank" class="text-dark">'.$contact->customer->customer_name.' - '.$contact->customer->customer_code.'</a>';
            },
            'searchLogic' => function ($query, $column, $searchTerm) {
                $query->orWhereHas('customer', function ($query) use ($searchTerm) {
                    $query->where('customer_name', 'like', '%'.$searchTerm.'%')
                        ->orWhere('customer_code', 'like', '%'.$searchTerm.'%');
                });
            },
        ]);
        CRUD::column('name');
        CRUD::addColumn([
            'name' => 'email',
            'label' => 'Email',
        ]);
    }

    /**
     * Define what happens when a single raw is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     *
     * @return void
     */
    protected function setupShowOperation()
    {
        CRUD::addColumn([
            'label' => 'Customer', // Table column heading
            'name' => 'customer.customer_name', // the column that contains the I
        ]);
        CRUD::column('name');
        CRUD::column('email');
    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     *
     * @return void
     */
    protected function setupUpdateOperation()
    {
        // Load the Contact model with the customer relationship
        $contact = Contact::with('customer')->findOrFail(request()->id);
        // Set the customer ID in the form for the select2 field to pre-select the correct value
        $this->crud->entry = $contact; // Ensure the data is correctly set for the form

        // This will set the customer team ID, just as you are already doing
        set_customer_team_id($contact->customer->id);

        // Call the setupCreateOperation method to apply the field configuration for the edit operation
        $this->crud->hasUploadFields();
        CRUD::setValidation(ContactRequest::class);

        $attributes = request()->query()['category_name'] ?? false
            ? ['readonly' => 'readonly']
            : [];

        CRUD::addField([
            'label' => 'Customer', // Table column heading
            'type' => 'select2_from_ajax',
            'name' => 'customer_id', // the column that contains the ID of that connected entity;
            'attribute' => 'display_name', // foreign key attribute that is shown to user
            'data_source' => backpack_url('contact/fetch/customer'),
            'method' => 'POST',
            'tab' => 'Basic',
            'default' => old('customer_id', $this->crud->entry->customer_id ?? null),
        ]);

        if (config('amplify.api.contact_detail', false)) {
            CRUD::addField([
                'name' => 'contact_code',
                'label' => 'Contact Code',
                'type' => 'text',
                'tab' => 'ERP',
            ]);
        }

        CRUD::field('name')->type('text')->tab('Basic');

        CRUD::addField([
            'name' => 'email',
            'label' => 'Email',
            'tab' => 'Basic',
            'type' => 'email',
            'attributes' => [
                'autocomplete' => 'off',
                'id' => 'new-email-address',
            ],
        ]);

        CRUD::field('phone')->type('text')->tab('Basic');

        CRUD::addField([
            'name' => 'roles',
            'label' => 'Role(s)',
            'type' => 'select2_from_ajax_multiple',
            'placeholder' => 'Select Roles',
            'minimum_input_length' => 0,
            'data_source' => route('contact.roles'),
            'include_all_form_fields' => true,
            'dependencies' => ['customer_id'],
            'tab' => 'Basic',
        ]);

        CRUD::addField([ // select2_from_ajax: 1-n relationship
            'label' => 'Address', // Table column heading
            'type' => 'select2_from_ajax',
            'name' => 'customer_address_id', // the column that contains the ID of that connected entity;
            'model' => CustomerAddress::class, // the method that defines the relationship in your Model
            'attribute' => 'display_name', // foreign key attribute that is shown to user
            'data_source' => route('addresses.get'), // url to controller search function (with /{id} should return model)
            'placeholder' => 'Select an address', // placeholder for the select
            'include_all_form_fields' => true, // sends the other form fields along with the request so it can be filtered.
            'minimum_input_length' => 0, // minimum characters to type before querying results
            'dependencies' => ['customer_id'], // when a dependency changes, this select2 is reset to null
            'pivot' => false,
            'tab' => 'Basic',
            'options' => (fn ($query) => $query->orderBy('address_name')->get()),
            'default' => old('customer_address_id', $this->crud->entry->customer_address_id ?? null),
        ]);

        CRUD::field('order_limit')->type('number')->attributes(['step' => 'any', 'min' => 0])->label('Order Limit')->tab('ERP');
        CRUD::field('daily_budget_limit')->type('number')->attributes(['step' => 'any', 'min' => 0])->label('Daily Budget Limit')->tab('ERP');
        CRUD::field('monthly_budget_limit')->type('number')->attributes(['step' => 'any', 'min' => 0])->label('Monthly Budget Limit')->tab('ERP');

        if (config('amplify.basic.enable_multi_customer_manage')) {
            CRUD::addField([
                'name' => 'warehouse_id',
                'type' => 'relationship',
                'label' => 'Default Warehouse',
                'entity' => 'ownWarehouse',
                'tab' => 'ERP',
                'options' => (fn ($query) => $query->orderBy('name')->get()),
            ]);

            CRUD::addField([
                'name' => 'contactLogins',
                'type' => 'relationship',
                'entity' => 'backendContactLogins',
                'label' => 'Assign Customers',
                'tab' => 'Login Manager',
                'subfields' => [
                    [
                        'name' => 'customer_id',
                        'label' => 'Customer',
                        'type' => 'contact_customer_assign',
                        'attribute' => 'customer_name',
                        'model' => Customer::class,
                        'data_source' => backpack_url('contact/fetch/assignable-customer'),
                        'method' => 'post',
                        'pivot' => false,
                        'delay' => 500,
                        'allows_null' => true,
                        'include_all_form_fields' => true,
                        'placeholder' => 'Type customer name, code, id',
                        'minimum_input_length' => 2,
                        'attributes' => [
                            'class' => 'contact_customer_assign',
                        ],

                    ],
                    [
                        'name' => 'warehouse_id',
                        'label' => 'Warehouse',
                        'entity' => 'warehouse',
                        'type' => 'relationship',
                        'placeholder' => 'Select an default warehouse',
                        'wrapper' => [
                            'class' => 'form-group col-md-6',
                        ],
                        'options' => (fn ($query) => $query->orderBy('name')->get()),
                    ],
                    [
                        'name' => 'customer_address_id',
                        'entity' => 'customerAddress',
                        'label' => 'Default ShipTo',
                        'placeholder' => 'Select an default ship to address',
                        'type' => 'relationship',
                        'wrapper' => [
                            'class' => 'form-group col-md-6',
                        ],
                        'options' => (fn ($query) => $query->orderBy('address_name')->get()),
                    ],
                    [
                        'name' => 'roles',
                        'label' => 'Current Role(s)',
                        'type' => 'select2_from_array',
                        'options' => [],
                        'allows_null' => false,
                        'fake' => true,
                        'allows_multiple' => true,
                    ],
                    [
                        'name' => 'permissions',
                        'label' => 'Permissions',
                        'type' => 'permission',
                        'attribute' => 'name',
                        'fake' => true,
                        'model' => CustomerPermission::class,
                        'options' => function () {
                            return CustomerPermission::where('guard_name', Contact::AUTH_GUARD)
                                ->orderBy('name', 'ASC')->pluck('name', 'id')->toArray();
                        },
                    ],
                ],
            ]);
        }

        CRUD::addField([
            'name' => 'password_reset_required',
            'type' => 'hidden',
        ]);

        CRUD::addField([
            'name' => 'profile_image',
            'label' => 'Profile Image',
            'type' => 'upload',
            'upload' => true,
            'withFiles' => true,
            'tab' => 'Basic',
        ]);

        CRUD::addField([
            'name' => 'redirect_route',
            'label' => 'Preferred Page After Login',
            'type' => 'select_from_array',
            'allows_null' => true,
            'options' => CustomerHelper::redirecteableUrls(),
            'default' => 'contacts',
            'tab' => 'Basic',
        ]);

        CRUD::addField([
            'name' => 'enabled',
            'label' => 'Enabled',
            'type' => 'boolean',
            'allows_null' => false,
            'default' => true,
            'tab' => 'Basic',
            'hint' => 'If the contact is enabled, they will be able to login to the system.',
        ]);

        CRUD::addField([
            'name' => 'ownPermissions',
            'label' => 'Permissions',
            'type' => 'permission',
            'attribute' => 'name',
            'model' => CustomerPermission::class,
            'options' => function () {
                return CustomerPermission::where('guard_name', Contact::AUTH_GUARD)
                    ->orderBy('name', 'ASC')->pluck('name', 'id')->toArray();
            },
            'tab' => 'Permission',
        ]);
    }

    public function update(ContactRequest $request)
    {
        $this->crud->removeFields(['roles', 'contactLogins']);
        $this->crud->setRequest($this->crud->validateRequest());
        $this->crud->unsetValidation();
        $traitRes = $this->traitUpdate();
        // Get the contact entry
        $contact = Contact::findOrFail($request->id);
        // Check if 'enabled' is set to true and 'enabled_at' is empty
        if ($request->enabled == 1 && empty($contact->enabled_at)) {
            // Set 'enabled_at' to the current timestamp
            $contact->enabled_at = now();
            $contact->save();

            if (config('amplify.client_code' == 'ALR')){
                // Trigger the notification
                NotificationFactory::call(Event::CONTACT_ACCOUNT_REQUEST_ACCEPTED, [
                    'contact_id' => $contact->id
                ]);
            }{
                // Trigger the notification
                NotificationFactory::call(Event::REGISTRATION_REQUEST_ACCEPTED, [
                    'contact_id' => $contact->id, 'customer_id' => $contact->customer_id,
                ]);
            }
        }
        $this->afterCreateUpdateOperation($request);
        $this->crud->entry->updateContactLoginAsPerEntry();

        return $traitRes;
    }

    protected function afterCreateUpdateOperation($request): void
    {
        $this->crud->entry->refresh();

        if ($request->filled('roles')) {
            $roles = [];

            foreach ($request->roles ?? [] as $role_id) {
                $roles[$role_id] = [
                    'team_id' => $request->customer_id,
                ];
            }

            $this->crud->entry->roles()->sync($roles);
        }

        if ($request->filled('ownPermissions')) {
            $ownPermissions = [];

            DB::table(config('permission.table_names.model_has_permissions'))->where([
                'model_type' => Contact::class,
                'model_id' => $this->crud->entry->id,
                'team_id' => $request->customer_id,
            ])->delete();

            foreach (json_decode($request->ownPermissions, true) ?? [] as $permission_id) {
                $ownPermissions[$permission_id] = [
                    'team_id' => $request->customer_id,
                ];
            }

            $this->crud->entry->permissions()->sync($ownPermissions);
        }

        DB::transaction(function () use ($request) {
            $roles = [];
            $permissions = [];
            $contact = $this->crud->entry;
            $contact->contactLogins()
                ->where('customer_id', '<>', $contact->customer_id)
                ->delete();

            foreach ($request->contactLogins ?? [] as $login_customer) {

                ContactLogin::firstOrCreate([
                    'contact_id' => $contact->id,
                    'customer_id' => $login_customer['customer_id'],
                    'warehouse_id' => $login_customer['warehouse_id'],
                    'customer_address_id' => $login_customer['customer_address_id'],
                ]);

                $login_customer['permissions'] = is_string($login_customer['permissions']) ? json_decode($login_customer['permissions'], true) : $login_customer['permissions'];

                DB::table(config('permission.table_names.model_has_roles'))->where([
                    'model_type' => Contact::class,
                    'model_id' => $contact->id,
                    'team_id' => $login_customer['customer_id'],
                ])->delete();

                DB::table(config('permission.table_names.model_has_permissions'))->where([
                    'model_type' => Contact::class,
                    'model_id' => $contact->id,
                    'team_id' => $login_customer['customer_id'],
                ])->delete();

                foreach ($login_customer['roles'] ?? [] as $role) {
                    if ($role) {
                        $roles[] = [
                            'role_id' => $role,
                            'model_type' => Contact::class,
                            'model_id' => $contact->id,
                            'team_id' => $login_customer['customer_id'],
                        ];
                    }
                }

                foreach ($login_customer['permissions'] ?? [] as $permission) {
                    if ($permission) {
                        $permissions[] = [
                            'permission_id' => $permission,
                            'model_type' => Contact::class,
                            'model_id' => $contact->id,
                            'team_id' => $login_customer['customer_id'],
                        ];
                    }
                }

            }

            DB::table(config('permission.table_names.model_has_roles'))->insert($roles);
            DB::table(config('permission.table_names.model_has_permissions'))->insert($permissions);
            $contact->validateActiveCustomer();
        });
    }

    public function fetchCustomerGroup()
    {
        return CustomerGroup::where('group_name', 'like', '%'.\request()->q.'%')->get();
    }
}
