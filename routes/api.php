<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CapsuleController;

Route::post('/capsules', [CapsuleController::class, 'store']);
Route::get('/capsules/{id}', [CapsuleController::class, 'show']);
Route::get('/public-wall', [CapsuleController::class, 'publicWall']);