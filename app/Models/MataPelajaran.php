<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MataPelajaran extends Model
{
    use HasFactory;

    protected $table = 'mata_pelajaran';

    protected $fillable = [
        'kode_mapel',
        'nama_mapel',
        'kelompok',
        'status',
    ];

    public function pembelajaran()
    {
        return $this->hasMany(Pembelajaran::class, 'mapel_id');
    }
}
