<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\KegiatanRequest;
use App\Http\Resources\KegiatanResource;
use App\Models\Kegiatan;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class KegiatanController extends Controller
{
    // READ
    public function index(Request $request): AnonymousResourceCollection
    {
        $perPage = min(max((int) $request->query('per_page', 10), 1), 100);

        $kegiatan = Kegiatan::query()
            ->when($request->query('search'), function ($q, $search) {
                $q->where('judul', 'like', "%{$search}%")
                    ->orWhere('jenis', 'like', "%{$search}%");
            })
            ->orderBy('judul')
            ->paginate($perPage)
            ->withQueryString();

        return KegiatanResource::collection($kegiatan)
            ->additional([
                'success' => true,
                'message' => 'Daftar data kegiatan.'
            ]);
    }


    // CREATE
    public function store(KegiatanRequest $request): JsonResponse
    {
        $kegiatan = Kegiatan::create(
            $request->validated()
        );

        return (new KegiatanResource($kegiatan))
            ->additional([
                'success' => true,
                'message' => 'Data kegiatan berhasil ditambahkan.'
            ])
            ->response()
            ->setStatusCode(201);
    }


    // DETAIL
    public function show(Kegiatan $kegiatan): KegiatanResource
    {
        return (new KegiatanResource($kegiatan))
            ->additional([
                'success' => true,
                'message' => 'Detail data kegiatan.'
            ]);
    }


    // UPDATE
    public function update(
        KegiatanRequest $request,
        Kegiatan $kegiatan
    ): KegiatanResource {

        $kegiatan->update(
            $request->validated()
        );

        return (new KegiatanResource($kegiatan))
            ->additional([
                'success' => true,
                'message' => 'Data kegiatan berhasil diperbarui.'
            ]);
    }


    // DELETE
    public function destroy(Kegiatan $kegiatan): JsonResponse
    {
        $kegiatan->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data kegiatan berhasil dihapus.'
        ]);
    }
}