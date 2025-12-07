<?php

namespace Database\Seeders;

use App\Models\TopikRiset;
use Illuminate\Database\Seeder;

class TopikRisetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $topikList = [
            'Sumber Daya Manusia dan Organisasi DJBC',
            'Kehumasan Bea Cukai',
            'Kepatuhan Bea Cukai',
            'Kepabeanan - Impor',
            'Kepabeanan - Ekspor',
            'Kepabeanan - Barang Kiriman',
            'Kepabeanan - Barang Penumpang',
            'Cukai',
            'Hukum Bea Cukai',
            'Perdagangan Internasional',
            'Teknologi Informasi',
            'Dukungan Teknis Komputer, Jaringan, dan Teknologi Lainnya',
            'Edukasi Bea Cukai',
            'Lain-lain BC',
        ];

        foreach ($topikList as $topik) {
            TopikRiset::updateOrCreate(
                ['nama_topik' => $topik],
                [
                    'nama_topik' => $topik,
                    'deskripsi' => null,
                ]
            );
        }

        $this->command->info('Topik Riset berhasil di-seed: ' . count($topikList) . ' topik');
    }
}
