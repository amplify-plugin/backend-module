<?php

namespace Amplify\System\Backend\Http\Controllers\Admin;

use Amplify\System\Abstracts\BackpackCustomCrudController;
use Amplify\System\Backend\Http\Requests\ProductRequest;
use Amplify\System\Backend\Http\Requests\SKUProductRequest;
use Amplify\System\Backend\Models\Attribute;
use Amplify\System\Backend\Models\AttributeProduct;
use Amplify\System\Backend\Models\Brand;
use Amplify\System\Backend\Models\Category;
use Amplify\System\Backend\Models\CustomerGroup;
use Amplify\System\Backend\Models\DocumentType;
use Amplify\System\Backend\Models\DocumentTypeProduct;
use Amplify\System\Backend\Models\Manufacturer;
use Amplify\System\Backend\Models\ModelCode;
use Amplify\System\Backend\Models\OptionProduct;
use Amplify\System\Backend\Models\Product;
use Amplify\System\Backend\Models\ProductClassification;
use Amplify\System\Backend\Models\ProductImage;
use Amplify\System\Backend\Models\SkuProduct;
use Amplify\System\Backend\Traits\ProductTrait;
use Amplify\System\Cms\Models\Page;
use Amplify\System\Helpers\ProductHelper;
use Amplify\System\Utility\Services\DataTransformation\ExecuteScriptService;
use Backpack\CRUD\app\Exceptions\BackpackProRequiredException;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\InlineCreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanel;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Backpack\Pro\Http\Controllers\Operations\CloneOperation;
use Backpack\Pro\Http\Controllers\Operations\FetchOperation;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use JsonException;
use Prologue\Alerts\Facades\Alert;
use Spatie\Translatable\HasTranslations;
use stdClass;

/**
 * Class ProductCrudController
 *
 * @property-read CrudPanel $crud
 * @property int count
 * @property string current_tab
 * @property string next_tab
 * @property stdClass category
 */
class ProductCrudController extends BackpackCustomCrudController
{
    use CloneOperation;
    use CreateOperation {
        store as traitStore;
    }
    use FetchOperation;
    use HasTranslations;
    use InlineCreateOperation;
    use ListOperation;
    use ProductTrait;
    use ShowOperation;
    use UpdateOperation {
        update as traitUpdate;
    }

    protected $tabs = [];

    protected $current_tab = '';

    protected $next_tab = '';

    protected $product;

    /**
     * @var mixed
     */
    protected $attributes;

    /**
     * @var Collection
     */
    protected $attributesName;

    /**
     * @var Builder[]|EloquentCollection
     */
    private $categories;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(Product::class);
        CRUD::setRoute(config('backpack.base.route_prefix').'/product');
        CRUD::setEntityNameStrings('product', 'products');
        $this->crud->enableBulkActions();
        $this->crud->addButton('top', 'bulk_archive', 'view', 'crud::buttons.bulk_archive');
        $this->crud->addButton('top', 'bulk_publish', 'view', 'crud::buttons.bulk_publish');

