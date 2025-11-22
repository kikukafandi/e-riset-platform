<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KantorBeaCukai extends Model
{
    use HasFactory;

    protected $table = 'kantor_bea_cukai';

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

    public function dokumenPermohonans()
    {
        return $this->hasMany(DokumenPermohonan::class, 'kantor_tujuan', 'kode_kantor');
    }
}