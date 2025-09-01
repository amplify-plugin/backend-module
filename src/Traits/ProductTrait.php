<?php

namespace Amplify\System\Backend\Traits;

use Amplify\System\Backend\Http\Resources\ProductItemsResources;
use App\Http\Controllers\Admin\ProductCrudController;
use App\Http\Requests\ProductRequest;
use App\Models\Attribute;
use App\Models\Category;
use App\Models\CategoryProduct;
use App\Models\Option;
use App\Models\Product;
use App\Models\ProductClassification;
use App\Models\SkuProduct;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use stdClass;

trait ProductTrait
{
    private array $searches = [];

    private array $searchCategory = [];

    private array $finalCategoriesArray = [];

    public function getTabs(): array
    {
        return $this->tabs;
    }

    public function setTabs(array $tabs = []): void
    {
        if (array_search($this->crud->getCurrentOperation(), ['update', 'create']) !== false) {
            $tabs = collect($this->crud->settings()[$this->crud->getCurrentOperation().'.fields'])
                ->keyby('tab')
                ->keys()
                ->map(function ($key) {
                    return Str::slug($key, '-');
                })
                ->reject(function ($key) {
                    return $key == '';
                })
                ->map(function ($key) {
                    return $key;
                });
        }
        $this->tabs = collect($tabs);
    }

    public function getCurrentTab(): string
    {
        return $this->current_tab;
    }

    public function setCurrentTab(string $current_tab): void
    {
        $this->current_tab = $current_tab;
    }

    /**
     * @return Builder[]|EloquentCollection
     */
    public function fetchCategory()
    {
        return Category::query()->whereNull('parent_id')->get()
            ->sortBy(fn ($item) => $item->getLabelAttribute(), SORT_NATURAL | SORT_FLAG_CASE)
            ->values();
    }

    public function fetchCategoryTree(): array
    {
        $categories = Category::query()->whereNull('parent_id')->with('children')->get()
            ->sortBy(fn ($item) => $item->getLabelAttribute(), SORT_NATURAL | SORT_FLAG_CASE)
            ->values()
            ->toArray();

        array_unset_recursive($categories, 'children');

        return $categories;
    }

    /**
     * @return array|Builder|Builder[]|EloquentCollection|Model|null
     */
    public function fetchProductClassification()
    {
        $model = new ProductClassification;

        if ($id = request()->id) {
            return $model->query()->findOrFail($id);
        }

        $productClassifications = $model->query()
            ->whereNull('parent_id')
            ->with('children')
            ->get()
            ->sortBy(fn ($item) => $item->getLabelAttribute(), SORT_NATURAL | SORT_FLAG_CASE)
            ->values()
            ->toArray();

        array_unset_recursive($productClassifications, 'children');

        return $productClassifications;
    }

    /**
     * @return array
     */
    public function fetchClassificationProducts(): JsonResponse
    {
        $search = trim(request()->search);
        $paginatePerPage = request()->pagination['resultsPerPage'] ?? '';
        $product = Product::query()->with('productImage')
            ->where('product_classification_id', request()->id);

        if (request()->filled('search')) {
            $product = $product->where('product_name', 'like', '%'.$search.'%');
        }

        return response()->json($product->paginate($paginatePerPage));
    }

