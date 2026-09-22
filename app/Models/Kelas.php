<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kelas extends Model
{
    /**
     * The table associated with the model.
     */
    protected $table = 'kelas';

    /**
     * Mass assignable attributes.
     */
    protected $fillable = [
        'nama_kelas',
        'wali_kelas_id',
        'is_active',
    ];

    /**
     * Cast attributes.
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];

    // ==========================================================
    // RELATIONSHIPS
    // ==========================================================

    /**
     * Relasi ke tabel siswa.
     * Satu kelas memiliki banyak siswa.
     */
    public function siswa(): HasMany
    {
        return $this->hasMany(Siswa::class, 'kelas_id');
    }

    /**
     * Relasi ke wali kelas (User).
     */
    public function waliKelas()
    {
        return $this->belongsTo(User::class, 'wali_kelas_id');
    }

    // ==========================================================
    // SCOPES
    // ==========================================================

    /**
     * Scope untuk hanya mengambil kelas yang aktif.
     */
    public function scopeAktif($query)
    {
        return $query->where('is_active', true);
    }
}
