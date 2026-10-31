<?php

namespace Amplify\System\Backend\Http\Controllers\Admin;

use Amplify\System\Abstracts\BackpackCustomCrudController;
use Amplify\System\Backend\Http\Requests\AttributeRequest;
use Amplify\System\Backend\Exports\AttributeValueExport;
use Amplify\System\Backend\Models\Attribute;
use Amplify\System\Backend\Models\AttributeProduct;
use Amplify\System\Backend\Traits\BulkExportOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\InlineCreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanel;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Backpack\Pro\Http\Controllers\Operations\FetchOperation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Exception;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

/**
 * Class AttributeCrudController
 *
 * @property-read CrudPanel $crud
 */
class AttributeCrudController extends BackpackCustomCrudController
{
    use CreateOperation;
    use DeleteOperation;
    use FetchOperation;
    use InlineCreateOperation;
    use ListOperation;
    use UpdateOperation;
    use BulkExportOperation;
    use ShowOperation;

    /**
     * @var string[]
     */
    private $units = [
        'kg' => 'Kg',
        'g' => 'g',
        'in' => 'In',
        'cm' => 'cm',
        'ft' => 'ft',
        'l' => 'L',
        'km' => 'Km',
        'm' => 'm',
    ];

    /**
     * @var string[]
     */
    private $types = [
        'text' => 'Text',
        'date' => 'Date',
        'integer' => 'Integer',
        'decimal' => 'Decimal',
        'boolean' => 'Boolean',
        'enum' => 'Enum',
        'select' => 'Select',
    ];

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(Attribute::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/attribute');
        CRUD::setEntityNameStrings('attribute', 'attributes');
    }

