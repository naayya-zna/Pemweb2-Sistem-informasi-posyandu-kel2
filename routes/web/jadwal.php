<?php
use App\Http\Controllers\Api\JadwalController;
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



Route::middleware('role:admin,kader')->group(function () {

    Route::resource('jadwal', JadwalController::class)
        ->except(['index', 'show']);

});


Route::resource('jadwal', JadwalController::class)
    ->only(['index', 'show']);

Route::view('/jadwal', 'jadwal.index')->name('jadwal.index');