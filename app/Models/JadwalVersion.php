<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalVersion extends Model
{
    use HasFactory;

    protected $table = 'jadwal_versions';

    protected $fillable = [
        'periode_akademik_id',
        'nama_versi',
        'is_active',
    ];

    public function periode()
    {
        return $this->belongsTo(Periode::class, 'periode_akademik_id');
    }

    public function jadwal()
    {
        return $this->hasMany(Jadwal::class, 'version_id');
    }
}
