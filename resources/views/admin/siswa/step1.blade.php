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
                            <h5 class="card-title">Biodata <span class="text-danger">{{ $siswa->nama }}</span></h5>
                        </div>
                        <div class="card-body">
                            <input hidden name="st" value="{{ $st }}">
                            <div class="row g-2">
                                <div class="col-md-6">
                                    <label class="form-label">Nama Lengkap</label>
                                    <input type="text" name="nama" id="nama" value="{{ $siswa->nama }}"
                                        class="form-control text-uppercase" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">NIUP</label>
                                    <input data-parsley-length="[16,16]"
                                        data-parsley-length-message="Harus terdiri dari 16 digit angka" type="number"
                                        name="niup" value="{{ $siswa->niup }}" class="form-control" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">NO KK</label>
                                    <input type="number" data-parsley-length="[16,16]"
                                        data-parsley-length-message="Harus terdiri dari 16 digit angka" name="no_kk"
                                        value="{{ $siswa->no_kk }}" class="form-control" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">NIK</label>
                                    <input type="number" data-parsley-length="[16,16]"
                                        data-parsley-length-message="Harus terdiri dari 16 digit angka" name="nik"
                                        value="{{ $siswa->nik }}" class="form-control" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">No Akta Kelahiran</label>
                                    <input type="text" name="no_akta" value="{{ $siswa->no_akta }}" class="form-control"
                                        required>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">NISN</label>
                                    <input type="number" name="nisn" value="{{ old('nisn', $siswa->nisn ?? '') }}"
                                        class="form-control" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Tempat Lahir</label>
                                    <input type="text" name="tempat_lahir"
                                        value="{{ old('tempat_lahir', $siswa->tempat_lahir ?? '') }}"
                                        class="form-control text-uppercase" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Tanggal Lahir</label>
                                    <input type="date" name="tanggal_lahir"
                                        value="{{ old('tanggal_lahir', $siswa->tanggal_lahir ?? '') }}"
                                        class="form-control" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Jenis Kelamin</label>
                                    <select name="jenis_kelamin" class="form-select" required>
                                        <option value="">-- Pilih Jenis Kelamin --</option>
                                        <option value="Laki-Laki"
                                            {{ old('jenis_kelamin', $siswa->jenis_kelamin ?? '') == 'Laki-Laki' ? 'selected' : '' }}>
                                            Laki-Laki
                                        </option>
                                        <option value="Perempuan"
                                            {{ old('jenis_kelamin', $siswa->jenis_kelamin ?? '') == 'Perempuan' ? 'selected' : '' }}>
                                            Perempuan
                                        </option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Agama</label>
                                    <select name="agama" class="form-select" required>
                                        <option value="">-- Pilih Agama --</option>
                                        @foreach ($agama as $a)
                                            <option value="{{ $a->id }}"
                                                {{ old('agama', $siswa->agama->id ?? '') == $a->id ? 'selected' : '' }}>
                                                {{ $a->nama_agama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Status dalam Keluarga</label>
                                    <select name="dlm_klrg" class="form-select" required>
                                        <option value="">-- Pilih Status --</option>
                                        @foreach (['Kandung', 'Tiri', 'Angkat'] as $k)
                                            <option value="{{ $k }}"
                                                {{ old('dlm_klrg', $siswa->dlm_klrg ?? '') == $k ? 'selected' : '' }}>
                                                {{ $k }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Anak ke</label>
                                    <input type="number" name="ank_ke" value="{{ old('ank_ke', $siswa->ank_ke ?? '') }}"
                                        class="form-control" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Jumlah Saudara</label>
                                    <input type="number" name="sdr" value="{{ old('sdr', $siswa->sdr ?? '') }}"
                                        class="form-control" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Jurusan</label>
                                    <select name="jurusan" class="form-select" required>
                                        <option value="">-- Pilih Jurusan --</option>
                                        @foreach ($jurusan as $j)
                                            <option value="{{ $j->id }}"
                                                {{ old('jurusan', $siswa->jurusan->id ?? '') == $j->id ? 'selected' : '' }}>
                                                {{ $j->program_keahlian }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Jenis Pendaftaran</label>
                                    <select name="jenis_daftar" class="form-select" required>
                                        <option value="">-- Pilih Jenis Pendaftaran --</option>
                                        @foreach (['BARU', 'PINDAH'] as $jns)
                                            <option value="{{ $jns }}"
                                                {{ old('jenis_daftar', $siswa->jenis_daftar ?? '') == $jns ? 'selected' : '' }}>
                                                {{ $jns }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Asal Sekolah</label>
                                    <input type="text" name="asal_sekolah"
                                        value="{{ old('asal_sekolah', $siswa->asal_sekolah ?? '') }}"
                                        class="form-control text-uppercase" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Nomor Ijazah</label>
                                    <input type="text" name="nomor_ijazah"
                                        value="{{ old('nomor_ijazah', $siswa->nomor_ijazah ?? '') }}"
                                        class="form-control" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Tinggal Di</label>
                                    <select name="tinggal_di" class="form-select" required>
                                        <option value="">-- Pilih Tempat Tinggal --</option>
                                        @foreach (['BERSAMA ORANG TUA', 'WALI', 'KOST', 'ASRAMA', 'PANTI ASUHAN', 'PESANTREN', 'LAINNYA'] as $t)
                                            <option value="{{ $t }}"
                                                {{ old('tinggal_di', $siswa->tinggal_di ?? '') == $t ? 'selected' : '' }}>
                                                {{ $t }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Tinggi (cm)</label>
                                    <input type="number" name="tinggi_badan"
                                        value="{{ old('tinggi_badan', $siswa->tinggi_badan ?? '') }}"
                                        class="form-control" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Berat (kg)</label>
                                    <input type="number" name="berat_badan"
                                        value="{{ old('berat_badan', $siswa->berat_badan ?? '') }}" class="form-control"
                                        required>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Hobi</label>
                                    <input type="text" name="hoby" value="{{ old('hoby', $siswa->hoby ?? '') }}"
                                        class="form-control text-uppercase" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Cita-Cita</label>
                                    <input type="text" name="cita_cita"
                                        value="{{ old('cita_cita', $siswa->cita_cita ?? '') }}"
                                        class="form-control text-uppercase" required>
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
            $('#formSimpan').on('submit', function(e) {
                e.preventDefault();
                $(this).parsley().validate();
                if ($(this).parsley().isValid()) {
                    $('#loader').css('display', 'flex');
                    $.ajax({
                        url: "{{ route('siswa.update.step1', $siswa->id_person) }}",
                        type: "PUT",
                        data: $(this).serialize(),
                        success: function(response) {
                            if (response.status == 'success') {
                                $('#loader').css('display', 'none');
                                let url =
                                    "/admin/siswa_edit/step2/" +
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
                        url: "{{ route('siswa.batal') }}",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "id": "{{ $siswa->id_person }}"
                        },
                        success: function(hasil) {
                            $('#loader').css('display', 'none');
                            let url = "{{ route('siswa') }}";

                            window.location.href = url;
                        }
                    });
                }
            });
        }
    </script>
@endpush