    protected function setupCustomRoutes($segment, $routeName, $controller)
    {
        Route::get($segment . '/{attribute}/reorder', [
            'as' => $routeName . '.reorder',
            'uses' => $controller . '@reorder',
            'operation' => 'value-reorder',
        ]);

        Route::post($segment . '/{attribute}/reorder', [
            'as' => $routeName . '.save-reorder',
            'uses' => $controller . '@saveReorder'
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
        $this->crud->addButtonFromModelFunction('line', 'reorder-value', 'reorderValuesBtn', 'ending');

        CRUD::addColumn([
            'name' => 'id',
            'type' => 'custom_html',
            'value' => function ($model) {
                if ($model->is_new === 1 && !$model->is_updated) {
                    return $model->id . ' <sup class="badge text-danger px-0">New</sup>';
                } elseif ($model->is_updated) {
                    return $model->id . ' <sup class="badge text-warning px-0">Updated</sup>';
                } else {
                    return $model->id;
                }
            },
        ]);

        CRUD::addColumn([
            'name' => 'name',
            'label' => 'Name',
        ]);

        CRUD::addColumn([
            'name' => 'slug',
            'label' => 'Slug',
        ]);

        CRUD::addColumn([
            'name' => 'type',
            'label' => 'Type',
            'type' => 'select_from_array',
            'options' => $this->types,
        ]);

        CRUD::addColumn([
            'name' => 'use_as_filter',
            'label' => 'Use As Filter',
            'type' => 'boolean',
        ]);

        CRUD::addColumn([
            'name' => 'searchable',
            'label' => 'Searchable',
            'type' => 'boolean',
        ]);

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']);
         */
    }

    protected function setupShowOperation()
    {
        $id = $this->crud->getCurrentEntryId();

        $entries = AttributeProduct::query()
            ->where('attribute_id', '=', $id)
            ->groupBy('attribute_value')
            ->orderBy('sequence')
            ->get()->toArray();

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

        CRUD::addcolumn([
            'name' => 'name',
            'label' => 'Name',
            'type' => 'custom_html',
            'value' => function ($model) {
                return $model->local_name;
            },
        ]);

        CRUD::addcolumn([
            'name' => 'description',
        ]);

        CRUD::addColumn([
            'name' => 'type',
            'label' => 'Type',
            'type' => 'select_from_array',
            'options' => $this->types,
        ]);

        CRUD::addColumn([
            'name' => 'unit',
            'label' => 'Unit',
            'type' => 'select_from_array',
            'options' => $this->units,
        ]);

        CRUD::addColumn([
            'name' => 'has_range',
            'label' => 'Has Range',
            'type' => 'boolean',
        ]);

        CRUD::addColumn([
            'name' => 'use_as_filter',
            'label' => 'Use As Filter',
            'type' => 'boolean',
        ]);

        CRUD::addColumn([
            'name' => 'searchable',
            'label' => 'Searchable',
            'type' => 'boolean',
        ]);

        CRUD::addColumn([
            'name' => 'tunable',
            'label' => 'Treat As Column',
            'type' => 'boolean'
        ]);


        CRUD::addcolumn([
            'name' => 'attribute_value',
            'label' => 'Values',
            'type' => 'table',
            'value' => $entries,
            'columns' => [
                'sequence' => 'Sequence',
                'attribute_value' => 'Value',
            ],
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
        CRUD::setValidation(AttributeRequest::class);
        $this->crud->setCreateView('backend::pages.attribute.create');

        $this->data['translatable'] = array_keys($this->crud->model->translations);
        $this->data['attribute'] = $this->crud->model->find(request()->id);

        CRUD::addField([
            'name' => 'name',
            'type' => 'text',
            'label' => 'Name',
            'attributes' => [
                'placeholder' => 'Enter attribute name',
            ],
        ]);

        CRUD::addField([
            'name' => 'slug',
            'type' => 'text',
            'label' => 'Slug',
            'attributes' => [
                'placeholder' => 'Enter attribute slug',
            ],
        ]);

        CRUD::addField([
            'name' => 'description',
            'type' => 'textarea',
            'attributes' => [
                'placeholder' => 'Attribute Description',
            ],
        ]);

        CRUD::addField([
            'name' => 'type',
            'type' => 'select_from_array',
            'options' => $this->types,
            'allows_null' => false,
            'attributes' => [
                'id' => 'attribute_type',
            ],
        ]);

        CRUD::addField([
            'name' => 'select_options',
            'label' => 'Select Options',
            'type' => 'table',
            'columns' => [
                'label' => 'Label',
                'slug' => 'Slug',
            ],
        ]);

        CRUD::addField([
            'name' => 'unit',
            'type' => 'text',
            'allows_null' => false,
            'attributes' => [
                'placeholder' => 'Type unit here...',
            ],
        ]);

        CRUD::addField([
            'name' => 'is_required',
            'type' => 'checkbox',
        ]);

        CRUD::addField([
            'name' => 'has_range',
            'type' => 'checkbox',
        ]);

        CRUD::addField([
            'name' => 'use_as_filter',
            'type' => 'checkbox',
        ]);

        CRUD::addField([
            'name' => 'is_updated',
            'type' => 'checkbox',
        ]);

        CRUD::addField([
            'name' => 'searchable',
            'type' => 'checkbox',
        ]);

        CRUD::addField([
            'name' => 'tunable',
            'label' => 'Treat As Column',
            'type' => 'checkbox',
        ]);
    }

    protected function setupInlineCreateOperation()
    {
        CRUD::setValidation(AttributeRequest::class);

        CRUD::addField([
            'name' => 'name',
        ]);

        CRUD::addField([
            'name' => 'slug',
        ]);

        CRUD::addField([
            'name' => 'description',
            'type' => 'text',
        ]);

        CRUD::addField([
            'name' => 'type',
            'type' => 'select_from_array',
            'options' => $this->types,
            'allows_null' => false,
        ]);

        CRUD::addField([
            'name' => 'unit',
            'type' => 'text',
            'allows_null' => false,
        ]);

        CRUD::addField([
            'name' => 'is_required',
        ]);

        CRUD::addField([
            'name' => 'has_range',
        ]);

        CRUD::addField([
            'name' => 'use_as_filter',
        ]);

        CRUD::addField([
            'name' => 'is_updated',
        ]);

        CRUD::addField([
            'name' => 'searchable',
        ]);

        CRUD::addField([
            'name' => 'tunable',
            'label' => 'Treat As Column',
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
        $this->crud->setUpdateView('backend::pages.attribute.create');
        $this->setupCreateOperation();
    }

    public function fetchAttributeSlug(): JsonResponse
    {
        $baseSlug = \Illuminate\Support\Str::slug(request()->slug ?? '');
        $id = request()->id ?? null;

        if (empty($baseSlug)) {
            return response()->json([
                'slug' => '',
            ]);
        }

        $slug = $baseSlug;
        $counter = 1;

        while (Attribute::query()
            ->where('slug', $slug)
            ->when($id, function ($query) use ($id) {
                $query->where('id', '!=', $id);
            })
            ->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return response()->json([
            'slug' => $slug,
        ]);
    }

    public function reorder(Attribute $attribute)
    {
        $entries = AttributeProduct::query()
            ->select('id', 'sequence', 'attribute_value', 'attribute_id')
            ->where('attribute_id', $attribute->getKey())
            ->groupBy('attribute_value')
            ->orderBy('sequence')
            ->get();

        $this->crud->setHeading('Attribute Values');
        $this->crud->setSubheading('Reorder attribute values');

        $this->crud->set('reorder.max_level', 1);

        return view('backend::pages.attribute.reorder_value', [
            'crud' => $this->crud,
            'entries' => $entries,
            'title' => 'Reorder Values',
            'attribute' => $attribute,
        ]);
    }

    public function saveReorder(Attribute $attribute, Request $request)
    {
        try {
            $attributeValues = [];

            foreach ($request->input('tree', []) as $sequence => $item) {

                if (empty($item['item_id'])) {
                    continue;
                }

                $attributeValues[$sequence] = $item['item_id'];
            }

            if (empty($attributeValues)) {
                return back()->with('warning', 'Nothing to reorder.');
            }

            //Prepare Query

            $cases = [];
            $bindings = [];

            foreach ($attributeValues as $sequence => $attributeValue) {
                $cases[] = 'WHEN JSON_SEARCH(attribute_value, \'one\', ?) IS NOT NULL THEN ?';
                $bindings[] = $attributeValue;
                $bindings[] = $sequence;
            }

            // Single bulk query: rows are matched by attribute_id + attribute_value,
            // so every attribute_product row sharing the same attribute value across
            // different product ids receives the same sequence, keeping sequences
            // unique per attribute (no duplicate sequence per attribute value).
            $searches = implode(' OR ', array_fill(0, count($attributeValues),
                'JSON_SEARCH(attribute_value, \'one\', ?) IS NOT NULL'));

            //Used RAW Query for 1,01,41,345 rows can be a possibility
            DB::update("
            UPDATE attribute_product
            SET sequence = CASE " . implode(' ', $cases) . " ELSE sequence END
            WHERE attribute_id = ? AND ($searches)
        ", array_merge($bindings, [$attribute->getKey()], array_values($attributeValues)));

            $attribute->is_updated = true;
            $attribute->save();

            return back()->with('success', 'Attribute values reordered successfully.');
        } catch (\Throwable $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    /**
     * Export multiple entries in one go.
     *
     * @return BinaryFileResponse|RedirectResponse
     * @throws Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function bulkExport()
    {
        $this->crud->hasAccessOrFail('bulkExport');

        /**
         * @var int[] $entries ids of attributes
         */
        $entries = request()->input('entries', []);

        if (empty($entries)) {
            return back()->with('warning', 'No attributes selected for export.');
        }

        $rows = AttributeProduct::query()
            ->select('attributes.name', 'attribute_product.attribute_value', 'attribute_product.sequence')
            ->join('attributes', 'attributes.id', '=', 'attribute_product.attribute_id')
            ->whereIn('attribute_id', $entries)
            ->distinct()
            ->orderBy('attributes.name')
            ->orderBy('attribute_product.sequence')
            ->get()
            ->map(function ($row) {
                return [
                    'attribute_name' => $row->name,
                    'attribute_value' => $row->attribute_value,
                    'sequence' => $row->sequence,
                ];
            });

        return Excel::download(
            new AttributeValueExport($rows),
            'attribute-values-'.now()->format('Y-m-d-His').'.xlsx',
            \Maatwebsite\Excel\Excel::XLSX
        );
    }
}