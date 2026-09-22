<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MataPelajaran extends Model
{
    protected $table = 'mata_pelajaran';

    protected $fillable = ['kode_mapel', 'nama_mapel', 'is_active'];

    protected $casts = ['is_active' => 'boolean'];

    /**
     * Scope: hanya mapel yang aktif.
     */
    public function scopeAktif($query)
    {
        return $query->where('is_active', true);
    }
}
