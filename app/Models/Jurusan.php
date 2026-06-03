<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    use HasFactory;
    protected $table = 'jurusan';
    protected $fillable = [
        'kode_nomenklatur',
        'bidang_keahlian',
        'program_keahlian',
        'kons_keahlian',
        'deskripsi',
        'foto',
        'status',
    ];
}
