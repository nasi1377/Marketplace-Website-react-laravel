<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        '/desktop/avatar_upload',
        '/desktop/sendMsg',
        '/desktop/LoadMsgByUser',
        '/desktop/ReadMsgByUser',
        '/send-verify-mobile',
         'api/login', // این مسیر رو اضافه کن تا لاراول برای لاگین توکن CSRF نخواد
         'api/*', 
         'api/supplier/products/store',
     


    // یا کلاً مسیرهای API رو معاف کن

    ];
}
