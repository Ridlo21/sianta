<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SlotWaktu extends Model
{
    use HasFactory;

    protected $table = 'slot_waktu';

    protected $fillable = [
        'hari',
        'jam_ke',
        'waktu_mulai',
        'waktu_selesai',
        'is_istirahat',
    ];
}
