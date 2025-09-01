<?php

namespace Amplify\System\Backend\Http\Middlewares;

use App\Models\Contact;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CustomerAuthCheck
{
    private array $excluded_routes = [
        'frontend.force-reset-password',
        'frontend.force-reset-password-attempt',
    ];

    /**
     * Answer to unauthorized access request.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse|RedirectResponse
     */
    private function respondToUnauthorizedRequest($request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized.',
            ], 401);
        } else {
            return redirect()->route('frontend.login');
        }
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(Request): (Response|RedirectResponse)  $next
     * @return Response|RedirectResponse|JsonResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (customer_check()) {

            if (! in_array($request->route()->getName(), $this->excluded_routes)) {
                if ($request->user(Contact::AUTH_GUARD)->password_reset_required) {
                    if ($request->ajax() || $request->wantsJson()) {
                        return response()->json([
                            'message' => 'Required password reset.',
                        ], 500);
                    } else {
                        return redirect()->route('frontend.force-reset-password');
                    }
                }
            }

            return $next($request);
        }

        return $this->respondToUnauthorizedRequest($request);
    }
}
