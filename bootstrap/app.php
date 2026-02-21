<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure( basePath: dirname( __DIR__ ) )
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware( function ( Middleware $middleware ): void {
        // Register session-based auth on the "web" middleware group after
        // the session middleware so the session store is available.
        $middleware->appendToGroup( 'web', App\Http\Middleware\SessionAuth::class );
    } )
    ->withExceptions( function ( Exceptions $exceptions ): void {
        //
    } )->create();
