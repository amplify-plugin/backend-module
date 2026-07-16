<?php

namespace Amplify\System\Backend\Providers;

use Amplify\System\Backend\Http\Middlewares\AdminForcePasswordReset;
use Amplify\System\Backend\Http\Middlewares\CustomerAuthCheck;
use Amplify\System\Backend\Http\Middlewares\Language;
use Amplify\System\Backend\Http\Middlewares\ProductSessionClear;
use Amplify\System\Backend\Http\Middlewares\TeamsPermission;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/admin/dashboard';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        $this->aliasMiddleware('admin_password_reset_required', AdminForcePasswordReset::class);
        $this->aliasMiddleware('customers', CustomerAuthCheck::class);

        $this->pushMiddlewareToGroup('web', Language::class);
        $this->pushMiddlewareToGroup('web', ProductSessionClear::class);
        $this->pushMiddlewareToGroup('web', TeamsPermission::class);

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(__DIR__.'/../../routes/api.php');

            Route::middleware(['web', backpack_middleware(), 'admin_password_reset_required'])
                ->prefix(config('backpack.base.route_prefix', 'backpack'))
                ->group(__DIR__.'/../../routes/web.php');
        });
    }
}
