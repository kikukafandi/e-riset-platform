<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seeder untuk kategori mahasiswa
        $mahasiswaList = [
            [
                'nama_lengkap' => 'Andi Pratama',
                'email' => 'andi.mahasiswa@example.com',
                'kampus' => 'Politeknik Negeri Bandung',
                'jurusan' => 'Teknik Informatika',
                'nim' => '220101001',
                'jenjang' => 'S1',
            ],
            [
                'nama_lengkap' => 'Rina Kusuma',
                'email' => 'rina.mahasiswa@example.com',
                'kampus' => 'Politeknik Negeri Malang',
                'jurusan' => 'Teknik Komputer',
                'nim' => '220102002',
                'jenjang' => 'D3',
            ],
            [
                'nama_lengkap' => 'Budi Santoso',
                'email' => 'budi.mahasiswa@example.com',
                'kampus' => 'Politeknik Negeri Surabaya',
                'jurusan' => 'Sistem Informasi Bisnis',
                'nim' => '220103003',
                'jenjang' => 'D3',
            ],
            [
                'nama_lengkap' => 'Fitri Ananda',
                'email' => 'fitri.mahasiswa@example.com',
                'kampus' => 'Politeknik Negeri Semarang',
                'jurusan' => 'Teknik Elektro',
                'nim' => '220104004',
                'jenjang' => 'S1',
            ],
            [
                'nama_lengkap' => 'Agus Saputra',
                'email' => 'agus.mahasiswa@example.com',
                'kampus' => 'Politeknik Negeri Jember',
                'jurusan' => 'Teknik Mesin',
                'nim' => '220105005',
                'jenjang' => 'D3',
            ],
        ];

        foreach ($mahasiswaList as $mhs) {
            User::create([
                'nama_lengkap' => $mhs['nama_lengkap'],
                'email' => $mhs['email'],
                'kategori' => 'mahasiswa',
                'kampus' => $mhs['kampus'],
                'jurusan' => $mhs['jurusan'],
                'nim' => $mhs['nim'],
                'jenjang' => $mhs['jenjang'],
                'alamat' => fake()->address(),
                'no_telepon' => fake()->phoneNumber(),
                'nik' => fake()->numerify('##########'),
                'instansi' => $mhs['kampus'],
                'sponsor_riset' => 'Kampus Merdeka',
                'npwp' => fake()->numerify('###########'),
                'email_verified_at' => now(),
                'password' => Hash::make('password123'),
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Seeder untuk kategori nonmahasiswa
        $nonMahasiswaList = [
            [
                'nama_lengkap' => 'Dr. Siti Haryati',
                'email' => 'siti.nonmahasiswa@example.com',
                'instansi' => 'BRIN',
                'sponsor_riset' => 'Kemendikbud',
            ],
            [
                'nama_lengkap' => 'Ir. Dewa Putra',
                'email' => 'dewa.nonmahasiswa@example.com',
                'instansi' => 'LIPI',
                'sponsor_riset' => 'Kemenristek',
            ],
            [
                'nama_lengkap' => 'Dian Prasetyo',
                'email' => 'dian.nonmahasiswa@example.com',
                'instansi' => 'PT Teknologi Nusantara',
                'sponsor_riset' => 'Internal',
            ],
        ];

        foreach ($nonMahasiswaList as $nm) {
            User::create([
                'nama_lengkap' => $nm['nama_lengkap'],
                'email' => $nm['email'],
                'kategori' => 'nonmahasiswa',
                'kampus' => null,
                'jurusan' => null,
                'nim' => null,
                'jenjang' => null,
                'alamat' => fake()->address(),
                'no_telepon' => fake()->phoneNumber(),
                'nik' => fake()->numerify('##########'),
                'instansi' => $nm['instansi'],
                'sponsor_riset' => $nm['sponsor_riset'],
                'npwp' => fake()->numerify('###########'),
                'email_verified_at' => now(),
                'password' => Hash::make('password123'),
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
