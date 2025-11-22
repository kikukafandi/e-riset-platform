<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TopikRiset extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_topik',
        'deskripsi',
    ];

    public function dokumenPermohonans()
    {
        return $this->hasMany(DokumenPermohonan::class, 'topik_tujuan_riset', 'nama_topik');
    }

    public function usageStats()
    {
        return $this->hasMany(TopikUsageStat::class);
    }

    // Get total usage count
    public function getTotalUsageAttribute()
    {
        return $this->dokumenPermohonans()->count();
    }

    // Get usage count for specific period
    public function getUsageForPeriod($year, $month = null)
    {
        $query = $this->dokumenPermohonans()
            ->whereYear('created_at', $year);
        
        if ($month) {
            $query->whereMonth('created_at', $month);
        }
        
        return $query->count();
    }

    // Update usage statistics
    public function updateUsageStats($year, $month)
    {
        $count = $this->getUsageForPeriod($year, $month);
        
        TopikUsageStat::updateOrCreate(
            [
                'topik_riset_id' => $this->id,
                'year' => $year,
                'month' => $month
            ],
            ['usage_count' => $count]
        );
    }
}
