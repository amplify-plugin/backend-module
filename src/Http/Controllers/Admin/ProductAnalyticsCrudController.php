<?php

namespace Amplify\System\Backend\Http\Controllers\Admin;

use Amplify\System\Abstracts\BackpackCustomCrudController;
use Amplify\System\Backend\Models\Contact;
use Amplify\System\Backend\Models\Product;
use Amplify\System\Backend\Models\RecentlyViewedProduct;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanel;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Backpack\CRUD\app\Library\Widget;
use Backpack\Pro\Http\Controllers\Operations\FetchOperation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Number;

/**
 * Class ProductAnalyticsCrudController
 *
 * @property-read CrudPanel $crud
 */
class ProductAnalyticsCrudController extends BackpackCustomCrudController
{
    use FetchOperation;
    use ListOperation;
    use ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     */
    public function setup(): void
    {
        CRUD::setModel(RecentlyViewedProduct::class);
        CRUD::setRoute(config('backpack.base.route_prefix').'/product-analytics');
        CRUD::setEntityNameStrings('product-analytics', 'product analytics');
    }

    private function widgets()
    {
        $stats = RecentlyViewedProduct::query()
            ->selectRaw('COUNT(*) AS `total`')
            ->selectRaw('COUNT(CASE WHEN `repeat` > 1 THEN 1 END) AS `repeated`')
            ->selectRaw('COUNT(`add_to_cart_at`) AS `add_to_cart`')
            ->selectRaw('COUNT(`ordered_at`) AS `ordered`')
            ->selectRaw('COUNT(`rfq_at`) AS `quoted`')
            ->when(request()->filled('customer_id'), fn ($query)  => $query->where('customer_id', request()->input('customer_id')))
            ->when(request()->filled('contact_id'), fn ($query)  => $query->where('contact_id', request()->input('contact_id')))
            ->first();

        Widget::add([
            'type' => 'div',
            'class' => 'row mb-3',
            'content' => [
                [
                    'type'        => 'progress',
                    'class'       => 'card text-white bg-primary mb-2',
                    'value'       => $stats->add_to_cart > 0 ? Number::percentage($stats->total / $stats->add_to_cart) : 'N/A',
                    'description' => 'Add To Cart',
                    'hint'        => $stats->add_to_cart > 0 ? 'Ratio between viewed and added to the cart' : 'No data available',
                ],
                [
                    'type'        => 'progress',
                    'class'       => 'card text-white bg-warning mb-2',
                    'value'       => $stats->quoted > 0 ? Number::percentage($stats->total / $stats->quoted) : 'N/A',
                    'description' => 'Quoted',
                    'hint'        => $stats->quoted > 0 ? 'Ratio between viewed and quoted items' : 'No data available',
                ],
                [
                    'type'        => 'progress',
                    'class'       => 'card text-white bg-success mb-2',
                    'value'       => $stats->ordered > 0 ? Number::percentage($stats->total / $stats->ordered) : 'N/A',
                    'description' => 'Purchased',
                    'hint'        => $stats->ordered > 0 ? 'Ratio between viewed and purchased items' : 'No data available',
                ],
                [
                    'type'        => 'progress',
                    'class'       => 'card text-white bg-secondary mb-2',
                    'value'       => $stats->repeated > 0 ? Number::percentage($stats->total / $stats->repeated) : 'N/A',
                    'description' => 'Repeated',
                    'hint'        => $stats->total > 0 ? 'Ratio of revisited items' : 'No data available',
                ],
            ]
        ]);
    }

