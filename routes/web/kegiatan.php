<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KegiatanController;

Route::resource('kegiatan', KegiatanController::class);