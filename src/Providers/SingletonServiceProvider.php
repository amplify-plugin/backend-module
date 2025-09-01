<?php

namespace Amplify\System\Backend;

use Amplify\System\Backend\Services\InstanceManagerService;
use Amplify\System\Backend\Services\PunchOutApiService;
use Amplify\System\Message\Messenger;
use Amplify\System\Payment\PayApiService;
use Amplify\System\Payment\Services\CenPosPaymentGateway;
use Illuminate\Support\ServiceProvider;

class SingletonServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->app->singleton('instanceManager', function ($app) {
            return new InstanceManagerService;
        });

        $this->app->singleton('msg', function () {
            return new Messenger;
        });

        $this->app->singleton('CenPos', function () {
            return new CenPosPaymentGateway;
        });

        $this->app->singleton(PayApiService::class, function () {
            return new PayApiService;
        });

        $this->app->singleton(PunchOutApiService::class, function () {
            return new PunchOutApiService;
        });
    }
}
