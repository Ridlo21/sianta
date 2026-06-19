<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PendidikanGuru extends Model
{
    use HasFactory;
    protected $table = 'guru_pendidikan';

    protected $fillable = [
        'guru_id',
        'jenjang',
        'jurusan',
        'nama_instansi',
        'tahun_masuk',
        'tahun_lulus',
        'nomor_ijazah',
        'scan_file_ijazah',
    ];

    public function guru(): BelongsTo
    {
        return $this->belongsTo(Guru::class, 'guru_id', 'id');
    }
}
