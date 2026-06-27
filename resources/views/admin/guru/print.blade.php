<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Profil Guru - {{ $guru->nama_lengkap }}</title>
    <!-- FontAwesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* General styling for screen preview */
        * {
            box-sizing: border-box;
        }

        body {
            background-color: #f1f3f5;
            margin: 0;
            padding: 20px 10px;
            font-family: Arial, sans-serif;
            color: #333;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        /* Navigation Control Bar */
        .control-bar {
            width: 210mm;
            background: #ffffff;
            border-radius: 10px;
            padding: 12px 24px;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            border: 1px solid rgba(0, 0, 0, 0.06);
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
            text-decoration: none;
            transition: all 0.2s ease;
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
            box-shadow: 0 4px 12px rgba(59, 125, 221, 0.3);
        }

        .control-title {
            font-weight: bold;
            color: #212529;
            font-size: 15px;
        }

        /* A4 Page Layout Container */
        .print-page {
            background-color: #ffffff;
            width: 210mm;
            height: 297mm;
            padding: 15mm 15mm;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            position: relative;
        }

        .page-break {
            page-break-after: always;
        }

        /* Kop Surat (Header) */
        .kop-surat {
            font-family: 'Times New Roman', Times, serif;
            margin-bottom: 15px;
            width: 100%;
        }

        .kop-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .kop-logo-container {
            width: 80px;
            display: flex;
            justify-content: flex-start;
            align-items: center;
        }

        .kop-logo {
            width: 80px;
            height: auto;
            object-fit: contain;
        }

        .kop-text {
            text-align: center;
            flex-grow: 1;
            padding: 0 10px;
        }

        .kop-right-spacer {
            width: 80px;
        }

        .kop-yayasan {
            font-size: 14pt;
            font-weight: bold;
            margin: 0;
            line-height: 1.2;
        }

        .kop-smk {
            font-size: 18pt;
            font-weight: bold;
            margin: 2px 0 4px 0;
            line-height: 1.2;
        }

        .kop-nss {
            font-size: 9.5pt;
            font-weight: bold;
            margin: 2px 0;
        }

        .kop-kompetensi {
            font-size: 8.5pt;
            font-weight: bold;
            margin: 2px 0;
        }

        .kop-address {
            border: 1px solid #000000;
            padding: 3px 6px;
            text-align: center;
            font-size: 7.5pt;
            font-weight: normal;
            margin-top: 8px;
            line-height: 1.3;
        }

        .kop-address .underline {
            text-decoration: underline;
        }

        /* Title & Metadata */
        .doc-title {
            text-align: center;
            font-size: 12pt;
            font-weight: bold;
            text-transform: uppercase;
            text-decoration: underline;
            margin-top: 10px;
            margin-bottom: 5px;
        }

        .doc-meta {
            text-align: center;
            font-size: 8.5pt;
            margin-bottom: 15px;
        }

        /* Tables styling */
        .print-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        .print-table th,
        .print-table td {
            border: 1px solid #999;
            padding: 4px 8px;
            font-size: 8.5pt;
            vertical-align: middle;
            text-align: left;
        }

        .print-table th {
            background-color: #f8f9fa;
            font-weight: bold;
            text-align: center;
        }

        /* Column widths for Profile Table */
        .col-attr {
            width: 25%;
            font-weight: bold;
            font-style: italic;
        }

        .col-val {
            width: 45%;
        }

        .col-info {
            width: 30%;
            color: #555;
        }

        /* Column widths for Pembelajaran Table */
        .col-no {
            width: 6%;
            text-align: center;
        }

        .col-rombel {
            width: 47%;
        }

        .col-mapel {
            width: 37%;
        }

        .col-jam {
            width: 10%;
            text-align: center;
        }

        /* Signature block & QR layout */
        .footer-section {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-top: 25px;
            padding-right: 20px;
            padding-left: 20px;
        }

        .qr-container {
            width: 120px;
            text-align: center;
        }

        .qr-box {
            border: 1px solid #ccc;
            padding: 5px;
            background: #fff;
            display: inline-block;
        }

        .qr-box img {
            width: 110px;
            height: 110px;
            display: block;
        }

        .sig-container {
            width: 250px;
            text-align: left;
            font-size: 9.5pt;
        }

        .sig-date {
            margin-bottom: 5px;
        }

        .sig-title {
            margin-bottom: 60px;
        }

        .sig-name {
            font-weight: bold;
            text-decoration: underline;
            text-transform: uppercase;
        }

        .sig-niy {
            font-size: 9pt;
            color: #111;
        }

        /* Footnotes (Catatan) */
        .notes-section {
            margin-top: 30px;
            font-size: 8.5pt;
            line-height: 1.4;
            color: #222;
        }

        .notes-section h4 {
            margin: 0 0 5px 0;
            font-weight: bold;
        }

        .notes-section ol {
            margin: 0;
            padding-left: 15px;
        }

        .notes-section li {
            margin-bottom: 4px;
            text-align: justify;
        }

        /* Print Override styles */
        @media print {
            @page {
                size: A4 portrait;
                margin: 12mm 15mm 12mm 15mm;
            }

            body {
                background-color: #ffffff;
                margin: 0;
                padding: 0;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
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

            .page-break {
                page-break-after: always;
                height: 0;
                margin: 0;
                padding: 0;
                border: none;
            }

            .print-table th,
            .print-table td {
                border: 1px solid #000000 !important;
            }
        }
    </style>
</head>

<body>

    <!-- On-screen Navigation and Action Control Bar -->
    <div class="no-print control-bar">
        <a href="{{ route('guru') }}" class="btn btn-back">
            <i class="fa-solid fa-arrow-left"></i> Kembali
        </a>
        <span class="control-title">Pratinjau Cetak Profil Guru - {{ $guru->nama_lengkap }}</span>
        <button onclick="window.print()" class="btn btn-print">
            <i class="fa-solid fa-print"></i> Cetak Dokumen
        </button>
    </div>

    <!-- PAGE 1: Profil Guru -->
    <div class="print-page page-break">
        <!-- Kop Surat -->
        <div class="kop-surat">
            <div class="kop-header">
                <div class="kop-logo-container">
                    <img src="{{ asset('asset_portal/logo.webp') }}" alt="Logo SMK" class="kop-logo">
                </div>
                <div class="kop-text">
                    <div class="kop-yayasan">YAYASAN NURUL ABROR AL-ROBBANIYIN</div>
                    <div class="kop-smk">SMK NURUL ABROR AL-ROBBANIYIN</div>
                    <div class="kop-nss">NSS : 402052521043 &nbsp;&nbsp;&nbsp;&nbsp; NPSN : 69852107
                        &nbsp;&nbsp;&nbsp;&nbsp; Terakreditasi : B</div>
                    <div class="kop-kompetensi">Kompetensi Keahlian : 833 - Akuntansi dan Keuangan Lembaga
                        &nbsp;&nbsp;&nbsp;&nbsp; 411 - Rekayasa Perangkat Lunak</div>
                </div>
                <div class="kop-right-spacer"></div>
            </div>
            <div class="kop-address">
                Jl. KH. Agus Salim No. 165 Alasbuluh Wongsorejo Banyuwangi 68453 HP. 0813 8002 6064 e-mail : <span
                    class="underline">smkrobbany@gmail.com</span>, Website : <span
                    class="underline">http://www.smknaa.com</span>
            </div>
        </div>

        <!-- Title -->
        <div class="doc-title">Profil Guru</div>
        <div class="doc-meta">
            Data berikut dikeluarkan melalui aplikasi SIANTA pada tanggal
            {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }} Pukul: {{ \Carbon\Carbon::now()->format('H:i:s') }}
        </div>

        <!-- Attributes Table -->
        <table class="print-table">
            <thead>
                <tr>
                    <th style="width: 25%;">Atribut</th>
                    <th style="width: 45%;">Isian</th>
                    <th style="width: 30%;">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="col-attr">Tanggal Perubahan</td>
                    <td class="col-val">{{ $guru->updated_at ? $guru->updated_at->format('Y-m-d H:i:s') : '-' }}</td>
                    <td class="col-info">Diperoleh dari tabel Guru & Tendik</td>
                </tr>
                <tr>
                    <td class="col-attr">Nomor Surat Tugas</td>
                    <td class="col-val">{{ $guru->no_surat_tugas ?? '-' }}</td>
                    <td class="col-info" rowspan="3">Diperoleh dari tabel penugasan</td>
                </tr>
                <tr>
                    <td class="col-attr">Tanggal Surat Tugas</td>
                    <td class="col-val">{{ $guru->tgl_surat_tugas ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="col-attr">Tahun Ajaran</td>
                    <td class="col-val">{{ $tahunAktif->tahun_ajaran ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="col-attr">Sekolah Induk</td>
                    <td class="col-val">{{ $guru->sekolah_induk == 1 ? 'Ya' : 'Tidak' }}</td>
                    <td class="col-info"></td>
                </tr>
                <tr>
                    <td class="col-attr">Nama</td>
                    <td class="col-val">{{ $guru->nama_lengkap }}</td>
                    <td class="col-info"></td>
                </tr>
                <tr>
                    <td class="col-attr">NIK</td>
                    <td class="col-val">{{ $guru->nik ?? '-' }}</td>
                    <td class="col-info"></td>
                </tr>
                <tr>
                    <td class="col-attr">Jenis Kelamin</td>
                    <td class="col-val">{{ $guru->jenis_kelamin == 'L' ? 'Laki-Laki' : 'Perempuan' }}</td>
                    <td class="col-info"></td>
                </tr>
                <tr>
                    <td class="col-attr">TTL</td>
                    <td class="col-val">
                        {{ strtoupper($guru->tempat_lahir ?? '-') }},
                        {{ $guru->tanggal_lahir ? \Carbon\Carbon::parse($guru->tanggal_lahir)->translatedFormat('d F Y') : '-' }}
                    </td>
                    <td class="col-info">Tempat dan tanggal lahir</td>
                </tr>
                <tr>
                    <td class="col-attr">Nama Ibu Kandung</td>
                    <td class="col-val">{{ strtoupper($guru->keluarga->nama_ibu ?? '-') }}</td>
                    <td class="col-info"></td>
                </tr>
                <tr>
                    <td class="col-attr">Alamat</td>
                    <td class="col-val">
                        @php
                            $alamat = $guru->alamat;
                            if ($guru->desaDetail) {
                                $alamat .= ' Desa/Kel. ' . $guru->desaDetail->name;
                            }
                            if ($guru->kecamatan) {
                                $alamat .= ' Kec. ' . $guru->kecamatan->name;
                            }
                            if ($guru->kabupaten) {
                                $alamat .= ' ' . $guru->kabupaten->name;
                            }
                        @endphp
                        {{ $alamat }}
                    </td>
                    <td class="col-info"></td>
                </tr>
                <tr>
                    <td class="col-attr">Agama</td>
                    <td class="col-val">{{ $guru->agama->nama_agama ?? '-' }}</td>
                    <td class="col-info"></td>
                </tr>
                <tr>
                    <td class="col-attr">Status Perkawinan</td>
                    <td class="col-val">{{ $guru->status_perkawinan ?? '-' }}</td>
                    <td class="col-info"></td>
                </tr>
                <tr>
                    <td class="col-attr">Nama {{ $guru->jenis_kelamin == 'L' ? 'Istri' : 'Suami' }}</td>
                    <td class="col-val">{{ $guru->keluarga->nama_pasangan ?? '-' }}</td>
                    <td class="col-info"></td>
                </tr>
                <tr>
                    <td class="col-attr">Pekerjaan {{ $guru->jenis_kelamin == 'L' ? 'Istri' : 'Suami' }}</td>
                    <td class="col-val">
                        {{ $guru->keluarga->pekerjaanPasangan->nama_pekerjaan ?? ($guru->keluarga->pekerjaan_pasangan ?? '-') }}
                    </td>
                    <td class="col-info"></td>
                </tr>
                <tr>
                    <td class="col-attr">NPWP</td>
                    <td class="col-val">{{ $guru->npwp ?? '-' }}</td>
                    <td class="col-info"></td>
                </tr>
                <tr>
                    <td class="col-attr">Nama Wajib Pajak</td>
                    <td class="col-val">{{ $guru->nama_wajib_pajak ?? '-' }}</td>
                    <td class="col-info"></td>
                </tr>
                <tr>
                    <td class="col-attr">Jenis GTK</td>
                    <td class="col-val">{{ $guru->jenis_gtk ?? '-' }}</td>
                    <td class="col-info"></td>
                </tr>
                <tr>
                    <td class="col-attr">Jabatan GTK</td>
                    <td class="col-val">{{ $guru->jabatan_gtk ?? '-' }}</td>
                    <td class="col-info"></td>
                </tr>
                <tr>
                    <td class="col-attr">NUPTK</td>
                    <td class="col-val">{{ $guru->nuptk ?? '-' }}</td>
                    <td class="col-info"></td>
                </tr>
                <tr>
                    <td class="col-attr">Status Kepegawaian</td>
                    <td class="col-val">{{ $guru->status_kepegawaian ?? '-' }}</td>
                    <td class="col-info"></td>
                </tr>
                <tr>
                    <td class="col-attr">NIY/NIGK</td>
                    <td class="col-val">{{ $guru->niy ?? '-' }}</td>
                    <td class="col-info"></td>
                </tr>
                <tr>
                    <td class="col-attr">SK Pengangkatan</td>
                    <td class="col-val">{{ $guru->sk_pengangkatan ?? '-' }}</td>
                    <td class="col-info"></td>
                </tr>
                <tr>
                    <td class="col-attr">TMT Pengangkatan</td>
                    <td class="col-val">{{ $guru->tmt_pengangkatan ?? '-' }}</td>
                    <td class="col-info"></td>
                </tr>
                <tr>
                    <td class="col-attr">Lembaga Pengangkat</td>
                    <td class="col-val">{{ $guru->lembaga_pengangkat ?? '-' }}</td>
                    <td class="col-info"></td>
                </tr>
                <tr>
                    <td class="col-attr">Kartu {{ $guru->jenis_kelamin == 'L' ? 'Istri' : 'Suami' }}</td>
                    <td class="col-val">{{ $guru->keluarga->kartu_pasangan ?? '-' }}</td>
                    <td class="col-info"></td>
                </tr>
                <tr>
                    <td class="col-attr">Pendidikan Terakhir</td>
                    <td class="col-val">{{ $pendidikanTerakhir }}</td>
                    <td class="col-info">Diperoleh dari tabel riwayat pendidikan formal</td>
                </tr>
                <tr>
                    <td class="col-attr">Status Kuliah</td>
                    <td class="col-val">{{ $guru->status_kuliah == 1 ? 'Ya' : 'Tidak' }}</td>
                    <td class="col-info"></td>
                </tr>
                <tr>
                    <td class="col-attr">Email</td>
                    <td class="col-val">{{ $guru->email ?? '-' }}</td>
                    <td class="col-info">Diperoleh dari akun pengguna</td>
                </tr>
                <tr>
                    <td class="col-attr">Tahun Pensiun</td>
                    <td class="col-val">{{ $guru->tahun_pensiun ?? '-' }}</td>
                    <td class="col-info"></td>
                </tr>
                <tr>
                    <td class="col-attr">Jumlah Total Peserta Didik</td>
                    <td class="col-val">{{ $totalSiswa }}</td>
                    <td class="col-info">Diperoleh dari tabel anggota rombel</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- PAGE 2: Lampiran Rekapitulasi Pembelajaran -->
    <div class="print-page">
        <!-- Title Header -->
        <div style="font-size: 11pt; font-weight: bold; margin-bottom: 12px; margin-top: 10px;">
            Lampiran Rekapitulasi Pembelajaran <u>{{ strtoupper($guru->nama_lengkap) }}</u>:
        </div>

        <!-- Rekapitulasi Table -->
        <table class="print-table">
            <thead>
                <tr>
                    <th class="col-no">No</th>
                    <th class="col-rombel">Informasi Rombel</th>
                    <th class="col-mapel">Mata Pelajaran</th>
                    <th class="col-jam">Jumlah Jam/Minggu</th>
                </tr>
            </thead>
            <tbody>
                @forelse($activePembelajaran as $p)
                    <tr>
                        <td class="col-no">{{ $loop->iteration }}</td>
                        <td class="col-rombel">
                            Jenis Rombel: Kelas<br>
                            Tingkat: Kelas {{ $p->rombel->kelas->nama_kelas ?? '-' }}<br>
                            Nama: {{ $p->rombel->nama_rombel ?? '-' }}<br>
                            Kurikulum: SMK Merdeka {{ $p->rombel->jurusan->kons_keahlian ?? '' }}<br>
                            Jumlah Anggota Rombel:
                            {{ $p->rombel->penempatanRombel()->where('status_aktif', 1)->count() }}
                        </td>
                        <td class="col-mapel">
                            {{ $p->mataPelajaran->kode_mapel ?? '' }} - {{ $p->mataPelajaran->nama_mapel ?? '' }}<br>
                            Kelompok: {{ $p->mataPelajaran->kelompok ?? 'Kejuruan' }}
                        </td>
                        <td class="col-jam">{{ $p->jam_mengajar }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="text-align: center; font-style: italic; padding: 10px;">Tidak ada
                            data pembelajaran aktif.</td>
                    </tr>
                @endforelse
                <tr style="font-weight: bold;">
                    <td colspan="3" style="text-align: center; text-transform: uppercase;">Jumlah Total Jam
                        Mengajar</td>
                    <td class="col-jam">{{ $totalJamMengajar }}</td>
                </tr>
            </tbody>
        </table>

        <!-- Signature and QR Section -->
        <div class="footer-section">
            <!-- QR Code -->
            <div class="qr-container">
                <div class="qr-box">
                    @php
                        $qrData = urlencode(route('guru.public-profile', $guru));
                    @endphp
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=110&data={{ $qrData }}"
                        alt="Tanda Tangan Elektronik QR">
                </div>
            </div>

            <!-- Signature -->
            <div class="sig-container">
                <div class="sig-date">Kab. Banyuwangi, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</div>
                <div class="sig-title">Menyetujui,</div>
                <div class="sig-name">
                    @if ($kepalaSekolah)
                        {{ $kepalaSekolah->nama_lengkap }}
                    @else
                        Anda Belum Mengaktifkan Akun Kepala Sekolah
                    @endif
                </div>
                <div class="sig-niy">
                    NIY/NIGK:
                    @if ($kepalaSekolah)
                        {{ $kepalaSekolah->niy ?? '-' }}
                    @else
                        33302330138066
                    @endif
                </div>
            </div>
        </div>

        <!-- Notes (Catatan) -->
        <div class="notes-section">
            <h4>Catatan:</h4>
            <ol>
                <li>Data yang diinput pada formulir ini bersifat rahasia dan hanya digunakan untuk kepentingan
                    administrasi melalui aplikasi SIANTA.
                </li>
                <li>Pastikan seluruh data yang diisikan benar, lengkap, dan sesuai dengan dokumen yang dimiliki.</li>
                <li>Data dapat diverifikasi dan divalidasi oleh administrator sebelum digunakan dalam proses
                    administrasi.</li>
                <li>Pengguna bertanggung jawab atas kebenaran data yang diinput.</li>
                <li>Dilarang menyebarluaskan data pribadi tanpa izin dari pemilik data sesuai dengan ketentuan peraturan
                    perundang-undangan yang berlaku.</li>
            </ol>
        </div>
    </div>

</body>

</html>
