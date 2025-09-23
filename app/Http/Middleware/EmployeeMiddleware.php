<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeeMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::guard('employee')->check()) {
            return $next($request);
        }

        return redirect('/login')->with('error', 'Пожалуйста, войдите в систему.');
    }
} 