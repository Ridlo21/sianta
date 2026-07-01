@extends('template')
@section('content')
    <div class="container-fluid p-0">
        <div class="row mb-3 mb-xl-3 align-items-center">
            <div class="col-auto">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-1">
                        <li class="breadcrumb-item active" aria-current="page">Sebaran Mapel</li>
                    </ol>
                </nav>
                <h3 class="mb-0 text-dark fw-bold"><strong>Sebaran Mapel (Pembelajaran Rombel)</strong></h3>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-bottom border-light">
                        <h5 class="card-title mb-0 fw-bold">Daftar Rombongan Belajar</h5>
                        <h6 class="card-subtitle text-muted mt-1">Daftar kelompok belajar pada tahun ajaran aktif <strong>{{ $tahun ? $tahun->tahun_ajaran : '-' }}</strong>. Pilih Rombel untuk mendistribusikan mata pelajaran dan guru pengampu (PTK) beserta alokasi jam mengajar.</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="datatables-sebaran" class="table table-striped table-hover align-middle" style="width:100%">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 5%;">#</th>
                                        <th>Nama Rombel</th>
                                        <th>Tingkat Kelas</th>
                                        <th>Jurusan / Program Keahlian</th>
                                        <th>Wali Kelas</th>
                                        <th class="text-center">Jumlah Mapel</th>
                                        <th class="text-center">Total Jam / Minggu</th>
                                        <th style="width: 15%;" class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($rombels as $idx => $r)
                                        <tr>
                                            <td>{{ $idx + 1 }}</td>
                                            <td><strong class="text-dark">{{ $r->nama_rombel }}</strong></td>
                                            <td>Kelas {{ $r->kelas ? $r->kelas->nama_kelas : '-' }}</td>
                                            <td>{{ $r->jurusan ? $r->jurusan->program_keahlian : 'Umum' }}</td>
                                            <td>
                                                @if($r->waliRombel && count($r->waliRombel) > 0 && $r->waliRombel[0]->guru)
                                                    {{ $r->waliRombel[0]->guru->nama }}
                                                @else
                                                    <span class="text-muted small">Belum Ditentukan</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-primary-soft text-primary px-2.5 py-1 rounded-pill fw-bold">
                                                    {{ $r->pembelajaran_count }} Mapel
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-success-soft text-success px-2.5 py-1 rounded-pill fw-bold">
                                                    {{ $r->total_jam ?? 0 }} Jam
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('sebaran-mapel.manage', $r->id) }}" class="btn btn-outline-primary btn-sm shadow-sm fw-bold px-3">
                                                    <i class="fas fa-edit me-1"></i> Atur Sebaran
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center py-5 text-muted">
                                                <div class="mb-3">
                                                    <i data-feather="home" style="width: 48px; height: 48px;" class="text-secondary opacity-50"></i>
                                                </div>
                                                <h5>Tidak Ada Rombel Aktif</h5>
                                                <p class="small text-muted mb-0">Silakan daftarkan atau aktifkan Rombel pada tahun ajaran berjalan terlebih dahulu.</p>
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

    <style>
        .bg-primary-soft {
            background-color: rgba(99, 102, 241, 0.1) !important;
            color: #4f46e5 !important;
        }
        .bg-success-soft {
            background-color: rgba(28, 187, 140, 0.1) !important;
            color: #1cbb8c !important;
        }
        .table-responsive {
            overflow-x: visible !important;
        }
    </style>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#datatables-sebaran').DataTable({
                paging: true,
                lengthChange: false,
                searching: true,
                ordering: false,
                info: true,
                autoWidth: false,
                responsive: true
            });
        });
    </script>
@endpush
