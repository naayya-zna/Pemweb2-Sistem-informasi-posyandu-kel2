<?php

use App\Models\{Jadwal, Kegiatan, Warga};
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\ProfileController;


Route::get('/', function () {
    $jadwals = Jadwal::with('kegiatan')
        ->where('status', 'akan_datang')
        ->whereDate('tanggal', '>=', today())
        ->orderBy('tanggal')->orderBy('jam_mulai')
        ->take(3)->get();

    $stat = [
        'warga' => Warga::count(),
        'kegiatan' => Kegiatan::where('status', 'aktif')->count(),
        'jadwal' => Jadwal::where('status', 'akan_datang')
            ->whereDate('tanggal', '>=', today())
            ->count(),
    ];

    return view('welcome', compact('jadwals', 'stat'));
})->name('home');



Route::middleware('role:admin,kader')->group(function () {

    Route::resource('jadwal', JadwalController::class)
        ->except(['index', 'show']);

});


Route::resource('jadwal', JadwalController::class)
    ->only(['index', 'show']);


Route::resource('kegiatan', KegiatanController::class);



Route::view('/login', 'auth.login')->name('login');

Route::view('/register', 'auth.register')->name('register');



Route::redirect('/dashboard', '/jadwal')
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__.'/web/warga.php';
require __DIR__.'/web/kegiatan.php';
require __DIR__.'/web/jadwal.php';
require __DIR__.'/web/pemeriksaan.php';
require __DIR__.'/auth.php';