@extends('template')
@section('content')
    <div class="container-fluid p-0">
        <!-- Breadcrumb & Page Header -->
        <div class="row mb-3 mb-xl-3 align-items-center">
            <div class="col-auto">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-1">
                        <li class="breadcrumb-item"><a href="{{ route('rombel') }}">Rombel</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Detail Rombel</li>
                    </ol>
                </nav>
                <h3 class="mb-0 text-dark fw-bold"><strong>Kelola Rombel: {{ $rombel->nama_rombel }}</strong></h3>
            </div>
            <div class="col-auto ms-auto text-end">
                <a href="{{ route('rombel') }}" class="btn btn-outline-secondary shadow-sm">
                    <i class="align-middle me-1" data-feather="arrow-left"></i> Kembali
                </a>
            </div>
        </div>

        <div class="row">
            <!-- Left Column: Rombel & Wali Kelas Info -->
            <div class="col-xl-4 col-lg-5 mb-4">
                <!-- Rombel Detail Card -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-bottom border-light py-3">
                        <h5 class="card-title mb-0 fw-bold">Informasi Rombel</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3 d-flex align-items-center">
                            <div class="rombel-icon-box me-3">
                                @if(strpos(strtolower($rombel->nama_rombel), 'pplg') !== false || ($rombel->jurusan && strpos(strtolower($rombel->jurusan->program_keahlian), 'pplg') !== false))
                                    <i data-feather="code" class="text-info" style="width: 20px; height: 20px;"></i>
                                @elseif(strpos(strtolower($rombel->nama_rombel), 'akl') !== false || ($rombel->jurusan && strpos(strtolower($rombel->jurusan->program_keahlian), 'akl') !== false))
                                    <i data-feather="dollar-sign" class="text-success" style="width: 20px; height: 20px;"></i>
                                @else
                                    <i data-feather="book-open" class="text-primary" style="width: 20px; height: 20px;"></i>
                                @endif
                            </div>
                            <div>
                                <small class="text-muted d-block lh-1">Nama Kelompok Belajar</small>
                                <span class="fs-4 fw-extrabold text-dark mt-0.5 d-inline-block">{{ $rombel->nama_rombel }}</span>
                            </div>
                        </div>

                        <hr class="my-3 border-light">

                        <div class="row g-3">
                            <div class="col-6">
                                <small class="text-muted d-block">Tingkat Kelas</small>
                                <span class="fw-bold text-dark fs-5">Kelas {{ $rombel->kelas ? $rombel->kelas->nama_kelas : '-' }}</span>
                            </div>
                            <div class="col-6">
                                <small class="text-muted d-block">Tahun Ajaran</small>
                                <span class="fw-bold text-dark fs-5">{{ $tahun ? $tahun->tahun_ajaran : '-' }}</span>
                            </div>
                            <div class="col-12">
                                <small class="text-muted d-block">Program Keahlian (Jurusan)</small>
                                <span class="fw-bold text-dark fs-6">{{ $rombel->jurusan ? $rombel->jurusan->program_keahlian : 'Umum (Tanpa Jurusan)' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Wali Kelas Card -->
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-bottom border-light py-3 d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0 fw-bold">Wali Rombel (Wali Kelas)</h5>
                        <button class="btn btn-sm btn-primary-soft" id="btnUbahWali">
                            <i data-feather="edit-2" class="feather-sm"></i> Atur Wali
                        </button>
                    </div>
                    <div class="card-body text-center py-4">
                        @if($activeWali && $activeWali->guru)
                            <div class="mb-3 position-relative d-inline-block">
                                <img src="{{ $activeWali->guru->foto ? asset('gambar_berkas/avatars/' . $activeWali->guru->foto) : asset('asset_admin/img/avatars/avatar.png') }}"
                                    class="img-fluid rounded-circle border border-primary border-3 shadow-xs" 
                                    style="width: 100px; height: 100px; object-fit: cover;" 
                                    alt="{{ $activeWali->guru->nama_lengkap }}" />
                            </div>
                            <h4 class="fw-extrabold text-dark mb-1">{{ $activeWali->guru->nama_lengkap }}</h4>
                            <p class="text-muted small mb-0">NIY: {{ $activeWali->guru->niy ?? '-' }}</p>
                            <span class="badge bg-success-light text-success fw-bold px-3 py-1.5 rounded-pill mt-2">Aktif Jabatan</span>
                        @else
                            <div class="py-4">
                                <div class="text-muted mb-3">
                                    <i data-feather="user-x" style="width: 48px; height: 48px;" class="text-secondary opacity-50"></i>
                                </div>
                                <h5 class="fw-bold text-secondary">Belum Ada Wali Kelas</h5>
                                <p class="text-muted small px-3">Tahun ajaran berjalan belum menetapkan Wali Rombel untuk kelompok ini.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Right Column: Student List & Transfer Operations -->
            <div class="col-xl-8 col-lg-7 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white border-bottom border-light py-3">
                        <div class="row align-items-center">
                            <div class="col">
                                <h5 class="card-title mb-0 fw-bold">Daftar Siswa Rombel</h5>
                            </div>
                            <div class="col-auto text-end d-flex gap-2">
                                <a href="{{ route('rombel.print', $rombel->id) }}" target="_blank" class="btn btn-sm btn-success shadow-sm fw-bold">
                                    <i data-feather="printer" class="feather-sm me-1"></i> Cetak PDF
                                </a>
                                <button class="btn btn-sm btn-primary shadow-sm fw-bold" id="btnTambahSiswa">
                                    <i data-feather="user-plus" class="feather-sm"></i> Tambah Siswa
                                </button>
                                <span class="badge bg-primary-soft text-primary px-3 py-2 rounded-pill fw-bold fs-6">
                                    {{ count($students) }} Siswa
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Transfer Panel (Hidden by default, shown when items checked) -->
                    <div id="transferPanel" class="bg-light-soft border-bottom border-light px-4 py-3 align-items-center justify-content-between d-none transition-all">
                        <div class="d-flex align-items-center mb-2 mb-md-0">
                            <i data-feather="info" class="text-primary me-2 feather-md"></i>
                            <div>
                                <span class="fw-bold text-dark fs-5" id="checkedCount">0</span>
                                <span class="text-muted">Siswa terpilih untuk dipindahkan</span>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-2 flex-wrap flex-md-nowrap">
                            <label class="form-label mb-0 fw-bold text-muted text-nowrap">Rombel Tujuan:</label>
                            <select id="target_rombel_id" class="form-select select2" style="width: 250px;">
                                <option value="" disabled selected>Pilih Rombel...</option>
                                @foreach($otherRombels->groupBy('kelas.nama_kelas') as $kelasName => $rombelsInKelas)
                                    <optgroup label="Tingkat Kelas {{ $kelasName }}">
                                        @foreach($rombelsInKelas as $r)
                                            <option value="{{ $r->id }}">
                                                {{ $r->nama_rombel }} ({{ $r->jurusan ? $r->jurusan->kons_keahlian : 'Umum' }})
                                            </option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            </select>
                            <button class="btn btn-primary text-nowrap fw-bold shadow-sm" id="btnPindahSiswa">
                                <i data-feather="corner-down-right" class="feather-sm me-1"></i> Pindahkan
                            </button>
                        </div>
                    </div>

                    <div class="card-body py-3">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover align-middle" id="tableRombelSiswa" style="width: 100%;">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 5%;" class="text-center">
                                            <input type="checkbox" class="form-check-input" id="checkAll">
                                        </th>
                                        <th style="width: 5%;">#</th>
                                        <th>NIS</th>
                                        <th>NISN</th>
                                        <th>Nama Lengkap</th>
                                        <th>L/P</th>
                                        <th class="text-center">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($students as $idx => $s)
                                        <tr>
                                            <td class="text-center">
                                                <input type="checkbox" class="form-check-input check-student" value="{{ $s->id_person }}">
                                            </td>
                                            <td>{{ $idx + 1 }}</td>
                                            <td>{{ $s->nis ?? '-' }}</td>
                                            <td>{{ $s->nisn ?? '-' }}</td>
                                            <td><strong class="text-dark">{{ $s->nama }}</strong></td>
                                            <td>{{ $s->jenis_kelamin == 'Laki-Laki' ? 'L' : 'P' }}</td>
                                            <td class="text-center">
                                                <span class="badge bg-success-light text-success fw-bold">Aktif</span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center py-5 text-muted">
                                                <div class="mb-3">
                                                    <i data-feather="users" style="width: 48px; height: 48px;" class="text-secondary opacity-50"></i>
                                                </div>
                                                <h5>Belum Ada Anggota Siswa</h5>
                                                <p class="small text-muted mb-0">Rombel ini masih kosong atau penempatan belum diatur.</p>
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

    <!-- Modal Tambah Siswa Baru (Opsi 1) -->
    <div class="modal fade" id="modalTambahSiswa" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content border-0 shadow-lg">
                <form id="formTambahSiswa">
                    @csrf
                    <input type="hidden" name="rombel_id" value="{{ $rombel->id }}">
                    <div class="modal-header bg-primary text-white border-0 py-3">
                        <h5 class="modal-title text-white fw-bold">Tambah Siswa Baru ke Rombel</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4">
                        <p class="text-muted mb-3">Menampilkan siswa aktif dengan jurusan yang sesuai yang belum terdaftar di Rombel manapun untuk tahun ajaran aktif berjalan.</p>
                        <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                            <table class="table table-hover table-striped align-middle" id="tableUnassignedSiswa" style="width: 100%;">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 5%;" class="text-center">
                                            <input type="checkbox" class="form-check-input" id="checkAllUnassigned">
                                        </th>
                                        <th>NIS</th>
                                        <th>Nama Lengkap</th>
                                        <th>L/P</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($unassignedStudents as $s)
                                        <tr>
                                            <td class="text-center">
                                                <input type="checkbox" class="form-check-input check-unassigned" name="siswa_ids[]" value="{{ $s->id_person }}">
                                            </td>
                                            <td>{{ $s->nis ?? '-' }}</td>
                                            <td><strong class="text-dark">{{ $s->nama }}</strong></td>
                                            <td>{{ $s->jenis_kelamin == 'Laki-Laki' ? 'L' : 'P' }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center py-4 text-muted">
                                                Tidak ada siswa aktif tanpa rombel saat ini.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer border-top-0 p-3 bg-light rounded-bottom d-flex justify-content-end gap-2">
                        <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary px-4" id="btnSubmitTambahSiswa" {{ $unassignedStudents->isEmpty() ? 'disabled' : '' }}>
                            Tambah Terpilih
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Atur Wali Kelas -->
    <div class="modal fade" id="modalWali" tabindex="-1" role="dialog" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content border-0 shadow-lg">
                <form id="formWali" data-parsley-validate>
                    @csrf
                    <input type="hidden" name="rombel_id" value="{{ $rombel->id }}">
                    <div class="modal-header bg-primary text-white border-0 py-3">
                        <h5 class="modal-title text-white fw-bold">Atur Wali Kelas</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Pilih Guru sebagai Wali Kelas</label>
                            <select name="guru_id" id="guru_id" class="form-select select2-modal" required>
                                <option value="" disabled selected>Pilih Guru...</option>
                                @foreach($gurus as $g)
                                    <option value="{{ $g->id }}" {{ $activeWali && $activeWali->guru_id == $g->id ? 'selected' : '' }}>
                                        {{ $g->nama_lengkap }} (NIY: {{ $g->niy ?? '-' }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer border-top-0 p-3 bg-light rounded-bottom d-flex justify-content-end gap-2">
                        <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary px-4">Simpan Wali</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        .rombel-icon-box {
            width: 44px;
            height: 44px;
            background-color: rgba(99, 102, 241, 0.08);
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
        }
        .bg-light-soft {
            background-color: #f7f9fa;
        }
        .bg-primary-soft {
            background-color: rgba(99, 102, 241, 0.1) !important;
            color: #4f46e5 !important;
        }
        .btn-primary-soft {
            background-color: rgba(99, 102, 241, 0.08);
            color: #4f46e5;
            border: none;
            transition: all 0.2s ease;
        }
        .btn-primary-soft:hover {
            background-color: #4f46e5;
            color: #fff;
        }
        .table-responsive {
            overflow-x: visible !important;
        }
        #transferPanel {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
    </style>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Initialize Select2 in main page
            $('.select2').select2({
                dropdownParent: $('#transferPanel'),
                placeholder: "Pilih Rombel...",
                allowClear: true
            });

            // Initialize Select2 in modal
            $('#btnUbahWali').click(function() {
                $('#modalWali').modal('show');
                // Re-initialize select2 for modal after open
                setTimeout(function() {
                    $('.select2-modal').select2({
                        dropdownParent: $('#modalWali'),
                        placeholder: "Pilih Guru..."
                    });
                }, 200);
            });

            // Checkbox Actions
            $('#checkAll').change(function() {
                let checked = $(this).prop('checked');
                $('.check-student').prop('checked', checked);
                updateTransferPanel();
            });

            $(document).on('change', '.check-student', function() {
                updateTransferPanel();
                // update checkAll state
                let total = $('.check-student').length;
                let checked = $('.check-student:checked').length;
                $('#checkAll').prop('checked', total === checked);
            });

            function updateTransferPanel() {
                let checkedCount = $('.check-student:checked').length;
                if (checkedCount > 0) {
                    $('#checkedCount').text(checkedCount);
                    $('#transferPanel').removeClass('d-none').addClass('d-flex');
                } else {
                    $('#transferPanel').removeClass('d-flex').addClass('d-none');
                }
            }

            // Save Wali Kelas Action
            $('#formWali').on('submit', function(e) {
                e.preventDefault();
                $(this).parsley().validate();
                if ($(this).parsley().isValid()) {
                    $('#loader').css('display', 'flex');
                    $('#modalWali').modal('hide');
                    
                    $.ajax({
                        type: "POST",
                        url: "{{ route('rombel.set-wali') }}",
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
                                });
                            }
                        },
                        error: function(xhr) {
                            $('#loader').css('display', 'none');
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Terjadi kesalahan pada server.'
                            });
                        }
                    });
                }
            });

            // Transfer Students Action
            $('#btnPindahSiswa').click(function() {
                let targetRombelId = $('#target_rombel_id').val();
                if (!targetRombelId) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Validasi Gagal',
                        text: 'Silakan pilih Rombel Tujuan terlebih dahulu.'
                    });
                    return;
                }

                let targetRombelText = $('#target_rombel_id option:selected').text().trim();
                let studentIds = [];
                $('.check-student:checked').each(function() {
                    studentIds.push($(this).val());
                });

                Swal.fire({
                    title: 'Konfirmasi Pemindahan',
                    text: 'Apakah Anda yakin ingin memindahkan ' + studentIds.length + ' siswa terpilih ke ' + targetRombelText + '?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Pindahkan!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#loader').css('display', 'flex');
                        $.ajax({
                            type: "POST",
                            url: "{{ route('rombel.pindah-siswa') }}",
                            data: {
                                _token: "{{ csrf_token() }}",
                                siswa_ids: studentIds,
                                target_rombel_id: targetRombelId,
                                source_rombel_id: "{{ $rombel->id }}"
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
                                    text: 'Terjadi kesalahan pada server saat memindahkan siswa.'
                                });
                            }
                        });
                    }
                });
            });

            // Show modal for adding unassigned students
            $('#btnTambahSiswa').click(function() {
                $('#modalTambahSiswa').modal('show');
            });

            // Checkbox for unassigned students
            $('#checkAllUnassigned').change(function() {
                let checked = $(this).prop('checked');
                $('.check-unassigned').prop('checked', checked);
            });

            $(document).on('change', '.check-unassigned', function() {
                let total = $('.check-unassigned').length;
                let checked = $('.check-unassigned:checked').length;
                $('#checkAllUnassigned').prop('checked', total === checked);
            });

            // Submit added students
            $('#formTambahSiswa').on('submit', function(e) {
                e.preventDefault();
                let checkedCount = $('.check-unassigned:checked').length;
                if (checkedCount === 0) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Validasi Gagal',
                        text: 'Pilih minimal satu siswa untuk ditambahkan.'
                    });
                    return;
                }

                $('#loader').css('display', 'flex');
                $('#modalTambahSiswa').modal('hide');

                $.ajax({
                    type: "POST",
                    url: "{{ route('rombel.tambah-siswa') }}",
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
                            });
                        }
                    },
                    error: function(xhr) {
                        $('#loader').css('display', 'none');
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Terjadi kesalahan pada server saat menambahkan siswa.'
                        });
                    }
                });
            });
        });
    </script>
@endpush
