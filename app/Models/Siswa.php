<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;
    protected $table = 'siswa';
    protected $primaryKey = 'id_person';

    protected $fillable = [
        'no_kk',
        'nik',
        'niup',
        'nisn',
        'nis',
        'nama',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'agama_id',
        'kewarganegaraan',
        'dlm_klrg',
        'ank_ke',
        'sdr',
        'alamat_lengkap',
        'desa',
        'kec',
        'kab',
        'prov',
        'pos',
        'asal_sekolah',
        'nomor_ijazah',
        'no_akta',
        'tinggal_di',
        'tinggi_badan',
        'berat_badan',
        'hoby',
        'cita_cita',

        // ayah
        'nik_a',
        'nm_a',
        'tgl_lahir_a',
        'tmpt_lahir_a',
        'agama_a',
        'pkrjn_a',
        'pndkn_a',
        'penghasilan_a',

        // ibu
        'nik_i',
        'nm_i',
        'tgl_lahir_i',
        'tmpt_lahir_i',
        'agama_i',
        'pkrjn_i',
        'pndkn_i',
        'penghasilan_i',

        // wali
        'nik_w',
        'nm_w',
        'tgl_lahir_w',
        'tmpt_lahir_w',
        'agama_w',
        'almt_w',
        'desa_w',
        'kec_w',
        'kab_w',
        'prov_w',
        'pos_w',
        'pkrjn_w',
        'pndkn_w',
        'penghasilan_w',
        'hp_w',
        'foto_warna_santri',
        'foto_wali_santri_warna',
        'foto_scan_kk',
        'foto_scan_akta',
        'foto_scan_skck',
        'foto_scan_ket_sehat',
        'foto_ijazah',
        'foto_skl',
        'file_kip',
        'status',
        'jenis_daftar',
        'jurusan_id',
        'tgl_daftar',
        'user_id',
        'status_step'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function agama()
    {
        return $this->belongsTo(Agama::class, 'agama_id');
    }

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_id');
    }
}
