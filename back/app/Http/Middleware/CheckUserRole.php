<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserRole
{
    public function handle(Request $request, Closure $next)
    {
        // چک می‌کنیم کاربر لاگین باشه و نقش‌اش برابر 2 باشه
        if (Auth::check() && Auth::user()->role_id == 2) {
            return $next($request);
        }

        // اگه دسترسی نداشت، خطای 403 (دسترسی غیرمجاز) برمی‌گردونیم
        return response()->json([
            'message' => 'شما مجاز به دسترسی به این بخش نیستید.'
        ], 403);
    }
}
