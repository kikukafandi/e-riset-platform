<?php

namespace Database\Seeders;

use App\Models\KantorBeaCukai;
use Illuminate\Database\Seeder;

class KantorBeaCukaiSeeder extends Seeder
{
    public function run(): void
    {
        $kantors = [
            // DKI Jakarta
            ['nama_kantor' => 'Kanwil DJBC Jakarta', 'kode_kantor' => 'JKT001', 'provinsi' => 'DKI Jakarta', 'kota' => 'Jakarta Pusat', 'alamat' => 'Jl. Jend. A. Yani, Jakarta Pusat', 'jenis_kantor' => 'kanwil'],
            ['nama_kantor' => 'KPPBC TMP A Soekarno Hatta', 'kode_kantor' => 'JKT002', 'provinsi' => 'DKI Jakarta', 'kota' => 'Tangerang', 'alamat' => 'Bandara Soekarno Hatta, Tangerang', 'jenis_kantor' => 'kppbc'],
            ['nama_kantor' => 'KPPBC Tanjung Priok', 'kode_kantor' => 'JKT003', 'provinsi' => 'DKI Jakarta', 'kota' => 'Jakarta Utara', 'alamat' => 'Pelabuhan Tanjung Priok, Jakarta Utara', 'jenis_kantor' => 'kppbc'],
            
            // Jawa Barat
            ['nama_kantor' => 'Kanwil DJBC Jawa Barat', 'kode_kantor' => 'JBR001', 'provinsi' => 'Jawa Barat', 'kota' => 'Bandung', 'alamat' => 'Jl. Asia Afrika, Bandung', 'jenis_kantor' => 'kanwil'],
            ['nama_kantor' => 'KPPBC Bandung', 'kode_kantor' => 'JBR002', 'provinsi' => 'Jawa Barat', 'kota' => 'Bandung', 'alamat' => 'Jl. Pasteur, Bandung', 'jenis_kantor' => 'kppbc'],
            ['nama_kantor' => 'KPPBC Cirebon', 'kode_kantor' => 'JBR003', 'provinsi' => 'Jawa Barat', 'kota' => 'Cirebon', 'alamat' => 'Jl. Siliwangi, Cirebon', 'jenis_kantor' => 'kppbc'],
            
            // Jawa Tengah
            ['nama_kantor' => 'Kanwil DJBC Jawa Tengah', 'kode_kantor' => 'JTE001', 'provinsi' => 'Jawa Tengah', 'kota' => 'Semarang', 'alamat' => 'Jl. Pemuda, Semarang', 'jenis_kantor' => 'kanwil'],
            ['nama_kantor' => 'KPPBC Semarang', 'kode_kantor' => 'JTE002', 'provinsi' => 'Jawa Tengah', 'kota' => 'Semarang', 'alamat' => 'Pelabuhan Tanjung Mas, Semarang', 'jenis_kantor' => 'kppbc'],
            ['nama_kantor' => 'KPPBC Solo', 'kode_kantor' => 'JTE003', 'provinsi' => 'Jawa Tengah', 'kota' => 'Surakarta', 'alamat' => 'Jl. Slamet Riyadi, Solo', 'jenis_kantor' => 'kppbc'],
            
            // Jawa Timur
            ['nama_kantor' => 'Kanwil DJBC Jawa Timur', 'kode_kantor' => 'JTI001', 'provinsi' => 'Jawa Timur', 'kota' => 'Surabaya', 'alamat' => 'Jl. Pahlawan, Surabaya', 'jenis_kantor' => 'kanwil'],
            ['nama_kantor' => 'KPPBC Tanjung Perak', 'kode_kantor' => 'JTI002', 'provinsi' => 'Jawa Timur', 'kota' => 'Surabaya', 'alamat' => 'Pelabuhan Tanjung Perak, Surabaya', 'jenis_kantor' => 'kppbc'],
            ['nama_kantor' => 'KPPBC Malang', 'kode_kantor' => 'JTI003', 'provinsi' => 'Jawa Timur', 'kota' => 'Malang', 'alamat' => 'Jl. Veteran, Malang', 'jenis_kantor' => 'kppbc'],
            
            // Bali
            ['nama_kantor' => 'Kanwil DJBC Bali Nusra', 'kode_kantor' => 'BAL001', 'provinsi' => 'Bali', 'kota' => 'Denpasar', 'alamat' => 'Jl. Raya Puputan, Denpasar', 'jenis_kantor' => 'kanwil'],
            ['nama_kantor' => 'KPPBC Ngurah Rai', 'kode_kantor' => 'BAL002', 'provinsi' => 'Bali', 'kota' => 'Denpasar', 'alamat' => 'Bandara Ngurah Rai, Denpasar', 'jenis_kantor' => 'kppbc'],
            
            // Sumatera Utara
            ['nama_kantor' => 'Kanwil DJBC Sumut', 'kode_kantor' => 'SUT001', 'provinsi' => 'Sumatera Utara', 'kota' => 'Medan', 'alamat' => 'Jl. Putri Hijau, Medan', 'jenis_kantor' => 'kanwil'],
            ['nama_kantor' => 'KPPBC Belawan', 'kode_kantor' => 'SUT002', 'provinsi' => 'Sumatera Utara', 'kota' => 'Medan', 'alamat' => 'Pelabuhan Belawan, Medan', 'jenis_kantor' => 'kppbc'],
            
            // Sulawesi Selatan
            ['nama_kantor' => 'Kanwil DJBC Sulsel', 'kode_kantor' => 'SLS001', 'provinsi' => 'Sulawesi Selatan', 'kota' => 'Makassar', 'alamat' => 'Jl. Urip Sumoharjo, Makassar', 'jenis_kantor' => 'kanwil'],
            ['nama_kantor' => 'KPPBC Soekarno Hatta Makassar', 'kode_kantor' => 'SLS002', 'provinsi' => 'Sulawesi Selatan', 'kota' => 'Makassar', 'alamat' => 'Pelabuhan Soekarno Hatta, Makassar', 'jenis_kantor' => 'kppbc'],
            
            // Kalimantan Timur
            ['nama_kantor' => 'Kanwil DJBC Kaltim', 'kode_kantor' => 'KTI001', 'provinsi' => 'Kalimantan Timur', 'kota' => 'Balikpapan', 'alamat' => 'Jl. Jend. Sudirman, Balikpapan', 'jenis_kantor' => 'kanwil'],
            ['nama_kantor' => 'KPPBC Balikpapan', 'kode_kantor' => 'KTI002', 'provinsi' => 'Kalimantan Timur', 'kota' => 'Balikpapan', 'alamat' => 'Pelabuhan Semayang, Balikpapan', 'jenis_kantor' => 'kppbc'],
        ];

        foreach ($kantors as $kantor) {
            KantorBeaCukai::create($kantor);
        }
    }
}