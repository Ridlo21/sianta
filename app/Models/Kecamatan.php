<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kecamatan extends Model
{
    protected $table = 'kecamatan';
    protected $primaryKey = 'id';
    protected $fillable = ['name'];

    public function kabupaten()
    {
        return $this->belongsTo(Kabupaten::class, 'regency_id');
    }

    public function desa()
    {
        return $this->hasMany(Desa::class, 'district_id');
    }
}
