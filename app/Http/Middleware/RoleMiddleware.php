<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  mixed ...$roles
     * @return mixed
     */
    public function handle($request, Closure $next, ...$roles)
    {
        // Kalau user belum login = dianggap customer
        if (!Auth::check()) {
            if (in_array('customer', $roles)) {
                return $next($request);
            }
            abort(403, 'Access Denied');
        }

        // Kalau user login, cek role dari DB
        $userRole = Auth::user()->role;

        if (in_array($userRole, $roles)) {
            return $next($request);
        }

        abort(403, 'Access Denied');
    }
}