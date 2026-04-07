<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
public function handle($request, Closure $next, ...$roles)
{
    if (!Auth::guard('admin')->check()) {
        return redirect('/login');
    }

    $userRole = Auth::guard('admin')->user()->role;

    // support banyak role (kepala,petugas)
    $rolesArray = [];

    foreach ($roles as $role) {
        $rolesArray = array_merge($rolesArray, explode(',', $role));
    }

    if (!in_array($userRole, $rolesArray)) {
        abort(403);
    }

    return $next($request);
}
}
