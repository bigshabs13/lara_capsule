<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CapsuleController;
use App\Http\Controllers\Auth\AuthController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api');
Route::get('/me', [AuthController::class, 'me'])->middleware('auth:api');

Route::middleware('auth:api')->group(function () {
    Route::post('/capsules', [CapsuleController::class, 'store']);
    Route::get('/capsules/{id}', [CapsuleController::class, 'show']);
    Route::get('/capsules', [CapsuleController::class, 'index']);
    Route::get('/public-wall', [CapsuleController::class, 'publicWall']);
    Route::put('/capsules/{id}', [CapsuleController::class, 'update']);
    Route::patch('/capsules/{id}', [CapsuleController::class, 'update']);
    Route::delete('/capsules/{id}', [CapsuleController::class, 'destroy']);
});