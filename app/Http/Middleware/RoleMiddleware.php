<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = $request->user();

        /*
        |---------------------------------------
        | AUTH CHECK
        |---------------------------------------
        */

        if (!$user) {
            return $request->expectsJson()
                ? response()->json(['message' => 'Unauthenticated'], 401)
                : redirect('/login');
        }

        /*
        |---------------------------------------
        | ROLE CHECK
        |---------------------------------------
        */

        if (!in_array($user->role, $roles)) {
            return $request->expectsJson()
                ? response()->json(['message' => 'Forbidden'], 403)
                : abort(403, 'Unauthorized Access');
        }

        return $next($request);
    }
}