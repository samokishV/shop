<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Manager
{
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            if(Auth::user()->isManager()) {
                return $next($request);
            }
        }
        return redirect('login');
    }
}