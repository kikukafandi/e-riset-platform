<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function loginPage()
    {
        return view('auth.login');
    }

    public function registerPage()
    {
        return view('auth.register');
    }


    public function login(Request $request)
    {
        // validasi input
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        // cari user
        $user = User::where('email', $credentials['email'])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return back()->withErrors([
                'email' => 'Email atau password salah.',
            ])->onlyInput('email');
        }

        // login user
        Auth::login($user);

        // cek kategori dulu (sementara pakai dd)
        dd([
            'message' => 'Login berhasil!',
            'user' => $user,
            'kategori' => $user->kategori
        ]);
    }


    public function register(Request $request)
    {
        // ambil kategori
        $kategori = $request->input('kategori');

        // validasi sesuai kategori
        if ($kategori === 'mahasiswa') {
            $validated = $request->validate([
                'nama_lengkap' => 'required|string|max:255',
                'nik' => 'required|string|max:50|unique:users,nik',
                'email' => 'required|email|max:255|unique:users,email',
                'no_telepon' => 'required|string|max:20',
                'alamat' => 'required|string|max:500',
                'jurusan' => 'required|string|max:255',
                'nim' => 'required|string|max:50|unique:users,nim',
                'jenjang' => 'required|string|max:50',
                'kampus' => 'required|string|max:255',
                'password' => 'required|string|min:6|confirmed',
            ]);
        } else {
            $validated = $request->validate([
                'nama_lengkap' => 'required|string|max:255',
                'nik' => 'required|string|max:50|unique:users,nik',
                'npwp' => 'nullable|string|max:50',
                'no_telepon' => 'required|string|max:20',
                'alamat' => 'required|string|max:500',
                'instansi' => 'required|string|max:255',
                'sponsor_riset' => 'nullable|string|max:255',
                'email' => 'required|email|max:255|unique:users,email',
                'password' => 'required|string|min:6|confirmed',
            ]);
        }

        // simpan user
        $user = User::create([
            'nama_lengkap' => $validated['nama_lengkap'],
            'email' => $validated['email'],
            'kategori' => $kategori,
            'nik' => $validated['nik'],
            'npwp' => $validated['npwp'] ?? null,
            'no_telepon' => $validated['no_telepon'] ?? null,
            'alamat' => $validated['alamat'] ?? null,
            'jurusan' => $validated['jurusan'] ?? null,
            'nim' => $validated['nim'] ?? null,
            'jenjang' => $validated['jenjang'] ?? null,
            'kampus' => $validated['kampus'] ?? null,
            'instansi' => $validated['instansi'] ?? null,
            'sponsor_riset' => $validated['sponsor_riset'] ?? null,
            'password' => Hash::make($validated['password']),
        ]);

        // redirect ke login dengan pesan sukses
        return redirect()->route('loginPage')->with('success', 'Akun berhasil dibuat! Silakan login.');
    }

    public function logout()
    {
        // ini untuk logout
    }
}
