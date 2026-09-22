<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TahunAjaran extends Model
{
    protected $table = 'tahun_ajaran';

    protected $fillable = ['tahun', 'semester', 'is_active'];

    protected $casts = ['is_active' => 'boolean'];

    /**
     * Label tampilan tahun ajaran lengkap.
     */
    public function getLabelAttribute(): string
    {
        return $this->tahun . ' / ' . ucfirst($this->semester);
    }

    /**
     * Scope: hanya tahun ajaran yang aktif.
     */
    public function scopeAktif($query)
    {
        return $query->where('is_active', true);
    }
}
