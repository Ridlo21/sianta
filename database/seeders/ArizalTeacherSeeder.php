<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Agama;
use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\Rombel;
use App\Models\MataPelajaran;
use App\Models\Guru;
use App\Models\Gurukeluarga;
use App\Models\PendidikanGuru;
use App\Models\Pembelajaran;
use App\Models\Pekerjaan;

class ArizalTeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Get or create Agama record for Islam
        $agama = Agama::where('nama_agama', 'like', '%Islam%')->first();
        $agama_id = $agama ? $agama->id : 1;

        // 2. Get Jurusan PPLG (should be ID: 1, fallback to find by name/first)
        $jurusan = Jurusan::where('program_keahlian', 'like', '%Pengembangan Perangkat Lunak%')
            ->orWhere('id', 1)
            ->first();
        $jurusan_id = $jurusan ? $jurusan->id : 1;

        // 3. Get Kelas X (should be ID: 1)
        $kelas = Kelas::where('nama_kelas', 'X')->orWhere('id', 1)->first();
        $kelas_id = $kelas ? $kelas->id : 1;

        // 4. Create Rombels: 10 RPL 2 and 10 RPL 3 (using tahun_ajaran_id = 1)
        $rombel2 = Rombel::updateOrCreate(
            ['nama_rombel' => '10 RPL 2'],
            [
                'kelas_id' => $kelas_id,
                'jurusan_id' => $jurusan_id,
                'tahun_ajaran_id' => 1,
                'status' => 1
            ]
        );

        $rombel3 = Rombel::updateOrCreate(
            ['nama_rombel' => '10 RPL 3'],
            [
                'kelas_id' => $kelas_id,
                'jurusan_id' => $jurusan_id,
                'tahun_ajaran_id' => 1,
                'status' => 1
            ]
        );

        // 5. Create Mata Pelajaran: 800000121 - Dasar Dasar Pengembangan Perangkat Lunak dan Gim
        $mapel = MataPelajaran::updateOrCreate(
            ['kode_mapel' => '800000121'],
            [
                'nama_mapel' => 'Dasar Dasar Pengembangan Perangkat Lunak dan Gim',
                'kelompok' => 'Kejuruan',
                'status' => 1
            ]
        );

        // 6. Get or create Pekerjaan "Lainnya"
        $pekerjaan = Pekerjaan::where('nama_pekerjaan', 'like', '%Lainnya%')
            ->orWhere('nama_pekerjaan', 'like', '%Lain%')
            ->first();
        if (!$pekerjaan) {
            $pekerjaan = Pekerjaan::create(['nama_pekerjaan' => 'Lainnya']);
        }
        $pekerjaan_id = $pekerjaan->id;

        // 7. Create/Update Teacher Profile: ARIZAL IWAN MABRURI
        $guru = Guru::updateOrCreate(
            ['nik' => '3510182906990002'],
            [
                'nuptk' => '8961777678130212',
                'nama' => 'ARIZAL IWAN MABRURI',
                'jenis_kelamin' => 'L',
                'tempat_lahir' => 'BANYUWANGI',
                'tanggal_lahir' => '1999-06-29',
                'agama_id' => $agama_id,
                'status_perkawinan' => 'Kawin',
                'alamat' => 'DUSUN KRAJAN I RT/RW 002/003 Rt/Rw: 2/3 Desa/Kel. BANGSRING',
                'desa' => 'Bangsring',
                'kec' => 'Wongsorejo',
                'kab' => 'Banyuwangi',
                'prov' => 'Jawa Timur',
                'pos' => '68453',
                'email' => 'iwanmabruri3@gmail.com',
                'no_hp' => '082230765106',
                'jenis_gtk' => 'Guru',
                'jabatan_gtk' => 'Guru TIK',
                'status_kepegawaian' => 'GTY/PTY',
                'sk_pengangkatan' => 'YNAA-10/SK/01/07/2021',
                'tmt_pengangkatan' => '2021-07-07',
                'lembaga_pengangkat' => 'Ketua Yayasan',
                'npwp' => null, // empty in profile
                'nama_wajib_pajak' => null,
                'sekolah_induk' => true,
                'status_kuliah' => false,
                'no_surat_tugas' => 'YNAA-10/SK/01/07/2021',
                'tgl_surat_tugas' => '2021-07-06',
                'status_aktif' => true,
                'tahun_pensiun' => 2059,
                'jurusan_id' => $jurusan_id
            ]
        );

        // 8. Create Family: HOSYATUN (mother), ISNIYAH (wife)
        Gurukeluarga::updateOrCreate(
            ['guru_id' => $guru->id],
            [
                'nama_ibu' => 'HOSYATUN',
                'nama_pasangan' => 'ISNIYAH',
                'pekerjaan_pasangan' => $pekerjaan_id,
                'kartu_pasangan' => null
            ]
        );

        // 9. Create Education: S1 - Informatika
        PendidikanGuru::updateOrCreate(
            [
                'guru_id' => $guru->id,
                'jenjang' => 'S1'
            ],
            [
                'jurusan' => 'Informatika',
                'nama_instansi' => 'Universitas Terbuka / Institut Informatika',
                'tahun_masuk' => 2017,
                'tahun_lulus' => 2021
            ]
        );

        // 10. Create Pembelajaran workload (35 hours for 10 RPL 2, 33 hours for 10 RPL 3)
        Pembelajaran::updateOrCreate(
            [
                'rombel_id' => $rombel2->id,
                'mapel_id' => $mapel->id,
                'guru_id' => $guru->id
            ],
            [
                'sk_mengajar' => 'YNAA-10/SK/01/07/2021',
                'tanggal_sk' => '2021-07-06',
                'jam_mengajar' => 35,
                'status_aktif' => 1
            ]
        );

        Pembelajaran::updateOrCreate(
            [
                'rombel_id' => $rombel3->id,
                'mapel_id' => $mapel->id,
                'guru_id' => $guru->id
            ],
            [
                'sk_mengajar' => 'YNAA-10/SK/01/07/2021',
                'tanggal_sk' => '2021-07-06',
                'jam_mengajar' => 33,
                'status_aktif' => 1
            ]
        );
    }
}
