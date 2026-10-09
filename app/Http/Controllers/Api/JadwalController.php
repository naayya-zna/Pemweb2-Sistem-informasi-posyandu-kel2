<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\JadwalRequest;
use App\Http\Resources\JadwalResource;
use App\Models\Jadwal;
use App\Models\Kegiatan;
use App\Models\Pendaftaran;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class JadwalController extends Controller
{
    // GET /api/jadwal?search=&status=&kegiatan_id=&dari=&sampai=&urut=&per_page=&page=
    public function index(Request $request)
    {
        $request->validate([
            'status' => ['nullable', Rule::in(array_keys(Jadwal::STATUS))],
            'kegiatan_id' => ['nullable', 'integer'],
            'dari' => ['nullable', 'date'],
            'sampai' => ['nullable', 'date', 'after_or_equal:dari'],
            'urut' => ['nullable', Rule::in(['asc', 'desc'])],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:50'],
        ]);

        // Statistik seluruh jadwal.
        // Tidak mengikuti filter status, pencarian, maupun tanggal.
        $counts = [
            'total' => Jadwal::count(),
            'akan_datang' => Jadwal::where('status', 'akan_datang')->count(),
            'berlangsung' => Jadwal::where('status', 'berlangsung')->count(),
            'selesai' => Jadwal::where('status', 'selesai')->count(),
        ];

        $wargaId = $request->user()->warga_id;

        // Query daftar jadwal tetap mengikuti filter yang dipilih.
        $jadwals = Jadwal::query()
            ->with('kegiatan:id,judul,jenis')
            ->withCount([
                'pendaftarans as terdaftar_count' => fn ($q) =>
                    $q->whereIn('status', Pendaftaran::AKTIF),
            ])
            ->when(
                $wargaId,
                fn ($q) => $q->withExists([
                    'pendaftarans as sudah_daftar' => fn ($p) => $p
                        ->where('warga_id', $wargaId)
                        ->whereIn('status', Pendaftaran::AKTIF),
                ])
            )
            ->when(
                $request->search,
                fn ($q, $s) => $q->where(
                    fn ($w) => $w
                        ->where('lokasi', 'like', "%{$s}%")
                        ->orWhereHas(
                            'kegiatan',
                            fn ($k) => $k->where('judul', 'like', "%{$s}%")
                        )
                )
            )
            ->when(
                $request->status,
                fn ($q, $s) => $q->where('status', $s)
            )
            ->when(
                $request->kegiatan_id,
                fn ($q, $id) => $q->where('kegiatan_id', $id)
            )
            ->when(
                $request->dari,
                fn ($q, $d) => $q->whereDate('tanggal', '>=', $d)
            )
            ->when(
                $request->sampai,
                fn ($q, $d) => $q->whereDate('tanggal', '<=', $d)
            )
            ->orderBy('tanggal', $request->input('urut', 'desc'))
            ->orderBy('jam_mulai')
            ->paginate($request->integer('per_page', 10))
            ->withQueryString();

        return JadwalResource::collection($jadwals)
            ->additional([
                'success' => true,
                'counts' => $counts,
            ]);
    }

    // GET /api/jadwal/opsi
    public function opsi(): JsonResponse
    {
        return $this->sukses('OK', [
            'kegiatans' => Kegiatan::where('status', 'aktif')
                ->orderBy('judul')
                ->get(['id', 'judul']),
            'statuses' => Jadwal::STATUS,
        ]);
    }

    // POST /api/jadwal
    public function store(JadwalRequest $request): JsonResponse
    {
        $jadwal = Jadwal::create([
            ...$request->validated(),
            'status' => 'akan_datang',
        ]);

        return $this->sukses(
            'Jadwal berhasil dibuat.',
            new JadwalResource($this->withStats($jadwal, $request)),
            201
        );
    }

    // GET /api/jadwal/{jadwal}
    public function show(Request $request, Jadwal $jadwal): JsonResponse
    {
        return $this->sukses(
            'OK',
            new JadwalResource($this->withStats($jadwal, $request))
        );
    }

    // PUT /api/jadwal/{jadwal}
    public function update(JadwalRequest $request, Jadwal $jadwal): JsonResponse
    {
        if ($jadwal->status !== 'akan_datang') {
            return $this->gagal(
                'Hanya jadwal berstatus "Akan Datang" yang bisa diubah.'
            );
        }

        $jadwal->update($request->validated());

        return $this->sukses(
            'Jadwal berhasil diperbarui.',
            new JadwalResource($this->withStats($jadwal, $request))
        );
    }

    // DELETE /api/jadwal/{jadwal}
    public function destroy(Jadwal $jadwal): JsonResponse
    {
        if (
            $jadwal->pendaftarans()->exists()
            || $jadwal->pemeriksaans()->exists()
        ) {
            return $this->gagal(
                'Jadwal sudah memiliki peserta atau data pemeriksaan, '
                . 'jadi tidak bisa dihapus. Gunakan aksi Batalkan.'
            );
        }

        $jadwal->delete();

        return $this->sukses('Jadwal berhasil dihapus.');
    }

    // POST /api/jadwal/{jadwal}/mulai
    public function mulai(Request $request, Jadwal $jadwal): JsonResponse
    {
        if ($jadwal->status !== 'akan_datang') {
            return $this->gagal(
                'Hanya jadwal berstatus "Akan Datang" yang bisa dimulai.'
            );
        }

        $jadwal->update(['status' => 'berlangsung']);

        return $this->sukses(
            'Jadwal dimulai. Pemeriksaan sudah bisa dicatat.',
            new JadwalResource($this->withStats($jadwal, $request))
        );
    }

    // POST /api/jadwal/{jadwal}/selesai
    public function selesai(Request $request, Jadwal $jadwal): JsonResponse
    {
        if ($jadwal->status !== 'berlangsung') {
            return $this->gagal(
                'Hanya jadwal yang sedang berlangsung yang bisa diselesaikan.'
            );
        }

        DB::transaction(function () use ($jadwal) {
            $jadwal->update(['status' => 'selesai']);

            // Peserta terdaftar yang belum diperiksa dianggap tidak hadir.
            $jadwal->pendaftarans()
                ->where('status', 'terdaftar')
                ->update(['status' => 'tidak_hadir']);
        });

        return $this->sukses(
            'Jadwal diselesaikan.',
            new JadwalResource($this->withStats($jadwal, $request))
        );
    }

    // POST /api/jadwal/{jadwal}/batal
    public function batal(Request $request, Jadwal $jadwal): JsonResponse
    {
        if (! in_array(
            $jadwal->status,
            ['akan_datang', 'berlangsung'],
            true
        )) {
            return $this->gagal(
                'Jadwal yang sudah selesai atau batal tidak bisa dibatalkan.'
            );
        }

        DB::transaction(function () use ($jadwal) {
            $jadwal->update(['status' => 'batal']);

            $jadwal->pendaftarans()
                ->where('status', 'terdaftar')
                ->update(['status' => 'batal']);
        });

        return $this->sukses(
            'Jadwal dibatalkan.',
            new JadwalResource($this->withStats($jadwal, $request))
        );
    }

    private function withStats(
        Jadwal $jadwal,
        Request $request
    ): Jadwal {
        $jadwal->load('kegiatan:id,judul,jenis')
            ->loadCount([
                'pendaftarans as terdaftar_count' => fn ($q) =>
                    $q->whereIn('status', Pendaftaran::AKTIF),
            ]);

        if ($wargaId = $request->user()->warga_id) {
            $jadwal->loadExists([
                'pendaftarans as sudah_daftar' => fn ($q) => $q
                    ->where('warga_id', $wargaId)
                    ->whereIn('status', Pendaftaran::AKTIF),
            ]);
        }

        return $jadwal;
    }
}