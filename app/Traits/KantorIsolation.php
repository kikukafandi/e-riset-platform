<?php

namespace App\Traits;

use App\Models\DokumenPermohonan;

trait KantorIsolation
{
    /**
     * Get base query filtered by petugas kantor
     * Super user dapat akses semua, petugas lain hanya kantornya sendiri
     */
    protected function getKantorFilteredQuery($user = null)
    {
        if ($user === null) {
            $user = auth('petugas')->user();
        }

        $query = DokumenPermohonan::query();

        // Super user tidak difilter
        if ($user && method_exists($user, 'isSuperUser') && $user->isSuperUser()) {
            return $query;
        }

        // Petugas lain: filter berdasarkan kantor_id mereka
        if ($user && $user->kantor_id) {
            $query->where('kantor_tujuan', $user->kantor_id);
        } else {
            // Jika petugas tidak punya kantor, tidak bisa lihat apa-apa
            $query->whereRaw('1 = 0');
        }

        return $query;
    }

    /**
     * Check apakah petugas bisa mengakses dokumen tertentu
     */
    protected function canAccessDokumen($dokumen, $user = null)
    {
        if ($user === null) {
            $user = auth('petugas')->user();
        }

        if (!$user) {
            return false;
        }

        // Super user bisa akses semua
        if (method_exists($user, 'isSuperUser') && $user->isSuperUser()) {
            return true;
        }

        // Petugas hanya bisa akses dokumen dari kantornya
        return $user->kantor_id && $dokumen->kantor_tujuan == $user->kantor_id;
    }
}
