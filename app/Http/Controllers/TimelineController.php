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

        $request->validate([
            'paper_file' => 'required|file|mimes:pdf|max:10240', // 10MB max
            'doi_number' => 'nullable|string|max:255'
        ]);

        // Upload paper file
        $paperPath = $request->file('paper_file')->store('papers', 'public');

        // Update dokumen
        $dokumen->update([
            'paper_file' => $paperPath,
            'doi_number' => $request->doi_number,
            'paper_submitted_at' => now(),
            'paper_validation_status' => 'pending'
        ]);

        return redirect()->back()->with('success', 'Paper berhasil disubmit untuk validasi.');
    }

    // Pelaksana validation of paper (first step)
    public function validatePaper(Request $request, $id)
    {
        $dokumen = DokumenPermohonan::findOrFail($id);

        $request->validate([
            'validation_status' => 'required|in:valid,invalid',
            'validation_message' => 'nullable|string|max:1000'
        ]);

        // Update paper validation status
        $dokumen->update([
            'paper_validation_status' => $request->validation_status,
            'paper_validation_message' => $request->validation_message,
            'paper_validated_at' => now(),
            'tanggal_validasi_admin' => now()
        ]);

        // If valid, automatically forward to Eselon IV
        if ($request->validation_status === 'valid') {
            $dokumen->update([
                'admin_validation_status' => 'approved_by_pelaksana',
                'status' => 'menunggu_verifikasi'
            ]);
        } else {
            $dokumen->update([
                'admin_validation_status' => 'rejected_by_pelaksana',
                'status' => 'ditolak'
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => $request->validation_status === 'valid' ? 
                'Paper divalidasi dan diteruskan ke Eselon IV.' : 
                'Paper ditolak dan dikembalikan ke pemohon.'
        ]);
    }

    // Official verification and letter generation
    public function officialVerification(Request $request, $id)
    {
        $dokumen = DokumenPermohonan::findOrFail($id);

        $request->validate([
            'verification_status' => 'required|in:approved,rejected',
            'verification_message' => 'nullable|string|max:1000'
        ]);

        $dokumen->update([
            'admin_validation_status' => $request->verification_status,
            'admin_validation_message' => $request->verification_message,
            'admin_validated_at' => now(),
            'tanggal_verifikasi_pejabat' => now()
        ]);

        // Generate letter automatically
        try {
            if ($request->verification_status === 'approved') {
                $letterPath = $this->pdfLetterService->generateApprovalLetter($dokumen);
                $dokumen->update([
                    'approval_letter_path' => $letterPath,
                    'letter_generated_at' => now(),
                    'tanggal_mulai_riset' => now(),
                    'status_penelitian' => 'sedang_berjalan'
                ]);
            } else {
                $letterPath = $this->pdfLetterService->generateRejectionLetter($dokumen);
                $dokumen->update([
                    'rejection_letter_path' => $letterPath,
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

    // Get validation queue for admin
    public function validationQueue()
    {
        $pendingValidations = DokumenPermohonan::where('paper_validation_status', 'pending')
            ->whereNotNull('paper_file')
            ->with(['user', 'kantorBeaCukai'])
            ->paginate(20);

        return view('dashboard.validation-queue', compact('pendingValidations'));
    }

    // Get verification queue for officials
    public function verificationQueue()
    {
        $pendingVerifications = DokumenPermohonan::where('paper_validation_status', 'valid')
            ->where('admin_validation_status', 'pending')
            ->with(['user', 'kantorBeaCukai'])
            ->paginate(20);

        return view('dashboard.verification-queue', compact('pendingVerifications'));
    }
}