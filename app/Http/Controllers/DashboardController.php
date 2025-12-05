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

        // default metrics
        $total = (int) DokumenPermohonan::count();
        $pending = (int) DokumenPermohonan::where('status', 'diproses')->count();
        $disetujui = (int) DokumenPermohonan::where('status', 'diterima')->count();
        $ditolak = (int) DokumenPermohonan::where('status', 'ditolak')->count();
        $dokumenTidakLengkap = (int) DokumenPermohonan::where('status', 'dokumen_tidak_lengkap')->count();

        // filter list by role
        if ($user && $user->role === 'pelaksana') {
            // Dokumen baru masuk untuk divalidasi kelengkapan
            $permohonans = DokumenPermohonan::with('user')
                ->where('status', 'diproses')
                ->where(function ($q) {
                    $q->whereNull('paper_validation_status')
                        ->orWhere('paper_validation_status', 'pending');
                })
                ->latest()
                ->paginate(10);
        } else {
            // Pejabat (eselon_iii/eselon_ii) melihat dokumen yang sudah divalidasi pelaksana
            $permohonans = DokumenPermohonan::with('user')
                ->where('status', 'menunggu_tte')
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
