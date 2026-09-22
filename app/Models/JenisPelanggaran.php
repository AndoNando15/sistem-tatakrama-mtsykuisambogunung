<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JenisPelanggaran extends Model
{
    protected $table = 'jenis_pelanggaran';

    protected $fillable = [
        'kategori_id',
        'kode_pelanggaran',
        'uraian_pelanggaran',
        'poin',
        'sanksi_default',
        'is_active',
    ];

    protected $casts = ['is_active' => 'boolean', 'poin' => 'integer'];

    /**
     * Relasi: setiap jenis pelanggaran milik satu kategori.
     */
    public function kategori(): BelongsTo
    {
        return $this->belongsTo(KategoriPelanggaran::class, 'kategori_id');
    }

    /**
     * Scope: hanya jenis pelanggaran aktif.
     */
    public function scopeAktif($query)
    {
        return $query->where('is_active', true);
    }
}
