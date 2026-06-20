<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rombel extends Model
{
    protected $table = 'rombel';

    protected $fillable = [
        'kelas_id',
        'nama_rombel',
        'jurusan_id',
        'tahun_ajaran_id',
        'status',
    ];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    public function penempatanRombel()
    {
        return $this->hasMany(PenempatanRombel::class, 'rombel_id');
    }

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_id');
    }

    public function waliRombel()
    {
        return $this->hasMany(WaliRombel::class, 'rombel_id');
    }

    public function pembelajaran()
    {
        return $this->hasMany(Pembelajaran::class, 'rombel_id');
    }
}
