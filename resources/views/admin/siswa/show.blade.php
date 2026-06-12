@extends('template')
@section('content')
    @php
        $defaultAvatar = ($siswa->jenis_kelamin === 'Perempuan') ? 'female.png' : 'male.png';
        $foto = $siswa->foto_warna_santri ? asset('gambar_berkas/berkas_siswa/' . $siswa->foto_warna_santri) : asset('asset_admin/img/avatars/' . $defaultAvatar);
        $murid = $siswa;
    @endphp

    <div class="container-fluid p-0">
        <div class="row mb-3 align-items-center">
            <div class="col-auto">
                <h3><strong>{{ $title }}</strong></h3>
            </div>
            <div class="col text-end">
                <a href="{{ route('siswa') }}" class="btn btn-danger shadow-sm"><i class="fas fa-reply"></i> Kembali</a>
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
                                @if ($siswa->foto_warna_santri)
                                    <a href="{{ route('siswa.download.berkas', [$siswa->id_person, 'foto_warna_santri']) }}" class="btn btn-outline-primary btn-sm w-100 shadow-sm"><i class="fas fa-download"></i> Unduh Foto</a>
                                @endif
                            </div>

                            {{-- BIODATA --}}
                            <div class="col-lg-9">
                                {{-- HEADER --}}
                                <div class="mb-4">
                                    <h2 class="fw-bold mb-1">
                                        {{ strtoupper($murid->nama) }}
                                    </h2>
                                    <div class="text-muted">
                                        NISN : {{ $murid->nisn ?? '-' }}
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
                                                {{ $murid->nik }}
                                            </div>
                                        </div>

                                        <div class="mb-4">
                                            <small class="text-muted d-block">
                                                Tempat, Tanggal Lahir
                                            </small>
                                            <div class="fw-semibold">
                                                {{ $murid->tempat_lahir }},
                                                {{ $murid->tanggal_lahir ? \Carbon\Carbon::parse($murid->tanggal_lahir)->locale('id')->translatedFormat('d F Y') : '-' }}
                                            </div>
                                        </div>

                                        <div class="mb-4">
                                            <small class="text-muted d-block">
                                                Asal Sekolah
                                            </small>
                                            <div class="fw-semibold">
                                                {{ $murid->asal_sekolah ?? '-' }}
                                            </div>
                                        </div>

                                        <div class="mb-4">
                                            <small class="text-muted d-block">
                                                Jurusan
                                            </small>
                                            <div class="fw-semibold">
                                                {{ $murid->jurusan->program_keahlian ?? '-' }}
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
                                                {{ $murid->jenis_kelamin }}
                                            </div>
                                        </div>

                                        <div class="mb-4">
                                            <small class="text-muted d-block">
                                                Agama
                                            </small>
                                            <div class="fw-semibold">
                                                {{ $murid->agama->nama_agama ?? '-' }}
                                            </div>
                                        </div>

                                        <div class="mb-4">
                                            <small class="text-muted d-block">
                                                Status Anak
                                            </small>
                                            <div class="fw-semibold">
                                                {{ $murid->dlm_klrg }}
                                            </div>
                                        </div>

                                        <div class="mb-4">
                                            <small class="text-muted d-block">
                                                Anak Ke
                                            </small>
                                            <div class="fw-semibold">
                                                {{ $murid->ank_ke }}
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
                                        {{ $murid->alamat_lengkap }}
                                    </div>
                                    <div class="text-muted">
                                        {{ $murid->desaDetail->name ?? '-' }},
                                        {{ $murid->kecamatan->name ?? '-' }},
                                        {{ $murid->kabupaten->name ?? '-' }},
                                        {{ $murid->provinsi->name ?? '-' }}
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
                                                <div class="badge {{ $berkasLengkap == $totalBerkas ? 'bg-success' : 'bg-warning text-dark' }} px-3 py-2">
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
                                    <a class="nav-link active" href="#tab-1" data-bs-toggle="tab" role="tab">Data Diri Tambahan</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#tab-2" data-bs-toggle="tab" role="tab">Orang Tua</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#tab-3" data-bs-toggle="tab" role="tab">Data Wali</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#tab-4" data-bs-toggle="tab" role="tab">Data Berkas</a>
                                </li>
                            </ul>
                            <div class="tab-content pt-3">
                                <div class="tab-pane active" id="tab-1" role="tabpanel">
                                    <h4 class="tab-title mb-3">Data Diri Tambahan</h4>
                                    <table class="table table-bordered table-striped">
                                        <tr>
                                            <td style="width: 30%">No KK</td>
                                            <td>{{ $siswa->no_kk }}</td>
                                        </tr>
                                        <tr>
                                            <td>No Registrasi Akta</td>
                                            <td>{{ $siswa->no_akta }}</td>
                                        </tr>
                                        <tr>
                                            <td>No Induk Umum Pesantren</td>
                                            <td>{{ $siswa->niup ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td>Kewarganegaraan</td>
                                            <td>{{ $siswa->kewarganegaraan ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td>Jumlah Saudara</td>
                                            <td>{{ $siswa->sdr ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td>Hobi</td>
                                            <td>{{ $siswa->hoby }}</td>
                                        </tr>
                                        <tr>
                                            <td>Cita-cita</td>
                                            <td>{{ $siswa->cita_cita }}</td>
                                        </tr>
                                        <tr>
                                            <td>Tinggi / Berat</td>
                                            <td>{{ $siswa->tinggi_badan }} cm / {{ $siswa->berat_badan }} kg</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="tab-pane" id="tab-2" role="tabpanel">
                                    <h4 class="tab-title mb-3">Orang Tua</h4>
                                    <table class="table table-bordered table-striped">
                                        <tr>
                                            <th colspan="2" class="bg-light text-primary">BIODATA AYAH</th>
                                        </tr>
                                        <tr>
                                            <td style="width: 30%">NIK</td>
                                            <td>{{ $siswa->nik_a }}</td>
                                        </tr>
                                        <tr>
                                            <td>Nama</td>
                                            <td>{{ $siswa->nm_a }}</td>
                                        </tr>
                                        <tr>
                                            <td>Pendidikan</td>
                                            <td>{{ $siswa->pendidikanAyah->jenjang ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td>Pekerjaan</td>
                                            <td>{{ $siswa->pekerjaanAyah->nama_pekerjaan ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td>Penghasilan</td>
                                            <td>{{ $siswa->penghasilanAyah->kategori ?? '-' }}</td>
                                        </tr>

                                        <tr>
                                            <th colspan="2" class="bg-light text-primary">BIODATA IBU</th>
                                        </tr>
                                        <tr>
                                            <td>NIK</td>
                                            <td>{{ $siswa->nik_i }}</td>
                                        </tr>
                                        <tr>
                                            <td>Nama</td>
                                            <td>{{ $siswa->nm_i }}</td>
                                        </tr>
                                        <tr>
                                            <td>Pendidikan</td>
                                            <td>{{ $siswa->pendidikanIbu->jenjang ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td>Pekerjaan</td>
                                            <td>{{ $siswa->pekerjaanIbu->nama_pekerjaan ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td>Penghasilan</td>
                                            <td>{{ $siswa->penghasilanIbu->kategori ?? '-' }}</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="tab-pane" id="tab-3" role="tabpanel">
                                    <h4 class="tab-title mb-3">Wali</h4>
                                    <table class="table table-bordered table-striped">
                                        <tr>
                                            <td style="width: 30%">NIK</td>
                                            <td>{{ $siswa->nik_w }}</td>
                                        </tr>
                                        <tr>
                                            <td>Nama</td>
                                            <td>{{ $siswa->nm_w }}</td>
                                        </tr>
                                        <tr>
                                            <td>Pendidikan</td>
                                            <td>{{ $siswa->pendidikanWali->jenjang ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td>Pekerjaan</td>
                                            <td>{{ $siswa->pekerjaanWali->nama_pekerjaan ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td>Penghasilan</td>
                                            <td>{{ $siswa->penghasilanWali->kategori ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td>NO. HP</td>
                                            <td>{{ $siswa->hp_w }}</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="tab-pane" id="tab-4" role="tabpanel">
                                    <h4 class="tab-title mb-3">Data Berkas</h4>
                                    <div class="row g-3 justify-content-center">
                                        {{-- KK --}}
                                        <div class="col-md-6 col-lg-4 text-center">
                                            <div class="border rounded-4 p-3 bg-light">
                                                <div class="fw-semibold mb-2">Kartu Keluarga</div>
                                                @php
                                                    $kk = $siswa->foto_scan_kk ? 'gambar_berkas/berkas_siswa/' . $siswa->foto_scan_kk : 'asset_admin/img/notfound.png';
                                                @endphp
                                                <img src="{{ asset($kk) }}" class="img-fluid rounded-3 shadow-sm img-thumbnail"
                                                    style="height:150px; width:100%; object-fit:cover; cursor:pointer;"
                                                    onclick="openPreview('{{ asset($kk) }}', 'Kartu Keluarga')">
                                                @if ($siswa->foto_scan_kk)
                                                    <a href="{{ route('siswa.download.berkas', [$siswa->id_person, 'foto_scan_kk']) }}" class="btn btn-primary btn-sm mt-3 w-100 shadow-sm"><i class="fas fa-download"></i> Unduh Berkas</a>
                                                @else
                                                    <button class="btn btn-secondary btn-sm mt-3 w-100" disabled><i class="fas fa-times"></i> Belum Diunggah</button>
                                                @endif
                                            </div>
                                        </div>

                                        {{-- AKTA --}}
                                        <div class="col-md-6 col-lg-4 text-center">
                                            <div class="border rounded-4 p-3 bg-light">
                                                <div class="fw-semibold mb-2">Akta Kelahiran</div>
                                                @php
                                                    $akta = $siswa->foto_scan_akta ? 'gambar_berkas/berkas_siswa/' . $siswa->foto_scan_akta : 'asset_admin/img/notfound.png';
                                                @endphp
                                                <img src="{{ asset($akta) }}" class="img-fluid rounded-3 shadow-sm img-thumbnail"
                                                    style="height:150px; width:100%; object-fit:cover; cursor:pointer;"
                                                    onclick="openPreview('{{ asset($akta) }}', 'Akta Kelahiran')">
                                                @if ($siswa->foto_scan_akta)
                                                    <a href="{{ route('siswa.download.berkas', [$siswa->id_person, 'foto_scan_akta']) }}" class="btn btn-primary btn-sm mt-3 w-100 shadow-sm"><i class="fas fa-download"></i> Unduh Berkas</a>
                                                @else
                                                    <button class="btn btn-secondary btn-sm mt-3 w-100" disabled><i class="fas fa-times"></i> Belum Diunggah</button>
                                                @endif
                                            </div>
                                        </div>

                                        {{-- IJAZAH --}}
                                        <div class="col-md-6 col-lg-4 text-center">
                                            <div class="border rounded-4 p-3 bg-light">
                                                <div class="fw-semibold mb-2">Ijazah</div>
                                                @php
                                                    $ijazah = $siswa->foto_ijazah ? 'gambar_berkas/berkas_siswa/' . $siswa->foto_ijazah : 'asset_admin/img/notfound.png';
                                                @endphp
                                                <img src="{{ asset($ijazah) }}" class="img-fluid rounded-3 shadow-sm img-thumbnail"
                                                    style="height:150px; width:100%; object-fit:cover; cursor:pointer;"
                                                    onclick="openPreview('{{ asset($ijazah) }}', 'Ijazah')">
                                                @if ($siswa->foto_ijazah)
                                                    <a href="{{ route('siswa.download.berkas', [$siswa->id_person, 'foto_ijazah']) }}" class="btn btn-primary btn-sm mt-3 w-100 shadow-sm"><i class="fas fa-download"></i> Unduh Berkas</a>
                                                @else
                                                    <button class="btn btn-secondary btn-sm mt-3 w-100" disabled><i class="fas fa-times"></i> Belum Diunggah</button>
                                                @endif
                                            </div>
                                        </div>

                                        {{-- SKCK --}}
                                        <div class="col-md-6 col-lg-4 text-center">
                                            <div class="border rounded-4 p-3 bg-light">
                                                <div class="fw-semibold mb-2">SKCK / SKKB</div>
                                                @php
                                                    $skck = $siswa->foto_scan_skck ? 'gambar_berkas/berkas_siswa/' . $siswa->foto_scan_skck : 'asset_admin/img/notfound.png';
                                                @endphp
                                                <img src="{{ asset($skck) }}" class="img-fluid rounded-3 shadow-sm img-thumbnail"
                                                    style="height:150px; width:100%; object-fit:cover; cursor:pointer;"
                                                    onclick="openPreview('{{ asset($skck) }}', 'SKCK / SKKB')">
                                                @if ($siswa->foto_scan_skck)
                                                    <a href="{{ route('siswa.download.berkas', [$siswa->id_person, 'foto_scan_skck']) }}" class="btn btn-primary btn-sm mt-3 w-100 shadow-sm"><i class="fas fa-download"></i> Unduh Berkas</a>
                                                @else
                                                    <button class="btn btn-secondary btn-sm mt-3 w-100" disabled><i class="fas fa-times"></i> Belum Diunggah</button>
                                                @endif
                                            </div>
                                        </div>

                                        {{-- SURAT SEHAT --}}
                                        <div class="col-md-6 col-lg-4 text-center">
                                            <div class="border rounded-4 p-3 bg-light">
                                                <div class="fw-semibold mb-2">Surat Sehat</div>
                                                @php
                                                    $sehat = $siswa->foto_scan_ket_sehat ? 'gambar_berkas/berkas_siswa/' . $siswa->foto_scan_ket_sehat : 'asset_admin/img/notfound.png';
                                                @endphp
                                                <img src="{{ asset($sehat) }}" class="img-fluid rounded-3 shadow-sm img-thumbnail"
                                                    style="height:150px; width:100%; object-fit:cover; cursor:pointer;"
                                                    onclick="openPreview('{{ asset($sehat) }}', 'Surat Sehat')">
                                                @if ($siswa->foto_scan_ket_sehat)
                                                    <a href="{{ route('siswa.download.berkas', [$siswa->id_person, 'foto_scan_ket_sehat']) }}" class="btn btn-primary btn-sm mt-3 w-100 shadow-sm"><i class="fas fa-download"></i> Unduh Berkas</a>
                                                @else
                                                    <button class="btn btn-secondary btn-sm mt-3 w-100" disabled><i class="fas fa-times"></i> Belum Diunggah</button>
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
                    <img id="modalPreviewImg" src="" class="img-fluid rounded-3" style="max-height: 80vh; object-fit: contain;">
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function openPreview(url, title) {
            $('#previewModalLabel').text('Pratinjau: ' + title);
            $('#modalPreviewImg').attr('src', url);
            var myModal = new bootstrap.Modal(document.getElementById('previewModal'));
            myModal.show();
        }
    </script>
@endpush
