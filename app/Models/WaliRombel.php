<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WaliRombel extends Model
{
    protected $table = 'wali_rombel';

    protected $fillable = [
        'rombel_id',
        'guru_id',
        'tahun_ajaran_id',
        'status',
    ];

    public function rombel()
    {
        return $this->belongsTo(Rombel::class, 'rombel_id');
    }

    public function guru()
    {
        return $this->belongsTo(Guru::class, 'guru_id');
    }

    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class, 'tahun_ajaran_id');
    }
}
