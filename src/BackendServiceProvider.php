<?php

namespace Amplify\System\Backend;

use Amplify\System\Backend\Commands\CleanApiLogCommand;
use Amplify\System\Backend\Commands\CleanAuditCommand;
use Amplify\System\Backend\Commands\CleanEmailLogCommand;
use Amplify\System\Backend\Commands\CustomerRegisteredReportCommand;
use Amplify\System\Backend\Commands\BackupRunCommand;
use Amplify\System\Backend\Commands\SyncPermissionCommand;
use Amplify\System\Backend\Commands\AddProductSlugCommand;
use Amplify\System\Backend\Commands\UpdateProductImageFromStorage;
use Amplify\System\Backend\Models\Attribute;
use Amplify\System\Backend\Models\Category;
use Amplify\System\Backend\Models\Product;
use Amplify\System\Backend\Observers\AttributeObserver;
use Amplify\System\Backend\Observers\CategoryObserver;
use Amplify\System\Backend\Observers\ProductObserver;
use Amplify\System\Backend\Providers\AmplifyServiceProvider;
use Amplify\System\Backend\Providers\RouteServiceProvider;
use Amplify\System\Backend\Providers\SingletonServiceProvider;
use Amplify\System\Backend\Traits\HasBackendMenu;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class BackendServiceProvider extends ServiceProvider
{
    use HasBackendMenu;

    /**
     * Register services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/backend.php', 'amplify.backend');
        $this->mergeConfigFrom(__DIR__.'/../config/pim.php', 'amplify.pim');

        $this->app->register(SingletonServiceProvider::class);

        $this->app->register(AmplifyServiceProvider::class);

        $this->app->register(RouteServiceProvider::class);
    }

    /**
     * Bootstrap services.
     * @throws BindingResolutionException
     */
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'backend');

        $this->publishes([
            __DIR__.'/../public' => public_path('vendor/backend'),
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
                AddProductSlugCommand::class,
                UpdateProductImageFromStorage::class,
            ]);
        }

        Blade::componentNamespace('Amplify\\System\\Backend\\Components', 'backend');

        $this->registerCkeditorScriptComposer();

        $this->app->booted(function () {
            $backpackStyles = Config::get('backpack.base.styles');
            $color = Config::get('amplify.basic.color_scheme');
            $stylePath = "vendor/backend/css/color-schemes/{$color}-bundle.css";

            $backpackStyles[] = $stylePath;

            Config::set([
                'backpack.base.styles' => $backpackStyles,
                'backpack.base.project_logo' => '<img class="img-fluid" src="'.config('amplify.basic.navbar_brand', '/img/Amplify Logo 280 tagline.png').'" alt="Amplify Admin Panel">',
            ]);

            if ($this->app->runningInConsole()) {

                $schedule = app(\Illuminate\Console\Scheduling\Schedule::class);

                if (config('app.env') === 'production') {
                    $schedule->command(SyncPermissionCommand::class)
                        ->timezone(\config('amplify.schedule.timezone', \config('app.timezone', 'UTC')))
                        ->daily()
                        ->withoutOverlapping()
                        ->onOneServer();

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

                    $schedule->command(AddProductSlugCommand::class)
                        ->timezone(\config('amplify.schedule.timezone', \config('app.timezone', 'UTC')))
                        ->dailyAt('00:20')
                        ->withoutOverlapping()
                        ->onOneServer();

                    $schedule->command(BackupRunCommand::class)
                        ->timezone(\config('amplify.schedule.timezone', \config('app.timezone', 'UTC')))
                        ->dailyAt('02:00')
                        ->withoutOverlapping()
                        ->onOneServer();

                    $schedule->command(UpdateProductImageFromStorage::class, ['--rescan' => true])
                        ->timezone(\config('amplify.schedule.timezone', \config('app.timezone', 'UTC')))
                        ->dailyAt('02:30')
                        ->withoutOverlapping()
                        ->onOneServer();
                }
            }

        });

            $this->registerMenus();
    }

    /**
     * Inject CKEditor config scripts on admin layouts without per-client blank.blade.php edits.
     */
    private function registerCkeditorScriptComposer(): void
    {
        $this->app->booted(function () {
            if (!function_exists('backpack_view')) {
                return;
            }

            $layout = backpack_view('layouts.top_left');

            View::composer($layout, function () {
                View::startPush(
                    'before_scripts',
                    view('backend::partials.ckeditor-scripts-inner')
                );
            });
        });
    }

    private function loadObservers(): void
    {
        Product::observe(ProductObserver::class);
        Category::observe(CategoryObserver::class);
        Attribute::observe(AttributeObserver::class);
    }
}
