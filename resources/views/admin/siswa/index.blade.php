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
                        <h6 class="card-subtitle text-muted">Daftar jurusan yang tersedia dan digunakan dalam sistem
                            akademik. Data jurusan menjadi dasar dalam pengelolaan siswa, penyusunan NIS, pembentukan
                            rombel, serta berbagai proses akademik lainnya. Pastikan informasi jurusan selalu diperbarui
                            sesuai nomenklatur yang berlaku.</h6>
                    </div>
                    <div class="card-body">
                        <table id="datatables-reponsive" class="table table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Kode</th>
                                    <th>Bid Keahlian</th>
                                    <th>Prog Keahlian</th>
                                    <th>Kons Keahlian</th>
                                    <th>Status</th>
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
            $("#bt_tambah").click(function() {
                Swal.fire({
                    title: 'Peringatan!',
                    text: "Fitur ini hanya digunakan saat fitur ambil data tidak berfungsi, pastikan data yang akan ditambahkan belum ada di database!",
                    icon: 'warning',
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, lanjutkan!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
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
                    }
                })
            });
        })
        // Your custom script here
    </script>
@endpush
