<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Siswa extends Model
{
    /**
     * The table associated with the model.
     */
    protected $table = 'siswa';

    /**
     * Mass assignable attributes.
     */
    protected $fillable = [
        'kelas_id',
        'nis_nisn',
        'nama_siswa',
        'jenis_kelamin',
        'nama_orang_tua',
        'no_hp_orang_tua',
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
     * Relasi ke tabel kelas.
     * Setiap siswa terdaftar di satu kelas.
     */
    public function kelas(): BelongsTo
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    /**
     * Relasi ke tabel pelanggaran_siswa.
     * Satu siswa dapat memiliki banyak catatan pelanggaran.
     */
    public function pelanggaranSiswa(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(PelanggaranSiswa::class, 'siswa_id');
    }

    // ==========================================================
    // SCOPES
    // ==========================================================

    /**
     * Scope untuk hanya mengambil siswa yang aktif (is_active = true).
     * Ini menghindari penggunaan hard delete, menjaga riwayat historis.
     */
    public function scopeAktif($query)
    {
        return $query->where('is_active', true);
    }

    // ==========================================================
    // ACCESSORS
    // ==========================================================

    /**
     * Menampilkan label jenis kelamin secara lengkap.
     */
    public function getJenisKelaminLabelAttribute(): string
    {
        return match ($this->jenis_kelamin) {
            'L' => 'Laki-laki',
            'P' => 'Perempuan',
            default => '-',
        };
    }
}
