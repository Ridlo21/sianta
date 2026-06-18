<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    use HasFactory;
    protected $table = 'guru';

    protected $fillable = [
        'nip',
        'nuptk',
        'nik',
        'nama',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'agama_id',
        'status_perkawinan',
        'alamat',
        'desa',
        'kec',
        'kab',
        'prov',
        'pos',
        'email',
        'no_hp',
        'foto',
        'jenis_gtk',
        'jabatan_gtk',
        'status_kepegawaian',
        'jurusan',
        'status_aktif',
        'tahun_pensiun',
    ];

    public function agama()
    {
        return $this->belongsTo(Agama::class, 'agama_id');
    }

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_id');
    }
}