    public function fetchAttribute($classificationId = null, $productId = null): array
    {
        $productId = $productId == null ? request()->id : $productId;
        $classificationId = $classificationId == null ? request()->classification_id : $classificationId;

        $attributes['productClassification'] = ! $classificationId ? [] : $this->getAttributeValueFromMap(
            ProductClassification::query()
                ->findOrFail($classificationId)
                ->attributes()
                ->get()
        ) ?? [];

        $attributes['product'] = $productId
            ? Product::findOrFail($productId)->attributes()->get()->map(function ($attribute) {
                $productClassification = $this->getAttributeProductClassification($attribute);
                $productClassificationPivot = $productClassification->pivot ?? [];
                $pivot = $attribute->pivot ?? new stdClass;
                $boolean_titles = json_decode($productClassificationPivot->boolean_titles ?? '{}');

                return array_merge(
                    $attribute->toArray(),
                    [
                        'attribute_value' => $this->getLocaleValue($pivot->attribute_value ?? ''),
                        'local_attribute_value' => $this->getLocaleValue($pivot->attribute_value ?? ''),
                    ],
                    [
                        'enums' => $this->decorateEnums($productClassificationPivot->enums
                            ?? '[]'),
                        'min' => $productClassificationPivot->min ?? '',
                        'max' => $productClassificationPivot->max ?? '',
                        'boolean_true' => $boolean_titles->true ?? '',
                        'boolean_false' => $boolean_titles->false ?? '',
                        'is_required' => $productClassificationPivot->is_required ?? 0,
                        'is_multiple' => $productClassificationPivot->is_multiple ?? false,
                    ],
                );
            })->values() ?? [] : [];

        $attributes['all'] = $this->fetchAttributes();

        return $attributes;
    }

    /**
     * @return Builder[]|EloquentCollection
     */
    public function fetchAttributes()
    {
        return Attribute::query()
            ->get()
            ->sortBy(fn ($item) => $item->getLocalNameAttribute(), SORT_NATURAL | SORT_FLAG_CASE)
            ->values()
            ->map(function ($attribute) {
                $productClassification = $this->getAttributeProductClassification($attribute);
                $productClassificationPivot = $productClassification->pivot ?? [];
                $boolean_titles = json_decode(
                    $productClassificationPivot->boolean_titles ?? '{}'
                );

                return collect(array_merge(
                    $attribute->toArray(),
                    [
                        'attribute_value' => '',
                        'local_attribute_value' => '',
                    ],
                    [
                        'enums' => $this->decorateEnums($productClassificationPivot->enums ?? '[]'),
                        'min' => $productClassificationPivot->min ?? '',
                        'max' => $productClassificationPivot->max ?? '',
                        'boolean_true' => $boolean_titles->true ?? '',
                        'boolean_false' => $boolean_titles->false ?? '',
                        'is_required' => $productClassificationPivot->is_required ?? 0,
                    ]
                ));
            });
    }

    /**
     * @return stdClass
     */
    public function getAttributeProductClassification($attribute)
    {
        return $attribute->productClassifications()
            ->where('classification_id', request()->classification_id)
            ->first() ?? new stdClass;
    }

    /**
     * @return mixed
     */
    public function getAttributeValueFromMap($attributes)
    {
        return $attributes->map(function ($attribute) {
            $pivot = $attribute->pivot;
            $boolean_titles = json_decode(
                $pivot->boolean_titles ?? '{}'
            );

            return collect(array_merge(
                $attribute->toArray(),
                [
                    'attribute_value' => '',
                    'local_attribute_value' => '',
                ],
                [
                    'enums' => $this->decorateEnums($pivot->enums ?? '[]'),
                    'min' => $pivot->min ?? '',
                    'max' => $pivot->max ?? '',
                    'boolean_true' => $boolean_titles->true ?? '',
                    'boolean_false' => $boolean_titles->false ?? '',
                    'is_required' => $pivot->is_required ?? 0,
                    'is_multiple' => $pivot->is_multiple ?? false,
                ],
            ));
        });
    }

    public function getFile($image_type_aux, $image_parts, $folderPath, string $productCodeSlugify, string $folderPathWithProductCodeDir): string
    {
        $image_type = $image_type_aux;
        $image_base64 = base64_decode($image_parts);
        $file = $folderPath.'/'.$productCodeSlugify.'.'.$image_type;

        // If file exists, then get count and rename it
        $file = $this->checkIfFileExistsAndRename(
            $file,
            $productCodeSlugify,
            $folderPathWithProductCodeDir,
            $image_type
        );

        if ($file && ! File::isDirectory($folderPathWithProductCodeDir)) {
            File::makeDirectory($folderPathWithProductCodeDir, 0777, true, true);
        }

        file_put_contents($file, $image_base64);

        return $file;
    }

