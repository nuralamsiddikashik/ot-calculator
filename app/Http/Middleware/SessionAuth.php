<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SessionAuth {
    /**
     * Handle an incoming request.
     */
    public function handle( Request $request, Closure $next ) {
        $path = trim( $request->path(), '/' );

        $isLoginPath = $path === 'login' || $path === '';

        // If there's no session available yet (e.g., running in non-HTTP context), skip
        if ( !$request->hasSession() ) {
            return $next( $request );
        }

        // If user is logged in, prevent access to login page
        if ( $request->session()->has( 'user_id' ) ) {
            if ( $isLoginPath ) {
                return redirect( '/overtime' );
            }
            return $next( $request );
        }

        // Not logged in: allow only login routes
        if ( $isLoginPath ) {
            return $next( $request );
        }

        return redirect( '/login' );
    }
}
