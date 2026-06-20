@extends('template')
@section('content')
    <div class="container-fluid p-0">
        <div class="row mb-2 mb-xl-3 align-items-center">
            <div class="col-auto d-none d-sm-block">
                <h3 class="mb-0 text-dark fw-bold"><strong>{{ $title }}</strong></h3>
            </div>
            <div class="col-auto ms-auto text-end">
                <button class="btn btn-primary shadow-sm" id="btnTambah">
                    <i class="fas fa-plus me-1"></i> Tambah Mata Pelajaran
                </button>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-bottom border-light">
                        <h5 class="card-title mb-0 fw-bold">Daftar Mata Pelajaran</h5>
                        <h6 class="card-subtitle text-muted mt-1">Daftar seluruh mata pelajaran yang diajarkan. Data ini digunakan untuk menyusun sebaran pembelajaran serta penilaian raport siswa.</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="datatables-responsive" class="table table-striped table-hover align-middle" style="width:100%">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 5%;">#</th>
                                        <th style="width: 15%;">Kode Mapel</th>
                                        <th>Nama Mata Pelajaran</th>
                                        <th style="width: 20%;">Kelompok</th>
                                        <th style="width: 15%;">Status</th>
                                        <th style="width: 15%;">Aksi</th>
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

        <!-- Modal Form -->
        <div class="modal fade" id="modalMapel" tabindex="-1" role="dialog" aria-hidden="true"
            data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <form id="formMapel" data-parsley-validate>
                        @csrf
                        <input type="hidden" name="id" id="id" value="">
                        <div class="modal-header">
                            <h5 class="modal-title fw-bold">Tambah Mata Pelajaran</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body m-2">
                            <div class="row">
                                <div class="mb-3 col-md-12">
                                    <label class="form-label fw-semibold">Kode Mata Pelajaran</label>
                                    <input type="text" name="kode_mapel" id="kode_mapel" class="form-control" placeholder="Contoh: 300110000" required>
                                </div>
                                <div class="mb-3 col-md-12">
                                    <label class="form-label fw-semibold">Nama Mata Pelajaran</label>
                                    <input type="text" name="nama_mapel" id="nama_mapel" class="form-control" placeholder="Contoh: Bahasa Indonesia" required>
                                </div>
                                <div class="mb-3 col-md-12">
                                    <label class="form-label fw-semibold">Kelompok</label>
                                    <select name="kelompok" id="kelompok" class="form-select select2-modal" required>
                                        <option value="" disabled selected>Pilih Kelompok...</option>
                                        <option value="Umum">Umum</option>
                                        <option value="Kejuruan">Kejuruan</option>
                                        <option value="Pilihan">Pilihan</option>
                                        <option value="Muatan Lokal">Muatan Lokal</option>
                                        <option value="Tambahan">Tambahan</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
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
            // Init DataTable
            const table = $('#datatables-responsive').DataTable({
                paging: true,
                lengthChange: false,
                searching: true,
                ordering: false,
                info: true,
                autoWidth: false,
                responsive: true,
                processing: true,
                serverSide: true,
                ajax: "{{ route('mapel.data') }}",
                columns: [
                    { data: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'kode_mapel' },
                    { data: 'nama_mapel' },
                    { data: 'kelompok' },
                    { data: 'stats' },
                    { data: 'action', orderable: false, searchable: false }
                ]
            });

            // Tambah Button
            $('#btnTambah').click(function() {
                $('#formMapel')[0].reset();
                $('#id').val('');
                $('#modalMapel .modal-title').text('Tambah Mata Pelajaran');
                $('#modalMapel').modal('show');
            });

            // Edit Button Click
            $('#datatables-responsive').on("click", '.btnEdit', function() {
                let id = $(this).data('id');
                $.get("{{ route('mapel.edit', ':id') }}".replace(':id', id), function(data) {
                    $('#id').val(data.id);
                    $('#kode_mapel').val(data.kode_mapel);
                    $('#nama_mapel').val(data.nama_mapel);
                    $('#kelompok').val(data.kelompok).trigger('change');
                    $('#modalMapel .modal-title').text('Edit Mata Pelajaran');
                    $('#modalMapel').modal('show');
                });
            });

            // Form Submit (Save / Update)
            $('#formMapel').on('submit', function(e) {
                e.preventDefault();
                let id = $('#id').val();
                let url = id ? "{{ route('mapel.update') }}" : "{{ route('mapel.simpan') }}";
                
                $(this).parsley().validate();
                if ($(this).parsley().isValid()) {
                    $('#loader').css('display', 'flex');
                    $('#modalMapel').modal('hide');
                    
                    $.ajax({
                        type: "POST",
                        url: url,
                        data: $(this).serialize(),
                        success: function(response) {
                            $('#loader').css('display', 'none');
                            if (response.status == 'success') {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: response.message,
                                }).then(() => {
                                    table.ajax.reload();
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal',
                                    text: response.message,
                                }).then(() => {
                                    $('#modalMapel').modal('show');
                                });
                            }
                        },
                        error: function(xhr) {
                            $('#loader').css('display', 'none');
                            if (xhr.status === 422) {
                                let errors = xhr.responseJSON.errors;
                                let pesan = Object.values(errors).flat().join('\n');
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Validasi Gagal',
                                    text: pesan
                                }).then(() => {
                                    $('#modalMapel').modal('show');
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'Terjadi kesalahan pada server.'
                                }).then(() => {
                                    $('#modalMapel').modal('show');
                                });
                            }
                        }
                    });
                }
            });

            // Delete Button Click
            $('#datatables-responsive').on("click", '.btnHapus', function() {
                let id = $(this).data('id');
                
                Swal.fire({
                    title: 'Anda yakin?',
                    text: 'Mata pelajaran ini akan dinonaktifkan dari sistem.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Nonaktifkan!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#loader').css('display', 'flex');
                        $.ajax({
                            type: "POST",
                            url: "{{ route('mapel.hapus') }}",
                            data: {
                                _token: "{{ csrf_token() }}",
                                id: id
                            },
                            success: function(response) {
                                $('#loader').css('display', 'none');
                                if (response.status === 'success') {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Berhasil',
                                        text: response.message,
                                    }).then(() => {
                                        table.ajax.reload();
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
                                    text: 'Terjadi kesalahan pada server saat menghapus data.'
                                });
                            }
                        });
                    }
                });
            });
        });
    </script>
@endpush
