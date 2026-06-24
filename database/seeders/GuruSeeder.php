<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Guru;
use App\Models\Gurukeluarga;
use App\Models\Agama;
use App\Models\Provinsi;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Desa;
use Faker\Factory as Faker;
use Illuminate\Support\Str;

class GuruSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        $agamas = Agama::pluck('id')->toArray();
        $provinsis = Provinsi::all();
        $provinsi = $provinsis->first();
        $prov_id = $provinsi ? $provinsi->id : '35';

        $kab_id = '3510';
        $kec_id = '3510171';
        $desa_id = '3510171008';

        if ($provinsi) {
            $kab = Kabupaten::where('province_id', $prov_id)->first();
            if ($kab) {
                $kab_id = $kab->id;
                $kec = Kecamatan::where('regency_id', $kab_id)->first();
                if ($kec) {
                    $kec_id = $kec->id;
                    $desa = Desa::where('district_id', $kec_id)->first();
                    if ($desa) {
                        $desa_id = $desa->id;
                    }
                }
            }
        }

        $jenis_gtks = ['Guru Mapel', 'Guru Kelas', 'Guru BK', 'Tenaga Administrasi Sekolah', 'Pustakawan', 'Laboran'];
        $jabatan_gtks = ['Guru TIK', 'Guru Kelas', 'Guru BK', 'Staf Tata Usaha', 'Pustakawan', 'Laboran'];
        $status_kepegawaians = ['PNS', 'PPPK', 'GTY/PTY', 'GTT/PTT Provinsi', 'Guru Honor Sekolah'];
        $lembaga_pengangkats = ['Ketua Yayasan', 'Pemerintah Provinsi', 'Pemerintah Kabupaten', 'Kepala Sekolah'];
        
        $pekerjaans = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
        try {
            $db_pkrjn = \DB::table('pekerjaan')->pluck('id')->toArray();
            if (!empty($db_pkrjn)) $pekerjaans = $db_pkrjn;
        } catch (\Exception $e) {}

        for ($i = 1; $i <= 40; $i++) {
            $is_male = $faker->boolean();
            $gender = $is_male ? 'L' : 'P';
            $gelar_depan = $faker->randomElement(['Dr.', 'Drs.', 'H.', 'Hj.', '']);
            $gelar_belakang = $faker->randomElement(['S.Pd.', 'S.Kom.', 'M.Pd.', 'S.E.', 'S.T.', '']);
            
            $first_name = $is_male ? $faker->firstNameMale() : $faker->firstNameFemale();
            $last_name = $faker->lastName();
            $nama = strtoupper($first_name . ' ' . $last_name);

            $status_perkawinan = $faker->randomElement(['kawin', 'belum']);

            $guru = Guru::create([
                'niy' => $faker->numerify('##############'),
                'nuptk' => $faker->numerify('896177##########'),
                'nik' => $faker->numerify('35##############'),
                'nama' => $nama,
                'gelar_depan' => $gelar_depan ?: null,
                'gelar_belakang' => $gelar_belakang ?: null,
                'jenis_kelamin' => $gender,
                'tempat_lahir' => substr(strtoupper($faker->city()), 0, 50),
                'tanggal_lahir' => $faker->dateTimeBetween('-55 years', '-23 years')->format('Y-m-d'),
                'agama_id' => $faker->randomElement($agamas) ?: 1,
                'status_perkawinan' => $status_perkawinan,
                'alamat' => strtoupper($faker->streetAddress()),
                'desa' => $desa_id,
                'kec' => $kec_id,
                'kab' => $kab_id,
                'prov' => $prov_id,
                'pos' => $faker->postcode(),
                'email' => $faker->email(),
                'no_hp' => $faker->numerify('08##########'),
                'jenis_gtk' => $faker->randomElement($jenis_gtks),
                'jabatan_gtk' => $faker->randomElement($jabatan_gtks),
                'status_kepegawaian' => $faker->randomElement($status_kepegawaians),
                'sk_pengangkatan' => $faker->numerify('SK-YNAA/####/20##'),
                'tmt_pengangkatan' => $faker->dateTimeBetween('-8 years', '-1 years')->format('Y-m-d'),
                'lembaga_pengangkat' => $faker->randomElement($lembaga_pengangkats),
                'npwp' => substr($faker->numerify('##.###.###.#-###.###'), 0, 30),
                'nama_wajib_pajak' => $nama,
                'sekolah_induk' => $faker->boolean(80) ? 1 : 0,
                'status_kuliah' => $faker->boolean(10) ? 1 : 0,
                'no_surat_tugas' => $faker->numerify('ST-YNAA/####/20##'),
                'tgl_surat_tugas' => $faker->dateTimeBetween('-1 years', 'now')->format('Y-m-d'),
                'status_aktif' => 1,
                'tahun_pensiun' => $faker->numberBetween(2045, 2065),
                'created_at' => now(),
                'updated_at' => now()
            ]);

            Gurukeluarga::create([
                'guru_id' => $guru->id,
                'nama_ibu' => strtoupper($faker->name('female')),
                'nama_pasangan' => $status_perkawinan === 'kawin' ? strtoupper($faker->name($gender === 'L' ? 'female' : 'male')) : null,
                'pekerjaan_pasangan' => $status_perkawinan === 'kawin' ? $faker->randomElement($pekerjaans) : null,
                'kartu_pasangan' => $status_perkawinan === 'kawin' ? strtoupper(Str::random(10)) : null,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        $this->command->info('40 dummy guru and guru_keluarga records seeded successfully!');
    }
}
