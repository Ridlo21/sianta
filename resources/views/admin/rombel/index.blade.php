@extends('template')
@section('content')
    <div class="container-fluid p-0">
        <!-- Page Header -->
        <div class="row mb-4 align-items-center">
            <div class="col-auto">
                <h3 class="mb-0 text-dark fw-bold"><strong>{{ $title }}</strong></h3>
            </div>
            <div class="col-auto ms-auto text-end d-flex gap-2">
                <a href="{{ route('rombel.pembagian-massal') }}" class="btn btn-outline-primary shadow-sm fw-bold">
                    <i class="align-middle me-1" data-feather="users"></i> Pembagian Kelas Massal
                </a>
                <button class="btn btn-primary shadow-sm fw-bold" id="btnTambahRombel">
                    <i class="align-middle me-1" data-feather="plus"></i> Tambah Rombel
                </button>
            </div>
        </div>

        <!-- Academic Year Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm bg-primary overflow-hidden mb-0">
                    <div class="card-body p-4 position-relative">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h3 class="fw-bold mb-1">Manajemen Rombel</h3>
                                <p class="mb-0 font-weight-normal">Kelola kelompok belajar (rombel)
                                    berdasarkan tingkat kelas, jurusan, dan alokasikan siswa untuk periode akademik
                                    berjalan.</p>
                            </div>
                            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                                <div
                                    class="d-inline-flex align-items-center bg-white bg-opacity-10 px-4 py-2.5 rounded-3 border border-white border-opacity-10 shadow-xs">
                                    <i data-feather="calendar" class="me-2" style="width: 20px; height: 20px;"></i>
                                    <div>
                                        <div class="text-xs lh-1">Tahun Ajaran Aktif</div>
                                        <div class="fw-bold fs-5 mt-0.5">
                                            {{ $tahun ? $tahun->tahun_ajaran : 'Tidak Ada' }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Class Cards Grid -->
        <div class="row">
            @foreach ($kelas as $item)
                <div class="col-xl-4 col-md-6 mb-4">
                    <div class="card h-100 shadow-sm border-0 transition-hover">
                        <!-- Card Header -->
                        <div
                            class="card-header bg-white border-bottom border-light py-3 d-flex justify-content-between align-items-center">
                            <div>
                                <span class="text-uppercase text-muted fw-bold font-size-xxs tracking-wider">Tingkat
                                    Kelas</span>
                                <h4 class="card-title mb-0 fw-extrabold text-primary fs-3 mt-1">Kelas
                                    {{ $item->nama_kelas }}</h4>
                            </div>
                            <span class="badge bg-primary-soft text-primary px-3 py-2 rounded-pill fw-bold fs-6">
                                {{ $item->rombel->count() }} Rombel
                            </span>
                        </div>

                        <!-- Card Body -->
                        <div class="card-body py-3">
                            @if ($item->rombel->isEmpty())
                                <div class="text-center py-5">
                                    <div class="text-muted mb-3">
                                        <i data-feather="folder-minus" style="width: 48px; height: 48px;"
                                            class="text-secondary opacity-50"></i>
                                    </div>
                                    <p class="text-muted mb-0">Belum ada rombel yang terdaftar.</p>
                                </div>
                            @else
                                <div class="rombel-list">
                                    @php
                                        $groupedRombel = $item->rombel->groupBy('jurusan_id');
                                    @endphp
                                    @foreach ($groupedRombel as $jurusanId => $rombels)
                                        @php
                                            $firstRombel = $rombels->first();
                                            $jurusanName = $firstRombel->jurusan
                                                ? $firstRombel->jurusan->program_keahlian
                                                : 'Umum';
                                            $jurusanAlias = $firstRombel->jurusan
                                                ? $firstRombel->jurusan->kons_keahlian
                                                : 'Umum';
                                            $rombelCount = $rombels->count();
                                        @endphp
                                        <div class="rombel-group-item d-flex align-items-center justify-content-between p-3 mb-2.5 rounded-3 border border-light bg-light-soft cursor-pointer"
                                            data-kelas-id="{{ $item->id }}" data-kelas-name="{{ $item->nama_kelas }}"
                                            data-jurusan-id="{{ $jurusanId ?? 'null' }}"
                                            data-jurusan-alias="{{ $jurusanAlias }}" title="Klik untuk lihat daftar Rombel">
                                            <div class="d-flex align-items-center">
                                                <div class="rombel-icon-box me-3">
                                                    @if (strpos(strtolower($jurusanName), 'pplg') !== false || strpos(strtolower($jurusanAlias), 'pplg') !== false)
                                                        <i data-feather="code" class="text-info"
                                                            style="width: 18px; height: 18px;"></i>
                                                    @elseif(strpos(strtolower($jurusanName), 'akl') !== false || strpos(strtolower($jurusanAlias), 'akl') !== false)
                                                        <i data-feather="dollar-sign" class="text-success"
                                                            style="width: 18px; height: 18px;"></i>
                                                    @else
                                                        <i data-feather="book-open" class="text-primary"
                                                            style="width: 18px; height: 18px;"></i>
                                                    @endif
                                                </div>
                                                <div>
                                                    <h5 class="mb-0 fw-bold text-dark fs-5">
                                                        @if ($firstRombel->jurusan)
                                                            Rombel {{ $firstRombel->jurusan->kons_keahlian }}
                                                        @else
                                                            Rombel Umum
                                                        @endif
                                                    </h5>
                                                    <span class="text-muted d-block mt-0.5" style="font-size: 0.75rem;">
                                                        {{ $jurusanName }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="text-end">
                                                <span class="fs-3 fw-extrabold text-primary d-block line-height-1">
                                                    {{ $rombelCount }}
                                                </span>
                                                <span
                                                    class="text-uppercase text-muted fw-semibold tracking-wider font-size-xxs">Rombel</span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <!-- Card Footer -->
                        <div class="card-footer bg-white border-top-0 pt-0 pb-4 px-4">
                            <button class="btn btn-outline-primary w-100 py-2.5 rounded-3 fw-bold btn-selengkapnya"
                                data-kelas-id="{{ $item->id }}" data-kelas-name="{{ $item->nama_kelas }}">
                                Selengkapnya <i data-feather="arrow-right" class="feather-sm ms-1"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Modal Tambah/Edit Rombel -->
    <div class="modal fade" id="modalRombel" tabindex="-1" role="dialog" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content border-0 shadow-lg">
                <form id="formRombel" data-parsley-validate>
                    @csrf
                    <input type="hidden" name="id" id="rombel_id" value="">
                    <div class="modal-header bg-primary text-white border-0 py-3">
                        <h5 class="modal-title text-white fw-bold" id="modalRombelTitle">Tambah Rombel</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Tingkat Kelas</label>
                            <select name="kelas_id" id="kelas_id" class="form-select form-control" required>
                                <option value="" disabled selected>Pilih Kelas</option>
                                @foreach ($kelas as $k)
                                    <option value="{{ $k->id }}">Kelas {{ $k->nama_kelas }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nama Rombel</label>
                            <input type="text" name="nama_rombel" id="nama_rombel" class="form-control"
                                placeholder="Contoh: XI A (Sesuaikan dengan tingkat kelas yang anda pilih!)" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Jurusan / Konsentrasi Keahlian</label>
                            <select name="jurusan_id" id="jurusan_id" class="form-select form-control">
                                <option value="">Umum (Tanpa Jurusan)</option>
                                @foreach ($jurusan as $j)
                                    <option value="{{ $j->id }}">{{ $j->program_keahlian }}
                                        ({{ $j->kons_keahlian }})
                                    </option>
                                @endforeach
                            </select>
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

    <!-- Modal Detail Kelas (Selengkapnya) -->
    <div class="modal fade" id="modalDetailKelas" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-primary text-white border-0 py-3">
                    <h5 class="modal-title text-white fw-bold" id="modalDetailKelasTitle">Detail Rombel</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle" id="tableDetailRombel">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 5%;">#</th>
                                    <th>Nama Rombel</th>
                                    <th>Jurusan</th>
                                    <th class="text-center">Jumlah Siswa</th>
                                    <th class="text-center" style="width: 25%;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="tbodyDetailRombel">
                                <!-- Dynamic rows -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Daftar Siswa -->
    <div class="modal fade" id="modalSiswa" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-info text-white border-0 py-3">
                    <h5 class="modal-title text-white fw-bold" id="modalSiswaTitle">Daftar Siswa</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped align-middle" id="tableSiswa">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 5%;">#</th>
                                    <th>NIS</th>
                                    <th>NISN</th>
                                    <th>Nama Lengkap</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody id="tbodySiswa">
                                <!-- Dynamic rows -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Styles -->
    <style>
        .transition-hover {
            transition: transform 0.25s cubic-bezier(0.4, 0, 0.2, 1), box-shadow 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .transition-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 0.75rem 2rem rgba(0, 0, 0, 0.08) !important;
        }

        .rombel-group-item {
            transition: all 0.2s ease-in-out;
            cursor: pointer;
        }

        .rombel-group-item:hover {
            background-color: rgba(59, 125, 221, 0.04) !important;
            border-color: rgba(59, 125, 221, 0.15) !important;
            transform: translateX(4px);
        }

        .rombel-icon-box {
            width: 40px;
            height: 40px;
            background-color: rgba(59, 125, 221, 0.08);
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
        }

        .bg-light-soft {
            background-color: #fafbfc;
        }

        .bg-primary-soft {
            background-color: rgba(59, 125, 221, 0.1) !important;
            color: #3b7ddd !important;
        }

        .bg-info-soft {
            background-color: rgba(23, 162, 184, 0.1) !important;
            color: #17a2b8 !important;
        }

        .line-height-1 {
            line-height: 1;
        }

        .font-size-xxs {
            font-size: 0.65rem;
        }

        .tracking-wider {
            letter-spacing: 0.05em;
        }

        .mb-2\.5 {
            margin-bottom: 0.65rem !important;
        }

        .btn-selengkapnya {
            transition: all 0.2s ease;
        }

        .btn-selengkapnya:hover {
            background-color: #3b7ddd !important;
            color: #fff !important;
        }
    </style>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Action when clicking on a Jurusan row inside a Class card
            $('.rombel-group-item').click(function() {
                let kelasId = $(this).data('kelas-id');
                let kelasName = $(this).data('kelas-name');
                let jurusanId = $(this).data('jurusan-id');
                let jurusanAlias = $(this).data('jurusan-alias');

                $('#modalDetailKelasTitle').text('Detail Rombel - Kelas ' + kelasName + ' (' +
                    jurusanAlias + ')');
                $('#tbodyDetailRombel').html(
                    '<tr><td colspan="5" class="text-center py-4"><div class="spinner-border spinner-border-sm text-primary me-2"></div> Loading...</td></tr>'
                );
                $('#modalDetailKelas').modal('show');

                let kelasData = @json($kelas);
                let selectedKelas = kelasData.find(k => k.id == kelasId);

                if (selectedKelas && selectedKelas.rombel && selectedKelas.rombel.length > 0) {
                    let filteredRombel = selectedKelas.rombel.filter(r => {
                        if (jurusanId === 'null' || jurusanId === null || jurusanId === '') {
                            return r.jurusan_id === null;
                        }
                        return r.jurusan_id == jurusanId;
                    });

                    if (filteredRombel.length > 0) {
                        let html = '';
                        filteredRombel.forEach((r, idx) => {
                            let jurusanName = r.jurusan ? r.jurusan.program_keahlian : 'Umum';
                            let detailUrl = "{{ route('rombel.show-detail', ':id') }}".replace(
                                ':id', r.id);
                            let printUrl = "{{ route('rombel.print', ':id') }}".replace(
                                ':id', r.id);
                            html += `
                                <tr>
                                    <td>${idx + 1}</td>
                                    <td><strong class="text-dark">${r.nama_rombel}</strong></td>
                                    <td>${jurusanName}</td>
                                    <td class="text-center">
                                        <span class="badge bg-primary-soft text-primary fw-bold px-2.5 py-1.5 rounded">
                                            ${r.penempatan_rombel_count} Siswa
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-1">
                                            <a href="${detailUrl}" class="btn btn-sm btn-primary" title="Kelola Rombel Detail">
                                                <i class="align-middle" data-feather="external-link" style="width: 14px; height: 14px;"></i>
                                            </a>
                                            <a href="${printUrl}" target="_blank" class="btn btn-sm btn-success" title="Cetak PDF">
                                                <i class="align-middle" data-feather="printer" style="width: 14px; height: 14px;"></i>
                                            </a>
                                            <button class="btn btn-sm btn-info btnViewStudents" data-id="${r.id}" title="Lihat Siswa">
                                                <i class="align-middle" data-feather="users" style="width: 14px; height: 14px;"></i>
                                            </button>
                                            <button class="btn btn-sm btn-warning btnEditRombel" data-id="${r.id}" title="Edit Rombel">
                                                <i class="align-middle" data-feather="edit" style="width: 14px; height: 14px;"></i>
                                            </button>
                                            <button class="btn btn-sm btn-danger btnDeleteRombel" data-id="${r.id}" title="Hapus Rombel">
                                                <i class="align-middle" data-feather="trash-2" style="width: 14px; height: 14px;"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            `;
                        });
                        $('#tbodyDetailRombel').html(html);
                        feather.replace();
                    } else {
                        $('#tbodyDetailRombel').html(
                            '<tr><td colspan="5" class="text-center text-muted py-4">Belum ada rombel.</td></tr>'
                        );
                    }
                } else {
                    $('#tbodyDetailRombel').html(
                        '<tr><td colspan="5" class="text-center text-muted py-4">Belum ada rombel.</td></tr>'
                    );
                }
            });

            // Show Rombel Tambah Modal
            $('#btnTambahRombel').click(function() {
                $('#modalRombelTitle').text('Tambah Rombel');
                $('#formRombel')[0].reset();
                $('#rombel_id').val('');
                $('#modalRombel').modal('show');
            });

            // Action for Class Details (Selengkapnya) - Shows all Rombels in class
            $('.btn-selengkapnya').click(function() {
                let kelasId = $(this).data('kelas-id');
                let kelasName = $(this).data('kelas-name');

                $('#modalDetailKelasTitle').text('Detail Rombel - Kelas ' + kelasName + ' (Semua Rombel)');
                $('#tbodyDetailRombel').html(
                    '<tr><td colspan="5" class="text-center py-4"><div class="spinner-border spinner-border-sm text-primary me-2"></div> Loading...</td></tr>'
                );
                $('#modalDetailKelas').modal('show');

                let kelasData = @json($kelas);
                let selectedKelas = kelasData.find(k => k.id == kelasId);

                if (selectedKelas && selectedKelas.rombel && selectedKelas.rombel.length > 0) {
                    let html = '';
                    selectedKelas.rombel.forEach((r, idx) => {
                        let jurusanName = r.jurusan ? r.jurusan.program_keahlian : 'Umum';
                        let detailUrl = "{{ route('rombel.show-detail', ':id') }}".replace(':id', r
                            .id);
                        let printUrl = "{{ route('rombel.print', ':id') }}".replace(':id', r
                            .id);
                        html += `
                            <tr>
                                <td>${idx + 1}</td>
                                <td><strong class="text-dark">${r.nama_rombel}</strong></td>
                                <td>${jurusanName}</td>
                                <td class="text-center">
                                    <span class="badge bg-primary-soft text-primary fw-bold px-2.5 py-1.5 rounded">
                                        ${r.penempatan_rombel_count} Siswa
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-1">
                                        <a href="${detailUrl}" class="btn btn-sm btn-primary" title="Kelola Rombel Detail">
                                            <i class="align-middle" data-feather="external-link" style="width: 14px; height: 14px;"></i>
                                        </a>
                                        <a href="${printUrl}" target="_blank" class="btn btn-sm btn-success" title="Cetak PDF">
                                            <i class="align-middle" data-feather="printer" style="width: 14px; height: 14px;"></i>
                                        </a>
                                        <button class="btn btn-sm btn-info btnViewStudents" data-id="${r.id}" title="Lihat Siswa">
                                            <i class="align-middle" data-feather="users" style="width: 14px; height: 14px;"></i>
                                        </button>
                                        <button class="btn btn-sm btn-warning btnEditRombel" data-id="${r.id}" title="Edit Rombel">
                                            <i class="align-middle" data-feather="edit" style="width: 14px; height: 14px;"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger btnDeleteRombel" data-id="${r.id}" title="Hapus Rombel">
                                            <i class="align-middle" data-feather="trash-2" style="width: 14px; height: 14px;"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        `;
                    });
                    $('#tbodyDetailRombel').html(html);
                    feather.replace();
                } else {
                    $('#tbodyDetailRombel').html(
                        '<tr><td colspan="5" class="text-center text-muted py-4">Belum ada rombel.</td></tr>'
                    );
                }
            });

            // Action for viewing students inside class detail modal
            $(document).on('click', '.btnViewStudents', function() {
                let id = $(this).data('id');
                $('#modalDetailKelas').modal('hide');
                showStudentsModal(id);
            });

            // Action for editing rombel
            $(document).on('click', '.btnEditRombel', function() {
                let id = $(this).data('id');
                $('#modalDetailKelas').modal('hide');
                $('#loader').css('display', 'flex');

                $.get("{{ route('rombel.edit', ':id') }}".replace(':id', id), function(data) {
                    $('#loader').css('display', 'none');
                    $('#rombel_id').val(data.id);
                    $('#kelas_id').val(data.kelas_id);
                    $('#nama_rombel').val(data.nama_rombel);
                    $('#jurusan_id').val(data.jurusan_id || '');

                    $('#modalRombelTitle').text('Edit Rombel');
                    $('#modalRombel').modal('show');
                }).fail(function() {
                    $('#loader').css('display', 'none');
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Gagal mengambil data rombel.'
                    });
                });
            });

            // Action for deleting rombel
            $(document).on('click', '.btnDeleteRombel', function() {
                let id = $(this).data('id');
                $('#modalDetailKelas').modal('hide');

                Swal.fire({
                    title: 'Anda yakin?',
                    text: 'Apakah anda yakin untuk menghapus Rombel ini?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#loader').css('display', 'flex');
                        $.post("{{ route('rombel.hapus') }}", {
                            _token: "{{ csrf_token() }}",
                            id: id
                        }, function(response) {
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
                        }).fail(function() {
                            $('#loader').css('display', 'none');
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Terjadi kesalahan pada server.'
                            });
                        });
                    }
                });
            });

            // Form Submit for Store/Update
            $('#formRombel').on('submit', function(e) {
                e.preventDefault();
                let id = $('#rombel_id').val();
                let url = id ? "{{ route('rombel.update') }}" : "{{ route('rombel.simpan') }}";

                $(this).parsley().validate();
                if ($(this).parsley().isValid()) {
                    $('#loader').css('display', 'flex');
                    $('#modalRombel').modal('hide');

                    $.ajax({
                        type: "POST",
                        url: url,
                        data: $(this).serialize(),
                        success: function(response) {
                            $('#loader').css('display', 'none');
                            if (response.status === 'success') {
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
                                let pesan = Object.values(errors).flat().join('\n');
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

            // Helper to fetch and display student modal
            function showStudentsModal(rombelId) {
                $('#loader').css('display', 'flex');
                $.get("{{ route('rombel.students', ':id') }}".replace(':id', rombelId), function(data) {
                    $('#loader').css('display', 'none');
                    $('#modalSiswaTitle').text('Daftar Siswa - ' + data.rombel.nama_rombel);

                    let html = '';
                    if (data.students && data.students.length > 0) {
                        data.students.forEach((s, idx) => {
                            html += `
                                <tr>
                                    <td>${idx + 1}</td>
                                    <td>${s.nis || '-'}</td>
                                    <td>${s.nisn || '-'}</td>
                                    <td><strong class="text-dark">${s.nama}</strong></td>
                                    <td>${s.jenis_kelamin}</td>
                                    <td><span class="badge bg-success-light">Aktif</span></td>
                                </tr>
                            `;
                        });
                    } else {
                        html = `
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">
                                    <i data-feather="info" class="me-1 feather-sm"></i> Belum ada siswa yang ditempatkan di rombel ini.
                                </td>
                            </tr>
                        `;
                    }
                    $('#tbodySiswa').html(html);
                    $('#modalSiswa').modal('show');
                    feather.replace();
                }).fail(function() {
                    $('#loader').css('display', 'none');
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Gagal mengambil data siswa.'
                    });
                });
            }
        });
    </script>
@endpush
