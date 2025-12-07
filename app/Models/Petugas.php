<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Petugas extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'petugas';

    protected $guarded = ['id'];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function getRoleAttribute()
    {
        return $this->attributes['role'] ?? null;
    }

    /**
     * Relasi ke kantor bea cukai
     */
    public function kantor()
    {
        return $this->belongsTo(KantorBeaCukai::class, 'kantor_id');
    }

    /**
     * Scope untuk filter petugas aktif
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope untuk filter berdasarkan role
     */
    public function scopeByRole($query, $role)
    {
        return $query->where('role', $role);
    }

    /**
     * Check apakah petugas adalah super user
     */
    public function isSuperUser(): bool
    {
        return $this->role === 'super_user';
    }

    /**
     * Check apakah petugas bisa mengakses dokumen dari kantor tertentu
     */
    public function canAccessKantor($kodeKantor): bool
    {
        // Super user bisa akses semua kantor
        if ($this->isSuperUser()) {
            return true;
        }

        // Petugas hanya bisa akses kantor sendiri
        return $this->kantor && $this->kantor->kode_kantor === $kodeKantor;
    }
}