    private function nextCurrentTab(): void
    {
        $this->tabs->map(function ($tab, $index) {
            if ($tab == $this->current_tab) {
                $this->next_tab = ($this->tabs->values())[$index + 1] ?? '';
            }
        });
    }

    public function uploadImage(Request $request): string
    {
        if ($request->image) {
            $folderPath = $request->directory;
            $productCodeSlugify = Str::lower(Str::slug($request->productCode));
            $folderPathWithProductCodeDir = $folderPath.'/'.repeatString($productCodeSlugify, true);
            $image_parts = explode(';base64,', $request->image);
            $image_type_aux = explode('image/', $image_parts[0]);
            $file = $this->getFile(
                $image_type_aux[1],
                $image_parts[1],
                $folderPath,
                $productCodeSlugify,
                $folderPathWithProductCodeDir
            );
        }

        return $file ?? '';
    }

    public function uploadDocument(Request $request): string
    {
        if ($request->document) {
            $folderPath = $request->directory;
            $productCodeSlugify = Str::lower(Str::slug($request->productCode));
            $folderPathWithProductCodeDir = $folderPath.'/'.$productCodeSlugify;
            $document_parts = explode(';base64,', $request->document);
            $document_type = $request->fileExtension;
            $file = $this->getFile(
                $document_type,
                $document_parts[1],
                $folderPath,
                $productCodeSlugify,
                $folderPathWithProductCodeDir
            );
        }

        return $file ?? '';
    }

    public function checkIfFileExistsAndRename(string $file, string $productCode, $folderPathWithProductCodeDir, $image_type): string
    {
        if (
            File::isDirectory($folderPathWithProductCodeDir)
            && ($count = count(glob(public_path($folderPathWithProductCodeDir).'/*'.$productCode.'*'))) > 0
        ) {
            $file = $folderPathWithProductCodeDir.'/'.$productCode.'-'.$count.'.'.$image_type;
        } else {
            $file = $folderPathWithProductCodeDir.'/'.$productCode.'.'.$image_type;
        }

        return $file;
    }

    /**
     * @return mixed
     */
    public function removeImage(Request $request)
    {
        if (! empty($request->product_id)) {
            if (! empty($request->url) && File::exists(public_path($request->url))) {
                File::delete(public_path($request->url));
            }

            DB::table('product__images')
                ->where('product_id', $request->product_id)
                ->where($request->type, $request->url)
                ->update([$request->type => null]);
        }

        return $request->url;
    }

    /**
     * @return mixed
     */
    public function removeDocument(Request $request)
    {
        if (! empty($request->url) && File::exists(public_path($request->url))) {
            File::delete(public_path($request->url));
        }
        DB::table('document_type_product')
            ->where('product_id', $request->product_id)
            ->where('document_type_id', $request->document_type_id)
            ->delete();

        return $request->url;
    }

    private function decorateEnums($enums): Collection
    {
        return collect(json_decode($enums))
            ->map(function ($enum) {
                return ['name' => $enum, 'unique_slug' => Str::uuid()];
            });
    }

    /**
     * @return false|mixed|string
     */
    private function getLocaleValue(string $attribute_value)
    {
        $default = config('app.locale');
        $locale = request()->locale ?? $default;
        $attribute_value_json = json_decode($attribute_value, true);

        return $attribute_value_json && $attribute_value != $attribute_value_json
            ? ($attribute_value_json[$locale] ?? current($attribute_value_json))
            : $attribute_value;
    }

    public function publish(ProductRequest $request)
    {
        dd($request->all());
    }

    /**
     * @param  string  $site_search
     */
    private function getSiteSearchKeys($site_search = ''): ProductCrudController
    {
        // $site_search     = '-laptop/-2laptop/PC-Laptops/PC-Laptops/Brand:Acer/Brand:Acer';
        $site_search_arr = explode('/', $site_search);
        $search_string = null;
        $brands = $categories = [];

        foreach ($site_search_arr as $site_search) {
            switch ($site_search) {
                case strpos($site_search, '-') === 0:
                    $search_string = $search_string ?? substr($site_search, 1);
                    break;
                case strpos($site_search, 'Brand:') === 0:
                    array_push($brands, substr($site_search, 6));
                    break;
                default:
                    array_push($categories, $site_search);
                    break;
            }
        }

        $categories = array_unique($categories);
        $brands = array_unique($brands);

        $this->searches = compact('search_string', 'categories', 'brands');

        return $this;
    }

