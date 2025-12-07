<?php

namespace App\Http\Controllers;

use App\Models\DokumenPermohonan;
use App\Services\PdfLetterService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class TimelineController extends Controller
{
    protected $pdfLetterService;

    public function __construct(PdfLetterService $pdfLetterService)
    {
        $this->pdfLetterService = $pdfLetterService;
    }

    // Show timeline index for current user
    public function index()
    {
        $documents = DokumenPermohonan::where('user_id', Auth::id())
            ->with(['user', 'kantorBeaCukai'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('dashboard.timeline', compact('documents'));
    }

    // Show timeline for specific document
    public function showTimeline($id)
    {
        $dokumen = DokumenPermohonan::where('id', $id)
            ->where('user_id', Auth::id())
            ->with(['user', 'kantorBeaCukai'])
            ->firstOrFail();

        return view('dashboard.timeline', compact('dokumen'));
    }

    // Submit paper by applicant
    public function submitPaper(Request $request, $id)
    {
        $dokumen = DokumenPermohonan::where('id', $id)
            ->where('user_id', Auth::id())
            ->where('status', 'diterima')
            ->firstOrFail();

        // Validate request
        $request->validate([
            'paper_file' => 'required|file|mimes:pdf|max:10240', // Max 10MB
            'doi_number' => 'nullable|string|max:255'
        ]);

        // Store the paper file
        $paperPath = $request->file('paper_file')->store('papers', 'public');

        // Update dokumen with paper info
        $dokumen->update([
            'paper_file' => $paperPath,
            'doi_number' => $request->doi_number,
            'paper_submitted_at' => now(),
            'paper_validation_status' => 'pending'
        ]);

        return redirect()->route('timeline.index')
            ->with('success', 'Paper berhasil disubmit! Menunggu validasi dari admin.');
    }

    // Official verification and letter generation (TTE by Eselon II/III)
    public function officialVerification(Request $request, $id)
    {
        $dokumen = DokumenPermohonan::findOrFail($id);

        $request->validate([
            'verification_status' => 'required|in:approved,rejected',
            'verification_message' => 'nullable|string|max:1000'
        ]);

        if ($request->verification_status === 'approved') {
            // TTE Approved: Update status to diterima and set approval date
            $dokumen->update([
                'status' => 'diterima',
                'tanggal_persetujuan' => now(),
                'admin_validation_status' => 'approved',
                'admin_validation_message' => $request->verification_message,
                'admin_validated_at' => now(),
                'tanggal_mulai_riset' => now(),
                'status_penelitian' => 'sedang_berjalan'
            ]);
        } else {
            // TTE Rejected: Update status to ditolak
            $dokumen->update([
                'status' => 'ditolak',
                'admin_validation_status' => 'rejected',
                'admin_validation_message' => $request->verification_message,
                'admin_validated_at' => now()
            ]);
        }

        // Generate letter automatically
        try {
            if ($request->verification_status === 'approved') {
                $letterPath = $this->pdfLetterService->generateApprovalLetter($dokumen);
                $dokumen->update([
                    'generated_letter_path' => $letterPath,
                    'letter_generated_at' => now()
                ]);
            } else {
                $letterPath = $this->pdfLetterService->generateRejectionLetter($dokumen);
                $dokumen->update([
                    'generated_letter_path' => $letterPath,
                    'letter_generated_at' => now()
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Failed to generate letter: ' . $e->getMessage());
        }

        return response()->json([
            'success' => true,
            'message' => 'Verifikasi berhasil disimpan.' . ($request->verification_status === 'approved' ? ' Surat persetujuan telah digenerate.' : '')
        ]);
    }

    // Generate approval letter
    public function generateApprovalLetter($dokumen)
    {
        try {
            if ($dokumen->admin_validation_status === 'approved') {
                $letterPath = $this->pdfLetterService->generateApprovalLetter($dokumen);
                
                $dokumen->update([
                    'approval_letter_path' => $letterPath,
                    'letter_generated_at' => now()
                ]);
                
                return response()->json([
                    'success' => true,
                    'message' => 'Surat persetujuan berhasil digenerate.',
                    'download_url' => Storage::url($letterPath)
                ]);
            } elseif ($dokumen->admin_validation_status === 'rejected') {
                $letterPath = $this->pdfLetterService->generateRejectionLetter($dokumen);
                
                $dokumen->update([
                    'rejection_letter_path' => $letterPath,
                    'letter_generated_at' => now()
                ]);
                
                return response()->json([
                    'success' => true,
                    'message' => 'Surat penolakan berhasil digenerate.',
                    'download_url' => Storage::url($letterPath)
                ]);
            }
            
            return response()->json([
                'success' => false,
                'message' => 'Dokumen belum diverifikasi.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal generate surat: ' . $e->getMessage()
            ]);
        }
    }

    // Update timeline when status changes
    public static function updateTimeline($dokumen, $status)
    {
        switch ($status) {
            case 'diproses':
                if (!$dokumen->tanggal_submit) {
                    $dokumen->update(['tanggal_submit' => now()]);
                }
                break;
            case 'diterima':
                if (!$dokumen->tanggal_persetujuan) {
                    $dokumen->update(['tanggal_persetujuan' => now()]);
                }
                break;
        }
    }

    // Get validation queue for admin (Pelaksana) - Validasi Paper
    public function validationQueue()
    {
        $pendingValidations = DokumenPermohonan::where('paper_validation_status', 'pending')
            ->whereNotNull('paper_file')
            ->with(['user', 'kantorBeaCukai'])
            ->orderBy('paper_submitted_at', 'asc')  // FIFO
            ->paginate(20);

        return view('dashboard.validation-queue', compact('pendingValidations'));
    }

    // Validate paper by Pelaksana
    public function validatePaper(Request $request, $id)
    {
        $dokumen = DokumenPermohonan::findOrFail($id);

        $request->validate([
            'validation_status' => 'required|in:valid,invalid',
            'validation_message' => 'nullable|string|max:1000'
        ]);

        if ($request->validation_status === 'valid') {
            // Paper valid - penelitian selesai
            $dokumen->update([
                'paper_validation_status' => 'valid',
                'paper_validation_message' => $request->validation_message,
                'paper_validated_at' => now(),
                'status_penelitian' => 'selesai',  // Penelitian selesai
                'dapat_perijinan_lagi' => true  // Pemohon bisa ajukan riset baru
            ]);

            return redirect()->route('validation.queue')
                ->with('success', 'Paper berhasil divalidasi. Status penelitian: Selesai.');
        } else {
            // Paper invalid - perlu resubmit
            $dokumen->update([
                'paper_validation_status' => 'invalid',
                'paper_validation_message' => $request->validation_message,
                'paper_validated_at' => now()
                // paper_file tetap ada agar pemohon bisa lihat feedback
            ]);

            return redirect()->route('validation.queue')
                ->with('success', 'Paper ditolak. Pemohon akan menerima notifikasi untuk resubmit.');
        }
    }

    // Get verification queue for officials (Eselon II/III TTE)
    public function verificationQueue()
    {
        // Dokumen yang sudah melewati verifikasi berkas (Pelaksana) dan verifikasi tema (Eselon IV)
        // Siap untuk TTE oleh Eselon II/III
        $pendingVerifications = DokumenPermohonan::where('status', 'diproses')
            ->whereNotNull('tanggal_validasi_admin')  // Sudah verifikasi berkas oleh Pelaksana
            ->whereNotNull('tanggal_verifikasi_pejabat')  // Sudah verifikasi tema oleh Eselon IV
            ->whereNull('tanggal_persetujuan')  // Belum di-TTE/disetujui
            ->with(['user', 'kantorBeaCukai'])
            ->orderBy('created_at', 'asc')  // FIFO
            ->paginate(20);

        return view('dashboard.verification-queue', compact('pendingVerifications'));
    }
}