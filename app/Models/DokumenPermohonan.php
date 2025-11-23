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
        'dapat_perijinan_lagi' => 'boolean',
        'tanggal_draft' => 'datetime',
        'tanggal_submit' => 'datetime',
        'tanggal_validasi_admin' => 'datetime',
        'tanggal_verifikasi_pejabat' => 'datetime',
        'tanggal_mulai_riset' => 'datetime',
        'paper_submitted_at' => 'datetime',
        'paper_validated_at' => 'datetime',
        'admin_validated_at' => 'datetime',
        'letter_generated_at' => 'datetime'
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

    // Get timeline status for display
    public function getTimelineStatus()
    {
        if ($this->status_penelitian === 'selesai') {
            return 'completed';
        } elseif ($this->tanggal_mulai_riset) {
            return 'research_period';
        } elseif ($this->status === 'diterima') {
            return 'approved';
        } elseif ($this->tanggal_submit) {
            return 'processing';
        } else {
            return 'draft';
        }
    }

    // Get timeline percentage for progress bar
    public function getTimelinePercentage()
    {
        $status = $this->getTimelineStatus();
        return match($status) {
            'draft' => 20,
            'processing' => 40,
            'approved' => 60,
            'research_period' => 80,
            'completed' => 100,
            default => 0
        };
    }

    // Check if paper can be submitted
    public function canSubmitPaper()
    {
        return $this->status === 'diterima' && 
               $this->status_penelitian !== 'selesai' && 
               !$this->paper_file;
    }

    // Check if admin can validate
    public function canAdminValidate()
    {
        return $this->paper_file && 
               $this->paper_validation_status === 'pending';
    }
}
