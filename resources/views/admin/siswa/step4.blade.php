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
                    <input hidden name="st" value="{{ $st }}">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Alamat Lengkap <span class="text-danger">{{ $siswa->nama }}</span></h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <button type="button" class="btn btn-outline-primary" onclick="copyAyah()">
                                    Copy dari Ayah
                                </button>

                                <button type="button" class="btn btn-outline-success" onclick="copyIbu()">
                                    Copy dari Ibu
                                </button>
                            </div>
                            <div class="row g-2">

                                <div class="col-md-4">
                                    <label>Nama Wali</label>
                                    <input type="text" name="nm_w" class="form-control" required
                                        value="{{ $siswa->nm_w }}">
                                </div>

                                <div class="col-md-4">
                                    <label>NIK Wali</label>
                                    <input type="number" data-parsley-length="[16,16]"
                                        data-parsley-length-message="Harus terdiri dari 16 digit angka" name="nik_w"
                                        class="form-control" required value="{{ $siswa->nik_w }}">
                                </div>

                                <div class="col-md-4">
                                    <label>Tempat Lahir Wali</label>
                                    <input type="text" name="tmpt_lahir_w" class="form-control" required
                                        value="{{ $siswa->tmpt_lahir_w }}">
                                </div>

                                <div class="col-md-4">
                                    <label>Tanggal Lahir Wali</label>
                                    <input type="date" name="tgl_lahir_w" class="form-control" required
                                        value="{{ $siswa->tgl_lahir_w }}">
                                </div>

                                <div class="col-md-4">
                                    <label>Agama</label>
                                    <select name="agama_w" class="form-select" required>
                                        <option value="">-- Pilih --</option>
                                        @foreach ($agama as $a)
                                            <option value="{{ $a->id }}"
                                                {{ $a->id == $siswa->agama_w ? 'selected' : '' }}>
                                                {{ $a->nama_agama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label>Pekerjaan</label>
                                    <select name="pkrjn_w" class="form-select" required>
                                        <option value="">-- Pilih --</option>
                                        @foreach ($pekerjaan as $p)
                                            <option value="{{ $p->id }}"
                                                {{ $p->id == $siswa->pkrjn_w ? 'selected' : '' }}>
                                                {{ $p->nama_pekerjaan }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label>Pendidikan</label>
                                    <select name="pndkn_w" class="form-select" required>
                                        <option value="">-- Pilih --</option>
                                        @foreach ($pendidikan as $p)
                                            <option value="{{ $p->id }}"
                                                {{ $p->id == $siswa->pndkn_w ? 'selected' : '' }}>
                                                {{ $p->jenjang }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label>Penghasilan</label>
                                    <select name="penghasilan_w" class="form-select" required>
                                        <option value="">-- Pilih --</option>
                                        @foreach ($penghasilan as $p)
                                            <option value="{{ $p->id }}"
                                                {{ $p->id == $siswa->penghasilan_w ? 'selected' : '' }}>
                                                {{ $p->kategori }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label>No HP</label>
                                    <input type="number" data-parsley-length="[11,13]"
                                        data-parsley-length-message="Harus terdiri dari 11 sampai 13 digit angka"
                                        name="hp_w" class="form-control" required value="{{ $siswa->hp_w }}">
                                </div>

                                <div class="col-md-9">
                                    <label class="form-label">Alamat Lengkap</label>
                                    <input type="text" value="{{ old('almt_w', $siswa->almt_w ?? '') }}" name="almt_w"
                                        class="form-control text-uppercase" required>
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label">Kode Pos</label>
                                    <input type="text" name="pos_w" value="{{ old('pos_w', $siswa->pos_w ?? '') }}"
                                        class="form-control" required>
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label">Provinsi</label>
                                    <select name="prov_w" id="prov" class="form-select select2" required>
                                        <option value="">Pilih Provinsi</option>
                                        @foreach ($provinsi as $p)
                                            <option value="{{ $p->id }}"
                                                {{ old('prov_w', $siswa->prov_w ?? '') == $p->id ? 'selected' : '' }}>
                                                {{ $p->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Kabupaten -->
                                <div class="col-md-3">
                                    <label class="form-label">Kabupaten</label>
                                    <select name="kab_w" id="kab" class="form-select select2" required>
                                        <option value="">Pilih Kabupaten</option>
                                    </select>
                                </div>

                                <!-- Kecamatan -->
                                <div class="col-md-3">
                                    <label class="form-label">Kecamatan</label>
                                    <select name="kec_w" id="kec" class="form-select select2" required>
                                        <option value="">Pilih Kecamatan</option>
                                    </select>
                                </div>

                                <!-- Desa -->
                                <div class="col-md-3">
                                    <label class="form-label">Desa</label>
                                    <select name="desa_w" id="desa" class="form-select select2" required>
                                        <option value="">Pilih Desa</option>
                                    </select>
                                </div>


                            </div>
                        </div>
                        <div class="card-footer">
                            @if ($st == 't')
                                <a href="#" onclick="batal()" class="btn btn-danger">
                                    <i class="fas fa-times"></i> Batal
                                </a>
                            @else
                                <a href="{{ route('siswa') }}" class="btn btn-danger">
                                    <i class="fas fa-reply"></i> Kembali
                                </a>
                            @endif
                            <div class="float-end">
                                <a href="{{ route('siswa.edit.step3', [$siswa->id_person, $st]) }}"
                                    class="btn btn-primary">
                                    <i class="fas fa-arrow-left"></i> Sebelumnya
                                </a>

                                <!-- Kanan -->
                                <button type="submit" class="btn btn-success">
                                    Selesai <i class="fas fa-check"></i>
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
            $('.select2').select2()

            let provinsiID = "{{ $siswa->prov_w }}";
            let kabID = "{{ $siswa->kab_w }}";
            let kecamatanID = "{{ $siswa->kec_w }}";
            let desaID = "{{ $siswa->desa_w }}";

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
                    Swal.fire({
                        title: 'Selesai?',
                        text: "Sebelum klik selesai pastikan semua data telah valid!",
                        icon: 'question',
                        confirmButtonColor: '#198655',
                        cancelButtonColor: '#d33',
                        showCancelButton: true,
                        confirmButtonText: 'Ya, Selesai!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $('#loader').css('display', 'flex');
                            $.ajax({
                                url: "{{ route('siswa.update.step4', $siswa->id_person) }}",
                                type: "PUT",
                                data: $(this).serialize(),
                                success: function(response) {
                                    if (response.status == 'success') {
                                        $('#loader').css('display', 'none');
                                        let url = "{{ route('siswa') }}"
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
                }
            });
        });

        function copyAyah() {
            Swal.fire({
                title: 'Copy data dari Ayah?',
                text: "Data yang sudah diisi akan ter-overwrite",
                icon: 'warning',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                showCancelButton: true,
                confirmButtonText: 'Ya, copy!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.querySelector('[name=nm_w]').value = "{{ $siswa->nm_a }}";
                    document.querySelector('[name=nik_w]').value = "{{ $siswa->nik_a }}";
                    document.querySelector('[name=tmpt_lahir_w]').value = "{{ $siswa->tmpt_lahir_a }}";
                    document.querySelector('[name=tgl_lahir_w]').value = "{{ $siswa->tgl_lahir_a }}";
                    document.querySelector('[name=agama_w]').value = "{{ $siswa->agama_a }}";
                    document.querySelector('[name=pkrjn_w]').value = "{{ $siswa->pkrjn_a }}";
                    document.querySelector('[name=pndkn_w]').value = "{{ $siswa->pndkn_a }}";
                    document.querySelector('[name=penghasilan_w]').value = "{{ $siswa->penghasilan_a }}";
                }
            });
        }

        function copyIbu() {
            Swal.fire({
                title: 'Copy data dari Ibu?',
                text: "Data yang sudah diisi akan ter-overwrite",
                icon: 'warning',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                showCancelButton: true,
                confirmButtonText: 'Ya, copy!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.querySelector('[name=nm_w]').value = "{{ $siswa->nm_i }}";
                    document.querySelector('[name=nik_w]').value = "{{ $siswa->nik_i }}";
                    document.querySelector('[name=tmpt_lahir_w]').value = "{{ $siswa->tmpt_lahir_i }}";
                    document.querySelector('[name=tgl_lahir_w]').value = "{{ $siswa->tgl_lahir_i }}";
                    document.querySelector('[name=agama_w]').value = "{{ $siswa->agama_i }}";
                    document.querySelector('[name=pkrjn_w]').value = "{{ $siswa->pkrjn_i }}";
                    document.querySelector('[name=pndkn_w]').value = "{{ $siswa->pndkn_i }}";
                    document.querySelector('[name=penghasilan_w]').value = "{{ $siswa->penghasilan_i }}";
                }
            });
        }
    </script>
@endpush
