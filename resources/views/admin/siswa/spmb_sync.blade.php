@extends('template')
@section('content')
    <div class="container-fluid p-0">
        <div class="row mb-2 mb-xl-3">
            <div class="col-auto d-none d-sm-block">
                <h3><strong>{{ $title }}</strong></h3>
            </div>
            <div class="col-auto ms-auto text-end mt-n1">
                @if (!$connectionError)
                    <button class="btn btn-primary" id="btn-sync"><i class="fas fa-sync-alt"></i> Sinkronkan 10 Data</button>
                @endif
            </div>
        </div>

        @if ($connectionError)
            <div class="alert alert-danger" role="alert">
                <div class="alert-message">
                    <strong>Error Koneksi!</strong> {{ $connectionError }}
                </div>
            </div>
        @else
            <!-- Statistics Cards -->
            <div class="row">
                <div class="col-12 col-sm-6 col-xxl-4 d-flex">
                    <div class="card flex-fill">
                        <div class="card-body py-4">
                            <div class="d-flex align-items-start">
                                <div class="flex-grow-1">
                                    <h3 class="mb-2">{{ $stats['total'] }}</h3>
                                    <p class="mb-2 text-muted">Total Calon Siswa di SPMB</p>
                                </div>
                                <div class="d-inline-block ms-3">
                                    <div class="stat" style="background: rgba(99, 102, 241, 0.1); color: #4f46e5; border-radius: 50%; width: 48px; height: 48px; display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-users" style="font-size: 20px;"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-xxl-4 d-flex">
                    <div class="card flex-fill">
                        <div class="card-body py-4">
                            <div class="d-flex align-items-start">
                                <div class="flex-grow-1">
                                    <h3 class="mb-2 text-success">{{ $stats['synced'] }}</h3>
                                    <p class="mb-2 text-muted">Sudah Sinkron ke SIANTA</p>
                                </div>
                                <div class="d-inline-block ms-3">
                                    <div class="stat" style="background: rgba(46, 204, 113, 0.1); color: #2ecc71; border-radius: 50%; width: 48px; height: 48px; display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-check-circle" style="font-size: 20px;"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-xxl-4 d-flex">
                    <div class="card flex-fill">
                        <div class="card-body py-4">
                            <div class="d-flex align-items-start">
                                <div class="flex-grow-1">
                                    <h3 class="mb-2 text-warning">{{ $stats['pending'] }}</h3>
                                    <p class="mb-2 text-muted">Belum Sinkron (Pending)</p>
                                </div>
                                <div class="d-inline-block ms-3">
                                    <div class="stat" style="background: rgba(243, 156, 18, 0.1); color: #f39c12; border-radius: 50%; width: 48px; height: 48px; display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-hourglass-half" style="font-size: 20px;"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Student List Card -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Daftar Calon Siswa (Database SPMB)</h5>
                            <h6 class="card-subtitle text-muted">
                                Daftar siswa terdaftar dari database SPMB. Anda dapat menyinkronkan data di bawah ini secara bertahap (10 siswa per klik). Sistem akan secara otomatis memvalidasi data untuk menghindari duplikasi data berdasarkan NIK.
                            </h6>
                        </div>
                        <div class="card-body">
                            <table id="datatables-spmb" class="table table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama Lengkap</th>
                                        <th>NIK</th>
                                        <th>NISN</th>
                                        <th>Pilihan Jurusan</th>
                                        <th>Step Registrasi</th>
                                        <th>Status Sinkronisasi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($spmbStudents as $index => $student)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td><strong>{{ $student->nama }}</strong></td>
                                            <td>{{ $student->nik }}</td>
                                            <td>{{ $student->nisn }}</td>
                                            <td><span class="badge bg-secondary">{{ $student->jurusan_name }}</span></td>
                                            <td>
                                                @if ($student->status_step == 4)
                                                    <span class="badge bg-success">Lengkap (Step 4)</span>
                                                @else
                                                    <span class="badge bg-warning">Belum Lengkap (Step {{ $student->status_step }})</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($student->is_synced)
                                                    <span class="badge bg-success-light text-success" style="background: rgba(46, 204, 113, 0.1); padding: 5px 10px; border-radius: 4px; font-weight: 600;"><i class="fas fa-check"></i> Sudah Sinkron</span>
                                                @else
                                                    <span class="badge bg-warning-light text-warning" style="background: rgba(243, 156, 18, 0.1); padding: 5px 10px; border-radius: 4px; font-weight: 600;"><i class="fas fa-sync"></i> Belum Sinkron</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection

@push('scripts')
    @if (!$connectionError)
        <script>
            $(document).ready(function() {
                $('#datatables-spmb').DataTable({
                    paging: true,
                    lengthChange: true,
                    searching: true,
                    ordering: false,
                    info: true,
                    autoWidth: false,
                    responsive: true
                });

                $('#btn-sync').click(function() {
                    Swal.fire({
                        title: "Sinkronisasi Data Siswa",
                        text: "Sistem akan menarik maksimal 10 data siswa valid yang belum terdaftar di SIANTA secara otomatis.",
                        icon: "question",
                        showCancelButton: true,
                        confirmButtonColor: "#4f46e5",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Ya, Sinkronkan!",
                        cancelButtonText: "Batal"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $('#loader').css('display', 'flex');
                            $.ajax({
                                type: 'POST',
                                url: "{{ route('spmb.sync.process') }}",
                                data: {
                                    "_token": "{{ csrf_token() }}",
                                },
                                success: function(response) {
                                    $('#loader').css('display', 'none');
                                    if (response.status === 'success') {
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Sinkronisasi Berhasil',
                                            text: response.message,
                                            confirmButtonColor: "#4f46e5"
                                        }).then(() => {
                                            location.reload();
                                        });
                                    } else if (response.status === 'info') {
                                        Swal.fire({
                                            icon: 'info',
                                            title: 'Info',
                                            text: response.message,
                                            confirmButtonColor: "#4f46e5"
                                        });
                                    } else {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Gagal',
                                            text: response.message,
                                            confirmButtonColor: "#4f46e5"
                                        });
                                    }
                                },
                                error: function(xhr) {
                                    $('#loader').css('display', 'none');
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: 'Terjadi kesalahan sistem saat proses sinkronisasi.',
                                        confirmButtonColor: "#4f46e5"
                                    });
                                }
                            });
                        }
                    });
                });
            });
        </script>
    @endif
@endpush
