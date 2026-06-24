<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Siswa;
use App\Models\Agama;
use App\Models\Jurusan;
use App\Models\Provinsi;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Desa;
use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Support\Str;

class SiswaSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // Fetch foreign references or use fallbacks
        $agamas = Agama::pluck('id')->toArray();
        $jurusans = Jurusan::pluck('id')->toArray();
        
        $provinsis = Provinsi::all();
        $provinsi = $provinsis->first();
        $prov_id = $provinsi ? $provinsi->id : '35';

        // Find kab, kec, desa associated with prov
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

        $user_id = User::first()->id ?? 1;

        $hobbies = ['MEMBACA', 'BERMAIN BOLA', 'MENULIS', 'BERENANG', 'MENYANYI', 'GAMING', 'BULUTANGKIS', 'MELUKIS'];
        $cita_citas = ['DOKTER', 'GURU', 'TENTARA', 'POLISI', 'PENGUSAHA', 'PROGRAMMER', 'PILOT', 'ARSITEK'];
        $tempat_lahirs = ['BANYUWANGI', 'SURABAYA', 'JAKARTA', 'MALANG', 'BANDUNG', 'SEMARANG', 'YOGYAKARTA', 'BALI'];
        
        // Match the database enum exactly:
        // 'BERSAMA ORANG TUA','WALI','KOST','ASRAMA','PANTI ASUHAN','PESANTREN','LAINNYA'
        $tinggal_dis = ['BERSAMA ORANG TUA', 'WALI', 'KOST', 'ASRAMA', 'PANTI ASUHAN', 'PESANTREN', 'LAINNYA'];
        
        $pkrjns = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
        $pndkns = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
        $penghasilans = [1, 2, 3, 4, 5];

        // Retrieve actual IDs from DB if they exist
        try {
            $db_pkrjn = \DB::table('pekerjaan')->pluck('id')->toArray();
            if (!empty($db_pkrjn)) $pkrjns = $db_pkrjn;
            
            $db_pndkn = \DB::table('pendidikan')->pluck('id')->toArray();
            if (!empty($db_pndkn)) $pndkns = $db_pndkn;

            $db_penghasilan = \DB::table('penghasilan')->pluck('id')->toArray();
            if (!empty($db_penghasilan)) $penghasilans = $db_penghasilan;
        } catch (\Exception $e) {
            // ignore database table checks if tables don't exist
        }

        $students = [];
        for ($i = 1; $i <= 100; $i++) {
            $is_male = $faker->boolean();
            $gender = $is_male ? 'Laki-Laki' : 'Perempuan';
            $first_name = $is_male ? $faker->firstNameMale() : $faker->firstNameFemale();
            $last_name = $faker->lastName();
            $nama = substr(strtoupper($first_name . ' ' . $last_name), 0, 54);

            $nik = $faker->numerify('35##############');
            $no_kk = $faker->numerify('35##############');
            $nisn = $faker->numerify('300#######');
            $nis = $faker->numerify('2026/####');
            
            $students[] = [
                'no_kk' => $no_kk,
                'nik' => $nik,
                'no_akta' => strtoupper(Str::random(10)),
                'niup' => $nik,
                'nis' => $nis,
                'nisn' => $nisn,
                'nama' => $nama,
                'tempat_lahir' => $faker->randomElement($tempat_lahirs),
                'tanggal_lahir' => $faker->dateTimeBetween('-18 years', '-12 years')->format('Y-m-d'),
                'jenis_kelamin' => $gender,
                'agama_id' => $faker->randomElement($agamas) ?: 1,
                'kewarganegaraan' => 'WNI',
                'dlm_klrg' => $faker->randomElement(['Kandung', 'Tiri', 'Angkat']),
                'ank_ke' => $faker->numberBetween(1, 4),
                'sdr' => $faker->numberBetween(1, 5),
                'tinggal_di' => $faker->randomElement($tinggal_dis),
                'tinggi_badan' => $faker->numberBetween(140, 185),
                'berat_badan' => $faker->numberBetween(35, 80),
                'hoby' => $faker->randomElement($hobbies),
                'cita_cita' => $faker->randomElement($cita_citas),
                'alamat_lengkap' => strtoupper($faker->streetAddress()),
                'desa' => $desa_id,
                'kec' => $kec_id,
                'kab' => $kab_id,
                'prov' => $prov_id,
                'pos' => $faker->postcode(),
                'asal_sekolah' => substr('SMP ' . strtoupper($faker->company()), 0, 100),
                'nomor_ijazah' => strtoupper(Str::random(12)),
                
                // Ayah
                'nik_a' => $faker->numerify('35##############'),
                'nm_a' => substr(strtoupper($faker->name('male')), 0, 100),
                'tgl_lahir_a' => $faker->dateTimeBetween('-60 years', '-35 years')->format('Y-m-d'),
                'tmpt_lahir_a' => $faker->randomElement($tempat_lahirs),
                'agama_a' => $faker->randomElement($agamas) ?: 1,
                'pkrjn_a' => $faker->randomElement($pkrjns),
                'pndkn_a' => $faker->randomElement($pndkns),
                'penghasilan_a' => $faker->randomElement($penghasilans),

                // Ibu
                'nik_i' => $faker->numerify('35##############'),
                'nm_i' => substr(strtoupper($faker->name('female')), 0, 100),
                'tgl_lahir_i' => $faker->dateTimeBetween('-55 years', '-30 years')->format('Y-m-d'),
                'tmpt_lahir_i' => $faker->randomElement($tempat_lahirs),
                'agama_i' => $faker->randomElement($agamas) ?: 1,
                'pkrjn_i' => $faker->randomElement($pkrjns),
                'pndkn_i' => $faker->randomElement($pndkns),
                'penghasilan_i' => $faker->randomElement($penghasilans),

                // Wali
                'nik_w' => $faker->numerify('35##############'),
                'nm_w' => substr(strtoupper($faker->name('male')), 0, 100),
                'tgl_lahir_w' => $faker->dateTimeBetween('-60 years', '-35 years')->format('Y-m-d'),
                'tmpt_lahir_w' => $faker->randomElement($tempat_lahirs),
                'agama_w' => $faker->randomElement($agamas) ?: 1,
                'almt_w' => strtoupper($faker->streetAddress()),
                'desa_w' => $desa_id,
                'kec_w' => $kec_id,
                'kab_w' => $kab_id,
                'prov_w' => $prov_id,
                'pos_w' => $faker->postcode(),
                'pkrjn_w' => $faker->randomElement($pkrjns),
                'pndkn_w' => $faker->randomElement($pndkns),
                'penghasilan_w' => $faker->randomElement($penghasilans),
                'hp_w' => $faker->numerify('08##########'),

                'status' => 'Aktif',
                'jenis_daftar' => 'BARU',
                'jurusan_id' => $faker->randomElement($jurusans) ?: 1,
                'tgl_daftar' => now(),
                'user_id' => $user_id,
                'status_step' => 4,
                'created_at' => now(),
                'updated_at' => now()
            ];
        }

        Siswa::insert($students);
        $this->command->info('100 dummy siswa records seeded successfully!');
    }
}
