<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Guru;
use App\Models\Rombel;
use App\Models\MataPelajaran;
use App\Models\Jurusan;
use App\Models\Periode;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Admincontroller extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if (!$user) {
            abort(403, 'Unauthorized');
        }
        $title = 'Dashboard';

        // 1. Statistik Utama
        $tahunAktif = TahunAjaran::where('status', '1')->first();

        $totalSiswa = Siswa::where('status', 'Aktif')->count();
        $totalGuru = Guru::count();
        $totalRombel = Rombel::where('status', 1)
            ->when($tahunAktif, function ($query) use ($tahunAktif) {
                $query->where('tahun_ajaran_id', $tahunAktif->id);
            })
            ->count();
        $totalMapel = MataPelajaran::count();

        // 2. Data Grafik Jenis Kelamin
        $siswaLaki = Siswa::where('status', 'Aktif')->where('jenis_kelamin', 'Laki-Laki')->count();
        $siswaPerempuan = Siswa::where('status', 'Aktif')->where('jenis_kelamin', 'Perempuan')->count();

        // 3. Data Grafik Jurusan
        $jurusanList = Jurusan::all();
        $jurusanLabels = [];
        $jurusanCounts = [];
        foreach ($jurusanList as $jurusan) {
            $jurusanLabels[] = $jurusan->kode_nomenklatur;
            $jurusanCounts[] = Siswa::where('status', 'Aktif')->where('jurusan_id', $jurusan->id)->count();
        }

        // 4. Pendaftaran Siswa Terbaru (5 Terakhir)
        $siswaTerbaru = Siswa::orderBy('id_person', 'desc')->take(5)->get();

        // 5. Periode Aktif
        $periodeAktif = Periode::where('status', 1)->first();

        return view('admin.dashboard.utama', compact(
            'title',
            'user',
            'totalSiswa',
            'totalGuru',
            'totalRombel',
            'totalMapel',
            'siswaLaki',
            'siswaPerempuan',
            'jurusanLabels',
            'jurusanCounts',
            'siswaTerbaru',
            'periodeAktif'
        ));
    }
}
