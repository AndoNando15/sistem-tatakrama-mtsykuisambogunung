<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AturanSanksiKumulasi extends Model
{
    protected $table = 'aturan_sanksi_kumulasi';

    protected $fillable = ['min_poin', 'max_poin', 'tindakan', 'nilai_sikap'];

    protected $casts = ['min_poin' => 'integer', 'max_poin' => 'integer'];

    /**
     * Label rentang poin.
     */
    public function getRentangPoinAttribute(): string
    {
        return $this->min_poin . ' – ' . $this->max_poin . ' poin';
    }
}
