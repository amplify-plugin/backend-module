<?php

namespace Amplify\System\Backend\Http\Controllers\Admin;

use Amplify\System\Abstracts\BackpackCustomCrudController;
use Amplify\System\Backend\Http\Requests\BrandRequest;
use Amplify\System\Backend\Models\Brand;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/**
 * Class BrandCrudController
 *
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class BrandCrudController extends BackpackCustomCrudController
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
     */
    public function setup(): void
    {
        CRUD::setModel(Brand::class);
        CRUD::setRoute(config('backpack.base.route_prefix').'/brand');
        CRUD::setEntityNameStrings('brand', 'brands');
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
     */
    protected function setupListOperation(): void
    {
        $this->crud->query->withTrashed();

        CRUD::addFilter(
            [
                'name' => 'featured',
                'type' => 'dropdown',
                'label' => 'Featured',
            ],
            fn () => ['0' => 'No', '1' => 'Yes'],
            fn ($value) => $this->crud->addClause('where', 'featured', '=', $value)
        );

        CRUD::addFilter(
            [
                'name' => 'status',
                'type' => 'select2',
                'label' => 'Status',
            ],
            fn () => ['published' => 'Published', 'archived' => 'Archived'],
            function ($value) {
                if ($value === 'archived') {
                    $this->crud->addClause('onlyTrashed');
                } elseif ($value === 'published') {
                    $this->crud->addClause('withoutTrashed');
                }
            }
        );

        CRUD::addColumn(['name' => 'id']);
        CRUD::addColumn(['name' => 'title', 'label' => 'Title']);
        CRUD::addColumn(['name' => 'slug', 'label' => 'Slug']);

        CRUD::addColumn([
            'name' => 'featured',
            'label' => 'Featured',
            'type' => 'custom_html',
            'value' => fn ($entity) => $entity->featured
                ? "<i class='la la-check text-success' title='True'></i>"
                : "<i class='la la-times text-danger' title='False'></i>",
        ]);

        CRUD::addColumn([
            'name' => 'image',
            'label' => 'Logo',
            'type' => 'image',
            'width' => '48px',
            'height' => 'auto',
        ]);

        CRUD::addColumn([
            'name' => 'deleted_at',
            'label' => 'Status',
            'type' => 'custom_html',
            'value' => fn ($model) => $model->deleted_at
                ? '<span class="rounded border border-danger text-danger px-3 py-2">Archived</span>'
                : '<span class="rounded border border-success text-success px-3 py-2">Published</span>',
        ]);

        CRUD::addButtonFromModelFunction('line', 'change_status', 'changeStatus', 'end');
    }

    /**
     * Define what happens when the Create operation is loaded.
     */
    protected function setupCreateOperation(): void
    {
        CRUD::setValidation(BrandRequest::class);

        CRUD::addField([
            'name' => 'title',
            'label' => 'Title',
            'type' => 'text',
            'tab' => 'Basic',
        ]);

        CRUD::addField([
            'name' => 'featured',
            'label' => 'Featured Brand',
            'type' => 'boolean',
            'tab' => 'Basic',
        ]);

        CRUD::addField([
            'label' => 'Logo Image',
            'name' => 'image',
            'type' => 'browse',
            'attributes' => ['id' => 'image'],
            'crop' => true,
            'aspect_ratio' => 1,
            'tab' => 'Basic',
        ]);
    }

    /**
     * Define what happens when the Update operation is loaded.
     */
    protected function setupUpdateOperation(): void
    {
        $this->setupCreateOperation();
    }

    protected function setupShowOperation(): void
    {
        CRUD::column('id')->type('number')->thousands_sep('');
        CRUD::column('title');
        CRUD::column('slug');

        CRUD::addColumn([
            'name' => 'image',
            'type' => 'image',
            'width' => '200px',
            'height' => 'auto',
        ]);

        CRUD::column('featured')->label('Featured Brand')->type('boolean');
    }

    /**
     * bulkArchive → Soft delete
     */
    public function bulkArchive(Request $request)
    {
        $ids = $request->input('entries');
        if (! empty($ids)) {
            return Brand::whereIn('id', $ids)->delete();
        }
    }

    /**
     * bulkPublish → Restore soft deleted
     */
    public function bulkPublish(Request $request)
    {
        $ids = $request->input('entries');
        if (! empty($ids)) {
            return Brand::withTrashed()->whereIn('id', $ids)->restore();
        }
    }
}
