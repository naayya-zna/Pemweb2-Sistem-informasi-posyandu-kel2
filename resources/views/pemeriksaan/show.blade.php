@extends('layouts.app')

@section('content')

<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h3>Detail Pemeriksaan</h3>

        <div>

            <a href="{{ route('pemeriksaan.edit', $pemeriksaan) }}"
               class="btn btn-warning">
                Edit
            </a>

            <a href="{{ route('pemeriksaan.index') }}"
               class="btn btn-secondary">
                Kembali
            </a>

        </div>

    </div>


    <div class="row">

        {{-- Data Warga --}}
        <div class="col-md-6 mb-4">

            <div class="card h-100">

                <div class="card-header">
                    <strong>Data Warga</strong>
                </div>

                <div class="card-body">

                    <table class="table table-borderless">

                        <tr>
                            <th width="40%">Nama</th>
                            <td>{{ $pemeriksaan->warga?->nama ?? '-' }}</td>
                        </tr>

                        <tr>
                            <th>NIK</th>
                            <td>{{ $pemeriksaan->warga?->nik ?? '-' }}</td>
                        </tr>

                        <tr>
                            <th>Jenis Kelamin</th>
                            <td>{{ $pemeriksaan->warga?->jenis_kelamin ?? '-' }}</td>
                        </tr>

                        <tr>
                            <th>Kategori</th>
                            <td>{{ $pemeriksaan->warga?->kategori ?? '-' }}</td>
                        </tr>

                        <tr>
                            <th>Alamat</th>
                            <td>{{ $pemeriksaan->warga?->alamat ?? '-' }}</td>
                        </tr>

                    </table>

                </div>

            </div>

        </div>


        {{-- Data Pemeriksaan --}}
        <div class="col-md-6 mb-4">

            <div class="card h-100">

                <div class="card-header">
                    <strong>Data Pemeriksaan</strong>
                </div>

                <div class="card-body">

                    <table class="table table-borderless">

                        <tr>
                            <th width="45%">Tanggal</th>
                            <td>
                                {{ $pemeriksaan->tanggal?->format('d/m/Y') ?? '-' }}
                            </td>
                        </tr>

                        <tr>
                            <th>Jadwal</th>
                            <td>
                                {{ $pemeriksaan->jadwal?->lokasi ?? '-' }}
                            </td>
                        </tr>

                        <tr>
                            <th>Pemeriksa</th>
                            <td>
                                {{ $pemeriksaan->pemeriksa?->name ?? '-' }}
                            </td>
                        </tr>

                        <tr>
                            <th>Berat Badan</th>
                            <td>
                                {{ $pemeriksaan->berat_badan ?? '-' }} kg
                            </td>
                        </tr>

                        <tr>
                            <th>Tinggi Badan</th>
                            <td>
                                {{ $pemeriksaan->tinggi_badan ?? '-' }} cm
                            </td>
                        </tr>

                        <tr>
                            <th>Lingkar Kepala</th>
                            <td>
                                {{ $pemeriksaan->lingkar_kepala ?? '-' }} cm
                            </td>
                        </tr>

                        <tr>
                            <th>Lingkar Lengan</th>
                            <td>
                                {{ $pemeriksaan->lingkar_lengan ?? '-' }} cm
                            </td>
                        </tr>

                        <tr>
                            <th>Tekanan Darah</th>
                            <td>
                                {{ $pemeriksaan->tekanan_darah ?? '-' }}
                            </td>
                        </tr>

                        <tr>
                            <th>Gula Darah</th>
                            <td>
                                {{ $pemeriksaan->gula_darah ?? '-' }} mg/dL
                            </td>
                        </tr>

                        <tr>
                            <th>Status Gizi</th>
                            <td>

                                @if($pemeriksaan->status_gizi)

                                    <span class="badge bg-info">
                                        {{ $pemeriksaan->status_gizi }}
                                    </span>

                                @else
                                    -
                                @endif

                            </td>
                        </tr>

                    </table>

                </div>

            </div>

        </div>


        {{-- Keluhan --}}
        <div class="col-md-6 mb-4">

            <div class="card h-100">

                <div class="card-header">
                    <strong>Keluhan</strong>
                </div>

                <div class="card-body">

                    {{ $pemeriksaan->keluhan ?: 'Tidak ada keluhan.' }}

                </div>

            </div>

        </div>


        {{-- Catatan --}}
        <div class="col-md-6 mb-4">

            <div class="card h-100">

                <div class="card-header">
                    <strong>Catatan</strong>
                </div>

                <div class="card-body">

                    {{ $pemeriksaan->catatan ?: 'Tidak ada catatan.' }}

                </div>

            </div>

        </div>

    </div>

</div>

@endsection