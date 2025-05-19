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
        $middleware->alias([
            'manager' => App\Http\Middleware\ManagerMiddleware::class,
            'user' => App\Http\Middleware\UserMiddleware::class,
            'task' => App\Http\Middleware\TaskManagerMiddleware::class,
            'taskuser' => App\Http\Middleware\TaskUserMiddleware::class,
            'submituser' => App\Http\Middleware\SubmitUserMiddleware::class,
            'submitcancel' => App\Http\Middleware\SubmitCancelUserMiddleware::class,

        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
