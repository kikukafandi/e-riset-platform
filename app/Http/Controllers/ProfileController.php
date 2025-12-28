<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('dashboard.profile', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        // 1. Validasi Dasar
        $rules = [
            'nama_lengkap' => 'required|string|max:255',
            'email' => [
                'required', 
                'email', 
                Rule::unique('users')->ignore($user->id), // Abaikan email milik sendiri saat cek unique
            ],
            'no_telepon' => 'required|string|max:20',
            'alamat' => 'nullable|string',
            'nik' => 'required|string|size:16', // Asumsi NIK 16 digit
        ];

        // Validasi Password (hanya jika diisi)
        if ($request->filled('password')) {
            $rules['password'] = 'confirmed|min:6';
        }

        // Tambahan Validasi Berdasarkan Kategori (Opsional, sesuaikan dengan kolom DB Anda)
        if ($user->kategori == 'mahasiswa') {
            $rules['nim'] = 'nullable|string';
            $rules['kampus'] = 'nullable|string';
        } else {
            $rules['instansi'] = 'nullable|string';
        }

        $validated = $request->validate($rules);

        // 2. Update Data User
        $user->nama_lengkap = $request->nama_lengkap; 
        $user->email = $request->email;
        $user->no_telepon = $request->no_telepon;
        $user->alamat = $request->alamat;
        $user->nik = $request->nik;
        
        // Update field dinamis sesuai kategori
        if($user->kategori == 'mahasiswa'){
            $user->nim = $request->nim ?? $user->nim;
            $user->kampus = $request->kampus ?? $user->kampus;
        } else {
            $user->instansi = $request->instansi ?? $user->instansi;
        }

        // 3. Update Password jika diisi
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return back()->with('success', 'Profil berhasil diperbarui!');
    }
}