<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::guard('employee')->check()) {
            return redirect('/login')->with('error', 'Пожалуйста, войдите в систему.');
        }

        $employee = Auth::guard('employee')->user();
        
        if (!$employee->jobTitle || !in_array($employee->jobTitle->title, ['Администратор', 'Administrator'])) {
            return redirect('/')->with('error', 'У вас нет прав для доступа к этой странице.');
        }

        return $next($request);
    }
} 