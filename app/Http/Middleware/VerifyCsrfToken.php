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
        // 🚨 लॉगआउट राउट को CSRF सुरक्षा जांच से बाहर रखा गया है ताकि 419 एरर कभी न आए
        '/farmer-logout',
    ];
}