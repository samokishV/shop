<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle($request, Closure $next, ... $roles)
    {
        if (empty($roles)) {
            $roles = ['admin'];
        }

        foreach ($roles as $role) {
            if (Auth::user() && $request->user()->role === $role) {
                return $next($request);
            }
        }
        return redirect('login');
    }
}
