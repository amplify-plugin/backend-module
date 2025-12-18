<?php

namespace Amplify\System\Backend\Http\Middlewares;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class Language
{
    public array $fakeFields = [
        '_email',
        '_password',
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        App::setLocale(session('locale_lang', config('app.fallback_locale')));

        if (in_array($request->method(), ['POST', 'PUT', 'PATCH', 'DELETE'])) {
            foreach ($this->fakeFields as $field) {
                $request->request->remove($field);
            }
        }

        return $next($request);
    }
}
