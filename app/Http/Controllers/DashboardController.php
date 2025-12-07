<?php

namespace App\Http\Controllers;

use App\Models\DokumenPermohonan;
use Illuminate\Http\Request;
use App\Models\TopikRiset;

class DashboardController extends Controller
{
    public function index()
    {

        $permohonans = DokumenPermohonan::with('user')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();
        return view('dashboard.index', compact('permohonans'));
    }


    public function create()
    {
        $kantorCukai = \App\Models\KantorBeaCukai::where('is_active', true)
            ->orderBy('provinsi', 'asc')
            ->orderBy('nama_kantor', 'asc')
            ->get();
        $topikRiset = TopikRiset::orderBy('nama_topik', 'asc')->get();
        return view('dashboard.form-permohonan', compact('topikRiset', 'kantorCukai'));
    }
    public function dashboardPetugas()
    {
        $user = auth('petugas')->user();

        // Eselon II/III: redirect ke halaman Queue TTE
        if ($user && in_array($user->role, ['eselon_ii', 'eselon_iii'])) {
            return redirect()->route('verification.queue');
        }

        // default metrics
        $total = (int) DokumenPermohonan::count();
        $pending = (int) DokumenPermohonan::where('status', 'diproses')->count();
        $disetujui = (int) DokumenPermohonan::where('status', 'diterima')->count();
        $ditolak = (int) DokumenPermohonan::where('status', 'ditolak')->count();
        $dokumenTidakLengkap = (int) DokumenPermohonan::where('status', 'dokumen_tidak_lengkap')->count();

        // Filter berdasarkan role dan tahap verifikasi
        if ($user && $user->role === 'pelaksana') {
            // Pelaksana: lihat dokumen yang belum diverifikasi berkas (tanggal_validasi_admin null)
            $permohonans = DokumenPermohonan::with('user')
                ->where('status', 'diproses')
                ->whereNull('tanggal_validasi_admin')
                ->latest()
                ->paginate(10);
        } elseif ($user && $user->role === 'eselon_iv') {
            // Eselon IV: lihat dokumen yang sudah verifikasi berkas tapi belum verifikasi tema
            $permohonans = DokumenPermohonan::with('user')
                ->where('status', 'diproses')
                ->whereNotNull('tanggal_validasi_admin')
                ->whereNull('tanggal_verifikasi_pejabat')
                ->latest()
                ->paginate(10);
        } else {
            // Default (super_user, super_admin): lihat semua yang diproses
            $permohonans = DokumenPermohonan::with('user')
                ->where('status', 'diproses')
                ->latest()
                ->paginate(10);
        }

        return view('dashboard.petugas', compact('permohonans', 'total', 'pending', 'disetujui', 'ditolak', 'dokumenTidakLengkap'));
    }
    public function getStatistikPermohonan()
    {
        $total = (int) DokumenPermohonan::count();
        $pending = (int) DokumenPermohonan::where('status', 'diproses')->count();
        $disetujui = (int) DokumenPermohonan::where('status', 'diterima')->count();
        $ditolak = (int) DokumenPermohonan::where('status', 'ditolak')->count();
        $dokumenTidakLengkap = (int) DokumenPermohonan::where('status', 'dokumen_tidak_lengkap')->count();

        // Additional statistics for the new features
        $currentYear = date('Y');

        // Employee vs Non-employee statistics
        $pegawaiCount = DokumenPermohonan::whereHas('user', function ($q) {
            $q->where('kategori', 'nonmahasiswa')->whereNotNull('instansi');
        })->count();

        $nonPegawaiCount = DokumenPermohonan::whereHas('user', function ($q) {
            $q->where('kategori', 'mahasiswa')
                ->orWhere(function ($subQ) {
                    $subQ->where('kategori', 'nonmahasiswa')->whereNull('instansi');
                });
        })->count();

        // Research completion statistics
        $overdueCount = DokumenPermohonan::where('status', 'diterima')
            ->where('status_penelitian', '!=', 'selesai')
            ->where('deadline_penelitian', '<', now())
            ->count();

        $completedCount = DokumenPermohonan::where('status_penelitian', 'selesai')->count();

        // Pastikan key-nya sama dengan yang dicari di JavaScript
        return response()->json([
            'total' => $total,
            'pending' => $pending,
            'disetujui' => $disetujui,
            'ditolak' => $ditolak,
            'dokumenTidakLengkap' => $dokumenTidakLengkap,
            'pegawai' => $pegawaiCount,
            'nonPegawai' => $nonPegawaiCount,
            'overdue' => $overdueCount,
            'completed' => $completedCount
        ]);
    }
}
