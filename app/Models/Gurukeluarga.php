<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Gurukeluarga extends Model
{
    protected $table = 'guru_keluarga';

    protected $fillable = [
        'guru_id',
        'nama_ibu',
        'nama_pasangan',
        'pekerjaan_pasangan',
        'kartu_pasangan',
    ];

    public function guru(): BelongsTo
    {
        return $this->belongsTo(Guru::class, 'guru_id', 'id');
    }
}
