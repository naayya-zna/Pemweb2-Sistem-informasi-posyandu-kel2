<?php
use App\Http\Controllers\Api\PemeriksaanController;
use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login'])->middleware('throttle:10,1');

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('me', [AuthController::class, 'me']);
        Route::post('logout', [AuthController::class, 'logout']);
    });
});

// Awalan nama "api." supaya tidak bentrok dengan nama route web (jadwal.index, dst.)
Route::name('api.')->middleware('auth:sanctum')->group(function () {
    require __DIR__.'/api/warga.php';       // Lulu
    require __DIR__.'/api/kegiatan.php';    // Diva
    require __DIR__.'/api/jadwal.php';      // Naya
    require __DIR__.'/api/pemeriksaan.php'; // Ghozi
});

