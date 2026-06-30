@extends('template')
@section('content')
    <style>
        /* Custom Dashboard Styles */
        .dashboard-container {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            color: var(--text-main);
        }

        .text-theme-value {
            color: var(--text-value) !important;
        }

        .text-theme-main {
            color: var(--text-main) !important;
        }

        .bg-primary-subtle {
            background-color: rgba(37, 99, 235, 0.08) !important;
        }

        .bg-success-subtle {
            background-color: rgba(16, 185, 129, 0.08) !important;
        }

        .bg-info-subtle {
            background-color: rgba(6, 182, 212, 0.08) !important;
        }

        .bg-warning-subtle {
            background-color: rgba(245, 158, 11, 0.08) !important;
        }

        /* Welcome Banner */
        .welcome-banner {
            background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 50%, #3b82f6 100%);
            border-radius: 16px;
            padding: 2.25rem;
            color: #ffffff;
            position: relative;
            overflow: hidden;
            border: none;
            box-shadow: 0 10px 25px rgba(37, 99, 235, 0.15);
            margin-bottom: 2rem;
        }

        .welcome-banner::before {
            content: '';
            position: absolute;
            top: -40%;
            right: -10%;
            width: 320px;
            height: 320px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.18) 0%, rgba(255, 255, 255, 0) 70%);
            pointer-events: none;
        }

        .welcome-banner::after {
            content: '';
            position: absolute;
            bottom: -30%;
            left: 20%;
            width: 180px;
            height: 180px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.12) 0%, rgba(255, 255, 255, 0) 70%);
            pointer-events: none;
        }

        .welcome-banner-title {
            font-size: 1.75rem;
            font-weight: 750;
            margin-bottom: 0.5rem;
            letter-spacing: -0.02em;
        }

        .welcome-banner-text {
            font-size: 0.975rem;
            opacity: 0.9;
            font-weight: 400;
            max-width: 580px;
            line-height: 1.5;
        }

        .welcome-badge-glass {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.25);
            padding: 0.5rem 1.25rem;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 600;
            color: #ffffff;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        /* Metric Cards */
        .metric-card {
            background: var(--bg-card);
            border: 1px solid var(--border-card);
            border-radius: 16px !important;
            padding: 1.5rem;
            transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.01), 0 2px 4px -1px rgba(0, 0, 0, 0.005) !important;
            height: 100%;
            position: relative;
        }

        .metric-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(15, 23, 42, 0.04), 0 10px 10px -5px rgba(15, 23, 42, 0.02) !important;
            border-color: rgba(226, 232, 240, 1);
        }

        .metric-card-title {
            color: #64748b;
            font-size: 0.85rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 0.5rem;
        }

        .metric-card-value {
            font-size: 2.25rem;
            font-weight: 700;
            color: var(--text-value);
            line-height: 1;
            margin-bottom: 0.25rem;
            letter-spacing: -0.03em;
        }

        .metric-card-desc {
            color: #94a3b8;
            font-size: 0.85rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .metric-icon-wrapper {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Stat Soft & Hover Colors */
        .stat-blue {
            background: rgba(37, 99, 235, 0.07) !important;
            color: #2563eb !important;
        }

        .metric-card:hover .stat-blue {
            background: #2563eb !important;
            color: #ffffff !important;
            box-shadow: 0 8px 20px rgba(37, 99, 235, 0.25);
            transform: scale(1.08) rotate(5deg);
        }

        .stat-green {
            background: rgba(16, 185, 129, 0.07) !important;
            color: #10b981 !important;
        }

        .metric-card:hover .stat-green {
            background: #10b981 !important;
            color: #ffffff !important;
            box-shadow: 0 8px 20px rgba(16, 185, 129, 0.25);
            transform: scale(1.08) rotate(5deg);
        }

        .stat-amber {
            background: rgba(245, 158, 11, 0.07) !important;
            color: #f59e0b !important;
        }

        .metric-card:hover .stat-amber {
            background: #f59e0b !important;
            color: #ffffff !important;
            box-shadow: 0 8px 20px rgba(245, 158, 11, 0.25);
            transform: scale(1.08) rotate(5deg);
        }

        .stat-purple {
            background: rgba(6, 182, 212, 0.07) !important;
            color: #0891b2 !important;
        }

        .metric-card:hover .stat-purple {
            background: #0891b2 !important;
            color: #ffffff !important;
            box-shadow: 0 8px 20px rgba(6, 182, 212, 0.25);
            transform: scale(1.08) rotate(5deg);
        }

        /* Badge Soft Styles */
        .badge-soft-blue {
            background-color: rgba(37, 99, 235, 0.08);
            color: #2563eb;
            font-size: 0.75rem;
            font-weight: 600;
            padding: 0.25rem 0.5rem;
            border-radius: 6px;
        }

        .badge-soft-green {
            background-color: rgba(16, 185, 129, 0.08);
            color: #10b981;
            font-size: 0.75rem;
            font-weight: 600;
            padding: 0.25rem 0.5rem;
            border-radius: 6px;
        }

        .badge-soft-amber {
            background-color: rgba(245, 158, 11, 0.08);
            color: #f59e0b;
            font-size: 0.75rem;
            font-weight: 600;
            padding: 0.25rem 0.5rem;
            border-radius: 6px;
        }

        .badge-soft-purple {
            background-color: rgba(6, 182, 212, 0.08);
            color: #0891b2;
            font-size: 0.75rem;
            font-weight: 600;
            padding: 0.25rem 0.5rem;
            border-radius: 6px;
        }

        /* Quick Access */
        .quick-access-section {
            margin-top: 2rem;
            margin-bottom: 2rem;
        }

        .quick-access-title {
            font-size: 1.05rem;
            font-weight: 700;
            color: var(--text-value);
            margin-bottom: 1rem;
            letter-spacing: -0.01em;
        }

        .quick-card {
            background: var(--bg-quick-card);
            border: 1px solid var(--border-card);
            border-radius: 14px;
            padding: 1.1rem 1.25rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            text-decoration: none !important;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.005);
        }

        .quick-card:hover {
            border-color: #2563eb;
            box-shadow: 0 10px 20px -3px rgba(37, 99, 235, 0.08);
            transform: translateX(5px);
        }

        .quick-card-info {
            display: flex;
            align-items: center;
            gap: 0.9rem;
        }

        .quick-card-icon {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .quick-card-name {
            font-weight: 600;
            font-size: 0.95rem;
            color: var(--text-main);
            transition: color 0.2s ease;
        }

        .quick-card:hover .quick-card-name {
            color: #2563eb;
        }

        .quick-card-arrow {
            color: #94a3b8;
            transition: transform 0.3s ease, color 0.3s ease;
        }

        .quick-card:hover .quick-card-arrow {
            transform: translateX(3px);
            color: #2563eb;
        }

        /* Charts */
        .chart-card {
            background: var(--bg-card);
            border: 1px solid var(--border-card);
            border-radius: 16px !important;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.01) !important;
            overflow: hidden;
            margin-bottom: 2rem;
            height: 100%;
        }

        .chart-card-header {
            background: transparent;
            border-bottom: 1px solid var(--border-card);
            padding: 1.25rem 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .chart-card-title {
            font-size: 1rem;
            font-weight: 700;
            color: var(--text-value);
            margin-bottom: 0;
        }

        .chart-card-body {
            padding: 1.5rem;
        }

        /* Gender Table Styles */
        .gender-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 0.5rem;
            margin-top: 1rem;
        }

        .gender-table tr {
            background: var(--bg-table-row);
            transition: all 0.2s ease;
        }

        .gender-table tr:hover {
            background: var(--bg-table-hover);
        }

        .gender-table td {
            border: none !important;
            padding: 0.75rem 1rem !important;
            vertical-align: middle;
            font-weight: 550;
            color: var(--text-table-label);
        }

        .gender-table td:first-child {
            border-top-left-radius: 10px;
            border-bottom-left-radius: 10px;
        }

        .gender-table td:last-child {
            border-top-right-radius: 10px;
            border-bottom-right-radius: 10px;
            text-align: right;
            color: var(--text-value);
            font-weight: 700;
        }

        /* Customize navigation pills for the tab */
        #recent-tab .nav-link {
            border-radius: 8px !important;
            font-size: 0.8rem !important;
            font-weight: 600 !important;
            color: var(--text-muted) !important;
            background: transparent;
            transition: all 0.2s ease;
            border: 1px solid var(--border-card) !important;
        }

        #recent-tab .nav-link.active {
            color: #ffffff !important;
            background: linear-gradient(135deg, #1d4ed8 0%, #3b82f6 100%) !important;
            border-color: transparent !important;
            box-shadow: 0 4px 10px rgba(37, 99, 235, 0.15) !important;
        }
    </style>

    <div class="container-fluid p-0 dashboard-container">

        <!-- Modern Welcome Banner -->
        <div class="welcome-banner">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h3 class="welcome-banner-title">Selamat datang kembali, {{ $user->name }}! 👋</h3>
                    <p class="welcome-banner-text mb-0">
                        Berikut adalah rangkuman statistik data akademik hari ini. Sistem berjalan dengan normal dan siap
                        melayani aktivitas manajemen sekolah Anda.
                    </p>
                </div>
                @if ($periodeAktif)
                    <div class="col-md-4 text-md-end mt-3 mt-md-0">
                        <div class="welcome-badge-glass">
                            <i data-feather="calendar" style="width: 16px; height: 16px;"></i>
                            <span>Periode Aktif: {{ $periodeAktif->awal }}/{{ $periodeAktif->akhir }} (Smtr
                                {{ $periodeAktif->semester }})</span>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Row KPI Cards -->
        <div class="row g-3">
            <!-- Total Siswa -->
            <div class="col-sm-6 col-xl-3">
                <div class="metric-card">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h5 class="metric-card-title">Total Siswa</h5>
                            <h1 class="metric-card-value">{{ $totalSiswa }}</h1>
                            <div class="d-flex align-items-center gap-1 mt-1 mb-2">
                                <span class="text-success small fw-semibold d-flex align-items-center">
                                    <i data-feather="arrow-up-right"
                                        style="width: 14px; height: 14px; stroke-width: 2.5;"></i> +2.4%
                                </span>
                                <span style="font-size: 0.75rem; color: var(--text-muted);">semester ini</span>
                            </div>
                        </div>
                        <div class="metric-icon-wrapper stat-blue">
                            <i data-feather="users" style="width: 22px; height: 22px;"></i>
                        </div>
                    </div>
                    <div class="metric-card-desc mt-2">
                        <span class="badge-soft-blue">Siswa</span>
                        <span>Terdaftar aktif di sistem</span>
                    </div>
                </div>
            </div>

            <!-- Total Guru -->
            <div class="col-sm-6 col-xl-3">
                <div class="metric-card">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h5 class="metric-card-title">Pendidik</h5>
                            <h1 class="metric-card-value">{{ $totalGuru }}</h1>
                            <div class="d-flex align-items-center gap-1 mt-1 mb-2">
                                <span class="text-success small fw-semibold d-flex align-items-center">
                                    <i data-feather="arrow-up-right"
                                        style="width: 14px; height: 14px; stroke-width: 2.5;"></i> +1.2%
                                </span>
                                <span style="font-size: 0.75rem; color: var(--text-muted);">tahun ini</span>
                            </div>
                        </div>
                        <div class="metric-icon-wrapper stat-green">
                            <i data-feather="user-check" style="width: 22px; height: 22px;"></i>
                        </div>
                    </div>
                    <div class="metric-card-desc mt-2">
                        <span class="badge-soft-green">Guru</span>
                        <span>Tenaga pendidik aktif</span>
                    </div>
                </div>
            </div>

            <!-- Total Rombel -->
            <div class="col-sm-6 col-xl-3">
                <div class="metric-card">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h5 class="metric-card-title">Rombel</h5>
                            <h1 class="metric-card-value">{{ $totalRombel }}</h1>
                            <div class="d-flex align-items-center gap-1 mt-1 mb-2">
                                <span class="text-muted small fw-semibold d-flex align-items-center">
                                    <i data-feather="minus" style="width: 14px; height: 14px; stroke-width: 2.5;"></i> 0.0%
                                </span>
                                <span style="font-size: 0.75rem; color: var(--text-muted);">statis</span>
                            </div>
                        </div>
                        <div class="metric-icon-wrapper stat-amber">
                            <i data-feather="home" style="width: 22px; height: 22px;"></i>
                        </div>
                    </div>
                    <div class="metric-card-desc mt-2">
                        <span class="badge-soft-amber">Kelas</span>
                        <span>Rombongan belajar terdaftar</span>
                    </div>
                </div>
            </div>

            <!-- Total Mapel -->
            <div class="col-sm-6 col-xl-3">
                <div class="metric-card">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h5 class="metric-card-title">Mata Pelajaran</h5>
                            <h1 class="metric-card-value">{{ $totalMapel }}</h1>
                            <div class="d-flex align-items-center gap-1 mt-1 mb-2">
                                <span class="text-info small fw-semibold d-flex align-items-center">
                                    <i data-feather="check" style="width: 14px; height: 14px; stroke-width: 2.5;"></i> K.
                                    Merdeka
                                </span>
                                <span style="font-size: 0.75rem; color: var(--text-muted);">aktif</span>
                            </div>
                        </div>
                        <div class="metric-icon-wrapper stat-purple">
                            <i data-feather="book" style="width: 22px; height: 22px;"></i>
                        </div>
                    </div>
                    <div class="metric-card-desc mt-2">
                        <span class="badge-soft-purple">Mapel</span>
                        <span>Sebaran kurikulum saat ini</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Access Section -->
        <div class="quick-access-section">
            <h5 class="quick-access-title">Akses Cepat</h5>
            <div class="row g-3">
                <div class="col-6 col-md-3">
                    <a href="{{ route('siswa') }}" class="quick-card">
                        <div class="quick-card-info">
                            <div class="quick-card-icon" style="background: rgba(37, 99, 235, 0.08); color: #2563eb;">
                                <i data-feather="users" style="width: 18px; height: 18px;"></i>
                            </div>
                            <span class="quick-card-name">Data Siswa</span>
                        </div>
                        <i data-feather="chevron-right" class="quick-card-arrow" style="width: 16px; height: 16px;"></i>
                    </a>
                </div>
                <div class="col-6 col-md-3">
                    <a href="{{ route('guru') }}" class="quick-card">
                        <div class="quick-card-info">
                            <div class="quick-card-icon" style="background: rgba(16, 185, 129, 0.08); color: #10b981;">
                                <i data-feather="user-check" style="width: 18px; height: 18px;"></i>
                            </div>
                            <span class="quick-card-name">Data Guru</span>
                        </div>
                        <i data-feather="chevron-right" class="quick-card-arrow" style="width: 16px; height: 16px;"></i>
                    </a>
                </div>
                <div class="col-6 col-md-3">
                    <a href="{{ route('rombel') }}" class="quick-card">
                        <div class="quick-card-info">
                            <div class="quick-card-icon" style="background: rgba(245, 158, 11, 0.08); color: #f59e0b;">
                                <i data-feather="home" style="width: 18px; height: 18px;"></i>
                            </div>
                            <span class="quick-card-name">Data Rombel</span>
                        </div>
                        <i data-feather="chevron-right" class="quick-card-arrow" style="width: 16px; height: 16px;"></i>
                    </a>
                </div>
                <div class="col-6 col-md-3">
                    <a href="{{ route('jadwal') }}" class="quick-card">
                        <div class="quick-card-info">
                            <div class="quick-card-icon" style="background: rgba(6, 182, 212, 0.08); color: #0891b2;">
                                <i data-feather="calendar" style="width: 18px; height: 18px;"></i>
                            </div>
                            <span class="quick-card-name">Jadwal Pelajaran</span>
                        </div>
                        <i data-feather="chevron-right" class="quick-card-arrow" style="width: 16px; height: 16px;"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Row Charts -->
        <div class="row">
            <!-- Chart Siswa per Jurusan -->
            <div class="col-12 col-lg-8 d-flex mb-3 mb-lg-0">
                <div class="chart-card flex-fill w-100">
                    <div class="chart-card-header">
                        <h5 class="chart-card-title">Jumlah Siswa per Jurusan</h5>
                    </div>
                    <div class="chart-card-body d-flex w-100" style="min-height: 350px;">
                        <div class="align-self-center w-100" style="height: 300px;">
                            <canvas id="chart-jurusan"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Chart Gender -->
            <div class="col-12 col-lg-4 d-flex">
                <div class="chart-card flex-fill">
                    <div class="chart-card-header">
                        <h5 class="chart-card-title">Persentase Gender</h5>
                    </div>
                    <div class="chart-card-body d-flex flex-column justify-content-between" style="min-height: 350px;">
                        <div class="align-self-center w-100" style="height: 180px; position: relative;">
                            <canvas id="chart-gender"></canvas>
                        </div>
                        <div class="w-100 mt-3">
                            <table class="gender-table">
                                <tbody>
                                    <tr>
                                        <td>
                                            <span class="d-inline-block rounded-circle me-2"
                                                style="width: 10px; height: 10px; background: linear-gradient(135deg, #1d4ed8, #60a5fa); vertical-align: middle;"></span>
                                            Laki-laki (L)
                                        </td>
                                        <td>{{ $siswaLaki }}</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="d-inline-block rounded-circle me-2"
                                                style="width: 10px; height: 10px; background: linear-gradient(135deg, #ec4899, #f472b6); vertical-align: middle;"></span>
                                            Perempuan (P)
                                        </td>
                                        <td>{{ $siswaPerempuan }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Row Chart Rombel -->
        <div class="row">
            <div class="col-12 mb-3 mt-3">
                <div class="chart-card">
                    <div class="chart-card-header">
                        <h5 class="chart-card-title">Kapasitas & Jumlah Siswa per Rombel</h5>
                    </div>
                    <div class="chart-card-body" style="min-height: 380px;">
                        <div style="height: 330px; width: 100%;">
                            <canvas id="chart-rombel"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Row Recent & Info -->
        <div class="row">
            <!-- Grafik Siswa per Angkatan -->
            <div class="col-12 col-lg-8 mb-3 mb-lg-0">
                <div class="chart-card">
                    <div class="chart-card-header">
                        <h5 class="chart-card-title">Perkembangan Siswa per Angkatan</h5>
                    </div>
                    <div class="chart-card-body" style="min-height: 250px;">
                        <div style="height: 200px; width: 100%;">
                            <canvas id="chart-angkatan"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kalender & Sistem Info Card -->
            <div class="col-12 col-lg-4">
                <div class="card flex-fill w-100" style="height: 100%;">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Informasi Sistem</h5>
                    </div>
                    <div class="card-body d-flex flex-column justify-content-between" style="min-height: 250px;">
                        <div class="mb-3">
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-primary-subtle text-primary rounded p-2 me-3">
                                    <i data-feather="server" style="width: 20px; height: 20px;"></i>
                                </div>
                                <div>
                                    <div class="fw-semibold">Status Server</div>
                                    <small class="text-success"><span
                                            class="d-inline-block rounded-circle bg-success me-1"
                                            style="width: 8px; height: 8px;"></span> Online & Stabil</small>
                                </div>
                            </div>
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-info-subtle text-info rounded p-2 me-3">
                                    <i data-feather="clock" style="width: 20px; height: 20px;"></i>
                                </div>
                                <div>
                                    <div class="fw-semibold">Waktu Server</div>
                                    <small class="text-muted" id="realtime-clock">--:--:-- WIB</small>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <div class="bg-warning-subtle text-warning rounded p-2 me-3">
                                    <i data-feather="shield" style="width: 20px; height: 20px;"></i>
                                </div>
                                <div>
                                    <div class="fw-semibold">Keamanan Sesi</div>
                                    <small class="text-muted">Terlindungi SSL/HTTPS</small>
                                </div>
                            </div>
                        </div>
                        <div class="pt-3 border-top">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-muted small">Versi Aplikasi</span>
                                <span class="badge bg-secondary">v1.2.0</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let chartJurusan, chartGender, chartRombel, chartAngkatan;

        // Dynamic Chart Color Theme Function
        window.updateChartsTheme = function(theme) {
            const isDark = theme === 'dark';
            const gridColor = isDark ? "rgba(255, 255, 255, 0.06)" : "rgba(226, 232, 240, 0.4)";
            const fontColor = isDark ? "#64748b" : "#94a3b8";
            const borderColor = isDark ? "#151c2e" : "#ffffff";

            if (chartJurusan && chartJurusan.options && chartJurusan.options.scales) {
                chartJurusan.options.scales.yAxes[0].gridLines.color = gridColor;
                chartJurusan.options.scales.yAxes[0].ticks.fontColor = fontColor;
                chartJurusan.options.scales.xAxes[0].ticks.fontColor = fontColor;
                chartJurusan.update();
            }

            if (chartGender && chartGender.data && chartGender.data.datasets) {
                chartGender.data.datasets[0].borderColor = borderColor;
                chartGender.update();
            }

            if (chartRombel && chartRombel.options && chartRombel.options.scales) {
                chartRombel.options.scales.xAxes[0].gridLines.color = gridColor;
                chartRombel.options.scales.xAxes[0].ticks.fontColor = fontColor;
                chartRombel.options.scales.yAxes[0].ticks.fontColor = fontColor;
                chartRombel.update();
            }

            if (chartAngkatan && chartAngkatan.options && chartAngkatan.options.scales) {
                chartAngkatan.options.scales.yAxes[0].gridLines.color = gridColor;
                chartAngkatan.options.scales.yAxes[0].ticks.fontColor = fontColor;
                chartAngkatan.options.scales.xAxes[0].ticks.fontColor = fontColor;
                chartAngkatan.update();
            }
        }

        document.addEventListener("DOMContentLoaded", function() {
            // 1. Chart Batang (Jurusan)
            const ctxJurusan = document.getElementById("chart-jurusan").getContext("2d");

            const gradientJurusan = ctxJurusan.createLinearGradient(0, 0, 0, 300);
            gradientJurusan.addColorStop(0, "rgba(37, 99, 235, 0.85)"); // blue-600
            gradientJurusan.addColorStop(1, "rgba(59, 130, 246, 0.05)"); // blue-500 faded

            const gradientJurusanHover = ctxJurusan.createLinearGradient(0, 0, 0, 300);
            gradientJurusanHover.addColorStop(0, "rgba(37, 99, 235, 1)");
            gradientJurusanHover.addColorStop(1, "rgba(59, 130, 246, 0.2)");

            chartJurusan = new Chart(ctxJurusan, {
                type: "bar",
                data: {
                    labels: {!! json_encode($jurusanLabels) !!},
                    datasets: [{
                        label: "Jumlah Siswa",
                        backgroundColor: gradientJurusan,
                        borderColor: "rgba(37, 99, 235, 1)",
                        borderWidth: 1.5,
                        hoverBackgroundColor: gradientJurusanHover,
                        hoverBorderColor: "rgba(37, 99, 235, 1)",
                        data: {!! json_encode($jurusanCounts) !!},
                        barPercentage: .55,
                        categoryPercentage: .45
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    legend: {
                        display: false
                    },
                    scales: {
                        yAxes: [{
                            gridLines: {
                                display: true,
                                color: "rgba(226, 232, 240, 0.4)",
                                zeroLineColor: "transparent",
                                drawBorder: false
                            },
                            stacked: false,
                            ticks: {
                                beginAtZero: true,
                                fontColor: "#94a3b8",
                                fontSize: 11,
                                fontFamily: "'Inter', sans-serif"
                            }
                        }],
                        xAxes: [{
                            stacked: false,
                            gridLines: {
                                color: "transparent",
                                drawBorder: false
                            },
                            ticks: {
                                fontColor: "#94a3b8",
                                fontSize: 11,
                                fontFamily: "'Inter', sans-serif"
                            }
                        }]
                    },
                    tooltips: {
                        intersect: false,
                        backgroundColor: "rgba(15, 23, 42, 0.95)",
                        titleFontColor: "#fff",
                        titleFontFamily: "'Inter', sans-serif",
                        bodyFontColor: "#fff",
                        bodyFontFamily: "'Inter', sans-serif",
                        bodySpacing: 4,
                        padding: 12,
                        cornerRadius: 8,
                        displayColors: false
                    }
                }
            });

            // 2. Chart Donat (Gender)
            const ctxGender = document.getElementById("chart-gender").getContext("2d");

            const gradientMale = ctxGender.createLinearGradient(0, 0, 0, 180);
            gradientMale.addColorStop(0, "#1d4ed8"); // Blue-700
            gradientMale.addColorStop(1, "#60a5fa"); // Sky-400

            const gradientFemale = ctxGender.createLinearGradient(0, 0, 0, 180);
            gradientFemale.addColorStop(0, "#ec4899"); // Pink-500
            gradientFemale.addColorStop(1, "#f472b6"); // Pink-400

            chartGender = new Chart(ctxGender, {
                type: "doughnut",
                data: {
                    labels: ["Laki-laki", "Perempuan"],
                    datasets: [{
                        data: [{{ $siswaLaki }}, {{ $siswaPerempuan }}],
                        backgroundColor: [
                            gradientMale,
                            gradientFemale
                        ],
                        borderWidth: 4,
                        borderColor: "#ffffff"
                    }]
                },
                options: {
                    responsive: !window.MSInputMethodContext,
                    maintainAspectRatio: false,
                    legend: {
                        display: false
                    },
                    cutoutPercentage: 75,
                    tooltips: {
                        backgroundColor: "rgba(15, 23, 42, 0.95)",
                        bodyFontColor: "#fff",
                        bodyFontFamily: "'Inter', sans-serif",
                        padding: 12,
                        cornerRadius: 8,
                        displayColors: true
                    }
                }
            });

            // 3. Chart Rombel (Horizontal Bar)
            const ctxRombel = document.getElementById("chart-rombel").getContext("2d");

            const gradientRombel = ctxRombel.createLinearGradient(0, 0, 400, 0);
            gradientRombel.addColorStop(0, "rgba(16, 185, 129, 0.15)"); // green-500 faded
            gradientRombel.addColorStop(1, "rgba(16, 185, 129, 0.85)"); // green-500 solid

            const gradientRombelHover = ctxRombel.createLinearGradient(0, 0, 400, 0);
            gradientRombelHover.addColorStop(0, "rgba(16, 185, 129, 0.3)");
            gradientRombelHover.addColorStop(1, "rgba(16, 185, 129, 1)");

            chartRombel = new Chart(ctxRombel, {
                type: "horizontalBar",
                data: {
                    labels: {!! json_encode($rombelLabels) !!},
                    datasets: [{
                        label: "Jumlah Siswa",
                        backgroundColor: gradientRombel,
                        borderColor: "rgba(16, 185, 129, 1)",
                        borderWidth: 1.5,
                        hoverBackgroundColor: gradientRombelHover,
                        hoverBorderColor: "rgba(16, 185, 129, 1)",
                        data: {!! json_encode($rombelCounts) !!},
                        barPercentage: .55,
                        categoryPercentage: .45
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    legend: {
                        display: false
                    },
                    scales: {
                        xAxes: [{
                            gridLines: {
                                display: true,
                                color: "rgba(226, 232, 240, 0.4)",
                                zeroLineColor: "transparent",
                                drawBorder: false
                            },
                            ticks: {
                                beginAtZero: true,
                                fontColor: "#94a3b8",
                                fontSize: 11,
                                fontFamily: "'Inter', sans-serif",
                                precision: 0
                            }
                        }],
                        yAxes: [{
                            gridLines: {
                                color: "transparent",
                                drawBorder: false
                            },
                            ticks: {
                                fontColor: "#94a3b8",
                                fontSize: 11,
                                fontFamily: "'Inter', sans-serif"
                            }
                        }]
                    },
                    tooltips: {
                        intersect: false,
                        backgroundColor: "rgba(15, 23, 42, 0.95)",
                        titleFontColor: "#fff",
                        titleFontFamily: "'Inter', sans-serif",
                        bodyFontColor: "#fff",
                        bodyFontFamily: "'Inter', sans-serif",
                        bodySpacing: 4,
                        padding: 12,
                        cornerRadius: 8,
                        displayColors: false
                    }
                }
            });

            // 4. Chart Angkatan (Vertical Bar)
            const ctxAngkatan = document.getElementById("chart-angkatan").getContext("2d");

            const gradientAngkatan = ctxAngkatan.createLinearGradient(0, 0, 0, 200);
            gradientAngkatan.addColorStop(0, "rgba(59, 130, 246, 0.85)"); // blue-500
            gradientAngkatan.addColorStop(1, "rgba(59, 130, 246, 0.05)"); // blue-500 faded

            const gradientAngkatanHover = ctxAngkatan.createLinearGradient(0, 0, 0, 200);
            gradientAngkatanHover.addColorStop(0, "rgba(59, 130, 246, 1)");
            gradientAngkatanHover.addColorStop(1, "rgba(59, 130, 246, 0.2)");

            chartAngkatan = new Chart(ctxAngkatan, {
                type: "bar",
                data: {
                    labels: {!! json_encode($angkatanLabels) !!},
                    datasets: [{
                        label: "Siswa Aktif",
                        backgroundColor: gradientAngkatan,
                        borderColor: "rgba(59, 130, 246, 1)",
                        borderWidth: 1.5,
                        hoverBackgroundColor: gradientAngkatanHover,
                        hoverBorderColor: "rgba(59, 130, 246, 1)",
                        data: {!! json_encode($angkatanCounts) !!},
                        barPercentage: .4,
                        categoryPercentage: .3
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    legend: {
                        display: false
                    },
                    scales: {
                        yAxes: [{
                            gridLines: {
                                display: true,
                                color: "rgba(226, 232, 240, 0.4)",
                                zeroLineColor: "transparent",
                                drawBorder: false
                            },
                            ticks: {
                                beginAtZero: true,
                                fontColor: "#94a3b8",
                                fontSize: 11,
                                fontFamily: "'Inter', sans-serif",
                                precision: 0
                            }
                        }],
                        xAxes: [{
                            gridLines: {
                                color: "transparent",
                                drawBorder: false
                            },
                            ticks: {
                                fontColor: "#94a3b8",
                                fontSize: 11,
                                fontFamily: "'Inter', sans-serif"
                            }
                        }]
                    },
                    tooltips: {
                        intersect: false,
                        backgroundColor: "rgba(15, 23, 42, 0.95)",
                        titleFontColor: "#fff",
                        titleFontFamily: "'Inter', sans-serif",
                        bodyFontColor: "#fff",
                        bodyFontFamily: "'Inter', sans-serif",
                        bodySpacing: 4,
                        padding: 12,
                        cornerRadius: 8,
                        displayColors: false
                    }
                }
            });

            // Initialize correct colors immediately based on resolved theme
            const currentTheme = document.documentElement.getAttribute('data-theme') || 'light';
            window.updateChartsTheme(currentTheme);

            // Realtime Clock
            const clockEl = document.getElementById("realtime-clock");
            if (clockEl) {
                const updateClock = () => {
                    const now = new Date();
                    clockEl.textContent = now.toLocaleTimeString('id-ID', {
                        hour: '2-digit',
                        minute: '2-digit',
                        second: '2-digit'
                    }) + " WIB";
                };
                updateClock();
                setInterval(updateClock, 1000);
            }
        });
    </script>
@endpush
