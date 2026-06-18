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
                <form id="formSimpan" data-parsley-validate>
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Biodata <span class="text-danger">{{ $guru->nama }}</span></h5>
                        </div>
                        <div class="card-body">
                            <input hidden name="st" value="{{ $st }}">
                            <div class="row g-2">
                                <div class="col-md-9">
                                    <label class="form-label">Nama Lengkap</label>
                                    <input type="text" name="nama" id="nama" value="{{ $guru->nama }}"
                                        class="form-control text-uppercase" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">NIK</label>
                                    <input type="number" data-parsley-length="[16,16]"
                                        data-parsley-length-message="Harus terdiri dari 16 digit angka" name="nik"
                                        value="{{ $guru->nik }}" class="form-control" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">NIP</label>
                                    <input {{-- data-parsley-length="[16,16]" --}} {{-- data-parsley-length-message="Harus terdiri dari 16 digit angka"  --}} type="number" name="nip"
                                        value="{{ $guru->nip }}" class="form-control" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">NUPTK</label>
                                    <input type="number" {{-- data-parsley-length="[16,16]" --}} {{-- data-parsley-length-message="Harus terdiri dari 16 digit angka" --}} name="nuptk"
                                        value="{{ $guru->nuptk }}" class="form-control" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Jenis Kelamin</label>
                                    <select name="jenis_kelamin" class="form-select" required>
                                        <option value="">-- Pilih Jenis Kelamin --</option>
                                        <option value="L"
                                            {{ old('jenis_kelamin', $guru->jenis_kelamin ?? '') == 'L' ? 'selected' : '' }}>
                                            Laki-Laki
                                        </option>
                                        <option value="P"
                                            {{ old('jenis_kelamin', $guru->jenis_kelamin ?? '') == 'P' ? 'selected' : '' }}>
                                            Perempuan
                                        </option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Tempat Lahir</label>
                                    <input type="text" name="tempat_lahir"
                                        value="{{ old('tempat_lahir', $guru->tempat_lahir ?? '') }}"
                                        class="form-control text-uppercase" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Tanggal Lahir</label>
                                    <input type="date" name="tanggal_lahir"
                                        value="{{ old('tanggal_lahir', $guru->tanggal_lahir ?? '') }}" class="form-control"
                                        required>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Agama</label>
                                    <select name="agama" class="form-select" required>
                                        <option value="">-- Pilih Agama --</option>
                                        @foreach ($agama as $a)
                                            <option value="{{ $a->id }}"
                                                {{ old('agama', $guru->agama->id ?? '') == $a->id ? 'selected' : '' }}>
                                                {{ $a->nama_agama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Jurusan</label>
                                    <select name="jurusan" class="form-select" required>
                                        <option value="">-- Pilih Jurusan --</option>
                                        @foreach ($jurusan as $j)
                                            <option value="{{ $j->id }}"
                                                {{ old('jurusan', $guru->jurusan->id ?? '') == $j->id ? 'selected' : '' }}>
                                                {{ $j->program_keahlian }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Jenis PTK</label>
                                    <select name="jenis_gtk" id="jenis_gtk" class="form-select" required>
                                        <option value="">-- Pilih Jenis PTK --</option>
                                        <option {{ old('jenis_gtk') == 'Guru' ? 'selected' : '' }} value="Guru">Guru
                                        </option>
                                        <option {{ old('jenis_gtk') == 'Kepala Sekolah' ? 'selected' : '' }}
                                            value="Kepala Sekolah">Kepala Sekolah</option>
                                        <option {{ old('jenis_gtk') == 'Tenaga Administrasi Sekolah' ? 'selected' : '' }}
                                            value="Tenaga Administrasi Sekolah">Tenaga Administrasi Sekolah</option>
                                        <option {{ old('jenis_gtk') == 'Pustakawan' ? 'selected' : '' }}
                                            value="Pustakawan">Pustakawan</option>
                                        <option {{ old('jenis_gtk') == 'Laboran' ? 'selected' : '' }} value="Laboran">
                                            Laboran</option>
                                        <option {{ old('jenis_gtk') == 'Pengawas Sekolah' ? 'selected' : '' }}
                                            value="Pengawas Sekolah">Pengawas Sekolah</option>
                                        <option {{ old('jenis_gtk') == 'Lainnya' ? 'selected' : '' }} value="Lainnya">
                                            Lainnya</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Jabatan PTK</label>
                                    <select name="jabatan_gtk" id="jabatan_gtk" class="form-select" required>
                                        <option value="">-- Pilih Jabatan PTK --</option>
                                        <option {{ old('jabatan_gtk') == 'Kepala Sekolah' ? 'selected' : '' }}
                                            value="Kepala Sekolah">
                                            Kepala Sekolah</option>
                                        <option {{ old('jabatan_gtk') == 'Wakil Kepala Sekolah' ? 'selected' : '' }}
                                            value="Wakil Kepala Sekolah">
                                            Wakil Kepala Sekolah</option>
                                        <option {{ old('jabatan_gtk') == 'Guru Mata Pelajaran' ? 'selected' : '' }}
                                            value="Guru Mata Pelajaran">
                                            Guru Mata Pelajaran</option>
                                        <option {{ old('jabatan_gtk') == 'Guru Kelas' ? 'selected' : '' }}
                                            value="Guru Kelas">
                                            Guru Kelas</option>
                                        <option {{ old('jabatan_gtk') == 'Guru BK' ? 'selected' : '' }} value="Guru BK">
                                            Guru BK</option>
                                        <option {{ old('jabatan_gtk') == 'Wali Kelas' ? 'selected' : '' }}
                                            value="Wali Kelas">
                                            Wali Kelas</option>
                                        <option {{ old('jabatan_gtk') == 'Kepala Tata Usaha' ? 'selected' : '' }}
                                            value="Kepala Tata Usaha">
                                            Kepala Tata Usaha</option>
                                        <option {{ old('jabatan_gtk') == 'Staf Tata Usaha' ? 'selected' : '' }}
                                            value="Staf Tata Usaha">
                                            Staf Tata Usaha</option>
                                        <option {{ old('jabatan_gtk') == 'Operator Sekolah' ? 'selected' : '' }}
                                            value="Operator Sekolah">
                                            Operator Sekolah</option>
                                        <option {{ old('jabatan_gtk') == 'Pustakawan' ? 'selected' : '' }}
                                            value="Pustakawan">
                                            Pustakawan</option>
                                        <option {{ old('jabatan_gtk') == 'Laboran' ? 'selected' : '' }} value="Laboran">
                                            Laboran</option>
                                        <option {{ old('jabatan_gtk') == 'Teknisi' ? 'selected' : '' }} value="Teknisi">
                                            Teknisi</option>
                                        <option {{ old('jabatan_gtk') == 'Satpam' ? 'selected' : '' }} value="Satpam">
                                            Satpam</option>
                                        <option {{ old('jabatan_gtk') == 'Petugas Kebersihan' ? 'selected' : '' }}
                                            value="Petugas Kebersihan">
                                            Petugas Kebersihan</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Status Perkawinan</label>
                                    <select name="status_perkawinan" id="status_perkawinan" class="form-select" required>
                                        <option value="">-- Pilih Status Perkawinan --</option>
                                        <option {{ old('status_perkawinan') == 'kawin' ? 'selected' : '' }}
                                            value="kawin">Kawin</option>
                                        <option {{ old('status_perkawinan') == 'belum' ? 'selected' : '' }}
                                            value="belum">Belum</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="email" id="email" class="form-control" required
                                        data-parsley-type-message="Format email tidak valid" value="{{ $guru->email }}">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">No Handphone</label>
                                    <input type="number" name="no_hp" id="no_hp" class="form-control" required
                                        data-parsley-length="[11,13]"
                                        data-parsley-length-message="Harus terdiri dari 11 sampai 13 digit angka"
                                        value="{{ $guru->no_hp }}">
                                </div>
                                <div class="col-md-9">
                                    <label class="form-label">Alamat Sesuai KTP</label>
                                    <input type="text" name="alamat" id="alamat" value="{{ $guru->alamat }}"
                                        class="form-control text-uppercase" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Kode Pos</label>
                                    <input type="number" name="pos" id="pos" value="{{ $guru->pos }}"
                                        class="form-control" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Provinsi</label>
                                    <select name="prov" id="prov" class="form-control select2" required>
                                        <option value="">-- Pilih Provinsi --</option>
                                        @foreach ($provinsi as $p)
                                            <option value="{{ $p->id }}"
                                                {{ old('prov', $guru->prov ?? '') == $p->id ? 'selected' : '' }}>
                                                {{ $p->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <!-- Kabupaten -->
                                <div class="col-md-3">
                                    <label class="form-label">Kabupaten</label>
                                    <select name="kab" id="kab" class="form-control select2" required>
                                        <option value="">-- Pilih Kabupaten --</option>
                                    </select>
                                </div>
                                <!-- Kecamatan -->
                                <div class="col-md-3">
                                    <label class="form-label">Kecamatan</label>
                                    <select name="kec" id="kec" class="form-control select2" required>
                                        <option value="">-- Pilih Kecamatan --</option>
                                    </select>
                                </div>
                                <!-- Desa -->
                                <div class="col-md-3">
                                    <label class="form-label">Desa</label>
                                    <select name="desa" id="desa" class="form-control select2" required>
                                        <option value="">-- Pilih Desa --</option>
                                    </select>
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
                                    <a href="{{ route('siswa') }}" class="btn btn-danger">
                                        <i class="fas fa-reply"></i> Kembali
                                    </a>
                                @endif
                                <!-- Kiri -->


                                <!-- Kanan -->
                                <button type="submit" class="btn btn-primary">
                                    Simpan & Lanjut <i class="fas fa-arrow-right"></i>
                                </button>
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
            $('#nama').focus()

            $('.select2').select2()

            let provinsiID = "{{ $guru->prov }}";
            let kabID = "{{ $guru->kab }}";
            let kecamatanID = "{{ $guru->kec }}";
            let desaID = "{{ $guru->desa }}";

            if (provinsiID) {
                $.ajax({
                    url: '/get-kota/' + provinsiID,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#kab').empty().append('<option value="">Pilih Kabupaten</option>');
                        $.each(data, function(key, value) {
                            $('#kab').append('<option value="' + value.id + '">' + value.name +
                                '</option>');
                        });
                        $('#kab').val(kabID);

                        if (kabID) {
                            $.ajax({
                                url: '/get-kecamatan/' + kabID,
                                type: 'GET',
                                dataType: 'json',
                                success: function(data) {
                                    $('#kec').empty().append(
                                        '<option value="">Pilih Kecamatan</option>'
                                    );
                                    $.each(data, function(key, value) {
                                        $('#kec').append('<option value="' +
                                            value.id + '">' + value.name +
                                            '</option>');
                                    });
                                    $('#kec').val(kecamatanID);
                                }
                            });

                            if (kecamatanID) {
                                $.ajax({
                                    url: '/get-desa/' + kecamatanID,
                                    type: 'GET',
                                    dataType: 'json',
                                    success: function(data) {
                                        $('#desa').empty().append(
                                            '<option value="">Pilih Desa</option>'
                                        );
                                        $.each(data, function(key, value) {
                                            $('#desa').append('<option value="' +
                                                value.id + '">' + value.name +
                                                '</option>');
                                        });
                                        $('#desa').val(desaID);
                                    }
                                });
                            }
                        }
                    }
                });
            }

            $('#prov').on('change', function() {
                var provinsiID = $(this).val();
                $('#kab').html('<option value="">Pilih Kabupaten</option>');
                $('#kec').html('<option value="">Pilih Kecamatan</option>');
                $('#desa').html('<option value="">Pilih Desa</option>');
                if (provinsiID) {
                    $.ajax({
                        url: '/get-kota/' + provinsiID,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            $('#kab').empty().append(
                                '<option value="">Pilih Kabupaten</option>');
                            $.each(data, function(key, value) {
                                $('#kab').append('<option value="' + value.id +
                                    '">' +
                                    value.name + '</option>');
                            });
                        }
                    });
                } else {
                    $('#kab').html('<option value="">Pilih Kabupaten</option>');
                }
            });

            $('#kab').on('change', function() {
                var kabID = $(this).val();
                $('#kec').html('<option value="">Pilih Kecamatan</option>');

                if (kabID) {
                    $.ajax({
                        url: '/get-kecamatan/' + kabID,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            $('#kec').empty().append(
                                '<option value="">Pilih Kecamatan</option>');
                            $.each(data, function(key, value) {
                                $('#kec').append('<option value="' + value.id +
                                    '">' + value.name + '</option>');
                            });
                        }
                    });
                } else {
                    $('#kec').html('<option value="">Pilih Kecamatan</option>');
                }
            });

            $('#kec').on('change', function() {
                var kecID = $(this).val();
                $('#desa').html('<option value="">Pilih Desa</option>');
                if (kecID) {
                    $.ajax({
                        url: '/get-desa/' + kecID,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            $('#desa').empty().append(
                                '<option value="">Pilih Desa</option>');
                            $.each(data, function(key, value) {
                                $('#desa').append('<option value="' + value.id +
                                    '">' + value.name + '</option>');
                            });
                        }
                    });
                } else {
                    $('#desa').html('<option value="">Pilih Desa</option>');
                }
            });

            $('#formSimpan').on('submit', function(e) {
                e.preventDefault();
                $(this).parsley().validate();
                if ($(this).parsley().isValid()) {
                    $('#loader').css('display', 'flex');
                    $.ajax({
                        url: "{{ route('guru.update.step1', $guru->id) }}",
                        type: "PUT",
                        data: $(this).serialize(),
                        success: function(response) {
                            if (response.status == 'success') {
                                $('#loader').css('display', 'none');
                                let url =
                                    "/admin/guru_edit/step2/" +
                                    response
                                    .id + "/" + response.st;

                                window.location.href = url;
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
                            "id": "{{ $guru->id }}"
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
