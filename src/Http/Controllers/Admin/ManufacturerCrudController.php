<?php

namespace Amplify\System\Backend\Http\Controllers\Admin;

use Amplify\System\Abstracts\BackpackCustomCrudController;
use Amplify\System\Backend\Http\Requests\ManufacturerRequest;
use Amplify\System\Backend\Models\Manufacturer;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanel;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/**
 * Class ManufacturerCrudController
 *
 * @property-read CrudPanel $crud
 */
class ManufacturerCrudController extends BackpackCustomCrudController
{
    use CreateOperation;
    use DeleteOperation {
        destroy as traitDestroy;
    }
    use ListOperation;
    use ShowOperation;
    use UpdateOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(Manufacturer::class);
        CRUD::setRoute(config('backpack.base.route_prefix').'/manufacturer');
        CRUD::setEntityNameStrings('manufacturer', 'manufacturers');
        CRUD::enableBulkActions();
        CRUD::addButton('top', 'bulk_archive', 'view', 'crud::buttons.bulk_archive');
        CRUD::addButton('top', 'bulk_publish', 'view', 'crud::buttons.bulk_publish');
    }

    protected function setupCustomRoutes($segment, $routeName, $controller)
    {
        Route::post($segment.'/bulk-archive', [
            'as' => $routeName.'.bulk-archive',
            'uses' => $controller.'@bulkArchive',
            'operation' => 'bulkArchive',
        ]);
        Route::post($segment.'/bulk-publish', [
            'as' => $routeName.'.bulk-publish',
            'uses' => $controller.'@bulkPublish',
            'operation' => 'bulkPublish',
        ]);
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     */
    protected function setupListOperation(): void
    {
        CRUD::addFilter(
            [
                'name' => 'featured',
                'type' => 'dropdown',
                'label' => 'Featured',
            ],
            function () {
                return [
                    '0' => 'No',
                    '1' => 'Yes',
                ];
            },
            function ($value) {
                // if the filter is active
                $this->crud->addClause('where', 'featured', '=', $value);
            }
        );
        CRUD::addFilter(
            [
                'name' => 'status',
                'type' => 'select2',
                'label' => 'Status',
            ],
            function () {
                return [
                    'published' => 'Published',
                    'archived' => 'Archived',
                ];
            },
            function ($value) {
                if ($value === 'archived') {
                    $this->crud->addClause('whereNotNull', 'archived_at');
                }
            }
        );

        CRUD::addButtonFromModelFunction('line', 'change_status', 'changeStatus', 'end');

        CRUD::addColumn([
            'name' => 'id',
        ]);

        CRUD::addColumn([
            'name' => 'code',
        ]);

        CRUD::addColumn([
            'name' => 'name',
        ]);

        CRUD::addColumn([
            'name' => 'featured',
            'label' => 'Featured',
            'type' => 'custom_html',
            'value' => function ($entity) {
                $className = ($entity->featured) ? 'la-check text-success' : 'la-sync la-times text-danger';
                $title = ($entity->featured) ? 'True' : 'False';

                return "<i class='la ".$className."' title='".$title."'></i>";
            },
        ]);

        CRUD::addColumn([
            'name' => 'image',
            'label' => 'Logo',
            'type' => 'image',
            'width' => '48px',
            'height' => 'auto',
        ]);

        CRUD::addColumn([
            'name' => 'archived_at',
            'label' => 'Status',
            'type' => 'custom_html',
            'value' => function ($model) {
                if ($model->archived_at) {
                    $html = '<span class="rounded border border-danger text-danger px-3 py-2">Archived</span>';
                } else {
                    $html = '<span class="rounded border border-success text-success px-3 py-2">Published</span>';
                }

                return $html;
            },
        ]);
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     */
    protected function setupCreateOperation(): void
    {
        CRUD::setValidation(ManufacturerRequest::class);

        CRUD::addField([
            'name' => 'code',
            'label' => 'Code',
            'type' => 'text',
            'tab' => 'Basic',
        ]);

        CRUD::addField([
            'name' => 'name',
            'label' => 'Name',
            'type' => 'text',
            'tab' => 'Basic',
        ]);

        CRUD::addField([
            'name' => 'featured',
            'label' => 'Featured Manufacturer',
            'type' => 'boolean',
            'tab' => 'Basic',
        ]);

        CRUD::addField([
            'label' => 'Logo Image',
            'name' => 'image',
            'type' => 'browse',
            'attributes' => [
                'id' => 'image',
            ],
            'crop' => true,
            'aspect_ratio' => 1,
            'tab' => 'Basic',
        ]);

        CRUD::addField([
            'name' => 'contact_name',
            'label' => 'Name',
            'type' => 'text',
            'tab' => 'Contact Details',
        ]);

        CRUD::addField([
            'name' => 'contact_email',
            'label' => 'Email',
            'type' => 'text',
            'tab' => 'Contact Details',
        ]);

        CRUD::addField([
            'name' => 'contact_phone',
            'label' => 'Phone',
            'type' => 'text',
            'tab' => 'Contact Details',
        ]);

        //        CRUD::addField([
        //            'name' => 'contact_address',
        //            'label' => 'Address',
        //            'type' => 'table',
        //            'entity_singular' => 'more', // used on the "Add X" button
        //            'attributes' => ['class' => 'table-bordered'],
        //            'columns' => [
        //                'address_name' => 'Address Name',
        //                'address' => 'Address Details',
        //                'zip_code' => 'Zip Code',
        //            ],
        //            'tab' => 'Contact Details',
        //        ]);
    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     */
    protected function setupUpdateOperation(): void
    {
        $this->setupCreateOperation();
    }

    protected function setupShowOperation(): void
    {
        CRUD::column('id')->type('number')->thousands_sep('');

        CRUD::column('code');

        CRUD::column('name');

        CRUD::addColumn([
            'name' => 'image',
            'type' => 'image',
            'width' => '200px',
            'height' => 'auto',
        ]);

        CRUD::column('featured')->label(' Featured Manufacturer')->type('boolean');

        CRUD::addColumn([
            'name' => 'contact_name',
            'type' => 'custom_html',
            'value' => function ($entry) {
                return ! empty($entry->contact_name)
                    ? $entry->contact_name
                    : '-';
            },
        ]);

        CRUD::addColumn([
            'name' => 'contact_email',
            'type' => 'custom_html',
            'value' => function ($entry) {
                return ! empty($entry->contact_email)
                    ? $entry->contact_email
                    : '-';
            },
        ]);

        CRUD::addColumn([
            'name' => 'contact_phone',
            'type' => 'custom_html',
            'value' => function ($entry) {
                return ! empty($entry->contact_phone)
                    ? $entry->contact_phone
                    : '-';
            },
        ]);

        CRUD::addColumn([
            'name' => 'contact_address',
            'type' => 'table',
            'columns' => [
                'address_name' => 'Address Name',
                'address' => 'Address Details',
                'zip_code' => 'Zip Code',
            ],
        ]);

    }

    /**
     * @return array|string
     */
    public function destroy($id)
    {
        $this->crud->hasAccessOrFail('delete');
        /**
         * @var Manufacturer $model
         */
        $model = $this->crud->model->findOrFail($id);

        $imagePath = $model->image;

        if ($model->products()->doesntExist()) {
            if ($model->delete() && ! empty($imagePath)) {
                deleteFileFromPublicFolder($imagePath);
            }

            return (string) 1;
        }

        return ['error' => ["Manufacturer has {$model->products->count()} products attached."]];
    }

    /**
     * bulkArchive
     *
     * @param  mixed  $request
     * @return bool
     */
    public function bulkArchive(Request $request)
    {
        $selectedItems = $request->input('entries');
        if (! empty($selectedItems)) {
            return Manufacturer::whereIn('id', $selectedItems)
                ->where('archived_at', null)
                ->update(['archived_at' => now()]);
        }
    }

    /**
     * bulkPublish
     *
     * @param  mixed  $request
     * @return bool
     */
    public function bulkPublish(Request $request)
    {
        $selectedItems = $request->input('entries');
        if (! empty($selectedItems)) {
            return Manufacturer::whereIn('id', $selectedItems)
                ->whereNotNull('archived_at')
                ->update(['archived_at' => null]);
        }
    }
}
