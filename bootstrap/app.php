<?php

use App\Http\Middleware\CheckAccessKey;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull;
use Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance;
use Illuminate\Foundation\Http\Middleware\TrimStrings;
use Illuminate\Http\Middleware\HandleCors;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Routing\Middleware\ThrottleRequests;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        api: __DIR__.'/../routes/api.php',
        apiPrefix: '/api/v1',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // 🟢 Global middleware (optional)
        $middleware->use([
            HandleCors::class,
            TrimStrings::class,
            ConvertEmptyStringsToNull::class,
            PreventRequestsDuringMaintenance::class,
        ]);

        // 🟡 Middleware groups
        $middleware->group('api', [
            ThrottleRequests::class,
            SubstituteBindings::class,
        ]);

        // 🔴 Route middleware (like "check.access")
        $middleware->alias([
            'check.access' => CheckAccessKey::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
