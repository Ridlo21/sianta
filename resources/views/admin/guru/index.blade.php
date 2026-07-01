@extends('template')
@section('content')
    <div class="container-fluid p-0">
        <div class="row mb-2 mb-xl-3">
            <div class="col-auto d-none d-sm-block">
                <h3><strong>{{ $title }}</strong></h3>
            </div>
            <div class="col-auto ms-auto text-end mt-n1 d-flex justify-content-end align-items-center gap-2">
                <div class="dropdown d-inline-block">
                    <button class="btn btn-success dropdown-toggle fw-bold shadow-xs" type="button" id="dropdownExportExcel" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-file-excel me-1"></i> Export Excel
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="dropdownExportExcel">
                        <li>
                            <a class="dropdown-item fw-bold text-primary" href="{{ route('guru.export', 'Laki-laki') }}">
                                <i class="fas fa-mars me-1"></i> Laki-Laki
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item fw-bold text-danger" href="{{ route('guru.export', 'Perempuan') }}">
                                <i class="fas fa-venus me-1"></i> Perempuan
                            </a>
                        </li>
                    </ul>
                </div>
                <button class="btn btn-primary" id="bt_tambah"><i class="fas fa-plus"></i> Tambah Guru & Tendik</button>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">List Guru & Tendik</h5>
                        <h6 class="card-subtitle text-muted">Daftar guru dan tendik yang terdaftar dan aktif dalam sistem
                            akademik.
                            Data guru dan tendik digunakan sebagai dasar pengelolaan tenaga pendidik, pembagian tugas
                            mengajar,
                            penjadwalan pelajaran, penetapan wali kelas, serta berbagai proses administrasi dan akademik
                            lainnya. Pastikan data guru dan tendik selalu diperbarui sesuai dengan kondisi dan penugasan
                            yang berlaku.
                        </h6>
                    </div>
                    <div class="card-body">
                        <table id="datatables-reponsive" class="table table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>NIY</th>
                                    <th>NUPTK</th>
                                    <th>Nama Lengkap</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#datatables-reponsive').DataTable({
                paging: true,
                lengthChange: true,
                searching: true,
                ordering: false,
                info: true,
                autoWidth: false,
                responsive: true,
                processing: true,
                serverSide: true,
                ajax: "{{ route('guru.data') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'niy'
                    },
                    {
                        data: 'nuptk'
                    },
                    {
                        data: 'nama'
                    },
                    {
                        data: 'jenis_kelamin'
                    },
                    {
                        data: 'action'
                    }
                ]
            });

            $('#datatables-reponsive').on("click", '.btnHapus', function() {
                var id = $(this).data("id");
                Swal.fire({
                    title: "Anda Yakin?",
                    icon: 'question',
                    text: 'Anda tidak dapat mengembalikan ini',
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    showDenyButton: true,
                    showCancelButton: false,
                    confirmButtonText: "Ya, lanjutkan!",
                    denyButtonText: `Tidak`
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#loader').css('display', 'flex');
                        $.ajax({
                            url: "{{ route('guru.hapus') }}",
                            type: "POST",
                            data: {
                                _token: "{{ csrf_token() }}",
                                id: id
                            },
                            success: function(response) {
                                $('#loader').css('display', 'none');
                                if (response.status == 'success') {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Berhasil',
                                        text: response.message,
                                    }).then(() => {
                                        location.reload();
                                    });
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Gagal',
                                        text: response.message,
                                    });
                                }
                            },
                            error: function(xhr) {
                                $('#loader').css('display', 'none');
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'Terjadi kesalahan pada server.',
                                });
                            }
                        });
                    }
                });
            });

            $("#bt_tambah").click(function() {
                $('#loader').css('display', 'flex');
                $.ajax({
                    type: 'POST',
                    url: "{{ route('guru.store') }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function(hasil) {
                        $('#loader').css('display', 'none');
                        let url = "guru_edit/step1/" + hasil + "/t";

                        window.location.href = url;
                    }
                });
            });
        })
    </script>
@endpush