    private function getQueryBuild($query): Builder
    {
        if (! empty($this->searches['search_string']) && count($this->searches['categories']) > 0) {
            $search_string = $this->searches['search_string'];
            $categories = $this->searches['categories'];
            $query = $query->where('product_name', 'like', '%'.$search_string.'%');
            $getCategoryIds = $this->getCategoriesByCategoryCode($categories);
            $this->searchCategory = $getCategoryIds->toArray();
            $productIds = CategoryProduct::where('category_id', end($this->searchCategory))
                ->pluck('product_id');
            $query = $query->whereIn('id', $productIds);

            $this->finalCategoriesArray = collect(Category::query()
                ->where('parent_id', end($this->searchCategory))
                ->whereHas('products')
                ->withCount('products')
                ->get())
                ->map(function ($category) {
                    $item['ids'] = $category->id;
                    $item['name'] = $category->category_name;
                    $item['nodeString'] = $category->category_code;
                    $item['productCount'] = $category->products_count;

                    return $item;
                })->toArray();
        } elseif (! empty($this->searches['search_string'])) {
            $search_string = $this->searches['search_string'];
            // Get products
            $query = $query->whereHas('categories')
                ->where('product_name', 'like', '%'.$search_string.'%');
            // Get categories
            $productIds = Product::where('product_name', 'like', '%'.$search_string.'%')
                ->pluck('id');
            $getCategoryIds = CategoryProduct::whereIn('product_id', $productIds)
                ->pluck('category_id');
            $this->searchCategory = $getCategoryIds->toArray();
            $this->finalCategoriesArray = collect(Category::query()
                ->whereIn('id', $this->searchCategory)
                ->with('products', function ($query) use ($search_string) {
                    $query->where('products.product_name', 'LIKE', '%'.$search_string.'%');
                })
                ->get())
                ->map(function ($category) {
                    $item['ids'] = $category->id;
                    $item['name'] = $category->category_name;
                    $item['nodeString'] = $category->category_code;
                    $item['productCount'] = $category->products->count();

                    return $item;
                })->toArray();
        } elseif (count($this->searches['categories']) > 0) {
            $getCategoryIds = $this->getCategoriesByCategoryCode($this->searches['categories']);
            $this->searchCategory = $getCategoryIds->toArray();
            $productIds = CategoryProduct::where('category_id', end($this->searchCategory))
                ->pluck('product_id');
            $query = $query->whereIn('id', $productIds);

            $this->finalCategoriesArray =
                collect(Category::query()
                    ->where('parent_id', end($this->searchCategory))
                    ->whereHas('products')
                    ->withCount('products')
                    ->get())
                    ->map(function ($category) {
                        $item['ids'] = $category->id;
                        $item['name'] = $category->category_name;
                        $item['nodeString'] = $category->category_code;
                        $item['productCount'] = $category->products_count;

                        return $item;
                    })->toArray();
        }

        return $query;
    }

    /**
     * @return Builder[]|EloquentCollection
     */
    public function fetchProductsList()
    {
        $product = request()->returnSKUS === 'true' ? Product::query() : Product::query()->doesntHave('parentProducts');
        $paginatePerPage = isset(request()->resultsPerPage) ? request()->resultsPerPage : '';

        if ((request()->categoryProduct ?? false) == 'true') {
            $product = $this->getSiteSearchKeys(request('site_search') ?? '')->getQueryBuild($product);
            $paginationData = $product->with('productImage')->paginate($paginatePerPage);
            $mappedProductData = $paginationData->map(fn ($q) => $q->append('product_id'));
            $paginationData = $paginationData->toArray();
            unset($paginationData['data']);
            $categories = $this->finalCategoriesArray;
            $product = compact('paginationData', 'mappedProductData', 'categories');
        } else {
            $product = $product->where('id', '!=', request()->id)->get(['id', 'product_code', 'product_name']);
        }

        return $product;
    }

