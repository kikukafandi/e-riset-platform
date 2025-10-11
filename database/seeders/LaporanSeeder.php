<?php

namespace Database\Seeders;

use App\Models\Laporan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LaporanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Laporan::create([
            'judul_penelitian' => 'Efisiensi Energi IoT dalam Sistem Rumah Pintar',
            'dokumen_id' => 1,
            'paper_penelitian' => 'Hasil penelitian menunjukkan bahwa sistem ...',
            'link_paper' => 'https://example.com/paper-efisiensi-energi',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
