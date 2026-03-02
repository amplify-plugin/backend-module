<?php

namespace Amplify\System\Backend\Http\Controllers\Admin;

use Amplify\ErpApi\Facades\ErpApi;
use Amplify\ErpApi\Jobs\CustomerProfileSyncJob;
use Amplify\System\Abstracts\BackpackCustomCrudController;
use Amplify\System\Backend\Http\Requests\CustomerRegistrationRequest;
use Amplify\System\Backend\Models\Contact;
use Amplify\System\Backend\Models\Customer;
use Amplify\System\Backend\Models\CustomerAddress;
use Amplify\System\Backend\Models\CustomerGroup;
use Amplify\System\Backend\Models\Event;
use Amplify\System\Factories\NotificationFactory;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanel;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Prologue\Alerts\Facades\Alert;

/**
 * Class CustomerRegistrationCrudController
 *
 * @property-read CrudPanel $crud
 */
class CustomerRegistrationCrudController extends BackpackCustomCrudController
{
    use CreateOperation {
        store as traitStore;
    }
    use DeleteOperation {
        destroy as traitDestroy;
    }
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
        CRUD::setModel(Customer::class);
        CRUD::setRoute(config('backpack.base.route_prefix').'/customer-registration');
        CRUD::setEntityNameStrings('customer-registration', 'registration requests');

