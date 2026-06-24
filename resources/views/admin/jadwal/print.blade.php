<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Pembelajaran - {{ $selectedJurusanAlias }} - {{ $version->nama_versi }}</title>
    <style>
        * {
            box-sizing: border-box;
        }
        body {
            font-family: Arial, Helvetica, sans-serif;
            margin: 0;
            padding: 0;
            color: #000;
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
            padding: 6px 12px;
            font-size: 9pt;
            font-weight: bold;
            text-decoration: none;
            border-radius: 4px;
            cursor: pointer;
            border: 1px solid transparent;
        }
        .btn-secondary {
            background-color: #6c757d;
            color: #fff;
        }
        .btn-primary {
            background-color: #0d6efd;
            color: #fff;
        }

        /* Header Style */
        .header-title {
            text-align: center;
            font-weight: bold;
            font-size: 11pt;
            text-transform: uppercase;
            margin-bottom: 2px;
        }
        .header-subtitle {
            text-align: center;
            font-weight: bold;
            font-size: 10pt;
            text-transform: uppercase;
            margin-bottom: 15px;
            border-bottom: 2px solid #000;
            padding-bottom: 5px;
        }

        /* Main Container Layout */
        .print-container {
            display: flex;
            gap: 15px;
            width: 100%;
        }

        .grid-section {
            flex: 2.2;
        }

        .legend-section {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        /* Table Styling */
        table.grid-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 7.5pt;
        }
        table.grid-table th, table.grid-table td {
            border: 1px solid #000000;
            padding: 3px 2px;
            text-align: center;
            vertical-align: middle;
        }
        table.grid-table th {
            background-color: #f0f0f0;
            font-weight: bold;
        }
        .day-header {
            font-weight: bold;
            background-color: #e2e3e5;
            text-transform: uppercase;
            font-size: 8pt;
        }

        /* Legend Table Styling */
        .legend-box {
            border: 1px solid #000;
            padding: 6px;
            background-color: #fff;
        }
        .legend-title {
            font-weight: bold;
            font-size: 8pt;
            text-transform: uppercase;
            border-bottom: 1px solid #000;
            padding-bottom: 2px;
            margin-bottom: 4px;
            text-align: center;
        }
        table.legend-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 7.5pt;
        }
        table.legend-table td {
            padding: 1.5px 3px;
            vertical-align: top;
        }
        .legend-code {
            font-weight: bold;
            width: 10%;
            text-align: center;
        }
        .legend-value {
            width: 90%;
        }

        /* Footer / Signatures */
        .print-footer {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-top: 15px;
            font-size: 8pt;
        }
        .footer-note {
            width: 60%;
            font-style: italic;
            font-size: 7.5pt;
        }
        .footer-sig {
            width: 250px;
            text-align: center;
        }

        /* Print Override */
        @media print {
            .no-print-bar {
                display: none !important;
            }
            body {
                margin: 0;
                padding: 0;
            }
        }
    </style>
