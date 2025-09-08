<?php

namespace Amplify\System\Backend;

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
        $this->mergeConfigFrom(__DIR__ . '/../config/backend.php', 'amplify.backend');

        $this->app->register(SingletonServiceProvider::class);

        $this->app->register(SingletonServiceProvider::class);

        $this->app->booting(function () {
            $backpackStyles = Config::get('backpack.base.styles');
            $color = Config::get('amplify.basic.color_scheme');
            $stylePath = "css/color-schemes/{$color}-bundle.css";

            $backpackStyles[] = $stylePath;

            Config::set([
                'backpack.base.styles' => $backpackStyles,
                'backpack.base.project_logo' => '<img class="img-fluid" src="' . config('amplify.cms.logo_path', '/img/Amplify Logo 280 tagline.png') . '" alt="Amplify Admin Panel">',
            ]);
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->loadRoutesFrom(__DIR__.'/../routes/backend.php');
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        $this->loadRoutesFrom(__DIR__.'/../routes/develop.php');
    }
}
