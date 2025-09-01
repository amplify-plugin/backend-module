<?php

namespace Amplify\System\Backend\Facades;

use Amplify\System\Backend\Services\PunchOutApiService;
use Illuminate\Support\Facades\Facade;

/**
 * Payment service Facade
 *
 * @see \Amplify\System\Backend\Services\PunchOutApiService
 */
class PunchOutApi extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return PunchOutApiService::class;
    }
}
