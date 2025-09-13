<?php

namespace App\Http\Controllers;

use App\Models\DokumenPermohonan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DokumenPermohonanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul_riset' => 'required|string|max:255',
            'proposal' => 'required|file|mimes:pdf|max:2048',
            'unit_kerja_lokasi_riset' => 'required|string',
            'jenis_permohonan_data' => 'required|string',
            'data_statistik_yang_diminta' => 'nullable|string',
            'kuisioner' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'pedoman_wawancara' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'proposal_fgd' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        // Upload file utama (proposal wajib)
        $proposalPath = $request->file('proposal')->store('dokumen/proposal', 'public');

        // Upload opsional
        $kuisionerPath = $request->file('kuisioner') ? $request->file('kuisioner')->store('dokumen/kuisioner', 'public') : null;
        $wawancaraPath = $request->file('pedoman_wawancara') ? $request->file('pedoman_wawancara')->store('dokumen/wawancara', 'public') : null;
        $fgdPath = $request->file('proposal_fgd') ? $request->file('proposal_fgd')->store('dokumen/fgd', 'public') : null;

        // Simpan ke database
        DokumenPermohonan::create([
            'judul_riset' => $validated['judul_riset'],
            'proposal' => $proposalPath,
            'user_id' => Auth::id(),
            'unit_kerja_lokasi_riset' => $validated['unit_kerja_lokasi_riset'],
            'jenis_permohonan_data' => $validated['jenis_permohonan_data'],
            'data_statistik_yang_diminta' => $validated['data_statistik_yang_diminta'] ?? null,
            'kuisioner' => $kuisionerPath,
            'pedoman_wawancara' => $wawancaraPath,
            'proposal_fgd' => $fgdPath,
            'status' => 'diproses', // default
        ]);

        return redirect()->back()->with('success', 'Permohonan dokumen berhasil dikirim!');
    }

    /**
     * Display the specified resource.
     */
    public function show(DokumenPermohonan $dokumenPermohonan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DokumenPermohonan $dokumenPermohonan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DokumenPermohonan $dokumenPermohonan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DokumenPermohonan $dokumenPermohonan)
    {
        //
    }
}
