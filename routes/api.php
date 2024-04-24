<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\WargaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'show']);
    Route::get('/warga', [WargaController::class, 'index']);
    Route::post('/warga', [WargaController::class, 'store']);
    Route::get('/warga/{warga}', [WargaController::class, 'show']);
    Route::put('/warga/{warga}', [WargaController::class, 'update']);
    Route::delete('/warga/{warga}', [WargaController::class, 'destroy']);
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
