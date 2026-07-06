<?php

namespace Amplify\System\Backend\Http\Controllers\Admin;

use Amplify\System\Abstracts\BackpackCustomCrudController;
use Amplify\System\Backend\Http\Requests\CategoryRequest;
use Amplify\System\Backend\Models\Category;
use Amplify\System\Backend\Models\Product;
use Amplify\System\Backend\Traits\ProductCategoryTrait;
use Amplify\System\Backend\Traits\ReorderTrait;
use Amplify\System\Jobs\CategoryCloneJob;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\InlineCreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ReorderOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanel;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Backpack\Pro\Http\Controllers\Operations\FetchOperation;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Prologue\Alerts\Facades\Alert;

/**
 * Class CategoryCrudController
 *
 * @property-read CrudPanel $crud
 */
class CategoryCrudController extends BackpackCustomCrudController
{
    use CreateOperation;
    use DeleteOperation {
        destroy as traitDestroy;
    }
    use FetchOperation;
    use InlineCreateOperation;
    use ListOperation;
    use ProductCategoryTrait;
    use ReorderOperation;
    use ReorderTrait;
    use UpdateOperation;

    public string $reorderLabel = 'category_name';

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     *
     * @throws \Exception
     */
    public function setup()
    {
        CRUD::setModel(Category::class);
        CRUD::setRoute(config('backpack.base.route_prefix').'/category');
        CRUD::setEntityNameStrings('category', 'categories');
    }

