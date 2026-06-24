@extends('template')
@section('content')
    @php
        $defaultAvatar = $guru->jenis_kelamin === 'P' ? 'gurufemale.png' : 'gurumale.png';
        $foto = $guru->foto
            ? asset('gambar_berkas/berkas_guru/' . $guru->foto)
            : asset('asset_admin/img/avatars/' . $defaultAvatar);
    @endphp

    <style>
        .nav-pills-custom .nav-link {
            border: none;
            color: #6c757d;
            font-weight: 600;
            padding: 0.75rem 1.5rem;
            border-radius: 30px;
            transition: all 0.3s ease;
            margin-right: 0.5rem;
            background-color: #f8f9fa;
            border: 1px solid #e9ecef;
        }
        .nav-pills-custom .nav-link:hover {
            background-color: rgba(59, 125, 221, 0.05);
            color: #3b7ddd;
            border-color: rgba(59, 125, 221, 0.2);
        }
        .nav-pills-custom .nav-link.active {
            background-color: #3b7ddd !important;
            color: #ffffff !important;
            border-color: #3b7ddd;
            box-shadow: 0 4px 15px rgba(59, 125, 221, 0.25);
        }
        .hover-scale {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .hover-scale:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.08) !important;
        }
        .doc-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid #e9ecef;
            border-radius: 16px;
            background-color: #ffffff;
        }
        .doc-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.06) !important;
            border-color: #3b7ddd;
        }
        .doc-img-container {
            position: relative;
            overflow: hidden;
            border-radius: 12px;
            height: 160px;
            background-color: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .doc-img-container img {
            transition: all 0.5s ease;
            max-height: 100%;
            object-fit: cover;
            width: 100%;
        }
        .doc-img-container:hover img {
            transform: scale(1.08);
        }
        .detail-row {
            display: flex;
            padding: 0.85rem 1.25rem;
            border-bottom: 1px solid #f8f9fa;
            align-items: center;
        }
        .detail-row:last-child {
            border-bottom: none;
        }
        .detail-label {
            width: 38%;
            color: #6c757d;
            font-size: 0.875rem;
            font-weight: 550;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .detail-value {
            width: 62%;
            color: #212529;
            font-weight: 600;
            font-size: 0.925rem;
        }
        .parent-card {
            background: #ffffff;
            border: 1px solid #e9ecef;
            border-radius: 20px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.01);
            height: 100%;
            overflow: hidden;
            transition: all 0.3s ease;
        }
        .parent-card:hover {
            border-color: rgba(59, 125, 221, 0.2);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.03);
        }
        .parent-header {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid #f8f9fa;
            background-color: #fafbfc;
        }
        .info-pill {
            background-color: #f0f4f9;
            color: #495057;
            font-size: 0.8rem;
            font-weight: 700;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            border: 1px solid #e2e8f0;
        }
    </style>

    <div class="container-fluid p-0">
        <!-- Page Header -->
        <div class="row mb-4 align-items-center">
            <div class="col-auto">
                <h3 class="mb-0 text-dark fw-bold"><strong>Detail Guru</strong></h3>
            </div>
            <div class="col text-end">
                <a href="{{ route('guru') }}" class="btn btn-outline-secondary shadow-sm px-4 fw-bold">
                    <i class="fas fa-reply me-1"></i> Kembali
                </a>
            </div>
        </div>

        {{-- PROFILE SUMMARY CARD --}}
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden hover-scale">
                    <div class="card-body p-4 p-lg-5">
                        <div class="row g-4 align-items-center">
                            {{-- FOTO --}}
                            <div class="col-lg-3 text-center text-lg-start">
                                <div class="d-inline-block position-relative">
                                    <img src="{{ $foto }}" class="rounded-4 shadow-sm border border-light border-4 img-thumbnail"
                                        style="width: 200px; height: 260px; object-fit: cover;">
                                </div>
                                @if ($guru->foto)
                                    <div class="mt-3 px-3">
                                        <a href="{{ route('guru.download.berkas', [$guru, 'foto']) }}"
                                            class="btn btn-outline-primary btn-sm w-100 shadow-xs fw-semibold py-2">
                                            <i class="fas fa-download me-1"></i> Unduh Foto
                                        </a>
                                    </div>
                                @endif
                            </div>

                            {{-- BIODATA --}}
                            <div class="col-lg-9">
                                {{-- HEADER --}}
                                <div class="mb-4 text-center text-lg-start">
                                    <div class="d-flex flex-column flex-lg-row align-items-center gap-2 mb-2">
                                        <h2 class="fw-extrabold text-dark mb-0">
                                            {{ strtoupper($guru->nama_lengkap) }}
                                        </h2>
                                        @php
                                            $statusBadge = $guru->status_aktif == 1
                                                ? '<span class="badge bg-primary px-3 py-2 rounded-pill fs-6 fw-bold">Aktif</span>'
                                                : '<span class="badge bg-danger px-3 py-2 rounded-pill fs-6 fw-bold">Tidak Aktif</span>';
                                        @endphp
                                        {!! $statusBadge !!}
                                    </div>
                                    <div class="text-muted fw-semibold fs-5">
                                        NIY : {{ $guru->niy ?? '-' }} | NUPTK : {{ $guru->nuptk ?? '-' }}
                                    </div>
                                </div>

                                {{-- QUICK INFO GRID --}}
                                <div class="row g-3">
                                    <div class="col-md-6 col-lg-4">
                                        <div class="p-3 bg-light rounded-4 border border-light-subtle h-100">
                                            <small class="text-muted d-block fw-semibold mb-1"><i class="fas fa-id-card me-1"></i> NIK</small>
                                            <span class="fw-bold text-dark fs-6">{{ $guru->nik }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4">
                                        <div class="p-3 bg-light rounded-4 border border-light-subtle h-100">
                                            <small class="text-muted d-block fw-semibold mb-1"><i class="fas fa-calendar-alt me-1"></i> TTL</small>
                                            <span class="fw-bold text-dark fs-6">
                                                {{ $guru->tempat_lahir }},
                                                {{ $guru->tanggal_lahir ? \Carbon\Carbon::parse($guru->tanggal_lahir)->locale('id')->translatedFormat('d F Y') : '-' }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4">
                                        <div class="p-3 bg-light rounded-4 border border-light-subtle h-100">
                                            <small class="text-muted d-block fw-semibold mb-1"><i class="fas fa-user-tag me-1"></i> Jenis GTK</small>
                                            <span class="fw-bold text-dark fs-6">{{ $guru->jenis_gtk ?? '-' }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4">
                                        <div class="p-3 bg-light rounded-4 border border-light-subtle h-100">
                                            <small class="text-muted d-block fw-semibold mb-1"><i class="fas fa-briefcase me-1"></i> Jabatan GTK</small>
                                            <span class="fw-bold text-dark fs-6">{{ $guru->jabatan_gtk ?? '-' }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4">
                                        <div class="p-3 bg-light rounded-4 border border-light-subtle h-100">
                                            <small class="text-muted d-block fw-semibold mb-1"><i class="fas fa-venus-mars me-1"></i> Jenis Kelamin</small>
                                            <span class="fw-bold text-dark fs-6">{{ $guru->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4">
                                        <div class="p-3 bg-light rounded-4 border border-light-subtle h-100">
                                            <small class="text-muted d-block fw-semibold mb-1"><i class="fas fa-pray me-1"></i> Agama</small>
                                            <span class="fw-bold text-dark fs-6">{{ $guru->agama->nama_agama ?? '-' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        {{-- ALAMAT & BERKAS SUMMARY --}}
                        <div class="border-top mt-4 pt-4">
                            <div class="row g-4 align-items-center">
                                {{-- ALAMAT --}}
                                <div class="col-lg-8">
                                    <small class="text-muted d-block fw-bold mb-1"><i class="fas fa-map-marker-alt me-1 text-danger"></i> Alamat Lengkap</small>
                                    <div class="fw-bold text-dark fs-5 mb-1">{{ $guru->alamat }}</div>
                                    <div class="text-secondary fw-semibold">
                                        Desa {{ $guru->desaDetail->name ?? '-' }}, 
                                        Kec. {{ $guru->kecamatan->name ?? '-' }}, 
                                        Kab. {{ $guru->kabupaten->name ?? '-' }}, 
                                        Prov. {{ $guru->provinsi->name ?? '-' }}
                                    </div>
                                </div>

                                {{-- STATUS BERKAS --}}
                                <div class="col-lg-4">
                                    @php
                                        $totalBerkas = 6;
                                        $berkasLengkap = collect([
                                            $guru->foto,
                                            $guru->scan_kk,
                                            $guru->scan_akta,
                                            $guru->scan_ktp,
                                            $guru->scan_sk,
                                            $guru->scan_transkrip_nilai,
                                        ])
                                            ->filter()
                                            ->count();
                                    @endphp

                                    <div class="border rounded-4 p-3 bg-light-soft h-100 d-flex justify-content-between align-items-center">
                                        <div>
                                            <small class="text-muted d-block fw-semibold mb-1">Pemberkasan</small>
                                            @if ($berkasLengkap == $totalBerkas)
                                                <div class="fw-extrabold text-success fs-5"><i class="fas fa-check-circle me-1"></i> Lengkap</div>
                                            @else
                                                <div class="fw-extrabold text-warning fs-5"><i class="fas fa-exclamation-circle me-1"></i> Belum Lengkap</div>
                                            @endif
                                        </div>
                                        <div class="text-end">
                                            <span class="badge {{ $berkasLengkap == $totalBerkas ? 'bg-success' : 'bg-warning text-dark' }} px-3 py-2 fs-6 rounded-pill">
                                                {{ $berkasLengkap }} / {{ $totalBerkas }} Berkas
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- DETAIL TABS --}}
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4">
                        <ul class="nav nav-pills nav-pills-custom mb-4" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="pills-pendidikan-tab" data-bs-toggle="pill" data-bs-target="#tab-3" type="button" role="tab"><i class="fas fa-graduation-cap me-1"></i> Riwayat Pendidikan</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-kepegawaian-tab" data-bs-toggle="pill" data-bs-target="#tab-1" type="button" role="tab"><i class="fas fa-user-tie me-1"></i> Kepegawaian & Kontak</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-keluarga-tab" data-bs-toggle="pill" data-bs-target="#tab-2" type="button" role="tab"><i class="fas fa-users me-1"></i> Keluarga</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-berkas-tab" data-bs-toggle="pill" data-bs-target="#tab-4" type="button" role="tab"><i class="fas fa-folder-open me-1"></i> Data Berkas</button>
                            </li>
                        </ul>

                        <div class="tab-content" id="pills-tabContent">
                            {{-- TAB 1: DATA KEPEGAWAIAN & KONTAK --}}
                            <div class="tab-pane fade" id="tab-1" role="tabpanel">
                                <h4 class="fw-bold mb-3 text-dark"><i class="fas fa-info-circle me-1 text-primary"></i> Data Kepegawaian & Kontak</h4>
                                <div class="row border rounded-4 bg-white overflow-hidden g-0">
                                    <div class="col-md-6">
                                        <div class="detail-row">
                                            <div class="detail-label"><i class="fas fa-id-card-alt text-muted"></i> Status Kepegawaian</div>
                                            <div class="detail-value text-dark">{{ $guru->status_kepegawaian ?? '-' }}</div>
                                        </div>
                                        <div class="detail-row">
                                            <div class="detail-label"><i class="fas fa-file-contract text-muted"></i> SK Pengangkatan</div>
                                            <div class="detail-value text-dark">{{ $guru->sk_pengangkatan ?? '-' }}</div>
                                        </div>
                                        <div class="detail-row">
                                            <div class="detail-label"><i class="fas fa-calendar-check text-muted"></i> TMT Pengangkatan</div>
                                            <div class="detail-value text-dark">
                                                {{ $guru->tmt_pengangkatan ? \Carbon\Carbon::parse($guru->tmt_pengangkatan)->locale('id')->translatedFormat('d F Y') : '-' }}
                                            </div>
                                        </div>
                                        <div class="detail-row">
                                            <div class="detail-label"><i class="fas fa-landmark text-muted"></i> Lembaga Pengangkat</div>
                                            <div class="detail-value text-dark text-uppercase">{{ $guru->lembaga_pengangkat ?? '-' }}</div>
                                        </div>
                                        <div class="detail-row">
                                            <div class="detail-label"><i class="fas fa-file-signature text-muted"></i> No. Surat Tugas</div>
                                            <div class="detail-value text-dark">{{ $guru->no_surat_tugas ?? '-' }}</div>
                                        </div>
                                        <div class="detail-row">
                                            <div class="detail-label"><i class="fas fa-calendar-day text-muted"></i> Tanggal Surat Tugas</div>
                                            <div class="detail-value text-dark">
                                                {{ $guru->tgl_surat_tugas ? \Carbon\Carbon::parse($guru->tgl_surat_tugas)->locale('id')->translatedFormat('d F Y') : '-' }}
                                            </div>
                                        </div>
                                        <div class="detail-row">
                                            <div class="detail-label"><i class="fas fa-hourglass-end text-muted"></i> Tahun Pensiun</div>
                                            <div class="detail-value text-dark">{{ $guru->tahun_pensiun ?? '-' }}</div>
                                        </div>
                                        <div class="detail-row">
                                            <div class="detail-label"><i class="fas fa-ring text-muted"></i> Status Perkawinan</div>
                                            <div class="detail-value text-dark">{{ ucwords($guru->status_perkawinan ?? '-') }}</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 border-start">
                                        <div class="detail-row">
                                            <div class="detail-label"><i class="fas fa-percent text-muted"></i> NPWP</div>
                                            <div class="detail-value text-dark">{{ $guru->npwp ?? '-' }}</div>
                                        </div>
                                        <div class="detail-row">
                                            <div class="detail-label"><i class="fas fa-user-tag text-muted"></i> Nama Wajib Pajak</div>
                                            <div class="detail-value text-dark text-uppercase">{{ $guru->nama_wajib_pajak ?? '-' }}</div>
                                        </div>
                                        <div class="detail-row">
                                            <div class="detail-label"><i class="fas fa-graduation-cap text-muted"></i> Status Kuliah</div>
                                            <div class="detail-value text-dark">
                                                {{ $guru->status_kuliah == '1' ? 'Ya / Sedang Kuliah' : 'Tidak' }}
                                            </div>
                                        </div>
                                        <div class="detail-row">
                                            <div class="detail-label"><i class="fas fa-users-cog text-muted"></i> Jenis GTK</div>
                                            <div class="detail-value text-dark">{{ $guru->jenis_gtk ?? '-' }}</div>
                                        </div>
                                        <div class="detail-row">
                                            <div class="detail-label"><i class="fas fa-user-shield text-muted"></i> Jabatan GTK</div>
                                            <div class="detail-value text-dark">{{ $guru->jabatan_gtk ?? '-' }}</div>
                                        </div>
                                        <div class="detail-row">
                                            <div class="detail-label"><i class="fas fa-envelope text-muted"></i> Email</div>
                                            <div class="detail-value text-dark">{{ $guru->email ?? '-' }}</div>
                                        </div>
                                        <div class="detail-row">
                                            <div class="detail-label"><i class="fas fa-phone text-muted"></i> No. HP</div>
                                            <div class="detail-value text-dark fw-bold">{{ $guru->no_hp ?? '-' }}</div>
                                        </div>
                                        <div class="detail-row">
                                            <div class="detail-label"><i class="fas fa-mail-bulk text-muted"></i> Kode Pos</div>
                                            <div class="detail-value text-dark">{{ $guru->pos ?? '-' }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- TAB 2: KELUARGA --}}
                            <div class="tab-pane fade" id="tab-2" role="tabpanel">
                                <h4 class="fw-bold mb-3 text-dark"><i class="fas fa-users text-primary mb-0"></i> Informasi Keluarga</h4>
                                <div class="row g-4">
                                    {{-- IBU KANDUNG --}}
                                    <div class="col-md-6">
                                        <div class="parent-card">
                                            <div class="parent-header d-flex justify-content-between align-items-center">
                                                <h5 class="fw-bold text-danger mb-0"><i class="fas fa-female me-1 fs-5"></i> IBU KANDUNG</h5>
                                                <span class="info-pill bg-danger-subtle text-danger border-danger-subtle">IBU</span>
                                            </div>
                                            <div class="p-3">
                                                <div class="detail-row">
                                                    <div class="detail-label">Nama Ibu</div>
                                                    <div class="detail-value text-uppercase text-dark">{{ $guru->keluarga->nama_ibu ?? '-' }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- PASANGAN --}}
                                    @if ($guru->status_perkawinan == 'kawin')
                                        <div class="col-md-6">
                                            <div class="parent-card">
                                                <div class="parent-header d-flex justify-content-between align-items-center">
                                                    <h5 class="fw-bold text-primary mb-0"><i class="fas fa-ring me-1 fs-5"></i> PASANGAN (SUAMI / ISTRI)</h5>
                                                    <span class="info-pill">PASANGAN</span>
                                                </div>
                                                <div class="p-3">
                                                    <div class="detail-row">
                                                        <div class="detail-label">Nama Pasangan</div>
                                                        <div class="detail-value text-uppercase text-dark">{{ $guru->keluarga->nama_pasangan ?? '-' }}</div>
                                                    </div>
                                                    <div class="detail-row">
                                                        <div class="detail-label">Pekerjaan Pasangan</div>
                                                        <div class="detail-value">{{ $guru->keluarga->pekerjaanPasangan->nama_pekerjaan ?? '-' }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            {{-- TAB 3: RIWAYAT PENDIDIKAN --}}
                            <div class="tab-pane fade show active" id="tab-3" role="tabpanel">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h4 class="fw-bold text-dark mb-0"><i class="fas fa-graduation-cap text-primary me-1"></i> Riwayat Pendidikan</h4>
                                    <button class="btn btn-primary btn-sm shadow-sm" data-bs-toggle="modal"
                                        data-bs-target="#modalTambahPendidikan">
                                        <i class="fas fa-plus"></i> Tambah Riwayat Pendidikan
                                    </button>
                                </div>
                                <div class="table-responsive border rounded-4 bg-white overflow-hidden">
                                    <table class="table table-striped table-hover mb-0">
                                        <thead class="bg-light">
                                            <tr>
                                                <th style="width: 5%">No</th>
                                                <th>Jenjang</th>
                                                <th>Nama Instansi</th>
                                                <th>Jurusan</th>
                                                <th>Tahun Masuk</th>
                                                <th>Tahun Lulus</th>
                                                <th>Nomor Ijazah</th>
                                                <th style="width: 15%">File Ijazah</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($guru->pendidikan as $index => $edu)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td><span class="badge bg-secondary-subtle text-secondary px-3 py-1.5 rounded-pill fw-bold">{{ $edu->jenjang }}</span></td>
                                                    <td class="fw-semibold text-dark">{{ $edu->nama_instansi }}</td>
                                                    <td>{{ $edu->jurusan ?? '-' }}</td>
                                                    <td>{{ $edu->tahun_masuk }}</td>
                                                    <td>{{ $edu->tahun_lulus }}</td>
                                                    <td>{{ $edu->nomor_ijazah ?? '-' }}</td>
                                                    <td>
                                                        @if ($edu->scan_file_ijazah)
                                                            @php
                                                                $edu_path = 'gambar_berkas/berkas_guru/' . $edu->scan_file_ijazah;
                                                            @endphp
                                                            <div class="d-flex gap-1">
                                                                <button class="btn btn-sm btn-info text-white fw-bold shadow-xs px-3"
                                                                    onclick="openPreview('{{ asset($edu_path) }}', 'Ijazah {{ $edu->jenjang }}')">
                                                                    <i class="fas fa-eye"></i> Lihat
                                                                </button>
                                                                <a href="{{ route('guru.pendidikan.download', $edu->id) }}"
                                                                    class="btn btn-sm btn-primary fw-bold shadow-xs px-3">
                                                                    <i class="fas fa-download"></i> Unduh
                                                                </a>
                                                            </div>
                                                        @else
                                                            <span class="text-muted"><i class="fas fa-times-circle"></i> Tidak Ada</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="8" class="text-center text-muted py-4">Belum ada riwayat pendidikan.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            {{-- TAB 4: DATA BERKAS --}}
                            <div class="tab-pane fade" id="tab-4" role="tabpanel">
                                <h4 class="fw-bold mb-3 text-dark"><i class="fas fa-folder-open text-primary me-1"></i> Dokumen Pendukung & Berkas</h4>
                                <div class="row g-4 justify-content-center">
                                    @php
                                        $foto_file = $guru->foto
                                            ? 'gambar_berkas/berkas_guru/' . $guru->foto
                                            : 'asset_admin/img/notfound.png';
                                        $isFotoPdf = strtolower(pathinfo($foto_file, PATHINFO_EXTENSION)) === 'pdf';

                                        $kk_file = $guru->scan_kk
                                            ? 'gambar_berkas/berkas_guru/' . $guru->scan_kk
                                            : 'asset_admin/img/notfound.png';
                                        $isKkPdf = strtolower(pathinfo($kk_file, PATHINFO_EXTENSION)) === 'pdf';

                                        $akta_file = $guru->scan_akta
                                            ? 'gambar_berkas/berkas_guru/' . $guru->scan_akta
                                            : 'asset_admin/img/notfound.png';
                                        $isAktaPdf = strtolower(pathinfo($akta_file, PATHINFO_EXTENSION)) === 'pdf';

                                        $ktp_file = $guru->scan_ktp
                                            ? 'gambar_berkas/berkas_guru/' . $guru->scan_ktp
                                            : 'asset_admin/img/notfound.png';
                                        $isKtpPdf = strtolower(pathinfo($ktp_file, PATHINFO_EXTENSION)) === 'pdf';

                                        $sk_file = $guru->scan_sk
                                            ? 'gambar_berkas/berkas_guru/' . $guru->scan_sk
                                            : 'asset_admin/img/notfound.png';
                                        $isSkPdf = strtolower(pathinfo($sk_file, PATHINFO_EXTENSION)) === 'pdf';

                                        $transkrip_file = $guru->scan_transkrip_nilai
                                            ? 'gambar_berkas/berkas_guru/' . $guru->scan_transkrip_nilai
                                            : 'asset_admin/img/notfound.png';
                                        $isTranskripPdf = strtolower(pathinfo($transkrip_file, PATHINFO_EXTENSION)) === 'pdf';
                                    @endphp

                                    {{-- FOTO GURU --}}
                                    <div class="col-md-6 col-lg-4">
                                        <div class="doc-card p-3 shadow-xs text-center h-100 d-flex flex-column justify-content-between">
                                            <div>
                                                <h6 class="fw-extrabold text-dark mb-2"><i class="far fa-image text-primary me-1"></i> Foto Guru</h6>
                                                <div class="doc-img-container shadow-xs mb-3 border">
                                                    @if($isFotoPdf)
                                                        <i class="far fa-file-pdf text-danger fs-1" style="cursor: pointer;" onclick="openPreview('{{ asset($foto_file) }}', 'Foto Guru')"></i>
                                                    @else
                                                        <img src="{{ asset($foto_file) }}" alt="Foto Guru" style="cursor:pointer;"
                                                            onclick="openPreview('{{ asset($foto_file) }}', 'Foto Guru')">
                                                    @endif
                                                </div>
                                            </div>
                                            <div>
                                                @if ($guru->foto)
                                                    <a href="{{ route('guru.download.berkas', [$guru, 'foto']) }}"
                                                        class="btn btn-primary btn-sm w-100 py-2 fw-semibold shadow-xs"><i
                                                            class="fas fa-download me-1"></i> Unduh Berkas</a>
                                                @else
                                                    <button class="btn btn-secondary btn-sm w-100 py-2" disabled><i
                                                            class="fas fa-times me-1"></i> Belum Diunggah</button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    {{-- KARTU KELUARGA --}}
                                    <div class="col-md-6 col-lg-4">
                                        <div class="doc-card p-3 shadow-xs text-center h-100 d-flex flex-column justify-content-between">
                                            <div>
                                                <h6 class="fw-extrabold text-dark mb-2"><i class="far fa-file-alt text-primary me-1"></i> Kartu Keluarga</h6>
                                                <div class="doc-img-container shadow-xs mb-3 border">
                                                    @if($isKkPdf)
                                                        <i class="far fa-file-pdf text-danger fs-1" style="cursor: pointer;" onclick="openPreview('{{ asset($kk_file) }}', 'Kartu Keluarga')"></i>
                                                    @else
                                                        <img src="{{ asset($kk_file) }}" alt="Kartu Keluarga" style="cursor:pointer;"
                                                            onclick="openPreview('{{ asset($kk_file) }}', 'Kartu Keluarga')">
                                                    @endif
                                                </div>
                                            </div>
                                            <div>
                                                @if ($guru->scan_kk)
                                                    <a href="{{ route('guru.download.berkas', [$guru, 'scan_kk']) }}"
                                                        class="btn btn-primary btn-sm w-100 py-2 fw-semibold shadow-xs"><i
                                                            class="fas fa-download me-1"></i> Unduh Berkas</a>
                                                @else
                                                    <button class="btn btn-secondary btn-sm w-100 py-2" disabled><i
                                                            class="fas fa-times me-1"></i> Belum Diunggah</button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    {{-- AKTA LAHIR --}}
                                    <div class="col-md-6 col-lg-4">
                                        <div class="doc-card p-3 shadow-xs text-center h-100 d-flex flex-column justify-content-between">
                                            <div>
                                                <h6 class="fw-extrabold text-dark mb-2"><i class="far fa-file-alt text-primary me-1"></i> Akta Kelahiran</h6>
                                                <div class="doc-img-container shadow-xs mb-3 border">
                                                    @if($isAktaPdf)
                                                        <i class="far fa-file-pdf text-danger fs-1" style="cursor: pointer;" onclick="openPreview('{{ asset($akta_file) }}', 'Akta Kelahiran')"></i>
                                                    @else
                                                        <img src="{{ asset($akta_file) }}" alt="Akta Kelahiran" style="cursor:pointer;"
                                                            onclick="openPreview('{{ asset($akta_file) }}', 'Akta Kelahiran')">
                                                    @endif
                                                </div>
                                            </div>
                                            <div>
                                                @if ($guru->scan_akta)
                                                    <a href="{{ route('guru.download.berkas', [$guru, 'scan_akta']) }}"
                                                        class="btn btn-primary btn-sm w-100 py-2 fw-semibold shadow-xs"><i
                                                            class="fas fa-download me-1"></i> Unduh Berkas</a>
                                                @else
                                                    <button class="btn btn-secondary btn-sm w-100 py-2" disabled><i
                                                            class="fas fa-times me-1"></i> Belum Diunggah</button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    {{-- KTP --}}
                                    <div class="col-md-6 col-lg-4">
                                        <div class="doc-card p-3 shadow-xs text-center h-100 d-flex flex-column justify-content-between">
                                            <div>
                                                <h6 class="fw-extrabold text-dark mb-2"><i class="far fa-id-card text-primary me-1"></i> KTP</h6>
                                                <div class="doc-img-container shadow-xs mb-3 border">
                                                    @if($isKtpPdf)
                                                        <i class="far fa-file-pdf text-danger fs-1" style="cursor: pointer;" onclick="openPreview('{{ asset($ktp_file) }}', 'KTP')"></i>
                                                    @else
                                                        <img src="{{ asset($ktp_file) }}" alt="KTP" style="cursor:pointer;"
                                                            onclick="openPreview('{{ asset($ktp_file) }}', 'KTP')">
                                                    @endif
                                                </div>
                                            </div>
                                            <div>
                                                @if ($guru->scan_ktp)
                                                    <a href="{{ route('guru.download.berkas', [$guru, 'scan_ktp']) }}"
                                                        class="btn btn-primary btn-sm w-100 py-2 fw-semibold shadow-xs"><i
                                                            class="fas fa-download me-1"></i> Unduh Berkas</a>
                                                @else
                                                    <button class="btn btn-secondary btn-sm w-100 py-2" disabled><i
                                                            class="fas fa-times me-1"></i> Belum Diunggah</button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    {{-- SK KEPEGAWAIAN --}}
                                    <div class="col-md-6 col-lg-4">
                                        <div class="doc-card p-3 shadow-xs text-center h-100 d-flex flex-column justify-content-between">
                                            <div>
                                                <h6 class="fw-extrabold text-dark mb-2"><i class="far fa-file-alt text-primary me-1"></i> SK Kepegawaian</h6>
                                                <div class="doc-img-container shadow-xs mb-3 border">
                                                    @if($isSkPdf)
                                                        <i class="far fa-file-pdf text-danger fs-1" style="cursor: pointer;" onclick="openPreview('{{ asset($sk_file) }}', 'SK Kepegawaian')"></i>
                                                    @else
                                                        <img src="{{ asset($sk_file) }}" alt="SK Kepegawaian" style="cursor:pointer;"
                                                            onclick="openPreview('{{ asset($sk_file) }}', 'SK Kepegawaian')">
                                                    @endif
                                                </div>
                                            </div>
                                            <div>
                                                @if ($guru->scan_sk)
                                                    <a href="{{ route('guru.download.berkas', [$guru, 'scan_sk']) }}"
                                                        class="btn btn-primary btn-sm w-100 py-2 fw-semibold shadow-xs"><i
                                                            class="fas fa-download me-1"></i> Unduh Berkas</a>
                                                @else
                                                    <button class="btn btn-secondary btn-sm w-100 py-2" disabled><i
                                                            class="fas fa-times me-1"></i> Belum Diunggah</button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    {{-- TRANSKRIP NILAI --}}
                                    <div class="col-md-6 col-lg-4">
                                        <div class="doc-card p-3 shadow-xs text-center h-100 d-flex flex-column justify-content-between">
                                            <div>
                                                <h6 class="fw-extrabold text-dark mb-2"><i class="far fa-file-alt text-primary me-1"></i> Transkrip Nilai</h6>
                                                <div class="doc-img-container shadow-xs mb-3 border">
                                                    @if($isTranskripPdf)
                                                        <i class="far fa-file-pdf text-danger fs-1" style="cursor: pointer;" onclick="openPreview('{{ asset($transkrip_file) }}', 'Transkrip Nilai')"></i>
                                                    @else
                                                        <img src="{{ asset($transkrip_file) }}" alt="Transkrip Nilai" style="cursor:pointer;"
                                                            onclick="openPreview('{{ asset($transkrip_file) }}', 'Transkrip Nilai')">
                                                    @endif
                                                </div>
                                            </div>
                                            <div>
                                                @if ($guru->scan_transkrip_nilai)
                                                    <a href="{{ route('guru.download.berkas', [$guru, 'scan_transkrip_nilai']) }}"
                                                        class="btn btn-primary btn-sm w-100 py-2 fw-semibold shadow-xs"><i
                                                            class="fas fa-download me-1"></i> Unduh Berkas</a>
                                                @else
                                                    <button class="btn btn-secondary btn-sm w-100 py-2" disabled><i
                                                            class="fas fa-times me-1"></i> Belum Diunggah</button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Preview Berkas -->
    <div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="modal-header bg-dark text-white border-0 py-3">
                    <h5 class="modal-title text-white fw-bold" id="previewModalLabel">Pratinjau Berkas</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center bg-dark p-3 rounded-bottom d-flex align-items-center justify-content-center">
                    <img id="modalPreviewImg" src="" class="img-fluid rounded-3 shadow"
                        style="max-height: 75vh; object-fit: contain;">
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Pendidikan -->
    <div class="modal fade" id="modalTambahPendidikan" tabindex="-1" aria-labelledby="modalTambahPendidikanLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                <form id="formPendidikan" data-parsley-validate enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="guru_id" value="{{ $guru->id }}">
                    <div class="modal-header bg-primary text-white py-3 border-0">
                        <h5 class="modal-title text-white fw-bold" id="modalTambahPendidikanLabel">Tambah Riwayat Pendidikan</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Jenjang Pendidikan</label>
                            <select name="jenjang" class="form-select text-uppercase" required>
                                <option value="">Pilih Jenjang</option>
                                <option value="SD">SD</option>
                                <option value="SMP">SMP</option>
                                <option value="SMA">SMA</option>
                                <option value="D1">D1</option>
                                <option value="D2">D2</option>
                                <option value="D3">D3</option>
                                <option value="D4">D4</option>
                                <option value="S1">S1</option>
                                <option value="S2">S2</option>
                                <option value="S3">S3</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nama Instansi (Sekolah / Kampus)</label>
                            <input type="text" name="nama_instansi" class="form-control text-uppercase" required
                                placeholder="CONTOH: UNIVERSITAS INDONESIA">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Jurusan</label>
                            <input type="text" name="jurusan" class="form-control text-uppercase"
                                placeholder="CONTOH: TEKNIK INFORMATIKA (KOSONGKAN JIKA SD/SMP)">
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Tahun Masuk</label>
                                <input type="number" name="tahun_masuk" class="form-control" required min="1900"
                                    max="2100" placeholder="CONTOH: 2018" data-parsley-type="integer"
                                    data-parsley-length="[4, 4]">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Tahun Lulus</label>
                                <input type="number" name="tahun_lulus" class="form-control" required min="1900"
                                    max="2100" placeholder="CONTOH: 2022" data-parsley-type="integer"
                                    data-parsley-length="[4, 4]">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nomor Ijazah</label>
                            <input type="text" name="nomor_ijazah" class="form-control text-uppercase"
                                placeholder="NOMOR IJAZAH">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Scan File Ijazah</label>
                            <input type="file" name="scan_file_ijazah" class="form-control"
                                accept="image/png, image/jpeg, image/jpg, application/pdf" data-parsley-filemaxsize="2"
                                data-parsley-fileextension="jpg,jpeg,png,pdf">
                            <div class="form-text">Maksimal 2 MB (Format: JPG, JPEG, PNG, atau PDF)</div>
                        </div>
                    </div>
                    <div class="modal-footer bg-light border-0 py-3">
                        <button type="button" class="btn btn-secondary px-4 fw-semibold" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary px-4 fw-semibold"><i class="fas fa-save me-1"></i> Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function openPreview(url, title) {
            $('#previewModalLabel').text('Pratinjau: ' + title);

            // Check if file is PDF
            if (url.toLowerCase().endsWith('.pdf')) {
                $('#modalPreviewImg').hide();
                let iframe = `<iframe src="${url}" style="width:100%; height:70vh; border:none; border-radius:8px;"></iframe>`;
                if ($('#modalPreviewPdf').length === 0) {
                    $('.modal-body').append('<div id="modalPreviewPdf" style="width:100%;"></div>');
                }
                $('#modalPreviewPdf').html(iframe).show();
            } else {
                $('#modalPreviewPdf').hide();
                $('#modalPreviewImg').attr('src', url).show();
            }

            var myModal = new bootstrap.Modal(document.getElementById('previewModal'));
            myModal.show();
        }

        // Register Parsley Custom Validators for File Size and File Extension
        window.Parsley.addValidator('filemaxsize', {
            validateString: function(value, maxSize, parsleyInstance) {
                var files = parsleyInstance.$element[0].files;
                if (files.length === 0) {
                    return true;
                }
                return files[0].size <= maxSize * 1024 * 1024;
            },
            requirementType: 'number',
            messages: {
                id: 'Ukuran file maksimal %s MB.',
                en: 'File size must be at most %s MB.'
            }
        });

        window.Parsley.addValidator('fileextension', {
            validateString: function(value, requirement, parsleyInstance) {
                var files = parsleyInstance.$element[0].files;
                if (files.length === 0) {
                    return true;
                }
                var file = files[0];
                var extensions = requirement.toLowerCase().split(',');
                var ext = file.name.split('.').pop().toLowerCase();
                return extensions.indexOf(ext) > -1;
            },
            requirementType: 'string',
            messages: {
                id: 'Format file harus berupa: %s.',
                en: 'Allowed formats: %s.'
            }
        });

        $(document).ready(function() {
            $('#formPendidikan').on('submit', function(e) {
                e.preventDefault();
                let formData = new FormData(this);
                $(this).parsley().validate();
                if ($(this).parsley().isValid()) {
                    $('#loader').css('display', 'flex');
                    let modalEl = document.getElementById('modalTambahPendidikan');
                    let modal = bootstrap.Modal.getInstance(modalEl);
                    if (modal) {
                        modal.hide();
                    }
                    $.ajax({
                        url: "{{ route('guru.pendidikan.store') }}",
                        type: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            $('#loader').css('display', 'none');
                            if (response.status == 'success') {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: response.message,
                                }).then(() => {
                                    window.location.reload();
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal',
                                    text: response.message,
                                }).then(() => {
                                    if (modal) {
                                        modal.show();
                                    }
                                });
                            }
                        },
                        error: function(xhr) {
                            $('#loader').css('display', 'none');
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Terjadi kesalahan pada server.',
                            }).then(() => {
                                if (modal) {
                                    modal.show();
                                }
                            });
                        }
                    });
                }
            });
        });
    </script>
@endpush
