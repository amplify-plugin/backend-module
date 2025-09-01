<?php

namespace Amplify\System\Backend;

use Amplify\System\Backend\Providers\SingletonServiceProvider;
use Illuminate\Support\ServiceProvider;

class BackendServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/backend.php', 'amplify.backend');

        $this->app->register(SingletonServiceProvider::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
