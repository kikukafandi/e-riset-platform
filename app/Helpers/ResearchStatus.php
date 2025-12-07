<?php

namespace App\Helpers;

class ResearchStatus
{
    // Status sesuai enum di database
    const DIPROSES = 'diproses';
    const DOKUMEN_TIDAK_LENGKAP = 'dokumen_tidak_lengkap';
    const DITERIMA = 'diterima';
    const DITOLAK = 'ditolak';

    public static function all()
    {
        return [
            self::DIPROSES,
            self::DITERIMA,
            self::DITOLAK,
            self::DOKUMEN_TIDAK_LENGKAP,
        ];
    }

    public static function labels()
    {
        return [
            self::DIPROSES => 'Diproses',
            self::DITERIMA => 'Diterima',
            self::DITOLAK => 'Ditolak',
            self::DOKUMEN_TIDAK_LENGKAP => 'Dokumen Tidak Lengkap',
        ];
    }

    // Transisi yang diizinkan per role
    // Alur: User submit -> Pelaksana verifikasi berkas -> Eselon IV verifikasi tema & narasumber -> Eselon II/III approve
    // Semua tahap verifikasi masih status 'diproses', hanya Eselon II/III yang bisa ubah ke 'diterima'
    public static function allowedTransitions($role)
    {
        switch ($role) {
            case 'pelaksana':
                // Pelaksana: hanya bisa tandai dokumen tidak lengkap, tidak bisa approve
                return [
                    self::DIPROSES => [self::DOKUMEN_TIDAK_LENGKAP],
                ];
            case 'eselon_iv':
                // Eselon IV: verifikasi tema & narasumber, tidak bisa approve, hanya bisa tolak jika tidak sesuai
                return [
                    self::DIPROSES => [self::DITOLAK],
                ];
            case 'eselon_iii':
            case 'eselon_ii':
                // Eselon II/III: yang berhak approve atau tolak final
                return [
                    self::DIPROSES => [self::DITERIMA, self::DITOLAK],
                ];
            default:
                return [];
        }
    }

    public static function canTransition($from, $to, $role)
    {
        $allowed = self::allowedTransitions($role);
        return isset($allowed[$from]) && in_array($to, $allowed[$from]);
    }
}
