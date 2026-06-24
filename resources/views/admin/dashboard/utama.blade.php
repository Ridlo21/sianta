@extends('template')
@section('content')
    <style>
        .container-fluid .card {
            transition: transform 0.25s ease, box-shadow 0.25s ease;
        }

        .container-fluid .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.08) !important;
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
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col mt-0">
                                <h5 class="card-title">Total Siswa Aktif</h5>
                            </div>
                            <div class="col-auto">
                                <div class="stat text-primary">
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
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col mt-0">
                                <h5 class="card-title">Guru & Pendidik</h5>
                            </div>
                            <div class="col-auto">
                                <div class="stat text-primary">
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
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col mt-0">
                                <h5 class="card-title">Rombongan Belajar</h5>
                            </div>
                            <div class="col-auto">
                                <div class="stat text-primary">
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
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col mt-0">
                                <h5 class="card-title">Mata Pelajaran</h5>
                            </div>
                            <div class="col-auto">
                                <div class="stat text-primary">
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
                                        <td>Laki-laki (L)</td>
                                        <td class="text-end font-weight-bold">{{ $siswaLaki }}</td>
                                    </tr>
                                    <tr>
                                        <td>Perempuan (P)</td>
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
            new Chart(document.getElementById("chart-jurusan"), {
                type: "bar",
                data: {
                    labels: {!! json_encode($jurusanLabels) !!},
                    datasets: [{
                        label: "Jumlah Siswa",
                        backgroundColor: window.theme.primary,
                        borderColor: window.theme.primary,
                        hoverBackgroundColor: window.theme.primary,
                        hoverBorderColor: window.theme.primary,
                        data: {!! json_encode($jurusanCounts) !!},
                        barPercentage: .75,
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
                                display: false
                            },
                            stacked: false,
                            ticks: {
                                stepSize: 20
                            }
                        }],
                        xAxes: [{
                            stacked: false,
                            gridLines: {
                                color: "transparent"
                            }
                        }]
                    }
                }
            });

            // 2. Chart Donat (Gender)
            new Chart(document.getElementById("chart-gender"), {
                type: "doughnut",
                data: {
                    labels: ["Laki-laki", "Perempuan"],
                    datasets: [{
                        data: [{{ $siswaLaki }}, {{ $siswaPerempuan }}],
                        backgroundColor: [
                            window.theme.primary,
                            window.theme.warning
                        ],
                        borderWidth: 5
                    }]
                },
                options: {
                    responsive: !window.MSInputMethodContext,
                    maintainAspectRatio: false,
                    legend: {
                        display: false
                    },
                    cutoutPercentage: 75
                }
            });
        });
    </script>
@endpush
