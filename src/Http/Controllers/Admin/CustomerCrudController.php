<?php

namespace Amplify\System\Backend\Http\Controllers\Admin;

use Amplify\ErpApi\Facades\ErpApi;
use Amplify\ErpApi\Jobs\CustomerProfileSyncJob;
use Amplify\ErpApi\Wrappers\Warehouse;
use Amplify\System\Abstracts\BackpackCustomCrudController;
use Amplify\System\Backend\Http\Requests\CustomerRequest;
use Amplify\System\Backend\Models\Customer;
use Amplify\System\Backend\Models\CustomerGroup;
use Amplify\System\Helpers\UtilityHelper;
use Backpack\CRUD\app\Exceptions\BackpackProRequiredException;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanel;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/**
 * Class CustomerCrudController
 *
 * @property-read CrudPanel $crud
 */
class CustomerCrudController extends BackpackCustomCrudController
{
    use CreateOperation;
    use DeleteOperation;
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
        CRUD::setRoute(config('backpack.base.route_prefix').'/customer');
        CRUD::setEntityNameStrings('customer', 'customers');
    }

    protected function setupCustomRoutes($segment, $routeName, $controller)
    {
        Route::post($segment.'/bulk-profile-sync', [
            'as' => $routeName.'.bulk-profile-sync',
            'uses' => $controller.'@bulkProfileSync',
            'operation' => 'bulkProfileSync',
        ]);

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
     *
     * @throws BackpackProRequiredException
     */
    protected function setupListOperation()
    {
        $this->crud->enableExportButtons();

        if (backpack_user()->can($this->crud->entity_name.'.erp-bulk-sync')) {
            $this->crud->enableBulkActions();
            $this->crud->addButton('top', 'bulk_erp_sync', 'view', 'crud::buttons.bulk_erp_sync');
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
            $this->crud->addClause('where', 'created_at', '<=', $dates->to.' 23:59:59');
        });

        CRUD::addColumn([
            'name' => 'id',
            'label' => 'ID',
            'type' => 'custom_html',
            'value' => function ($customer) {
                if (backpack_user()->can($this->crud->entity_name.'.erp-bulk-sync')) {
                    return "<span>{$customer->id} "
                        .(($customer->synced_at != null) ? "<sup class='badge text-success px-0 font-weight-bold'>Synced</sup>" : '')
                        .'</span>';
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

        CRUD::column('phone');

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
        $options = [];
        ErpApi::getWarehouses()->each(function (Warehouse $warehouse) use (&$options) {
            $options[$warehouse->InternalId] = "{$warehouse->WarehouseNumber} - {$warehouse->WarehouseName}";
        });
        CRUD::setValidation(CustomerRequest::class);
        // BASIC
        CRUD::field('customer_code')->type('text')->tab('Basic')->label('Company Code');
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
            'hide_when' => [
                0 => ['punch_out_configuration'],
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
        // ADDRESS
        CRUD::addFields([
            [
                'name' => 'address_1',
                'type' => 'text',
                'label' => 'Address Line 1',
                'tab' => 'Addresses',
                'allows_null' => false,
            ],
            [
                'name' => 'address_2',
                'type' => 'text',
                'label' => 'Address Line 2',
                'tab' => 'Addresses',
            ],
            [
                'name' => 'address_3',
                'type' => 'text',
                'label' => 'Address Line 3',
                'tab' => 'Addresses',
            ],
            [
                'name' => 'city',
                'type' => 'text',
                'label' => 'City',
                'tab' => 'Addresses',
                'wrapper' => [
                    'class' => 'form-group col-md-6',
                ],
            ],
            [
                'name' => 'state',
                'type' => 'text',
                'label' => 'State',
                'tab' => 'Addresses',
                'wrapper' => [
                    'class' => 'form-group col-md-6',
                ],
            ],
            [
                'name' => 'country_code',
                'type' => 'text',
                'label' => 'Country',
                'tab' => 'Addresses',
                'wrapper' => [
                    'class' => 'form-group col-md-6',
                ],
            ],
            [
                'name' => 'zip_code',
                'type' => 'text',
                'label' => 'Zip Code',
                'tab' => 'Addresses',
                'wrapper' => [
                    'class' => 'form-group col-md-6',
                ],
            ],
        ]);

        CRUD::addField([
            'name' => 'addresses',
            'label' => 'Ship To Addresses',
            'type' => 'relationship',
            'tab' => 'Addresses',
            'new_item_label' => 'New Ship To Address',
            'subfields' => [
                [
                    'name' => 'address_code',
                    'type' => 'text',
                    'label' => 'Address Code',
                    'allows_null' => false,
                ],
                [
                    'name' => 'address_name',
                    'type' => 'text',
                    'label' => 'Address Name',
                    'allows_null' => false,
                ],
                [
                    'name' => 'address_1',
                    'type' => 'text',
                    'label' => 'Street Line 1',
                    'allows_null' => false,
                ],
                [
                    'name' => 'address_2',
                    'type' => 'text',
                    'label' => 'Street Line 2',
                ],
                [
                    'name' => 'address_3',
                    'type' => 'text',
                    'label' => 'Street Line 3',
                ],
                [
                    'name' => 'city',
                    'type' => 'text',
                    'label' => 'City',
                    'wrapper' => [
                        'class' => 'form-group col-md-6',
                    ],
                ],
                [
                    'name' => 'state',
                    'type' => 'text',
                    'label' => 'State',
                    'wrapper' => [
                        'class' => 'form-group col-md-6',
                    ],
                ],
                [
                    'name' => 'country_code',
                    'type' => 'text',
                    'label' => 'Country',
                    'wrapper' => [
                        'class' => 'form-group col-md-6',
                    ],
                ],
                [
                    'name' => 'zip_code',
                    'type' => 'text',
                    'label' => 'Zip Code',
                    'wrapper' => [
                        'class' => 'form-group col-md-6',
                    ],
                ],
            ],
        ]);
        // ADMIN
        CRUD::addField([
            'name' => 'contact',
            'type' => 'relationship',
            'label' => 'Admin (Role) User / Contact',
            'tab' => 'Admin',
            'subfields' => [
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
                    'type' => (config('amplify.api.contact_detail', false)) ? 'text' : 'hidden',
                    'label' => 'Contact ID',
                    'allows_null' => true,
                ],
                [
                    'name' => 'login_id',
                    'type' => (config('amplify.api.contact_detail', false)) ? 'text' : 'hidden',
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
    public function fetchCustomerGroup()
    {
        return CustomerGroup::where('group_name', 'like', '%'.\request()->q.'%')->get();
    }

    /**
     * bulkPublish
     *
     * @param  mixed  $request
     * @return JsonResponse
     */
    public function bulkProfileSync(Request $request)
    {
        try {
            $selectedItems = $request->input('entries');

            if (! empty($selectedItems)) {
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
