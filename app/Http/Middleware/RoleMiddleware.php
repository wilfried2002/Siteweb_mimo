<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = auth()->user();

        if (!$user) {
            return redirect()->route('employee.login');
        }

        if (!$user->hasAnyRole($roles) && !$user->is_admin) {
            abort(403, 'Accès refusé.');
        }

        return $next($request);
    }
}
