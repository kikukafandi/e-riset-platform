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
}
