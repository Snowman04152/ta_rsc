<?php

namespace App\Http\Middleware;

use Auth;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        if ($request->expectsJson()) {
            return null;
        } else {
            if (Auth::guard('web')->check()) {
                return route('dashboard');
            } else {
                return route('loginuser');
            }
            if (Auth::guard('admin')->check()) {
                return route('dashboardadmin');
            } else {
                return route('loginadmin');
            }
        }
    }
    // protected function redirectTo(Request $request): ?string
    // {
    //     return $request->expectsJson() ? null : route('login');
    // }

}
