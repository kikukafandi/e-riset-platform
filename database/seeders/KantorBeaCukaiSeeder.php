<?php

namespace Database\Seeders;

use App\Models\KantorBeaCukai;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class KantorBeaCukaiSeeder extends Seeder
{
    public function run(): void
    {
        $csvPath = base_path('kantor.csv');

        if (!file_exists($csvPath)) {
            $this->command?->warn('File kantor.csv tidak ditemukan, seeder dilewati.');
            return;
        }

        $file = new \SplFileObject($csvPath);
        $file->setFlags(\SplFileObject::READ_CSV | \SplFileObject::SKIP_EMPTY);

        $header = null;
        $rows = [];
        foreach ($file as $index => $row) {
            if ($row === [null] || $row === false) {
                continue;
            }
            // Normalize row length (some CSV readers may trim)
            $row = array_map(fn($v) => is_string($v) ? trim($v) : $v, $row);
            if ($index === 0) {
                $header = $row;
                continue;
            }
            if (count($row) < 4) {
                // Expecting columns: No.,Provinsi,Nama Kantor,Eselon
                continue;
            }
            $rows[] = [
                'no' => $row[0],
                'provinsi' => $row[1],
                'nama_kantor' => $row[2],
                'eselon' => (int)$row[3],
            ];
        }

        foreach ($rows as $entry) {
            $jenis = $this->inferJenisKantor($entry['nama_kantor']);

            KantorBeaCukai::updateOrCreate(
                [
                    'nama_kantor' => $entry['nama_kantor'],
                    'provinsi' => $entry['provinsi'],
                ],
                [
                    // Fields from CSV
                    'nama_kantor' => $entry['nama_kantor'],
                    'provinsi' => $entry['provinsi'],
                    // Additional inferred/default fields
                    'jenis_kantor' => $jenis,
                    'kota' => null,
                    'alamat' => null,
                    'kode_kantor' => null,
                    'eselon' => $entry['eselon'],
                ]
            );
        }
    }

    /**
     * Infer jenis_kantor from nama_kantor text.
     */
    private function inferJenisKantor(string $nama): string
    {
        $namaLower = Str::lower($nama);
        if (Str::contains($namaLower, ['kppbc'])) {
            return 'kppbc';
        }
        if (Str::contains($namaLower, ['kpu'])) {
            return 'kpu';
        }
        if (Str::contains($namaLower, ['kanwil'])) {
            return 'kanwil';
        }
        // Default to 'kanwil' to satisfy enum constraints in migration
        return 'kanwil';
    }
}