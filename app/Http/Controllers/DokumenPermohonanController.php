<?php

namespace App\Http\Controllers;

use App\Models\DokumenPermohonan;
use App\Models\TopikRiset;
use App\Models\User;
use App\Traits\KantorIsolation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class DokumenPermohonanController extends Controller
{
    use KantorIsolation;
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
            // Dokumen Wajib
            'proposal'                  => 'required|file|mimes:pdf|max:2048',
            'surat_pengantar'           => 'required|file|mimes:pdf|max:2048', 
            'surat_pernyataan'          => 'required|file|mimes:pdf|max:2048', 

            // Data Riset
            'topik_tujuan_riset'        => 'required|string|max:255',
            'topik_tujuan_riset_baru'   => [
                'nullable',
                'string',
                'max:255',
                'required_if:topik_tujuan_riset,tambah_topik_baru',
                'unique:topik_risets,nama_topik',
            ],
            'kantor_tujuan'             => 'required|integer|exists:kantor_bea_cukais,id', 
            'jenis_permohonan_data'     => 'required|string|max:255',
            'data_statistik_yang_diminta' => 'nullable|string',

            // Dokumen Opsional
            'kuisioner'                 => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'pedoman_wawancara'         => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'proposal_fgd'              => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ];

        // 2. Tentukan Pesan Error Kustom
        $messages = [
            'proposal.required'         => 'File proposal riset wajib diupload.',
            'surat_pengantar.required'  => 'Surat pengantar dari kampus/instansi wajib diupload.',
            'surat_pernyataan.required' => 'Surat pernyataan bermeterai wajib diupload.',
            'kantor_tujuan.required'    => 'Kantor tujuan wajib dipilih.',
            'kantor_tujuan.exists'      => 'Kantor tujuan yang dipilih tidak valid.',
            'mimes'                     => 'Format file harus :values.',
            'max'                       => 'Ukuran file maksimal 2MB.',
        ];

        // 3. Jalankan Validasi
        $validated = $request->validate($rules, $messages);

        // Inisialisasi variabel path agar bisa dihapus di catch block jika error
        $proposalPath = null;
        $pengantarPath = null;
        $pernyataanPath = null;
        $kuisionerPath = null;
        $wawancaraPath = null;
        $fgdPath = null;

        try {
            // 4. Proses Upload File (Buat folder jika belum ada)
            Storage::disk('public')->makeDirectory('dokumen/proposal');
            Storage::disk('public')->makeDirectory('dokumen/pengantar');
            Storage::disk('public')->makeDirectory('dokumen/pernyataan');
            Storage::disk('public')->makeDirectory('dokumen/kuisioner');
            Storage::disk('public')->makeDirectory('dokumen/wawancara');
            Storage::disk('public')->makeDirectory('dokumen/fgd');

            // A. Upload Dokumen Wajib
            if ($request->hasFile('proposal') && $request->file('proposal')->isValid()) {
                $proposalPath = $request->file('proposal')->store('dokumen/proposal', 'public');
            }

            if ($request->hasFile('surat_pengantar') && $request->file('surat_pengantar')->isValid()) {
                $pengantarPath = $request->file('surat_pengantar')->store('dokumen/pengantar', 'public');
            }

            if ($request->hasFile('surat_pernyataan') && $request->file('surat_pernyataan')->isValid()) {
                $pernyataanPath = $request->file('surat_pernyataan')->store('dokumen/pernyataan', 'public');
            }

            // Cek jika upload wajib gagal
            if (!$proposalPath || !$pengantarPath || !$pernyataanPath) {
                throw new \Exception('Gagal mengupload salah satu dokumen wajib.');
            }

            // B. Upload Dokumen Opsional
            $kuisionerPath = $request->hasFile('kuisioner') && $request->file('kuisioner')->isValid() ?
                $request->file('kuisioner')->store('dokumen/kuisioner', 'public') : null;

            $wawancaraPath = $request->hasFile('pedoman_wawancara') && $request->file('pedoman_wawancara')->isValid() ?
                $request->file('pedoman_wawancara')->store('dokumen/wawancara', 'public') : null;

            $fgdPath = $request->hasFile('proposal_fgd') && $request->file('proposal_fgd')->isValid() ?
                $request->file('proposal_fgd')->store('dokumen/fgd', 'public') : null;
        } catch (\Exception $e) {
            // Hapus file yang sudah terlanjur ter-upload jika terjadi error validasi upload
            if ($proposalPath) Storage::disk('public')->delete($proposalPath);
            if ($pengantarPath) Storage::disk('public')->delete($pengantarPath);
            if ($pernyataanPath) Storage::disk('public')->delete($pernyataanPath);

            Log::error('File upload error: ' . $e->getMessage());
            return back()->withErrors(['upload' => 'Gagal mengupload file: ' . $e->getMessage()])->withInput();
        }

        // 5. Proses Logika Topik Riset
        $namaTopikFinal = '';
        if ($validated['topik_tujuan_riset'] == 'tambah_topik_baru') {
            $namaTopikFinal = $validated['topik_tujuan_riset_baru'];
            // Opsional: Cek lagi apakah topik sudah ada untuk menghindari duplikasi manual
            $existingTopik = TopikRiset::where('nama_topik', $namaTopikFinal)->first();
            if (!$existingTopik) {
                TopikRiset::create([
                    'nama_topik' => $namaTopikFinal,
                    'deskripsi' => 'Topik baru ditambahkan oleh pengguna.'
                ]);
            }
        } else {
            $namaTopikFinal = $validated['topik_tujuan_riset'];
        }

        // 6. Siapkan Data Final untuk Disimpan
        $dataToSave = $validated;

        // Mapping Path File
        $dataToSave['proposal'] = $proposalPath;
        $dataToSave['surat_pengantar'] = $pengantarPath;
        $dataToSave['surat_pernyataan'] = $pernyataanPath;
        $dataToSave['kuisioner'] = $kuisionerPath;
        $dataToSave['pedoman_wawancara'] = $wawancaraPath;
        $dataToSave['proposal_fgd'] = $fgdPath;

        // Mapping Data Lain
        $dataToSave['user_id'] = Auth::id();
        $dataToSave['status'] = 'diproses';
        $dataToSave['topik_tujuan_riset'] = $namaTopikFinal;

        // Hapus field yang tidak ada di tabel database
        unset($dataToSave['topik_tujuan_riset_baru']);
        // 'kantor_tujuan' sudah sesuai dengan nama kolom di migrasi (foreign key)

        try {
            // 7. Simpan ke Database

            // Generate service number: 4digit-year (NNNN-YYYY)
            $year = now()->year;
            $countThisYear = DokumenPermohonan::whereYear('created_at', $year)->count() + 1;
            $serviceNumber = str_pad((string)$countThisYear, 4, '0', STR_PAD_LEFT) . '-' . $year;
            $dataToSave['service_number'] = $serviceNumber;

            $dokumen = DokumenPermohonan::create($dataToSave);

            Log::info('Dokumen permohonan berhasil dibuat', ['id' => $dokumen->id, 'user' => Auth::id()]);

            // 8. Redirect
            return redirect()->route('dashboardPage')->with('success', 'Permohonan riset berhasil dikirim! Status saat ini: Diproses.');
        } catch (\Exception $e) {
            Log::error('Database save error: ' . $e->getMessage());

            // Hapus semua file jika penyimpanan database gagal (Rollback File)
            if ($proposalPath) Storage::disk('public')->delete($proposalPath);
            if ($pengantarPath) Storage::disk('public')->delete($pengantarPath);
            if ($pernyataanPath) Storage::disk('public')->delete($pernyataanPath);
            if ($kuisionerPath) Storage::disk('public')->delete($kuisionerPath);
            if ($wawancaraPath) Storage::disk('public')->delete($wawancaraPath);
            if ($fgdPath) Storage::disk('public')->delete($fgdPath);

            return back()->withErrors(['database' => 'Terjadi kesalahan sistem saat menyimpan data. Silakan coba lagi.'])->withInput();
        }
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
            $user = auth('petugas')->user();

            // Validasi akses kantor
            if (!$this->canAccessDokumen($permohonan, $user)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda tidak memiliki akses ke dokumen dari kantor lain.'
                ], 403);
            }

            $request->validate([
                'status' => 'required|string'
            ]);
            $toStatus = $request->status;

            // Handle verifikasi actions (tidak mengubah status database)
            if ($toStatus === 'verifikasi_berkas') {
                // Pelaksana verifikasi berkas - tandai sudah diverifikasi
                $permohonan->tanggal_validasi_admin = now();
                $permohonan->save();
                return response()->json([
                    'success' => true,
                    'status' => $permohonan->status,
                    'message' => 'Berkas berhasil diverifikasi. Lanjut ke Eselon IV.'
                ], 200);
            }

            if ($toStatus === 'verifikasi_tema') {
                // Eselon IV verifikasi tema & narasumber
                $permohonan->tanggal_verifikasi_pejabat = now();
                $permohonan->save();
                return response()->json([
                    'success' => true,
                    'status' => $permohonan->status,
                    'message' => 'Tema & narasumber berhasil diverifikasi. Lanjut ke TTE.'
                ], 200);
            }

            // Use strict workflow validation untuk status database
            $permohonan->updateStatusWithRole($toStatus, $user);
            return response()->json([
                'success' => true,
                'status' => $permohonan->status,
                'message' => 'Status berhasil diperbarui'
            ], 200);
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

        // Jika login via petugas, cek akses kantor
        if (auth('petugas')->check()) {
            $petugas = auth('petugas')->user();

            // Validasi akses berdasarkan kantor
            if (!$this->canAccessDokumen($dokumen, $petugas)) {
                abort(403, 'Anda tidak memiliki akses ke dokumen dari kantor lain.');
            }
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

    // Disposisi workflow removed per new simplified process
}
