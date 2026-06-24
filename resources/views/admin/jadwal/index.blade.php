@extends('template')

@section('content')
<div class="container-fluid p-0">
    <div class="row mb-2 mb-xl-3">
        <div class="col-auto d-none d-sm-block">
            <h3><strong>{{ $title }}</strong></h3>
        </div>
        <div class="col-auto ms-auto text-end mt-n1">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahVersi">
                <i class="fas fa-plus"></i> Tambah Versi Jadwal
            </button>
        </div>
    </div>

    <!-- Alert Success / Error -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <div class="alert-message">
                <strong>Berhasil!</strong> {{ session('success') }}
            </div>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <div class="alert-message">
                <strong>Gagal!</strong> {{ session('error') }}
            </div>
        </div>
    @endif

    <div class="row">
        <!-- Info Periode Aktif -->
        <div class="col-md-12 mb-3">
            <div class="card bg-light border-0 shadow-sm">
                <div class="card-body py-3 d-flex align-items-center justify-content-between">
                    <div>
                        <h5 class="mb-1 text-primary">Periode Akademik Aktif:</h5>
                        <p class="mb-0 fw-bold fs-5">
                            Tahun Pelajaran {{ $periodeAktif->awal }}/{{ $periodeAktif->akhir }} - Semester {{ $periodeAktif->semester }}
                        </p>
                    </div>
                    <span class="badge bg-success px-3 py-2 fs-6">Aktif</span>
                </div>
            </div>
        </div>

        <!-- Tabel Daftar Versi -->
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Daftar Versi Jadwal Pembelajaran</h5>
                    <h6 class="card-subtitle text-muted">
                        Kelola versi jadwal akademik di bawah ini. Anda dapat membuat backup (snapshot) jadwal sebelum melakukan revisi jadwal di pertengahan semester.
                    </h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover align-middle">
                            <thead>
                                <tr>
                                    <th style="width: 5%">#</th>
                                    <th style="width: 35%">Nama Versi Jadwal</th>
                                    <th style="width: 15%">Status Keaktifan</th>
                                    <th style="width: 20%">Tanggal Dibuat</th>
                                    <th style="width: 25%" class="text-end">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($versions as $version)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <span class="fw-bold">{{ $version->nama_versi }}</span>
                                        </td>
                                        <td>
                                            @if($version->is_active)
                                                <span class="badge bg-success px-2 py-1"><i class="fas fa-check-circle me-1"></i> Aktif Berjalan</span>
                                            @else
                                                <span class="badge bg-secondary px-2 py-1">Arsip / Cadangan</span>
                                            @endif
                                        </td>
                                        <td>{{ $version->created_at->translatedFormat('d F Y H:i') }}</td>
                                        <td class="text-end">
                                            <div class="d-inline-flex gap-1">
                                                <!-- Edit Grid -->
                                                <a href="{{ route('jadwal.version.edit', $version->id) }}" class="btn btn-warning btn-sm" title="Edit Matriks Jadwal">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>

                                                <!-- Backup / Snapshot -->
                                                <form action="{{ route('jadwal.version.backup', $version->id) }}" method="POST" class="d-inline-block">
                                                    @csrf
                                                    <button type="submit" class="btn btn-info btn-sm btn-backup-confirm" title="Backup / Duplikat Versi ini">
                                                        <i class="fas fa-copy"></i> Backup
                                                    </button>
                                                </form>

                                                <!-- Print Dropdown -->
                                                <div class="dropdown d-inline-block">
                                                    <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownPrint{{ $version->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="fas fa-print"></i> Cetak
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownPrint{{ $version->id }}">
                                                        <li>
                                                            <a class="dropdown-item" href="{{ route('jadwal.print', $version->id) }}?jurusan=AKL" target="_blank">
                                                                <i class="fas fa-file-pdf me-2 text-danger"></i> Cetak Jurusan AKL
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" href="{{ route('jadwal.print', $version->id) }}?jurusan=PPLG" target="_blank">
                                                                <i class="fas fa-file-pdf me-2 text-primary"></i> Cetak Jurusan PPLG
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>

                                                <!-- Aktifkan -->
                                                @if(!$version->is_active)
                                                    <form action="{{ route('jadwal.version.activate', $version->id) }}" method="POST" class="d-inline-block">
                                                        @csrf
                                                        <button type="submit" class="btn btn-success btn-sm" title="Aktifkan Versi ini">
                                                            <i class="fas fa-play"></i> Aktifkan
                                                        </button>
                                                    </form>

                                                    <!-- Hapus -->
                                                    <form action="{{ route('jadwal.version.delete', $version->id) }}" method="POST" class="d-inline-block form-hapus">
                                                        @csrf
                                                        <button type="button" class="btn btn-danger btn-sm btn-hapus-submit" title="Hapus Versi ini">
                                                            <i class="fas fa-trash-alt"></i> Hapus
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4 text-muted">Belum ada versi jadwal terdaftar.</td>
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

<!-- Modal Tambah Versi -->
<div class="modal fade" id="modalTambahVersi" tabindex="-1" aria-labelledby="modalTambahVersiLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('jadwal.version.create') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahVersiLabel"><i class="fas fa-plus me-2 text-primary"></i>Tambah Versi Jadwal Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-content-body p-3">
                    <div class="mb-3">
                        <label for="nama_versi" class="form-label fw-bold">Nama Versi Jadwal</label>
                        <input type="text" class="form-control" id="nama_versi" name="nama_versi" placeholder="Contoh: Jadwal Ganjil Versi Awal, Revisi 1 September" required>
                        <small class="text-muted mt-1 d-block">Gunakan nama versi yang deskriptif agar mudah diidentifikasi.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Versi</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Confirmation for deleting versions
        const deleteButtons = document.querySelectorAll('.btn-hapus-submit');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                const form = this.closest('.form-hapus');
                Swal.fire({
                    title: 'Apakah Anda Yakin?',
                    text: "Seluruh data penempatan jadwal pada versi ini akan dihapus secara permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });

        // Backup confirmation
        const backupButtons = document.querySelectorAll('.btn-backup-confirm');
        backupButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const form = this.closest('form');
                Swal.fire({
                    title: 'Backup Versi Jadwal?',
                    text: "Sistem akan menduplikasi seluruh data jadwal aktif sebagai cadangan arsip.",
                    icon: 'info',
                    showCancelButton: true,
                    confirmButtonColor: '#3b7ddd',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Backup!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    });
</script>
@endpush