        CRUD::removeButton('delete');
    }

    protected function setupCustomRoutes($segment, $routeName, $controller)
    {
        Route::post($segment.'/{id}/attribute-values', [
            'as' => $routeName.'.attributeValues',
            'uses' => $controller.'@attributeValues',
            'operation' => 'attributeValues',
        ]);
        Route::post($segment.'/{id}/publish', [
            'as' => $routeName.'.publish',
            'uses' => $controller.'@publish',
            'operation' => 'publish',
        ]);
        Route::post($segment.'/sku-reorder', [
            'as' => $routeName.'.sku-reorder',
            'uses' => $controller.'@skuReorder',
            'operation' => 'sku-reorder',
        ]);
    }

    /**
     * @return RedirectResponse
     *
     * @throws JsonException
     */
    public function store(ProductRequest $request)
    {
        if (ProductHelper::checkIfProductIsReadyToPublish()) {
            $request->merge([
                'status' => 'published',
                'published_at' => now(),
            ]);
        }

        if ($request->has_sku) {
            $request->merge([
                'sku_default_attributes' => json_encode($request->sku_default_attributes),
            ]);
        }

        /* Make data transformation while creating product */
        if (getDataTransformations('Products', $request->categories, 'save', 'boolean')) {
            $transformedData = $this->runDataTransformation($request->all());
            $request->merge($transformedData);
        }

        // your additional operations before save here
        $response = $this->traitStore();
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        $pivot = request()->pivot;
        $id = $this->crud->entry->id;
        $classification_id = $this->crud->entry->product_classification_id;

        $this->updatePivot($pivot, $id, $classification_id);
        $this->updateGroupPricePivot($request->customer_group_price, $id);
        $this->updateDocuments($request->productDocuments, $id);

        // Storing product images.
        $this->crud->entry->productImage()->updateOrCreate(['product_id' => $this->crud->entry->id], [
            'main' => $request->main,
            'thumbnail' => $request->thumbnail,
            'additional' => $request->additional,
        ]);

        if ($request->has('model_codes') && ! empty($request->input('model_codes'))) {
            // Model Code Attach
            $codes = Arr::map($request->model_codes, fn ($item) => $item['code']);
            $this->crud->entry->modelCodes()->attach($codes);
        }

        // operation after published product
        if ($this->data['entry']->status === 'published') {
            DB::table('products')->where('id', $this->data['entry']->id)->update(['published_at' => now(), 'archived_at' => null]);
        }

        return $response;
    }

    /**
     * @return array|RedirectResponse
     *
     * @throws JsonException
     */
    public function update(ProductRequest $request)
    {
        if (ProductHelper::checkIfProductIsReadyToPublish()) {
            $request->merge([
                'status' => 'published',
                'published_at' => now(),
            ]);
        }

        if ($request->has_sku) {
            $request->merge([
                'sku_default_attributes' => json_encode($request->sku_default_attributes),
            ]);
        }

        /* Make data transformation while updating product */
        if (getDataTransformations('Products', $request->categories, 'save', 'boolean')) {
            $transformedData = $this->runDataTransformation($request->all());
            $request->merge($transformedData);
        }

        // your additional operations before save here
        $response = $this->traitUpdate($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        $pivot = request()->pivot;
        $id = $this->crud->entry->id;

        $classification_id = $this->crud->entry->product_classification_id;

        $this->updatePivot($pivot, $id, $classification_id);
        $this->updateGroupPricePivot($request->customer_group_price, $id);
        $this->updateDocuments($request->productDocuments, $id);

        // Storing product images.
        $this->crud->entry->productImage()->updateOrCreate(['product_id' => $this->crud->entry->id], [
            'main' => $request->main,
            'thumbnail' => $request->thumbnail,
            'additional' => $request->additional,
        ]);

        if ($request->has('model_codes') && ! empty($request->input('model_codes'))) {
            // Model Code table data sync
            $codes = Arr::map($request->model_codes, fn ($item) => $item['code']);

            $this->crud->entry->modelCodes()->sync($codes);
        }

        // operation after published product
        if ($this->data['entry']->status === 'published') {
            DB::table('products')
                ->where('id', $this->data['entry']->id)
                ->update(['published_at' => now(), 'archived_at' => null]);
        }

        return $response;
    }

    /**
     * bulkDelete
     *
     * @param  mixed  $request
     * @return bool|void
     */
    public function bulkArchive(Request $request)
    {
        // CRUD::hasAccessOrFail('archive');
        $selectedItems = $request->input('entries');
        if (! empty($selectedItems)) {
            return Product::whereIn('id', $selectedItems)->where('status', '!=', 'archived')->update(['status' => 'archived']);
        }
    }

    /**
     * bulkPublish
     *
     * @param  mixed  $request
     * @return bool|void
     */
    public function bulkPublish(Request $request)
    {
        // CRUD::hasAccessOrFail('publish');
        $selectedItems = $request->input('entries');
        if (! empty($selectedItems)) {
            return Product::whereIn('id', $selectedItems)->where('status', '!=', 'published')->update(['status' => 'published']);
        }
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
        // Customizing Action Buttons
        CRUD::modifyButton('clone', ['content' => 'crud::buttons.product_clone']);
        CRUD::addButtonFromModelFunction('line', 'status_archive', 'statusArchive', 'end');

        CRUD::enableExportButtons();

        if (! backpack_user()->can('product.create') && ! (is_super_admin())) {
            CRUD::removeButton('create');
        }
        if (backpack_user()->can('product.publish')) {
            CRUD::addButtonFromModelFunction('line', 'status_publish', 'statusPublish', 'end');
        }
        if (backpack_user()->can('product.unpublish')) {
            CRUD::addButtonFromModelFunction('line', 'status_unpublish', 'statusUnpublish', 'end');
        }

        $rootId = config('amplify.sayt.default_catalog');

        $root = Category::query()->select('lft', 'rgt')
            ->findOrFail($rootId);

        $this->crud->query->where(function ($q) use ($root) {
            $q->whereHas('categories', function ($query) use ($root) {
                $query->whereBetween('categories.lft', [$root->lft, $root->rgt]);
            })
                ->orWhereDoesntHave('categories');
        });

        CRUD::addFilter([
            'name' => 'status',
            'type' => 'select2_multiple',
            'label' => 'Status',
        ],
            function () {
                return config('amplify.pim.product_statuses');
            },
            function ($values) {
                // if the filter is active
                $this->crud->addClause('whereIn', 'status', json_decode($values));
            }
        );

        // if request status empty then except status archived data return
        if ($this->crud->getRequest()->status == null) {
            $this->crud->addClause('whereNotIn', 'status', ['archived']);
        }

        if (config('amplify.pim.use_classifications')) {
            CRUD::addFilter(
                [
                    'name' => 'product_classification_id',
                    'type' => 'select_tree',
                    'label' => 'Classification',
                    'isMultiple' => false,
                    'styles' => [
                        'width' => 'width: 250px !important;',
                    ],
                ],
                function () {
                    $productClassification = ProductClassification::with('children')
                        ->where('parent_id', null)
                        ->get()
                        ->sortBy(fn ($item) => $item->getLabelAttribute(), SORT_NATURAL | SORT_FLAG_CASE)
                        ->values()
                        ->toArray();
                    array_unset_recursive($productClassification, 'children');
                    array_rename_recursive($productClassification, 'children', 'subs');
                    array_rename_recursive($productClassification, 'label', 'title');

                    return $productClassification;
                },
                function ($value) {
                    // if the filter is active
                    $this->crud->addClause('where', 'product_classification_id', $value);
                }
            );
        }

        CRUD::addFilter(
            [
                'name' => 'category_name',
                'type' => 'select_tree',
                'label' => 'Categories',
                'styles' => [
                    'width' => 'width: 250px !important;',
                ],
            ],
            function () {
                $categories = Category::with('children')
                    ->where('parent_id', '=', null)
                    ->get()
                    ->sortBy(fn ($item) => $item->getLabelAttribute(), SORT_NATURAL | SORT_FLAG_CASE)
                    ->values()
                    ->toArray();
                array_unset_recursive($categories, 'children');
                array_rename_recursive($categories, 'children', 'subs');
                array_rename_recursive($categories, 'label', 'title');

                return $categories;
                // return Category::all()->pluck('category_name', 'id')->toArray();
            },
            function ($values) {
                // if the filter is active
                $this->crud->query->whereHas('categories', function ($query) use ($values) {
                    $query->whereIn('category_id', json_decode($values));
                });
            }
        );

        CRUD::addFilter(
            [
                'name' => 'product_type',
                'type' => 'select2',
                'label' => 'Product Type',
            ],
            function () {
                return [
                    'normal' => 'Normal',
                    'bundle' => 'Bundle',
                    'configurable' => 'Configurable',
                ];
            },
            function ($value) {
                // if the filter is active
                $this->crud->addClause('where', 'product_type', '=', $value);
            }
        );

        CRUD::addFilter(
            [
                'name' => 'manufacturer_id',
                'type' => 'select2',
                'label' => 'Manufacturer',
            ],
            function () {
                return Manufacturer::orderBy('name')->get()->pluck('name', 'id')->toArray();
            },
            function ($value) {
                $this->crud->addClause('where', 'manufacturer_id', '=', $value);
            }
        );

        CRUD::addFilter(
            [
                'name' => 'is_new',
                'type' => 'dropdown',
                'label' => 'Is New',
            ],
            function () {
                return [
                    '0' => 'No',
                    '1' => 'Yes',
                ];
            },
            function ($value) {
                // if the filter is active
                $this->crud->addClause('where', 'is_new', '=', $value);
            }
        );

        CRUD::addFilter(
            [
                'name' => 'has_sku',
                'type' => 'dropdown',
                'label' => 'Has SKU',
            ],
            function () {
                return [
                    '0' => 'No',
                    '1' => 'Yes',
                ];
            },
            function ($value) {
                // if the filter is active
                $this->crud->addClause('where', 'has_sku', '=', $value);
            }
        );

        CRUD::addColumn([
            'name' => 'id',
            'type' => 'custom_html',
            'value' => function ($model) {
                if ($model->is_new === 1 && ! $model->is_updated) {
                    return $model->id.' <sup class="badge text-danger px-0">New</sup>';
                } elseif ($model->is_updated) {
                    return $model->id.' <sup class="badge text-warning px-0">Updated</sup>';
                } else {
                    return $model->id;
                }
            },
        ]);

        CRUD::addColumn([
            'name' => 'product_code',
            'label' => 'Product Code',
        ]);

        CRUD::addColumn([
            'name' => 'product_name',
            'label' => 'Product Name',
            'type' => 'custom_html',
            'value' => function ($model) {
                return $model->local_product_name;
            },
            'searchLogic' => function ($query, $column, $searchTerm) {
                $query->orWhere('product_name', 'like', '%'.$searchTerm.'%');
            },
        ]);

        CRUD::addColumn([
            'name' => 'status',
            'type' => 'custom_html',
            'value' => function ($model) {
                switch ($model->status) {
                    case 'incomplete':
                        $html =
                            '<span class="rounded border border-primary text-primary px-3 py-2">Incomplete</span>';
                        break;
                    case 'draft':
                        $html = '<span class="rounded border border-warning text-warning px-3 py-2">Draft</span>';
                        break;
                    case 'published':
                        $html =
                            '<span class="rounded border border-success text-success px-3 py-2">Published</span>';
                        break;
                    case 'archived':
                        $html = '<span class="rounded border border-danger text-danger px-3 py-2">Archived</span>';
                        break;
                    default:
                        $html = '-';
                        break;
                }

                return $html;
            },
            'searchLogic' => function ($query, $column, $searchTerm) {
                $query->orWhere('status', 'like', '%'.$searchTerm.'%');
            },
        ]);
        if (config('amplify.pim.use_classifications')) {
            CRUD::addColumn([
                'name' => 'product_classification_id',
                'label' => 'Product Classification',
                'entity' => 'productClassification',
                'attribute' => 'title',
                'model' => ProductClassification::class,
                'searchLogic' => function ($query, $column, $searchTerm) {
                    $query->orWhereHas('productClassification', function ($q) use ($searchTerm) {
                        $q->where('title', 'like', '%'.$searchTerm.'%');
                    });
                },
            ]);
        }
        CRUD::addColumn([
            'name' => 'categories',
            'label' => 'Categories',
            'attribute' => 'category_name',
            'model' => Category::class,
            'entity' => 'categories',
            'searchLogic' => function ($query, $column, $searchTerm) {
                $query->orWhereHas('categories', function ($q) use ($searchTerm) {
                    $q->where('category_name', 'like', '%'.$searchTerm.'%');
                });
            },
        ]);

        if (config('amplify.client_code') == 'RHS') {
            CRUD::addColumn([
                'name' => 'modelCodes',
                'label' => 'Model Codes',
                'attribute' => 'code',
                'model' => ModelCode::class,
                'entity' => 'modelCodes',
                'searchLogic' => function ($query, $column, $searchTerm) {
                    $query->orWhereHas('modelCodes', function ($q) use ($searchTerm) {
                        $q->where('code', 'like', '%'.$searchTerm.'%');
                    });
                },
            ]);
        }

        CRUD::column('selling_price')->label('Selling Price');

        CRUD::column('manufacturerRelation')->label('Manufacturer');

        CRUD::addColumn([
            'name' => 'updated_at',
            'type' => 'datetime',
            'label' => 'Last Updated',
        ]);
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     *
     * @return void
     *
     * @throws JsonException
     */
    protected function setupCreateOperation()
    {
        // TODO Add Product Type Attribute
        CRUD::setValidation(ProductRequest::class);
        $this->crud->setCreateContentClass('col-md-12');

        $this->data['translatable'] = array_keys($this->crud->model->translations);
        $this->data['product'] = $this->crud->model->with('productImage', 'productClassification', 'categories', 'options', 'CustomerGroupPrice')->find(request()->id);
        $this->data['productClassification'] = $this->data['product']->productClassification ?? new stdClass;
        $this->data['attributes'] = json_decode($data['productClassification']->attributes ?? '[]', true);
        $this->data['customer_groups'] = CustomerGroup::where('group_pricing_type', 'group-price-per-product')->get();
        $this->data['options'] = json_decode($this->data['productClassification']->options ?? '[]', true);
        $this->data['core_configs'] = config('amplify.pim');
        $this->data['product_mandatory_fields'] = ProductHelper::isRequiredFields() ? ProductHelper::getProductMandatoryFields() : [];
        $this->data['easyAsk_default_product_categories'] = eaDefaultCategories('products');
        $this->data['all_single_product_pages'] = Page::select('id', 'name')->whereIn('page_type', ['single_product', 'custom_product'])->orderBy('name')->get()->toArray();
        // $this->data['all_single_product_pages'] = Page::getPages(['single_product','custom_product']);

        $this->data['all_manufacturers'] = Manufacturer::orderBy('name')->get()->transform(function ($item, $key) {
            $item->label = $item->name;

            return $item;
        });
        $this->data['all_brands'] = Brand::orderBy('title')->get()->transform(function ($item, $key) {
            $item->label = $item->title; // treeselect expects `label`

            return $item;
        });
        $this->data['all_document_types'] = DocumentType::orderBy('name')->get();
        $this->data['show_order_quantity_config_tab'] = config('amplify.pim.use_minimum_order_quantity') && ! $this->crud->entry?->has_sku;

        // dd($this->data, $this->data['productClassification'], $this->data['product']);
        $this->crud->setCreateView('backend::pages.product.create');

        // "Attributes" "Pricing" "Media" "Documents" "SEO" "Icecat"
        CRUD::field('product_type')->tab('BasicInfo');
        CRUD::field('product_name')->tab('BasicInfo');
        CRUD::field('has_sku')->tab('BasicInfo');
        CRUD::field('sku_default_attributes')->tab('BasicInfo');
        CRUD::field('product_code')->tab('BasicInfo');
        CRUD::field('prop65_message')->tab('BasicInfo');
        CRUD::field('brand_name')->tab('BasicInfo');
        CRUD::field('product_classification_id')->tab('BasicInfo');
        CRUD::field('short_description')->tab('BasicInfo');
        CRUD::field('description')->tab('BasicInfo');
        CRUD::field('categories')->tab('BasicInfo');
        CRUD::field('ean_number')->tab('BasicInfo');
        CRUD::field('gtin_number')->tab('BasicInfo');
        CRUD::field('upc_number')->tab('BasicInfo');
        CRUD::field('asin')->tab('BasicInfo');
        // CRUD::field('manufacturer')->tab('BasicInfo');
        // CRUD::field('brand')->tab('BasicInfo');
        // CRUD::field('model_code')->tab('BasicInfo');
        // CRUD::field('model_name')->tab('BasicInfo');
        CRUD::field('uom')->tab('BasicInfo');
        CRUD::field('pack_size')->tab('BasicInfo');
        CRUD::field('is_non_stock')->tab('BasicInfo');
        CRUD::field('allow_back_order')->tab('BasicInfo');
        CRUD::field('manufacturer_id')->tab('BasicInfo');
        CRUD::field('brand_id')->tab('BasicInfo');
        CRUD::field('single_product_page_id')->tab('BasicInfo');

        CRUD::field('attributes')->tab('Attributes');

        CRUD::field('selling_price')->tab('Pricing');
        CRUD::field('msrp')->tab('Pricing');
        CRUD::field('customer_group_price')->tab('Pricing');

        CRUD::field('product_slug')->tab('SEO');
        CRUD::field('meta_description')->tab('SEO');
        CRUD::field('meta_keywords')->tab('SEO');
        CRUD::field('og_description')->tab('SEO');

        CRUD::field('status')->type('enum')->tab('BasicInfo');
        CRUD::field('products_list')->tab('BasicInfo');
        CRUD::field('is_updated')->tab('BasicInfo');
        CRUD::field('archived_at')->type('hidden')->tab('BasicInfo');
        CRUD::field('published_at')->type('hidden')->tab('BasicInfo');

        if ($this->data['show_order_quantity_config_tab']) {
            CRUD::field('min_order_qty')->tab('ExtraData');
            CRUD::field('qty_interval')->tab('ExtraData');
        }
        CRUD::field('flags[availability]')->tab('ExtraData');
        CRUD::field('flags[price]')->tab('ExtraData');
        CRUD::field('flags[special]')->tab('ExtraData');

        CRUD::field('specifications')->tab('FeaturesAndSpecifications');

        // Product images in product__images table
        CRUD::addField([
            'name' => 'images',
            'type' => 'relationship',
            'entity' => 'productImage',
            'tab' => 'Media',
            'subfields' => [
                [
                    'name' => 'main',
                    'type' => 'text',
                ],
                [
                    'name' => 'thumbnail',
                    'type' => 'text',
                ],
                [
                    'name' => 'additional',
                    'type' => 'text',
                ],
            ],
        ]);
        CRUD::addField([
            'name' => 'options',
            'type' => 'relationship',
            'entity' => 'options',
            'inline_create' => true,
            'attribute' => 'option_name', // foreign key attribute that is shown to user
            'pivot' => true,
        ]);
    }

    protected function storeSKUProduct(SKUProductRequest $request)
    {
        CRUD::setValidation(SKUProductRequest::class);
        $default_locale = config('app.locale');

        $request->merge([
            'product_name' => json_encode([
                $default_locale => $request->product_name,
            ], JSON_THROW_ON_ERROR),
            'description' => json_encode([
                $default_locale => $request->description,
            ], JSON_THROW_ON_ERROR),
        ]);
        $productData = $this->prepareData($request);
        $productData['user_id'] = backpack_auth()->id();
        $productData['created_at'] = Carbon::now();
        $productData['updated_at'] = Carbon::now();

        $productID = DB::table('products')->insertGetId($productData);
        $this->createOrUpdateSKUProductImage($request->main, $productID);
        $this->createOrUpdateSKUProductAttribute($request, $productID);

        return response()->json([
            'success' => true,
        ]);
    }

    /**
     * @throws JsonException
     */
    protected function updateSKUProduct(SKUProductRequest $request)
    {
        $product = Product::where('id', $request->id)->with('productImage')->firstOrFail();
        $productData = $this->prepareData($request);
        $productData['sku_id'] = $request->parent_id.'-'.$product->id;
        $product->update($productData);
        $product->parentProducts()->attach($request->parent_id);
        $this->createOrUpdateSKUProductImage($request->main, $request->id);
        $this->createOrUpdateSKUProductAttribute($request, $request->id);

        return response()->json([
            'success' => true,
        ], 200);
    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @throws JsonException
     */
    protected function setupUpdateOperation()
    {
        $this->crud->setUpdateContentClass('col-md-12');

        $product = $this->crud->getCurrentEntry();
        $this->redirectUriIfSKUProduct($product, 'edit');
        // SKU default attributes set functionality
        $sku_default_attributes_ids = is_array($product->sku_default_attributes)
            ? $product->sku_default_attributes
            : (! empty($product->sku_default_attributes) ? json_decode($product->sku_default_attributes) : []);
        if (count($sku_default_attributes_ids) > 0) {
            $sku_default_attributes = ProductTrait::getSkuDefaultAttributes($sku_default_attributes_ids);
            $this->data['sku_default_attributes'] = $sku_default_attributes;
        } else {
            $this->data['sku_default_attributes'] = [];
        }
        $this->data['product_documents'] = DocumentTypeProduct::where('product_id', $product->id)
            ->orderBy('order', 'ASC')
            ->get()
            ->transform(function ($item) {
                $documentType = DocumentType::find($item->document_type_id);
                if (! empty($documentType)) {
                    $media_type = $documentType->media_type;
                    $item->file_type = DocumentType::ACCEPT_FILE_TYPES[$media_type] ?? null;
                    $item->media_type = $media_type;
                }

                return $item;
            });

        $this->crud->setUpdateView('backend::pages.product.create');
        $this->setupCreateOperation();
    }

    protected function setupShowOperation()
    {
        $this->crud->set('show.setFromDb', false);

        $product = $this->crud->getCurrentEntry();
        $this->redirectUriIfSKUProduct($product, 'view');

        CRUD::addcolumn([
            'name' => 'product_type',
            'label' => 'Product Type',
            'type' => 'custom_html',
            'value' => function ($entry) {
                return ucfirst($entry->product_type);
            },
        ]);
        CRUD::addcolumn([
            'name' => 'product_code',
            'label' => 'Product Code',
        ]);
        CRUD::addcolumn([
            'name' => 'prop65_message',
            'label' => 'Prop 65 Message',
        ]);
        CRUD::addColumn([
            'name' => 'brand_id',
            'label' => 'Brand Name',
            'type' => 'custom_html',
            'value' => fn ($entry) => $entry->brand?->title ?? '-',
        ]);
        CRUD::addcolumn([
            'name' => 'product_name',
            'label' => 'Product Name',
            'type' => 'custom_html',
            'value' => function ($model) {
                return $model->local_product_name;
            },
        ]);

        if ($product->product_type !== 'bundle') {
            CRUD::addcolumn([
                'name' => 'has_sku',
                'label' => 'Has SKU',
                'type' => 'boolean',
            ]);
        }
        CRUD::addcolumn([
            'name' => 'productImage.thumbnail',
            'label' => 'Thumbnail',
            'type' => 'image',
            'width' => '120px',
            'height' => 'auto',
        ]);
        CRUD::addcolumn([
            'name' => 'productImage.main',
            'label' => 'Main Image',
            'type' => 'image',
            'width' => '120px',
            'height' => 'auto',
        ]);

        CRUD::addcolumn([
            'name' => 'productImage.additional',
            'label' => 'Additional',
            'type' => 'multiple_images',
            'width' => '120px',
            'height' => 'auto',
        ]);
        CRUD::addcolumn([
            'name' => 'asin',
            'label' => 'ASIN',
        ]);
        CRUD::addcolumn([
            'name' => 'ean_number',
            'label' => 'EAN Number',
        ]);
        CRUD::addcolumn([
            'name' => 'gtin_number',
            'label' => 'GTIN Number',
        ]);
        CRUD::addcolumn([
            'name' => 'upc_number',
            'label' => 'UPC Number',
        ]);
        CRUD::addcolumn([
            'name' => 'msrp',
            'label' => 'MSRP',
        ]);
        CRUD::addcolumn([
            'name' => 'description',
            'label' => 'Product Description',
            'type' => 'custom_html',
            'value' => function ($model) {
                return $model->description;
            },
        ]);
        CRUD::addcolumn([
            'name' => 'created_at',
            'label' => 'Created At',
            'type' => 'datetime',
        ]);

        CRUD::addcolumn([
            'name' => 'update_at',
            'label' => 'Last Updated At',
            'type' => 'datetime',
        ]);

        CRUD::removeButtons(['delete']);
        CRUD::addButtonFromModelFunction('line', 'cancel', 'cancel', 'beginning');
        if (backpack_user()->can('product.publish')) {
            CRUD::addButtonFromModelFunction('line', 'status_publish', 'statusPublishExit', 'beginning');
        }
    }

    private function senitizePivotData(&$pivot)
    {
        $pivot['productAttributes'] = array_filter($pivot['productAttributes'], function ($attribute) {
            return isset($attribute['attribute_value']) && $attribute['attribute_value'];
        });
    }

    /**
     * Update attribute_product & attribute_product_classification table
     */
    private function updatePivot($pivot, $id, $classification_id)
    {
        app()->setLocale(request()->getLocale() ?? config('app.locale'));
        $this->senitizePivotData($pivot);

        // $this->crud->entry->attributes()->sync($pivot['productAttributes']);
        AttributeProduct::query()->where('product_id', $id)->delete();
        foreach ($pivot['productAttributes'] as $productAttribute) {
            $where = ['product_id' => $id, 'attribute_id' => $productAttribute['attribute_id']];
            $newProductAttribute = array_merge($productAttribute, $where);

            AttributeProduct::query()->updateOrCreate($where, $newProductAttribute);
            // $attributeProduct->update($productAttribute);
        }

        // $this->crud->entry->productClassification->attributes()->sync($pivot['optionalSelectedAttributes']);
        if (config('amplify.pim.use_classifications')) {
            foreach ($pivot['optionalSelectedAttributes'] as $optional) {
                $where = [
                    'classification_id' => $optional['classification_id'] ?? $classification_id,
                    'attribute_id' => $optional['attribute_id'],
                ];
                $optional['updated_at'] = now();
                $optional['created_at'] = now();
                $optional['boolean_titles'] = isset($optional['boolean_titles'])
                    ? json_encode($optional['boolean_titles'])
                    : null;
                $optional['enums'] = isset($optional['enums'])
                    ? json_encode($optional['enums'])
                    : null;

                DB::table('attribute_product_classification')->updateOrInsert($where, $optional);
            }
        }

        foreach ($pivot['productOptions'] as $productOption) {
            $data = [
                'product_id' => $id,
                'option_id' => $productOption['option_id'],
            ];

            $optionProduct = OptionProduct::query()->updateOrInsert($data, $productOption);
        }
    }

    private function updateGroupPricePivot($customer_group_price, $product_id)
    {
        $customerGroupPricePivotData = [];
        if (is_array($customer_group_price) && count($customer_group_price) > 0) {
            foreach ($customer_group_price as $cgp) {
                $customerGroupPricePivotData[] = [
                    'customer_group_id' => $cgp['id'],
                    'product_id' => $product_id,
                    'price' => $cgp['price'],
                ];
            }
        }
        $productInstance = Product::findOrFail($product_id);
        $productInstance->CustomerGroupPrice()->detach();
        $productInstance->CustomerGroupPrice()->attach($customerGroupPricePivotData);
    }

    private function redirectUriIfSKUProduct($product, $action): void
    {
        if ($product->parent_id !== null) {
            $redirect_uri = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on'
                    ? 'https'
                    : 'http')."://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
            $uri = explode('/', $redirect_uri);
            array_splice($uri, -2);

            $query = [
                'simple_product_id' => $product->id,
                'activeTab' => 'SKUS',
                'action' => $action,
            ];
            $query = array_merge(request()->all(), $query);
            $uri = implode('/', $uri).'/'.$product->parent_id.'/edit?'.http_build_query($query);
            header('Location: '.$uri);
            exit();
        }
    }

    private function prepareData($request)
    {
        return [
            'sku_id' => $request->sku_id,
            'parent_id' => $request->parent_id,
            'product_type' => $request->product_type,
            'product_name' => $request->product_name,
            'product_code' => $request->product_code,
            'prop65_message' => $request->prop65_message,
            'brand_name' => $request->brand_name,
            'description' => $request->description,
            'sku_part_number' => $request->sku_part_number,
            'selling_price' => $request->selling_price,
            'min_order_qty' => $request->min_order_qty,
            'qty_interval' => $request->qty_interval,
            'specifications' => $request->specifications,
        ];
    }

    private function setLocalData($newDataField, $existingDataField, $locale)
    {
        $dataField = (array) json_decode($existingDataField);
        $dataField[$locale] = $newDataField;

        return json_encode($dataField);
    }

    /**
     * @throws JsonException
     */
    private function createOrUpdateSKUProductAttribute($request, $productID)
    {
        if (count($request->productAttributeValues) > 0) {
            $removeExtraAttribute = AttributeProduct::where('product_id', $productID)
                ->whereNotIn('attribute_id', array_column($request->productAttributeValues, 'attribute_id'));
            if ($removeExtraAttribute->get()->count() > 0) {
                $removeExtraAttribute->delete();
            }

            foreach ($request->productAttributeValues as $productAttribute) {
                $where = ['product_id' => $productID, 'attribute_id' => $productAttribute['attribute_id']];
                $attributeProduct = DB::table('attribute_product')->where($where)->first();
                if (! empty($attributeProduct)) {
                    $attributeValue =
                        $this->setLocalData($productAttribute['attribute_value'], $attributeProduct->attribute_value, $request->locale);
                    DB::table('attribute_product')->where($where)->update([
                        'attribute_value' => $attributeValue,
                        'updated_at' => Carbon::now(),
                    ]);
                } else {
                    $default_locale = config('app.locale');
                    $attributeValue = json_encode([
                        $default_locale => $productAttribute['attribute_value'],
                    ], JSON_THROW_ON_ERROR);

                    DB::table('attribute_product')->insert([
                        'attribute_id' => $productAttribute['attribute_id'],
                        'product_id' => $productID,
                        'attribute_value' => $attributeValue,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);
                }
            }
        }
    }

    private function createOrUpdateSKUProductImage($image, $productID)
    {
        $isImageExist = ProductImage::where('product_id', $productID)->first();
        if (! empty($isImageExist)) {
            ProductImage::where('product_id', $productID)->update([
                'main' => $image,
                'updated_at' => Carbon::now(),
            ]);
        } else {
            ProductImage::insert([
                'product_id' => $productID,
                'main' => $image,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }

    /**
     * @return array|array[]|null[]
     */
    public function runDataTransformation($requestData): array
    {
        /* Creating a backup of $requestData */
        $requestDataBackup = $requestData;

        /* Preparing data for Data Transformation */
        $preparedData = $this->prepareDataForDataTransformation($requestData);

        /* Making data transformation */
        $transformedData = $this->makeDataTransformation($preparedData, $requestDataBackup['categories']);

        /* Making $transformedData compatible with $requestData and return the final transformed data array */
        return $this->makeTransformedDataCompatibleWithRequestData($transformedData, $requestDataBackup);
    }

    private function prepareDataForDataTransformation($requestData): array
    {
        /* Prepare category names from array of ids to array of category_names */
        $categoryIds = $requestData['categories'] ?? [];
        $categories = count($categoryIds) > 0
            ? collect(Category::query()
                ->whereIn('id', $categoryIds)
                ->get()
                ->toArray())
                ->pluck('label')
                ->toArray()
            : [];

        /* Prepare productClassification name from id to name */
        $productClassificationId = $requestData['product_classification_id'] ?? null;
        $productClassification = ! empty($productClassificationId)
            ? collect(ProductClassification::query()
                ->where('id', $productClassificationId)
                ->first()
                ->toArray())['label']
            : null;

        /* Prepare product attribute as name and value pair */
        $productAttributes = [];
        if (
            isset($requestData['pivot']['productAttributes'])
            && count($requestData['pivot']['productAttributes']) > 0
        ) {
            collect($requestData['pivot']['productAttributes'])->map(function ($item) use (&$productAttributes) {
                $productAttributes[] = [
                    'name' => Attribute::query()->find($item['attribute_id'])->name,
                    'value' => $item['attribute_value'],
                ];
            });
        }

        /* Removing some unnecessary fields from $requestData before preparing $fields for 'Data Transformations' */
        unset(
            $requestData['categories'],
            $requestData['product_classification_id'],
            $requestData['customer_group_price'],
            $requestData['pivot'],
            $requestData['products_list'],
            $requestData['attributes'],
            $requestData['classificationChanged'],
            $requestData['options'],
            $requestData['active_tab'],
        );

        /* Prepare fields of all $requestData as name, value pair */
        $fields = [];
        foreach ($requestData as $key => $value) {
            $fields[] = [
                'name' => $key,
                'value' => $value,
            ];
        }

        return [
            'script' => [],
            'fields' => $fields,
            'attributes' => $productAttributes,
            'variables' => [],
            'categories' => $categories,
            'productClassification' => $productClassification,
        ];
    }

    private function makeDataTransformation(array $preparedData, array $inCategories = []): array
    {
        collect(
            getDataTransformations('Products', $inCategories, 'save', 'array')->toArray()
        )->map(function ($item) use (&$preparedData) {
            /* Preparing script */
            $preparedData['script'] = preg_split("/\r\n|\n|\r/", $item['scripts']);
            /* Make data-transformation using 'ExecuteScriptService' */
            $executeScriptService = new ExecuteScriptService;
            $responseData = $executeScriptService->validateScript($preparedData);
            /* Updating $preparedData for next transformation */
            $preparedData = [
                'fields' => $responseData['fields'],
                'attributes' => $responseData['attributes'],
                'variables' => $responseData['variables'],
                'categories' => $responseData['categories'],
                'productClassification' => $responseData['productClassification'],
            ];
        });

        return $preparedData;
    }

    /**
     * @return array|array[]|null[]
     */
    private function makeTransformedDataCompatibleWithRequestData(array $transformedData, $requestDataBackup): array
    {
        /* Making $transformedData['fields'] compatible with $requestData format */
        $productFields = [];
        collect($transformedData['fields'])->map(function ($item) use (&$productFields) {
            $productFields[$item['name']] = $item['value'];
        });

        /* Making $transformedData['attributes'] compatible with $requestData format */
        $productAttributes = [];
        $productAttributesWithPivotStructure = [];
        collect($transformedData['attributes'])->map(function ($item) use (&$productAttributes, &$productAttributesWithPivotStructure) {
            $matchedAttributes = Attribute::query()
                ->where('name', 'like', '%'.$item['name'].'%')
                ->get();

            if (count($matchedAttributes) > 0) {
                if (count($matchedAttributes) === 1) {
                    $attributeData = $matchedAttributes->toArray()[0];
                } else {
                    $attributeData = collect($matchedAttributes->toArray())
                        ->where('local_name', $item['name'])
                        ->first();
                }

                if (! empty($attributeData)) {
                    $productAttributes[] = $attributeData['id'];
                    $productAttributesWithPivotStructure[] = [
                        'attribute_id' => $attributeData['id'],
                        'attribute_value' => $item['value'],
                    ];
                }
            } else {
                $attribute = Attribute::create([
                    'name' => $item['name'],
                    'type' => 'text',
                    'is_new' => 1,
                ]);

                $productAttributes[] = $attribute['id'];
                $productAttributesWithPivotStructure[] = [
                    'attribute_id' => $attribute['id'],
                    'attribute_value' => $item['value'],
                ];
            }
        });

        /* Making $transformedData['categories'] compatible with $requestData format */
        $categoryIds = [];
        collect($transformedData['categories'])->map(function ($item) use (&$categoryIds) {
            $matchedCategories = Category::query()
                ->where('category_name', 'like', '%'.$item.'%')
                ->get();
            if (count($matchedCategories) > 0) {
                $category = collect($matchedCategories->toArray())->where('label', $item)->first();
                $categoryIds[] = $category['id'];
            }
        });

        /* Making $transformedData['productClassification'] compatible with $requestData format */
        $productClassificationId = null;
        $matchedProductClassification = ProductClassification::query()
            ->where('title', 'like', '%'.$transformedData['productClassification'].'%')
            ->get();
        if (count($matchedProductClassification) > 0) {
            $productClassificationData = collect($matchedProductClassification->toArray())->first();
            $productClassificationId = $productClassificationData['id'];
        }

        /* Merging formatted data with $requestData */
        $requestDataBackup = array_merge($requestDataBackup, $productFields);
        $requestDataBackup['pivot']['productAttributes'] = $productAttributesWithPivotStructure;

        return array_merge($requestDataBackup, [
            'attributes' => $productAttributes,
            'categories' => $categoryIds,
            'product_classification_id' => $productClassificationId,
        ]);
    }

    private function updateDocuments($productDocuments, $productId): void
    {
        if (count($productDocuments) > 0) {
            DocumentTypeProduct::query()->where('product_id', $productId)->delete();

            $productDocuments = collect($productDocuments)->map(function ($item) use ($productId) {
                return [
                    'product_id' => $productId,
                    'document_type_id' => $item['document_type_id'],
                    'order' => $item['order'],
                    'file_path' => isset($item['file_path']) ? $item['file_path'] : null,
                    'content' => isset($item['content']) ? $item['content'] : null,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
            });

            DocumentTypeProduct::insert($productDocuments->toArray());
        }
    }

    public function skuReorder(Request $request)
    {
        $productInstance = new Product;
        $index = 'id';

        \Batch::update($productInstance, $request->reorder, $index);

        return response()->json([
            'message' => 'Successfully updated.',
        ], 200);
    }

    public function removeSku($parentId, $skuId)
    {
        SkuProduct::where([
            'parent_id' => $parentId,
            'sku_id' => $skuId,
        ])->delete();
    }

    public function updatePivotTable(Request $request): JsonResponse
    {
        app()->setLocale($request->input('locale', config('app.locale')));

        foreach ($request->except('locale') as $item) {
            $where = collect($item)->only(['product_id', 'attribute_id'])->toArray();
            $item['created_at'] = now();
            $item['updated_at'] = now();

            $attributeProduct = AttributeProduct::query()->where($where)->first();
            $attributeProduct->update($item);
        }

        return response()->json(['message' => 'Success']);
    }

    public function save(ProductRequest $request)
    {
        DB::beginTransaction();

        try {
            $productId = DB::table('products')
                ->insertGetId(array_merge($request->product, ['user_id' => backpack_auth()->id()]));
            ProductImage::insert(array_merge($request->product_image, ['product_id' => $productId]));
            $product = Product::find($productId);
            // $product->attributes()->sync($request->attributes);
            $product->categories()->sync($request->categories);
            /*DB::insert(...);
            DB::insert(...);*/

            DB::commit();
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            // something went wrong
        }

        // dd($request->all());
    }

    public function statusUpdate(Product $product, $status, $previous_status): RedirectResponse
    {
        $product->published_at = $status === 'published' ? now() : null;
        $product->archived_at = $status === 'archived' ? now() : null;
        $product->previous_status = $previous_status;
        $product->status = $status;

        $product_code = explode('-archived-', $product->product_code)[0];

        switch ($status) {
            case 'archived':
                $lastProduct = Product::where('product_code', 'like', $product_code.'-archived-'.'%')->latest()->first();
                $serial = $lastProduct ? explode('-archived-', $lastProduct->product_code)[1] : 0;
                $product->product_code = $product_code.'-archived-'.($serial + 1);
                break;
            default:
                $product->product_code = $product_code;
                $existingProduct = Product::where('product_code', $product->product_code)->first();
                if ($existingProduct) {
                    Alert::warning('Product code already exists')->flash();

                    return Redirect::route('product.index');
                }
        }

        $product->save();

        Alert::success('Product status updated')->flash();

        return Redirect::route('product.index');
    }

    public function clone($id)
    {

        $this->crud->hasAccessOrFail('clone');

        $oldEntry = $this->crud->model->findOrFail($id);
        $prev_attribute = json_decode($oldEntry->sku_default_attributes);

        if (! empty($oldEntry->product_classification_id)) {
            $checkProdcutClsExist = ProductClassification::find($oldEntry->product_classification_id);
            if (! $checkProdcutClsExist) {
                return response()->json('Existing classification is archived. Update the classification', 500);
            }
            $fetch_attribute = $this->fetchAttribute($oldEntry->product_classification_id, $id);
        }

        $new_attribute = [];
        if (! empty($fetch_attribute)) {
            $new_attribute = $fetch_attribute['productClassification']->pluck('id')->toArray();
        }

        if ($prev_attribute != null) {
            $mergedArray = array_merge($prev_attribute, $new_attribute);
            $new_attribute = array_unique($mergedArray);
        }

        if ($oldEntry->has_sku == 0) {
            $clonedEntry = $oldEntry->replicate(['product_code', 'has_sku', 'sku_id', 'product_slug', 'sku_default_attributes']);
            $clonedEntry->product_code = 'master-'.$oldEntry->product_code;
            $clonedEntry->has_sku = true;
            $clonedEntry->sku_id = null;
            $clonedEntry->sku_default_attributes = json_encode($new_attribute);
            $clonedEntry->product_slug = 'master-'.$oldEntry->product_slug;

            $existingProduct = Product::where('product_code', $clonedEntry->product_code)->first();
            if ($existingProduct) {
                if ($existingProduct->archived_at !== null) {
                    return response()->json('This product previous master copy exits. Please check the archive and rename the product code.', 500);
                } else {
                    return response()->json('This product previous master copy exits. Please check it and rename the product code.', 500);
                }
            }
            $clonedEntry->push();

            // Category.
            $categories = $oldEntry->categories()->pluck('category_id');
            if ($categories->isNotEmpty()) {
                $clonedEntry->categories()->sync($categories);
            }

            $clonedEntry->skuProducts()->attach($oldEntry->id);
            $oldEntry->update(['sku_id' => $clonedEntry->id.'-'.$oldEntry->id]);

            return 'true';
        } else {
            return response()->json('This product is already a master product', 500);
        }
    }
}