    /**
     * Define what happens when the List operation is loaded.
     */
    protected function setupListOperation(): void
    {
        $this->widgets();

        CRUD::addFilter([
            'name' => 'customer_id',
            'type' => 'select2_ajax',
            'label' => 'Customer',
            'placeholder' => 'Type Name, Code, Email, Phone',
            'method' => 'POST',
            'select_attribute' => 'display_name',
        ], backpack_url('contact/fetch/customer'), function ($value) {
            $this->crud->query->where('customer_id', '=', $value);
        });

        CRUD::addFilter([
            'name' => 'contact_id',
            'type' => 'select2_ajax',
            'label' => 'Contact',
            'placeholder' => 'Type Name or Email',
            'method' => 'POST',
            'select_attribute' => 'name',
        ], backpack_url('recently-viewed-product/fetch/contact'), function ($value) {
            $this->crud->query->where('contact_id', '=', $value);
        });

        CRUD::addColumn([
            'name' => 'id',
            'label' => 'ID',
            'type' => 'number',
        ]);

        CRUD::addColumn([
            'name' => 'product_id',
            'label' => 'Product',
            'type' => 'relationship',
            'entity' => 'product',
            'attribute' => 'display_name',
            'searchLogic' => function ($query, $column, $searchTerm) {
                $query->orWhereHas('product', function ($q) use ($searchTerm) {
                    $q->where('product_name', 'like', '%'.$searchTerm.'%')
                        ->orWhere('product_code', 'like', '%'.$searchTerm.'%');
                });
            },
        ]);

        CRUD::addColumn([
            'name' => 'customer_id',
            'label' => 'Customer',
            'type' => 'relationship',
            'entity' => 'customer',
            'attribute' => 'display_name',
        ]);

        CRUD::addColumn([
            'name' => 'contact_id',
            'label' => 'Contact',
            'type' => 'relationship',
            'entity' => 'contact',
            'attribute' => 'name',
        ]);

        CRUD::addColumn([
            'name' => 'session',
            'label' => 'Session',
            'type' => 'text',
            'limit' => 12,
        ]);

        CRUD::addColumn([
            'name' => 'repeat',
            'label' => 'Repeat',
            'type' => 'number',
        ]);

        CRUD::addColumn([
            'name' => 'viewed_at',
            'label' => 'Viewed At',
            'type' => 'datetime',
        ]);

        CRUD::addColumn([
            'name' => 'add_to_cart_at',
            'label' => 'Added To Cart',
            'type' => 'datetime',
        ]);

        CRUD::addColumn([
            'name' => 'rfq_at',
            'label' => 'RFQ At',
            'type' => 'datetime',
        ]);

        CRUD::addColumn([
            'name' => 'ordered_at',
            'label' => 'Ordered At',
            'type' => 'datetime',
        ]);

        CRUD::addColumn([
            'name' => 'updated_at',
            'label' => 'Updated At',
            'type' => 'datetime',
        ]);

        $this->crud->orderBy('viewed_at', 'desc');
    }

    /**
     * Define what happens when the Create operation is loaded.
     */
    protected function setupCreateOperation(): void
    {
        CRUD::setValidation(RecentlyViewedProductRequest::class);

        CRUD::addField([
            'name' => 'customer_id',
            'label' => 'Customer',
            'type' => 'select2_from_ajax',
            'entity' => 'customer',
            'attribute' => 'display_name',
            'model' => Customer::class,
            'data_source' => backpack_url('contact/fetch/customer'),
            'placeholder' => 'Optional — search customer',
            'minimum_input_length' => 1,
            'delay' => 200,
            'method' => 'POST',
            'allows_null' => true,
            'hint' => 'Optional. Used to narrow contacts and attach the row to a customer account.',
            'default' => old('customer_id', $this->crud->entry->customer_id ?? null),
        ]);

        CRUD::addField([
            'name' => 'contact_id',
            'label' => 'Contact',
            'type' => 'select2_from_ajax',
            'entity' => 'contact',
            'attribute' => 'name',
            'model' => Contact::class,
            'data_source' => backpack_url('recently-viewed-product/fetch/contact'),
            'placeholder' => 'Optional — search contact',
            'minimum_input_length' => 0,
            'delay' => 200,
            'method' => 'POST',
            'dependencies' => ['customer_id'],
            'include_all_form_fields' => true,
            'allows_null' => true,
            'hint' => 'Optional. When set, the product appears in that contact\'s storefront recently viewed list. Customer is auto-filled from the contact when empty.',
            'default' => old('contact_id', $this->crud->entry->contact_id ?? null),
        ]);

        CRUD::addField([
            'name' => 'product_id',
            'label' => 'Product',
            'type' => 'select2_from_ajax',
            'entity' => 'product',
            'attribute' => 'display_name',
            'model' => Product::class,
            'data_source' => backpack_url('recently-viewed-product/fetch/product'),
            'placeholder' => 'Search by product name or code',
            'minimum_input_length' => 1,
            'delay' => 200,
            'method' => 'POST',
            'hint' => 'Required. Search products by name or product code.',
            'default' => old('product_id', $this->crud->entry->product_id ?? null),
        ]);

        CRUD::addField([
            'name' => 'viewed_at',
            'label' => 'Viewed At',
            'type' => 'datetime',
            'default' => old('viewed_at', $this->crud->entry->viewed_at ?? now()),
            'hint' => 'Defaults to now when left empty.',
        ]);

        CRUD::addField([
            'name' => 'repeat',
            'label' => 'Repeat',
            'type' => 'number',
            'default' => old('repeat', $this->crud->entry->repeat ?? 1),
            'attributes' => ['min' => 1],
        ]);

        CRUD::addField([
            'name' => 'session',
            'label' => 'Session',
            'type' => 'text',
            'default' => old('session', $this->crud->entry->session ?? null),
        ]);

        CRUD::addField([
            'name' => 'add_to_cart_at',
            'label' => 'Added To Cart At',
            'type' => 'datetime',
            'default' => old('add_to_cart_at', $this->crud->entry->add_to_cart_at ?? null),
        ]);

        CRUD::addField([
            'name' => 'rfq_at',
            'label' => 'RFQ At',
            'type' => 'datetime',
            'default' => old('rfq_at', $this->crud->entry->rfq_at ?? null),
        ]);

        CRUD::addField([
            'name' => 'ordered_at',
            'label' => 'Ordered At',
            'type' => 'datetime',
            'default' => old('ordered_at', $this->crud->entry->ordered_at ?? null),
        ]);
    }

