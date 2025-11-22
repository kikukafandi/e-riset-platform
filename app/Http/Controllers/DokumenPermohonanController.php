<?php

namespace App\Http\Controllers;

use App\Models\DokumenPermohonan;
use App\Models\TopikRiset;
use App\Models\User;
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
        // 1. Tentukan Aturan Validasi
        $rules = [
            'judul_riset'               => 'required|string|max:255',
            'proposal'                  => 'required|file|mimes:pdf|max:2048',
            'topik_tujuan_riset'        => 'required|string|max:255', // Ini ditambahkan kembali
            'topik_tujuan_riset_baru'   => [
                'nullable',
                'string',
                'max:255',
                'required_if:topik_tujuan_riset,tambah_topik_baru',
                'unique:topik_risets,nama_topik',
            ],
            'unit_kerja_lokasi_riset'   => 'required|string',
            'jenis_permohonan_data'     => 'required|string',
            'data_statistik_yang_diminta' => 'nullable|string',
            'kuisioner'                 => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'pedoman_wawancara'         => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'proposal_fgd'              => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'kantor_tujuan'             => 'required|string|exists:kantor_bea_cukai,kode_kantor',
        ];

        // 2. Tentukan Pesan Error Kustom
        $messages = [
            'topik_tujuan_riset_baru.required_if' => 'Nama topik baru wajib diisi jika Anda memilih "Lainnya".',
            'topik_tujuan_riset_baru.unique' => 'Nama topik baru ini sudah ada, silakan pilih dari daftar.',
        ];

        // 3. Jalankan Validasi
        $validated = $request->validate($rules, $messages);

        // 4. Proses Upload File (Logika darimu sudah bagus)
        $proposalPath = $request->file('proposal')->store('dokumen/proposal', 'public');
        $kuisionerPath = $request->file('kuisioner') ? $request->file('kuisioner')->store('dokumen/kuisioner', 'public') : null;
        $wawancaraPath = $request->file('pedoman_wawancara') ? $request->file('pedoman_wawancara')->store('dokumen/wawancara', 'public') : null;
        $fgdPath = $request->file('proposal_fgd') ? $request->file('proposal_fgd')->store('dokumen/fgd', 'public') : null;

        // 5. Proses Logika Topik Riset
        $namaTopikFinal = '';
        if ($validated['topik_tujuan_riset'] == 'tambah_topik_baru') {
            // Jika topik baru, simpan ke tabel master
            $namaTopikFinal = $validated['topik_tujuan_riset_baru'];
            TopikRiset::create([
                'nama_topik' => $namaTopikFinal,
                'deskripsi' => 'Topik baru ditambahkan oleh pengguna.'
            ]);
        } else {
            // Jika topik lama, gunakan yang dari dropdown
            $namaTopikFinal = $validated['topik_tujuan_riset'];
        }

        // 6. Siapkan Data Final untuk Disimpan
        $dataToSave = $validated; // Mulai dengan semua data tervalidasi

        // Timpa/Tambahkan data spesifik
        $dataToSave['proposal'] = $proposalPath;
        $dataToSave['kuisioner'] = $kuisionerPath;
        $dataToSave['pedoman_wawancara'] = $wawancaraPath;
        $dataToSave['proposal_fgd'] = $fgdPath;
        $dataToSave['user_id'] = Auth::id();
        $dataToSave['status'] = 'diproses';
        $dataToSave['topik_tujuan_riset'] = $namaTopikFinal; // Ini adalah perbaikan utamanya

        // Hapus field sementara
        unset($dataToSave['topik_tujuan_riset_baru']);

        // 7. Simpan ke Database
        DokumenPermohonan::create($dataToSave);

        // 8. Redirect
        return redirect()->route('dashboardPage')->with('success', 'Permohonan dokumen berhasil dikirim!');
    }

    public function total()
    {
        // Logika untuk mengambil semua data permohonan dari database
        return view('dashboard.manage-petugas.total_permohonan');
    }

    public function pending()
    {
        // Logika untuk mengambil data permohonan yang pending
        return view('dashboard.manage-petugas.pending');
    }

    public function disetujui()
    {
        // Logika untuk mengambil data permohonan yang disetujui
        return view('dashboard.manage-petugas.disetujui');
    }

    public function ditolak()
    {
        // Logika untuk mengambil data permohonan yang ditolak
        return view('dashboard.manage-petugas.ditolak');
    }

    public function updateStatus(Request $request, $id)
    {
        try {
            $permohonan = DokumenPermohonan::findOrFail($id);
            
            $request->validate([
                'status' => 'required|in:diproses,diterima,ditolak,dokumen_tidak_lengkap'
            ]);

            $permohonan->status = $request->status;

            // If approved, set deadline and research status
            if ($request->status === 'diterima') {
                $permohonan->tanggal_persetujuan = now();
                $permohonan->deadline_penelitian = now()->addYear(); // 1 year deadline
                $permohonan->status_penelitian = 'sedang_berjalan';
            }

            $permohonan->save();

            return response()->json(['success' => true, 'status' => $permohonan->status], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $dokumen = DokumenPermohonan::findOrFail($id);

        // Jika login via web (user)
        if (auth('web')->check()) {
            $user = auth('web')->user();

            // hanya pemilik dokumen yang bisa lihat
            if ($dokumen->user_id !== $user->id) {
                abort(403, 'Anda tidak memiliki akses ke dokumen ini.');
            }
        }

        // Jika login via petugas, biarkan bisa lihat semuanya
        if (auth('petugas')->check()) {
            $petugas = auth('petugas')->user();
            // bisa tambahkan logika tambahan kalau mau
        }

        return view('dashboard.manage-petugas.show', compact('dokumen'));
    }


    /**
     * Show the form for editing the specified resource.
     */

    public function status()
    {
        $permohonans = DokumenPermohonan::with('user')->latest()->paginate(10);

        return view('dashboard.dokumen-status', compact('permohonans'));
    }
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



    /**
     * Update research completion (for researchers)
     */
    public function updateResearchCompletion(Request $request, $id)
    {
        $dokumen = DokumenPermohonan::where('id', $id)
            ->where('user_id', Auth::id())
            ->where('status', 'diterima')
            ->firstOrFail();

        $request->validate([
            'doi_number' => 'nullable|string|max:255',
            'file_paper_pdf' => 'nullable|file|mimes:pdf|max:10240' // 10MB max
        ]);

        if (!$request->doi_number && !$request->hasFile('file_paper_pdf')) {
            return back()->withErrors(['completion' => 'Minimal satu dari DOI Number atau File Paper PDF harus diisi.']);
        }

        if ($request->hasFile('file_paper_pdf')) {
            $pdfPath = $request->file('file_paper_pdf')->store('dokumen/papers', 'public');
            $dokumen->file_paper_pdf = $pdfPath;
        }

        if ($request->doi_number) {
            $dokumen->doi_number = $request->doi_number;
        }

        $dokumen->status_penelitian = 'selesai';
        $dokumen->save();

        return redirect()->back()->with('success', 'Penelitian berhasil diselesaikan.');
    }

    /**
     * Check for researchers who cannot get new permits
     */
    public function checkResearcherEligibility($userId)
    {
        $user = User::findOrFail($userId);
        
        // Check if user has any overdue research
        $hasOverdueResearch = $user->dokumenPermohonans()
            ->where('dapat_perijinan_lagi', false)
            ->exists();

        return response()->json([
            'can_apply' => !$hasOverdueResearch,
            'message' => $hasOverdueResearch ? 
                'Anda tidak dapat mengajukan penelitian baru karena memiliki penelitian yang belum diselesaikan dalam batas waktu yang ditentukan.' : 
                'Anda dapat mengajukan penelitian baru.'
        ]);
    }

    /**
     * Get research completion dashboard for officers
     */
    public function researchCompletionDashboard()
    {
        $overdueResearch = DokumenPermohonan::with(['user', 'kantorBeaCukai'])
            ->where('status', 'diterima')
            ->where('status_penelitian', '!=', 'selesai')
            ->where('deadline_penelitian', '<', now())
            ->paginate(20);

        $completedResearch = DokumenPermohonan::with(['user'])
            ->where('status_penelitian', 'selesai')
            ->whereNotNull(['doi_number', 'file_paper_pdf'], 'or')
            ->paginate(20);

        return view('dashboard.research-completion', compact('overdueResearch', 'completedResearch'));
    }
}
