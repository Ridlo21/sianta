<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    protected $table = 'kelas';
    protected $primaryKey = 'id';

    public function rombel()
    {
        return $this->hasMany(Rombel::class, 'kelas_id');
    }
}
