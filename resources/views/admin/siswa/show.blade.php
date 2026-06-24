@extends('template')
@section('content')
    @php
        $defaultAvatar = $siswa->jenis_kelamin === 'Perempuan' ? 'female.png' : 'male.png';
        $foto = $siswa->foto_warna_santri
            ? asset('gambar_berkas/berkas_siswa/' . $siswa->foto_warna_santri)
            : asset('asset_admin/img/avatars/' . $defaultAvatar);
        $murid = $siswa;
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
                <h3 class="mb-0 text-dark fw-bold"><strong>Detail Siswa</strong></h3>
            </div>
            <div class="col text-end">
                <a href="{{ route('siswa') }}" class="btn btn-outline-secondary shadow-sm px-4 fw-bold">
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
                                @if ($siswa->foto_warna_santri)
                                    <div class="mt-3 px-3">
                                        <a href="{{ route('siswa.download.berkas', [$siswa, 'foto_warna_santri']) }}"
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
                                            {{ strtoupper($murid->nama) }}
                                        </h2>
                                        @php
                                            $statusBadge = '';
                                            if ($murid->status == 'Aktif') {
                                                $statusBadge = '<span class="badge bg-primary px-3 py-2 rounded-pill fs-6 fw-bold">Aktif</span>';
                                            } elseif ($murid->status == 'Lulus') {
                                                $statusBadge = '<span class="badge bg-success px-3 py-2 rounded-pill fs-6 fw-bold">Lulus</span>';
                                            } elseif ($murid->status == 'Pindah') {
                                                $statusBadge = '<span class="badge bg-warning text-dark px-3 py-2 rounded-pill fs-6 fw-bold">Mutasi Keluar</span>';
                                            } elseif ($murid->status == 'Keluar') {
                                                $statusBadge = '<span class="badge bg-danger px-3 py-2 rounded-pill fs-6 fw-bold">Berhenti</span>';
                                            }
                                        @endphp
                                        {!! $statusBadge !!}
                                    </div>
                                    <div class="text-muted fw-semibold fs-5">
                                        NISN : {{ $murid->nisn ?? '-' }} | NIS : {{ $murid->nis ?? '-' }}
                                    </div>
                                </div>

                                {{-- QUICK INFO GRID --}}
                                <div class="row g-3">
                                    <div class="col-md-6 col-lg-4">
                                        <div class="p-3 bg-light rounded-4 border border-light-subtle h-100">
                                            <small class="text-muted d-block fw-semibold mb-1"><i class="fas fa-id-card me-1"></i> NIK</small>
                                            <span class="fw-bold text-dark fs-6">{{ $murid->nik }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4">
                                        <div class="p-3 bg-light rounded-4 border border-light-subtle h-100">
                                            <small class="text-muted d-block fw-semibold mb-1"><i class="fas fa-calendar-alt me-1"></i> TTL</small>
                                            <span class="fw-bold text-dark fs-6">
                                                {{ $murid->tempat_lahir }},
                                                {{ $murid->tanggal_lahir ? \Carbon\Carbon::parse($murid->tanggal_lahir)->locale('id')->translatedFormat('d F Y') : '-' }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4">
                                        <div class="p-3 bg-light rounded-4 border border-light-subtle h-100">
                                            <small class="text-muted d-block fw-semibold mb-1"><i class="fas fa-graduation-cap me-1"></i> Jurusan</small>
                                            <span class="fw-bold text-dark fs-6">{{ $murid->jurusan->program_keahlian ?? '-' }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4">
                                        <div class="p-3 bg-light rounded-4 border border-light-subtle h-100">
                                            <small class="text-muted d-block fw-semibold mb-1"><i class="fas fa-school me-1"></i> Asal Sekolah</small>
                                            <span class="fw-bold text-dark fs-6">{{ $murid->asal_sekolah ?? '-' }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4">
                                        <div class="p-3 bg-light rounded-4 border border-light-subtle h-100">
                                            <small class="text-muted d-block fw-semibold mb-1"><i class="fas fa-venus-mars me-1"></i> Jenis Kelamin</small>
                                            <span class="fw-bold text-dark fs-6">{{ $murid->jenis_kelamin }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4">
                                        <div class="p-3 bg-light rounded-4 border border-light-subtle h-100">
                                            <small class="text-muted d-block fw-semibold mb-1"><i class="fas fa-pray me-1"></i> Agama</small>
                                            <span class="fw-bold text-dark fs-6">{{ $murid->agama->nama_agama ?? '-' }}</span>
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
                                    <div class="fw-bold text-dark fs-5 mb-1">{{ $murid->alamat_lengkap }}</div>
                                    <div class="text-secondary fw-semibold">
                                        Desa {{ $murid->desaDetail->name ?? '-' }}, 
                                        Kec. {{ $murid->kecamatan->name ?? '-' }}, 
                                        Kab. {{ $murid->kabupaten->name ?? '-' }}, 
                                        Prov. {{ $murid->provinsi->name ?? '-' }}
                                    </div>
                                </div>

                                {{-- STATUS BERKAS --}}
                                <div class="col-lg-4">
                                    @php
                                        $totalBerkas = 5;
                                        $berkasLengkap = collect([
                                            $murid->foto_scan_kk,
                                            $murid->foto_scan_akta,
                                            $murid->foto_scan_ket_sehat,
                                            $murid->foto_ijazah,
                                            $murid->foto_scan_skck,
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
                                <button class="nav-link active" id="pills-diri-tab" data-bs-toggle="pill" data-bs-target="#tab-1" type="button" role="tab"><i class="fas fa-user-tag me-1"></i> Data Diri Tambahan</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-ortu-tab" data-bs-toggle="pill" data-bs-target="#tab-2" type="button" role="tab"><i class="fas fa-users-cog me-1"></i> Orang Tua</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-wali-tab" data-bs-toggle="pill" data-bs-target="#tab-3" type="button" role="tab"><i class="fas fa-user-shield me-1"></i> Data Wali</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-berkas-tab" data-bs-toggle="pill" data-bs-target="#tab-4" type="button" role="tab"><i class="fas fa-folder-open me-1"></i> Data Berkas</button>
                            </li>
                        </ul>

                        <div class="tab-content" id="pills-tabContent">
                            {{-- TAB 1: DATA DIRI TAMBAHAN --}}
                            <div class="tab-pane fade show active" id="tab-1" role="tabpanel">
                                <h4 class="fw-bold mb-3 text-dark"><i class="fas fa-info-circle me-1 text-primary"></i> Data Diri Tambahan</h4>
                                <div class="row border rounded-4 bg-white overflow-hidden g-0">
                                    <div class="col-md-6">
                                        <div class="detail-row">
                                            <div class="detail-label"><i class="fas fa-credit-card text-muted"></i> No KK</div>
                                            <div class="detail-value text-dark">{{ $siswa->no_kk }}</div>
                                        </div>
                                        <div class="detail-row">
                                            <div class="detail-label"><i class="fas fa-file-invoice text-muted"></i> Registrasi Akta</div>
                                            <div class="detail-value text-dark">{{ $siswa->no_akta }}</div>
                                        </div>
                                        <div class="detail-row">
                                            <div class="detail-label"><i class="fas fa-mosque text-muted"></i> NIUP (Pesantren)</div>
                                            <div class="detail-value text-dark">{{ $siswa->niup ?? '-' }}</div>
                                        </div>
                                        <div class="detail-row">
                                            <div class="detail-label"><i class="fas fa-globe text-muted"></i> Kewarganegaraan</div>
                                            <div class="detail-value text-dark">{{ $siswa->kewarganegaraan ?? '-' }}</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 border-start">
                                        <div class="detail-row">
                                            <div class="detail-label"><i class="fas fa-users text-muted"></i> Jumlah Saudara</div>
                                            <div class="detail-value text-dark">{{ $siswa->sdr ?? '-' }}</div>
                                        </div>
                                        <div class="detail-row">
                                            <div class="detail-label"><i class="fas fa-gamepad text-muted"></i> Hobi</div>
                                            <div class="detail-value text-dark text-uppercase">{{ $siswa->hoby }}</div>
                                        </div>
                                        <div class="detail-row">
                                            <div class="detail-label"><i class="fas fa-bullseye text-muted"></i> Cita-cita</div>
                                            <div class="detail-value text-dark text-uppercase">{{ $siswa->cita_cita }}</div>
                                        </div>
                                        <div class="detail-row">
                                            <div class="detail-label"><i class="fas fa-ruler-vertical text-muted"></i> Tinggi / Berat</div>
                                            <div class="detail-value text-dark">{{ $siswa->tinggi_badan }} cm / {{ $siswa->berat_badan }} kg</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- TAB 2: ORANG TUA --}}
                            <div class="tab-pane fade" id="tab-2" role="tabpanel">
                                <h4 class="fw-bold mb-3 text-dark"><i class="fas fa-users text-primary me-1"></i> Informasi Orang Tua</h4>
                                <div class="row g-4">
                                    {{-- AYAH --}}
                                    <div class="col-md-6">
                                        <div class="parent-card">
                                            <div class="parent-header d-flex justify-content-between align-items-center">
                                                <h5 class="fw-bold text-primary mb-0"><i class="fas fa-male me-1 fs-5"></i> BIODATA AYAH</h5>
                                                <span class="info-pill">AYAH</span>
                                            </div>
                                            <div class="p-3">
                                                <div class="detail-row">
                                                    <div class="detail-label">NIK</div>
                                                    <div class="detail-value">{{ $siswa->nik_a }}</div>
                                                </div>
                                                <div class="detail-row">
                                                    <div class="detail-label">Nama Lengkap</div>
                                                    <div class="detail-value text-uppercase text-dark">{{ $siswa->nm_a }}</div>
                                                </div>
                                                <div class="detail-row">
                                                    <div class="detail-label">Pendidikan</div>
                                                    <div class="detail-value">{{ $siswa->pendidikanAyah->jenjang ?? '-' }}</div>
                                                </div>
                                                <div class="detail-row">
                                                    <div class="detail-label">Pekerjaan</div>
                                                    <div class="detail-value">{{ $siswa->pekerjaanAyah->nama_pekerjaan ?? '-' }}</div>
                                                </div>
                                                <div class="detail-row">
                                                    <div class="detail-label">Penghasilan</div>
                                                    <div class="detail-value"><span class="badge bg-light text-dark border py-1.5 px-3 fs-7">{{ $siswa->penghasilanAyah->kategori ?? '-' }}</span></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- IBU --}}
                                    <div class="col-md-6">
                                        <div class="parent-card">
                                            <div class="parent-header d-flex justify-content-between align-items-center">
                                                <h5 class="fw-bold text-danger mb-0"><i class="fas fa-female me-1 fs-5"></i> BIODATA IBU</h5>
                                                <span class="info-pill bg-danger-subtle text-danger border-danger-subtle">IBU</span>
                                            </div>
                                            <div class="p-3">
                                                <div class="detail-row">
                                                    <div class="detail-label">NIK</div>
                                                    <div class="detail-value">{{ $siswa->nik_i }}</div>
                                                </div>
                                                <div class="detail-row">
                                                    <div class="detail-label">Nama Lengkap</div>
                                                    <div class="detail-value text-uppercase text-dark">{{ $siswa->nm_i }}</div>
                                                </div>
                                                <div class="detail-row">
                                                    <div class="detail-label">Pendidikan</div>
                                                    <div class="detail-value">{{ $siswa->pendidikanIbu->jenjang ?? '-' }}</div>
                                                </div>
                                                <div class="detail-row">
                                                    <div class="detail-label">Pekerjaan</div>
                                                    <div class="detail-value">{{ $siswa->pekerjaanIbu->nama_pekerjaan ?? '-' }}</div>
                                                </div>
                                                <div class="detail-row">
                                                    <div class="detail-label">Penghasilan</div>
                                                    <div class="detail-value"><span class="badge bg-light text-dark border py-1.5 px-3 fs-7">{{ $siswa->penghasilanIbu->kategori ?? '-' }}</span></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- TAB 3: DATA WALI --}}
                            <div class="tab-pane fade" id="tab-3" role="tabpanel">
                                <h4 class="fw-bold mb-3 text-dark"><i class="fas fa-user-shield me-1 text-primary"></i> Data Wali Siswa</h4>
                                <div class="row">
                                    <div class="col-md-8 mx-auto">
                                        <div class="parent-card">
                                            <div class="parent-header d-flex justify-content-between align-items-center">
                                                <h5 class="fw-bold text-success mb-0"><i class="fas fa-user-tie me-1"></i> BIODATA WALI</h5>
                                                <span class="info-pill bg-success-subtle text-success border-success-subtle">WALI</span>
                                            </div>
                                            <div class="p-3">
                                                <div class="detail-row">
                                                    <div class="detail-label">NIK Wali</div>
                                                    <div class="detail-value">{{ $siswa->nik_w }}</div>
                                                </div>
                                                <div class="detail-row">
                                                    <div class="detail-label">Nama Lengkap</div>
                                                    <div class="detail-value text-uppercase text-dark">{{ $siswa->nm_w }}</div>
                                                </div>
                                                <div class="detail-row">
                                                    <div class="detail-label">Pendidikan</div>
                                                    <div class="detail-value">{{ $siswa->pendidikanWali->jenjang ?? '-' }}</div>
                                                </div>
                                                <div class="detail-row">
                                                    <div class="detail-label">Pekerjaan</div>
                                                    <div class="detail-value">{{ $siswa->pekerjaanWali->nama_pekerjaan ?? '-' }}</div>
                                                </div>
                                                <div class="detail-row">
                                                    <div class="detail-label">Penghasilan</div>
                                                    <div class="detail-value"><span class="badge bg-light text-dark border py-1.5 px-3 fs-7">{{ $siswa->penghasilanWali->kategori ?? '-' }}</span></div>
                                                </div>
                                                <div class="detail-row">
                                                    <div class="detail-label">Nomor Handphone</div>
                                                    <div class="detail-value text-dark fw-bold"><i class="fab fa-whatsapp text-success me-1"></i> {{ $siswa->hp_w }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- TAB 4: DATA BERKAS --}}
                            <div class="tab-pane fade" id="tab-4" role="tabpanel">
                                <h4 class="fw-bold mb-3 text-dark"><i class="fas fa-folder-open text-primary me-1"></i> Dokumen Pendukung & Berkas</h4>
                                <div class="row g-4 justify-content-center">
                                    {{-- KK --}}
                                    <div class="col-md-6 col-lg-4">
                                        <div class="doc-card p-3 shadow-xs text-center h-100 d-flex flex-column justify-content-between">
                                            <div>
                                                <h6 class="fw-extrabold text-dark mb-2"><i class="far fa-file-alt text-primary me-1"></i> Kartu Keluarga</h6>
                                                @php
                                                    $kk = $siswa->foto_scan_kk
                                                        ? 'gambar_berkas/berkas_siswa/' . $siswa->foto_scan_kk
                                                        : 'asset_admin/img/notfound.png';
                                                    $isKkPdf = strtolower(pathinfo($kk, PATHINFO_EXTENSION)) === 'pdf';
                                                @endphp
                                                <div class="doc-img-container shadow-xs mb-3 border">
                                                    @if($isKkPdf)
                                                        <i class="far fa-file-pdf text-danger fs-1" style="cursor: pointer;" onclick="openPreview('{{ asset($kk) }}', 'Kartu Keluarga')"></i>
                                                    @else
                                                        <img src="{{ asset($kk) }}" alt="KK" style="cursor:pointer;"
                                                            onclick="openPreview('{{ asset($kk) }}', 'Kartu Keluarga')">
                                                    @endif
                                                </div>
                                            </div>
                                            <div>
                                                @if ($siswa->foto_scan_kk)
                                                    <a href="{{ route('siswa.download.berkas', [$siswa, 'foto_scan_kk']) }}"
                                                        class="btn btn-primary btn-sm w-100 py-2 fw-semibold shadow-xs"><i
                                                            class="fas fa-download me-1"></i> Unduh Berkas</a>
                                                @else
                                                    <button class="btn btn-secondary btn-sm w-100 py-2" disabled><i
                                                            class="fas fa-times me-1"></i> Belum Diunggah</button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    {{-- AKTA --}}
                                    <div class="col-md-6 col-lg-4">
                                        <div class="doc-card p-3 shadow-xs text-center h-100 d-flex flex-column justify-content-between">
                                            <div>
                                                <h6 class="fw-extrabold text-dark mb-2"><i class="far fa-file-alt text-primary me-1"></i> Akta Kelahiran</h6>
                                                @php
                                                    $akta = $siswa->foto_scan_akta
                                                        ? 'gambar_berkas/berkas_siswa/' . $siswa->foto_scan_akta
                                                        : 'asset_admin/img/notfound.png';
                                                    $isAktaPdf = strtolower(pathinfo($akta, PATHINFO_EXTENSION)) === 'pdf';
                                                @endphp
                                                <div class="doc-img-container shadow-xs mb-3 border">
                                                    @if($isAktaPdf)
                                                        <i class="far fa-file-pdf text-danger fs-1" style="cursor: pointer;" onclick="openPreview('{{ asset($akta) }}', 'Akta Kelahiran')"></i>
                                                    @else
                                                        <img src="{{ asset($akta) }}" alt="Akta" style="cursor:pointer;"
                                                            onclick="openPreview('{{ asset($akta) }}', 'Akta Kelahiran')">
                                                    @endif
                                                </div>
                                            </div>
                                            <div>
                                                @if ($siswa->foto_scan_akta)
                                                    <a href="{{ route('siswa.download.berkas', [$siswa, 'foto_scan_akta']) }}"
                                                        class="btn btn-primary btn-sm w-100 py-2 fw-semibold shadow-xs"><i
                                                            class="fas fa-download me-1"></i> Unduh Berkas</a>
                                                @else
                                                    <button class="btn btn-secondary btn-sm w-100 py-2" disabled><i
                                                            class="fas fa-times me-1"></i> Belum Diunggah</button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    {{-- IJAZAH --}}
                                    <div class="col-md-6 col-lg-4">
                                        <div class="doc-card p-3 shadow-xs text-center h-100 d-flex flex-column justify-content-between">
                                            <div>
                                                <h6 class="fw-extrabold text-dark mb-2"><i class="far fa-file-alt text-primary me-1"></i> Ijazah Asli</h6>
                                                @php
                                                    $ijazah = $siswa->foto_ijazah
                                                        ? 'gambar_berkas/berkas_siswa/' . $siswa->foto_ijazah
                                                        : 'asset_admin/img/notfound.png';
                                                    $isIjazahPdf = strtolower(pathinfo($ijazah, PATHINFO_EXTENSION)) === 'pdf';
                                                @endphp
                                                <div class="doc-img-container shadow-xs mb-3 border">
                                                    @if($isIjazahPdf)
                                                        <i class="far fa-file-pdf text-danger fs-1" style="cursor: pointer;" onclick="openPreview('{{ asset($ijazah) }}', 'Ijazah')"></i>
                                                    @else
                                                        <img src="{{ asset($ijazah) }}" alt="Ijazah" style="cursor:pointer;"
                                                            onclick="openPreview('{{ asset($ijazah) }}', 'Ijazah')">
                                                    @endif
                                                </div>
                                            </div>
                                            <div>
                                                @if ($siswa->foto_ijazah)
                                                    <a href="{{ route('siswa.download.berkas', [$siswa, 'foto_ijazah']) }}"
                                                        class="btn btn-primary btn-sm w-100 py-2 fw-semibold shadow-xs"><i
                                                            class="fas fa-download me-1"></i> Unduh Berkas</a>
                                                @else
                                                    <button class="btn btn-secondary btn-sm w-100 py-2" disabled><i
                                                            class="fas fa-times me-1"></i> Belum Diunggah</button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    {{-- SKCK --}}
                                    <div class="col-md-6 col-lg-4">
                                        <div class="doc-card p-3 shadow-xs text-center h-100 d-flex flex-column justify-content-between">
                                            <div>
                                                <h6 class="fw-extrabold text-dark mb-2"><i class="far fa-file-alt text-primary me-1"></i> SKCK / SKKB</h6>
                                                @php
                                                    $skck = $siswa->foto_scan_skck
                                                        ? 'gambar_berkas/berkas_siswa/' . $siswa->foto_scan_skck
                                                        : 'asset_admin/img/notfound.png';
                                                    $isSkckPdf = strtolower(pathinfo($skck, PATHINFO_EXTENSION)) === 'pdf';
                                                @endphp
                                                <div class="doc-img-container shadow-xs mb-3 border">
                                                    @if($isSkckPdf)
                                                        <i class="far fa-file-pdf text-danger fs-1" style="cursor: pointer;" onclick="openPreview('{{ asset($skck) }}', 'SKCK / SKKB')"></i>
                                                    @else
                                                        <img src="{{ asset($skck) }}" alt="SKCK" style="cursor:pointer;"
                                                            onclick="openPreview('{{ asset($skck) }}', 'SKCK / SKKB')">
                                                    @endif
                                                </div>
                                            </div>
                                            <div>
                                                @if ($siswa->foto_scan_skck)
                                                    <a href="{{ route('siswa.download.berkas', [$siswa, 'foto_scan_skck']) }}"
                                                        class="btn btn-primary btn-sm w-100 py-2 fw-semibold shadow-xs"><i
                                                            class="fas fa-download me-1"></i> Unduh Berkas</a>
                                                @else
                                                    <button class="btn btn-secondary btn-sm w-100 py-2" disabled><i
                                                            class="fas fa-times me-1"></i> Belum Diunggah</button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    {{-- SURAT SEHAT --}}
                                    <div class="col-md-6 col-lg-4">
                                        <div class="doc-card p-3 shadow-xs text-center h-100 d-flex flex-column justify-content-between">
                                            <div>
                                                <h6 class="fw-extrabold text-dark mb-2"><i class="far fa-file-alt text-primary me-1"></i> Surat Sehat</h6>
                                                @php
                                                    $sehat = $siswa->foto_scan_ket_sehat
                                                        ? 'gambar_berkas/berkas_siswa/' . $siswa->foto_scan_ket_sehat
                                                        : 'asset_admin/img/notfound.png';
                                                    $isSehatPdf = strtolower(pathinfo($sehat, PATHINFO_EXTENSION)) === 'pdf';
                                                @endphp
                                                <div class="doc-img-container shadow-xs mb-3 border">
                                                    @if($isSehatPdf)
                                                        <i class="far fa-file-pdf text-danger fs-1" style="cursor: pointer;" onclick="openPreview('{{ asset($sehat) }}', 'Surat Keterangan Sehat')"></i>
                                                    @else
                                                        <img src="{{ asset($sehat) }}" alt="Surat Sehat" style="cursor:pointer;"
                                                            onclick="openPreview('{{ asset($sehat) }}', 'Surat Keterangan Sehat')">
                                                    @endif
                                                </div>
                                            </div>
                                            <div>
                                                @if ($siswa->foto_scan_ket_sehat)
                                                    <a href="{{ route('siswa.download.berkas', [$siswa, 'foto_scan_ket_sehat']) }}"
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
    </script>
@endpush
