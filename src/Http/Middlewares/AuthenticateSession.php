<?php

namespace Amplify\System\Backend\Http\Middlewares;

use Backpack\CRUD\app\Http\Middleware\AuthenticateSession as BackpackAuthenticateSession;
use Closure;
use Illuminate\Http\Request;

/**
 * Laravel 12 compatible replacement for Backpack's AuthenticateSession.
 *
 * Laravel 12 stores an APP_KEY-keyed HMAC of the password hash in the session
 * (see Illuminate\Session\Middleware\AuthenticateSession::hashPasswordForCookie),
 * while Backpack's implementation still compares the raw password hash, which
 * invalidates every session right after login.
 *
 * This class keeps Backpack's behavior (guard resolution, logout + alert) and
 * only aligns the session password value with Laravel 12 semantics, accepting
 * both the new HMAC format and the legacy raw hash format.
 */
class AuthenticateSession extends BackpackAuthenticateSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (! $request->hasSession() || ! $this->user) {
            return $next($request);
        }

        if ($this->guard()->viaRemember()) {
            $passwordHash = explode('|', $request->cookies->get($this->guard()->getRecallerName()))[2] ?? null;

            if (! $passwordHash || $passwordHash != $this->user->getAuthPassword()) {
                $this->logout($request);
            }
        }

        if (! $request->session()->has('password_hash_'.backpack_guard_name())) {
            $this->storePasswordHashInSession($request);
        }

        $sessionPasswordHash = $request->session()->get('password_hash_'.backpack_guard_name());

        if (! $this->validatePasswordHash($this->user->getAuthPassword(), $sessionPasswordHash)) {
            $this->logout($request);
        }

        return tap($next($request), function () use ($request) {
            if (! is_null($this->guard()->user())) {
                $this->storePasswordHashInSession($request);
            }
        });
    }

    /**
     * Store the user's current password hash in the session using
     * Laravel 12's HMAC format (with a fallback to the raw hash when
     * the guard does not support hashPasswordForCookie()).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function storePasswordHashInSession($request)
    {
        if (! $this->user) {
            return;
        }

        $request->session()->put([
            'password_hash_'.backpack_guard_name() => $this->sessionPasswordValue($this->user->getAuthPassword()),
        ]);
    }

    /**
     * Validate the stored session value against the user's current
     * password hash, accepting both the HMAC and legacy raw formats.
     *
     * @param  string  $passwordHash
     * @param  mixed  $storedValue
     * @return bool
     */
    protected function validatePasswordHash($passwordHash, $storedValue)
    {
        if (! is_string($storedValue)) {
            return false;
        }

        return hash_equals($this->sessionPasswordValue($passwordHash), $storedValue)
            || hash_equals($passwordHash, $storedValue);
    }

    /**
     * Compute the session password value using Laravel's
     * hashPasswordForCookie() behavior when available.
     *
     * @param  string  $passwordHash
     * @return string
     */
    protected function sessionPasswordValue($passwordHash)
    {
        try {
            return $this->guard()->hashPasswordForCookie($passwordHash);
        } catch (\BadMethodCallException) {
            return $passwordHash;
        }
    }
}
