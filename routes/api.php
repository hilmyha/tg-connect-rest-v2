<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\DokumenWargaController;
use App\Http\Controllers\API\InformasiController;
use App\Http\Controllers\API\LaporanController;
use App\Http\Controllers\API\PanicController;
use App\Http\Controllers\API\UserController;
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
    // recap
    Route::get('/recap', [WargaController::class, 'recap']);

    // Informasi
    Route::get('/informasi', [InformasiController::class, 'index']);
    Route::post('/informasi', [InformasiController::class, 'store']);
    Route::get('/informasi/{informasi}', [InformasiController::class, 'show']);
    Route::put('/informasi/{informasi}', [InformasiController::class, 'update']);
    Route::delete('/informasi/{informasi}', [InformasiController::class, 'destroy']);

    // Laporan
    Route::get('/laporan', [LaporanController::class, 'index']);
    Route::post('/laporan', [LaporanController::class, 'store']);
    Route::get('/laporan/{laporan}', [LaporanController::class, 'show']);
    Route::put('/laporan/{laporan}', [LaporanController::class, 'update']);
    Route::delete('/laporan/{laporan}', [LaporanController::class, 'destroy']);

    // Dokumen Warga
    Route::get('/dokumen-warga', [DokumenWargaController::class, 'index']);
    Route::post('/dokumen-warga', [DokumenWargaController::class, 'store']);
    Route::get('/dokumen-warga/{dokumenWarga}', [DokumenWargaController::class, 'show']);

    // Panic
    Route::get('/panic', [PanicController::class, 'index']);
    Route::post('/panic', [PanicController::class, 'store']);
    Route::get('/panic/{panic}', [PanicController::class, 'show']);
});

Route::group(['middleware' => 'auth:sanctum', 'is_admin'], function () {
    Route::get('/admin', [UserController::class, 'index']);
    Route::post('/admin', [UserController::class, 'store']);
    Route::get('/admin/{user}', [UserController::class, 'show']);
    Route::put('/admin/{user}', [UserController::class, 'update']);
    Route::delete('/admin/{user}', [UserController::class, 'destroy']);
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
