@extends('template_guru')
@section('content')
    <div class="container-fluid p-0">
        <div class="row mb-2 mb-xl-3">
            <div class="col-auto d-none d-sm-block">
                <h3><strong>{{ $title }}</strong></h3>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <form id="formSimpan" data-parsley-validate>
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Data Kepegawaian & Penugasan <span
                                    class="text-danger">{{ $guru->nama }}</span></h5>
                        </div>
                        <div class="card-body">
                            <input hidden name="st" value="{{ $st }}">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Jenis PTK</label>
                                    <select name="jenis_gtk" id="jenis_gtk" class="form-select" required>
                                        <option value="">-- Pilih Jenis PTK --</option>
                                        @php
                                            $jenisGtk = old('jenis_gtk', $guru->jenis_gtk ?? '');
                                        @endphp

                                        <option value="Guru" {{ $jenisGtk == 'Guru' ? 'selected' : '' }}>Guru</option>
                                        <option value="Kepala Sekolah"
                                            {{ $jenisGtk == 'Kepala Sekolah' ? 'selected' : '' }}>Kepala Sekolah</option>
                                        <option value="Tenaga Administrasi Sekolah"
                                            {{ $jenisGtk == 'Tenaga Administrasi Sekolah' ? 'selected' : '' }}>Tenaga
                                            Administrasi Sekolah</option>
                                        <option value="Pustakawan" {{ $jenisGtk == 'Pustakawan' ? 'selected' : '' }}>
                                            Pustakawan</option>
                                        <option value="Laboran" {{ $jenisGtk == 'Laboran' ? 'selected' : '' }}>Laboran
                                        </option>
                                        <option value="Pengawas Sekolah"
                                            {{ $jenisGtk == 'Pengawas Sekolah' ? 'selected' : '' }}>Pengawas Sekolah
                                        </option>
                                        <option value="Lainnya" {{ $jenisGtk == 'Lainnya' ? 'selected' : '' }}>Lainnya
                                        </option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Jabatan PTK</label>
                                    <select name="jabatan_gtk" id="jabatan_gtk" class="form-select select2" required>
                                        <option value="">-- Pilih Jabatan PTK --</option>
                                        @php
                                            $jabatanGtk = old('jabatan_gtk', $guru->jabatan_gtk ?? '');
                                        @endphp

                                        <option value="Kepala Sekolah"
                                            {{ $jabatanGtk == 'Kepala Sekolah' ? 'selected' : '' }}>Kepala Sekolah</option>
                                        <option value="Wakil Kepala Sekolah"
                                            {{ $jabatanGtk == 'Wakil Kepala Sekolah' ? 'selected' : '' }}>Wakil Kepala
                                            Sekolah</option>
                                        <option value="Guru Mata Pelajaran"
                                            {{ $jabatanGtk == 'Guru Mata Pelajaran' ? 'selected' : '' }}>Guru Mata
                                            Pelajaran</option>
                                        <option value="Guru Kelas" {{ $jabatanGtk == 'Guru Kelas' ? 'selected' : '' }}>
                                            Guru
                                            Kelas</option>
                                        <option value="Guru BK" {{ $jabatanGtk == 'Guru BK' ? 'selected' : '' }}>Guru BK
                                        </option>
                                        <option value="Wali Kelas" {{ $jabatanGtk == 'Wali Kelas' ? 'selected' : '' }}>
                                            Wali
                                            Kelas</option>
                                        <option value="Kepala Tata Usaha"
                                            {{ $jabatanGtk == 'Kepala Tata Usaha' ? 'selected' : '' }}>Kepala Tata Usaha
                                        </option>
                                        <option value="Staf Tata Usaha"
                                            {{ $jabatanGtk == 'Staf Tata Usaha' ? 'selected' : '' }}>Staf Tata Usaha
                                        </option>
                                        <option value="Operator Sekolah"
                                            {{ $jabatanGtk == 'Operator Sekolah' ? 'selected' : '' }}>Operator Sekolah
                                        </option>
                                        <option value="Pustakawan" {{ $jabatanGtk == 'Pustakawan' ? 'selected' : '' }}>
                                            Pustakawan</option>
                                        <option value="Laboran" {{ $jabatanGtk == 'Laboran' ? 'selected' : '' }}>Laboran
                                        </option>
                                        <option value="Teknisi" {{ $jabatanGtk == 'Teknisi' ? 'selected' : '' }}>Teknisi
                                        </option>
                                        <option value="Satpam" {{ $jabatanGtk == 'Satpam' ? 'selected' : '' }}>Satpam
                                        </option>
                                        <option value="Petugas Kebersihan"
                                            {{ $jabatanGtk == 'Petugas Kebersihan' ? 'selected' : '' }}>Petugas Kebersihan
                                        </option>
                                        <option value="Bendahara" {{ $jabatanGtk == 'Bendahara' ? 'selected' : '' }}>
                                            Bendahara
                                        </option>
                                        <option value="Ka. Tata Usaha"
                                            {{ $jabatanGtk == 'Ka. Tata Usaha' ? 'selected' : '' }}>Ka. Tata Usaha
                                        </option>
                                        <option value="WAKASEK Kurikulum"
                                            {{ $jabatanGtk == 'WAKASEK Kurikulum' ? 'selected' : '' }}>WAKASEK Kurikulum
                                        </option>
                                        <option value="WAKASEK Kesiswaan"
                                            {{ $jabatanGtk == 'WAKASEK Kesiswaan' ? 'selected' : '' }}>WAKASEK Kesiswaan
                                        </option>
                                        <option value="WAKASEK Humas"
                                            {{ $jabatanGtk == 'WAKASEK Humas' ? 'selected' : '' }}>WAKASEK Humas
                                        </option>
                                        <option value="WAKASEK SARPRAS"
                                            {{ $jabatanGtk == 'WAKASEK SARPRAS' ? 'selected' : '' }}>WAKASEK SARPRAS
                                        </option>
                                        <option value="Admin WAKA Kurikulum"
                                            {{ $jabatanGtk == 'Admin WAKA Kurikulum' ? 'selected' : '' }}>Admin WAKA
                                            Kurikulum
                                        </option>
                                        <option value="Admin WAKA Kesiswaan"
                                            {{ $jabatanGtk == 'Admin WAKA Kesiswaan' ? 'selected' : '' }}>Admin WAKA
                                            Kesiswaan
                                        </option>
                                        <option value="Admin WAKA Humas"
                                            {{ $jabatanGtk == 'Admin WAKA Humas' ? 'selected' : '' }}>Admin WAKA Humas
                                        </option>
                                        <option value="Admin WAKA SARPRAS"
                                            {{ $jabatanGtk == 'Admin WAKA SARPRAS' ? 'selected' : '' }}>Admin WAKA SARPRAS
                                        </option>
                                        <option value="Manajemen Mutu"
                                            {{ $jabatanGtk == 'Manajemen Mutu' ? 'selected' : '' }}>Manajemen Mutu
                                        </option>
                                        <option value="KAPROG RPL" {{ $jabatanGtk == 'KAPROG RPL' ? 'selected' : '' }}>
                                            KAPROG RPL
                                        </option>
                                        <option value="Koordinator BK RPL"
                                            {{ $jabatanGtk == 'Koordinator BK RPL' ? 'selected' : '' }}>Koordinator BK RPL
                                        </option>
                                        <option value="KAPROG AKL" {{ $jabatanGtk == 'KAPROG AKL' ? 'selected' : '' }}>
                                            KAPROG AKL
                                        </option>
                                        <option value="Koordinator BK AKL"
                                            {{ $jabatanGtk == 'Koordinator BK AKL' ? 'selected' : '' }}>Koordinator BK AKL
                                        </option>
                                    </select>
                                </div>
                                <!-- Status Kepegawaian -->
                                <div class="col-md-6">
                                    <label class="form-label">Status Kepegawaian</label>
                                    <select name="status_kepegawaian" class="form-select select2" required>
                                        <option value="">-- Pilih Status Kepegawaian --</option>
                                        @php
                                            $currStatus = old('status_kepegawaian', $guru->status_kepegawaian ?? '');
                                        @endphp
                                        <option value="PNS" {{ $currStatus == 'PNS' ? 'selected' : '' }}>PNS</option>
                                        <option value="PNS Diperbantukan"
                                            {{ $currStatus == 'PNS Diperbantukan' ? 'selected' : '' }}>PNS Diperbantukan
                                        </option>
                                        <option value="PNS Depag" {{ $currStatus == 'PNS Depag' ? 'selected' : '' }}>PNS
                                            Depag</option>
                                        <option value="GTY/PTY" {{ $currStatus == 'GTY/PTY' ? 'selected' : '' }}>GTY/PTY
                                        </option>
                                        <option value="GTT/PTT Provinsi"
                                            {{ $currStatus == 'GTT/PTT Provinsi' ? 'selected' : '' }}>GTT/PTT Provinsi
                                        </option>
                                        <option value="GTT/PTT Kabupaten/Kota"
                                            {{ $currStatus == 'GTT/PTT Kabupaten/Kota' ? 'selected' : '' }}>GTT/PTT
                                            Kabupaten/Kota</option>
                                        <option value="Guru Bantu Pusat"
                                            {{ $currStatus == 'Guru Bantu Pusat' ? 'selected' : '' }}>Guru Bantu Pusat
                                        </option>
                                        <option value="Guru Honor Sekolah"
                                            {{ $currStatus == 'Guru Honor Sekolah' ? 'selected' : '' }}>Guru Honor Sekolah
                                        </option>
                                        <option value="Tenaga Honor Sekolah"
                                            {{ $currStatus == 'Tenaga Honor Sekolah' ? 'selected' : '' }}>Tenaga Honor
                                            Sekolah</option>
                                        <option value="PPPK" {{ $currStatus == 'PPPK' ? 'selected' : '' }}>PPPK</option>
                                        <option value="Lainnya" {{ $currStatus == 'Lainnya' ? 'selected' : '' }}>Lainnya
                                        </option>
                                    </select>
                                </div>

                                <!-- SK Pengangkatan -->
                                <div class="col-md-6">
                                    <label class="form-label">SK Pengangkatan</label>
                                    <input type="text" name="sk_pengangkatan"
                                        value="{{ old('sk_pengangkatan', $guru->sk_pengangkatan ?? '') }}"
                                        class="form-control text-uppercase" placeholder="Contoh: YNAA-10/SK/01/07/2021"
                                        required>
                                </div>

                                <!-- TMT Pengangkatan -->
                                <div class="col-md-6">
                                    <label class="form-label">TMT Pengangkatan</label>
                                    <input type="date" name="tmt_pengangkatan"
                                        value="{{ old('tmt_pengangkatan', $guru->tmt_pengangkatan ?? '') }}"
                                        class="form-control" required>
                                </div>

                                <!-- Lembaga Pengangkat -->
                                <div class="col-md-6">
                                    <label class="form-label">Lembaga Pengangkat</label>
                                    <input type="text" name="lembaga_pengangkat"
                                        value="{{ old('lembaga_pengangkat', $guru->lembaga_pengangkat ?? '') }}"
                                        class="form-control text-uppercase"
                                        placeholder="Contoh: Yayasan / Kepala Sekolah / Dinas" required>
                                </div>

                                <!-- NPWP -->
                                <div class="col-md-6">
                                    <label class="form-label">NPWP</label>
                                    <input type="text" name="npwp" id="npwp"
                                        value="{{ old('npwp', $guru->npwp ?? '') }}" class="form-control"
                                        placeholder="Contoh: 00.000.000.0-000.000">
                                </div>

                                <!-- Nama Wajib Pajak -->
                                <div class="col-md-6">
                                    <label class="form-label">Nama Wajib Pajak</label>
                                    <input type="text" name="nama_wajib_pajak"
                                        value="{{ old('nama_wajib_pajak', $guru->nama_wajib_pajak ?? '') }}"
                                        class="form-control text-uppercase">
                                </div>

                                <!-- Status Kuliah -->
                                <div class="col-md-6">
                                    <label class="form-label">Status Kuliah</label>
                                    <select name="status_kuliah" class="form-select" required>
                                        @php
                                            $currKuliah = old('status_kuliah', $guru->status_kuliah ?? '0');
                                        @endphp
                                        <option value="0" {{ $currKuliah == '0' ? 'selected' : '' }}>Tidak</option>
                                        <option value="1" {{ $currKuliah == '1' ? 'selected' : '' }}>Ya / Sedang
                                            Kuliah</option>
                                    </select>
                                </div>

                                <!-- No Surat Tugas -->
                                <div class="col-md-6">
                                    <label class="form-label">No. Surat Tugas</label>
                                    <input type="text" name="no_surat_tugas"
                                        value="{{ old('no_surat_tugas', $guru->no_surat_tugas ?? '') }}"
                                        class="form-control text-uppercase" required>
                                </div>

                                <!-- Tgl Surat Tugas -->
                                <div class="col-md-6">
                                    <label class="form-label">Tanggal Surat Tugas</label>
                                    <input type="date" name="tgl_surat_tugas"
                                        value="{{ old('tgl_surat_tugas', $guru->tgl_surat_tugas ?? '') }}"
                                        class="form-control" required>
                                </div>

                                <!-- Tahun Pensiun -->
                                <div class="col-md-6">
                                    <label class="form-label">Tahun Pensiun</label>
                                    <input type="number" name="tahun_pensiun"
                                        value="{{ old('tahun_pensiun', $guru->tahun_pensiun ?? '') }}"
                                        class="form-control" min="1900" max="2100" placeholder="Contoh: 2059"
                                        data-parsley-type="integer" data-parsley-range="[1900, 2100]" required>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="d-flex justify-content-between align-items-center">
                                @if ($st == 't')
                                    <a href="#" onclick="batal()" class="btn btn-danger">
                                        <i class="fas fa-times"></i> Batal
                                    </a>
                                @else
                                    <a href="{{ route('guru.dashboard') }}" class="btn btn-danger">
                                        <i class="fas fa-reply"></i> Kembali
                                    </a>
                                @endif

                                <div>
                                    <a href="{{ route('guru.lengkapi_data.step1') }}" class="btn btn-secondary me-2">
                                        <i class="fas fa-arrow-left"></i> Sebelumnya
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        Simpan & Lanjut <i class="fas fa-arrow-right"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('.select2').select2();

            $('#formSimpan').on('submit', function(e) {
                e.preventDefault();
                $(this).parsley().validate();
                if ($(this).parsley().isValid()) {
                    $('#loader').css('display', 'flex');
                    $.ajax({
                        url: "{{ route('guru.lengkapi_data.update.step2') }}",
                        type: "PUT",
                        data: $(this).serialize(),
                        success: function(response) {
                            if (response.status == 'success') {
                                $('#loader').css('display', 'none');
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: response.message,
                                }).then(() => {
                                    let url = "{{ route('guru.lengkapi_data.show') }}";
                                    window.location.href = url;
                                });
                            } else {
                                $('#loader').css('display', 'none');
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal',
                                    text: response.message,
                                });
                            }
                        },
                        error: function(xhr) {
                            $('#loader').css('display', 'none');
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Terjadi kesalahan pada server.',
                            });
                        }
                    });
                }
            });
        });

        function batal() {
            Swal.fire({
                title: 'Anda yakin?',
                text: 'Apakah anda yakin untuk membatalkan?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Tidak',
                confirmButtonText: 'Ya, batalkan!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#loader').css('display', 'flex');
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('guru.batal') }}",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "id": "{{ $guru->getRouteKey() }}"
                        },
                        success: function(hasil) {
                            $('#loader').css('display', 'none');
                            let url = "{{ route('guru') }}";

                            window.location.href = url;
                        }
                    });
                }
            });
        }
    </script>
@endpush
