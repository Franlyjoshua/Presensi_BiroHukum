<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\AuthenticateParticipant;
use App\Http\Middleware\AdminMiddleware; // <-- TAMBAHKAN INI

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'auth.participant' => AuthenticateParticipant::class,
            'admin' => AdminMiddleware::class, // <-- TAMBAHKAN ALIAS INI
            // 'auth' => \App\Http\Middleware\Authenticate::class, // Jika Anda perlu middleware auth standar Laravel
            // 'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class, // Jika Anda perlu middleware guest standar Laravel
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();