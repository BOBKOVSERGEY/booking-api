<?php

use App\Http\Controllers\Api\V1\Auth\RegisterController;
use App\Http\Controllers\Api\V1\Owner\PropertyController;
use App\Http\Controllers\Api\V1\User\BookingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::prefix('v1')
    ->middleware('auth:sanctum')
    ->group(function () {
    Route::get('owner/properties', [PropertyController::class, 'index']);
    Route::post('owner/properties', [PropertyController::class, 'store']);
    Route::get('user/bookings', [BookingController::class, 'index']);

});

Route::prefix('v1')
    ->group(function () {
        Route::post('auth/register', RegisterController::class);
    });
