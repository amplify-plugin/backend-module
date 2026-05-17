<?php

namespace Amplify\System\Backend\Http\Controllers\Admin;

use Amplify\ErpApi\Facades\ErpApi;
use Amplify\ErpApi\Jobs\CustomerProfileSyncJob;
use Amplify\ErpApi\Wrappers\Warehouse;
use Amplify\System\Abstracts\BackpackCustomCrudController;
use Amplify\System\Backend\Http\Requests\CustomerRequest;
use Amplify\System\Backend\Models\Country;
use Amplify\System\Backend\Models\Customer;
use Amplify\System\Backend\Models\CustomerGroup;
use Amplify\System\Backend\Models\IndustryClassification;
use Amplify\System\Helpers\UtilityHelper;
use Backpack\CRUD\app\Exceptions\BackpackProRequiredException;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use \Backpack\Pro\Http\Controllers\Operations\FetchOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanel;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Backpack\CRUD\app\Library\Widget;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException;

/**
 * Class CustomerCrudController
 *
 * @property-read CrudPanel $crud
 */
class CustomerCrudController extends BackpackCustomCrudController
{
    use CreateOperation {
        store as traitStore;
    }
    use DeleteOperation;
    use FetchOperation;
    use ListOperation;
    use ShowOperation;
    use UpdateOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     *
     * @throws \Exception
     */
    public function setup()
    {
        CRUD::setModel(Customer::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/customer');
        CRUD::setEntityNameStrings('customer', 'customers');
        CRUD::addBaseClause('active');
    }

    protected function setupCustomRoutes($segment, $routeName, $controller)
    {
        Route::post($segment . '/bulk-profile-sync', [
            'as' => $routeName . '.bulk-profile-sync',
            'uses' => $controller . '@bulkProfileSync',
            'operation' => 'erp-bulk-sync',
        ]);
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     *
     * @return void
     *
     * @throws BackpackProRequiredException
     */
    protected function setupListOperation()
    {
        $this->crud->enableExportButtons();

        if (backpack_user()->can($this->crud->entity_name . '.erp-bulk-sync')) {
            $this->crud->enableBulkActions();
            $this->crud->addButton('top', 'bulk_erp_sync', 'view', 'backend::buttons.bulk_erp_sync');
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
        }

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
            $this->crud->addClause('where', 'created_at', '<=', $dates->to . ' 23:59:59');
        });

        CRUD::addColumn([
            'name' => 'id',
            'label' => 'ID',
            'type' => 'custom_html',
            'value' => function ($customer) {
                if (backpack_user()->can($this->crud->entity_name . '.erp-bulk-sync')) {
                    return "<span>{$customer->id} "
                        . (($customer->synced_at != null) ? "<sup class='badge text-success px-0 font-weight-bold'>Synced</sup>" : '')
                        . '</span>';
                } else {
                    return "<span>{$customer->id}</span>";
                }
            },

        ]);

        CRUD::addColumn([
            'name' => 'customer_code',
            'label' => 'Customer Code',
        ]);
        CRUD::addColumn([
            'name' => 'customer_name',
            'label' => 'Customer Name',
        ]);
        CRUD::column('email');

        CRUD::addColumn([
            'name' => 'phone',
            'label' => 'Phone',
            'type' => 'custom_html',
            'value' => function ($customer) {

                $phone = $customer->phone;

                if (!empty($customer->phone_ext)) {
                    $phone .= config("amplify.constant.phone_ext_delimiter", "ext") . $customer->phone_ext;
                }

                return $phone;
            }
        ]);

        CRUD::addColumn([
            'name' => 'punch_out',
            'label' => 'Punch Out',
            'type' => 'boolean',
        ]);

        CRUD::addColumn([
            'name' => 'customer_type',
            'label' => 'Customer Type',
        ]);

        $this->crud->addClause('active');
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     *
     * @return void
     *
     * @throws \Exception
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(CustomerRequest::class);
        Widget::add()->type('script')->content('vendor/backend/js/forms/customer.js');

        $countries = Country::enabled()->get()->pluck('name', 'iso2')->toArray();

        // BASIC
        CRUD::field('customer_name')->type('text')->tab('Basic')->label('Company Name');
        CRUD::field('customer_code')->type('text')->tab('Basic')->label('Company Code');
        CRUD::field('email')->type('email')->tab('Basic')->label('Company Email');
        CRUD::addField([
            'name' => 'phone',
            'label' => 'Company Phone',
            'type' => 'text',
            'tab' => 'Basic',
            'wrapper' => ['class' => 'form-group col-md-9'],
        ]);
        CRUD::addField([
            'name' => 'phone_ext',
            'label' => 'Phone Extension',
            'type' => 'text',
            'tab' => 'Basic',
            'wrapper' => ['class' => 'form-group col-md-3'],
        ]);
        CRUD::addField([
            'name' => 'approved',
            'type' => 'hidden',
            'value' => 1,
        ]);
        CRUD::addField([
            'label' => 'Industry Classification',
            'name' => 'industry_classification_id',
            'type' => 'select2',
            'entity' => 'IndustryClassification',
            'model' => IndustryClassification::class,
            'attribute' => 'name',
            'tab' => 'Basic',
            'placeholder' => 'Select a industry classification',
            'options' => (fn($query) => $query->orderBy('name')->get()),
        ]);
        CRUD::field('customer_type')->type('enum')->tab('Basic')->label('Customer Type');

        // BIll ADDRESS
        CRUD::addFields([
            [
                'name' => 'address_1',
                'type' => 'text',
                'label' => 'Address Line 1',
                'tab' => 'Billing',
                'allows_null' => false,
            ],
            [
                'name' => 'address_2',
                'type' => 'text',
                'label' => 'Address Line 2',
                'tab' => 'Billing',
            ],
            [
                'name' => 'address_3',
                'type' => 'text',
                'label' => 'Address Line 3',
                'tab' => 'Billing',
            ],
            [
                'name' => 'city',
                'type' => 'text',
                'label' => 'City',
                'tab' => 'Billing',
                'wrapper' => [
                    'class' => 'form-group col-md-6',
                ],
            ],
            [
                'name' => 'country_code',
                'type' => 'select2_from_array',
                'options' => $countries,
                'label' => 'Country',
                'tab' => 'Billing',
                'wrapper' => [
                    'class' => 'form-group col-md-6',
                ],
            ],
            [
                'model' => \Amplify\System\Backend\Models\State::class,
                'attribute' => 'name',
                'data_source' => backpack_url('state/fetch/state-by-country-code'),
                'placeholder' => 'Select an state',
                'include_all_form_fields' => true,
                'method' => 'POST',
                'minimum_input_length' => 0,
                'dependencies' => ['country_code'],
                'tab' => 'Billing',
                'name' => 'state',
                'type' => 'select2_from_ajax',
                'label' => 'State',
                'wrapper' => [
                    'class' => 'form-group col-md-6',
                ],
            ],
            [
                'name' => 'zip_code',
                'type' => 'text',
                'label' => 'Zip Code',
                'tab' => 'Billing',
                'wrapper' => [
                    'class' => 'form-group col-md-6',
                ],
            ],
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
                'default' => 0,
                'tab' => 'Additional',
            ],
            [
                'type' => 'tinymce',
                'name' => 'punch_out_configuration',
                'label' => 'Punch Out Configuration',
                'both',
                'tab' => 'Additional',
            ],
            [
                'label' => 'Customer Group',
                'name' => 'customer_group_id',
                'type' => 'select2',
                'entity' => 'customer_group',
                'model' => CustomerGroup::class,
                'attribute' => 'group_name',
                'ajax' => true,
                'tab' => 'Additional',
                'placeholder' => 'Select a customer group',
                'options' => (fn($query) => $query->orderBy('group_name')->get()),
            ], [
                'name' => 'warehouse_seq_code',
                'label' => 'Warehouse seq code',
                'type' => 'text',
                'tab' => 'Additional',
                'attributes' => [
                    'autocomplete' => 'false',
                ],
            ],
            [
                'name' => 'free_shipment_amount',
                'type' => 'number',
                'tab' => 'Additional',

            ],
            [
                'name' => 'is_suspended',
                'type' => 'boolean',
                'label' => 'Suspended?',
                'tab' => 'Additional',

            ]
        ]);
    }


    /**
     * Complete overwrite to backpack method
     *
     * @return array|\Illuminate\Http\RedirectResponse
     */
    public function store()
    {
        $this->crud->hasAccessOrFail('create');

        $request = $this->crud->validateRequest();

        $this->crud->registerFieldEvents();

        if (config('amplify.erp.auto_create_cash_customer')
            && !$request->filled('customer_code')) {

            $industry = null;

            if ($request->filled('industry_classification_id')) {
                $industry = IndustryClassification::find($request->input('industry_classification_id'));
            }

            $erpCustomer = ErpApi::createCustomer([
                'template_customer_number' => config('amplify.frontend.guest_default'),
                'email_address' => $request->input('email'),
                'phone_number' => $request->input('phone'),
                'phone_ext' => $request->input('phone_ext'),
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
                'customer_industry' => $industry?->name ?? null,
            ]);

            if (!empty($erpCustomer->Message)) {
                throw ValidationException::withMessages([
                    'customer_code' => $erpCustomer->Message,
                ]);
            }

            if ($erpCustomer->CustomerNumber == null) {

                \Alert::success(trans('Unable to create customer on ERP.'))->flash();

                return redirect()->back();
            }

            $request->offsetSet('customer_code', $erpCustomer->CustomerNumber);
        }

        $item = $this->crud->create($this->crud->getStrippedSaveRequest($request));

        $this->data['entry'] = $this->crud->entry = $item;

        \Alert::success(trans('backpack::crud.insert_success'))->flash();

        $this->crud->setSaveAction();

        if (!empty($custom->customer_code)) {
            CustomerProfileSyncJob::dispatch(['customer_id' => $this->data['entry']->getKey()]);
        }

        return $this->crud->performSaveAction($item->getKey());
    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     *
     * @return void
     *
     * @throws \Exception
     */
    protected function setupUpdateOperation()
    {
        CRUD::setValidation(CustomerRequest::class);

        $this->setupCreateOperation();

        $options = [];
        ErpApi::getWarehouses()->each(function (Warehouse $warehouse) use (&$options) {
            $options[$warehouse->InternalId] = "{$warehouse->WarehouseNumber} - {$warehouse->WarehouseName}";
        });

        //ERP
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
        CRUD::addColumn([
            'name' => 'phone',
            'label' => 'Phone',
            'type' => 'custom_html',
            'value' => function ($customer) {

                $phone = $customer->phone;

                if (!empty($customer->phone_ext)) {
                    $phone .= config("amplify.constant.phone_ext_delimiter", "ext") . $customer->phone_ext;
                }

                return $phone;
            }
        ]);
        CRUD::column('punch_out')->type('boolean');
        CRUD::column('customer_type');
        CRUD::column('customer_group_id');
        CRUD::column('customer_type');
        CRUD::column('warehouse_seq_code');
        CRUD::column('is_suspended')->type('boolean');
        CRUD::addColumn([
            'name' => 'addresses',
            'label' => 'Addresses',
            'type' => 'table-related',
            'columns' => [
                [
                    'name' => 'address_name',
                    'label' => 'Name',
                    'type' => 'text',
                ],
                [
                    'name' => 'address_code',
                    'label' => 'Code',
                    'type' => 'text',
                ],
                [
                    'name' => 'address_1',
                    'label' => 'Line 1',
                    'type' => 'text',
                ],
                [
                    'name' => 'address_2',
                    'label' => 'Line 2',
                    'type' => 'text',
                ],
                [
                    'name' => 'address_3',
                    'label' => 'Line 3',
                    'type' => 'text',
                ],
                [
                    'name' => 'city',
                    'label' => 'City',
                    'type' => 'text',
                ],
                [
                    'name' => 'state',
                    'label' => 'State',
                    'type' => 'text',
                ],
                [
                    'name' => 'country_code',
                    'label' => 'Country',
                    'type' => 'text',
                ],
                [
                    'name' => 'zip_code',
                    'label' => 'Zip Code',
                    'type' => 'text',
                ],
                [
                    'name' => 'phone',
                    'label' => 'Phone',
                    'type' => 'text',
                ],
            ],
        ]);

        // Admin Tab
        CRUD::addColumn([
            'name' => 'contact.name',
            'label' => 'Name',
        ]);
        CRUD::addColumn([
            'name' => 'contact.email',
            'label' => 'Email',
        ]);
        CRUD::addColumn([
            'name' => 'contact.phone',
            'label' => 'Phone',
        ]);
        CRUD::addColumn([
            'name' => 'contact.is_admin',
            'label' => 'Is Admin',
            'type' => 'boolean',
        ]);
        CRUD::addColumn([
            'name' => 'contact.order_limit',
            'label' => 'Order Limit',
            'type' => 'number',
        ]);
        CRUD::addColumn([
            'name' => 'contact.daily_budget_limit',
            'label' => 'Daily Budget Limit',
            'type' => 'number',
        ]);
        CRUD::addColumn([
            'name' => 'contact.monthly_budget_limit',
            'label' => 'Monthly Budget Limit',
            'type' => 'number',
        ]);

        // Fields of ERP Information tab
        CRUD::addColumn([
            'name' => 'ar_number',
            'label' => 'Customer AR Number',
        ]);
        CRUD::addColumn([
            'name' => 'class',
            'label' => 'Customer Class',
        ]);
        CRUD::addColumn([
            'name' => 'default_currency',
            'label' => 'Customer Default Currency',
        ]);
        CRUD::addColumn([
            'name' => 'shipto_address_code',
            'label' => 'Customer Default Shipto Address Code',
        ]);
        CRUD::addColumn([
            'name' => 'suspend_code',
            'label' => 'Customer Suspend Code',
        ]);
        CRUD::addColumn([
            'name' => 'warehouse_id',
            'label' => 'Default Warehouse Code',
        ]);
        CRUD::addColumn([
            'name' => 'carrier_code',
            'label' => 'Customer Carrier Code',
        ]);
        CRUD::addColumn([
            'name' => 'business_contact',
            'label' => 'Customer Business Contact',
        ]);
        CRUD::addColumn([
            'name' => 'customer_po_required',
            'label' => 'Customer PO Required',
            'type' => 'boolean',
        ]);
        CRUD::addColumn([
            'name' => 'allow_backorder',
            'label' => 'Customer Allow Backorder',
            'type' => 'boolean',
        ]);
        CRUD::addColumn([
            'name' => 'credit_card_only',
            'label' => 'Customer Credit Card Only',
            'type' => 'boolean',
        ]);
        CRUD::column('free_shipment_amount')->type('number');

    }

    /***
     * @param $id
     * @return bool|string
     */
    public function destroy($id)
    {
        $this->crud->hasAccessOrFail('delete');

        $this->crud->getCurrentEntry()->contacts()->delete();

        $this->crud->getCurrentEntry()->addresses()->delete();

        $id = $this->crud->getCurrentEntryId() ?? $id;

        return $this->crud->delete($id);
    }

    /**
     * @return mixed
     */
    protected function fetchCustomerGroup()
    {
        return $this->fetch(CustomerGroup::class);
    }

    /**
     * bulkPublish
     *
     * @param mixed $request
     * @return JsonResponse
     */
    public function bulkProfileSync(Request $request)
    {
        try {
            $selectedItems = $request->input('entries');

            if (!empty($selectedItems)) {
                foreach ($selectedItems as $customer_id) {
                    CustomerProfileSyncJob::dispatch(['customer_id' => $customer_id]);
                }
            }

            return response()->json([
                'message' => 'success',
                'status' => true,
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => $exception->getMessage(),
                'status' => false,
            ]);
        }
    }
}
