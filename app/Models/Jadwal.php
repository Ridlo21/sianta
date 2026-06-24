<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    use HasFactory;

    protected $table = 'jadwal';

    protected $fillable = [
        'version_id',
        'slot_waktu_id',
        'pembelajaran_id',
    ];

    public function version()
    {
        return $this->belongsTo(JadwalVersion::class, 'version_id');
    }

    public function slotWaktu()
    {
        return $this->belongsTo(SlotWaktu::class, 'slot_waktu_id');
    }

    public function pembelajaran()
    {
        return $this->belongsTo(Pembelajaran::class, 'pembelajaran_id');
    }
}
