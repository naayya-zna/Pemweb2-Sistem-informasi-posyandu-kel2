<?php

use App\Models\{Jadwal, Kegiatan, Warga};
use Illuminate\Support\Facades\Route;

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

Route::view('/login', 'auth.login')->name('login');
Route::view('/register', 'auth.register')->name('register');

Route::redirect('/dashboard', '/jadwal')->name('dashboard');

require __DIR__.'/web/warga.php';
require __DIR__.'/web/kegiatan.php';
require __DIR__.'/web/jadwal.php';
require __DIR__.'/web/pemeriksaan.php';