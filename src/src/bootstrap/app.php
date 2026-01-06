<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(function () {
        // Web routes
        Route::middleware('web')->group(__DIR__ . '/../routes/web.php');

        // API routes
        Route::prefix('api')->middleware('api')->group(__DIR__ . '/../routes/api.php');

        // Console routes
        require __DIR__ . '/../routes/console.php';

        // Health check
        Route::get('/up', fn() => 'OK');
    })
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })
    ->create();
