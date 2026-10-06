<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\Kegiatan;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class JadwalController extends Controller
{
    public const STATUS = [
        'akan_datang' => 'Akan Datang',
        'berlangsung' => 'Berlangsung',
        'selesai' => 'Selesai',
        'batal' => 'Batal',
    ];

    public function index(Request $request)
    {
        $jadwals = Jadwal::with('kegiatan')
            ->when($request->status, fn ($q, $s) => $q->where('status', $s))
            ->when($request->q, fn ($q, $s) => $q->whereHas(
                'kegiatan', fn ($k) => $k->where('judul', 'like', "%{$s}%")
            ))
            ->orderByDesc('tanggal')
            ->paginate(10)
            ->withQueryString();

        return view('jadwal.index', [
            'jadwals' => $jadwals,
            'statuses' => self::STATUS,
        ]);
    }

    public function create()
    {
        return view('jadwal.create', [
            'kegiatans' => Kegiatan::where('status', 'aktif')->orderBy('judul')->get(),
            'statuses' => self::STATUS,
        ]);
    }

    public function store(Request $request)
    {
        Jadwal::create($request->validate($this->rules(true)));

        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil ditambahkan.');
    }

    public function show(Jadwal $jadwal)
    {
        $jadwal->load('kegiatan')->loadCount('pemeriksaans');

        return view('jadwal.show', ['jadwal' => $jadwal, 'statuses' => self::STATUS]);
    }

    public function edit(Jadwal $jadwal)
    {
        return view('jadwal.edit', [
            'jadwal' => $jadwal,
            'kegiatans' => Kegiatan::orderBy('judul')->get(),
            'statuses' => self::STATUS,
        ]);
    }

    public function update(Request $request, Jadwal $jadwal)
    {
        $jadwal->update($request->validate($this->rules(false)));

        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil diperbarui.');
    }

    public function destroy(Jadwal $jadwal)
    {
        if ($jadwal->pemeriksaans()->exists()) {
            return back()->with('error', 'Jadwal tidak bisa dihapus karena sudah memiliki data pemeriksaan. Ubah statusnya menjadi Batal.');
        }

        $jadwal->delete();

        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil dihapus.');
    }

    private function rules(bool $isCreate): array
    {
        return [
            'kegiatan_id' => ['required', 'exists:kegiatans,id'],
            'tanggal' => array_filter(['required', 'date', $isCreate ? 'after_or_equal:today' : null]),
            'jam_mulai' => ['required', 'date_format:H:i'],
            'jam_selesai' => ['required', 'date_format:H:i', 'after:jam_mulai'],
            'lokasi' => ['required', 'string', 'max:255'],
            'petugas' => ['nullable', 'string', 'max:255'],
            'status' => ['required', Rule::in(array_keys(self::STATUS))],
        ];
    }
}