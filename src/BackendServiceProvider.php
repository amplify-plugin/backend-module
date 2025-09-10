<?php

namespace Amplify\System\Backend;

use Amplify\System\Backend\Providers\AmplifyServiceProvider;
use Amplify\System\Backend\Providers\RouteServiceProvider;
use Amplify\System\Backend\Providers\SingletonServiceProvider;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class BackendServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/backend.php', 'amplify.backend');

        $this->app->register(SingletonServiceProvider::class);

        $this->app->register(AmplifyServiceProvider::class);

        $this->app->register(RouteServiceProvider::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'backend');

        $this->publishes([
            __DIR__.'/../public' => public_path('vendor/backend'),
        ], 'backend-asset');

        $this->app->booted(function () {
            $backpackStyles = Config::get('backpack.base.styles');
            $color = Config::get('amplify.basic.color_scheme');
            $stylePath = "vendor/backend/css/color-schemes/{$color}-bundle.css";

            $backpackStyles[] = $stylePath;

            Config::set([
                'backpack.base.styles' => $backpackStyles,
                'backpack.base.project_logo' => '<img class="img-fluid" src="'.config('amplify.cms.logo_path', '/img/Amplify Logo 280 tagline.png').'" alt="Amplify Admin Panel">',
            ]);
        });
    }
}
