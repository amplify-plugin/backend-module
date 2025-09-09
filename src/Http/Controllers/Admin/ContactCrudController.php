<?php

namespace Amplify\System\Backend\Http\Controllers\Admin;

use Amplify\ErpApi\Facades\ErpApi;
use Amplify\Frontend\Events\ContactLoggedIn;
use Amplify\Frontend\Helpers\CustomerHelper;
use Amplify\System\Abstracts\BackpackCustomCrudController;
use Amplify\System\Backend\Http\Requests\ContactRequest;
use Amplify\System\Backend\Models\Contact;
use Amplify\System\Backend\Models\ContactLogin;
use Amplify\System\Backend\Models\Customer;
use Amplify\System\Backend\Models\CustomerAddress;
use Amplify\System\Backend\Models\CustomerPermission;
use Amplify\System\Backend\Models\Event;
use Amplify\System\Backend\Models\Role;
use Amplify\System\Factories\NotificationFactory;
use App\Http\Controllers\Admin\CrudPanel;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Backpack\CRUD\app\Library\Widget;
use Backpack\Pro\Http\Controllers\Operations\FetchOperation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

/**
 * Class ContactCrudController
 *
 * @property-read CrudPanel $crud
 */
class ContactCrudController extends BackpackCustomCrudController
{
    use CreateOperation {
        store as traitStore;
    }
    use DeleteOperation;
    use FetchOperation;
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
        CRUD::setRoute(config('backpack.base.route_prefix').'/contact');
        CRUD::setEntityNameStrings('contact', 'contacts');
    }

    protected function setupCustomRoutes($segment, $routeName, $controller)
    {
        Route::match(['get', 'post'], $segment.'/roles', [
            'as' => $routeName.'.roles',
            'uses' => $controller.'@getRoles',
        ]);

        Route::get($segment.'/{contact}/impersonate', [
            'as' => $routeName.'.impersonate',
            'uses' => $controller.'@setImpersonate',
        ]);

        Route::post($segment.'/assignable-validation', [
            'as' => $routeName.'.assignable-validation',
            'uses' => $controller.'@verifyAssignableContact',
        ]);
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
        // @todo enable this before contact registration request
        // $this->crud->addClause('whereNull', 'enabled_at');

        $this->crud->enableExportButtons();

        $this->crud->addFilter([
            'name' => 'synced_at',
            'type' => 'dropdown',
            'label' => 'Is Synced',
        ],
            function () {
                return [
                    '1' => 'Yes',
                    '0' => 'No',
                ];
            },
            function ($value) {
                if ($value == '1') {
                    $this->crud->addClause('whereNotNull', 'synced_at');
                }

                if ($value == '0') {
                    $this->crud->addClause('whereNull', 'synced_at');
                }
            });

        CRUD::addFilter(
            [
                'name' => 'enabled',
                'type' => 'dropdown',
                'label' => 'Is Enabled',
            ],
            function () {
                return [
                    '1' => 'Yes',
                    '0' => 'No',
                ];
            },
            function ($value) {
                if ($value == '1') {
                    $this->crud->addClause('where', 'enabled', true);
                }

                if ($value == '0') {
                    $this->crud->addClause('where', 'enabled', false);
                }
            }
        );

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

        if (request()->has('role')) {
            [$role_id, $team_id] = explode('-', request('role'));
            set_customer_team_id($team_id);
            $this->crud->addClause('whereHas', 'ownRoles', fn ($q) => $q->id = $role_id);
        }

        $this->crud->modifyButton('create', ['content' => 'crud::buttons.contact-create-old']);

        CRUD::addColumn([
            'name' => 'id',
            'label' => 'ID',
            'type' => 'custom_html',
            'value' => function ($contact) {
                return ($contact->synced_at != null)
                    ? "<span>{$contact->id}</span><sup class='badge text-success px-0 font-weight-bold'>Synced</sup></span>"
                    : "<span>{$contact->id}</span>";
            },

        ]);

        CRUD::addColumn([
            'name' => 'profile_image',
            'label' => 'Image',
            'type' => 'image',
            'width' => '56px',
            'height' => 'auto',
        ]);

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
        CRUD::column('order_limit');

        CRUD::addColumn([
            'name' => 'enabled',
            'label' => 'Enabled',
            'type' => 'boolean',
        ]);

        $this->crud->addClause('approved');
        $this->crud->addButtonFromView('line', 'impersonate', 'impersonate', 'end');

        CRUD::addFilter([
            'name' => 'created_between',
            'type' => 'date_range',
            'label' => 'Created/Registered',
            'date_range_options' => [
                'timePicker' => false,
                'minYear' => now()->subYears(20)->format('Y'),
                'maxYear' => now()->format('Y'),
                'locale' => [
                    'format' => 'DD MMM, YYYY',
                ],
            ],
        ], false, function ($value) {
            $dates = json_decode($value);
            $this->crud->addClause('where', 'created_at', '>=', $dates->from);
            $this->crud->addClause('where', 'created_at', '<=', $dates->to.' 23:59:59');
        });
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     *
     * @return void
     */
    protected function setupCreateOperation()
    {
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
            'name' => 'accountTitle',
            'label' => 'Account Title',
            'tab' => 'Basic',
            'type' => 'relationship',
        ]);

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

        CRUD::addField([
            'name' => 'login_id',
            'label' => 'Login ID',
            'tab' => 'Basic',
            'type' => 'text',
            'attributes' => [
                'autocomplete' => 'off',
                'id' => 'new-account',
            ],
        ]);

        CRUD::field('phone')->type('text')->tab('Basic');

        Crud::addField([
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
            'model' => 'Amplify\System\Backend\Models\CustomerAddress', // the method that defines the relationship in your Model
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

        CRUD::addField([
            'name' => 'password',
            'type' => 'show_hide_password',
            'showButton' => 'true',
            'tab' => 'Basic',
            'attributes' => [
                'autocomplete' => 'off',
                'id' => 'new-password',
            ],
        ]);

        CRUD::field('password_confirmation')->type('show_hide_password')->label('Confirm Password')->tab('Basic');
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
        $this->setupCreateOperation();
    }

    public function store(ContactRequest $request)
    {
        $this->crud->removeFields(['roles', 'contactLogins']);
        $this->crud->setRequest($this->crud->validateRequest());
        $this->crud->unsetValidation();
        $traitRes = $this->traitStore();
        $this->afterCreateUpdateOperation($request);
        $this->crud->entry->updateContactLoginAsPerEntry();

        return $traitRes;
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

            // Trigger the notification
            NotificationFactory::call(Event::CONTACT_ACCOUNT_REQUEST_ACCEPTED, [
                'contact_id' => $contact->id,
            ]);
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

    /**
     * Define what happens when a single raw is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * TODO: $entry->addresses dont have any office_phone_number , office_email
     *
     * @return void
     */
    protected function setupShowOperation()
    {
        CRUD::addColumn([
            'label' => 'Customer', // Table column heading
            'name' => 'customer.customer_name', // the column that contains the I
        ]);

        if (config('amplify.api.contact_detail', false)) {
            CRUD::addColumn([
                'name' => 'contact_code',
                'label' => 'Contact Code',
                'type' => 'text',
            ]);
        }

        CRUD::addColumn([
            'name' => 'profile_image',
            'label' => 'Image',
            'type' => 'image',
            'width' => '128px',
            'height' => 'auto',
        ]);
        CRUD::column('name');
        CRUD::column('email');
        CRUD::column('phone');
        CRUD::addColumn([
            'name' => 'address',
            'label' => 'Address',
            'type' => 'custom_html',
            'value' => function ($entry) {
                $customer_address = $entry->customer_address;
                $str = '<div class="d-grid">';
                if ($customer_address != null) {
                    $str .= '<table class="table table-bordered table-hover table-striped">
                                <tbody>
                                    <tr>
                                        <th>Address Name:</th>
                                        <td>'.($customer_address->address_name ?? '').'</td>
                                    </tr>
                                    <tr>
                                        <th>Line 1:</th>
                                        <td>'.($customer_address->address_1 ?? '').'</td>
                                    </tr>
                                    <tr>
                                        <th>Line 2:</th>
                                        <td>'.($customer_address->address_2 ?? '').'</td>
                                    </tr>
                                    <tr>
                                        <th>Line 3:</th>
                                        <td>'.($customer_address->address_3 ?? '').'</td>
                                    </tr>
                                    <tr>
                                        <th>City:</th>
                                        <td>'.($customer_address->city ?? '').'</td>
                                    </tr>
                                    <tr>
                                        <th>State:</th>
                                        <td>'.($customer_address->state ?? '').'</td>
                                    </tr>
                                    <tr>
                                        <th>Country:</th>
                                        <td>'.($customer_address->country_code ?? '').'</td>
                                    </tr>
                                    <tr>
                                        <th>Zip Code:</th>
                                        <td>'.($customer_address->zip_code ?? '').'</td>
                                    </tr>
                                </tbody>
                             </table>';
                }

                return $str;
            },
        ]);

        CRUD::addColumn([
            'name' => 'login_id',
            'label' => 'Login ID',
            'type' => 'text',
        ]);
        /*CRUD::addColumn([
            'name'  => 'limit_type',
            'label' => 'Limit Type'
        ]);*/
        CRUD::addColumn([
            'name' => 'daily_budget_limit',
            'label' => 'Daily Budget Limit',
        ]);
        CRUD::addColumn([
            'name' => 'order_limit',
            'label' => 'Order Limit',
        ]);
        CRUD::addColumn([
            'name' => 'monthly_budget_limit',
            'label' => 'Monthly Budget Limit',
        ]);
        CRUD::addColumn([
            'name' => 'spend_today',
            'label' => 'Spend Today',
        ]);
        CRUD::addColumn([
            'name' => 'spend_this_month',
            'label' => 'Spend This Month',
        ]);
        CRUD::addColumn([
            'name' => 'warehouse_name',
            'label' => 'Default Warehouse',
            'type' => 'relationship',
            'entity' => 'ownWarehouse',
        ]);
        CRUD::addColumn([
            'name' => 'redirect_route',
            'label' => 'Preferred Page After Login',
            'type' => 'select_from_array',
            'options' => CustomerHelper::redirecteableUrls(),
        ]);
        CRUD::addColumn([
            'name' => 'assigned_customers',
            'label' => 'Assigned Customers',
            'type' => 'model_function',
            'function_name' => 'getAssignedCustomerNames',
        ]);

        CRUD::addColumn([
            'name' => 'activeCustomer.name',
            'label' => 'Current Active Customers',
            'type' => 'relationship',
        ]);

        Widget::add([
            'type' => 'card',
            'wrapper' => ['class' => 'col-12 px-0'], // optional
            'class' => 'card',
            'content' => [
                'header' => '<h5 class="card-title mb-0">Contact Login History</h5>', // optional
                'body' => view('backend::partials.contact-login-history', ['contact' => $this->crud->getModel()->findOrFail($this->crud->getCurrentEntryId())]),
            ],
        ])->to('after_content');

    }

    public function getAddresses(Request $request)
    {
        $form = backpack_form_input();

        $options = CustomerAddress::select('*', DB::raw('CONCAT(address_name," - ",address_code) AS display_name'));

        if (! empty($request->q)) {
            $options->where(function ($query) use ($request) {
                return $query->where('address_name', 'LIKE', "%{$request->q}%")
                    ->orWhere('address_code', 'LIKE', "%{$request->q}%");
            });
        }

        if (! $form['customer_id']) {
            return [];
        }

        if ($form['customer_id']) {
            $options = $options->where('customer_id', $form['customer_id']);
        }

        $results = $options->paginate(20);

        return $results;
    }

    public function getRoles()
    {
        $form = backpack_form_input();

        if (isset($form['customer_id'])) {
            return Role::where('guard_name', 'customer')
                ->where(fn ($q) => $q->whereNull('team_id')->orWhere('team_id', $form['customer_id']))
                ->orderBy('name', 'ASC')
                ->paginate(20);
        }

        return [];
    }

    public function fetchCustomer()
    {
        return $this->fetch([
            'model' => \Amplify\System\Backend\Models\Customer::class,
            'searchable_attributes' => ['customer_name', 'customer_code', 'id', 'email', 'phone'],
            'paginate' => 10, // items to show per page
            'searchOperator' => 'LIKE',
            'query' => fn ($model) => $model
                ->select(
                    'id', 'customer_name', 'customer_code',
                    DB::raw('CONCAT(customer_name," - ",customer_code) AS display_name')
                )
                ->orderBy('customer_name'),
        ]);
    }

    public function fetchAssignableCustomer(Request $request)
    {
        $customerExcluded = [];

        $inputs = backpack_form_input();

        if (isset($inputs['id'])) {
            $currentContactModel = Contact::find($inputs['id']);
            if ($currentContactModel) {
                $customerExcluded = $currentContactModel->contactLogins->pluck('customer_id')->toArray();
            }
        }

        return $this->fetch([
            'model' => \Amplify\System\Backend\Models\Customer::class,
            'searchable_attributes' => ['customer_name', 'customer_code', 'id', 'email', 'phone'],
            'paginate' => 10, // items to show per page
            'searchOperator' => 'LIKE',
            'query' => fn ($model) => $model->where('is_assignable', true)->whereNotIn('id', $customerExcluded),
        ]);
    }

    public function setImpersonate(Contact $contact): RedirectResponse
    {
        Auth::guard(Contact::AUTH_GUARD)->logout();

        // Clear application cache
        Cache::clear();

        Auth::guard(Contact::AUTH_GUARD)->login($contact);

        event(new ContactLoggedIn($contact));

        if (! empty($contact->redirect_route)) {
            return redirect()->intended($contact->redirect_route);
        }

        return redirect()->intended('/');
    }

    public function verifyAssignableContact(Request $request): JsonResponse
    {
        try {
            $contact_email = $request->input('contact_email');
            $customer_id = $request->input('customer_id');

            if (! $customer_id || ! $contact_email) {
                throw new \Exception('Contact Email or Customer Id is missing');
            }

            $customerModel = Customer::find($customer_id);

            if (! $customerModel) {
                throw new \Exception('Invalid Customer ID received from input');
            }

            $warehouses = ErpApi::getWarehouses();

            $customerAddresses = $customerModel->addresses;

            $response = ErpApi::contactValidation([
                'email_address' => $contact_email,
                'customer_number' => $customerModel->customer_code,
            ]);

            $jsonResponse['warehouse_id'] = null;
            $jsonResponse['customer_address_id'] = null;
            $jsonResponse['valid'] = (isset($response->ValidCombination) && $response->ValidCombination == 'Y');
            $jsonResponse['status'] = $jsonResponse['valid'];
            $jsonResponse['message'] = ($jsonResponse['status'])
                ? 'This customer can be assigned to current contact person.'
                : 'This customer can not be assigned to current contact person.';

            if (isset($response->DefaultWarehouse)) {
                $defaultWarehouse = $warehouses->firstWhere('WarehouseNumber', $response->DefaultWarehouse);
                $jsonResponse['warehouse_id'] = ($defaultWarehouse) ? $defaultWarehouse->InternalId : $customerModel->warehouse_id;
            }

            if (isset($response->DefaultShipTo)) {
                $defaultShipTo = $customerAddresses->firstWhere('address_name', $response->DefaultShipTo);

                if (! $defaultShipTo) {
                    $defaultShipTo = $customerAddresses->firstWhere('address_name', $customerModel->shipto_address_code);
                }
                $jsonResponse['customer_address_id'] = $defaultShipTo->id ?? null;
            }

            return response()->json($jsonResponse);

        } catch (\Exception $exception) {
            Log::error($exception);

            return response()->json(['message' => $exception->getMessage(), 'status' => false], 200);
        }
    }
}
