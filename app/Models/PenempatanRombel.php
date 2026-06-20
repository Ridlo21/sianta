<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenempatanRombel extends Model
{
    protected $table = 'penempatan_rombel';

    protected $fillable = [
        'rombel_id',
        'siswa_id',
        'tahun_ajaran_id',
        'status_aktif',
    ];

    public function rombel()
    {
        return $this->belongsTo(Rombel::class, 'rombel_id');
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id', 'id_person');
    }
}
