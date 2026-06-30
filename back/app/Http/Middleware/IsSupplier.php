<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsSupplier
{
    public function handle(Request $request, Closure $next)
    {
        // چک کن که کاربر لاگین کرده باشه و نقش تامین‌کننده (مثلاً 3) داشته باشه
        if (auth()->check() && auth()->user()->role_id == 3) {
            return $next($request);
        }

        return response()->json(['message' => 'دسترسی غیرمجاز'], 403);
    }
}
