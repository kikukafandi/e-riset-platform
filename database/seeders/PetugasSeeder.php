<?php

namespace Database\Seeders;

use App\Models\Petugas;
use App\Models\KantorBeaCukai;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PetugasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get first 2 kantor for testing
        $kantorA = KantorBeaCukai::first();
        $kantorB = KantorBeaCukai::skip(1)->first();

        // Super Admin - bisa akses semua kantor
        Petugas::create([
            'nama' => 'Super Admin',
            'jabatan' => 'Administrator',
            'nip' => '1000000001',
            'email' => 'super@domain.com',
            'password' => Hash::make('password'),
            'role' => 'super_user',
            'kantor_id' => null, // Super user tidak perlu kantor
            'is_active' => true,
        ]);

        // Petugas Kantor A
        Petugas::create([
            'nama' => 'Pelaksana Kantor A',
            'jabatan' => 'Pelaksana',
            'nip' => '1000000002',
            'email' => 'pelaksana.a@domain.com',
            'password' => Hash::make('password'),
            'role' => 'pelaksana',
            'kantor_id' => $kantorA?->id,
            'is_active' => true,
        ]);

        Petugas::create([
            'nama' => 'Eselon IV Kantor A',
            'jabatan' => 'Kepala Seksi',
            'nip' => '1000000003',
            'email' => 'eselon4.a@domain.com',
            'password' => Hash::make('password'),
            'role' => 'eselon_iv',
            'kantor_id' => $kantorA?->id,
            'is_active' => true,
        ]);

        Petugas::create([
            'nama' => 'Eselon III Kantor A',
            'jabatan' => 'Kepala Bidang',
            'nip' => '1000000004',
            'email' => 'eselon3.a@domain.com',
            'password' => Hash::make('password'),
            'role' => 'eselon_iii',
            'kantor_id' => $kantorA?->id,
            'is_active' => true,
        ]);

        Petugas::create([
            'nama' => 'Eselon II Kantor A',
            'jabatan' => 'Kepala Kantor',
            'nip' => '1000000005',
            'email' => 'eselon2.a@domain.com',
            'password' => Hash::make('password'),
            'role' => 'eselon_ii',
            'kantor_id' => $kantorA?->id,
            'is_active' => true,
        ]);

        // Petugas Kantor B (untuk testing isolasi)
        if ($kantorB) {
            Petugas::create([
                'nama' => 'Pelaksana Kantor B',
                'jabatan' => 'Pelaksana',
                'nip' => '1000000006',
                'email' => 'pelaksana.b@domain.com',
                'password' => Hash::make('password'),
                'role' => 'pelaksana',
                'kantor_id' => $kantorB->id,
                'is_active' => true,
            ]);

            Petugas::create([
                'nama' => 'Eselon IV Kantor B',
                'jabatan' => 'Kepala Seksi',
                'nip' => '1000000007',
                'email' => 'eselon4.b@domain.com',
                'password' => Hash::make('password'),
                'role' => 'eselon_iv',
                'kantor_id' => $kantorB->id,
                'is_active' => true,
            ]);

            Petugas::create([
                'nama' => 'Eselon II Kantor B',
                'jabatan' => 'Kepala Kantor',
                'nip' => '1000000008',
                'email' => 'eselon2.b@domain.com',
                'password' => Hash::make('password'),
                'role' => 'eselon_ii',
                'kantor_id' => $kantorB->id,
                'is_active' => true,
            ]);
        }
    }
}