</head>
<body>

    <!-- Top Navigation for Browser View -->
    <div class="no-print-bar">
        <a href="{{ route('jadwal') }}" class="btn btn-secondary">&larr; Kembali</a>
        <div>
            <strong>Pratinjau Cetak Jadwal (Jurusan {{ $selectedJurusanAlias }})</strong>
        </div>
        <button onclick="window.print()" class="btn btn-primary">Cetak / Simpan PDF</button>
    </div>

    <div style="padding: 10px;">
        <!-- Header -->
        <div class="header-title">Jadwal Pembelajaran SMK Nurul Abror Al-Robbaniyin ({{ $selectedJurusanAlias }})</div>
        <div class="header-subtitle">Tahun Pelajaran {{ $periodeAktif->awal }}/{{ $periodeAktif->akhir }} Semester {{ $periodeAktif->semester }}</div>

        <!-- Main Content -->
        <div class="print-container">
            
            <!-- LEFT: Main Schedule Grid -->
            <div class="grid-section">
                <table class="grid-table">
                    <thead>
                        <tr>
                            <th style="width: 70px;">WAKTU</th>
                            @foreach($rombels as $rombel)
                                <th>{{ $rombel->nama_rombel }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $currentDay = '';
                        @endphp
                        @foreach($slotWaktus as $slot)
                            <!-- Day Divider Row -->
                            @if($currentDay !== $slot->hari)
                                @php
                                    $currentDay = $slot->hari;
                                @endphp
                                <tr>
                                    <td colspan="{{ $rombels->count() + 1 }}" class="day-header">
                                        {{ $slot->hari }}
                                    </td>
                                </tr>
                            @endif

                            <tr>
                                <!-- Time Slot Column -->
                                <td style="font-size: 7pt; font-weight: bold; background-color: #f9f9f9;">
                                    {{ substr($slot->waktu_mulai, 0, 5) }}-{{ substr($slot->waktu_selesai, 0, 5) }}
                                </td>

                                <!-- Rombel Columns -->
                                @if($slot->is_istirahat)
                                    <td colspan="{{ $rombels->count() }}" style="background-color: #f2f2f2; font-style: italic; font-weight: bold; font-size: 7.5pt; color: #555;">
                                        ISTIRAHAT
                                    </td>
                                @else
                                    @foreach($rombels as $rombel)
                                        @php
                                            $item = isset($grid[$slot->id][$rombel->id]) ? $grid[$slot->id][$rombel->id] : null;
                                        @endphp
                                        <td>
                                            @if($item)
                                                @php
                                                    $guruId = $item->pembelajaran->guru_id;
                                                    $guruCode = isset($guruCodes[$guruId]) ? $guruCodes[$guruId]['code'] : '-';
                                                    $mapelCode = $item->pembelajaran->mataPelajaran->kode_mapel ?? '';
                                                @endphp
                                                <span style="font-weight: bold; font-size: 8pt;">
                                                    {{ $guruCode }} {{ $mapelCode }}
                                                </span>
                                            @else
                                                -
                                            @endif
                                        </td>
                                    @endforeach
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- RIGHT: Legends / Legenda -->
            <div class="legend-section">
                
                <!-- Legend: Mata Pelajaran -->
                <div class="legend-box">
                    <div class="legend-title">Kode Mata Pelajaran</div>
                    <table class="legend-table">
                        @foreach($groupedMapels as $kelompok => $mapels)
                            <tr>
                                <td colspan="2" style="font-weight: bold; background-color: #f0f0f0; padding-top: 4px; padding-bottom: 2px;">
                                    @if($kelompok === 'Umum')
                                        A. Muatan Nasional
                                    @elseif($kelompok === 'Kejuruan')
                                        B. Dasar Program Keahlian / C. Konsentrasi
                                    @elseif($kelompok === 'Muatan Lokal')
                                        D. Muatan Lokal
                                    @else
                                        Lain-Lain ({{ $kelompok }})
                                    @endif
                                </td>
                            </tr>
                            @foreach($mapels as $m)
                                <tr>
                                    <td class="legend-code" style="width: 25%">{{ $m->kode_mapel }}</td>
                                    <td class="legend-value">{{ $m->nama_mapel }}</td>
                                </tr>
                            @endforeach
                        @endforeach
                    </table>
                </div>

                <!-- Legend: Nama Guru -->
                <div class="legend-box">
                    <div class="legend-title">Kode Nama Guru</div>
                    <table class="legend-table">
                        @foreach($guruCodes as $gId => $gData)
                            <tr>
                                <td class="legend-code">{{ $gData['code'] }}</td>
                                <td class="legend-value">{{ $gData['name'] }}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>

                <!-- Legend: Wali Kelas -->
                <div class="legend-box">
                    <div class="legend-title">Wali Kelas</div>
                    <table class="legend-table">
                        @foreach($waliKelasList as $rombelNama => $waliNama)
                            <tr>
                                <td style="font-weight: bold; width: 40%">{{ $rombelNama }}</td>
                                <td class="legend-value">{{ $waliNama }}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>

            </div>

        </div>

        <!-- Footer / Signatures -->
        <div class="print-footer">
            <div class="footer-note">
                <strong>Keterangan:</strong><br>
                - Jika ada jadwal yang berbenturan silahkan hubungi kurikulum.<br>
                - Jika ada yang ingin mengganti hari, silahkan hubungi kurikulum untuk diperbaharui.
            </div>
            <div class="footer-sig">
                Banyuwangi, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}<br>
                Waka Kurikulum {{ $selectedJurusanAlias }}<br>
                SMK Nurul Abror Al-Robbaniyin
                <br><br><br><br>
                <u><strong>....................................</strong></u>
            </div>
        </div>

    </div>

</body>
</html>
