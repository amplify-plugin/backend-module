<?php

namespace Amplify\System\Backend\Http\Middlewares;

use App\Models\User;
use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TeamsPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(Request): (Response|RedirectResponse)  $next
     * @return Response|RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $team_id = ($request->segment(1) == 'admin')
            ? (backpack_auth()->check() ? User::SYSTEM_TEAM_ID : null)
            : ((customer_check()) ? customer()->id : null);

        if ($team_id !== null) {
            setPermissionsTeamId($team_id);
        }

        return $next($request);
    }
}
