<?php

namespace Amplify\System\Backend\Http\Controllers\Admin;

use Amplify\ErpApi\Jobs\PromptProductSyncJob;
use Amplify\ErpApi\ProductSyncService;
use Amplify\System\Abstracts\BackpackCustomCrudController;
use Amplify\System\Backend\Http\Requests\ProductSyncRequest;
use Amplify\System\Backend\Models\ProductSync;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanel;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use InvalidArgumentException;

/**
 * Class SynchronizationCrudController
 *
 * @property-read CrudPanel $crud
 */
class SynchronizationCrudController extends BackpackCustomCrudController
{
    use DeleteOperation;
    use ListOperation;
    use ShowOperation;
    use UpdateOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     *
     * @throws Exception
     */
    public function setup()
    {
        CRUD::setModel(ProductSync::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/synchronization');
        CRUD::setEntityNameStrings('synchronization', 'synchronizations');
    }

    protected function setupCustomRoutes($segment, $routeName, $controller): void
    {
        Route::get($segment.'/{id}/process', [
            'as' => $routeName.'.process',
            'uses' => $controller.'@process',
            'operation' => 'process',
        ]);

        Route::get($segment.'/bulk-process', [
            'as' => $routeName.'.bulk-process',
            'uses' => $controller.'@bulkProcess',
            'operation' => 'bulkProcess',
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
        CRUD::addFilter([
            'name' => 'update_action',
            'label' => 'Action',
            'type' => 'dropdown',
        ],
            [
                'create' => 'New Entry',
                'update' => 'Data Updated',
                'delete' => 'Item Deleted',
            ],
            function ($value) {
                if ($value == 'create') {
                    $this->crud->addClause('where', 'update_action', ProductSyncService::ACTION_NEW);
                } elseif ($value == 'update') {
                    $this->crud->addClause('whereIn', 'update_action', [ProductSyncService::ACTION_UPDATE, ProductSyncService::ACTION_CHANGE]);
                } elseif ($value == 'delete') {
                    $this->crud->addClause('where', 'update_action', ProductSyncService::ACTION_DELETE);
                }
            });

        CRUD::addFilter([
            'name' => 'is_processed',
            'label' => 'Processed',
            'type' => 'dropdown',
        ],
            [
                '1' => 'Yes',
                '0' => 'No',

            ],
            function ($value) {
                $this->crud->addClause('where', 'is_processed', '=', $value);
            });

        CRUD::addFilter([
            'name' => 'error',
            'label' => 'Failed?',
            'type' => 'dropdown',
        ],
            [
                1 => 'Yes',
                0 => 'No',

            ],
            function ($value) {
                $this->crud->addClause(function ($query) use ($value) {
                    return ($value == 1)
                        ? $query->whereNotNull('error')
                        : $query->whereNull('error');
                });
            });

        $this->crud->enableBulkActions();

        $this->crud->addButton('top', 'bulk_process', 'view', 'backend::buttons.bulk_sync_process', 'beginning');

        $this->crud->removeButton('update');

        $this->crud->addButton('line', 'process', 'view', 'backend::buttons.sync_process', 'beginning');

        CRUD::addColumn([
            'name' => 'id',
            'label' => 'ID',
            'type' => 'custom_html',
            'value' => function ($productSync) {
                return match (true) {
                    !empty($productSync->error) => "<span>{$productSync->id} <sup class='badge text-danger px-0 font-weight-bold'>Failed</sup></span>",
                    $productSync->is_processed => "<span>{$productSync->id} <sup class='badge text-success px-0 font-weight-bold'>Processed</sup></span>",
                    default => "<span>{$productSync->id}</span>"
                };
            },
        ]);
        CRUD::column('item_number');
        CRUD::column('update_action');
        CRUD::column('description_1');
        CRUD::column('description_2');
        CRUD::column('list_price')->type('text');
        CRUD::column('brand');
        CRUD::column('allow_backorder')->type('boolean');
        CRUD::column('created_at');
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
        CRUD::setValidation(ProductSyncRequest::class);

        CRUD::field('item_number');
        CRUD::field('description_1');
        CRUD::field('description_2');
        CRUD::field('item_class');
        CRUD::field('list_price')->type('text');
        CRUD::field('manufacturer');
        CRUD::field('brand');
        CRUD::field('price_class');
        CRUD::field('pricing_unit_of_measure');
        CRUD::field('primary_vendor');
        CRUD::field('unit_of_measure');
        CRUD::field('update_action');
        CRUD::field('is_processed')->type('boolean');
        CRUD::field('allow_backorder')->type('boolean');
        CRUD::field('error')->type('textarea');
    }

    /**
     * Define what happens when the Show operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-show
     *
     * @return void
     */
    protected function setupShowOperation()
    {
        CRUD::column('created_at')->type('datetime');
        CRUD::column('updated_at')->type('datetime');
        CRUD::column('error')->type('textarea');
        CRUD::column('item_number');
        CRUD::column('update_action');
        CRUD::column('description_1');
        CRUD::column('description_2');
        CRUD::column('item_class');
        CRUD::column('price_class');
        CRUD::column('list_price')->type('text');
        CRUD::column('unit_of_measure');
        CRUD::column('pricing_unit_of_measure');
        CRUD::column('manufacturer');
        CRUD::column('primary_vendor')->label('Vendor');
        CRUD::column('standard_part_number')->type('text')->label('Standard/ Manufacturer Part Number');
        CRUD::column('brand');
        CRUD::column('is_processing')->type('boolean');
        CRUD::column('is_processed')->type('boolean');
        CRUD::column('allow_backorder')->type('boolean');
        if (config('amplify.client_code') == 'RHS') {
            CRUD::column('rhs_parts_note')->type('textarea')->label('RHS Parts Note');
        }
        CRUD::column('payload')->type('json');
    }

    /**
     * @return JsonResponse
     */
    public function process($id)
    {
        PromptProductSyncJob::dispatch([$id], backpack_user()->id)->onQueue('worker');

        return response()->json([
            'type' => 'success',
            'message' => 'Selected item(s) has been added to catalog sync process queue.'
        ]);
    }

    /**
     * @return JsonResponse
     */
    public function bulkProcess(Request $request)
    {
        $status = null;
        try {
            if ($request->has('selection') && $request->input('selection') == 'selected') {
                $productSyncList = array_values($request->entries);
                $status = 'selected';
            } elseif ($request->has('selection') && $request->input('selection') == 'all') {
                $productSyncList = [0 => 'all'];
            }

            if (!empty($productSyncList)) {

                PromptProductSyncJob::dispatch($productSyncList, backpack_user()->id)->onQueue('worker');

                return response()->json([
                    'type' => 'success',
                    'message' => $status == 'selected'
                        ? 'Selected item(s) has been added to catalog sync process queue.'
                        : 'All Remaining item(s) have been added to catalog sync process queue.',
                ]);
            } else {
                throw new InvalidArgumentException('No Entries available to process');
            }
        } catch (Exception $exception) {
            return response()->json([
                'type' => 'error',
                'message' => $exception->getMessage(),
            ]);
        }
    }
}
