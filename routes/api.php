<?php

use App\Http\Controllers\Api\V1\Auth\RegisterController;
use App\Http\Controllers\Api\V1\Owner\PropertyController;
use App\Http\Controllers\Owner\PropertyPhotoController;
use App\Http\Controllers\Public\ApartmentController;
use App\Http\Controllers\Public\PropertySearchController;
use App\Http\Controllers\User\BookingController;
use Illuminate\Support\Facades\Route;


Route::prefix('v1')
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::prefix('owner')->group(function () {
            Route::get('properties', [PropertyController::class, 'index']);
            Route::post('properties', [PropertyController::class, 'store']);
            Route::post('properties/{property}/photos/{photo}/reorder/{newPosition}',
                [PropertyPhotoController::class, 'reorder']);
        });

        Route::prefix('user')->group(function () {
            Route::get('bookings', [BookingController::class, 'index']);
        });

        Route::post('properties/{property}/photos', [PropertyPhotoController::class, 'store']);

        Route::prefix('user')->group(function () {
            Route::resource('bookings', BookingController::class);
        });
});

Route::get('search', PropertySearchController::class);
Route::get('properties/{property}',
    \App\Http\Controllers\Public\PropertyController::class);
Route::get('apartments/{apartment}',
    ApartmentController::class);

Route::prefix('v1')
    ->group(function () {
        Route::post('auth/register', RegisterController::class);
    });


