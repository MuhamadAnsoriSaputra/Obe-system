<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     */
    protected $middleware = [
        // Handle trusted proxies
        \Illuminate\Http\Middleware\TrustProxies::class,

        // Handle CORS
        \Illuminate\Http\Middleware\HandleCors::class,

        // Maintenance mode protection
        \App\Http\Middleware\PreventRequestsDuringMaintenance::class,

        // Validate post size
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,

        // Trim string inputs
        \App\Http\Middleware\TrimStrings::class,

        // Convert empty strings to null
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
    ];

    /**
     * The application's route middleware groups.
     */
    protected $middlewareGroups = [
        'web' => [
            // Cookie encryption
            \App\Http\Middleware\EncryptCookies::class,

            // Add queued cookies to response
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,

            // Start the session
            \Illuminate\Session\Middleware\StartSession::class,

            // Share errors from session to views
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,

            // Verify CSRF token
            \App\Http\Middleware\VerifyCsrfToken::class,

            // Route bindings
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'api' => [
            // Throttle API requests
            \Illuminate\Routing\Middleware\ThrottleRequests::class . ':api',

            // Route bindings
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     */
    protected $routeMiddleware = [
        // Default Laravel middleware
        'auth' => \App\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'auth.session' => \Illuminate\Session\Middleware\AuthenticateSession::class,
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
        'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,

        'role' => \App\Http\Middleware\RoleMiddleware::class,
    ];
}
