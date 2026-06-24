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
                            <h5 class="card-title">Biodata Orang Tua <span class="text-danger">{{ $siswa->nama }}</span>
                            </h5>
                        </div>
                        <div class="card-body">
                            @csrf
                            <input hidden name="st" value="{{ $st }}">
                            <div class="row g-3">

                                <div class="col-md-3">
                                    <label>Nama Ayah</label>
                                    <input type="text" name="nm_a" id="nm_a" class="form-control text-uppercase"
                                        value="{{ old('nm_a', $siswa->nm_a ?? '') }}" required>
                                </div>

                                <div class="col-md-3">
                                    <label>NIK Ayah</label>
                                    <input type="text" data-parsley-length="[16,16]"
                                        data-parsley-length-message="Harus terdiri dari 16 digit angka" name="nik_a"
                                        class="form-control" value="{{ old('nik_a', $siswa->nik_a ?? '') }}" required>
                                </div>

                                <div class="col-md-3">
                                    <label>Tempat Lahir Ayah</label>
                                    <input type="text" name="tmpt_lahir_a" class="form-control  text-uppercase"
                                        value="{{ old('tmpt_lahir_a', $siswa->tmpt_lahir_a ?? '') }}" required>
                                </div>

                                <div class="col-md-3">
                                    <label>Tanggal Lahir Ayah</label>
                                    <input type="date" name="tgl_lahir_a"
                                        value="{{ old('tgl_lahir_a', $siswa->tgl_lahir_a ?? '') }}" class="form-control"
                                        required>
                                </div>

                                <div class="col-md-3">
                                    <label>Agama</label>
                                    <select name="agama_a" class="form-select" required>
                                        <option value="">-- Pilih Agama --</option>
                                        @foreach ($agama as $a)
                                            <option value="{{ $a->id }}"
                                                {{ old('agama_a', $siswa->agama_a ?? '') == $a->id ? 'selected' : '' }}>
                                                {{ $a->nama_agama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <label>Pekerjaan</label>
                                    <select name="pkrjn_a" class="form-select" required>
                                        <option value="">-- Pilih Pekerjaan --</option>
                                        @foreach ($pekerjaan as $p)
                                            <option value="{{ $p->id }}"
                                                {{ old('pkrjn_a', $siswa->pkrjn_a ?? '') == $p->id ? 'selected' : '' }}>
                                                {{ $p->nama_pekerjaan }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <label>Pendidikan</label>
                                    <select name="pndkn_a" class="form-select" required>
                                        <option value="">-- Pilih Pendidikan --</option>
                                        @foreach ($pendidikan as $p)
                                            <option value="{{ $p->id }}"
                                                {{ old('pndkn_a', $siswa->pndkn_a ?? '') == $p->id ? 'selected' : '' }}>
                                                {{ $p->jenjang }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <label>Penghasilan</label>
                                    <select name="penghasilan_a" class="form-select" required>
                                        <option value="">-- Pilih Penghasilan --</option>
                                        @foreach ($penghasilan as $p)
                                            <option value="{{ $p->id }}"
                                                {{ old('penghasilan_a', $siswa->penghasilan_a ?? '') == $p->id ? 'selected' : '' }}>
                                                {{ $p->kategori }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>

                            <hr class="border-secondary border-2 opacity-75 mb-5 mt-5">

                            <div class="row g-3">

                                <div class="col-md-3">
                                    <label>Nama Ibu</label>
                                    <input type="text" name="nm_i" value="{{ old('nm_i', $siswa->nm_i ?? '') }}"
                                        class="form-control text-uppercase" required>
                                </div>

                                <div class="col-md-3">
                                    <label>NIK Ibu</label>
                                    <input type="text" data-parsley-length="[16,16]"
                                        data-parsley-length-message="Harus terdiri dari 16 digit angka" name="nik_i"
                                        class="form-control" value="{{ old('nik_i', $siswa->nik_i ?? '') }}" required>
                                </div>

                                <div class="col-md-3">
                                    <label>Tempat Lahir Ibu</label>
                                    <input type="text" name="tmpt_lahir_i"
                                        value="{{ old('tmpt_lahir_i', $siswa->tmpt_lahir_i ?? '') }}"
                                        class="form-control text-uppercase" required>
                                </div>

                                <div class="col-md-3">
                                    <label>Tanggal Lahir Ibu</label>
                                    <input type="date" name="tgl_lahir_i"
                                        value="{{ old('tgl_lahir_i', $siswa->tgl_lahir_i ?? '') }}" class="form-control"
                                        required>
                                </div>

                                <div class="col-md-3">
                                    <label>Agama</label>
                                    <select name="agama_i" class="form-select" required>
                                        <option value="">-- Pilih Agama --</option>
                                        @foreach ($agama as $a)
                                            <option value="{{ $a->id }}"
                                                {{ old('agama_i', $siswa->agama_i ?? '') == $a->id ? 'selected' : '' }}>
                                                {{ $a->nama_agama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <label>Pekerjaan</label>
                                    <select name="pkrjn_i" class="form-select" required>
                                        <option value="">-- Pilih Pekerjaan --</option>
                                        @foreach ($pekerjaan as $p)
                                            <option value="{{ $p->id }}"
                                                {{ old('pkrjn_i', $siswa->pkrjn_i ?? '') == $p->id ? 'selected' : '' }}>
                                                {{ $p->nama_pekerjaan }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <label>Pendidikan</label>
                                    <select name="pndkn_i" class="form-select" required>
                                        <option value="">-- Pilih Pendidikan --</option>
                                        @foreach ($pendidikan as $p)
                                            <option value="{{ $p->id }}"
                                                {{ old('pndkn_i', $siswa->pndkn_i ?? '') == $p->id ? 'selected' : '' }}>

                                                {{ $p->jenjang }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <label>Penghasilan</label>
                                    <select name="penghasilan_i" class="form-select" required>
                                        <option value="">-- Pilih Penghasilan --</option>
                                        @foreach ($penghasilan as $p)
                                            <option value="{{ $p->id }}"
                                                {{ old('penghasilan_i', $siswa->penghasilan_i ?? '') == $p->id ? 'selected' : '' }}>
                                                {{ $p->kategori }}
                                            </option>
                                        @endforeach
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
                                <a href="{{ route('siswa.edit.step2', [$siswa, $st]) }}"
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
            $('#nm_a').focus()
            $('#formSimpan').on('submit', function(e) {
                e.preventDefault();
                $(this).parsley().validate();
                if ($(this).parsley().isValid()) {
                    $('#loader').css('display', 'flex');
                    $.ajax({
                        url: "{{ route('siswa.update.step3', $siswa) }}",
                        type: "PUT",
                        data: $(this).serialize(),
                        success: function(response) {
                            if (response.status == 'success') {
                                $('#loader').css('display', 'none');
                                let url =
                                    "/admin/siswa_edit/step4/" +
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
