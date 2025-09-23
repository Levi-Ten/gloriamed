<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuthCnam
{
    public function handle(Request $request, Closure $next)
    {
        if (!$request->session()->has('user_cnam_id')) {
            return redirect()->route('auth.login');
        }
        return $next($request);
    }
}
