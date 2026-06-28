@php
function romanToArabic($string) {
    $romans = [
        '/^XII\b/i' => '12',
        '/^XI\b/i' => '11',
        '/^X\b/i' => '10',
        '/^IX\b/i' => '9',
        '/^VIII\b/i' => '8',
        '/^VII\b/i' => '7',
        '/^VI\b/i' => '6',
        '/^V\b/i' => '5',
        '/^IV\b/i' => '4',
        '/^III\b/i' => '3',
        '/^II\b/i' => '2',
        '/^I\b/i' => '1',
    ];
    
    foreach ($romans as $pattern => $replace) {
        if (preg_match($pattern, $string)) {
            return preg_replace($pattern, $replace, $string);
        }
    }
    return $string;
}

$kelasSemesterFormatted = romanToArabic($rombel->nama_rombel) . ' / ' . ($periode ? $periode->semester : '-');
$jurusanFormatted = $rombel->jurusan ? $rombel->jurusan->program_keahlian : 'Umum';
$tahunAjaranFormatted = $tahun ? $tahun->tahun_ajaran : '-';
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Hadir - {{ $rombel->nama_rombel }}</title>
    <style>
        * {
            box-sizing: border-box;
        }
        body {
            font-family: Arial, Helvetica, sans-serif;
            margin: 0;
            padding: 0;
            color: #000;
            background-color: #fff;
            font-size: 8.5pt;
        }

        /* Landscape A4 Print Setting */
        @page {
            size: A4 landscape;
            margin: 8mm 10mm;
        }

        .no-print-bar {
            background-color: #f8f9fa;
            border-bottom: 1px solid #dee2e6;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .btn {
            display: inline-flex;
            align-items: center;
            padding: 6px 14px;
            font-size: 9pt;
            font-weight: bold;
            text-decoration: none;
            border-radius: 4px;
            cursor: pointer;
            border: 1px solid transparent;
            font-family: Arial, sans-serif;
        }
        .btn-secondary {
            background-color: #6c757d;
            color: #fff;
            border-color: #6c757d;
        }
        .btn-success {
            background-color: #198754;
            color: #fff;
            border-color: #198754;
        }

        .print-container {
            padding: 10px;
            width: 100%;
        }

        /* Header Style */
        .header-title {
            text-align: center;
            font-weight: bold;
            font-size: 11pt;
            text-transform: uppercase;
            margin-bottom: 12px;
            letter-spacing: 0.5px;
        }

        /* Meta Table Style */
        .meta-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 8px;
        }
        .meta-table td {
            border: none !important;
            padding: 2px 0;
            vertical-align: top;
            font-size: 8.5pt;
        }

        /* Main Attendance Table Style */
        table.attendance-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 8pt;
        }
        table.attendance-table th, table.attendance-table td {
            border: 1px solid #000000;
            padding: 3px 4px;
            vertical-align: middle;
        }
        table.attendance-table th {
            font-weight: bold;
            text-align: center;
            background-color: #ffffff;
        }
        table.attendance-table td {
            height: 25px;
        }
        
        .text-center {
            text-align: center;
        }
        .text-left {
            text-align: left;
        }

        /* Footer Style */
        .print-footer {
            margin-top: 10px;
            font-size: 8pt;
        }
        .footer-note {
            font-weight: bold;
            font-style: italic;
        }

        /* Print Override */
        @media print {
            .no-print-bar {
                display: none !important;
            }
            body {
                margin: 0;
                padding: 0;
                background-color: #fff;
            }
            .print-container {
                padding: 0;
            }
        }
    </style>
</head>
<body>

    <!-- Top Navigation for Browser View -->
    <div class="no-print-bar">
        <a href="{{ route('rombel.show-detail', $rombel->id) }}" class="btn btn-secondary">&larr; Kembali ke Detail Rombel</a>
        <div>
            <strong>Pratinjau Cetak Daftar Hadir Rombel ({{ $rombel->nama_rombel }})</strong>
        </div>
        <button onclick="window.print()" class="btn btn-success">Cetak / Simpan PDF</button>
    </div>

    <div class="print-container">
        <!-- Header -->
        <div class="header-title">DAFTAR HADIR PESERTA DIDIK SMK NURUL ABROR AL-ROBBANIYIN</div>

        <!-- Metadata Section -->
        <table class="meta-table">
            <tr>
                <td style="width: 15%; font-weight: bold;">Konsentrasi Keahlian</td>
                <td style="width: 1.5%; font-weight: bold;">:</td>
                <td style="width: 38.5%; font-weight: bold;">{{ $jurusanFormatted }}</td>
                <td style="width: 12%; font-weight: bold;">Bulan</td>
                <td style="width: 1.5%; font-weight: bold;">:</td>
                <td style="width: 31.5%;">......................................................................</td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Tahun Pelajaran</td>
                <td style="font-weight: bold;">:</td>
                <td style="font-weight: bold;">{{ $tahunAjaranFormatted }}</td>
                <td style="font-weight: bold;">Mata Pelajaran</td>
                <td style="font-weight: bold;">:</td>
                <td style="border: none;">......................................................................</td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Kelas / Semester</td>
                <td style="font-weight: bold;">:</td>
                <td style="font-weight: bold;">{{ $kelasSemesterFormatted }}</td>
                <td style="font-weight: bold;">Guru Mapel</td>
                <td style="font-weight: bold;">:</td>
                <td style="border: none;">......................................................................</td>
            </tr>
        </table>

        <!-- Attendance Grid Table -->
        <table class="attendance-table">
            <thead>
                <tr>
                    <th rowspan="3" style="width: 3.5%;">No</th>
                    <th rowspan="3" style="width: 26%;">Nama Peserta Didik</th>
                    <th rowspan="3" style="width: 10%;">NIS</th>
                    <th rowspan="3" style="width: 10.5%;">NISN</th>
                    <th colspan="10">Tanggal / Pertemuan</th>
                    <th colspan="3">Jumlah</th>
                </tr>
                <tr>
                    @for ($col = 1; $col <= 10; $col++)
                    <th style="width: 3.25%;">{{ $col }}</th>
                    @endfor
                    <th colspan="3" rowspan="1">Tidak Hadir</th>
                </tr>
                <tr>
                    @for ($col = 1; $col <= 10; $col++)
                        <th rowspan="1" style="height: 12px; padding: 1px;"></th>
                    @endfor
                    <th style="width: 2.75%;">S</th>
                    <th style="width: 2.75%;">I</th>
                    <th style="width: 2.75%;">A</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($students as $index => $student)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td class="text-left" style="padding-left: 6px; text-transform: uppercase;">
                            {{ $student->nama }}
                        </td>
                        <td class="text-center">{{ $student->nis ?? '-' }}</td>
                        <td class="text-center">{{ $student->nisn ?? '-' }}</td>
                        {{-- 10 empty columns for attendance check --}}
                        @for ($col = 1; $col <= 10; $col++)
                            <td></td>
                        @endfor
                        {{-- 3 empty columns for S, I, A --}}
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Footer / Signature -->
        <div class="print-footer">
            <div class="footer-note">
                Catatan : Daftar Hadir ini wajib disetorkan setiap akhir bulan kepada Bagian Tata Usaha sebagai laporan
            </div>
        </div>
    </div>

</body>
</html>
