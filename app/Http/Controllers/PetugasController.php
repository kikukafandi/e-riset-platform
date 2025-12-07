<?php

namespace App\Http\Controllers;

use App\Models\Petugas;
use App\Models\KantorBeaCukai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
            // Cek apakah petugas masih aktif
            $petugas = Auth::guard('petugas')->user();
            if (!$petugas->is_active) {
                Auth::guard('petugas')->logout();
                return back()->with('error', 'Akun Anda tidak aktif. Silakan hubungi administrator.');
            }

            $request->session()->regenerate();

            return redirect()->route('dashboard.petugas')
                ->with('success', 'Selamat datang, ' . $petugas->nama);
        }

        return back()->with('error', 'Email atau password salah!');
    }

    public function logoutPetugas(Request $request)
    {
        Auth::guard('petugas')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login.petugas.view')
            ->with('success', 'Anda sudah logout.');
    }

    /**
     * Halaman registrasi petugas
     */
    public function registerPetugasView()
    {
        $kantorList = KantorBeaCukai::active()->orderBy('nama_kantor')->get();
        return view('auth.register-petugas', compact('kantorList'));
    }

    /**
     * Proses registrasi petugas
     */
    public function registerPetugas(Request $request)
    {
        $request->validate([
            'nama'      => 'required|string|max:255',
            'email'     => 'required|email|unique:petugas,email',
            'nip'       => 'required|string|max:20|unique:petugas,nip',
            'jabatan'   => 'required|string|max:100',
            'role'      => 'required|in:pelaksana,eselon_iv,eselon_iii,eselon_ii',
            'kantor_id' => 'required|exists:kantor_bea_cukai,id',
            'password'  => 'required|string|min:8|confirmed',
        ], [
            'nama.required'      => 'Nama harus diisi',
            'email.required'     => 'Email harus diisi',
            'email.email'        => 'Format email tidak valid',
            'email.unique'       => 'Email sudah terdaftar',
            'nip.required'       => 'NIP harus diisi',
            'nip.unique'         => 'NIP sudah terdaftar',
            'jabatan.required'   => 'Jabatan harus diisi',
            'role.required'      => 'Role harus dipilih',
            'kantor_id.required' => 'Kantor harus dipilih',
            'kantor_id.exists'   => 'Kantor tidak valid',
            'password.required'  => 'Password harus diisi',
            'password.min'       => 'Password minimal 8 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
        ]);

        $petugas = Petugas::create([
            'nama'      => $request->nama,
            'email'     => $request->email,
            'nip'       => $request->nip,
            'jabatan'   => $request->jabatan,
            'role'      => $request->role,
            'kantor_id' => $request->kantor_id,
            'password'  => Hash::make($request->password),
            'is_active' => true,
        ]);

        return redirect()->route('login.petugas.view')
            ->with('success', 'Registrasi berhasil! Silakan login dengan akun Anda.');
    }

    /**
     * List semua petugas (management)
     */
    public function index()
    {
        $petugas = Petugas::with('kantor')->get();
        return view('dashboard.manage-petugas.index', compact('petugas'));
    }

    /**
     * Halaman create petugas (admin)
     */
    public function create()
    {
        $kantorList = KantorBeaCukai::active()->orderBy('nama_kantor')->get();
        return view('dashboard.manage-petugas.create', compact('kantorList'));
    }

    /**
     * Store petugas baru (admin)
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama'      => 'required|string|max:255',
            'email'     => 'required|email|unique:petugas,email',
            'nip'       => 'required|string|max:20|unique:petugas,nip',
            'jabatan'   => 'required|string|max:100',
            'role'      => 'required|in:super_user,pelaksana,eselon_iv,eselon_iii,eselon_ii',
            'kantor_id' => 'nullable|exists:kantor_bea_cukai,id',
            'password'  => 'nullable|string|min:8',
        ]);

        $data = $request->only(['nama', 'email', 'nip', 'jabatan', 'role', 'kantor_id']);
        
        // Set default password jika tidak diisi
        $data['password'] = Hash::make($request->password ?? 'password123');
        $data['is_active'] = true;

        Petugas::create($data);

        return redirect()->route('manage.petugas')
            ->with('success', 'Petugas berhasil ditambahkan!');
    }

    /**
     * Hapus petugas
     */
    public function destroy($id)
    {
        $petugas = Petugas::findOrFail($id);
        $petugas->delete();

        return redirect()->route('manage.petugas')
            ->with('success', 'Petugas berhasil dihapus!');
    }

    /**
     * Halaman edit petugas
     */
    public function edit($id)
    {
        $petugas = Petugas::findOrFail($id);
        $kantorList = KantorBeaCukai::active()->orderBy('nama_kantor')->get();
        return view('dashboard.manage-petugas.edit', compact('petugas', 'kantorList'));
    }

    /**
     * Update petugas
     */
    public function update(Request $request, $id)
    {
        $petugas = Petugas::findOrFail($id);

        $request->validate([
            'nama'      => 'required|string|max:255',
            'email'     => 'required|email|unique:petugas,email,' . $petugas->id,
            'nip'       => 'required|string|max:20|unique:petugas,nip,' . $petugas->id,
            'jabatan'   => 'required|string|max:100',
            'role'      => 'required|in:super_user,pelaksana,eselon_iv,eselon_iii,eselon_ii',
            'kantor_id' => 'nullable|exists:kantor_bea_cukai,id',
            'is_active' => 'boolean',
            'password'  => 'nullable|string|min:8',
        ]);

        $data = $request->only(['nama', 'email', 'nip', 'jabatan', 'role', 'kantor_id']);
        $data['is_active'] = $request->boolean('is_active');

        // Update password jika diisi
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $petugas->update($data);

        return redirect()->route('manage.petugas')
            ->with('success', 'Petugas berhasil diperbarui!');
    }

    /**
     * Toggle status aktif petugas
     */
    public function toggleActive($id)
    {
        $petugas = Petugas::findOrFail($id);
        $petugas->update(['is_active' => !$petugas->is_active]);

        $status = $petugas->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->route('manage.petugas')
            ->with('success', "Petugas berhasil {$status}!");
    }
}
