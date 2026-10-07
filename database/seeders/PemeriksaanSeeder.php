<?php

namespace Database\Seeders;

use App\Models\Pemeriksaan;
use Illuminate\Database\Seeder;

class PemeriksaanSeeder extends Seeder
{
    public function run(): void
    {
        Pemeriksaan::create([
            'warga_id' => 1,
            'jadwal_id' => 1,
            'pemeriksa_id' => 1,
            'tanggal' => '2026-10-06',

            'berat_badan' => 55.5,
            'tinggi_badan' => 165,
            'lingkar_kepala' => 55,
            'lingkar_lengan' => 25,

            'tekanan_darah' => '120/80',
            'gula_darah' => 95,

            'keluhan' => 'Tidak ada keluhan',
            'catatan' => 'Kondisi normal',
            'status_gizi' => 'Normal',
        ]);

        Pemeriksaan::create([
            'warga_id' => 2,
            'jadwal_id' => 1,
            'pemeriksa_id' => 1,
            'tanggal' => '2026-10-06',

            'berat_badan' => 60,
            'tinggi_badan' => 170,
            'lingkar_kepala' => 56,
            'lingkar_lengan' => 27,

            'tekanan_darah' => '118/78',
            'gula_darah' => 90,

            'keluhan' => 'Tidak ada',
            'catatan' => 'Pemeriksaan rutin',
            'status_gizi' => 'Normal',
        ]);
    }
}