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
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->validateCsrfTokens(except: [
            'register-shift', 'feedback', 'get-projects-with-shifts', 'get-locations', 'location', 'location/{id}', 'project/{id}/location'
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
