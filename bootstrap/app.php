<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function ($middleware) {
        $middleware->alias([
            'checkUserStatus' => \App\Http\Middleware\CheckUserStatus::class,
            'checkRole' => \App\Http\Middleware\CheckRole::class,
            'checkPermission' => \App\Http\Middleware\CheckPermission::class,
        ]);
        // Add audit middleware for login/logout tracking
        $middleware->append(\App\Http\Middleware\AuditLoginLogout::class);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
