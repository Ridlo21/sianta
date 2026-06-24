<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Hashidable;

class Guru extends Model
{
    use HasFactory, Hashidable;
    protected $table = 'guru';

    protected $appends = ['nama_lengkap'];

    protected $fillable = [
        'niy',
        'gelar_depan',
        'gelar_belakang',
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
        'scan_kk',
        'scan_akta',
        'scan_ktp',
        'scan_sk',
        'scan_transkrip_nilai',
        'jenis_gtk',
        'jabatan_gtk',
        'status_kepegawaian',
        'sk_pengangkatan',
        'tmt_pengangkatan',
        'lembaga_pengangkat',
        'npwp',
        'nama_wajib_pajak',
        'sekolah_induk',
        'status_kuliah',
        'no_surat_tugas',
        'tgl_surat_tugas',
        'status_aktif',
        'tahun_pensiun',
    ];

    public function agama()
    {
        return $this->belongsTo(Agama::class, 'agama_id');
    }

    public function keluarga()
    {
        return $this->hasOne(Gurukeluarga::class, 'guru_id', 'id');
    }

    public function pendidikan()
    {
        return $this->hasMany(PendidikanGuru::class, 'guru_id', 'id');
    }

    public function provinsi()
    {
        return $this->belongsTo(Provinsi::class, 'prov');
    }

    public function kabupaten()
    {
        return $this->belongsTo(Kabupaten::class, 'kab');
    }

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class, 'kec');
    }

    public function desa()
    {
        return $this->belongsTo(Desa::class, 'desa');
    }

    public function desaDetail()
    {
        return $this->belongsTo(Desa::class, 'desa', 'id');
    }

    public function pembelajaran()
    {
        return $this->hasMany(Pembelajaran::class, 'guru_id');
    }

    public function getNamaLengkapAttribute()
    {
        $gelarDepan = $this->gelar_depan ? trim($this->gelar_depan) . ' ' : '';
        $gelarBelakang = $this->gelar_belakang ? ', ' . trim($this->gelar_belakang) : '';
        return $gelarDepan . $this->nama . $gelarBelakang;
    }
}
