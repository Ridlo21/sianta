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
                <form id="formUpload" data-parsley-validate>
                    @csrf
                    @method('PUT')
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Upload Berkas <span class="text-danger">{{ $siswa->nama }}</span></h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-2">
                                <div class="col-md-4">
                                    <label class="form-label">Foto Siswa</label>
                                    <img id="preview" class="img-thumbnail mt-2 mb-3"
                                        src="{{ $siswa->foto_warna_santri ? asset('gambar_berkas/berkas_siswa/' . $siswa->foto_warna_santri) : '' }}"
                                        style="max-width: 300px; {{ $siswa->foto_warna_santri ? '' : 'display:none;' }}">
                                    <input type="file" name="foto_warna_santri" id="foto_warna_santri"
                                        class="form-control text-uppercase"
                                        accept="image/png, image/jpeg, image/jpg"
                                        data-parsley-filemaxsize="2"
                                        data-parsley-fileextension="jpg,jpeg,png"
                                        {{ $siswa->foto_warna_santri == '' ? 'required' : '' }}>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Foto Scan KK</label>
                                    <img id="preview2" class="img-thumbnail mt-2 mb-3"
                                        src="{{ $siswa->foto_scan_kk ? asset('gambar_berkas/berkas_siswa/' . $siswa->foto_scan_kk) : '' }}"
                                        style="max-width: 300px; {{ $siswa->foto_scan_kk ? '' : 'display:none;' }}">
                                    <input type="file" name="foto_scan_kk" id="foto_scan_kk"
                                        class="form-control text-uppercase"
                                        accept="image/png, image/jpeg, image/jpg"
                                        data-parsley-filemaxsize="2"
                                        data-parsley-fileextension="jpg,jpeg,png"
                                        {{ $siswa->foto_scan_kk == '' ? 'required' : '' }}>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Foto Scan Akta Lahir</label>
                                    <img id="preview3" class="img-thumbnail mt-2 mb-3"
                                        src="{{ $siswa->foto_scan_akta ? asset('gambar_berkas/berkas_siswa/' . $siswa->foto_scan_akta) : '' }}"
                                        style="max-width: 300px; {{ $siswa->foto_scan_akta ? '' : 'display:none;' }}">
                                    <input type="file" name="foto_scan_akta" id="foto_scan_akta"
                                        class="form-control text-uppercase"
                                        accept="image/png, image/jpeg, image/jpg"
                                        data-parsley-filemaxsize="2"
                                        data-parsley-fileextension="jpg,jpeg,png"
                                        {{ $siswa->foto_scan_akta == '' ? 'required' : '' }}>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Foto Scan SKCK</label>
                                    <img id="preview4" class="img-thumbnail mt-2 mb-3"
                                        src="{{ $siswa->foto_scan_skck ? asset('gambar_berkas/berkas_siswa/' . $siswa->foto_scan_skck) : '' }}"
                                        style="max-width: 300px; {{ $siswa->foto_scan_skck ? '' : 'display:none;' }}">
                                    <input type="file" name="foto_scan_skck" id="foto_scan_skck"
                                        class="form-control text-uppercase"
                                        accept="image/png, image/jpeg, image/jpg"
                                        data-parsley-filemaxsize="2"
                                        data-parsley-fileextension="jpg,jpeg,png"
                                        {{ $siswa->foto_scan_skck == '' ? 'required' : '' }}>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Foto Scan Surat Ket Sehat</label>
                                    <img id="preview5" class="img-thumbnail mt-2 mb-3"
                                        src="{{ $siswa->foto_scan_ket_sehat ? asset('gambar_berkas/berkas_siswa/' . $siswa->foto_scan_ket_sehat) : '' }}"
                                        style="max-width: 300px; {{ $siswa->foto_scan_ket_sehat ? '' : 'display:none;' }}">
                                    <input type="file" name="foto_scan_ket_sehat" id="foto_scan_ket_sehat"
                                        class="form-control text-uppercase"
                                        accept="image/png, image/jpeg, image/jpg"
                                        data-parsley-filemaxsize="2"
                                        data-parsley-fileextension="jpg,jpeg,png"
                                        {{ $siswa->foto_scan_ket_sehat == '' ? 'required' : '' }}>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Foto Scan Ijazah</label>
                                    <img id="preview6" class="img-thumbnail mt-2 mb-3"
                                        src="{{ $siswa->foto_ijazah ? asset('gambar_berkas/berkas_siswa/' . $siswa->foto_ijazah) : '' }}"
                                        style="max-width: 300px; {{ $siswa->foto_ijazah ? '' : 'display:none;' }}">
                                    <input type="file" name="foto_ijazah" id="foto_ijazah"
                                        class="form-control text-uppercase"
                                        accept="image/png, image/jpeg, image/jpg"
                                        data-parsley-filemaxsize="2"
                                        data-parsley-fileextension="jpg,jpeg,png"
                                        {{ $siswa->foto_ijazah == '' ? 'required' : '' }}>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <div class="alert alert-info p-2">
                                        <dl>
                                            <dt><strong>Informasi & Ketentuan :</strong></dt>
                                            <dd>
                                                <ul class="mb-0 mt-2">
                                                    <li>Foto siswa harus menggunakan foto berwarna dan tampak jelas.</li>
                                                    <li>Scan Kartu Keluarga (KK) harus terbaca dengan jelas, tidak buram,
                                                        dan
                                                        seluruh bagian dokumen terlihat.</li>
                                                    <li>Scan Akta Kelahiran harus terbaca dengan jelas, tidak terpotong, dan
                                                        seluruh
                                                        informasi dapat dibaca.</li>
                                                    <li>Scan SKCK, Surat Keterangan Sehat, dan Ijazah harus dalam kondisi
                                                        jelas dan
                                                        mudah dibaca.</li>
                                                    <li>Format file yang diperbolehkan: JPG, JPEG, atau PNG.</li>
                                                    <li>Ukuran setiap file yang diunggah maksimal <strong>2 MB</strong>.
                                                    </li>
                                                </ul>
                                            </dd>
                                        </dl>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <a href="{{ route('siswa') }}" class="btn btn-danger"><i class="fas fa-reply"></i> Kembali</a>
                            <button class="btn btn-primary float-end"><i class="fas fa-save"></i> Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $('#foto_warna_santri').on('change', function() {
            const file = this.files[0];

            if (file) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    $('#preview')
                        .attr('src', e.target.result)
                        .show();
                }

                reader.readAsDataURL(file);
            }
        });

        $('#foto_scan_kk').on('change', function() {
            const file = this.files[0];

            if (file) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    $('#preview2')
                        .attr('src', e.target.result)
                        .show();
                }

                reader.readAsDataURL(file);
            }
        });

        $('#foto_scan_akta').on('change', function() {
            const file = this.files[0];

            if (file) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    $('#preview3')
                        .attr('src', e.target.result)
                        .show();
                }

                reader.readAsDataURL(file);
            }
        });

        $('#foto_scan_skck').on('change', function() {
            const file = this.files[0];

            if (file) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    $('#preview4')
                        .attr('src', e.target.result)
                        .show();
                }

                reader.readAsDataURL(file);
            }
        });

        $('#foto_scan_ket_sehat').on('change', function() {
            const file = this.files[0];

            if (file) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    $('#preview5')
                        .attr('src', e.target.result)
                        .show();
                }

                reader.readAsDataURL(file);
            }
        });

        $('#foto_ijazah').on('change', function() {
            const file = this.files[0];

            if (file) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    $('#preview6')
                        .attr('src', e.target.result)
                        .show();
                }

                reader.readAsDataURL(file);
            }
        });

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
            $('#formUpload').on('submit', function(e) {
                e.preventDefault();
                let formData = new FormData(this);
                $(this).parsley().validate();
                if ($(this).parsley().isValid()) {
                    $('#loader').css('display', 'flex');
                    $.ajax({
                        url: "{{ route('siswa.update.upload', $siswa) }}",
                        type: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            if (response.status == 'success') {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: response.message,
                                }).then(() => {
                                    let url = "/admin/siswa";
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
        })
    </script>
@endpush