    /**
     * @return Builder|Builder[]|EloquentCollection|Model|null
     */
    public function fetchProductById()
    {
        $select = request()->selectAllFieldsWithAttributes
            ? '*'
            : ['id', 'product_code', 'product_name', 'product_classification_id'];

        $with = request()->selectAllFieldsWithAttributes
            ? ['productImage', 'attributes', 'productClassification.attributes', 'categories']
            : ['productImage'];

        $product = Product::query()
            ->select($select)
            ->with($with)
            ->findOrFail(request()->id);

        if (request()->productClassificationId) {
            $product->product_classification_id = request()->productClassificationId;
            $product->save();
        }

        if (request()->categoryId) {
            $where = [
                'product_id' => $product->id,
                'category_id' => request()->categoryId,
            ];

            CategoryProduct::query()->firstOrCreate($where, []);
        }

        return $product;
    }

    /**
     * @return object
     */
    public function fetchProductFromEasyaskById(Request $request)
    {
        $easyAskProduct = \Sayt::getProductById((int) $request->id);

        if (! empty($easyAskProduct)) {
            $product = $easyAskProduct->items[0];
            $product->isSkuProduct = isset($product->Sku_Id) ? true : false;
            $product->seopath = $easyAskProduct->seoPath;

            return $product;
        }

        return null;
    }

    /**
     * @return array
     */
    public function fetchProductOption()
    {
        $options['productClassification'] = ProductClassification::findOrFail(request()->classification_id)
            ->options()
            ->get() ?? new stdClass;

        $options['product'] = request()->id
            ? Product::query()
                ->findOrFail(request()->id)
                ->options()
                ->get() ?? new stdClass
            : new stdClass;

        $options['all'] = $this->fetchProductOptions();

        return $options;
    }

    /**
     * @return Option[]|EloquentCollection
     */
    public function fetchProductOptions()
    {
        return Option::all();
    }

    public function fetchEasyAskProducts(): JsonResponse
    {
        $site_search = request('site_search') === '-' || ! request()->filled('site_search')
            ? ''
            : request('site_search');
        $response = \Sayt::storeProducts($site_search);
        $response['product_search_by_id_prefix'] = config('amplify.search.product_search_by_id_prefix');

        return response()->json($response);
    }

    /**
     * Fetch Product From Local Server for ICE Cat
     */
    public function fetchProductsFromLocal(): JsonResponse
    {
        $id = request('site_search') === '-' || ! request()->filled('site_search')
            ? ''
            : request('site_search');
        $type = request('type');
        $data = [];
        $data['products'] = $type == 'category' ? $this->getCategoryProducts($id) : $this->getLocalProduct($id);
        $data['product_search_by_id_prefix'] = config('amplify.search.product_search_by_id_prefix');

        return response()->json(collect($data));
    }

    /**
     * Fetch Product from Categroy list
     *
     * @param  mixed  $id
     */
    private function getCategoryProducts($id): array
    {
        $categories = Category::query()->with('products')->findOrFail($id);
        if ($categories && count($categories->products) > 0) {
            return ['items' => ProductItemsResources::collection($categories->products)->resource];
        }

        return ['items' => []];

    }

    /**
     * Fetch Product from local server
     *
     * @param  mixed  $id
     */
    private function getLocalProduct($id): array
    {
        $products = Product::query()->with('skuProducts')->where('id', $id)->get();
        if (count($products) > 0) {

            return ['items' => ProductItemsResources::collection($products)->resource];
        }

        return ['items' => []];

    }

