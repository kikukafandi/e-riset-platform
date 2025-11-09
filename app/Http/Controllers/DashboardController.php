<?php

namespace App\Http\Controllers;

use App\Models\DokumenPermohonan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $permohonans = DokumenPermohonan::with('user')->latest()->get();
        return view('dashboard.index', compact('permohonans'));
    }


    public function create()
    {
        return view('dashboard.form-permohonan');
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
}
