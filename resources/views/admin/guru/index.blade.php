@extends('template')
@section('content')
    <div class="container-fluid p-0">
        <div class="row mb-2 mb-xl-3">
            <div class="col-auto d-none d-sm-block">
                <h3><strong>{{ $title }}</strong></h3>
            </div>
            <div class="col-auto ms-auto text-end mt-n1">
                <button class="btn btn-primary" id="bt_tambah"><i class="fas fa-plus"></i> Tambah Guru</button>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">List Guru</h5>
                        <h6 class="card-subtitle text-muted">Daftar guru yang terdaftar dan aktif dalam sistem akademik.
                            Data guru digunakan sebagai dasar pengelolaan tenaga pendidik, pembagian tugas mengajar,
                            penjadwalan pelajaran, penetapan wali kelas, serta berbagai proses administrasi dan akademik
                            lainnya. Pastikan data guru selalu diperbarui sesuai dengan kondisi dan penugasan yang berlaku.
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
