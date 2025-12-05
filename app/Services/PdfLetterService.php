<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class PdfLetterService
{
    /**
     * Generate approval letter for research application
     */
    public function generateApprovalLetter($dokumen)
    {
        // Build verification payload and QR URL
        $verificationHash = hash('sha256', $dokumen->id . '|' . ($dokumen->user->email ?? '') . '|' . now()->timestamp);
        $verificationUrl = url('/verify-letter?doc=' . $dokumen->id . '&hash=' . $verificationHash);
        $qrUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=180x180&data=' . urlencode($verificationUrl);

        $letterData = [
            'document_number' => $this->generateDocumentNumber(),
            'date' => now()->format('d F Y'),
            'applicant_name' => $dokumen->user->nama_lengkap,
            'research_title' => $dokumen->judul_riset,
            'research_topic' => $dokumen->topik_tujuan_riset,
            'office_destination' => $dokumen->kantorBeaCukai ? $dokumen->kantorBeaCukai->nama_kantor : '-',
            'office_code' => $dokumen->kantorBeaCukai ? $dokumen->kantorBeaCukai->kode_kantor : '-',
            'applicant_institution' => $dokumen->user->instansi ?: 'Peneliti Mandiri',
            'research_period' => $this->formatPeriod($dokumen->rencana_mulai_riset, $dokumen->rencana_selesai_riset),
            'verification_date' => $this->formatDateOrNow($dokumen->verified_at),
            'paper_title' => $dokumen->paper_title ?: $dokumen->judul_riset,
            'doi_number' => $dokumen->doi_number,
            'verification_message' => $dokumen->verification_message,
            'qr_url' => $qrUrl,
            'verification_url' => $verificationUrl,
        ];

        $htmlContent = $this->generateLetterHtml($letterData);
        
        // Generate PDF using a PDF library (you'll need to install one like dompdf or mpdf)
        $pdfContent = $this->convertHtmlToPdf($htmlContent);
        
        // Save the PDF file
        $fileName = 'approval_letter_' . $dokumen->id . '_' . time() . '.pdf';
        $filePath = 'approval_letters/' . $fileName;
        
        Storage::disk('public')->put($filePath, $pdfContent);
        
        return $filePath;
    }

    /**
     * Generate rejection letter for research application
     */
    public function generateRejectionLetter($dokumen)
    {
        $verificationHash = hash('sha256', $dokumen->id . '|' . ($dokumen->user->email ?? '') . '|' . now()->timestamp);
        $verificationUrl = url('/verify-letter?doc=' . $dokumen->id . '&hash=' . $verificationHash);
        $qrUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=180x180&data=' . urlencode($verificationUrl);

        $letterData = [
            'document_number' => $this->generateDocumentNumber(),
            'date' => now()->format('d F Y'),
            'applicant_name' => $dokumen->user->nama_lengkap,
            'research_title' => $dokumen->judul_riset,
            'research_topic' => $dokumen->topik_tujuan_riset,
            'applicant_institution' => $dokumen->user->instansi ?: 'Peneliti Mandiri',
            'verification_date' => $this->formatDateOrNow($dokumen->verified_at),
            'rejection_reason' => $dokumen->verification_message,
            'qr_url' => $qrUrl,
            'verification_url' => $verificationUrl,
        ];

        $htmlContent = $this->generateRejectionLetterHtml($letterData);
        
        $pdfContent = $this->convertHtmlToPdf($htmlContent);
        
        $fileName = 'rejection_letter_' . $dokumen->id . '_' . time() . '.pdf';
        $filePath = 'rejection_letters/' . $fileName;
        
        Storage::disk('public')->put($filePath, $pdfContent);
        
        return $filePath;
    }

    /**
     * Generate document number for the letter
     */
    private function generateDocumentNumber()
    {
        $year = date('Y');
        $month = date('m');
        $sequence = rand(1000, 9999); // In production, this should be from database sequence
        
        return "S-{$sequence}/BC.0101/{$month}/{$year}";
    }

    /**
     * Generate HTML content for approval letter
     */
    private function generateLetterHtml($data)
    {
        return view('letters.approval', $data)->render();
    }

    /**
     * Generate HTML content for rejection letter
     */
    private function generateRejectionLetterHtml($data)
    {
        return view('letters.rejection', $data)->render();
    }

    /**
     * Convert HTML to PDF
     * This is a placeholder - you need to implement using your preferred PDF library
     */
    private function convertHtmlToPdf($html)
    {
        // Using dompdf as example (you need to install it first)
        // composer require dompdf/dompdf
        
        try {
            $dompdf = new \Dompdf\Dompdf([
                'enable_remote' => true,
                'default_font' => 'DejaVu Sans',
                'enable_php' => false,
            ]);
            
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();
            
            return $dompdf->output();
        } catch (\Exception $e) {
            // Fallback: return HTML content as text file for now
            return $html;
        }
    }

    private function formatDateOrNow($date)
    {
        try {
            if ($date instanceof \Carbon\Carbon) {
                return $date->format('d F Y');
            }
            if (is_string($date) && !empty($date)) {
                return \Carbon\Carbon::parse($date)->format('d F Y');
            }
        } catch (\Throwable $e) {
            // fallback below
        }
        return now()->format('d F Y');
    }

    private function formatPeriod($start, $end)
    {
        $startStr = $this->formatDateOrDash($start);
        $endStr = $this->formatDateOrDash($end);
        return $startStr . ' - ' . $endStr;
    }

    private function formatDateOrDash($date)
    {
        try {
            if ($date instanceof \Carbon\Carbon) {
                return $date->format('d F Y');
            }
            if (is_string($date) && !empty($date)) {
                return \Carbon\Carbon::parse($date)->format('d F Y');
            }
        } catch (\Throwable $e) {
            // ignore and fallback
        }
        return '-';
    }

    /**
     * Get letter template path for preview
     */
    public function getLetterPreviewUrl($dokumen, $type = 'approval')
    {
        if ($type === 'approval' && $dokumen->approval_letter_path) {
            return Storage::url($dokumen->approval_letter_path);
        }
        
        if ($type === 'rejection' && $dokumen->rejection_letter_path) {
            return Storage::url($dokumen->rejection_letter_path);
        }
        
        return null;
    }
}