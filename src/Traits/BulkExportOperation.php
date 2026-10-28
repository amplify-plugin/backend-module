<?php

namespace Amplify\System\Backend\Traits;

use Illuminate\Support\Facades\Route;

trait BulkExportOperation
{
    /**
     * Define which routes are needed for this operation.
     *
     * @param  string  $segment  Name of the current entity (singular). Used as first URL segment.
     * @param  string  $routeName  Prefix of the route name.
     * @param  string  $controller  Name of the current CrudController.
     */
    protected function setupBulkExportRoutes($segment, $routeName, $controller)
    {
        Route::post($segment.'/bulk-export', [
            'as'        => $routeName.'.bulkExport',
            'uses'      => $controller.'@bulkExport',
            'operation' => 'bulkExport',
        ]);
    }

    /**
     * Add the default settings, buttons, etc that this operation needs.
     */
    protected function setupBulkDeleteDefaults()
    {
        $this->crud->allowAccess('bulkExport');

        $this->crud->operation('bulkExport', function () {
            $this->crud->loadDefaultOperationSettingsFromConfig();
        });

        $this->crud->operation('list', function () {
            $this->crud->enableBulkActions();
            $this->crud->addButton('bottom', 'bulk_export', 'view', 'backend::buttons.bulk_export');
        });
    }

    /**
     * Delete multiple entries in one go.
     *
     * @return array
     */
    public function bulkExport()
    {
        $this->crud->hasAccessOrFail('bulkExport');

        $entries = request()->input('entries', []);
        $deletedEntries = [];

        foreach ($entries as $key => $id) {
            if ($entry = $this->crud->model->find($id)) {
                $deletedEntries[] = $entry->delete();
            }
        }

        return $deletedEntries;
    }

}