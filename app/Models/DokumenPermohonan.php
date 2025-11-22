<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class DokumenPermohonan extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'tanggal_persetujuan' => 'date',
        'deadline_penelitian' => 'date',
        'dapat_perijinan_lagi' => 'boolean'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function kantorBeaCukai()
    {
        return $this->belongsTo(KantorBeaCukai::class, 'kantor_tujuan', 'kode_kantor');
    }

    public function topikRiset()
    {
        return $this->belongsTo(TopikRiset::class, 'topik_tujuan_riset', 'nama_topik');
    }

    // Check if research is overdue
    public function isOverdue()
    {
        if (!$this->deadline_penelitian || $this->status_penelitian === 'selesai') {
            return false;
        }
        
        return Carbon::now()->isAfter($this->deadline_penelitian);
    }

    // Update research status based on deadline
    public function updateResearchStatus()
    {
        if ($this->isOverdue() && $this->status_penelitian !== 'selesai') {
            $this->status_penelitian = 'terlambat';
            $this->dapat_perijinan_lagi = false;
            $this->save();
        }
    }

    // Scope for filtering by employee/non-employee
    public function scopeByEmployeeType($query, $type)
    {
        return $query->whereHas('user', function ($q) use ($type) {
            if ($type === 'pegawai') {
                $q->where('kategori', 'nonmahasiswa')->whereNotNull('instansi');
            } elseif ($type === 'non_pegawai') {
                $q->where('kategori', 'mahasiswa')->orWhere(function($q) {
                    $q->where('kategori', 'nonmahasiswa')->whereNull('instansi');
                });
            }
        });
    }
}
