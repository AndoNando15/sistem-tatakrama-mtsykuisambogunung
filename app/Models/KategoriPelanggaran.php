<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KategoriPelanggaran extends Model
{
    protected $table = 'kategori_pelanggaran';

    protected $fillable = ['kode', 'nama_kategori', 'sifat_akumulasi'];

    /**
     * Relasi: satu kategori memiliki banyak jenis pelanggaran.
     */
    public function jenisPelanggaran(): HasMany
    {
        return $this->hasMany(JenisPelanggaran::class, 'kategori_id');
    }

    /**
     * Label sifat akumulasi yang human-readable.
     */
    public function getSifatAkumulasiLabelAttribute(): string
    {
        return match ($this->sifat_akumulasi) {
            'semester'   => 'Per Semester',
            'tahunan'    => 'Per Tahun',
            'selamanya'  => 'Selamanya (Permanen)',
            default      => ucfirst($this->sifat_akumulasi),
        };
    }
}