    /**
     * Define what happens when the Update operation is loaded.
     */
    protected function setupUpdateOperation(): void
    {
        $this->setupCreateOperation();
    }

    /**
     * Define what happens when the Show operation is loaded.
     */
    protected function setupShowOperation(): void
    {
        CRUD::column('id');

        CRUD::addColumn([
            'name' => 'product_id',
            'label' => 'Product',
            'type' => 'relationship',
            'entity' => 'product',
            'attribute' => 'display_name',
        ]);

        CRUD::addColumn([
            'name' => 'customer_id',
            'label' => 'Customer',
            'type' => 'relationship',
            'entity' => 'customer',
            'attribute' => 'display_name',
        ]);

        CRUD::addColumn([
            'name' => 'contact_id',
            'label' => 'Contact',
            'type' => 'relationship',
            'entity' => 'contact',
            'attribute' => 'name',
        ]);

        CRUD::column('session');
        CRUD::column('repeat')->type('number');
        CRUD::column('viewed_at')->type('datetime');
        CRUD::column('add_to_cart_at')->type('datetime');
        CRUD::column('rfq_at')->type('datetime');
        CRUD::column('ordered_at')->type('datetime');
        CRUD::column('created_at')->type('datetime');
        CRUD::column('updated_at')->type('datetime');
    }

    public function fetchProduct()
    {
        return $this->fetch([
            'model' => Product::class,
            'searchable_attributes' => ['product_name', 'product_code', 'id'],
            'paginate' => 10,
            'searchOperator' => 'LIKE',
            'query' => fn ($model) => $model
                ->select(
                    'id',
                    'product_name',
                    'product_code',
                    DB::raw('CONCAT(product_code, " - ", product_name) AS display_name')
                )
                ->orderBy('product_name'),
        ]);
    }

    public function fetchContact()
    {
        $inputs = backpack_form_input();

        return $this->fetch([
            'model' => Contact::class,
            'searchable_attributes' => ['name', 'email', 'id'],
            'paginate' => 10,
            'searchOperator' => 'LIKE',
            'query' => function ($model) use ($inputs) {
                $query = $model
                    ->select(
                        'id',
                        'name',
                        'email',
                        'customer_id'
                    )
                    ->orderBy('name');

                if (! empty($inputs['customer_id'])) {
                    $query->where('customer_id', $inputs['customer_id']);
                }

                return $query;
            },
        ]);
    }
}
