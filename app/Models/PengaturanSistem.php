<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengaturanSistem extends Model
{
    use HasFactory;

    protected $table = 'pengaturan_sistem';

    protected $fillable = [
        'nama_sekolah',
        'npsn',
        'alamat_sekolah',
        'nama_kepala_sekolah',
        'nip_kepala_sekolah',
        'nama_guru_bk',
        'nip_guru_bk',
        'logo_path',
    ];

    public static function getSettings(): self
    {
        return static::firstOrCreate([], [
            'nama_sekolah'        => 'MTs Negeri Tatakrama',
            'npsn'                => '12345678',
            'alamat_sekolah'      => 'Jl. Pendidikan No. 1, Kota',
            'nama_kepala_sekolah' => 'Drs. H. Ahmad Dahlan, M.Pd',
            'nip_kepala_sekolah'  => '197001011995031001',
            'nama_guru_bk'        => 'Siti Rahmawati, S.Psi',
            'nip_guru_bk'         => '198205102008012003',
        ]);
    }
}
