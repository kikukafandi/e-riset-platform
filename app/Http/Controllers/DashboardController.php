<?php

namespace App\Http\Controllers;

use App\Models\DokumenPermohonan;
use App\Traits\KantorIsolation;
use Illuminate\Http\Request;
use App\Models\TopikRiset;

class DashboardController extends Controller
{
    use KantorIsolation;
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

        // Base query dengan filter kantor
        $baseQuery = $this->getKantorFilteredQuery($user);

        // Metrics - filtered by kantor (semua role bisa lihat statistik)
        $total = (int) (clone $baseQuery)->count();
        $pending = (int) (clone $baseQuery)->where('status', 'diproses')->count();
        $disetujui = (int) (clone $baseQuery)->where('status', 'diterima')->count();
        $ditolak = (int) (clone $baseQuery)->where('status', 'ditolak')->count();
        $dokumenTidakLengkap = (int) (clone $baseQuery)->where('status', 'dokumen_tidak_lengkap')->count();

        // Additional statistics
        $pegawaiCount = (int) (clone $baseQuery)->whereHas('user', function ($q) {
            $q->where('kategori', 'nonmahasiswa')->whereNotNull('instansi');
        })->count();

        $nonPegawaiCount = (int) (clone $baseQuery)->whereHas('user', function ($q) {
            $q->where('kategori', 'mahasiswa')
                ->orWhere(function ($subQ) {
                    $subQ->where('kategori', 'nonmahasiswa')->whereNull('instansi');
                });
        })->count();

        $overdueCount = (int) (clone $baseQuery)->where('status', 'diterima')
            ->where('status_penelitian', '!=', 'selesai')
            ->where('deadline_penelitian', '<', now())
            ->count();

        $completedCount = (int) (clone $baseQuery)->where('status_penelitian', 'selesai')->count();

        $sedangBerjalanCount = (int) (clone $baseQuery)->where('status_penelitian', 'sedang_berjalan')->count();

        // Filter berdasarkan role dan tahap verifikasi
        if ($user && $user->role === 'pelaksana') {
            // Pelaksana: lihat dokumen yang belum diverifikasi berkas (tanggal_validasi_admin null)
            $permohonans = $this->getKantorFilteredQuery($user)
                ->with('user')
                ->where('status', 'diproses')
                ->whereNull('tanggal_validasi_admin')
                ->latest()
                ->paginate(10);
        } elseif ($user && $user->role === 'eselon_iv') {
            // Eselon IV: lihat dokumen yang sudah verifikasi berkas tapi belum verifikasi tema
            $permohonans = $this->getKantorFilteredQuery($user)
                ->with('user')
                ->where('status', 'diproses')
                ->whereNotNull('tanggal_validasi_admin')
                ->whereNull('tanggal_verifikasi_pejabat')
                ->latest()
                ->paginate(10);
        } elseif ($user && in_array($user->role, ['eselon_ii', 'eselon_iii'])) {
            // Eselon II/III: lihat dokumen yang siap untuk TTE
            $permohonans = $this->getKantorFilteredQuery($user)
                ->with('user')
                ->where('status', 'diproses')
                ->whereNotNull('tanggal_validasi_admin')
                ->whereNotNull('tanggal_verifikasi_pejabat')
                ->whereNull('tanggal_persetujuan')
                ->latest()
                ->paginate(10);
        } else {
            // Super user: lihat semua yang diproses (no kantor filter)
            $permohonans = DokumenPermohonan::with('user')
                ->where('status', 'diproses')
                ->latest()
                ->paginate(10);
        }

        return view('dashboard.petugas', compact(
            'permohonans', 
            'total', 
            'pending', 
            'disetujui', 
            'ditolak', 
            'dokumenTidakLengkap',
            'pegawaiCount',
            'nonPegawaiCount',
            'overdueCount',
            'completedCount',
            'sedangBerjalanCount'
        ));
    }

    public function getStatistikPermohonan()
    {
        $user = auth('petugas')->user();
        $baseQuery = $this->getKantorFilteredQuery($user);

        $total = (int) (clone $baseQuery)->count();
        $pending = (int) (clone $baseQuery)->where('status', 'diproses')->count();
        $disetujui = (int) (clone $baseQuery)->where('status', 'diterima')->count();
        $ditolak = (int) (clone $baseQuery)->where('status', 'ditolak')->count();
        $dokumenTidakLengkap = (int) (clone $baseQuery)->where('status', 'dokumen_tidak_lengkap')->count();

        // Additional statistics for the new features
        $currentYear = date('Y');

        // Employee vs Non-employee statistics
        $pegawaiCount = (int) (clone $baseQuery)->whereHas('user', function ($q) {
            $q->where('kategori', 'nonmahasiswa')->whereNotNull('instansi');
        })->count();

        $nonPegawaiCount = (int) (clone $baseQuery)->whereHas('user', function ($q) {
            $q->where('kategori', 'mahasiswa')
                ->orWhere(function ($subQ) {
                    $subQ->where('kategori', 'nonmahasiswa')->whereNull('instansi');
                });
        })->count();

        // Research completion statistics
        $overdueCount = (int) (clone $baseQuery)->where('status', 'diterima')
            ->where('status_penelitian', '!=', 'selesai')
            ->where('deadline_penelitian', '<', now())
            ->count();

        $completedCount = (int) (clone $baseQuery)->where('status_penelitian', 'selesai')->count();

        $sedangBerjalanCount = (int) (clone $baseQuery)->where('status_penelitian', 'sedang_berjalan')->count();

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
            'completed' => $completedCount,
            'sedangBerjalan' => $sedangBerjalanCount
        ]);
    }
}