    protected function setupCustomRoutes($segment, $routeName, $controller): void
    {
        Route::get($segment.'/clone/{category}', [
            'as' => $routeName.'.clone',
            'uses' => $controller.'@cloneCategory',
            'operation' => 'cloneCategory',
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
        CRUD::addFilter(
            [
                'name' => 'parent_id',
                'type' => 'dropdown',
                'label' => 'Catalog',
            ],
            function () {
                return $this->crud->model
                    ->where('parent_id', null)
                    ->get()
                    ->pluck('category_name', 'id')->toArray();
            },
            function ($value) {
                $this->crud->addClause('where', 'parent_id', '=', $value);
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
                'name' => 'featured',
                'type' => 'dropdown',
                'label' => 'Is Featured',
            ],
            function () {
                return [
                    '0' => 'No',
                    '1' => 'Yes',
                ];
            },
            function ($value) {
                $this->crud->addClause('where', 'featured', '=', $value);
            }
        );

        $this->crud->addButtonFromModelFunction('line', 'show-clone_category-btn', 'showCloneCategoryBtn', 'ending');

        if (! backpack_user()->can('category.create') && ! (is_super_admin())) {
            $this->crud->removeButton('create');
        }

        CRUD::addColumn([
            'name' => 'id',
            'type' => 'custom_html',
            'label' => '#',
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
            'name' => 'category_code',
            'label' => 'Category Code',
        ]);

        CRUD::addColumn([
            'name' => 'category_name',
            'label' => 'Category Name',
            'type' => 'custom_html',
            'value' => function ($model) {
                return $model->label;
            },
        ]);

        CRUD::addColumn([
            'name' => 'category_slug',
            'label' => 'Category Slug',
        ]);

        CRUD::addColumn([
            'name' => 'is_top_nav',
            'label' => 'Is Top Nav',
            'type' => 'boolean',
        ]);

        CRUD::addColumn([
            'name' => 'featured',
            'label' => 'Is Featured',
            'type' => 'boolean',
        ]);
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
        CRUD::setValidation(CategoryRequest::class);

        $this->crud->setCreateView('backend::pages.category.create');

        $this->data['translatable'] = array_keys($this->crud->model->translations);
        $this->data['category'] = $this->crud->model->with('products.productImage')->find(request()->id);

        $this->data['catalogs'] = $this->crud->model->whereNull('parent_id')->get()
            ->map(function ($item) {
                $item->name = $item->category_name;

                return $item;
            })->pluck('name', 'id')->toArray();

        $this->data['easyAsk_default_product_categories'] = eaDefaultCategories('categories');
        $this->data['categorization_required'] = config('amplify.pim.categorization_required', false);

        CRUD::addField([
            'name' => 'category_code',
            'label' => 'Category Code',
            'tab' => 'Basic Info',
        ]);
        CRUD::addField([
            'name' => 'category_name',
            'label' => 'Category Name',
            'tab' => 'Basic Info',
        ]);
        CRUD::addField([
            'name' => 'description',
            'label' => 'Category Description',
            'tab' => 'Basic Info',
        ]);
        CRUD::addField([
            'name' => 'category_slug',
            'label' => 'Category Slug',
            'tab' => 'Basic Info',
        ]);
        CRUD::addField([
            'name' => 'pim_category_id',
            'label' => 'PIM Category',
            'tab' => 'Basic Info',
        ]);

        CRUD::addField([
            'name' => 'template',
            'tab' => 'Basic Info',
        ]);
        CRUD::addField([
            'name' => 'image',
            'type' => 'text',
            'tab' => 'Basic Info',
        ]);
        // CRUD::addField(['name' => 'parent_id', 'label' => 'Parent Id']);
        // CRUD::addField(['name' => 'level', 'label' => 'Level']);
        CRUD::addField([
            'name' => 'is_top_nav',
            'label' => 'Is Top Nav',
            'tab' => 'Basic Info',
        ]);

        CRUD::addField([
            'name' => 'featured',
            'label' => 'Is Featured',
            'tab' => 'Basic Info',
        ]);

        CRUD::addField([
            'name' => 'enabled',
            'label' => 'Enabled',
            'tab' => 'Basic Info',
        ]);

        CRUD::addField([
            'name' => 'is_new',
        ]);

        CRUD::addField([
            'name' => 'is_updated',
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
        $this->crud->setUpdateView('backend::pages.category.create');

        $this->setupCreateOperation();
    }

    /**
     * Reorder Category
     */
    protected function setupReorderOperation()
    {
        $this->crud->set('reorder.label', 'category_name');
        $this->crud->set('reorder.max_level', 0);
        $this->crud->addClause('orderBy', 'lft', 'ASC');
        $this->crud->addClause('select', ['id', 'category_name', 'lft', 'parent_id']);
    }

    /**
     *  Reorder the items in the database using the Nested Set pattern.
     *
     *  Database columns needed: id, parent_id, lft, rgt, depth, name/title
     *
     * @return Application|Factory|View
     */
    protected function setupShowOperation()
    {
        $this->crud->set('show.setFromDb', false);

        CRUD::addColumn([
            'name' => 'category_code',
            'label' => 'Category Code',
        ]);
        CRUD::addColumn([
            'name' => 'category_name',
            'label' => 'Category Name',
            'type' => 'custom_html',
            'value' => function ($model) {
                return $model->label;
            },
        ]);
        CRUD::addColumn([
            'name' => 'description',
            'label' => 'Category Description',
            'type' => 'custom_html',
            'value' => function ($model) {
                return $model->description ?: 'No description available';
            },
        ]);
        CRUD::addColumn([
            'name' => 'category_slug',
            'label' => 'Category Slug',
        ]);
        CRUD::addColumn([
            'name' => 'pim_category_id',
            'label' => 'PIM Category',
        ]);
        CRUD::addColumn([
            'name' => 'is_top_nav',
            'label' => 'Is Top Nav',
            'type' => 'boolean',
        ]);
        CRUD::addColumn([
            'name' => 'featured',
            'label' => 'Is Featured',
            'type' => 'boolean',
        ]);
        CRUD::addColumn([
            'name' => 'template',
        ]);
        CRUD::addColumn([
            'name' => 'image',
            'type' => 'image',
            'width' => '120px',
            'height' => 'auto',
        ]);

        CRUD::addColumn([
            'name' => 'products',
            'label' => 'Products',
            'type' => 'table-related',
            'view_namespace' => 'backend::columns',
            'columns' => [
                [
                    'name' => 'product_id',
                    'label' => 'Product ID',
                    'type' => 'text',
                ],
                [
                    'name' => 'product_name',
                    'label' => 'Product Name',
                    'type' => 'text',
                ],
            ],
        ]);
    }

    public function fetchProductsById(): JsonResponse
    {
        $search = trim(request('search'));
        $paginatePerPage = request()->pagination['resultsPerPage'] ?? '';

        $product = Product::query()->with('productImage')->whereHas('categories', function ($q) use ($search) {
            $q = $q->where('category_id', request()->id);

            if (! empty($search)) {
                $q = $q->where(function ($query) use ($search) {
                    return $query->where('product_name', 'like', '%'.$search.'%')
                        ->orWhere('description', 'like', '%'.$search.'%')
                        ->orWhere('product_code', 'like', '%'.$search.'%');
                });
            }

            return $q;
        });

        return response()->json($product->paginate($paginatePerPage));
    }

    public function fetchCategorySlug(): JsonResponse
    {
        $slug = request()->slug;
        $id = request()->id ?? null;

        return response()->json([
            'slug' => getCategorySlug($slug, $id),
        ]);
    }

    protected function fetchCategoryTree() {}

    /**
     * @return bool|string
     */
    public function destroy($id)
    {
        $this->crud->hasAccessOrFail('delete');
        $imagePath = $this->crud->getEntry($id)->image;
        $isDeleted = $this->crud->delete($id);
        if ($isDeleted && ! empty($imagePath)) {
            deleteFileFromPublicFolder($imagePath);
        }

        return $isDeleted;
    }

    public function cloneCategory(Category $category): RedirectResponse
    {
        CategoryCloneJob::dispatch($category, true);

        Alert::add('success', 'Creating classification process started successfully!')->flash();

        return Redirect::to('admin/category');
    }
}
