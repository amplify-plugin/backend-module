<?php

namespace Amplify\System\Backend\Http\Controllers\Admin\Settings;

use Amplify\System\Abstracts\BackpackCustomCrudController;
use Amplify\System\Backend\Models\SystemConfiguration;
use Amplify\System\Backend\Traits\SettingOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanel;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class Prop65SettingCrudController
 *
 * @property-read CrudPanel $crud
 */
class Prop65SettingController extends BackpackCustomCrudController
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
        CRUD::setRoute(config('backpack.base.route_prefix').'/prop65-setting');
        CRUD::setEntityNameStrings('prop65-setting', 'Prop65 Settings');
    }

    /**
     * Configure the setting group name. Apply settings to all operations.
     */
    public function getSettingName(): string
    {
        return 'prop65';
    }
}
