<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembelajaran extends Model
{
    use HasFactory;

    protected $table = 'pembelajaran';

    protected $fillable = [
        'rombel_id',
        'mapel_id',
        'guru_id',
        'sk_mengajar',
        'tanggal_sk',
        'jam_mengajar',
        'status_aktif',
    ];

    public function rombel()
    {
        return $this->belongsTo(Rombel::class, 'rombel_id');
    }

    public function mataPelajaran()
    {
        return $this->belongsTo(MataPelajaran::class, 'mapel_id');
    }

    public function guru()
    {
        return $this->belongsTo(Guru::class, 'guru_id');
    }
}
