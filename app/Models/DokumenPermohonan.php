<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Helpers\ResearchStatus;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\FacadesLog;

class DokumenPermohonan extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'tanggal_persetujuan' => 'date',
        'deadline_penelitian' => 'date',
        'tanggal_draft' => 'datetime',
        'tanggal_submit' => 'datetime',
        'tanggal_validasi_admin' => 'datetime',
        'tanggal_verifikasi_pejabat' => 'datetime',
        'tanggal_mulai_riset' => 'datetime',
        'paper_submitted_at' => 'datetime',
        'paper_validated_at' => 'datetime',
        'admin_validated_at' => 'datetime',
        'letter_generated_at' => 'datetime',
        'dapat_perijinan_lagi' => 'boolean',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function kantorBeaCukai()
    {
        return $this->belongsTo(KantorBeaCukai::class, 'kantor_tujuan', 'id');
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


    // Validasi transisi status sesuai role
    public function canTransition($toStatus, $user)
    {
        $role = $user->role ?? null;
        $fromStatus = $this->status;
        return ResearchStatus::canTransition($fromStatus, $toStatus, $role);
    }

    // Helper untuk update status dengan validasi
    public function updateStatusWithRole($toStatus, $user, $extra = [])
    {
        if (!$this->canTransition($toStatus, $user)) {
            throw new \Exception('Transisi status tidak valid atau role tidak sesuai');
        }
        $this->status = $toStatus;
        // Set tanggal persetujuan dan deadline saat status menjadi 'diterima'
        if ($toStatus === ResearchStatus::DITERIMA) {
            $this->tanggal_persetujuan = Carbon::now();
            $this->deadline_penelitian = Carbon::now()->addYear();
            $this->status_penelitian = 'sedang_berjalan';
        }
        foreach ($extra as $key => $val) {
            $this->$key = $val;
        }
        $this->save();
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
