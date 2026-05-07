<?php

namespace Amplify\System\Backend\Http\Middlewares;

use Amplify\System\Backend\Models\User;
use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TeamsPermission
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response|RedirectResponse) $next
     * @return Response|RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

        if (config('permission.teams')) {

            $teamId = null;

            if ($request->is('admin/*')) {
                if (backpack_auth()->check()) {
                    $teamId = USER::SYSTEM_TEAM_ID;
                }
            } else {
                if (customer_check()) {
                    $teamId = customer()->getKey();
                }
            }

            setPermissionsTeamId($teamId);
        }

        return $next($request);
    }
}
