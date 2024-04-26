<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\InformasiController;
use App\Http\Controllers\API\WargaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'show']);

    // Warga
    Route::get('/warga', [WargaController::class, 'index']);
    Route::post('/warga', [WargaController::class, 'store']);
    Route::get('/warga/{warga}', [WargaController::class, 'show']);
    Route::put('/warga/{warga}', [WargaController::class, 'update']);
    Route::delete('/warga/{warga}', [WargaController::class, 'destroy']);

    // Informasi
    Route::get('/informasi', [InformasiController::class, 'index']);
    Route::post('/informasi', [InformasiController::class, 'store']);
    Route::get('/informasi/{informasi}', [InformasiController::class, 'show']);
    Route::put('/informasi/{informasi}', [InformasiController::class, 'update']);
    Route::delete('/informasi/{informasi}', [InformasiController::class, 'destroy']);
});

Route::group(['middleware' => 'is_admin', 'auth:sanctum'], function () {
    Route::get('/admin', function () {
        return response()->json([
            'message' => 'You are an admin!',
        ]);
    });
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
