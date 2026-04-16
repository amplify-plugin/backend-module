<?php

namespace Amplify\System\Backend;

use Amplify\System\Backend\Commands\CleanApiLogCommand;
use Amplify\System\Backend\Commands\CleanAuditCommand;
use Amplify\System\Backend\Commands\CleanEmailLogCommand;
use Amplify\System\Backend\Commands\CustomerRegisteredReportCommand;
use Amplify\System\Backend\Commands\BackupRunCommand;
use Amplify\System\Backend\Commands\SyncPermissionCommand;
use Amplify\System\Backend\Commands\AddProductSlugCommand;
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
        $this->mergeConfigFrom(__DIR__ . '/../config/backend.php', 'amplify.backend');

        $this->app->register(SingletonServiceProvider::class);

        $this->app->register(AmplifyServiceProvider::class);

        $this->app->register(RouteServiceProvider::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'backend');

        $this->publishes([
            __DIR__ . '/../public' => public_path('vendor/backend'),
        ], 'backend-asset');

        $this->loadObservers();

        if ($this->app->runningInConsole()) {

            $this->commands([
                SyncPermissionCommand::class,
                BackupRunCommand::class,
                CleanApiLogCommand::class,
                CleanAuditCommand::class,
                CleanEmailLogCommand::class,
                CustomerRegisteredReportCommand::class,
                AddProductSlugCommand::class
            ]);
        }

        $this->app->booted(function () {
            $backpackStyles = Config::get('backpack.base.styles');
            $color = Config::get('amplify.basic.color_scheme');
            $stylePath = "vendor/backend/css/color-schemes/{$color}-bundle.css";

            $backpackStyles[] = $stylePath;

            Config::set([
                'backpack.base.styles' => $backpackStyles,
                'backpack.base.project_logo' => '<img class="img-fluid" src="' . config('amplify.basic.navbar_brand', '/img/Amplify Logo 280 tagline.png') . '" alt="Amplify Admin Panel">',
            ]);

            if ($this->app->runningInConsole()) {

                $schedule = app(\Illuminate\Console\Scheduling\Schedule::class);

                if (config('app.env') === 'production') {
                    $schedule->command(SyncPermissionCommand::class)
                        ->timezone(\config('amplify.schedule.timezone', \config('app.timezone', 'UTC')))
                        ->daily()
                        ->withoutOverlapping()
                        ->onOneServer();

                    $schedule->command(BackupRunCommand::class)
                        ->timezone(\config('amplify.schedule.timezone', \config('app.timezone', 'UTC')))
                        ->daily()
                        ->withoutOverlapping()
                        ->onOneServer();

                    $schedule->command(AddProductSlugCommand::class)
                        ->timezone(\config('amplify.schedule.timezone', \config('app.timezone', 'UTC')))
                        ->daily()
                        ->withoutOverlapping()
                        ->onOneServer();
                }

                $schedule->command(CleanAuditCommand::class)
                    ->timezone(\config('amplify.schedule.timezone', \config('app.timezone', 'UTC')))
                    ->daily()
                    ->withoutOverlapping()
                    ->onOneServer();

                $schedule->command(CleanApiLogCommand::class)
                    ->timezone(\config('amplify.schedule.timezone', \config('app.timezone', 'UTC')))
                    ->daily()
                    ->withoutOverlapping()
                    ->onOneServer();

                $schedule->command(CleanEmailLogCommand::class)
                    ->timezone(\config('amplify.schedule.timezone', \config('app.timezone', 'UTC')))
                    ->daily()
                    ->withoutOverlapping()
                    ->onOneServer();
            }
        });
    }

    private function loadObservers(): void
    {
        \Amplify\System\Backend\Models\Product::observe(\Amplify\System\Backend\Observers\ProductObserver::class);
        \Amplify\System\Backend\Models\Category::observe(\Amplify\System\Backend\Observers\CategoryObserver::class);
        \Amplify\System\Backend\Models\Attribute::observe(\Amplify\System\Backend\Observers\AttributeObserver::class);
    }
}
