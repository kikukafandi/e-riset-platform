<?php

namespace Database\Seeders;

use App\Models\DokumenPermohonan;
use App\Models\KantorBeaCukai; // Import model Kantor
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DokumenPermohonanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan ada setidaknya satu kantor bea cukai untuk relasi
        $kantor = KantorBeaCukai::first();
        $kantorId = $kantor ? $kantor->id : 1; // Default ke 1 jika null (pastikan seeder kantor dijalankan duluan)

        DokumenPermohonan::create([
            'user_id' => 1, // Pastikan user dengan ID 1 ada (UserSeeder)
            'judul_riset' => 'Analisis Efisiensi Pelayanan Ekspor Impor',
            'topik_tujuan_riset' => 'Kepabeanan dan Cukai',
            
            // Kolom Baru: Kantor Tujuan (Foreign Key)
            'kantor_tujuan' => $kantorId, 
            
            'jenis_permohonan_data' => 'Data Sekunder dan Wawancara',
            'data_statistik_yang_diminta' => 'Data volume ekspor tahun 2024',
            
            // Dokumen Wajib (Isi dengan dummy path)
            'proposal' => 'dokumen/proposal/dummy_proposal.pdf',
            'surat_pengantar' => 'dokumen/pengantar/dummy_pengantar.pdf',
            'surat_pernyataan' => 'dokumen/pernyataan/dummy_pernyataan.pdf',
            
            // Dokumen Opsional
            'kuisioner' => 'dokumen/kuisioner/dummy_kuisioner.pdf',
            'pedoman_wawancara' => null,
            'proposal_fgd' => null,
            
            'status' => 'diproses',
            
            'service_number' => '0001-' . date('Y'),
            
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}