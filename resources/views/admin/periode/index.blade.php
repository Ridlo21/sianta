@extends('template')
@section('content')
    <div class="container-fluid p-0">
        <div class="row mb-2 mb-xl-3">
            <div class="col-auto d-none d-sm-block">
                <h3><strong>{{ $title }}</strong></h3>
            </div>
            <div class="col-auto ms-auto text-end mt-n1">
                <button class="btn btn-primary" id="btnTambah"><i class="fas fa-plus"></i> Tambah Periode</button>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">List Periode Akademik</h5>
                        <h6 class="card-subtitle text-muted">Daftar Periode Akademik yang digunakan dalam sistem. Buat atau
                            aktifkan periode baru setelah seluruh proses pembelajaran dan administrasi pada periode
                            sebelumnya telah selesai.</h6>
                    </div>
                    <div class="card-body">
                        <table id="datatables-reponsive" class="table table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Tahun Ajaran</th>
                                    <th>Semester</th>
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
    <div class="modal fade" id="centeredModalPrimary" tabindex="-1" role="dialog" aria-hidden="true"
        data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel">
        <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
            <div class="modal-content">
                <form id="formPeriode" data-parsley-validate>
                    @csrf
                    <input type="hidden" name="id" id="id" value="">
                    <div class="modal-header">
                        <h5 class="modal-title"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body m-2">
                        <div class="mb-3">
                            <label class="form-label">Mulai Tahun</label>
                            <select name="awal" id="awal" class="form-select" required>
                                <option value="">Mulai Tahun</option>
                                @for ($i = date('Y') - 1; $i < date('Y') + 1; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Berakhir Tahun</label>
                            <select name="akhir" id="akhir" class="form-select" required>
                                <option value="">Berakhir Tahun</option>
                                @for ($i = date('Y'); $i <= date('Y') + 1; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Semester</label>
                            <select name="semester" id="semester" class="form-select" required>
                                <option value="">Semester</option>
                                <option value="Ganjil">Ganjil</option>
                                <option value="Genap">Genap</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary">Simpan</button>
                    </div>
                </form>
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
                ajax: "{{ route('periode.data') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'tahun'
                    },
                    {
                        data: 'semester'
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
                Swal.fire({
                    title: 'Anda yakin?',
                    text: 'Tindakan ini akan menonaktifkan periode akademik yang sedang berjalan. Pastikan seluruh kegiatan pembelajaran, penilaian, dan administrasi akademik telah selesai. Setelah periode diakhiri, statusnya tidak dapat diaktifkan kembali.',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    cancelButtonText: 'Tidak',
                    confirmButtonText: 'Ya, Lanjutkan!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#centeredModalPrimary .modal-title').text('Tambah Periode');
                        $('#formPeriode')[0].reset();
                        $('#centeredModalPrimary').modal('show');
                    }
                });

            });

            $('#datatables-reponsive').on("click", '.btnEdit', function() {
                let id = $(this).data('id');
                $.get("{{ route('periode.edit', ':id') }}".replace(':id', id), function(data) {
                    $('#id').val(data.id);
                    $('#awal').val(data.awal);
                    $('#akhir').val(data.akhir);
                    $('#semester').val(data.semester);
                    $('#centeredModalPrimary .modal-title').text('Edit Periode');
                    $('#centeredModalPrimary').modal('show');
                });
            });

            $('#formPeriode').on('submit', function(e) {
                e.preventDefault();
                let id = $('#id').val();
                let url = id ? "{{ route('periode.update') }}" : "{{ route('periode.simpan') }}";
                $(this).parsley().validate();
                if ($(this).parsley().isValid()) {
                    let awal = parseInt($('#awal').val());
                    let akhir = parseInt($('#akhir').val());
                    if (akhir <= awal) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Perhatian',
                            text: 'Tahun akhir harus lebih besar dari tahun awal.'
                        });
                        return;
                    }
                    Swal.fire({
                        title: 'Anda yakin?',
                        text: 'Tindakan ini akan menonaktifkan periode akademik yang sedang berjalan. Pastikan seluruh kegiatan pembelajaran, penilaian, dan administrasi akademik telah selesai. Setelah periode diakhiri, statusnya tidak dapat diaktifkan kembali.',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        cancelButtonText: 'Tidak',
                        confirmButtonText: 'Ya, Lanjutkan!'
                    }).then((result) => {
                        if (result.isConfirmed) {
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
                }
            });
        })
    </script>
@endpush
