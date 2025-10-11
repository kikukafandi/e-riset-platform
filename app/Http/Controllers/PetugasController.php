<?php

namespace App\Http\Controllers;

use App\Models\Petugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PetugasController extends Controller
{
    public function loginPetugasView()
    {
        return view('auth.login-petugas');
    }
    public function loginPetugas(Request $request)
    {
        // validasi input
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // cek login pakai guard petugas
        if (Auth::guard('petugas')->attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            return redirect()->route('dashboard.petugas')
                ->with('success', 'Selamat datang, ' . Auth::guard('petugas')->user()->nama);
        }

        return back()->with('error', 'Email atau password salah!');
    }

    public function logoutPetugas(Request $request)
    {
        Auth::guard('petugas')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login.petugas')
            ->with('success', 'Anda sudah logout.');
    }
    public function index()
    {
        $petugas = Petugas::all();
        return view('dashboard.manage-petugas.index', compact('petugas'));
    }
    public function create()
    {
        return view('dashboard.manage-petugas.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'nama'    => 'required|string|max:255',
            'email'   => 'required|email|unique:petugas,email',
            'nip'     => 'required|string|max:20|unique:petugas,nip',
            'jabatan' => 'required|string|max:100',
            'role'    => 'required|in:super_user,pelaksana,eselon_iv,eselon_iii,eselon_ii',
        ]);

        Petugas::create($request->all());

        return redirect()->route('manage.petugas')
            ->with('success', 'Petugas berhasil ditambahkan!');
    }
    public function destroy($id)
    {
        $petugas = Petugas::findOrFail($id);
        $petugas->delete();

        return redirect()->route('manage.petugas')
            ->with('success', 'Petugas berhasil dihapus!');
    }
    public function edit($id)
    {
        $petugas = Petugas::findOrFail($id);
        return view('dashboard.manage-petugas.edit', compact('petugas'));
    }
    public function update(Request $request, $id)
    {
        $petugas = Petugas::findOrFail($id);

        $request->validate([
            'nama'    => 'required|string|max:255',
            'email'   => 'required|email|unique:petugas,email,' . $petugas->id,
            'nip'     => 'required|string|max:20|unique:petugas,nip,' . $petugas->id,
            'jabatan' => 'required|string|max:100',
            'role'    => 'required|string|max:50',
        ]);

        $petugas->update($request->all());

        return redirect()->route('manage.petugas')
            ->with('success', 'Petugas berhasil diperbarui!');
    }
}
