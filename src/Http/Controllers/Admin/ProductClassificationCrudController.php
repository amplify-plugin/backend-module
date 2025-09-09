<?php

namespace Amplify\System\Backend\Http\Controllers\Admin;

use Amplify\System\Abstracts\BackpackCustomCrudController;
use Amplify\System\Backend\Http\Requests\ProductClassificationsRequest;
use Amplify\System\Backend\Models\Attribute;
use Amplify\System\Backend\Models\Option;
use Amplify\System\Backend\Models\ProductClassification;
use Amplify\System\Backend\Traits\ProductClassificationTrait;
use Amplify\System\Backend\Traits\ReorderTrait;
use Amplify\System\Cms\Models\Page;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ReorderOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanel;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Backpack\Pro\Http\Controllers\Operations\FetchOperation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

/**
 * Class ProductClassificationsCrudController
 *
 * @property-read CrudPanel $crud
 * @property array $units
 * @property array $types
 */
class ProductClassificationCrudController extends BackpackCustomCrudController
{
    use CreateOperation;
    use DeleteOperation;
    use FetchOperation;
    use ListOperation;
    use ProductClassificationTrait;
    use ReorderOperation;
    use ReorderTrait;
    use ShowOperation;
    use UpdateOperation {
        update as traitUpdate;
    }

    private array $units = [
        'kg' => 'Kg',
        'g' => 'g',
        'in' => 'In',
        'cm' => 'cm',
        'ft' => 'ft',
        'l' => 'L',
        'km' => 'Km',
        'm' => 'm',
    ];

    private array $types = [
        'text' => 'Text',
        'date' => 'Date',
        'integer' => 'Integer',
        'decimal' => 'Decimal',
        'boolean' => 'Boolean',
        'enum' => 'Enum',
    ];

