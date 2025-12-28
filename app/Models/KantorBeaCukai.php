<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KantorBeaCukai extends Model
{
    use HasFactory;

    protected $table = 'kantor_bea_cukais';

    protected $fillable = [
        'nama_kantor',
        'kode_kantor',
        'provinsi',
        'kota',
        'alamat',
        'jenis_kantor',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    /**
     * Relasi ke dokumen permohonan
     */
    public function dokumenPermohonans()
    {
        return $this->hasMany(DokumenPermohonan::class, 'kantor_tujuan', 'kode_kantor');
    }

    /**
     * Relasi ke petugas
     */
    public function petugasList()
    {
        return $this->hasMany(Petugas::class, 'kantor_id');
    }

    /**
     * Scope untuk filter kantor aktif
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope untuk filter berdasarkan jenis kantor
     */
    public function scopeByJenis($query, $jenis)
    {
        return $query->where('jenis_kantor', $jenis);
    }
}