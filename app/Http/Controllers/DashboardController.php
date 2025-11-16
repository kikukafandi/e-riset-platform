<?php

namespace App\Http\Controllers;

use App\Models\DokumenPermohonan;
use Illuminate\Http\Request;
use App\Models\TopikRiset;

class DashboardController extends Controller
{
    public function index()
    {
        $permohonans = DokumenPermohonan::with('user')->latest()->get();
        return view('dashboard.index', compact('permohonans'));
    }


    public function create()
    {
        $topikRiset = TopikRiset::orderBy('nama_topik', 'asc')->get();
        return view('dashboard.form-permohonan', compact('topikRiset'));
    }
    public function dashboardPetugas()
    {
        // ambil data permohonan beserta user-nya
        $permohonans = DokumenPermohonan::with('user')->latest()->paginate(10);

        $total = $permohonans->total();
        $pending = DokumenPermohonan::where('status', 'diproses')->count();
        $disetujui = DokumenPermohonan::where('status', 'diterima')->count();
        $ditolak = DokumenPermohonan::where('status', 'ditolak')->count();
        $dokumenTidakLengkap = DokumenPermohonan::where('status', 'dokumen_tidak_lengkap')->count();
        return view('dashboard.petugas', compact('permohonans', 'total', 'pending', 'disetujui', 'ditolak', 'dokumenTidakLengkap'));
    }
    public function getStatistikPermohonan()
    {
        $total = (int) DokumenPermohonan::count();
        $pending = (int) DokumenPermohonan::where('status', 'diproses')->count();
        $disetujui = (int) DokumenPermohonan::where('status', 'diterima')->count();
        $ditolak = (int) DokumenPermohonan::where('status', 'ditolak')->count();
        $dokumenTidakLengkap = (int) DokumenPermohonan::where('status', 'dokumen_tidak_lengkap')->count();

        // Pastikan key-nya sama dengan yang dicari di JavaScript
        return response()->json([
            'total' => $total,
            'pending' => $pending,
            'disetujui' => $disetujui,
            'ditolak' => $ditolak,
            'dokumenTidakLengkap' => $dokumenTidakLengkap
        ]);
    }
}
