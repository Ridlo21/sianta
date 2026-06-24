@extends('template')
@section('content')
    <div class="container-fluid p-0">
        <!-- Page Header -->
        <div class="row mb-3 mb-xl-3 align-items-center">
            <div class="col-auto">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-1">
                        <li class="breadcrumb-item"><a href="{{ route('rombel') }}">Rombel</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Pembagian Kelas Massal</li>
                    </ol>
                </nav>
                <h3 class="mb-0 text-dark fw-bold"><strong>Pembagian Rombel Massal</strong></h3>
            </div>
            <div class="col-auto ms-auto text-end">
                <a href="{{ route('rombel') }}" class="btn btn-outline-secondary shadow-sm">
                    <i class="align-middle me-1" data-feather="arrow-left"></i> Kembali
                </a>
            </div>
        </div>

        <div class="row">
            <!-- Left Column: Unassigned Students Checklist -->
            <div class="col-lg-7 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white border-bottom border-light py-3 d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title mb-0 fw-bold">Siswa Belum Ditempatkan</h5>
                            <small class="text-muted">Daftar siswa aktif yang belum memiliki rombel untuk tahun ajaran aktif.</small>
                        </div>
                        <span class="badge bg-primary-soft text-primary px-3 py-2 rounded-pill fw-bold fs-6">
                            {{ count($students) }} Siswa
                        </span>
                    </div>
                    <div class="card-body py-3">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover align-middle" id="tableMassalSiswa" style="width: 100%;">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 5%;" class="text-center">
                                            <input type="checkbox" class="form-check-input" id="checkAll">
                                        </th>
                                        <th style="width: 5%;">#</th>
                                        <th>NIS</th>
                                        <th>Nama Lengkap</th>
                                        <th style="width: 10%;">L/P</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $groupedStudents = $students->groupBy(function($student) {
                                            return $student->jurusan ? $student->jurusan->kons_keahlian : 'Umum / Tanpa Jurusan';
                                        });
                                        $globalIdx = 1;
                                    @endphp
                                    @forelse($groupedStudents as $jurusanName => $siswaList)
                                        <tr class="table-light table-group-header">
                                            <td class="text-center bg-light">
                                                <input type="checkbox" class="form-check-input check-group" data-group="{{ \Illuminate\Support\Str::slug($jurusanName) }}">
                                            </td>
                                            <td colspan="4" class="bg-light align-middle py-2">
                                                <span class="text-dark fw-bold">
                                                    <i data-feather="book-open" class="align-middle me-1 text-primary" style="width: 16px; height: 16px;"></i>
                                                    {{ $jurusanName }}
                                                </span>
                                                <span class="badge bg-primary-soft text-primary ms-2 rounded-pill fw-bold">
                                                    {{ count($siswaList) }} Siswa
                                                </span>
                                            </td>
                                        </tr>
                                        @foreach($siswaList as $s)
                                            <tr>
                                                <td class="text-center">
                                                    <input type="checkbox" class="form-check-input check-student" data-group="{{ \Illuminate\Support\Str::slug($jurusanName) }}" value="{{ $s->id_person }}">
                                                </td>
                                                <td>{{ $globalIdx++ }}</td>
                                                <td>{{ $s->nis ?? '-' }}</td>
                                                <td><strong class="text-dark">{{ $s->nama }}</strong></td>
                                                <td>{{ $s->jenis_kelamin == 'Laki-Laki' ? 'L' : 'P' }}</td>
                                            </tr>
                                        @endforeach
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-5 text-muted">
                                                <div class="mb-3">
                                                    <i data-feather="smile" style="width: 48px; height: 48px;" class="text-success opacity-50"></i>
                                                </div>
                                                <h5>Semua Siswa Telah Ditempatkan</h5>
                                                <p class="small text-muted mb-0">Tidak ada siswa aktif tanpa rombel untuk tahun ajaran berjalan.</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Target Rombel Selection & Info -->
            <div class="col-lg-5 mb-4">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-bottom border-light py-3">
                        <h5 class="card-title mb-0 fw-bold">Alokasi Rombel Tujuan</h5>
                    </div>
                    <div class="card-body">
                        <form id="formPembagianMassal">
                            @csrf
                            <div class="mb-4">
                                <label class="form-label fw-bold text-muted">Pilih Rombel Tujuan</label>
                                <select name="rombel_id" id="rombel_id" class="form-select select2" required>
                                    <option value="" disabled selected>Pilih Rombel...</option>
                                    @foreach($rombels->groupBy('kelas.nama_kelas') as $kelasName => $rombelsInKelas)
                                        <optgroup label="Tingkat Kelas {{ $kelasName }}">
                                            @foreach($rombelsInKelas as $r)
                                                <option value="{{ $r->id }}">
                                                    {{ $r->nama_rombel }} ({{ $r->jurusan ? $r->jurusan->kons_keahlian : 'Umum' }})
                                                </option>
                                            @endforeach
                                        </optgroup>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Target Rombel Info Panel (Loaded via JS) -->
                            <div id="targetInfoCard" class="card border border-light bg-light-soft p-3 mb-4 rounded-3 d-none">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="rombel-icon-box me-3">
                                        <i data-feather="home" class="text-primary" style="width: 20px; height: 20px;"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted d-block lh-1">Rombel Pilihan</small>
                                        <span class="fw-extrabold text-dark fs-4 mt-0.5 d-inline-block" id="infoRombelName">-</span>
                                    </div>
                                </div>
                                <div class="row g-2 mb-3">
                                    <div class="col-6">
                                        <small class="text-muted d-block">Tingkat Kelas</small>
                                        <span class="fw-bold text-dark" id="infoKelasName">-</span>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted d-block">Jumlah Siswa Saat Ini</small>
                                        <span class="fw-bold text-primary" id="infoStudentCount">0 Siswa</span>
                                    </div>
                                </div>
                                <div class="p-2.5 bg-white rounded border border-light">
                                    <small class="text-muted d-block mb-1">Wali Rombel (Wali Kelas)</small>
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset('asset_admin/img/avatars/avatar.png') }}" id="infoWaliAvatar" class="avatar img-fluid rounded-circle me-2" style="width: 32px; height: 32px; object-fit: cover;" alt="Avatar" />
                                        <div>
                                            <strong class="text-dark d-block fs-6" id="infoWaliName">Belum Ditentukan</strong>
                                            <span class="text-muted small" id="infoWaliNiy">-</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Checked count visual indicator -->
                            <div class="alert alert-info border-0 shadow-xs mb-4 d-flex align-items-center">
                                <i data-feather="info" class="me-2 text-info"></i>
                                <div>
                                    <strong id="checkedCount">0</strong> siswa terpilih untuk dialokasikan.
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary btn-lg w-100 py-2.5 fw-bold shadow-sm" id="btnSubmitMassal" disabled>
                                <i data-feather="check" class="feather-sm me-1"></i> Proses Penempatan Siswa
                            </button>
                        </form>
                    </div>
                </div>
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
        .table-responsive {
            overflow-x: visible !important;
        }
        .table-group-header td {
            background-color: #f8f9fa !important;
            border-top: 2px solid #e9ecef !important;
            border-bottom: 2px solid #e9ecef !important;
        }
    </style>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            const rombelData = @json($rombels);

            // Initialize Select2
            $('.select2').select2({
                placeholder: "Pilih Rombel Tujuan...",
                allowClear: true
            });

            // Update Target Rombel Info Preview
            $('#rombel_id').change(function() {
                let id = $(this).val();
                let rombel = rombelData.find(r => r.id == id);
                
                if (rombel) {
                    $('#infoRombelName').text(rombel.nama_rombel);
                    $('#infoKelasName').text('Kelas ' + (rombel.kelas ? rombel.kelas.nama_kelas : '-'));
                    $('#infoStudentCount').text(rombel.penempatan_rombel_count + ' Siswa');
                    
                    if (rombel.wali_rombel && rombel.wali_rombel.length > 0 && rombel.wali_rombel[0].guru) {
                        let guru = rombel.wali_rombel[0].guru;
                        let photoUrl = guru.foto ? "{{ asset('gambar_berkas/avatars/') }}/" + guru.foto : "{{ asset('asset_admin/img/avatars/avatar.png') }}";
                        
                        $('#infoWaliAvatar').attr('src', photoUrl);
                        $('#infoWaliName').text(guru.nama_lengkap);
                        $('#infoWaliNiy').text('NIY. ' + (guru.niy ?? '-'));
                    } else {
                        $('#infoWaliAvatar').attr('src', "{{ asset('asset_admin/img/avatars/avatar.png') }}");
                        $('#infoWaliName').text('Belum Ditentukan');
                        $('#infoWaliNiy').text('-');
                    }
                    
                    $('#targetInfoCard').removeClass('d-none');
                } else {
                    $('#targetInfoCard').addClass('d-none');
                }
                
                updateSubmitButtonState();
            });

            // Checkbox multi-select logic
            $('#checkAll').change(function() {
                let checked = $(this).prop('checked');
                $('.check-student').prop('checked', checked);
                $('.check-group').prop('checked', checked);
                updateSubmitButtonState();
            });

            // Group checkbox logic
            $(document).on('change', '.check-group', function() {
                let group = $(this).data('group');
                let checked = $(this).prop('checked');
                $(`.check-student[data-group="${group}"]`).prop('checked', checked);
                updateSubmitButtonState();
                
                // update checkAll state
                let total = $('.check-student').length;
                let checkedCount = $('.check-student:checked').length;
                $('#checkAll').prop('checked', total === checkedCount);
            });

            $(document).on('change', '.check-student', function() {
                updateSubmitButtonState();
                
                // update checkAll state
                let total = $('.check-student').length;
                let checked = $('.check-student:checked').length;
                $('#checkAll').prop('checked', total === checked);

                // update group check state
                let group = $(this).data('group');
                let groupTotal = $(`.check-student[data-group="${group}"]`).length;
                let groupChecked = $(`.check-student[data-group="${group}"]:checked`).length;
                $(`.check-group[data-group="${group}"]`).prop('checked', groupTotal === groupChecked);
            });

            function updateSubmitButtonState() {
                let checkedCount = $('.check-student:checked').length;
                let rombelSelected = $('#rombel_id').val();
                
                $('#checkedCount').text(checkedCount);
                
                if (checkedCount > 0 && rombelSelected) {
                    $('#btnSubmitMassal').prop('disabled', false);
                } else {
                    $('#btnSubmitMassal').prop('disabled', true);
                }
            }

            // Submit Action
            $('#formPembagianMassal').on('submit', function(e) {
                e.preventDefault();
                
                let targetRombelId = $('#rombel_id').val();
                let targetRombelText = $('#rombel_id option:selected').text().trim();
                let studentIds = [];
                $('.check-student:checked').each(function() {
                    studentIds.push($(this).val());
                });

                if (studentIds.length === 0 || !targetRombelId) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Validasi Gagal',
                        text: 'Silakan pilih siswa dan Rombel tujuan terlebih dahulu.'
                    });
                    return;
                }

                Swal.fire({
                    title: 'Konfirmasi Penempatan',
                    text: 'Apakah Anda yakin ingin menempatkan ' + studentIds.length + ' siswa ke ' + targetRombelText + '?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Tempatkan!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#loader').css('display', 'flex');
                        $.ajax({
                            type: "POST",
                            url: "{{ route('rombel.proses-pembagian-massal') }}",
                            data: {
                                _token: "{{ csrf_token() }}",
                                siswa_ids: studentIds,
                                rombel_id: targetRombelId
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
                                    text: 'Terjadi kesalahan pada server saat memproses penempatan siswa.'
                                });
                            }
                        });
                    }
                });
            });
        });
    </script>
@endpush
