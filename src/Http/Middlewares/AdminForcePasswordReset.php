<?php

namespace Amplify\System\Backend\Http\Middlewares;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AdminForcePasswordReset
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(Request): (Response|RedirectResponse)  $next
     * @return Response|RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (config('amplify.basic.force_password_reset_enabled')) {
            if (backpack_user()->password_reset_required == 1) {
                return redirect()->route('admin.force-password.reset', backpack_user()->id);
            }
        }

        return $next($request);
    }
}
