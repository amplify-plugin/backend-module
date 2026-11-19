<?php

namespace Amplify\System\Backend\Providers;

use Amplify\System\Backend\Http\Middlewares\AdminForcePasswordReset;
use Amplify\System\Backend\Http\Middlewares\Language;
use Amplify\System\Backend\Http\Middlewares\ProductSessionClear;
use Amplify\System\Backend\Http\Middlewares\TeamsPermission;
use Amplify\System\Backend\Models\Contact;
use Illuminate\Auth\Middleware\RedirectIfAuthenticated;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        $this->aliasMiddleware('admin_password_reset_required', AdminForcePasswordReset::class);

        $this->pushMiddlewareToGroup(backpack_guard_name(), Language::class);
        $this->pushMiddlewareToGroup(backpack_guard_name(), ProductSessionClear::class);
        $this->pushMiddlewareToGroup(backpack_guard_name(), TeamsPermission::class);

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(__DIR__.'/../../routes/api.php');

            Route::middleware(['web', backpack_middleware(), 'admin_password_reset_required'])
                ->prefix(config('backpack.base.route_prefix', 'backpack'))
                ->group(__DIR__.'/../../routes/web.php');
        });

        RedirectIfAuthenticated::redirectUsing(function (Request $request) {

            if (Auth::guard(Contact::AUTH_GUARD)->check()) {
                return '/dashboard';
            }

            if (Auth::guard(backpack_guard_name())->check()) {
                return backpack_url('/dashboard');
            }

            return '/';
        });
    }
}
