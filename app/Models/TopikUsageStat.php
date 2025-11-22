<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TopikUsageStat extends Model
{
    use HasFactory;

    protected $fillable = [
        'topik_riset_id',
        'usage_count',
        'year',
        'month'
    ];

    public function topikRiset()
    {
        return $this->belongsTo(TopikRiset::class);
    }
}