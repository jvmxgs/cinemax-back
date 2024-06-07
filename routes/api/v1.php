<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\MovieController;
use App\Http\Controllers\Api\V1\ShowtimeController;
use App\Http\Controllers\Api\V1\TimeSlotController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('login', [AuthController::class, 'login']);

Route::middleware('api', 'auth:sanctum')->group(function () {
    Route::resource('movies', MovieController::class);
    Route::resource('showtimes', ShowtimeController::class);
    Route::resource('time-slots', TimeSlotController::class);
});
