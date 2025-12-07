<?php

namespace App\Http\Controllers;

use App\Models\DokumenPermohonan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class OperisetLettersController extends Controller
{
    public function show(Request $request, DokumenPermohonan $dokumen)
    {
        // Authorize: only the owner (operiset) can access their letter
        if ($request->user()->id !== $dokumen->user_id) {
            abort(403, 'Anda tidak berhak mengakses surat ini.');
        }

        $path = $dokumen->generated_letter_path;
        if (!$path) {
            abort(404, 'Surat belum tersedia.');
        }

        // Stream the file if exists in public disk
        if (!Storage::disk('public')->exists($path)) {
            abort(404, 'Berkas surat tidak ditemukan.');
        }

        // Determine mime type using facade helper if available; fallback to PDF
        $mime = method_exists(Storage::class, 'mimeType') ? (Storage::mimeType($path) ?? 'application/pdf') : 'application/pdf';
        $filename = basename($path);

        return new StreamedResponse(function () use ($path) {
            $stream = Storage::disk('public')->readStream($path);
            fpassthru($stream);
            if (is_resource($stream)) {
                fclose($stream);
            }
        }, 200, [
            'Content-Type' => $mime,
            'Content-Disposition' => 'inline; filename="' . $filename . '"',
        ]);
    }
}
