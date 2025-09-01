<?php

namespace Amplify\System\Backend\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * InstanceManager Facade
 *
 * @see \Amplify\System\Backend\Services\InstanceManagerService
 *
 * @method static mixed get($key, $setter = "__optional__")
 * @method static mixed set ($key, $setter, $force = false)
 * @method static mixed isExists ($key)
 */
class InstanceManager extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'instanceManager';
    }
}
