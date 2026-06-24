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
                            <div class="row g-2">
                                <div class="col-md-6">
                                    <label class="form-label">Alamat Lengkap</label>
                                    <input type="text" value="{{ old('alamat_lengkap', $siswa->alamat_lengkap ?? '') }}"
                                        name="alamat_lengkap" id="alamat_lengkap" class="form-control text-uppercase"
                                        required>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Kewarganegaraan</label>
                                    <select name="kewarganegaraan" class="form-select" required>
                                        <option value="">-- Pilih Kewarganegaraan --</option>
                                        @foreach (['WNI', 'WNA'] as $w)
                                            <option value="{{ $w }}"
                                                {{ old('kewarganegaraan', $siswa->kewarganegaraan ?? '') == $w ? 'selected' : '' }}>
                                                {{ $w }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Kode Pos</label>
                                    <input type="number" name="pos" value="{{ old('pos', $siswa->pos ?? '') }}"
                                        class="form-control" required>
                                </div>
                                <!-- Provinsi -->
                                <div class="col-md-3">
                                    <label class="form-label">Provinsi</label>
                                    <select name="prov" id="prov" class="form-control select2" required>
                                        <option value="">-- Pilih Provinsi --</option>
                                        @foreach ($provinsi as $p)
                                            <option value="{{ $p->id }}"
                                                {{ old('prov', $siswa->prov ?? '') == $p->id ? 'selected' : '' }}>
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
                                <a href="{{ route('siswa.edit.step1', [$siswa, $st]) }}"
                                    class="btn btn-primary">
                                    <i class="fas fa-arrow-left"></i> Sebelumnya
                                </a>

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
            $('#alamat_lengkap').focus()
            $('.select2').select2()

            let provinsiID = "{{ $siswa->prov }}";
            let kabID = "{{ $siswa->kab }}";
            let kecamatanID = "{{ $siswa->kec }}";
            let desaID = "{{ $siswa->desa }}";

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
                        url: "{{ route('siswa.update.step2', $siswa) }}",
                        type: "PUT",
                        data: $(this).serialize(),
                        success: function(response) {
                            if (response.status == 'success') {
                                $('#loader').css('display', 'none');
                                let url =
                                    "/admin/siswa_edit/step3/" +
                                    response
                                    .id_person + "/" + response.st;

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
    </script>
@endpush
