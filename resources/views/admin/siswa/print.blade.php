<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Detail Siswa - {{ $siswa->nama }}</title>
    <!-- FontAwesome for Premium Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* General Styles for Screen Preview */
        * {
            box-sizing: border-box;
        }
        body {
            background-color: #f1f3f5;
            margin: 0;
            padding: 20px 15px;
            display: flex;
            flex-direction: column;
            align-items: center;
            font-family: Arial, sans-serif;
        }

        /* Screen Control Bar */
        .control-bar {
            width: 210mm;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 12px;
            padding: 10px 20px;
            margin-bottom: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(0, 0, 0, 0.05);
        }
        .btn {
            padding: 8px 16px;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            font-weight: bold;
            font-size: 13px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s ease;
            text-decoration: none;
        }
        .btn-back {
            background-color: #e9ecef;
            color: #495057;
        }
        .btn-back:hover {
            background-color: #dee2e6;
        }
        .btn-print {
            background-color: #3b7ddd;
            color: #ffffff;
        }
        .btn-print:hover {
            background-color: #2b6cb0;
            box-shadow: 0 4px 12px rgba(59, 125, 221, 0.35);
        }
        .control-title {
            font-weight: bold;
            color: #212529;
            font-size: 15px;
        }

        /* A4 Page Container */
        .print-page {
            background-color: #ffffff;
            width: 210mm;
            height: 297mm;
            padding: 8mm 12mm;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        /* NIS & NISN Boxes */
        .header-box {
            display: flex;
            justify-content: space-between;
            width: 100%;
            margin-bottom: 8px;
        }
        .nis-box, .nisn-box {
            border: 3px double #000000;
            padding: 3px 6px;
            font-weight: bold;
            font-size: 10.5pt;
            letter-spacing: 0.5px;
        }
        .nis-box {
            width: 45%;
        }
        .nisn-box {
            width: 48%;
        }

        /* Content Sections Layout */
        .section-row {
            display: flex;
            justify-content: space-between;
            width: 100%;
            margin-bottom: 4px;
        }
        .section-left {
            width: 78%;
        }
        .section-right {
            width: 22%;
            display: flex;
            justify-content: flex-end;
            align-items: flex-start;
            padding-top: 6px;
        }

        /* Section Headings */
        .section-title {
            font-weight: bold;
            font-size: 9.5pt;
            margin-top: 5px;
            margin-bottom: 2px;
            text-transform: uppercase;
            letter-spacing: 0.2px;
        }

        /* Form Tables */
        .form-table {
            width: 100%;
            border-collapse: collapse;
        }
        .form-table td {
            padding: 0.8px 0;
            vertical-align: top;
            font-size: 9pt;
            line-height: 1.2;
        }
        .col-num {
            width: 25px;
            padding-left: 5px !important;
        }
        .col-label {
            width: 180px;
        }
        .col-colon {
            width: 12px;
            text-align: center;
        }
        .col-val {
            word-break: break-word;
        }

        /* Nested Tables */
        .sub-form-table {
            width: 100%;
            border-collapse: collapse;
        }
        .sub-form-table td {
            padding: 0.8px 0;
            vertical-align: top;
            font-size: 9pt;
            line-height: 1.2;
        }
        .col-sub-num {
            width: 20px;
            padding-left: 5px !important;
        }
        .col-sub-label {
            width: 160px; /* 180px parent width - 20px sub num width = 160px */
        }
        .col-sub-colon {
            width: 12px;
            text-align: center;
        }
        .col-sub-val {
            word-break: break-word;
        }

        /* Helper Classes */
        .fw-bold {
            font-weight: bold;
        }

        /* Photo Boxes (3x4 aspect ratio, standard 30mm x 40mm) */
        .photo-box {
            width: 30mm;
            height: 40mm;
            border: 1px solid #000000;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background-color: #ffffff;
            overflow: hidden;
        }
        .photo-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .photo-placeholder {
            text-align: center;
            font-size: 9pt;
            line-height: 1.3;
        }
        .photo-placeholder span {
            display: block;
        }
        .photo-placeholder .photo-size {
            font-weight: bold;
            margin-top: 2px;
        }

        /* Print styles */
        @media print {
            @page {
                size: A4;
                margin: 8mm 12mm 8mm 12mm;
            }
            body {
                background-color: #ffffff;
                margin: 0;
                padding: 0;
                -webkit-print-color-adjust: exact;
            }
            .no-print {
                display: none !important;
            }
            .print-page {
                box-shadow: none !important;
                border: none !important;
                width: 100% !important;
                height: auto !important;
                padding: 0 !important;
                margin: 0 !important;
            }
        }
    </style>
</head>
<body>

    <!-- On-screen Navigation and Action Control Bar -->
    <div class="no-print control-bar">
        <a href="{{ route('siswa') }}" class="btn btn-back">
            <i class="fa-solid fa-arrow-left"></i> Kembali
        </a>
        <span class="control-title">Pratinjau Cetak Detail Siswa - {{ $siswa->nama }}</span>
        <button onclick="window.print()" class="btn btn-print">
            <i class="fa-solid fa-print"></i> Cetak Dokumen
        </button>
    </div>

    <!-- Printable Paper Area -->
    <div class="print-page">
        
        <!-- Top double bordered NIS & NISN boxes -->
        <div class="header-box">
            <div class="nis-box">NIS : {{ $siswa->nis ?? '' }}</div>
            <div class="nisn-box">NISN : {{ $siswa->nisn ?? '' }}</div>
        </div>

        <!-- Section A: Keterangan Tentang Diri Peserta Didik & Photo Box 1 -->
        <div class="section-row">
            <div class="section-left">
                <div class="section-title">A. KETERANGAN TENTANG DIRI PESERTA DIDIK</div>
                <table class="form-table">
                    <tr>
                        <td class="col-num">1.</td>
                        <td class="col-label">Nama Lengkap</td>
                        <td class="col-colon">:</td>
                        <td class="col-val">{{ strtoupper($siswa->nama) }}</td>
                    </tr>
                    <tr>
                        <td class="col-num">2.</td>
                        <td class="col-label">Jenis Kelamin</td>
                        <td class="col-colon">:</td>
                        <td class="col-val">{{ $siswa->jenis_kelamin }}</td>
                    </tr>
                    <tr>
                        <td class="col-num">3.</td>
                        <td class="col-label">Tempat Lahir</td>
                        <td class="col-colon">:</td>
                        <td class="col-val">{{ $siswa->tempat_lahir }}</td>
                    </tr>
                    <tr>
                        <td class="col-num">4.</td>
                        <td class="col-label">Tanggal Lahir</td>
                        <td class="col-colon">:</td>
                        <td class="col-val">{{ $siswa->tanggal_lahir ? \Carbon\Carbon::parse($siswa->tanggal_lahir)->format('m/d/Y') : '' }}</td>
                    </tr>
                    <tr>
                        <td class="col-num">5.</td>
                        <td class="col-label">Agama</td>
                        <td class="col-colon">:</td>
                        <td class="col-val">{{ $siswa->agama->nama_agama ?? '' }}</td>
                    </tr>
                    <tr>
                        <td class="col-num">6.</td>
                        <td class="col-label">Kewarganegaraan</td>
                        <td class="col-colon">:</td>
                        <td class="col-val">{{ $siswa->kewarganegaraan ?? '' }}</td>
                    </tr>
                    <tr>
                        <td class="col-num">7.</td>
                        <td class="col-label">Anak Keberapa</td>
                        <td class="col-colon">:</td>
                        <td class="col-val">{{ $siswa->ank_ke ?? '' }}</td>
                    </tr>
                    <tr>
                        <td class="col-num">8.</td>
                        <td class="col-label">Jml saudara kandung</td>
                        <td class="col-colon">:</td>
                        <td class="col-val">{{ $siswa->sdr ?? '' }}</td>
                    </tr>
                    <tr>
                        <td class="col-num">9.</td>
                        <td class="col-label">Jumlah saudara tiri</td>
                        <td class="col-colon">:</td>
                        <td class="col-val"></td>
                    </tr>
                </table>
            </div>
            <div class="section-right">
                <div class="photo-box">
                    @if ($siswa->foto_warna_santri)
                        <img src="{{ asset('gambar_berkas/berkas_siswa/' . $siswa->foto_warna_santri) }}" alt="Foto Siswa">
                    @else
                        <div class="photo-placeholder">
                            <span>Pas Foto</span>
                            <span class="photo-size">3x4</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Section B: Keterangan Tempat Tinggal -->
        <div class="section-row">
            <div class="section-left">
                <div class="section-title">B. KETERANGAN TEMPAT TINGGAL</div>
                <table class="form-table">
                    <tr>
                        <td class="col-num">10.</td>
                        <td class="col-label">Alamat</td>
                        <td class="col-colon">:</td>
                        <td class="col-val">
                            @php
                                $alamat_siswa = $siswa->alamat_lengkap;
                                if ($siswa->kecamatan) {
                                    $alamat_siswa .= ' Kec. ' . $siswa->kecamatan->name;
                                }
                                if ($siswa->kabupaten) {
                                    $alamat_siswa .= ' ' . $siswa->kabupaten->name;
                                }
                            @endphp
                            {{ $alamat_siswa }}
                        </td>
                    </tr>
                    <tr>
                        <td class="col-num">11.</td>
                        <td class="col-label">No. Telp./HP</td>
                        <td class="col-colon">:</td>
                        <td class="col-val"></td>
                    </tr>
                    <tr>
                        <td class="col-num">12.</td>
                        <td class="col-label">Tinggal dengan/di</td>
                        <td class="col-colon">:</td>
                        <td class="col-val">{{ $siswa->tinggal_di ?? '' }}</td>
                    </tr>
                </table>
            </div>
            <div class="section-right"></div>
        </div>

        <!-- Section C: Keterangan Pendidikan & Photo Box 2 -->
        <div class="section-row">
            <div class="section-left">
                <div class="section-title">C. KETERANGAN PENDIDIKAN</div>
                <table class="form-table">
                    <!-- 13 -->
                    <tr>
                        <td class="col-num">13.</td>
                        <td class="col-label fw-bold" colspan="3">Pendidikan Sebelumnya</td>
                    </tr>
                    <tr>
                        <td class="col-num"></td>
                        <td colspan="3">
                            <table class="sub-form-table">
                                <tr>
                                    <td class="col-sub-num">a.</td>
                                    <td class="col-sub-label">Tamatan dari</td>
                                    <td class="col-sub-colon">:</td>
                                    <td class="col-sub-val">{{ $siswa->asal_sekolah ?? '' }}</td>
                                </tr>
                                <tr>
                                    <td class="col-sub-num">b.</td>
                                    <td class="col-sub-label">Nomor Ijazah</td>
                                    <td class="col-sub-colon">:</td>
                                    <td class="col-sub-val">{{ $siswa->nomor_ijazah ?? '' }}</td>
                                </tr>
                                <tr>
                                    <td class="col-sub-num">c.</td>
                                    <td class="col-sub-label">Nomor SHUN</td>
                                    <td class="col-sub-colon">:</td>
                                    <td class="col-sub-val"></td>
                                </tr>
                                <tr>
                                    <td class="col-sub-num">d.</td>
                                    <td class="col-sub-label">Lama Belajar</td>
                                    <td class="col-sub-colon">:</td>
                                    <td class="col-sub-val">{{ $siswa->asal_sekolah ? '3 tahun' : '' }}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <!-- 14 -->
                    <tr>
                        <td class="col-num">14.</td>
                        <td class="col-label fw-bold" colspan="3">Pindah</td>
                    </tr>
                    <tr>
                        <td class="col-num"></td>
                        <td colspan="3">
                            <table class="sub-form-table">
                                <tr>
                                    <td class="col-sub-num">a.</td>
                                    <td class="col-sub-label">Ke sekolah</td>
                                    <td class="col-sub-colon">:</td>
                                    <td class="col-sub-val"></td>
                                </tr>
                                <tr>
                                    <td class="col-sub-num">b.</td>
                                    <td class="col-sub-label">Alasan</td>
                                    <td class="col-sub-colon">:</td>
                                    <td class="col-sub-val"></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <!-- 15 -->
                    <tr>
                        <td class="col-num">15.</td>
                        <td class="col-label fw-bold" colspan="3">Diterima di sekolah ini</td>
                    </tr>
                    <tr>
                        <td class="col-num"></td>
                        <td colspan="3">
                            <table class="sub-form-table">
                                <tr>
                                    <td class="col-sub-num">a.</td>
                                    <td class="col-sub-label">Kelas</td>
                                    <td class="col-sub-colon">:</td>
                                    <td class="col-sub-val">
                                        @php
                                            $kelas_nama = $placement && $placement->rombel && $placement->rombel->kelas ? $placement->rombel->kelas->nama_kelas : '';
                                            $kelas_map = [
                                                '10' => 'X (sepuluh)',
                                                'X' => 'X (sepuluh)',
                                                '11' => 'XI (sebelas)',
                                                'XI' => 'XI (sebelas)',
                                                '12' => 'XII (dua belas)',
                                                'XII' => 'XII (dua belas)',
                                            ];
                                            $kelas_display = isset($kelas_map[$kelas_nama]) ? $kelas_map[$kelas_nama] : $kelas_nama;
                                        @endphp
                                        {{ $kelas_display }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="col-sub-num">b.</td>
                                    <td class="col-sub-label">Kompetensi Keahlian</td>
                                    <td class="col-sub-colon">:</td>
                                    <td class="col-sub-val">{{ $siswa->jurusan->program_keahlian ?? '' }}</td>
                                </tr>
                                <tr>
                                    <td class="col-sub-num">c.</td>
                                    <td class="col-sub-label">Tanggal</td>
                                    <td class="col-sub-colon">:</td>
                                    <td class="col-sub-val">{{ $siswa->tgl_daftar ? \Carbon\Carbon::parse($siswa->tgl_daftar)->locale('id')->translatedFormat('d F Y') : '' }}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="section-right">
                <div class="photo-box">
                    @if ($siswa->foto_warna_santri)
                        <img src="{{ asset('gambar_berkas/berkas_siswa/' . $siswa->foto_warna_santri) }}" alt="Foto Siswa">
                    @else
                        <div class="photo-placeholder">
                            <span>Pas Foto</span>
                            <span class="photo-size">3x4</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Section D: Keterangan Tentang Ayah Kandung -->
        <div class="section-row">
            <div class="section-left">
                <div class="section-title">D. KETERANGAN TENTANG AYAH KANDUNG</div>
                <table class="form-table">
                    <tr>
                        <td class="col-num">16.</td>
                        <td class="col-label">Nama</td>
                        <td class="col-colon">:</td>
                        <td class="col-val">{{ $siswa->nm_a ?? '' }}</td>
                    </tr>
                    <tr>
                        <td class="col-num">17.</td>
                        <td class="col-label">Tempat dan tgl lahir</td>
                        <td class="col-colon">:</td>
                        <td class="col-val">
                            @php
                                $tempat_tgl_a = '';
                                if ($siswa->tmpt_lahir_a) {
                                    $tempat_tgl_a .= $siswa->tmpt_lahir_a;
                                }
                                if ($siswa->tgl_lahir_a) {
                                    $date_formatted_a = '';
                                    try {
                                        if (strlen($siswa->tgl_lahir_a) > 4) {
                                            $date_formatted_a = \Carbon\Carbon::parse($siswa->tgl_lahir_a)->locale('id')->translatedFormat('d F Y');
                                        } else {
                                            $date_formatted_a = $siswa->tgl_lahir_a;
                                        }
                                    } catch (\Exception $e) {
                                        $date_formatted_a = $siswa->tgl_lahir_a;
                                    }
                                    if ($tempat_tgl_a) {
                                        $tempat_tgl_a .= ', ' . $date_formatted_a;
                                    } else {
                                        $tempat_tgl_a = $date_formatted_a;
                                    }
                                }
                            @endphp
                            {{ $tempat_tgl_a }}
                        </td>
                    </tr>
                    <tr>
                        <td class="col-num">18.</td>
                        <td class="col-label">Agama</td>
                        <td class="col-colon">:</td>
                        <td class="col-val">{{ $siswa->agamaAyah->nama_agama ?? '' }}</td>
                    </tr>
                    <tr>
                        <td class="col-num">19.</td>
                        <td class="col-label">Pekerjaan</td>
                        <td class="col-colon">:</td>
                        <td class="col-val">{{ $siswa->pekerjaanAyah->nama_pekerjaan ?? '' }}</td>
                    </tr>
                    <tr>
                        <td class="col-num">20.</td>
                        <td class="col-label">Alamat</td>
                        <td class="col-colon">:</td>
                        <td class="col-val">{{ $alamat_siswa }}</td>
                    </tr>
                </table>
            </div>
            <div class="section-right"></div>
        </div>

        <!-- Section E: Keterangan Tentang Ibu Kandung -->
        <div class="section-row">
            <div class="section-left">
                <div class="section-title">E. KETERANGAN TENTANG IBU KANDUNG</div>
                <table class="form-table">
                    <tr>
                        <td class="col-num">21.</td>
                        <td class="col-label">Nama</td>
                        <td class="col-colon">:</td>
                        <td class="col-val">{{ $siswa->nm_i ?? '' }}</td>
                    </tr>
                    <tr>
                        <td class="col-num">22.</td>
                        <td class="col-label">Tempat dan tgl lahir</td>
                        <td class="col-colon">:</td>
                        <td class="col-val">
                            @php
                                $tempat_tgl_i = '';
                                if ($siswa->tmpt_lahir_i) {
                                    $tempat_tgl_i .= $siswa->tmpt_lahir_i;
                                }
                                if ($siswa->tgl_lahir_i) {
                                    $date_formatted_i = '';
                                    try {
                                        if (strlen($siswa->tgl_lahir_i) > 4) {
                                            $date_formatted_i = \Carbon\Carbon::parse($siswa->tgl_lahir_i)->locale('id')->translatedFormat('d F Y');
                                        } else {
                                            $date_formatted_i = $siswa->tgl_lahir_i;
                                        }
                                    } catch (\Exception $e) {
                                        $date_formatted_i = $siswa->tgl_lahir_i;
                                    }
                                    if ($tempat_tgl_i) {
                                        $tempat_tgl_i .= ', ' . $date_formatted_i;
                                    } else {
                                        $tempat_tgl_i = $date_formatted_i;
                                    }
                                }
                            @endphp
                            {{ $tempat_tgl_i }}
                        </td>
                    </tr>
                    <tr>
                        <td class="col-num">23.</td>
                        <td class="col-label">Agama</td>
                        <td class="col-colon">:</td>
                        <td class="col-val">{{ $siswa->agamaIbu->nama_agama ?? '' }}</td>
                    </tr>
                    <tr>
                        <td class="col-num">24.</td>
                        <td class="col-label">Pekerjaan</td>
                        <td class="col-colon">:</td>
                        <td class="col-val">{{ $siswa->pekerjaanIbu->nama_pekerjaan ?? '' }}</td>
                    </tr>
                    <tr>
                        <td class="col-num">25.</td>
                        <td class="col-label">Alamat</td>
                        <td class="col-colon">:</td>
                        <td class="col-val">{{ $alamat_siswa }}</td>
                    </tr>
                </table>
            </div>
            <div class="section-right"></div>
        </div>

        <!-- Section F: Keterangan Tentang Wali & Photo Box 3 -->
        <div class="section-row">
            <div class="section-left">
                <div class="section-title">F. KETERANGAN TENTANG WALI</div>
                <table class="form-table">
                    <tr>
                        <td class="col-num">26.</td>
                        <td class="col-label">Nama</td>
                        <td class="col-colon">:</td>
                        <td class="col-val">{{ $siswa->nm_w ?? '' }}</td>
                    </tr>
                    <tr>
                        <td class="col-num">27.</td>
                        <td class="col-label">Tempat dan tgl lahir</td>
                        <td class="col-colon">:</td>
                        <td class="col-val">
                            @php
                                $tempat_tgl_w = '';
                                if ($siswa->tmpt_lahir_w) {
                                    $tempat_tgl_w .= $siswa->tmpt_lahir_w;
                                }
                                if ($siswa->tgl_lahir_w) {
                                    $date_formatted_w = '';
                                    try {
                                        if (strlen($siswa->tgl_lahir_w) > 4) {
                                            $date_formatted_w = \Carbon\Carbon::parse($siswa->tgl_lahir_w)->locale('id')->translatedFormat('d F Y');
                                        } else {
                                            $date_formatted_w = $siswa->tgl_lahir_w;
                                        }
                                    } catch (\Exception $e) {
                                        $date_formatted_w = $siswa->tgl_lahir_w;
                                    }
                                    if ($tempat_tgl_w) {
                                        $tempat_tgl_w .= ', ' . $date_formatted_w;
                                    } else {
                                        $tempat_tgl_w = $date_formatted_w;
                                    }
                                }
                            @endphp
                            {{ $tempat_tgl_w }}
                        </td>
                    </tr>
                    <tr>
                        <td class="col-num">28.</td>
                        <td class="col-label">Agama</td>
                        <td class="col-colon">:</td>
                        <td class="col-val">{{ $siswa->agamaWali->nama_agama ?? '' }}</td>
                    </tr>
                    <tr>
                        <td class="col-num">29.</td>
                        <td class="col-label">Pekerjaan</td>
                        <td class="col-colon">:</td>
                        <td class="col-val">{{ $siswa->pekerjaanWali->nama_pekerjaan ?? '' }}</td>
                    </tr>
                    <tr>
                        <td class="col-num">30.</td>
                        <td class="col-label">Alamat</td>
                        <td class="col-colon">:</td>
                        <td class="col-val">
                            @php
                                $alamat_wali = $siswa->almt_w;
                                if ($wali_address_details['kec']) {
                                    $alamat_wali .= ' Kec. ' . $wali_address_details['kec'];
                                }
                                if ($wali_address_details['kab']) {
                                    $alamat_wali .= ' ' . $wali_address_details['kab'];
                                }
                            @endphp
                            {{ $alamat_wali }}
                        </td>
                    </tr>
                </table>
            </div>
            <div class="section-right">
                <div class="photo-box">
                    @if ($siswa->foto_wali_santri_warna)
                        <img src="{{ asset('gambar_berkas/berkas_siswa/' . $siswa->foto_wali_santri_warna) }}" alt="Foto Wali">
                    @else
                        <div class="photo-placeholder">
                            <span>Pas Foto</span>
                            <span class="photo-size">3x4</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>

    </div>

</body>
</html>
