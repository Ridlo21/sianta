@extends('template')
@section('content')
    @php
        $defaultAvatar = $guru->jenis_kelamin === 'P' ? 'gurufemale.png' : 'gurumale.png';
        $foto = $guru->foto
            ? asset('gambar_berkas/berkas_guru/' . $guru->foto)
            : asset('asset_admin/img/avatars/' . $defaultAvatar);
    @endphp

    <div class="container-fluid p-0">
        <div class="row mb-3 align-items-center">
            <div class="col-auto">
                <h3><strong>{{ $title }}</strong></h3>
            </div>
            <div class="col text-end">
                <a href="{{ route('guru') }}" class="btn btn-danger shadow-sm"><i class="fas fa-reply"></i> Kembali</a>
            </div>
        </div>

        {{-- PROFILE SUMMARY CARD --}}
        <div class="row justify-content-center mb-4">
            <div class="col-lg-12">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4 p-lg-5">
                        <div class="row g-5">
                            {{-- FOTO --}}
                            <div class="col-lg-3 text-center">
                                <img src="{{ $foto }}" class="rounded-4 shadow-sm mb-3 img-thumbnail"
                                    style="width: 200px; height: 260px; object-fit: cover;">
                                @if ($guru->foto)
                                    <a href="{{ route('guru.download.berkas', [$guru->id, 'foto']) }}"
                                        class="btn btn-outline-primary btn-sm w-100 shadow-sm"><i
                                            class="fas fa-download"></i> Unduh Foto</a>
                                @endif
                            </div>

                            {{-- BIODATA --}}
                            <div class="col-lg-9">
                                {{-- HEADER --}}
                                <div class="mb-4">
                                    <h2 class="fw-bold mb-1">
                                        {{ strtoupper($guru->nama) }}
                                    </h2>
                                    <div class="text-muted">
                                        NIP : {{ $guru->nip ?? '-' }} | NUPTK : {{ $guru->nuptk ?? '-' }}
                                    </div>
                                </div>

                                {{-- ISI --}}
                                <div class="row">
                                    {{-- KIRI --}}
                                    <div class="col-md-6">
                                        <div class="mb-4">
                                            <small class="text-muted d-block">
                                                NIK
                                            </small>
                                            <div class="fw-semibold">
                                                {{ $guru->nik }}
                                            </div>
                                        </div>

                                        <div class="mb-4">
                                            <small class="text-muted d-block">
                                                Tempat, Tanggal Lahir
                                            </small>
                                            <div class="fw-semibold">
                                                {{ $guru->tempat_lahir }},
                                                {{ $guru->tanggal_lahir ? \Carbon\Carbon::parse($guru->tanggal_lahir)->locale('id')->translatedFormat('d F Y') : '-' }}
                                            </div>
                                        </div>

                                        <div class="mb-4">
                                            <small class="text-muted d-block">
                                                Status Aktif
                                            </small>
                                            <div class="fw-semibold">
                                                @if ($guru->status_aktif == 1)
                                                    <span class="badge bg-success">Aktif</span>
                                                @else
                                                    <span class="badge bg-danger">Tidak Aktif</span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="mb-4">
                                            <small class="text-muted d-block">
                                                Jurusan
                                            </small>
                                            <div class="fw-semibold">
                                                {{ $guru->jurusan->program_keahlian ?? '-' }}
                                            </div>
                                        </div>
                                    </div>

                                    {{-- KANAN --}}
                                    <div class="col-md-6">
                                        <div class="mb-4">
                                            <small class="text-muted d-block">
                                                Jenis Kelamin
                                            </small>
                                            <div class="fw-semibold">
                                                {{ $guru->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                                            </div>
                                        </div>

                                        <div class="mb-4">
                                            <small class="text-muted d-block">
                                                Agama
                                            </small>
                                            <div class="fw-semibold">
                                                {{ $guru->agama->nama_agama ?? '-' }}
                                            </div>
                                        </div>

                                        <div class="mb-4">
                                            <small class="text-muted d-block">
                                                Jenis GTK
                                            </small>
                                            <div class="fw-semibold">
                                                {{ $guru->jenis_gtk ?? '-' }}
                                            </div>
                                        </div>

                                        <div class="mb-4">
                                            <small class="text-muted d-block">
                                                Jabatan GTK
                                            </small>
                                            <div class="fw-semibold">
                                                {{ $guru->jabatan_gtk ?? '-' }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- ALAMAT + STATUS BERKAS --}}
                        <div class="border-top mt-4 pt-4">
                            <div class="row g-4 align-items-start">
                                {{-- ALAMAT --}}
                                <div class="col-lg-8">
                                    <small class="text-muted d-block mb-2">
                                        Alamat
                                    </small>
                                    <div class="fw-semibold mb-2">
                                        {{ $guru->alamat }}
                                    </div>
                                    <div class="text-muted">
                                        {{ $guru->desaDetail->name ?? '-' }},
                                        {{ $guru->kecamatan->name ?? '-' }},
                                        {{ $guru->kabupaten->name ?? '-' }},
                                        {{ $guru->provinsi->name ?? '-' }}
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

                                    <div class="border rounded-4 p-3 bg-light h-100">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <small class="text-muted d-block">
                                                    Status Berkas
                                                </small>
                                                @if ($berkasLengkap == $totalBerkas)
                                                    <div class="fw-semibold text-success">
                                                        Berkas Lengkap
                                                    </div>
                                                @else
                                                    <div class="fw-semibold text-warning">
                                                        Berkas Belum Lengkap
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="text-end">
                                                <div
                                                    class="badge {{ $berkasLengkap == $totalBerkas ? 'bg-success' : 'bg-warning text-dark' }} px-3 py-2">
                                                    {{ $berkasLengkap }}/{{ $totalBerkas }}
                                                </div>
                                            </div>
                                        </div>
                                        {{-- INFO --}}
                                        <small class="text-muted d-block mt-3">
                                            Cek detail berkas pada bagian data berkas di bawah halaman ini.
                                        </small>
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
            <div class="col-md-12">
                <div class="card shadow-sm rounded-4">
                    <div class="card-body">
                        <div class="tab">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" href="#tab-3" data-bs-toggle="tab" role="tab">Riwayat
                                        Pendidikan</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link " href="#tab-1" data-bs-toggle="tab" role="tab">Data
                                        Kepegawaian & Kontak</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#tab-2" data-bs-toggle="tab" role="tab">Keluarga</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#tab-4" data-bs-toggle="tab" role="tab">Data Berkas</a>
                                </li>
                            </ul>
                            <div class="tab-content pt-3">
                                <div class="tab-pane" id="tab-1" role="tabpanel">
                                    <h4 class="tab-title mb-3">Data Kepegawaian & Kontak</h4>
                                    <table class="table table-bordered table-striped">
                                        <tr>
                                            <td style="width: 30%">Status Kepegawaian</td>
                                            <td>{{ $guru->status_kepegawaian ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td>Jenis GTK</td>
                                            <td>{{ $guru->jenis_gtk ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td>Jabatan GTK</td>
                                            <td>{{ $guru->jabatan_gtk ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td>Tahun Pensiun</td>
                                            <td>{{ $guru->tahun_pensiun ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td>No. HP</td>
                                            <td>{{ $guru->no_hp ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td>Email</td>
                                            <td>{{ $guru->email ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td>Status Perkawinan</td>
                                            <td>{{ ucwords($guru->status_perkawinan ?? '-') }}</td>
                                        </tr>
                                        <tr>
                                            <td>Kode Pos</td>
                                            <td>{{ $guru->pos ?? '-' }}</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="tab-pane" id="tab-2" role="tabpanel">
                                    <h4 class="tab-title mb-3">Keluarga</h4>
                                    <table class="table table-bordered table-striped">
                                        <tr>
                                            <th colspan="2" class="bg-light text-primary">IBU KANDUNG</th>
                                        </tr>
                                        <tr>
                                            <td style="width: 30%">Nama Ibu</td>
                                            <td>{{ $guru->keluarga->nama_ibu ?? '-' }}</td>
                                        </tr>
                                        @if ($guru->status_perkawinan == 'kawin')
                                            <tr>
                                                <th colspan="2" class="bg-light text-primary">PASANGAN (SUAMI / ISTRI)
                                                </th>
                                            </tr>
                                            <tr>
                                                <td>Nama Pasangan</td>
                                                <td>{{ $guru->keluarga->nama_pasangan ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <td>Pekerjaan Pasangan</td>
                                                <td>{{ $guru->keluarga->pekerjaanPasangan->nama_pekerjaan ?? '-' }}</td>
                                            </tr>
                                        @endif
                                    </table>
                                </div>
                                <div class="tab-pane active" id="tab-3" role="tabpanel">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h4 class="tab-title mb-0">Riwayat Pendidikan</h4>
                                        <button class="btn btn-primary btn-sm shadow-sm" data-bs-toggle="modal"
                                            data-bs-target="#modalTambahPendidikan">
                                            <i class="fas fa-plus"></i> Tambah Riwayat Pendidikan
                                        </button>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped">
                                            <thead>
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
                                                        <td><span class="badge bg-secondary">{{ $edu->jenjang }}</span>
                                                        </td>
                                                        <td>{{ $edu->nama_instansi }}</td>
                                                        <td>{{ $edu->jurusan ?? '-' }}</td>
                                                        <td>{{ $edu->tahun_masuk }}</td>
                                                        <td>{{ $edu->tahun_lulus }}</td>
                                                        <td>{{ $edu->nomor_ijazah ?? '-' }}</td>
                                                        <td>
                                                            @if ($edu->scan_file_ijazah)
                                                                <div class="d-flex gap-1">
                                                                    <button class="btn btn-sm btn-info"
                                                                        onclick="openPreview('{{ asset('gambar_berkas/berkas_guru/' . $edu->scan_file_ijazah) }}', 'Ijazah {{ $edu->jenjang }}')">
                                                                        <i class="fas fa-eye"></i> Lihat
                                                                    </button>
                                                                    <a href="{{ route('guru.pendidikan.download', $edu->id) }}"
                                                                        class="btn btn-sm btn-primary">
                                                                        <i class="fas fa-download"></i> Unduh
                                                                    </a>
                                                                </div>
                                                            @else
                                                                <span class="text-muted"><i
                                                                        class="fas fa-times-circle"></i> Tidak Ada</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="8" class="text-center text-muted py-3">Belum ada
                                                            riwayat pendidikan.</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane" id="tab-4" role="tabpanel">
                                    <h4 class="tab-title mb-3">Data Berkas</h4>
                                    <div class="row g-3 justify-content-center">
                                        {{-- FOTO --}}
                                        <div class="col-md-6 col-lg-4 text-center">
                                            <div class="border rounded-4 p-3 bg-light">
                                                <div class="fw-semibold mb-2">Foto Guru</div>
                                                @php
                                                    $foto_file = $guru->foto
                                                        ? 'gambar_berkas/berkas_guru/' . $guru->foto
                                                        : 'asset_admin/img/notfound.png';
                                                @endphp
                                                <img src="{{ asset($foto_file) }}"
                                                    class="img-fluid rounded-3 shadow-sm img-thumbnail"
                                                    style="height:150px; width:100%; object-fit:cover; cursor:pointer;"
                                                    onclick="openPreview('{{ asset($foto_file) }}', 'Foto Guru')">
                                                @if ($guru->foto)
                                                    <a href="{{ route('guru.download.berkas', [$guru->id, 'foto']) }}"
                                                        class="btn btn-primary btn-sm mt-3 w-100 shadow-sm"><i
                                                            class="fas fa-download"></i> Unduh Berkas</a>
                                                @else
                                                    <button class="btn btn-secondary btn-sm mt-3 w-100" disabled><i
                                                            class="fas fa-times"></i> Belum Diunggah</button>
                                                @endif
                                            </div>
                                        </div>

                                        {{-- KK --}}
                                        <div class="col-md-6 col-lg-4 text-center">
                                            <div class="border rounded-4 p-3 bg-light">
                                                <div class="fw-semibold mb-2">Kartu Keluarga</div>
                                                @php
                                                    $kk = $guru->scan_kk
                                                        ? 'gambar_berkas/berkas_guru/' . $guru->scan_kk
                                                        : 'asset_admin/img/notfound.png';
                                                @endphp
                                                <img src="{{ asset($kk) }}"
                                                    class="img-fluid rounded-3 shadow-sm img-thumbnail"
                                                    style="height:150px; width:100%; object-fit:cover; cursor:pointer;"
                                                    onclick="openPreview('{{ asset($kk) }}', 'Kartu Keluarga')">
                                                @if ($guru->scan_kk)
                                                    <a href="{{ route('guru.download.berkas', [$guru->id, 'scan_kk']) }}"
                                                        class="btn btn-primary btn-sm mt-3 w-100 shadow-sm"><i
                                                            class="fas fa-download"></i> Unduh Berkas</a>
                                                @else
                                                    <button class="btn btn-secondary btn-sm mt-3 w-100" disabled><i
                                                            class="fas fa-times"></i> Belum Diunggah</button>
                                                @endif
                                            </div>
                                        </div>

                                        {{-- AKTA --}}
                                        <div class="col-md-6 col-lg-4 text-center">
                                            <div class="border rounded-4 p-3 bg-light">
                                                <div class="fw-semibold mb-2">Akta Kelahiran</div>
                                                @php
                                                    $akta = $guru->scan_akta
                                                        ? 'gambar_berkas/berkas_guru/' . $guru->scan_akta
                                                        : 'asset_admin/img/notfound.png';
                                                @endphp
                                                <img src="{{ asset($akta) }}"
                                                    class="img-fluid rounded-3 shadow-sm img-thumbnail"
                                                    style="height:150px; width:100%; object-fit:cover; cursor:pointer;"
                                                    onclick="openPreview('{{ asset($akta) }}', 'Akta Kelahiran')">
                                                @if ($guru->scan_akta)
                                                    <a href="{{ route('guru.download.berkas', [$guru->id, 'scan_akta']) }}"
                                                        class="btn btn-primary btn-sm mt-3 w-100 shadow-sm"><i
                                                            class="fas fa-download"></i> Unduh Berkas</a>
                                                @else
                                                    <button class="btn btn-secondary btn-sm mt-3 w-100" disabled><i
                                                            class="fas fa-times"></i> Belum Diunggah</button>
                                                @endif
                                            </div>
                                        </div>

                                        {{-- KTP --}}
                                        <div class="col-md-6 col-lg-4 text-center">
                                            <div class="border rounded-4 p-3 bg-light">
                                                <div class="fw-semibold mb-2">KTP</div>
                                                @php
                                                    $ktp = $guru->scan_ktp
                                                        ? 'gambar_berkas/berkas_guru/' . $guru->scan_ktp
                                                        : 'asset_admin/img/notfound.png';
                                                @endphp
                                                <img src="{{ asset($ktp) }}"
                                                    class="img-fluid rounded-3 shadow-sm img-thumbnail"
                                                    style="height:150px; width:100%; object-fit:cover; cursor:pointer;"
                                                    onclick="openPreview('{{ asset($ktp) }}', 'KTP')">
                                                @if ($guru->scan_ktp)
                                                    <a href="{{ route('guru.download.berkas', [$guru->id, 'scan_ktp']) }}"
                                                        class="btn btn-primary btn-sm mt-3 w-100 shadow-sm"><i
                                                            class="fas fa-download"></i> Unduh Berkas</a>
                                                @else
                                                    <button class="btn btn-secondary btn-sm mt-3 w-100" disabled><i
                                                            class="fas fa-times"></i> Belum Diunggah</button>
                                                @endif
                                            </div>
                                        </div>

                                        {{-- SK --}}
                                        <div class="col-md-6 col-lg-4 text-center">
                                            <div class="border rounded-4 p-3 bg-light">
                                                <div class="fw-semibold mb-2">SK Kepegawaian</div>
                                                @php
                                                    $sk = $guru->scan_sk
                                                        ? 'gambar_berkas/berkas_guru/' . $guru->scan_sk
                                                        : 'asset_admin/img/notfound.png';
                                                @endphp
                                                <img src="{{ asset($sk) }}"
                                                    class="img-fluid rounded-3 shadow-sm img-thumbnail"
                                                    style="height:150px; width:100%; object-fit:cover; cursor:pointer;"
                                                    onclick="openPreview('{{ asset($sk) }}', 'SK Kepegawaian')">
                                                @if ($guru->scan_sk)
                                                    <a href="{{ route('guru.download.berkas', [$guru->id, 'scan_sk']) }}"
                                                        class="btn btn-primary btn-sm mt-3 w-100 shadow-sm"><i
                                                            class="fas fa-download"></i> Unduh Berkas</a>
                                                @else
                                                    <button class="btn btn-secondary btn-sm mt-3 w-100" disabled><i
                                                            class="fas fa-times"></i> Belum Diunggah</button>
                                                @endif
                                            </div>
                                        </div>

                                        {{-- TRANSKRIP --}}
                                        <div class="col-md-6 col-lg-4 text-center">
                                            <div class="border rounded-4 p-3 bg-light">
                                                <div class="fw-semibold mb-2">Transkrip Nilai</div>
                                                @php
                                                    $transkrip = $guru->scan_transkrip_nilai
                                                        ? 'gambar_berkas/berkas_guru/' . $guru->scan_transkrip_nilai
                                                        : 'asset_admin/img/notfound.png';
                                                @endphp
                                                <img src="{{ asset($transkrip) }}"
                                                    class="img-fluid rounded-3 shadow-sm img-thumbnail"
                                                    style="height:150px; width:100%; object-fit:cover; cursor:pointer;"
                                                    onclick="openPreview('{{ asset($transkrip) }}', 'Transkrip Nilai')">
                                                @if ($guru->scan_transkrip_nilai)
                                                    <a href="{{ route('guru.download.berkas', [$guru->id, 'scan_transkrip_nilai']) }}"
                                                        class="btn btn-primary btn-sm mt-3 w-100 shadow-sm"><i
                                                            class="fas fa-download"></i> Unduh Berkas</a>
                                                @else
                                                    <button class="btn btn-secondary btn-sm mt-3 w-100" disabled><i
                                                            class="fas fa-times"></i> Belum Diunggah</button>
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
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="previewModalLabel">Pratinjau Berkas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center bg-dark rounded-bottom p-3">
                    <img id="modalPreviewImg" src="" class="img-fluid rounded-3"
                        style="max-height: 80vh; object-fit: contain;">
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Pendidikan -->
    <div class="modal fade" id="modalTambahPendidikan" tabindex="-1" aria-labelledby="modalTambahPendidikanLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="formPendidikan" data-parsley-validate enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="guru_id" value="{{ $guru->id }}">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTambahPendidikanLabel">Tambah Riwayat Pendidikan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Jenjang Pendidikan</label>
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
                            <label class="form-label">Nama Instansi (Sekolah / Kampus)</label>
                            <input type="text" name="nama_instansi" class="form-control text-uppercase" required
                                placeholder="CONTOH: UNIVERSITAS INDONESIA">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Jurusan</label>
                            <input type="text" name="jurusan" class="form-control text-uppercase"
                                placeholder="CONTOH: TEKNIK INFORMATIKA (KOSONGKAN JIKA SD/SMP)">
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tahun Masuk</label>
                                <input type="number" name="tahun_masuk" class="form-control" required min="1900"
                                    max="2100" placeholder="CONTOH: 2018" data-parsley-type="integer"
                                    data-parsley-length="[4, 4]">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tahun Lulus</label>
                                <input type="number" name="tahun_lulus" class="form-control" required min="1900"
                                    max="2100" placeholder="CONTOH: 2022" data-parsley-type="integer"
                                    data-parsley-length="[4, 4]">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nomor Ijazah</label>
                            <input type="text" name="nomor_ijazah" class="form-control text-uppercase"
                                placeholder="NOMOR IJAZAH">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Scan File Ijazah</label>
                            <input type="file" name="scan_file_ijazah" class="form-control"
                                accept="image/png, image/jpeg, image/jpg, application/pdf" data-parsley-filemaxsize="2"
                                data-parsley-fileextension="jpg,jpeg,png,pdf">
                            <div class="form-text">Maksimal 2 MB (Format: JPG, JPEG, PNG, atau PDF)</div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
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
                let iframe = `<iframe src="${url}" style="width:100%; height:70vh; border:none;"></iframe>`;
                if ($('#modalPreviewPdf').length === 0) {
                    $('.modal-body').append('<div id="modalPreviewPdf"></div>');
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
