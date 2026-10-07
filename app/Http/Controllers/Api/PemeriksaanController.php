<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pemeriksaan;
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

        $data = $query
            ->latest('tanggal')
            ->paginate($request->get('per_halaman', 10));

        return response()->json([
            'success' => true,
            'message' => 'Data pemeriksaan berhasil diambil',
            'data' => $data,
        ]);
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

        $pemeriksaan = Pemeriksaan::create($validated);

        $pemeriksaan->load([
            'warga',
            'jadwal',
            'pemeriksa'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data pemeriksaan berhasil ditambahkan',
            'data' => $pemeriksaan,
        ], 201);
    }

    public function show(Pemeriksaan $pemeriksaan)
    {
        $pemeriksaan->load([
            'warga',
            'jadwal',
            'pemeriksa'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data pemeriksaan berhasil diambil',
            'data' => $pemeriksaan,
        ]);
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

        $pemeriksaan->load([
            'warga',
            'jadwal',
            'pemeriksa'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data pemeriksaan berhasil diperbarui',
            'data' => $pemeriksaan,
        ]);
    }

    public function destroy(Pemeriksaan $pemeriksaan)
    {
        $pemeriksaan->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data pemeriksaan berhasil dihapus',
        ]);
    }
}