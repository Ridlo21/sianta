<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kabupaten extends Model
{
    protected $table = 'kabupaten';
    protected $primaryKey = 'id';
    protected $fillable = ['name'];

    public function provinsi()
    {
        return $this->belongsTo(Provinsi::class, 'province_id');
    }

    public function kecamatan()
    {
        return $this->hasMany(Kecamatan::class, 'regency_id');
    }
}
