<?php

namespace App\Http\Controllers;

use App\Models\Pemeriksaan;
use App\Models\Warga;
use App\Models\Jadwal;
use App\Models\User;
use Illuminate\Http\Request;

class PemeriksaanController extends Controller
{
    public function index(Request $request)
    {
        $query = Pemeriksaan::with([
            'warga',
            'jadwal',
            'pemeriksa'
        ]);

        if ($request->filled('search')) {
            $search = $request->search;

            $query->whereHas('warga', function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%");
            });
        }

        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal', $request->tanggal);
        }

        $pemeriksaans = $query
            ->latest('tanggal')
            ->paginate(10)
            ->withQueryString();

        return view(
            'pemeriksaan.index',
            compact('pemeriksaans')
        );
    }

    public function create()
    {
        $wargas = Warga::orderBy('nama')->get();
        $jadwals = Jadwal::orderByDesc('tanggal')->get();
        $users = User::orderBy('name')->get();

        return view(
            'pemeriksaan.create',
            compact('wargas', 'jadwals', 'users')
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'warga_id' => 'required|exists:wargas,id',
            'jadwal_id' => 'required|exists:jadwals,id',
            'pemeriksa_id' => 'required|exists:users,id',
            'tanggal' => 'required|date',

            'berat_badan' => 'nullable|numeric|min:0|max:500',
            'tinggi_badan' => 'nullable|numeric|min:0|max:300',
            'lingkar_kepala' => 'nullable|numeric|min:0|max:100',
            'lingkar_lengan' => 'nullable|numeric|min:0|max:100',

            'tekanan_darah' => 'nullable|string|max:20',
            'gula_darah' => 'nullable|numeric|min:0|max:1000',

            'keluhan' => 'nullable|string',
            'catatan' => 'nullable|string',

            'status_gizi' => 'nullable|string|max:50',
        ]);

        Pemeriksaan::create($validated);

        return redirect()
            ->route('pemeriksaan.index')
            ->with('success', 'Data pemeriksaan berhasil ditambahkan.');
    }

    public function show(Pemeriksaan $pemeriksaan)
    {
        $pemeriksaan->load([
            'warga',
            'jadwal',
            'pemeriksa'
        ]);

        return view(
            'pemeriksaan.show',
            compact('pemeriksaan')
        );
    }

    public function edit(Pemeriksaan $pemeriksaan)
    {
        $wargas = Warga::orderBy('nama')->get();
        $jadwals = Jadwal::orderByDesc('tanggal')->get();
        $users = User::orderBy('name')->get();

        return view(
            'pemeriksaan.edit',
            compact(
                'pemeriksaan',
                'wargas',
                'jadwals',
                'users'
            )
        );
    }

    public function update(
        Request $request,
        Pemeriksaan $pemeriksaan
    ) {
        $validated = $request->validate([
            'warga_id' => 'required|exists:wargas,id',
            'jadwal_id' => 'required|exists:jadwals,id',
            'pemeriksa_id' => 'required|exists:users,id',
            'tanggal' => 'required|date',

            'berat_badan' => 'nullable|numeric|min:0|max:500',
            'tinggi_badan' => 'nullable|numeric|min:0|max:300',
            'lingkar_kepala' => 'nullable|numeric|min:0|max:100',
            'lingkar_lengan' => 'nullable|numeric|min:0|max:100',

            'tekanan_darah' => 'nullable|string|max:20',
            'gula_darah' => 'nullable|numeric|min:0|max:1000',

            'keluhan' => 'nullable|string',
            'catatan' => 'nullable|string',

            'status_gizi' => 'nullable|string|max:50',
        ]);

        $pemeriksaan->update($validated);

        return redirect()
            ->route('pemeriksaan.index')
            ->with('success', 'Data pemeriksaan berhasil diperbarui.');
    }

    public function destroy(Pemeriksaan $pemeriksaan)
    {
        $pemeriksaan->delete();

        return redirect()
            ->route('pemeriksaan.index')
            ->with('success', 'Data pemeriksaan berhasil dihapus.');
    }
}