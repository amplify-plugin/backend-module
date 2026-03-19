<?php

namespace Amplify\System\Backend\Http\Controllers\Admin;

use Amplify\ErpApi\Facades\ErpApi;
use Amplify\ErpApi\Jobs\CustomerProfileSyncJob;
use Amplify\ErpApi\Wrappers\Warehouse;
use Amplify\System\Abstracts\BackpackCustomCrudController;
use Amplify\System\Backend\Http\Requests\CustomerRegistrationRequest;
use Amplify\System\Backend\Models\Country;
use Amplify\System\Backend\Models\Customer;
use Amplify\System\Backend\Models\CustomerGroup;
use Amplify\System\Backend\Models\Event;
use Amplify\System\Backend\Models\IndustryClassification;
use Amplify\System\Factories\NotificationFactory;
use Amplify\System\Helpers\UtilityHelper;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\FetchOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanel;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Backpack\CRUD\app\Library\Widget;
use ErrorException;

/**
 * Class CustomerRegistrationCrudController
 *
 * @property-read CrudPanel $crud
 */
class CustomerRegistrationCrudController extends BackpackCustomCrudController
{
    use DeleteOperation {
        destroy as traitDestroy;
    }
    use FetchOperation;
    use ListOperation;
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

        CRUD::addBaseClause('inactive');
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
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     *
     * @return void
     */
    protected function setupUpdateOperation()
    {
        CRUD::setValidation(CustomerRegistrationRequest::class);
        Widget::add()->type('script')->content('vendor/backend/js/forms/customer.js');

        if (! config('amplify.basic.enable_erp_customer_create')) {
            CRUD::field('customer_code')->type('text')->tab('Basic')->label('Company Code');
        }

        $options = [];
        ErpApi::getWarehouses()->each(function (Warehouse $warehouse) use (&$options) {
            $options[$warehouse->InternalId] = "{$warehouse->WarehouseNumber} - {$warehouse->WarehouseName}";
        });
        // BASIC
        CRUD::field('customer_name')->type('text')->tab('Basic')->label('Company Name');
        CRUD::field('email')->type('email')->tab('Basic')->label('Company Email');
        CRUD::field('phone')->type('text')->tab('Basic')->label('Company Phone');
        CRUD::addField([
            'name' => 'punch_out',
            'label' => 'Punch Out',
            'type' => 'boolean',
            'inline' => true,
            'attributes' => ['class' => 'form-check-label mr-3'],
            'options' => [
                0 => 'No',
                1 => 'Yes',
            ],
            'default' => 0,
            'tab' => 'Basic',
        ]);
        CRUD::addField([
            'type' => 'tinymce',
            'name' => 'punch_out_configuration',
            'label' => 'Punch Out Configuration',
            'both',
            'tab' => 'Basic',
        ]);

        $countries = Country::enabled()->get()->pluck('name', 'iso2')->toArray();
        CRUD::addFields([
            [
                'name' => 'address_1',
                'type' => 'text',
                'label' => 'Address Line 1',
                'tab' => 'Basic',
                'allows_null' => false,
            ],
            [
                'name' => 'address_2',
                'type' => 'text',
                'label' => 'Address Line 2',
                'tab' => 'Basic',
            ],
            [
                'name' => 'address_3',
                'type' => 'text',
                'label' => 'Address Line 3',
                'tab' => 'Basic',
            ],
            [
                'name' => 'city',
                'type' => 'text',
                'label' => 'City',
                'tab' => 'Basic',
                'wrapper' => [
                    'class' => 'form-group col-md-6',
                ],
            ],
            [
                'name' => 'state',
                'type' => 'text',
                'label' => 'State',
                'tab' => 'Basic',
                'wrapper' => [
                    'class' => 'form-group col-md-6',
                ],
            ],
            [
                'name' => 'country_code',
                'type' => 'select2_from_array',
                'options' => $countries,
                'label' => 'Country',
                'tab' => 'Basic',
                'wrapper' => [
                    'class' => 'form-group col-md-6',
                ],
            ],
            [
                'name' => 'zip_code',
                'type' => 'text',
                'label' => 'Zip Code',
                'tab' => 'Basic',
                'wrapper' => [
                    'class' => 'form-group col-md-6',
                ],
            ],
        ]);

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
            'model' => CustomerGroup::class,
            'attribute' => 'group_name',
            'ajax' => true,
            'tab' => 'Basic',
            'placeholder' => 'Select a customer group',
            'options' => (fn ($query) => $query->orderBy('group_name')->get()),
        ]);
        CRUD::addField([
            'name' => 'warehouse_seq_code',
            'label' => 'Warehouse seq code',
            'type' => 'text',
            'tab' => 'Basic',
            'attributes' => [
                'autocomplete' => 'false',
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
            'options' => (fn ($query) => $query->orderBy('name')->get()),
        ]);

        CRUD::field('free_shipment_amount')->type('number')->tab('Basic');
        CRUD::field('is_suspended')->type('boolean')->tab('Basic');

        // ADMIN
        CRUD::addField([
            'name' => 'contact',
            'type' => 'relationship',
            'label' => 'Admin (Role) User / Contact',
            'tab' => 'Admin',
            'subfields' => [
                [
                    'name' => 'enabled',
                    'type' => 'hidden',
                    'label' => 'Enabled',
                    'value' => 1,
                ], [
                    'name' => 'otp',
                    'type' => 'hidden',
                    'label' => 'OTP',
                    'value' => null,
                ],
                [
                    'name' => 'enabled_at',
                    'type' => 'hidden',
                    'label' => 'Enabled at',
                    'value' => now()->format('Y-m-d H:i:s'),
                ],
                [
                    'name' => 'name',
                    'type' => 'text',
                    'label' => 'Admin Contact Name',
                    'allows_null' => false,
                ],
                [
                    'type' => 'hidden',
                    'name' => 'is_admin',
                    'value' => true,
                ],
                [
                    'name' => 'contact_code',
                    'type' => (config('amplify.api.contact_detail', false))
                        ? 'text'
                        : 'hidden',
                    'label' => 'Contact ID',
                    'allows_null' => true,
                ],
                [
                    'name' => 'login_id',
                    'type' => (config('amplify.api.contact_detail', false))
                        ? 'text'
                        : 'hidden',
                    'label' => 'Login ID',
                    'allows_null' => true,
                ],
                [
                    'name' => 'email',
                    'type' => 'email',
                    'label' => 'Admin Contact Email',
                ],
                [
                    'name' => 'phone',
                    'type' => 'text',
                    'label' => 'Admin Contact Phone',
                ],
                [
                    'name' => 'warehouse',
                    'type' => 'relationship',
                    'label' => 'Default Warehouse',
                    'entity' => 'ownWarehouse',
                    'options' => (fn ($query) => $query->orderBy('name')->get()),
                ],
                [
                    'name' => 'password',
                    'type' => 'show_hide_password',
                    'label' => 'Password',
                ],
                [
                    'name' => 'password_confirmation',
                    'type' => 'show_hide_password',
                    'label' => 'Confirm Password',
                    'fake' => true,
                ],
                [
                    'name' => 'profile_image',
                    'label' => 'Profile Image',
                    'type' => 'upload',
                    'upload' => true,
                    'withFiles' => true,
                ],
                [
                    'name' => 'order_limit',
                    'type' => 'number',
                    'label' => 'Order Limit',
                    'default' => 0,
                    'attributes' => [
                        'step' => '0.01',
                        'min' => 0,
                    ],
                ],
                [
                    'name' => 'daily_budget_limit',
                    'type' => 'number',
                    'label' => 'Daily Budget Limit',
                    'default' => 0,
                    'attributes' => [
                        'step' => '0.01',
                        'min' => 0,
                    ],
                ],
                [
                    'name' => 'monthly_budget_limit',
                    'type' => 'number',
                    'label' => 'Monthly Budget Limit',
                    'default' => 0,
                    'attributes' => [
                        'step' => '0.01',
                        'min' => 0,
                    ],
                ],
                [
                    'name' => 'spend_today',
                    'type' => 'number',
                    'label' => 'Spend Today',
                    'default' => 0,
                    'attributes' => [
                        'step' => '0.01',
                        'min' => 0,
                    ],
                ],
                [
                    'name' => 'spend_this_month',
                    'type' => 'number',
                    'label' => 'Monthly Spend',
                    'default' => 0,
                    'attributes' => [
                        'step' => '0.01',
                        'min' => 0,
                    ],
                ],
            ],
        ]);
        CRUD::addField([
            'name' => 'ar_number',
            'label' => 'AR Number',
            'tab' => 'ERP Information',
        ]);
        CRUD::addField([
            'name' => 'class',
            'label' => 'Customer Class',
            'tab' => 'ERP Information',
        ]);
        CRUD::addField([
            'name' => 'default_currency',
            'label' => 'Default Currency',
            'type' => 'select2_from_array',
            'options' => UtilityHelper::currencyDropdown(),
            'allows_null' => false,
            'tab' => 'ERP Information',
        ]);

        CRUD::addField([
            'name' => 'list_price',
            'label' => 'Default List Price (Your Price)',
            'type' => 'select_from_array',
            'options' => Customer::LIST_PRICES,
            'allows_null' => true,
            'tab' => 'ERP Information',
        ]);
        CRUD::addField([
            'name' => 'shipto_address_code',
            'label' => 'Default Ship to Address Code',
            'tab' => 'ERP Information',
        ]);
        CRUD::addField([
            'name' => 'suspend_code',
            'label' => 'Suspend Code',
            'type' => 'text',
            'tab' => 'ERP Information',
        ]);
        CRUD::addField([
            'type' => 'select2_from_array',
            'label' => 'Default Warehouse Code',
            'name' => 'warehouse_id',
            'options' => $options,
            'tab' => 'ERP Information',

        ]);
        CRUD::addField([
            'name' => 'carrier_code',
            'label' => 'Carrier Code',
            'type' => 'text',
            'tab' => 'ERP Information',
        ]);
        CRUD::addField([
            'name' => 'business_contact',
            'label' => 'Business Contact',
            'type' => 'email',
            'tab' => 'ERP Information',
        ]);
        CRUD::addField([
            'name' => 'own_truck_ship_charge',
            'label' => 'Own Truck Ship Charge',
            'type' => 'number',
            'tab' => 'ERP Information',
        ]);
        CRUD::addField([
            'name' => 'customer_po_required',
            'label' => 'PO Required',
            'type' => 'boolean',
            'tab' => 'ERP Information',
        ]);
        CRUD::addField([
            'name' => 'allow_backorder',
            'label' => 'Allow Backorder',
            'type' => 'boolean',
            'tab' => 'ERP Information',
        ]);
        CRUD::addField([
            'name' => 'credit_card_only',
            'label' => 'Credit Card Only',
            'type' => 'boolean',
            'tab' => 'ERP Information',
        ]);
        CRUD::addField([
            'name' => 'is_assignable',
            'label' => 'Allow Assign contact from other customer',
            'type' => 'boolean',
            'tab' => 'ERP Information',
        ]);
    }

    /**
     * This function overrides the default update function of backpack for this CustomerCrud
     */
    public function update()
    {
        /**
         * @var $request  CustomerRegistrationRequest
         */
        $request = $this->crud->getRequest();

        try {

            if (config('amplify.erp.auto_create_cash_customer')) {
                $industryClassification = IndustryClassification::find($request->input('industry_classification_id'));

                $erpCus = ErpApi::createCustomer([
                    'template_customer_number' => config('amplify.frontend.guest_default'),
                    'email_address' => $request->input('email'),
                    'phone_number' => $request->input('phone'),
                    'customer_name' => $request->input('customer_name'),
                    'contact' => null,
                    'address_1' => $request->input('address_1'),
                    'address_2' => $request->input('address_2'),
                    'address_3' => $request->input('address_3'),
                    'city' => $request->input('city'),
                    'state' => $request->input('state'),
                    'zip_code' => $request->input('zip_code'),
                    'country_code' => $request->input('country_code'),
                    'branch' => null,
                    'customer_industry' => $industryClassification?->name,
                ]);

                if (! empty($erpCus->Message)) {
                    throw new ErrorException('Customer Approval fFiled. Error: '.$erpCus->Message);
                }

                if ($erpCus->CustomerNumber == null) {
                    throw new ErrorException('Customer Approval fFiled. Error: '.$erpCus->Message);
                }

                $request->offsetSet('customer_code', $erpCus->CustomerNumber);

                $this->crud->setRequest($request);
            }
        } catch (ErrorException $e) {

            \Alert::error($e->getMessage());

            return redirect()->back();
        }

        $response = $this->traitUpdate();

        $customer = $this->crud->getCurrentEntry();

        CustomerProfileSyncJob::dispatch([
            'customer_id' => $this->crud->getCurrentEntryId(),
        ]);

        NotificationFactory::call(Event::REGISTRATION_REQUEST_ACCEPTED, [
            'contact_id' => $customer->contact->getKey(), 'customer_id' => $customer->getKey(),
        ]);

        return $response;
    }

    protected function fetchCustomerGroup()
    {
        return $this->fetch(CustomerGroup::class);
    }
}
