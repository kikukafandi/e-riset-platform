<?php

namespace Database\Seeders;

use App\Models\DokumenPermohonan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DokumenPermohonanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DokumenPermohonan::create([
            'topik_tujuan_riset' => 'Efisiensi Energi pada IoT',
            'judul_riset' => 'Analisis Efisiensi Energi pada Sistem IoT',
            'proposal' => 'Penelitian ini bertujuan untuk ...',
            'user_id' => 1,
            'unit_kerja_lokasi_riset' => 'Laboratorium Embedded System',
            'jenis_permohonan_data' => 'Data konsumsi energi IoT',
            'data_statistik_yang_diminta' => 'Data penggunaan listrik selama 1 bulan',
            'kuisioner' => 'Pertanyaan terkait efisiensi sistem IoT',
            'pedoman_wawancara' => 'Diskusi teknis dengan dosen pembimbing',
            'proposal_fgd' => 'Diskusi kelompok terkait hasil riset awal',
            'status' => 'diproses',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
