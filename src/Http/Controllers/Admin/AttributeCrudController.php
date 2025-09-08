<?php

namespace Amplify\System\Backend\Http\Controllers\Admin;

use Amplify\System\Abstracts\BackpackCustomCrudController;
use Amplify\System\Backend\Http\Requests\AttributeRequest;
use Amplify\System\Backend\Models\Attribute;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\InlineCreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanel;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Backpack\Pro\Http\Controllers\Operations\FetchOperation;

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
    use ShowOperation;
    use UpdateOperation;

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
    ];

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(Attribute::class);
        CRUD::setRoute(config('backpack.base.route_prefix').'/attribute');
        CRUD::setEntityNameStrings('attribute', 'attributes');
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
            'name' => 'slug',
            'label' => 'Name',
        ]);

        CRUD::addColumn([
            'name' => 'name',
            'label' => 'Display Name',
        ]);

        CRUD::addColumn([
            'name' => 'type',
            'label' => 'Type',
            'type' => 'custom_html',
            'value' => function ($attribute) {
                return ucfirst($attribute->type ?? '');
            },
        ]);

        CRUD::addColumn([
            'name' => 'use_as_filter',
            'label' => 'Use As Filter',
            'type' => 'custom_html',
            'value' => function ($attribute) {
                $use_as_filter = $attribute->use_as_filter ?? false;

                return "<i class='la la-".($use_as_filter
                        ? 'check text-success'
                        : 'times text-danger')."'></i>";
            },
        ]);

        CRUD::addColumn([
            'name' => 'searchable',
            'label' => 'Searchable',
            'type' => 'custom_html',
            'value' => function ($attribute) {
                $searchable = $attribute->searchable ?? false;

                return "<i class='la la-".($searchable
                        ? 'check text-success'
                        : 'times text-danger')."'></i>";
            },
        ]);

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']);
         */
    }

    protected function setupShowOperation()
    {
        $this->crud->set('show.setFromDb', false);

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
            'type' => 'custom_html',
            'value' => function ($attribute) {
                return ucfirst($attribute->type ?? '');
            },
        ]);

        CRUD::addColumn([
            'name' => 'unit',
            'label' => 'Unit',
            'type' => 'custom_html',
            'value' => function ($attribute) {
                return ucfirst($attribute->unit ?? '');
            },
        ]);

        CRUD::addColumn([
            'name' => 'has_range',
            'label' => 'Has Range',
            'type' => 'custom_html',
            'value' => function ($attribute) {
                $has_range = $attribute->has_range ?? false;

                return "<i class='la la-".($has_range
                        ? 'check text-success'
                        : 'times text-danger')."'></i>";
            },
        ]);

        CRUD::addColumn([
            'name' => 'use_as_filter',
            'label' => 'Use As Filter',
            'type' => 'custom_html',
            'value' => function ($attribute) {
                $use_as_filter = $attribute->use_as_filter ?? false;

                return "<i class='la la-".($use_as_filter
                        ? 'check text-success'
                        : 'times text-danger')."'></i>";
            },
        ]);

        CRUD::addColumn([
            'name' => 'searchable',
            'label' => 'Searchable',
            'type' => 'custom_html',
            'value' => function ($attribute) {
                $searchable = $attribute->searchable ?? false;

                return "<i class='la la-".($searchable
                        ? 'check text-success'
                        : 'times text-danger')."'></i>";
            },
        ]);

        CRUD::addColumn([
            'name' => 'tunable',
            'label' => 'Treat As Column',
            'type' => 'custom_html',
            'value' => function ($attribute) {
                $tunable = $attribute->tunable ?? false;

                return "<i class='la la-".($tunable
                        ? 'check text-success'
                        : 'times text-danger')."'></i>";
            },
        ]);

        CRUD::addcolumn([
            'name' => 'is_new',
            'label' => 'Is New',
            'type' => 'custom_html',
            'value' => function ($model) {
                return $model->is_new === 1
                    ? 'Yes'
                    : 'No';
            },
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

        $this->data['translatable'] = array_keys($this->crud->model->translations);
        $this->data['attribute'] = $this->crud->model->find(request()->id);

        $this->crud->setCreateView('crud::pages.attribute.create');

        CRUD::addField([
            'name' => 'hide',
            'type' => 'custom_html',
            'value' => '<style> .close.delete-element {display: none} </style>',
        ]);

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
        $this->crud->setUpdateView('crud::pages.attribute.create');
        $this->setupCreateOperation();
    }
}