        CRUD::addClause('inactive');
        CRUD::denyAccess('create');
    }

    protected function setupCustomRoutes($segment, $routeName, $controller)
    {
        Route::post($segment.'/fetch/customer_group', [
            'uses' => $controller.'@fetchCustomerGroup',
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
        CRUD::addColumn([
            'name' => 'id',
            'label' => '#',
        ]);
        CRUD::addColumns([
            [
                'name' => 'customer_code',
                'label' => 'Customer Code',
            ],
            [
                'name' => 'customer_name',
                'label' => 'Customer Name',
            ],
            [
                'name' => 'email',
                'label' => 'Email',
            ],
            [
                'name' => 'phone',
                'label' => 'Phone',
            ],
            [
                'name' => 'phone',
                'label' => 'Phone',
            ], [
                'name' => 'punch_out',
                'label' => 'Punch Out',
                'type' => 'boolean',
            ],
            [
                'name' => 'customer_type',
                'label' => 'Customer Type',
            ],
            [
                'name' => 'created_at',
                'label' => 'Applied At',
                'type' => 'datetime',
            ],
        ]);

        $this->crud->removeButton('show');
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
        CRUD::setValidation(CustomerRegistrationRequest::class);
        CRUD::field('customer_code')->type('text')->tab('Basic')->label('Customer Code');
        CRUD::field('customer_name')->type('text')->tab('Basic')->label('Customer Name');
        CRUD::field('email')->type('email')->tab('Basic');
        CRUD::field('phone')->type('text')->tab('Basic');

        CRUD::addField(
            [
                'name' => 'punch_out',
                'label' => 'Punch Out',
                'type' => 'boolean',
                'inline' => true,
                'attributes' => ['class' => 'form-check-label mr-3'],
                'options' => [
                    0 => 'No',
                    1 => 'Yes',
                ],
                'hide_when' => [
                    0 => ['punch_out_configuration'],
                ],
                'default' => 0,
                'tab' => 'Basic',
            ]
        );
        CRUD::addField([
            'type' => 'tinymce',
            'name' => 'punch_out_configuration',
            'label' => 'Punch Out Configuration',
            'both',
            'tab' => 'Basic',
        ]);

        CRUD::field('Customer Address')->type('customer_address')->tab('Basic');

        CRUD::addField([
            'name' => 'approved',
            'type' => 'hidden',
            'value' => 1,
        ]);

        CRUD::field('customer_type')->type('enum')->tab('Basic')->label('Customer Type');

        CRUD::addField([
            'label' => 'Customer Group',
            'name' => 'customer_group_id',
            'type' => 'select2',
            'entity' => 'customer_group',
            'model' => "Amplify\System\Backend\Models\CustomerGroup",
            'attribute' => 'group_name',
            'ajax' => true,
            'tab' => 'Basic',
            'placeholder' => 'Select a customer group',
        ]);
        CRUD::addField([
            'name' => 'warehouse_seq_code',
            'label' => 'Warehouse seq code',
            'type' => 'text',
            'tab' => 'Basic',
            'attributes' => [
                'autocomplete' => 'off',
            ],
        ]);
        CRUD::addField([
            'label' => 'Industry Classification',
            'name' => 'industry_classification_id',
            'type' => 'select2',
            'entity' => 'IndustryClassification',
            'model' => "Amplify\System\Backend\Models\IndustryClassification",
            'attribute' => 'name',
            'tab' => 'Basic',
            'placeholder' => 'Select a industry classification',
        ]);

        CRUD::field('is_suspended')->type('boolean')->tab('Basic');

        /*
         * Admin
         */
        CRUD::addField([
            'name' => 'contact.name',
            'label' => 'Name',
            'tab' => 'Admin',
            'type' => 'text',
        ]);
        CRUD::addField([
            'name' => 'contact.email',
            'label' => 'Email',
            'tab' => 'Admin',
            'type' => 'text',
        ]);
        CRUD::addField([
            'name' => 'contact.phone',
            'label' => 'Phone',
            'tab' => 'Admin',
            'type' => 'text',
        ]);

        // TODO Show Password
        CRUD::addField([
            'name' => 'contact.password',
            'label' => 'Password',
            'showButton' => 'true',
            'type' => 'show_hide_password',
            'tab' => 'Admin',
            'attributes' => [
                'autoComplete' => 'off',
            ],
        ]);
        CRUD::addField([
            'name' => 'contact.password_confirmation',
            'label' => 'Confirm Password',
            'type' => 'password',
            'tab' => 'Admin',
        ]);
        CRUD::field('show_password')->type('show_hide_password')->label('["Show", "Hide"]')->tab('Admin');

        CRUD::addField([
            'name' => 'contact.is_admin',
            'label' => 'Is Admin',
            'type' => 'boolean',
            'tab' => 'Admin',
            'default' => '1',
            'attributes' => ['readonly' => 'readonly', 'disabled' => 'disabled'],
        ]);
        CRUD::addField([
            'name' => 'contact.order_limit',
            'label' => 'Order Limit',
            'type' => 'number',
            'attributes' => ['step' => 'any'],
            'tab' => 'Admin',
        ]);
        CRUD::addField([
            'name' => 'contact.daily_budget_limit',
            'label' => 'Daily Budget Limit',
            'type' => 'number',
            'attributes' => ['step' => 'any'],
            'tab' => 'Admin',
        ]);
        CRUD::addField([
            'name' => 'contact.monthly_budget_limit',
            'label' => 'Monthly Budget Limit',
            'type' => 'number',
            'attributes' => ['step' => 'any'],
            'tab' => 'Admin',
        ]);

        // Fields of ERP Information tab
        CRUD::addField([
            'name' => 'ar_number',
            'label' => 'Customer AR Number',
            'tab' => 'ERP Information',
        ]);
        CRUD::addField([
            'name' => 'class',
            'label' => 'Customer Class',
            'tab' => 'ERP Information',
        ]);

        CRUD::addField([
            'name' => 'default_currency',
            'label' => 'Customer Default Currency',
            'type' => 'select2_from_array',
            'options' => \Amplify\System\Helpers\UtilityHelper::currencyDropdown(),
            'allows_null' => false,
            'tab' => 'ERP Information',
        ]);
        CRUD::addField([
            'name' => 'shipto_address_code',
            'label' => 'Customer Default Shipto Address Code',
            'tab' => 'ERP Information',
        ]);
        CRUD::addField([
            'name' => 'suspend_code',
            'label' => 'Customer Suspend Code',
            'tab' => 'ERP Information',
        ]);

        // TODO handle data from API as well important
        $options = [];

        \ErpApi::getWarehouses()->each(function (\Amplify\ErpApi\Wrappers\Warehouse $warehouse) use (&$options) {
            $options[$warehouse->InternalId] = "{$warehouse->WarehouseNumber} - {$warehouse->WarehouseName}";
        });

        CRUD::addField([
            'type' => 'select2_from_array',
            'label' => 'Default Warehouse Code',
            'name' => 'warehouse_id',
            'options' => $options,
            'tab' => 'ERP Information',

        ]);
        CRUD::addField([
            'name' => 'carrier_code',
            'label' => 'Customer Carrier Code',
            'tab' => 'ERP Information',
        ]);
        CRUD::addField([
            'name' => 'business_contact',
            'label' => 'Customer Business Contact',
            'tab' => 'ERP Information',
        ]);
        CRUD::addField([
            'name' => 'customer_po_required',
            'label' => 'Customer PO Required',
            'type' => 'boolean',
            'tab' => 'ERP Information',
        ]);
        CRUD::addField([
            'name' => 'allow_backorder',
            'label' => 'Customer Allow Backorder',
            'type' => 'boolean',
            'tab' => 'ERP Information',
        ]);
    }

    /**
     * This function overrides the default store function of CustomerCrudController provided by backpack
     *
     * @return RedirectResponse
     *
     * @throws \Throwable
     */
    public function store(CustomerRegistrationRequest $request)
    {
        DB::beginTransaction();

        try {
            $addresses = $this->formattedCustomerAddress($request->address);

            $customer = Customer::create(
                $request->only(
                    'customer_code',
                    'customer_name',
                    'phone',
                    'email',
                    'punch_out',
                    'punch_out_configuration',
                    'customer_type',
                    'customer_group_id',
                    'industry_classification_id',
                    'approved',
                    'web_order_number',
                    'is_suspended',
                    'warehouse_seq_code',
                    'ar_number',
                    'class',
                    'default_currency',
                    'shipto_address_code',
                    'suspend_code',
                    'warehouse_id',
                    'allow_backorder',
                    'carrier_code',
                    'business_contact',
                    'customer_po_required',
                    'address_1',
                    'address_2',
                    'address_3',
                    'city',
                    'state',
                    'zip_code',
                    'country_code',
                )
            );

            $customer->addresses()->saveMany($addresses);

            Contact::create([
                'name' => $request->contact['name'],
                'phone' => $request->contact['phone'],
                'password' => $request->contact['password'],
                'email' => $request->contact['email'],
                'customer_id' => $customer->id,
                'customer_address_id' => $customer->addresses->first()->id ?? null,
                'is_admin' => $request->contact['is_admin'],
                'order_limit' => $request->contact['order_limit'] ?? 0,
                'daily_budget_limit' => $request->contact['daily_budget_limit'] ?? 0,
                'monthly_budget_limit' => $request->contact['monthly_budget_limit'] ?? 0,
            ]);

            DB::commit();

            Alert::success(trans('backpack::crud.insert_success'))->flash();
        } catch (\Exception $exception) {
            Log::error('Customer Create Exception: '.$exception->getMessage());
            DB::rollBack();
            Alert::success(trans('crud.insert_failed', ['item' => 'Customer']))->flash();
        }

        return redirect(backpack_url('/customer'));
    }

    /**
     * This function returns the array in such a way that it can match the structure of the customer_addresses table
     *
     * @return array
     */
    public function formattedCustomerAddress($addresses)
    {
        $formattedAddress = [];

        array_walk($addresses, function ($address) use (&$formattedAddress) {
            $formattedAddress[] = new CustomerAddress([
                'address_name' => ($address['address_name'] ?? null),
                'address_1' => $address['address_1'] ?? null,
                'address_2' => $address['address_2'] ?? null,
                'address_3' => $address['address_3'] ?? null,
                'zip_code' => $address['zip_code'] ?? null,
                'city' => $address['city'] ?? null,
                'country_code' => $address['country_code'] ?? null,
                'state' => $address['state'] ?? null,
            ]);
        });

        return $formattedAddress;
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
        CRUD::setValidation(CustomerRegistrationRequest::class);

        if (! config('amplify.basic.enable_erp_customer_create')) {
            CRUD::field('customer_code')->type('text')->tab('Basic');
        }

        CRUD::field('customer_name')->type('text')->tab('Basic');
        CRUD::field('email')->type('email')->tab('Basic');
        CRUD::field('phone')->type('text')->tab('Basic');
        $this->crud->addField(
            [
                'name' => 'punch_out',
                'label' => 'Punch Out',
                'type' => 'toggle',
                'inline' => true,
                'attributes' => ['class' => 'form-check-label mr-3'],
                'options' => [
                    0 => 'No',
                    1 => 'Yes',
                ],
                'hide_when' => [
                    0 => ['punch_out_configuration'],
                ],
                'default' => 0,
                'tab' => 'Basic',
            ]
        );
        $this->crud->addField([
            'type' => 'tinymce',
            'name' => 'punch_out_configuration',
            'both',
            'tab' => 'Basic',
        ]);

        // Here we retrive the addresses of this customer using the eloquent relation defined in the model.

        CRUD::field('Customer Address')->type('customer_address')->tab('Basic');

        CRUD::field('customer_type')->type('enum')->tab('Basic');

        $contact = $this->crud->getCurrentEntry();
        /*
         * Admin
         */
        CRUD::addField([
            'name' => 'contact.name',
            'label' => 'Name',
            'tab' => 'Admin',
            'type' => 'text',
            'default' => $contact->name,
        ]);
        CRUD::addField([
            'name' => 'contact.email',
            'label' => 'Email',
            'tab' => 'Admin',
            'type' => 'text',
            'default' => $contact->phone,
        ]);
        CRUD::addField([
            'name' => 'contact.phone',
            'label' => 'Phone',
            'tab' => 'Admin',
            'type' => 'text',
            'default' => $contact->email,
        ]);
        $addresses = $contact->addresses->keyBy('id')->map(function ($item) {
            return $item['address_name'];
        })->toArray();

        CRUD::addField([
            'name' => 'customer_address_id',
            'label' => 'Address',
            'type' => 'select2_from_array',
            'options' => $addresses,
            'allows_null' => false,
            'tab' => 'Admin',
        ]);

        $contactId = optional($this->crud->entry->contact)->login_id;

        if (empty($contactId)) {
            $loginIdInput = "<div class='form-group col-sm-12 required px-0' element='div'>    <label>Login Id</label>
                                <input type='text' name='contact[login_id]' value='' class='form-control'>
                            </div>";

            CRUD::addField([
                'name' => 'contact.login_id',
                'type' => 'custom_html',
                'value' => $loginIdInput,
                'tab' => 'Admin',
            ]);
        } else {
            CRUD::addField([
                'name' => 'contact.login_id',
                'label' => 'Login ID',
                'type' => 'text',
                'tab' => 'Admin',
                // 'attributes' => ['readonly' => 'readonly'],
                'default' => $contact->login_id,
            ]);
        }

        CRUD::addField([
            'name' => 'contact.password',
            'label' => 'Password',
            'showButton' => 'true',
            'type' => 'custom.password',
            'tab' => 'Admin',
        ]);
        CRUD::addField([
            'name' => 'contact.password_confirmation',
            'label' => 'Confirm Password',
            'type' => 'password',
            'tab' => 'Admin',
        ]);
        CRUD::field('show_password')->type('custom.show_password')->label('["Show", "Hide"]')->tab('Admin');
        CRUD::addField([
            'name' => 'contact.is_admin',
            'label' => 'Is Admin',
            'type' => 'boolean',
            'tab' => 'Admin',
            'default' => $contact->is_admin,
            'attributes' => ['readonly' => 'readonly', 'disabled' => 'disabled'],
        ]);
        CRUD::addField([
            'name' => 'contact.order_limit',
            'label' => 'Order Limit',
            'type' => 'number',
            'attributes' => ['step' => 'any'],
            'tab' => 'Admin',
            'default' => $contact->order_limit,
        ]);
        CRUD::addField([
            'name' => 'contact.daily_budget_limit',
            'label' => 'Daily Budget Limit',
            'type' => 'number',
            'attributes' => ['step' => 'any'],
            'tab' => 'Admin',
            'default' => $contact->daily_budget_limit,
        ]);
        CRUD::addField([
            'name' => 'contact.monthly_budget_limit',
            'label' => 'Monthly Budget Limit',
            'type' => 'number',
            'attributes' => ['step' => 'any'],
            'tab' => 'Admin',
            'default' => $contact->monthly_budget_limit,
        ]);

        // Fields of ERP Information tab
        CRUD::addField([
            'name' => 'ar_number',
            'label' => 'Customer AR Number',
            'tab' => 'ERP Information',
        ]);
        CRUD::addField([
            'name' => 'class',
            'label' => 'Customer Class',
            'tab' => 'ERP Information',
        ]);

        CRUD::addField([
            'name' => 'default_currency',
            'label' => 'Customer Default Currency',
            'type' => 'select2_from_array',
            'options' => \Amplify\System\Helpers\UtilityHelper::currencyDropdown(),
            'allows_null' => false,
            'tab' => 'ERP Information',
        ]);
        CRUD::addField([
            'name' => 'shipto_address_code',
            'label' => 'Customer Default Shipto Address Code',
            'tab' => 'ERP Information',
        ]);
        CRUD::addField([
            'name' => 'suspend_code',
            'label' => 'Customer Suspend Code',
            'tab' => 'ERP Information',
        ]);
        CRUD::addField([
            'type' => 'select2',
            'label' => 'Default Warehouse Code',
            'name' => 'warehouse_id',
            'entity' => 'warehouse',
            'model' => "Amplify\System\Backend\Models\Warehouse",
            'attribute' => 'code',
            'tab' => 'ERP Information',
        ]);
        CRUD::addField([
            'name' => 'carrier_code',
            'label' => 'Customer Carrier Code',
            'tab' => 'ERP Information',
        ]);
        CRUD::addField([
            'name' => 'business_contact',
            'label' => 'Customer Business Contact',
            'tab' => 'ERP Information',
        ]);
        CRUD::addField([
            'name' => 'customer_po_required',
            'label' => 'Customer PO Required',
            'type' => 'boolean',
            'tab' => 'ERP Information',
        ]);
        CRUD::addField([
            'name' => 'allow_backorder',
            'label' => 'Customer Allow Backorder',
            'type' => 'boolean',
            'tab' => 'ERP Information',
        ]);

        $this->setupCreateOperation();
    }

    /**
     * This function overrides the default update function of backpack for this CustomerCrud
     */
    public function update(CustomerRegistrationRequest $request)
    {

        try {
            $customer = Customer::find($request->id);
            $customer->addresses()->delete();
            $addresses = $this->formattedCustomerAddress($request->address);
            $customer->addresses()->saveMany($addresses);
            $customerAddress = CustomerAddress::where('customer_id', $customer->id)->first();

            $newContactDetails = [
                'customer_id' => $customer->id,
                'name' => $request->contact['name'],
                'phone' => $request->contact['phone'],
                'login_id' => $request->contact['login_id'],
                'customer_address_id' => $customerAddress->id,
                'order_limit' => $request->contact['order_limit'] ?? 0,
                'daily_budget_limit' => $request->contact['daily_budget_limit'] ?? 0,
                'monthly_budget_limit' => $request->contact['monthly_budget_limit'] ?? 0,
                'email' => $request->contact['email'],
            ];

            if ($request->contact['password']) {
                $newContactDetails['password'] = $request->contact['password'];
            }
            $customer->contact()->update($newContactDetails);

            $customer_code = $request->input('customer_code', null);
            if (config('amplify.basic.enable_erp_customer_create')) {
                $erpCus = ErpApi::createCustomer([
                    'template_customer_number' => config('amplify.frontend.guest_default'),
                    'email_address' => $request->email,
                    'phone_number' => $request->phone,
                    'customer_name' => $request->customer_name,
                    'contact' => null,
                    'address_1' => $customerAddress->address_1,
                    'address_2' => $customerAddress->address_2,
                    'address_3' => $customerAddress->address_3,
                    'city' => $customerAddress->city,
                    'state' => $customerAddress->state,
                    'zip_code' => $customerAddress->zip_code,
                    'branch' => null,
                    'customer_industry' => $customer->industryClassification?->name,
                ]);

                if ($erpCus->CustomerNumber == null) {
                    $this->cusCreateError('Unable to update Customer Data', 'Can not appvored customer : '.$customer->id);

                    return redirect()->back();
                }

                $customer_code = $erpCus->CustomerNumber;
            }

            $customer->update(
                $request->only(
                    'customer_name',
                    'phone',
                    'email',
                    'punch_out',
                    'punch_out_configuration',
                    'customer_type',
                    'customer_group_id',
                    'industry_classification_id',
                    'approved',
                    'is_suspended',
                    'warehouse_seq_code',
                    'ar_number',
                    'class',
                    'default_currency',
                    'shipto_address_code',
                    'suspend_code',
                    'warehouse_id',
                    'allow_backorder',
                    'carrier_code',
                    'business_contact',
                    'customer_po_required',
                    'address_1',
                    'address_2',
                    'address_3',
                    'city',
                    'state',
                    'zip_code',
                    'country_code',
                ) + [
                    'customer_code' => $customer_code,
                ]
            );

            $contact = $customer->contact;

            if ($contact) {
                $contact->update(['enabled' => true, 'enabled_at' => now(), 'otp' => null]);
            }

            CustomerProfileSyncJob::dispatch(['customer_id' => $customer->id]);

            NotificationFactory::call(Event::REGISTRATION_REQUEST_RECEIVED, [
                'contact_id' => $contact->id, 'customer_id' => $customer->id,
            ]);

            Alert::success(trans('backpack::crud.insert_success'))->flash();

            return redirect(backpack_url('/customer'));
        } catch (\Exception $exception) {

            $this->cusCreateError('Unable to update Customer Data', $exception);

            return redirect()->back();
        }
    }

    private function cusCreateError($message, $exception)
    {
        Log::error($exception);
        Alert::error($message)->flash();
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
        CRUD::column('customer_code');
        CRUD::column('customer_name');
        CRUD::column('email');
        CRUD::column('phone');
        CRUD::column('punch_out')->type('boolean');
        CRUD::column('customer_type');
        CRUD::addColumn([
            'name' => 'address',
            'type' => 'custom_html',
            'value' => function ($entry) {
                $str = '<div class="d-grid">';
                foreach ($entry->addresses as $field => $value) {
                    $str .= '<strong>Address '.++$field.':</strong>';
                    $str .= '<table class="table table-sm table-striped mb-0 table-bordered">
                                <tr class="array-row">
                                    <th style="font-weight: 600!important;">Address Name</th>
                                    <td>'.($value->address_name ?? '').'</td>
                                </tr>
                                 <tr class="array-row">
                                    <th style="font-weight: 600!important;">Address Details</th>
                                    <td>'.($value->address ?? '').'</td>
                                </tr>
                                 <tr class="array-row">
                                    <th style="font-weight: 600!important;">Zip Code</th>
                                    <td>'.($value->zip_code ?? '').'</td>
                                </tr>
                                 <tr class="array-row">
                                    <th style="font-weight: 600!important;">Office Phone Number</th>
                                    <td>'.($value->office_phone_number ?? '').'</td>
                                </tr>
                                 <tr class="array-row">
                                    <th style="font-weight: 600!important;">Office Email</th>
                                    <td>'.($value->office_email ?? '').'</td>
                                </tr>';
                    $str .= '</table>';
                }
                $str .= '</div>';

                return $str;
            },
        ]);
    }

    public function destroy($id)
    {
        $this->crud->hasAccessOrFail('delete');

        $this->crud->getCurrentEntry()->contacts()->delete();

        $this->crud->getCurrentEntry()->addresses()->delete();

        $id = $this->crud->getCurrentEntryId() ?? $id;

        return $this->crud->delete($id);
    }

    public function fetchCustomerGroup()
    {
        return CustomerGroup::where('group_name', 'like', '%'.\request()->q.'%')->get();
    }

    /*public function store(CustomerRegistrationRequest $request)
    {
        return $request->all();
        $customer = new Customer();
        $customer->fill($request->all());
        $customer->save();
        $contact = new \Amplify\System\Backend\Models\Contact();
        $contact->fill($request->all());
        $contact->customer_id = $customer->id;
        $contact->save();
    }*/
}
