<?php

namespace Database\Seeders;

use App\Models\Petugas;
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
        Petugas::create([
            'nama' => 'Admin Super',
            'jabatan' => 'Administrator',
            'nip' => '1000000001',
            'email' => 'super@domain.com',
            'password' => Hash::make('password'),
            'role' => 'super_user',
        ]);

        Petugas::create([
            'nama' => 'Petugas Pelaksana',
            'jabatan' => 'Pelaksana',
            'nip' => '1000000002',
            'email' => 'pelaksana@domain.com',
            'password' => Hash::make('password'),
            'role' => 'pelaksana',
        ]);

        Petugas::create([
            'nama' => 'Eselon IV',
            'jabatan' => 'Kepala Seksi',
            'nip' => '1000000003',
            'email' => 'eselon4@domain.com',
            'password' => Hash::make('password'),
            'role' => 'eselon_iv',
        ]);

        Petugas::create([
            'nama' => 'Eselon III',
            'jabatan' => 'Kepala Bidang',
            'nip' => '1000000004',
            'email' => 'eselon3@domain.com',
            'password' => Hash::make('password'),
            'role' => 'eselon_iii',
        ]);

        Petugas::create([
            'nama' => 'Eselon II',
            'jabatan' => 'Kepala Kantor',
            'nip' => '1000000005',
            'email' => 'eselon2@domain.com',
            'password' => Hash::make('password'),
            'role' => 'eselon_ii',
        ]);
    }
}
