<?php

namespace Amplify\System\Backend\Http\Controllers\Admin\Settings;

use Amplify\System\Abstracts\BackpackCustomCrudController;
use Amplify\System\Backend\Models\SystemConfiguration;
use Amplify\System\Backend\Traits\SettingOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Support\Str;

/**
 * Class SeoSettingCrudController
 *
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class SecuritySettingController extends BackpackCustomCrudController
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
        CRUD::setRoute(config('backpack.base.route_prefix').'/security-setting');
        CRUD::setEntityNameStrings('Security Setting', 'Security Settings');
    }

    /**
     * Configure the setting group name. Apply settings to all operations.
     *
     * @return string
     */
    public function getSettingName(): string
    {
        return 'security';
    }
}
