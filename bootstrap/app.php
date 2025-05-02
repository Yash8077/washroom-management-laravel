<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
// 1. Import your middleware class
use App\Http\Middleware\CheckRole;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // 2. Register the alias inside the alias() method
        $middleware->alias([
            'role' => CheckRole::class, // Add this line
            // Add any other route middleware aliases here
            // e.g., 'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
        ]);

        // You can configure other middleware aspects here too (global, groups, etc.)
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Exception handling configuration
    })->create();