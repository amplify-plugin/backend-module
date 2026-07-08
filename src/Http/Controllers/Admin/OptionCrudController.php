<?php

namespace Amplify\System\Backend\Http\Controllers\Admin;

use Amplify\System\Abstracts\BackpackCustomCrudController;
use Amplify\System\Backend\Http\Requests\OptionRequest;
use Amplify\System\Backend\Models\Option;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\InlineCreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanel;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class OptionCrudController
 *
 * @property-read CrudPanel $crud
 */
class OptionCrudController extends BackpackCustomCrudController
{
    use CreateOperation;
    use DeleteOperation;
    use InlineCreateOperation;
    use ListOperation;
    use UpdateOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(Option::class);
        CRUD::setRoute(config('backpack.base.route_prefix').'/option');
        CRUD::setEntityNameStrings('option', 'options');
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
        CRUD::addColumn([
            'name' => 'option_name',
            'label' => 'Option Name',
        ]);
        CRUD::addColumn([
            'name' => 'is_required',
            'label' => 'Is Required',
            'type' => 'boolean',
        ]);
        CRUD::addColumn([
            'name' => 'option_type',
            'label' => 'Option Type',
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
        CRUD::setValidation(OptionRequest::class);

        $this->data['option'] = $this->crud->model->find(request()->id);
        $this->crud->setCreateView('backend::pages.options.create');

        CRUD::addField([
            'name' => 'option_name',
            'label' => 'Option Name',
        ]);
        CRUD::addField([
            'name' => 'is_required',
            'label' => 'Is Required',
        ]);
        CRUD::addField([
            'name' => 'description',
            'label' => 'Description',
        ]);
        CRUD::addField([
            'name' => 'option_type',
            'label' => 'Option Type',
        ]);
        CRUD::addField([
            'name' => 'value_type',
            'label' => 'Value Type',
        ]);
        CRUD::addField([
            'name' => 'default_value',
            'label' => 'Default Value',
        ]);
        CRUD::addField([
            'name' => 'limit_min',
            'label' => 'Limit Input Minimum characters',
        ]);
        CRUD::addField([
            'name' => 'limit_max',
            'label' => 'Limit Input Maximum characters',
        ]);
        CRUD::addField([
            'name' => 'limit_choices',
            'label' => 'Limit Choices',
        ]);
        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number']));
         */
    }

    protected function setupInlineCreateOperation()
    {
        CRUD::setValidation(OptionRequest::class);

        CRUD::addField([
            'name' => 'option_name',
            'label' => 'Option Name',
        ]);
        CRUD::addField([
            'name' => 'is_required',
            'label' => 'Is Required',
        ]);
        CRUD::addField([
            'name' => 'description',
            'label' => 'Description',
        ]);
        CRUD::addField([
            'name' => 'option_type',
            'label' => 'Option Type',
        ]);
        CRUD::addField([
            'name' => 'value_type',
            'label' => 'Value Type',
        ]);
        CRUD::addField([
            'name' => 'default_value',
            'label' => 'Default Value',
        ]);
        CRUD::addField([
            'name' => 'limit_min',
            'label' => 'Limit Input Minimum characters',
        ]);
        CRUD::addField([
            'name' => 'limit_max',
            'label' => 'Limit Input Maximum characters',
        ]);
        CRUD::addField([
            'name' => 'limit_choices',
            'label' => 'Limit Choices',
        ]);

        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number']));
         */
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
        $this->crud->setUpdateView('backend::pages.options.create');
        $this->setupCreateOperation();
    }

    protected function setupShowOperation()
    {
        $this->crud->set('show.setFromDb', false);
        $optionData = $this->crud->getCurrentEntry();

        CRUD::addColumn([
            'name' => 'option_name',
            'label' => 'Option Name',
        ]);

        CRUD::addColumn([
            'name' => 'is_required',
            'label' => 'Is Required',
            'type' => 'boolean',
        ]);

        CRUD::addColumn([
            'name' => 'description',
            'label' => 'Description',
        ]);

        CRUD::addColumn([
            'name' => 'option_type',
            'label' => 'Option Type',
            'type' => 'custom_html',
            'value' => function ($entry) {
                return ucfirst($entry->option_type);
            },
        ]);

        if ($optionData->option_type === 'boolean') {
            CRUD::addColumn([
                'name' => 'value_type',
                'label' => 'Value Type',
            ]);
        }

        CRUD::addColumn([
            'name' => 'default_value',
            'label' => 'Default Value',
        ]);

        if ($optionData->option_type !== 'boolean') {
            if (! empty($optionData->limit_choices)) {
                CRUD::addColumn([
                    'name' => 'limit_choices',
                    'label' => 'Limit Choices',
                    'type' => 'custom_html',
                    'value' => function ($entry) {
                        $view = '<div>';
                        $limit_choices = is_array($entry->limit_choices) ? $entry->limit_choices : json_decode($entry->limit_choices);
                        $last_key = count($limit_choices);
                        foreach ($limit_choices as $key => $value) {
                            $view .= '<span>'.$value['name'].((++$key === $last_key) ? '' : ', ').'</span>';
                        }

                        return $view .= '</div>';
                    },
                ]);
            } else {
                CRUD::addColumn([
                    'name' => 'limit_min',
                    'label' => $optionData->option_type === 'number' ? 'Limit Input Value' : 'Limit Input Characters',
                    'type' => 'custom_html',
                    'value' => function ($entry) {
                        $view = '<div>';
                        $view .= '<table class="table">
                                      <thead>
                                        <tr>
                                          <th scope="col">Min</th>
                                          <th scope="col">Max</th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                        <tr>
                                          <td>'.$entry->limit_min.'</td>
                                          <td>'.$entry->limit_max.'</td>
                                        </tr>
                                      </tbody>
                                    </table>';

                        return $view .= '</div>';
                    },
                ]);
            }
        }
    }
}
