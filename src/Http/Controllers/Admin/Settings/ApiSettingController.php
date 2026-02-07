<?php

namespace Amplify\System\Backend\Http\Controllers\Admin\Settings;

use Amplify\System\Abstracts\BackpackCustomCrudController;
use Amplify\System\Backend\Models\SystemConfiguration;
use Amplify\System\Backend\Traits\SettingOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanel;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class ApiSettingCrudController
 *
 * @property-read CrudPanel $crud
 */
class ApiSettingController extends BackpackCustomCrudController
{
    use SettingOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(SystemConfiguration::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/api-setting');
        CRUD::setEntityNameStrings('API Setting', 'API Settings');
    }

    /**
     * Configure the setting group name. Apply settings to all operations.
     *
     * @return string
     */
    public function getSettingName(): string
    {
        return 'api';
    }
}