    public string $reorderLabel = 'title';

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(ProductClassification::class);
        CRUD::setRoute(config('backpack.base.route_prefix').'/classification');
        CRUD::setEntityNameStrings('product-classification', 'product classifications');
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
        CRUD::column('id')->type('number')->thousands_sep('');
        CRUD::column('title');
        CRUD::addColumn([
            'name' => 'attributes',
            'label' => 'Attributes',
            'type' => 'custom_html',
            'value' => function ($entity) {
                return $this->makeAttributesForView($entity);
            },
        ]);
    }

    private function makeAttributesForView($entity): string
    {
        $view = '<div>';
        if (count($entity->attributes) > 0) {
            foreach ($entity->attributes as $value) {
                $view .= '<span style="font-size: 15px;" class="badge badge-secondary">'
                    .$value->name
                    .'</span>';
            }
        } else {
            $view .= '<span>-</span>';
        }

        return $view .= '</div>';
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
        CRUD::setValidation(ProductClassificationsRequest::class);

        $this->data['translatable'] = array_keys($this->crud->model->translations);
        $this->data['productClassification'] =
            $this->crud->model->with('attributes', 'options')->find(request()->id);
        $this->data['attributes'] = $this->getAttributes();
        $this->data['options'] = Option::get()
            ->sortBy(fn ($item) => $item->getLocalNameAttribute(), SORT_NATURAL | SORT_FLAG_CASE)
            ->values();
        $this->data['easyAsk_default_product_categories'] = eaDefaultCategories('categories');
        $this->data['all_single_product_pages'] = Page::getPages('single_product');

        $this->crud->setCreateView('backend::pages.product-classification.create');

        CRUD::addField([
            'name' => 'title',
            'type' => 'text',
        ]);

        CRUD::addField([
            'name' => 'attributes',
            'type' => 'relationship',
            'entity' => 'attributes',
            'inline_create' => true,
            'attribute' => 'name', // foreign key attribute that is shown to user
            'pivot' => true,
        ]);

        CRUD::addField([
            'name' => 'options',
            'type' => 'relationship',
            'entity' => 'options',
            'inline_create' => true,
            'attribute' => 'option_name', // foreign key attribute that is shown to user
            'pivot' => true,
        ]);

        CRUD::field('slug')->type('hidden');
        CRUD::field('single_product_page_id');

        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number']));
         */
    }

    /**
     * @return mixed
     */
    public function fetchAttributes()
    {
        // dd($this->getAttributes());
        return $this->getAttributes();
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
        $productClassificationData = $this->crud->getCurrentEntry();
        $this->crud->setUpdateView('backend::pages.product-classification.create');
        $this->setupCreateOperation();
    }

    /**
     * @return Response
     */
    public function update(ProductClassificationsRequest $request)
    {
        // check attribute ids diff
        $product_Classification = ProductClassification::findOrFail($request->id);
        $old_attribute_ids = $product_Classification->attributes->pluck('id')->toArray();
        $old_option_ids = $product_Classification->options->pluck('id')->toArray();

        // your additional operations before save here
        $response = $this->traitUpdate($request);

        $new_attribute_ids = $request['attributes'];
        $new_option_ids = $request['options'];
        $diff_attribute_ids = array_diff($old_attribute_ids, $new_attribute_ids);
        $diff_option_ids = array_diff($old_option_ids, $new_option_ids);
        // Update products table is_published == 0
        if (! empty($diff_attribute_ids) || ! empty($diff_option_ids)) {
            $products = $this->crud->entry->classificationProducts->where('status', 'published');
            foreach ($products as $product) {
                $product->update(['status' => 'incomplete']);
            }
        }
        /*if (isset($request['products']) && count($request['products']) > 0) {
            //first remove old
            Product::where('product_classification_id', $request['id'])
                ->update(['product_classification_id' => null]);
            //then add new
            Product::whereIn('id', $request['products'])
                ->update(['product_classification_id' => $request['id']]);
        }*/

        return $response;
    }

    /**
     * @return mixed
     */
    private function getAttributes()
    {
        return Attribute::get()
            ->sortBy(fn ($item) => $item->getLocalNameAttribute(), SORT_NATURAL | SORT_FLAG_CASE)
            ->values()
            ->map(function ($attribute) {
                $productClassifications = $attribute->productClassifications()
                    ->where('classification_id', request()->id)
                    ->first();
                $pivot = $productClassifications->pivot ?? new \stdClass;
                $boolean_titles = json_decode($pivot->boolean_titles ?? '{}');
                $attribute = array_merge(
                    $attribute->toArray(),
                    [
                        'min' => $pivot->min ?? '',
                        'max' => $pivot->max ?? '',
                        'is_multiple' => $pivot->is_multiple ?? false,
                        'is_required' => $pivot->is_required ?? false,
                        'boolean_true' => $boolean_titles->true ?? '',
                        'boolean_false' => $boolean_titles->false ?? '',
                        'enums' => collect(json_decode($pivot->enums ?? '[]'))->map(function ($enum) {
                            return ['name' => $enum, 'id' => time() + rand(1111, 9090)];
                        }) ?? [],
                    ]
                );

                return collect($attribute);
            });
    }

    /**
     *  Reorder the items in the database using the Nested Set pattern.
     *
     *  Database columns needed: id, parent_id, lft, rgt, depth, name/title
     *
     * @return Response
     */
    public function reorder()
    {
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', '300');

        $this->getReorderData();

        return view('backend::pages.product-classification.reorder', $this->data);
    }

    protected function setupShowOperation()
    {
        $this->data['attributes'] = $this->getAttributes();

        CRUD::column('title');
        CRUD::addColumn([
            'name' => 'attributes',
            'label' => 'Attributes',
            'type' => 'table-related',
            'columns' => [
                [
                    'name' => 'name',
                    'label' => 'Attribute Name',
                    'type' => 'text',
                ],
                [
                    'name' => 'is_multiple',
                    'label' => 'Is Multiple',
                    'type' => 'custom_html',
                    'value' => function ($entry) {
                        return $this->data['attributes'][0]['is_multiple'] ? 'Yes' : 'No';
                    },
                ],
                [
                    'name' => 'is_required',
                    'label' => 'Is required',
                    'type' => 'custom_html',
                    'value' => function ($entry) {
                        return $this->data['attributes'][0]['is_required'] ? 'Yes' : 'No';
                    },
                ],
            ],
        ]);

        CRUD::addColumn([
            'name' => 'options',
            'type' => 'relationship',
        ]);
        CRUD::addColumn([
            'name' => 'single_product_page_id',
            'label' => 'Product Details',
        ]);

    }

    public function updatePivotTable(Request $request): JsonResponse
    {
        foreach ($request->except(['insert']) as $item) {
            $where = collect($item)->only(['classification_id', 'attribute_id'])->toArray();
            $item['created_at'] = now();
            $item['updated_at'] = now();
            $item['boolean_titles'] = isset($item['boolean_titles'])
                ? json_encode($item['boolean_titles'])
                : null;
            $item['enums'] = isset($item['enums'])
                ? json_encode($item['enums'])
                : null;
            unset($item['type']);

            DB::table('attribute_product_classification')->updateOrInsert($where, $item);
        }

        return response()->json(['message' => 'Success']);
    }

    public function checkUseInProducts(ProductClassification $productClassification)
    {
        return $productClassification->classificationProducts()->where('status', 'published')->count();
    }
}
