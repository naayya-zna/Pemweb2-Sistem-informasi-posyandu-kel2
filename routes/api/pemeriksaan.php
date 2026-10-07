<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\PemeriksaanController;

Route::apiResource(
    'pemeriksaan',
    PemeriksaanController::class
);