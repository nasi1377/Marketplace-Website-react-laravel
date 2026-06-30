<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // ۱. اول چک می‌کنیم اصلاً کاربر لاگین کرده (توکن معتبره) یا نه
        if (!Auth::guard('sanctum')->check()) {
            return response()->json(['error' => 'ابتدا وارد حساب کاربری خود شوید (توکن نامعتبر)'], 401);
        }

        // ۲. حالا که مطمئنیم لاگین کرده، رولش رو چک می‌کنیم
        if (Auth::user()->role_id != 1) {
            return response()->json(['error' => 'دسترسی غیرمجاز، شما ادمین نیستید'], 403);
        }

        return $next($request);
    }
}
