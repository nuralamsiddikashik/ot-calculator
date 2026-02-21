<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\OvertimeController;
use Illuminate\Support\Facades\Route;

Route::get( '/', function () {
    return view( 'welcome' );
} );

Route::get( '/login', [AuthController::class, 'showLogin'] );
Route::post( '/login', [AuthController::class, 'login'] );
Route::middleware( [\App\Http\Middleware\SessionAuth::class] )->group( function () {
    Route::post( '/logout', [AuthController::class, 'logout'] );

    Route::get( '/', function () {
        return redirect( '/overtime' );
    } );

    Route::get( '/overtime', [OvertimeController::class, 'index'] );
    Route::get( '/overtime/list', [OvertimeController::class, 'list'] );
    Route::post( '/overtime/save', [OvertimeController::class, 'store'] );
    Route::delete( '/overtime/{id}', [OvertimeController::class, 'destroy'] );
    Route::delete( '/overtime', [OvertimeController::class, 'destroyAll'] );
} );
