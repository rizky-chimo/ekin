<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {

        // Grup API tanpa middleware stateful
        $middleware->group('api', [
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            \Illuminate\Http\Middleware\HandleCors::class,
        ]);

        // Jika kamu punya middleware global lain, bisa ditambahkan di sini
        // $middleware->append(\App\Http\Middleware\SomeGlobalMiddleware::class);

    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })
    ->create();
