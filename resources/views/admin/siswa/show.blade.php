@extends('template')
@section('content')
    <div class="container-fluid p-0">
        <div class="row mb-2 mb-xl-3">
            <div class="col-auto d-none d-sm-block">
                <h3><strong>{{ $title }}</strong></h3>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="tab">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" href="#tab-1" data-bs-toggle="tab" role="tab">Data Diri</a>
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
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab-1" role="tabpanel">
                            <h4 class="tab-title">Data Diri</h4>
                            <table class="table table-bordered">
                                <tr>
                                    <td>No KK</td>
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
                            <h4 class="tab-title">Orang Tua</h4>
                            <table class="table table-bordered">
                                <tr>
                                    <th colspan="2">BIODATA AYAH</th>
                                </tr>
                                <tr>
                                    <td>NIK</td>
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
                                    <th colspan="2">BIODATA IBU</th>
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
                            <h4 class="tab-title">Wali</h4>
                            <table class="table table-bordered">
                                <tr>
                                    <td>NIK</td>
                                    <td>{{ $siswa->nik_w }}</td>
                                </tr>
                                <tr>
                                    <td>Nama</td>
                                    <td>{{ $siswa->nm_w }}</td>
                                </tr>
                                <tr>
                                    <td>Pendidikan</td>
                                    <td>{{ $siswa->pendidikanWali->jenjang }}</td>
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
                            <div class="row g-3">

                                {{-- KK --}}
                                <div class="col-md-6 col-lg-4 text-center">

                                    <div class="border rounded-4 p-3 bg-light">

                                        <div class="fw-semibold mb-2">Kartu Keluarga</div>

                                        @php
                                            $kk = $siswa->foto_scan_kk ?: 'images/notfound.png';
                                        @endphp

                                        <img src="{{ asset($kk) }}" class="img-fluid rounded-3 shadow-sm"
                                            style="height:150px; object-fit:cover; cursor:pointer;"
                                            onclick="openPreview('{{ asset($kk) }}', 'Kartu Keluarga')">

                                    </div>

                                </div>

                                {{-- AKTA --}}
                                <div class="col-md-6 col-lg-4 text-center">

                                    <div class="border rounded-4 p-3 bg-light">

                                        <div class="fw-semibold mb-2">Akta Kelahiran</div>

                                        @php
                                            $akta = $siswa->foto_scan_akta ?: 'images/notfound.png';
                                        @endphp

                                        <img src="{{ asset($akta) }}" class="img-fluid rounded-3 shadow-sm"
                                            style="height:150px; object-fit:cover; cursor:pointer;"
                                            onclick="openPreview('{{ asset($akta) }}', 'Akta Kelahiran')">

                                    </div>

                                </div>

                                {{-- IJAZAH --}}
                                <div class="col-md-6 col-lg-6 text-center">

                                    <div class="border rounded-4 p-3 bg-light">

                                        <div class="fw-semibold mb-2">Ijazah / SKL</div>

                                        @php
                                            $ijazah = $siswa->foto_ijazah ?: 'images/notfound.png';
                                        @endphp

                                        <img src="{{ asset($ijazah) }}" class="img-fluid rounded-3 shadow-sm"
                                            style="height:150px; object-fit:cover; cursor:pointer;"
                                            onclick="openPreview('{{ asset($ijazah) }}', 'Ijazah / SKL')">

                                    </div>

                                </div>

                                {{-- SKL --}}
                                <div class="col-md-6 col-lg-6 text-center">

                                    <div class="border rounded-4 p-3 bg-light">

                                        <div class="fw-semibold mb-2">Surat Keterangan Lulus</div>

                                        @php
                                            $skl = $siswa->foto_skl ?: 'images/notfound.png';
                                        @endphp

                                        <img src="{{ asset($skl) }}" class="img-fluid rounded-3 shadow-sm"
                                            style="height:150px; object-fit:cover; cursor:pointer;"
                                            onclick="openPreview('{{ asset($skl) }}', 'Surat Keterangan Lulus')">

                                    </div>

                                </div>

                                {{-- SKKB --}}
                                <div class="col-md-6 col-lg-4 text-center">

                                    <div class="border rounded-4 p-3 bg-light">

                                        <div class="fw-semibold mb-2">SKCK / SKKB</div>

                                        @php
                                            $skck = $siswa->foto_scan_skck ?: 'images/notfound.png';
                                        @endphp

                                        <img src="{{ asset($skck) }}" class="img-fluid rounded-3 shadow-sm"
                                            style="height:150px; object-fit:cover; cursor:pointer;"
                                            onclick="openPreview('{{ asset($skck) }}', 'SKCK / SKKB')">

                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // 
    </script>
@endpush