    public function fetchSkuProducts(): JsonResponse
    {
        if (isset(request()->calledFrom) && request()->calledFrom === 'selector') {
            $sku_search = trim(request()->search);
            $paginatePerPage = request()->pagination['resultsPerPage'] ?? '';

            $SKUProducts = Product::with('attributes', 'productImage')
                ->whereHas('parentProducts', function ($query) {
                    $query->where('id', request()->parent_id);
                })
                ->where(function ($query) use ($sku_search) {
                    $query->where('product_name', 'like', '%'.$sku_search.'%');
                })
                ->paginate($paginatePerPage);
        } else {
            $sku_search = request()->skus_search;
            $paginatePerPage = request()->input('resultsPerPage', '');

            $SKUProducts = Product::with('attributes', 'productImage')
                ->doesntHave('parentProducts')
                ->where(function ($query) use ($sku_search) {
                    $query->where('product_name', 'like', '%'.$sku_search.'%');
                })
                ->paginate($paginatePerPage)
                ->toArray();
        }

        return response()->json($SKUProducts);
    }

    public function fetchSkuProductListById(): JsonResponse
    {
        $skuProductId = SkuProduct::where('parent_id', request()->parent_id)->pluck('sku_id')->toArray();

        $skuProducts = Product::with('attributes', 'productImage')
            ->whereIn('id', $skuProductId)
            ->orderBy('reorder', 'ASC')
            ->paginate(12)
            ->toArray();

        return response()->json([
            ...$skuProducts,
            'all_data' => $skuProductId,
        ], 200);
    }

    public function fetchProductBySkuId(): JsonResponse
    {
        $product = Product::query()
            ->whereNotNull('parent_id')
            ->where('sku_id', request()->sku_id)
            ->with('productImage', 'attributes')
            ->first();

        return response()->json($product);
    }

    public function fetchBundleProductsById(): JsonResponse
    {
        $bundleProducts = Product::query()
            ->where('product_type', request()->product_type ?? 'bundle')
            ->where('id', request()->id)
            ->firstOrFail('products_list');

        $products_list = collect($bundleProducts->products_list);

        $paginatePerPage = request()->pagination['resultsPerPage'] ?? 12;
        $currentPage = request()->pagination['currentPage'] ?? 1;

        $filtered_products_list = request()->search ?? false
            ? $products_list->filter(function ($item) {
                return stripos($item['Product_Name'], trim(request()->search)) !== false
                    or stripos($item['Short_Description'], trim(request()->search)) !== false
                    or stripos($item['Long_Description'], trim(request()->search)) !== false;
            })
            : $products_list;

        $data = $this->paginate($filtered_products_list, $paginatePerPage, $currentPage);

        return response()->json($data);
    }

    public function paginate($items, $perPage, $page = null, $options = []): LengthAwarePaginator
    {
        $page = $page ?? (Paginator::resolveCurrentPage()
            ?: 1);
        $items = $items instanceof Collection
            ? $items
            : Collection::make($items);

        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

    public static function getSkuDefaultAttributes($sku_default_attributes_ids)
    {
        return Attribute::query()->whereIn('id', $sku_default_attributes_ids)
            ->get()
            ->map(function ($attribute) {
                return array_merge(
                    $attribute->toArray(),
                    [
                        'attribute_value' => '',
                        'local_attribute_value' => '',
                    ],
                );
            });
    }

    /**
     * @return mixed
     */
    public function getCategoriesByCategoryCode($category_code)
    {
        return Category::whereIn('category_code', $category_code)->pluck('id');
    }

    public function fetchRemoveAllProducts()
    {
        if (request()->removeFrom === 'category') {
            return CategoryProduct::query()
                ->where('category_id', request()->id)
                ->delete();
        }

        if (request()->removeFrom === 'productClassification') {
            return Product::query()
                ->where('product_classification_id', request()->id)
                ->update([
                    'product_classification_id' => null,
                ]);
        }

        if (request()->removeFrom === 'product') {
            return Product::query()
                ->where('id', request()->id)
                ->update([
                    'products_list' => null,
                ]);
        }
    }

    public function fetchProductSlug(): JsonResponse
    {
        $slug = request()->slug;
        $id = request()->id ?? null;

        return response()->json([
            'slug' => getProductSlug($slug, $id),
        ]);
    }
}
