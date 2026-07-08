<?php

namespace Amplify\System\Backend\Http\Controllers\Admin;

use Amplify\System\Abstracts\BackpackCustomCrudController;
use Amplify\System\Backend\Http\Requests\CustomerGroupRequest;
use Amplify\System\Backend\Models\Category;
use Amplify\System\Backend\Models\Customer;
use Amplify\System\Backend\Models\CustomerGroup;
use Amplify\System\Backend\Models\FlatDiscount;
use Amplify\System\Backend\Models\OrderValueDiscount;
use Amplify\System\Backend\Models\OrderValueDiscountDetail;
use Amplify\System\Backend\Models\PricingRule;
use Amplify\System\Backend\Models\User;
use Amplify\System\Backend\Models\VolumeDiscount;
use Amplify\System\Backend\Models\VolumeDiscountDetail;
use Exception;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanel;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Backpack\Pro\Http\Controllers\Operations\FetchOperation;
use DB;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

/**
 * Class CustomerGroupCrudController
 *
 * @property-read CrudPanel $crud
 */
class CustomerGroupCrudController extends BackpackCustomCrudController
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
        CRUD::setModel(CustomerGroup::class);
        CRUD::setRoute(config('backpack.base.route_prefix').'/customer-group');
        CRUD::setEntityNameStrings('customer-group', 'customer groups');
        $this->data['categories'] = Category::select(['id', 'category_name'])->get()->toArray();
        $this->data['catalog_categories'] = Category::whereNull('parent_id')
            ->select(['id', 'category_name', 'parent_id'])
            ->orderBy('category_name')
            ->get()
            ->toArray();
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
        CRUD::addColumns([
            [
                'name' => 'id',
                'label' => 'ID',
                'type' => 'number',
            ],
            [
                'name' => 'group_name',
                'label' => 'Name',
            ],
            [
                'name' => 'group_code',
                'label' => 'Code',
            ],
            [
                'name' => 'group_pricing_type',
                'label' => 'Pricing',
                'type' => 'select_from_array',
                'options' => CustomerGroup::CUSTOMER_GROUP_PRICING_TYPE,
                'searchLogic' => function ($query, $column, $searchTerm) {
                    $query->orWhere('group_pricing_type', 'like', '%' . Str::slug($searchTerm) . '%');
                },
            ],
            [
                'name' => 'users',
                'label' => 'Assigned Users',
                'type' => 'relationship',
                'entity' => 'users',
                'attribute' => 'name',
            ]
        ]);
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     *
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(CustomerGroupRequest::class);
        $this->crud->setCreateContentClass('col-md-12');
        $this->crud->setCreateView('backend::pages.customer_groups.create');
        $this->data['users'] = User::query()
            ->select(['id', 'name', 'email'])
            ->orderBy('name')
            ->get()
            ->toArray();

        CRUD::addField([
            'name' => 'group_code',
            'label' => 'Group Code',
        ]);
        CRUD::addField([
            'name' => 'group_name',
            'label' => 'Group Name',
        ]);
        CRUD::addField([
            'name' => 'group_pricing_type',
            'label' => 'Group Pricing Type',
        ]);

        CRUD::field('customers');
        CRUD::field('users');
        CRUD::field('pricing_rules');

        $this->data['customer_group_pricing_type'] = CustomerGroup::CUSTOMER_GROUP_PRICING_TYPE;
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
        $this->data['customer_group_data'] = $this->crud->model
            ->with(
                'catalog',
                'customers',
                'users',
                'cg_pricing_rules.flat_discounts.categories',
                'cg_pricing_rules.volume_discounts.categories',
                'cg_pricing_rules.volume_discounts.volume_discount_details',
                'cg_pricing_rules.order_value_discount.order_value_discount_details'
            )
            ->find(request()->id);
        $this->crud->setEditContentClass('col-md-12');
        $this->crud->setUpdateView('backend::pages.customer_groups.create');
        $this->setupCreateOperation();
    }

    public function setupShowOperation()
    {

        CRUD::addColumns([
            [
                'name' => 'id',
                'label' => 'ID',
                'type' => 'number',
            ],
            [
                'name' => 'group_name',
                'label' => 'Name',
            ],
            [
                'name' => 'group_code',
                'label' => 'Code',
            ],
            [
                'name' => 'group_pricing_type',
                'label' => 'Pricing',
                'type' => 'select_from_array',
                'options' => CustomerGroup::CUSTOMER_GROUP_PRICING_TYPE,
                'searchLogic' => function ($query, $column, $searchTerm) {
                    $query->orWhere('group_pricing_type', 'like', '%' . Str::slug($searchTerm) . '%');
                },
            ],
            [
                'name' => 'users',
                'label' => 'Assigned Users',
                'type' => 'table-related',
                'entity' => 'users',
                'attribute' => 'name',
                'tab' => 'users',
            ]
        ]);

//        $this->data['customer_group_data'] = $this->crud->model
//            ->with(
//                'customers',
//                'users',
//                'cg_pricing_rules.flat_discounts.categories',
//                'cg_pricing_rules.volume_discounts.categories',
//                'cg_pricing_rules.volume_discounts.volume_discount_details',
//                'cg_pricing_rules.order_value_discount.order_value_discount_details'
//            )
//            ->find(request()->id);
//
//        $this->crud->setShowContentClass('col-md-12');
//        $this->crud->setShowView('backend::pages.customer_groups.show');
    }

    /**
     * @return RedirectResponse
     */
    public function store(CustomerGroupRequest $request)
    {
        DB::beginTransaction();
        try {
            $customerGroupResponse = $this->traitStore($request);
            $this->syncUsers($customerGroupResponse['data'], $request);
            if (count($request->customers) > 0) {
                Customer::whereIn('id', $request->customers)->update(['customer_group_id' => $customerGroupResponse['data']->id]);
            }

            $cg_id = $customerGroupResponse['data']->id;
            $pricingRulesDataFormat = [
                'customer_group_id' => $cg_id,
                'is_volume_discount' => $request->pricing_rules['volume_discount'] ?? 0,
                'is_volume_discount_additive' => $request->pricing_rules['volume_discount_additive'] ?? 0,
                'is_flat_discount' => $request->pricing_rules['flat_discount'] ?? 0,
                'is_order_value_discount' => $request->pricing_rules['order_value_discount'] ?? 0,
                'is_order_value_discount_additive' => $request->pricing_rules['order_value_discount_additive'] ?? 0,
            ];
            $pricingRulesData = PricingRule::create($pricingRulesDataFormat);
            if ($request->pricing_rules['flat_discount']
                && count($request->pricing_rules['flat_discount_pricing_rules']) > 0) {
                $this->handleFlatDiscountOperation($request, $pricingRulesData, false);
            }

            if ($request->pricing_rules['flat_discount']
                && count($request->pricing_rules['volume_discount_pricing_rules']) > 0) {
                $this->handleVolumeDiscountOperation($request, $pricingRulesData, false);
            }

            if (count($request->pricing_rules['order_value_discount_pricing_rules']) > 0) {
                $this->handleOrderValueDiscountOperation($request, $pricingRulesData, false);
            }
            DB::commit();

            return $customerGroupResponse;
        } catch (Exception $exception) {
            DB::rollback();

            return $exception->getMessage();
        }
    }

    /**
     * @return Response|string
     */
    public function update(CustomerGroupRequest $request)
    {
        DB::beginTransaction();
        try {
            $customerGroupResponse = $this->traitUpdate($request);
            $this->syncUsers($customerGroupResponse['data'], $request);
            $cg_id = $customerGroupResponse['data']->id;
            $pricingRulesDataFormat = [
                'customer_group_id' => $cg_id,
                'is_volume_discount' => $request->pricing_rules['volume_discount'] ?? 0,
                'is_volume_discount_additive' => $request->pricing_rules['volume_discount_additive'] ?? 0,
                'is_flat_discount' => $request->pricing_rules['flat_discount'] ?? 0,
                'is_order_value_discount' => $request->pricing_rules['order_value_discount'] ?? 0,
                'is_order_value_discount_additive' => $request->pricing_rules['order_value_discount_additive'] ?? 0,
            ];
            $pricingRulesData = PricingRule::updateOrCreate(['customer_group_id' => $cg_id], $pricingRulesDataFormat);

            if (count($request->pricing_rules['flat_discount_pricing_rules']) > 0) {
                $this->handleFlatDiscountOperation($request, $pricingRulesData, true);
            }

            if (count($request->pricing_rules['volume_discount_pricing_rules']) > 0) {
                $this->handleVolumeDiscountOperation($request, $pricingRulesData, true);
            }

            if (count($request->pricing_rules['order_value_discount_pricing_rules']) > 0) {
                $this->handleOrderValueDiscountOperation($request, $pricingRulesData, true);
            }
            DB::commit();

            return $customerGroupResponse;
        } catch (\Exception $exception) {
            DB::rollback();

            return $exception->getMessage();
        }
    }

    protected function syncUsers(CustomerGroup $customerGroup, CustomerGroupRequest $request): void
    {
        $userIds = collect($request->input('users', []))
            ->map(function ($user) {
                if (is_array($user)) {
                    return $user['id'] ?? null;
                }

                if (is_object($user)) {
                    return $user->id ?? null;
                }

                return $user;
            })
            ->filter()
            ->map(fn ($id) => (int) $id)
            ->values()
            ->all();

        $customerGroup->users()->sync($userIds);
    }

    /**
     * @param  false  $isUpdating
     */
    protected function handleFlatDiscountOperation($request, $pricingRulesData, $isUpdating = false)
    {
        if ($isUpdating) {
            FlatDiscount::where('pricing_rule_id', $pricingRulesData->id)->delete();
        }
        foreach ($request->pricing_rules['flat_discount_pricing_rules'] as $item) {
            $flatDiscount =
                FlatDiscount::create(['pricing_rule_id' => $pricingRulesData->id, 'discount' => $item['discount']]);
            if (count($item['categories']) > 0) {
                $pivotData = [];
                foreach ($item['categories'] as $categoryItem) {
                    $pivotData[] = [
                        'category_id' => $categoryItem['id'],
                        'flat_discount_id' => $flatDiscount->id,
                    ];
                }
                if ($isUpdating) {
                    $flatDiscount->categories()->detach();
                }
                $flatDiscount->categories()->attach($pivotData);
            }
        }
    }

    /**
     * @param  false  $isUpdating
     */
    protected function handleVolumeDiscountOperation($request, $pricingRulesData, $isUpdating = false)
    {
        if ($isUpdating) {
            VolumeDiscount::where('pricing_rule_id', $pricingRulesData->id)->delete();
        }
        foreach ($request->pricing_rules['volume_discount_pricing_rules'] as $item) {
            $volumeDiscount = VolumeDiscount::create(['pricing_rule_id' => $pricingRulesData->id]);
            if (count($item['categories']) > 0) {
                $pivotData = [];
                foreach ($item['categories'] as $categoryItem) {
                    $pivotData[] =
                        [
                            'category_id' => $categoryItem['id'],
                            'volume_discount_id' => $volumeDiscount->id,
                        ];
                }
                if ($isUpdating) {
                    $volumeDiscount->categories()->detach();
                }
                $volumeDiscount->categories()->attach($pivotData);
            }
            if (count($item['discounts']) > 0) {
                $volumeDiscountDetails = [];
                foreach ($item['discounts'] as $discountItem) {
                    $volumeDiscountDetails[] =
                        [
                            'volume_discount_id' => $volumeDiscount->id,
                            'min' => $discountItem['min'],
                            'max' => $discountItem['max'],
                            'discount' => $discountItem['discount'],
                        ];
                }
                if ($isUpdating) {
                    VolumeDiscountDetail::where('volume_discount_id', $volumeDiscount->id)->delete();
                }
                VolumeDiscountDetail::insert($volumeDiscountDetails);
            }
        }
    }

    /**
     * @param  false  $isUpdating
     */
    protected function handleOrderValueDiscountOperation($request, $pricingRulesData, $isUpdating = false)
    {
        if ($isUpdating) {
            OrderValueDiscount::where('pricing_rule_id', $pricingRulesData->id)->delete();
        }
        $orderValueDiscount = OrderValueDiscount::create(['pricing_rule_id' => $pricingRulesData->id]);
        $orderValueDiscountDetails = [];
        foreach ($request->pricing_rules['order_value_discount_pricing_rules'] as $item) {
            $orderValueDiscountDetails[] = [
                'order_value_discount_id' => $orderValueDiscount->id,
                'order_value_upto' => $item['order_value_upto'],
                'discount' => $item['discount'],
            ];
        }
        if ($isUpdating) {
            OrderValueDiscountDetail::where('order_value_discount_id', $orderValueDiscount->id)->delete();
        }
        OrderValueDiscountDetail::insert($orderValueDiscountDetails);
    }

    public function fetchCustomerById(): JsonResponse
    {
        $customer = Customer::query()->where(request()->all())->first();

        return response()->json($customer);
    }

    public function fetchCustomerList(): JsonResponse
    {
        $search = trim(request()->search);
        $customer_group_id = trim(request()->customer_group_id);
        $paginatePerPage = request()->pagination['resultsPerPage'] ?? 12;
        $customers = Customer::query();

        if (! empty($search)) {
            $customers = $customers->where('customer_group_id', '!=', $customer_group_id)->orWhereNull('customer_group_id')->where('customer_name', 'LIKE', "%{$search}%")
                ->orWhere('email', 'LIKE', "%{$search}%");

        } elseif (! empty($customer_group_id)) {
            $customers = $customers->where('customer_group_id', $customer_group_id);
        }

        $customers = $customers->select(['id', 'customer_code', 'customer_name', 'email', 'phone'])
            ->paginate($paginatePerPage);

        return response()->json($customers);
    }

    public function addCustomerToGroup(): JsonResponse
    {
        $response = Customer::whereId(request()->customer_id)->update([
            'customer_group_id' => request()->group_id,
        ]);

        return response()->json([
            'success' => true,
        ]);
    }

    public function removeCustomerFromGroup(): JsonResponse
    {
        Customer::whereId(request()->id)->update([
            'customer_group_id' => null,
        ]);

        return response()->json([
            'success' => true,
        ]);
    }
}
