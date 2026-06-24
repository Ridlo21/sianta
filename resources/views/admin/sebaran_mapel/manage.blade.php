@extends('template')
@section('content')
    <div class="container-fluid p-0">
        <!-- Page Header -->
        <div class="row mb-3 mb-xl-3 align-items-center">
            <div class="col-auto">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-1">
                        <li class="breadcrumb-item"><a href="{{ route('sebaran-mapel') }}">Sebaran Mapel</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Kelola Pembelajaran</li>
                    </ol>
                </nav>
                <h3 class="mb-0 text-dark fw-bold"><strong>Kelola Pembelajaran: {{ $rombel->nama_rombel }}</strong></h3>
            </div>
            <div class="col-auto ms-auto text-end">
                <a href="{{ route('sebaran-mapel') }}" class="btn btn-outline-secondary shadow-sm">
                    <i class="align-middle me-1" data-feather="arrow-left"></i> Kembali
                </a>
            </div>
        </div>

        <div class="row">
            <!-- Left Info Panel -->
            <div class="col-lg-4 mb-4">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-bottom border-light py-3">
                        <h5 class="card-title mb-0 fw-bold">Informasi Kelas & Kurikulum</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3 d-flex align-items-center">
                            <div class="rombel-icon-box me-3">
                                <i data-feather="layers" class="text-primary" style="width: 20px; height: 20px;"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block lh-1">Rombel Pilihan</small>
                                <span class="fs-4 fw-extrabold text-dark mt-0.5 d-inline-block">{{ $rombel->nama_rombel }}</span>
                            </div>
                        </div>

                        <hr class="my-3 border-light">

                        <div class="row g-3">
                            <div class="col-6">
                                <small class="text-muted d-block">Tingkat Kelas</small>
                                <span class="fw-bold text-dark">Kelas {{ $rombel->kelas ? $rombel->kelas->nama_kelas : '-' }}</span>
                            </div>
                            <div class="col-6">
                                <small class="text-muted d-block">Tahun Ajaran</small>
                                <span class="fw-bold text-dark">{{ $tahun ? $tahun->tahun_ajaran : '-' }}</span>
                            </div>
                            <div class="col-12">
                                <small class="text-muted d-block">Konsentrasi Keahlian (Jurusan)</small>
                                <span class="fw-bold text-dark">{{ $rombel->jurusan ? $rombel->jurusan->kons_keahlian : 'Umum (Tanpa Jurusan)' }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-light-soft border-top border-light d-flex justify-content-between align-items-center py-3">
                        <span class="text-muted fw-semibold">Total Jam / Minggu:</span>
                        <span class="badge bg-primary text-white px-3 py-2 rounded-pill fw-bold fs-6" id="labelTotalJam">
                            {{ $totalHours }} Jam
                        </span>
                    </div>
                </div>
            </div>

            <!-- Right Subject Mapel List -->
            <div class="col-lg-8 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-bottom border-light py-3 d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0 fw-bold">Sebaran Mata Pelajaran Rombel</h5>
                        <button class="btn btn-sm btn-primary shadow-sm fw-bold" id="btnTambahMapel" {{ $availableMapels->isEmpty() ? 'disabled' : '' }}>
                            <i data-feather="plus" class="feather-sm me-1"></i> Tambah Mapel
                        </button>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0" id="tablePembelajaran">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 5%;">#</th>
                                        <th>Kode</th>
                                        <th>Mata Pelajaran</th>
                                        <th>Guru Pengampu (PTK)</th>
                                        <th>No. SK / Tgl SK</th>
                                        <th style="width: 10%;" class="text-center">Jam</th>
                                        <th style="width: 15%;" class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $globalIdx = 1; @endphp
                                    @forelse($groupedPembelajaran as $kelompokName => $list)
                                        <tr class="table-light table-group-header">
                                            <td colspan="7" class="fw-bold text-primary bg-light-soft py-2 px-3">
                                                <i data-feather="grid" class="feather-sm align-middle me-1"></i> Kelompok: {{ $kelompokName }}
                                                <span class="badge bg-primary-soft text-primary ms-2 rounded-pill small fw-normal">
                                                    {{ count($list) }} Mapel
                                                </span>
                                            </td>
                                        </tr>
                                        @foreach($list as $p)
                                            <tr>
                                                <td>{{ $globalIdx++ }}</td>
                                                <td><span class="text-monospace small">{{ $p->mataPelajaran->kode_mapel }}</span></td>
                                                <td><strong class="text-dark">{{ $p->mataPelajaran->nama_mapel }}</strong></td>
                                                <td>
                                                    @if($p->guru)
                                                        <strong class="text-secondary">{{ $p->guru->nama_lengkap }}</strong>
                                                        @if($p->guru->niy)
                                                            <small class="text-muted d-block">NIY. {{ $p->guru->niy }}</small>
                                                        @endif
                                                    @else
                                                        <span class="text-danger small fw-semibold"><i data-feather="alert-triangle" class="feather-sm me-0.5"></i> Belum Ditentukan</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($p->sk_mengajar)
                                                        <span class="d-block small text-dark">{{ $p->sk_mengajar }}</span>
                                                        @if($p->tanggal_sk)
                                                            <small class="text-muted d-block">{{ date('d M Y', strtotime($p->tanggal_sk)) }}</small>
                                                        @endif
                                                    @else
                                                        <span class="text-muted small">-</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <span class="badge bg-success-soft text-success fw-bold px-2 py-1 fs-6">
                                                        {{ $p->jam_mengajar }} Jam
                                                    </span>
                                                </td>
                                                <td class="text-center">
                                                    <div class="d-flex gap-1 justify-content-center">
                                                        <button class="btn btn-warning btn-sm btnEditPembelajaran" data-id="{{ $p->id }}" title="Edit Pembelajaran">
                                                            <i class="fas fa-pencil-alt"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-danger btn-sm btnHapusPembelajaran" data-id="{{ $p->id }}" title="Hapus Mapel dari Rombel">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center py-5 text-muted">
                                                <div class="mb-3">
                                                    <i data-feather="book" style="width: 48px; height: 48px;" class="text-secondary opacity-50"></i>
                                                </div>
                                                <h5>Belum Ada Mata Pelajaran</h5>
                                                <p class="small text-muted mb-0">Rombel ini belum memiliki sebaran mata pelajaran untuk tahun ajaran aktif.</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Pembelajaran Mapel -->
    <div class="modal fade" id="modalPembelajaran" tabindex="-1" role="dialog" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content border-0 shadow-lg">
                <form id="formPembelajaran" data-parsley-validate>
                    @csrf
                    <input type="hidden" name="rombel_id" value="{{ $rombel->id }}">
                    <div class="modal-header bg-primary text-white border-0 py-3">
                        <h5 class="modal-title text-white fw-bold">Tambah Mata Pelajaran ke Rombel</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Pilih Mata Pelajaran</label>
                            <select name="mapel_id" id="mapel_id" class="form-select select2-modal" required style="width: 100%;">
                                <option value="" disabled selected>Pilih Mapel...</option>
                                @foreach($availableMapels->groupBy('kelompok') as $groupName => $mapelsInGroup)
                                    <optgroup label="Kelompok {{ $groupName }}">
                                        @foreach($mapelsInGroup as $m)
                                            <option value="{{ $m->id }}">
                                                {{ $m->kode_mapel }} - {{ $m->nama_mapel }}
                                            </option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Pilih Guru Pengampu (PTK)</label>
                            <select name="guru_id" id="guru_id" class="form-select select2-modal" style="width: 100%;">
                                <option value="" selected>Belum Ditentukan (Kosongkan)</option>
                                @foreach($gurus as $g)
                                    <option value="{{ $g->id }}">
                                        {{ $g->nama_lengkap }} (NIY. {{ $g->niy ?? '-' }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label class="form-label fw-semibold">Alokasi Jam Mengajar</label>
                                <input type="number" name="jam_mengajar" id="jam_mengajar" class="form-control" min="0" max="48" value="2" required>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label fw-semibold">Tanggal SK Mengajar</label>
                                <input type="date" name="tanggal_sk" id="tanggal_sk" class="form-control">
                            </div>
                            <div class="mb-3 col-md-12">
                                <label class="form-label fw-semibold">Nomor SK Mengajar</label>
                                <input type="text" name="sk_mengajar" id="sk_mengajar" class="form-control" placeholder="Contoh: SK/12/2026">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-top-0 p-3 bg-light rounded-bottom d-flex justify-content-end gap-2">
                        <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary px-4">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit Pembelajaran Mapel -->
    <div class="modal fade" id="modalEditPembelajaran" tabindex="-1" role="dialog" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content border-0 shadow-lg">
                <form id="formEditPembelajaran" data-parsley-validate>
                    @csrf
                    <input type="hidden" name="id" id="edit_id" value="">
                    <div class="modal-header bg-primary text-white border-0 py-3">
                        <h5 class="modal-title text-white fw-bold">Edit Pembelajaran Rombel</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="mb-3 bg-light-soft p-3 rounded border border-light">
                            <small class="text-muted d-block">Mata Pelajaran</small>
                            <span class="fw-bold text-dark fs-5" id="edit_label_mapel">-</span>
                            <small class="text-muted d-block mt-0.5" id="edit_label_kode">-</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Pilih Guru Pengampu (PTK)</label>
                            <select name="guru_id" id="edit_guru_id" class="form-select select2-modal-edit" style="width: 100%;">
                                <option value="" selected>Belum Ditentukan (Kosongkan)</option>
                                @foreach($gurus as $g)
                                    <option value="{{ $g->id }}">
                                        {{ $g->nama_lengkap }} (NIY. {{ $g->niy ?? '-' }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label class="form-label fw-semibold">Alokasi Jam Mengajar</label>
                                <input type="number" name="jam_mengajar" id="edit_jam_mengajar" class="form-control" min="0" max="48" required>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label fw-semibold">Tanggal SK Mengajar</label>
                                <input type="date" name="edit_tanggal_sk" id="edit_tanggal_sk" class="form-control">
                            </div>
                            <div class="mb-3 col-md-12">
                                <label class="form-label fw-semibold">Nomor SK Mengajar</label>
                                <input type="text" name="edit_sk_mengajar" id="edit_sk_mengajar" class="form-control" placeholder="Contoh: SK/12/2026">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-top-0 p-3 bg-light rounded-bottom d-flex justify-content-end gap-2">
                        <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary px-4">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        .rombel-icon-box {
            width: 44px;
            height: 44px;
            background-color: rgba(59, 125, 221, 0.08);
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
        }
        .bg-light-soft {
            background-color: #f7f9fa;
        }
        .bg-primary-soft {
            background-color: rgba(59, 125, 221, 0.1) !important;
            color: #3b7ddd !important;
        }
        .bg-success-soft {
            background-color: rgba(28, 187, 140, 0.1) !important;
            color: #1cbb8c !important;
        }
        .table-group-header td {
            background-color: #f8f9fa !important;
            border-top: 1px solid #e9ecef !important;
            border-bottom: 1px solid #e9ecef !important;
        }
        .table-responsive {
            overflow-x: visible !important;
        }
    </style>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Open Tambah Modal
            $('#btnTambahMapel').click(function() {
                $('#formPembelajaran')[0].reset();
                $('#mapel_id').val('').trigger('change');
                $('#guru_id').val('').trigger('change');
                $('#modalPembelajaran').modal('show');
                
                // Init select2 inside modal
                setTimeout(function() {
                    $('.select2-modal').select2({
                        dropdownParent: $('#modalPembelajaran')
                    });
                }, 200);
            });

            // Form Submit Tambah Sebaran Mapel
            $('#formPembelajaran').on('submit', function(e) {
                e.preventDefault();
                $(this).parsley().validate();
                if ($(this).parsley().isValid()) {
                    $('#loader').css('display', 'flex');
                    $('#modalPembelajaran').modal('hide');

                    $.ajax({
                        type: "POST",
                        url: "{{ route('sebaran-mapel.simpan') }}",
                        data: $(this).serialize(),
                        success: function(response) {
                            $('#loader').css('display', 'none');
                            if (response.status === 'success') {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: response.message
                                }).then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal',
                                    text: response.message
                                }).then(() => {
                                    $('#modalPembelajaran').modal('show');
                                });
                            }
                        },
                        error: function(xhr) {
                            $('#loader').css('display', 'none');
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Terjadi kesalahan pada server saat menambahkan mata pelajaran.'
                            }).then(() => {
                                $('#modalPembelajaran').modal('show');
                            });
                        }
                    });
                }
            });

            // Open Edit Modal & load data
            $('#tablePembelajaran').on('click', '.btnEditPembelajaran', function() {
                let id = $(this).data('id');
                $('#loader').css('display', 'flex');
                
                $.get("{{ route('sebaran-mapel.edit', ':id') }}".replace(':id', id), function(data) {
                    $('#loader').css('display', 'none');
                    
                    $('#edit_id').val(data.id);
                    $('#edit_label_mapel').text(data.mata_pelajaran ? data.mata_pelajaran.nama_mapel : '-');
                    $('#edit_label_kode').text('Kode: ' + (data.mata_pelajaran ? data.mata_pelajaran.kode_mapel : '-'));
                    
                    $('#edit_guru_id').val(data.guru_id).trigger('change');
                    $('#edit_jam_mengajar').val(data.jam_mengajar);
                    $('#edit_tanggal_sk').val(data.tanggal_sk);
                    $('#edit_sk_mengajar').val(data.sk_mengajar);
                    
                    $('#modalEditPembelajaran').modal('show');
                    
                    // Init select2 inside edit modal
                    setTimeout(function() {
                        $('.select2-modal-edit').select2({
                            dropdownParent: $('#modalEditPembelajaran')
                        });
                    }, 200);
                });
            });

            // Form Submit Update Sebaran Mapel
            $('#formEditPembelajaran').on('submit', function(e) {
                e.preventDefault();
                $(this).parsley().validate();
                if ($(this).parsley().isValid()) {
                    $('#loader').css('display', 'flex');
                    $('#modalEditPembelajaran').modal('hide');

                    // Map named fields correctly
                    let dataString = {
                        _token: "{{ csrf_token() }}",
                        id: $('#edit_id').val(),
                        guru_id: $('#edit_guru_id').val(),
                        jam_mengajar: $('#edit_jam_mengajar').val(),
                        tanggal_sk: $('#edit_tanggal_sk').val(),
                        sk_mengajar: $('#edit_sk_mengajar').val()
                    };

                    $.ajax({
                        type: "POST",
                        url: "{{ route('sebaran-mapel.update') }}",
                        data: dataString,
                        success: function(response) {
                            $('#loader').css('display', 'none');
                            if (response.status === 'success') {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: response.message
                                }).then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal',
                                    text: response.message
                                }).then(() => {
                                    $('#modalEditPembelajaran').modal('show');
                                });
                            }
                        },
                        error: function(xhr) {
                            $('#loader').css('display', 'none');
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Terjadi kesalahan pada server saat memperbarui sebaran mapel.'
                            }).then(() => {
                                $('#modalEditPembelajaran').modal('show');
                            });
                        }
                    });
                }
            });

            // Hapus Sebaran Mapel Action
            $('#tablePembelajaran').on('click', '.btnHapusPembelajaran', function() {
                let id = $(this).data('id');
                
                Swal.fire({
                    title: 'Hapus Mata Pelajaran dari Rombel?',
                    text: 'Ini akan menghapus distribusi mata pelajaran ini pada rombel aktif.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#loader').css('display', 'flex');
                        $.ajax({
                            type: "POST",
                            url: "{{ route('sebaran-mapel.hapus') }}",
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
                                        text: response.message
                                    }).then(() => {
                                        location.reload();
                                    });
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Gagal',
                                        text: response.message
                                    });
                                }
                            },
                            error: function(xhr) {
                                $('#loader').css('display', 'none');
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'Terjadi kesalahan pada server saat menghapus mata pelajaran.'
                                });
                            }
                        });
                    }
                });
            });
        });
    </script>
@endpush
