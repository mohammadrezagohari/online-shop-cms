<?php

namespace App\Http\Middleware;

use App\Enums\Roles;
use Closure;
use Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsSuperAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::user()->hasRole(Roles::SuperAdmin)) {
            return abort(Response::HTTP_FORBIDDEN);
        }
        return $next($request);
    }
}
