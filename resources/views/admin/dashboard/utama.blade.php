@extends('template')
@section('content')
    <style>
        .container-fluid .card {
            transition: transform 0.25s ease, box-shadow 0.25s ease, border-left-width 0.15s ease;
            border-left: 4px solid transparent;
            border-radius: 0.5rem;
        }

        .container-fluid .card-border-primary {
            border-left-color: #3b7ddd !important;
        }
        .container-fluid .card-border-success {
            border-left-color: #1cbb8c !important;
        }
        .container-fluid .card-border-warning {
            border-left-color: #fcb92c !important;
        }
        .container-fluid .card-border-purple {
            border-left-color: #8f5fe8 !important;
        }

        .container-fluid .card:hover {
            transform: translateY(-5px);
            border-left-width: 7px;
        }

        .container-fluid .card-border-primary:hover {
            box-shadow: 0 12px 24px rgba(59, 125, 221, 0.15) !important;
        }
        .container-fluid .card-border-success:hover {
            box-shadow: 0 12px 24px rgba(28, 187, 140, 0.15) !important;
        }
        .container-fluid .card-border-warning:hover {
            box-shadow: 0 12px 24px rgba(252, 185, 44, 0.15) !important;
        }
        .container-fluid .card-border-purple:hover {
            box-shadow: 0 12px 24px rgba(143, 95, 232, 0.15) !important;
        }

        /* Stat Icon Hover Micro-animation */
        .container-fluid .card .stat i {
            transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        .container-fluid .card:hover .stat i {
            transform: scale(1.2) rotate(8deg);
        }

        /* Custom stat icon colors */
        .stat-icon-primary {
            background: rgba(59, 125, 221, 0.1) !important;
            color: #3b7ddd !important;
        }
        .stat-icon-success {
            background: rgba(28, 187, 140, 0.1) !important;
            color: #1cbb8c !important;
        }
        .stat-icon-warning {
            background: rgba(252, 185, 44, 0.1) !important;
            color: #fcb92c !important;
        }
        .stat-icon-purple {
            background: rgba(143, 95, 232, 0.1) !important;
            color: #8f5fe8 !important;
        }
    </style>
    <div class="container-fluid p-0">
        <div class="row mb-2 mb-xl-3">
            <div class="col-auto d-none d-sm-block">
                <h3><strong>Dashboard</strong></h3>
            </div>
            @if ($periodeAktif)
                <div class="col-auto ms-auto text-end mt-n1">
                    <span class="badge bg-primary p-2">
                        Periode Aktif: {{ $periodeAktif->awal }}/{{ $periodeAktif->akhir }} - Semester
                        {{ $periodeAktif->semester }}
                    </span>
                </div>
            @endif
        </div>

        <!-- Row KPI Cards -->
        <div class="row">
            <!-- Total Siswa -->
            <div class="col-sm-6 col-xl-3">
                <div class="card card-border-primary">
                    <div class="card-body">
                        <div class="row">
                            <div class="col mt-0">
                                <h5 class="card-title">Total Siswa Aktif</h5>
                            </div>
                            <div class="col-auto">
                                <div class="stat stat-icon-primary">
                                    <i class="align-middle" data-feather="users"></i>
                                </div>
                            </div>
                        </div>
                        <h1 class="mt-1 mb-3">{{ $totalSiswa }}</h1>
                        <div class="mb-0">
                            <span class="text-muted">Siswa/Santri Terdaftar</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Guru -->
            <div class="col-sm-6 col-xl-3">
                <div class="card card-border-success">
                    <div class="card-body">
                        <div class="row">
                            <div class="col mt-0">
                                <h5 class="card-title">Guru & Pendidik</h5>
                            </div>
                            <div class="col-auto">
                                <div class="stat stat-icon-success">
                                    <i class="align-middle" data-feather="user-check"></i>
                                </div>
                            </div>
                        </div>
                        <h1 class="mt-1 mb-3">{{ $totalGuru }}</h1>
                        <div class="mb-0">
                            <span class="text-muted">Tenaga Pendidik Aktif</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Rombel -->
            <div class="col-sm-6 col-xl-3">
                <div class="card card-border-warning">
                    <div class="card-body">
                        <div class="row">
                            <div class="col mt-0">
                                <h5 class="card-title">Rombongan Belajar</h5>
                            </div>
                            <div class="col-auto">
                                <div class="stat stat-icon-warning">
                                    <i class="align-middle" data-feather="home"></i>
                                </div>
                            </div>
                        </div>
                        <h1 class="mt-1 mb-3">{{ $totalRombel }}</h1>
                        <div class="mb-0">
                            <span class="text-muted">Kelas Terdaftar</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Mapel -->
            <div class="col-sm-6 col-xl-3">
                <div class="card card-border-purple">
                    <div class="card-body">
                        <div class="row">
                            <div class="col mt-0">
                                <h5 class="card-title">Mata Pelajaran</h5>
                            </div>
                            <div class="col-auto">
                                <div class="stat stat-icon-purple">
                                    <i class="align-middle" data-feather="book"></i>
                                </div>
                            </div>
                        </div>
                        <h1 class="mt-1 mb-3">{{ $totalMapel }}</h1>
                        <div class="mb-0">
                            <span class="text-muted">Sebaran Kurikulum</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Row Charts -->
        <div class="row">
            <!-- Chart Siswa per Jurusan -->
            <div class="col-12 col-lg-8 d-flex">
                <div class="card flex-fill w-100">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Jumlah Siswa per Jurusan</h5>
                    </div>
                    <div class="card-body d-flex w-100">
                        <div class="align-self-center chart chart-lg">
                            <canvas id="chart-jurusan"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Chart Gender -->
            <div class="col-12 col-lg-4 d-flex">
                <div class="card flex-fill">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Persentase Gender</h5>
                    </div>
                    <div class="card-body d-flex">
                        <div class="align-self-center w-100">
                            <div class="py-3">
                                <div class="chart chart-xs">
                                    <canvas id="chart-gender"></canvas>
                                </div>
                            </div>
                            <table class="table mb-0">
                                <tbody>
                                    <tr>
                                        <td>
                                            <span class="d-inline-block rounded-circle me-2" style="width: 10px; height: 10px; background-color: #3b7ddd; vertical-align: middle; margin-top: -2px;"></span>
                                            Laki-laki (L)
                                        </td>
                                        <td class="text-end font-weight-bold">{{ $siswaLaki }}</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="d-inline-block rounded-circle me-2" style="width: 10px; height: 10px; background-color: #ff758c; vertical-align: middle; margin-top: -2px;"></span>
                                            Perempuan (P)
                                        </td>
                                        <td class="text-end font-weight-bold">{{ $siswaPerempuan }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // 1. Chart Batang (Jurusan)
            const ctxJurusan = document.getElementById("chart-jurusan").getContext("2d");
            const gradientJurusan = ctxJurusan.createLinearGradient(0, 0, 0, 300);
            gradientJurusan.addColorStop(0, "rgba(59, 125, 221, 0.85)"); // primary top
            gradientJurusan.addColorStop(0.5, "rgba(95, 116, 232, 0.55)"); // indigo middle
            gradientJurusan.addColorStop(1, "rgba(143, 95, 232, 0.05)"); // purple faded bottom

            const gradientJurusanHover = ctxJurusan.createLinearGradient(0, 0, 0, 300);
            gradientJurusanHover.addColorStop(0, "rgba(59, 125, 221, 1)");
            gradientJurusanHover.addColorStop(0.5, "rgba(95, 116, 232, 0.75)");
            gradientJurusanHover.addColorStop(1, "rgba(143, 95, 232, 0.15)");

            new Chart(ctxJurusan, {
                type: "bar",
                data: {
                    labels: {!! json_encode($jurusanLabels) !!},
                    datasets: [{
                        label: "Jumlah Siswa",
                        backgroundColor: gradientJurusan,
                        borderColor: "rgba(59, 125, 221, 1)",
                        borderWidth: 1.5,
                        hoverBackgroundColor: gradientJurusanHover,
                        hoverBorderColor: "rgba(59, 125, 221, 1)",
                        data: {!! json_encode($jurusanCounts) !!},
                        barPercentage: .6,
                        categoryPercentage: .5
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
                                color: "rgba(0, 0, 0, 0.04)",
                                zeroLineColor: "transparent",
                                drawBorder: false
                            },
                            stacked: false,
                            ticks: {
                                stepSize: 20,
                                fontColor: "#8e9aad",
                                fontSize: 11
                            }
                        }],
                        xAxes: [{
                            stacked: false,
                            gridLines: {
                                color: "transparent",
                                drawBorder: false
                            },
                            ticks: {
                                fontColor: "#8e9aad",
                                fontSize: 11
                            }
                        }]
                    },
                    tooltips: {
                        intersect: false,
                        backgroundColor: "rgba(30, 41, 59, 0.95)",
                        titleFontColor: "#fff",
                        bodyFontColor: "#fff",
                        bodySpacing: 4,
                        padding: 10,
                        cornerRadius: 6,
                        displayColors: false
                    }
                }
            });

            // 2. Chart Donat (Gender)
            const ctxGender = document.getElementById("chart-gender").getContext("2d");
            const gradientMale = ctxGender.createLinearGradient(0, 0, 0, 200);
            gradientMale.addColorStop(0, "#3b7ddd");
            gradientMale.addColorStop(1, "#5b9cfd");

            const gradientFemale = ctxGender.createLinearGradient(0, 0, 0, 200);
            gradientFemale.addColorStop(0, "#ff758c");
            gradientFemale.addColorStop(1, "#ff7eb3");

            new Chart(ctxGender, {
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
                        backgroundColor: "rgba(30, 41, 59, 0.95)",
                        bodyFontColor: "#fff",
                        padding: 10,
                        cornerRadius: 6,
                        displayColors: true
                    }
                }
            });
        });
    </script>
@endpush
