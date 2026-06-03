@extends('template')
@section('content')
    <div class="container-fluid p-0">
        <div class="row mb-2 mb-xl-3">
            <div class="col-auto d-none d-sm-block">
                <h3><strong>{{ $title }}</strong></h3>
            </div>
            <div class="col-auto ms-auto text-end mt-n1">
                <button class="btn btn-primary" id="btnTambah"><i class="fas fa-plus"></i> Tambah Jurusan</button>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">List Jurusan</h5>
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
        <div class="modal fade" id="centeredModalPrimary" tabindex="-1" role="dialog" aria-hidden="true"
            data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <form id="formJurusan" data-parsley-validate>
                        @csrf
                        <input type="hidden" name="id" id="id" value="">
                        <div class="modal-header">
                            <h5 class="modal-title"></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body m-2">
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Kode Nomenklatur</label>
                                    <input type="text" name="kode_nomenklatur" id="kode_nomenklatur" class="form-control"
                                        required>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Bidang Keahlian</label>
                                    <input type="text" name="bidang_keahlian" id="bidang_keahlian" class="form-control"
                                        required>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Program Keahlian</label>
                                    <input type="text" name="program_keahlian" id="program_keahlian" class="form-control"
                                        required>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Konsentrasi Keahlian</label>
                                    <input type="text" name="kons_keahlian" id="kons_keahlian" class="form-control"
                                        required>
                                </div>
                                <div class="mb-3 col-md-12">
                                    <label class="form-label">Deskripsi (Opsional)</label>
                                    <textarea class="form-control" name="deskripsi" id="deskripsi" cols="30" rows="5"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
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
                ajax: "{{ route('jurusan.data') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'kode_nomenklatur'
                    },
                    {
                        data: 'bidang_keahlian'
                    },
                    {
                        data: 'program_keahlian'
                    },
                    {
                        data: 'kons_keahlian'
                    },
                    {
                        data: 'stats'
                    },
                    {
                        data: 'action'
                    }
                ]
            });

            $('#btnTambah').click(function() {
                $('#centeredModalPrimary .modal-title').text('Tambah Jurusan');
                $('#formJurusan')[0].reset();
                $('#deskripsi').val('');
                $('#centeredModalPrimary').modal('show');
            });

            $('#datatables-reponsive').on("click", '.btnEdit', function() {
                let id = $(this).data('id');
                $.get("{{ route('jurusan.edit', ':id') }}".replace(':id', id), function(data) {
                    $('#id').val(data.id);
                    $('#kode_nomenklatur').val(data.kode_nomenklatur);
                    $('#bidang_keahlian').val(data.bidang_keahlian);
                    $('#program_keahlian').val(data.program_keahlian);
                    $('#kons_keahlian').val(data.kons_keahlian);
                    $('#deskripsi').val(data.deskripsi);
                    $('#centeredModalPrimary .modal-title').text('Edit Jurusan');
                    $('#centeredModalPrimary').modal('show');
                });
            });

            $('#formJurusan').on('submit', function(e) {
                e.preventDefault();
                let id = $('#id').val();
                let url = id ? "{{ route('jurusan.update') }}" : "{{ route('jurusan.simpan') }}";
                $(this).parsley().validate();
                if ($(this).parsley().isValid()) {
                    $('#loader').css('display', 'flex');
                    $('#centeredModalPrimary').modal('hide');
                    $.ajax({
                        type: "POST",
                        url: url,
                        data: $(this).serialize(),
                        success: function(response) {
                            if (response.status == 'success') {
                                $('#loader').css('display', 'none');
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
                            if (xhr.status === 422) {
                                let errors = xhr.responseJSON.errors;
                                let pesan = Object.values(errors).flat().join(
                                    '\n');
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Validasi Gagal',
                                    text: pesan
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'Terjadi kesalahan pada server.'
                                });
                            }
                        }
                    });
                }
            });
        });
    </script>
@endpush
