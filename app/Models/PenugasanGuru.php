<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PenugasanGuru extends Model
{
    use HasFactory;
    protected $table = 'guru_penugasan';

    protected $fillable = [
        'guru_id',
        'nomor_surat_tugas',
        'tanggal_surat_tugas',
        'tahun_ajaran',
        'sekolah_induk',
        'sk_pengangkatan',
        'tmt_pengangkatan',
        'lembaga_pengangkat',
    ];

    public function guru(): BelongsTo
    {
        return $this->belongsTo(Guru::class, 'guru_id', 'id');
    }
}
