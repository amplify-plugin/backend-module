<?php

namespace Amplify\System\Backend\Providers;

use Amplify\System\Message\Messenger;
use Amplify\System\Payment\PayApiService;
use Amplify\System\Payment\Services\CenPosPaymentGateway;
use Amplify\System\Services\InstanceManagerService;
use Amplify\System\Services\PunchOutApiService;
use Illuminate\Support\ServiceProvider;

class SingletonServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     */
    public function register(): void
    {
        $this->app->singleton('instanceManager', fn() => new InstanceManagerService);

        $this->app->singleton('msg', fn () => new Messenger);

        $this->app->singleton('CenPos', fn () => new CenPosPaymentGateway);

        $this->app->singleton(PayApiService::class, fn () => new PayApiService);

        $this->app->singleton(PunchOutApiService::class, fn () =>new PunchOutApiService);

        $this->app->singleton('sidebar', fn() => \Amplify\System\Backend\Menus\Sidebar::make());
    }
}
