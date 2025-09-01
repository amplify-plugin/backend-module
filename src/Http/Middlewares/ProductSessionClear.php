<?php

namespace Amplify\System\Backend\Http\Middlewares;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ProductSessionClear
{
    /**
     * Handle an incoming request.
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (\request()->route()->getName() !== 'frontend.singleProduct') {
            Session::forget('has_sku');
            Session::forget('seopath');
        }

        return $next($request);
    }
}
