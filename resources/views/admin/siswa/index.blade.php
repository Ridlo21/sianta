@extends('template')
@section('content')
    <div class="container-fluid p-0">
        <div class="row mb-2 mb-xl-3">
            <div class="col-auto d-none d-sm-block">
                <h3><strong>{{ $title }}</strong></h3>
            </div>
            <div class="col-auto ms-auto text-end mt-n1">
                <button class="btn btn-primary" id="bt_tambah"><i class="fas fa-plus"></i> Tambah Siswa</button>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">List Siswa</h5>
                        <h6 class="card-subtitle text-muted">Daftar siswa aktif yang terdaftar dalam sistem akademik. Data
                            siswa digunakan sebagai dasar pengelolaan administrasi, penempatan rombel, penyusunan NIS, dan
                            berbagai proses akademik lainnya.</h6>
                    </div>
                    <div class="card-body">
                        <table id="datatables-reponsive" class="table table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>NIS</th>
                                    <th>NISN</th>
                                    <th>Nama Lengkap</th>
                                    <th>Asal Sekolah</th>
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
                lengthChange: false,
                searching: true,
                ordering: false,
                info: true,
                autoWidth: false,
                responsive: true,
                processing: true,
                serverSide: true,
                ajax: "{{ route('siswa.data') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'nis'
                    },
                    {
                        data: 'nisn'
                    },
                    {
                        data: 'nama'
                    },
                    {
                        data: 'asal_sekolah'
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
                            url: "{{ route('siswa.hapus') }}",
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
                    url: "{{ route('siswa.store') }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function(hasil) {
                        $('#loader').css('display', 'none');
                        let url = "siswa_edit/step1/" + hasil + "/t";

                        window.location.href = url;
                    }
                });
            });
        })
        // Your custom script here
    </script>
@endpush
