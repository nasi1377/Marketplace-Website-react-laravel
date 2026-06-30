<?php

namespace App\Http\Middleware; // این خط خیلی مهمه

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckBarberRole
{
    public function handle(Request $request, Closure $next)
    {
        // ... کدهای قبلی
        if (Auth::check() && Auth::user()->role_id == 4) {
            return $next($request);
        }
        return response()->json(['message' => 'دسترسی غیرمجاز!'], 403);
    }
}
