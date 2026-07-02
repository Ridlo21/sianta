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
                <form id="formUpload" data-parsley-validate>
                    @csrf
                    @method('PUT')
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Upload Berkas <span class="text-danger">{{ $guru->nama }}</span></h5>
                        </div>
                        <div class="card-body">
                            @php
                                $pdfSvg = 'data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" width="100" height="120"><path fill="%23dc3545" d="M369.9 97.9L286 14C277 5 264.8-.1 252.1-.1H48C21.5-.1 0 21.4 0 48v416c0 26.5 21.5 48 48 48h288c26.5 0 48-21.5 48-48V131.9c0-12.7-5.1-25-14.1-34zM256 48l80 80h-80V48zM56 464c-4.4 0-8-3.6-8-8V56c0-4.4 3.6-8 8-8h152v96c0 13.3 10.7 24 24 24h96v288c0 4.4-3.6 8-8 8H56z"/></svg>';

                                $isKkPdf = $guru->scan_kk && strtolower(pathinfo($guru->scan_kk, PATHINFO_EXTENSION)) === 'pdf';
                                $kkSrc = $isKkPdf ? $pdfSvg : ($guru->scan_kk ? asset('gambar_berkas/berkas_guru/' . $guru->scan_kk) : '');

                                $isAktaPdf = $guru->scan_akta && strtolower(pathinfo($guru->scan_akta, PATHINFO_EXTENSION)) === 'pdf';
                                $aktaSrc = $isAktaPdf ? $pdfSvg : ($guru->scan_akta ? asset('gambar_berkas/berkas_guru/' . $guru->scan_akta) : '');

                                $isKtpPdf = $guru->scan_ktp && strtolower(pathinfo($guru->scan_ktp, PATHINFO_EXTENSION)) === 'pdf';
                                $ktpSrc = $isKtpPdf ? $pdfSvg : ($guru->scan_ktp ? asset('gambar_berkas/berkas_guru/' . $guru->scan_ktp) : '');

                                $isSkPdf = $guru->scan_sk && strtolower(pathinfo($guru->scan_sk, PATHINFO_EXTENSION)) === 'pdf';
                                $skSrc = $isSkPdf ? $pdfSvg : ($guru->scan_sk ? asset('gambar_berkas/berkas_guru/' . $guru->scan_sk) : '');

                                $isTranskripPdf = $guru->scan_transkrip_nilai && strtolower(pathinfo($guru->scan_transkrip_nilai, PATHINFO_EXTENSION)) === 'pdf';
                                $transkripSrc = $isTranskripPdf ? $pdfSvg : ($guru->scan_transkrip_nilai ? asset('gambar_berkas/berkas_guru/' . $guru->scan_transkrip_nilai) : '');
                            @endphp
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label">Foto Guru</label>
                                    <img id="preview_foto" class="img-thumbnail mt-2 mb-3"
                                        src="{{ $guru->foto ? asset('gambar_berkas/berkas_guru/' . $guru->foto) : '' }}"
                                        style="max-width: 300px; {{ $guru->foto ? '' : 'display:none;' }}">
                                    <input type="file" name="foto" id="foto" class="form-control text-uppercase"
                                        accept="image/png, image/jpeg, image/jpg" data-parsley-filemaxsize="2"
                                        data-parsley-fileextension="jpg,jpeg,png" {{ $guru->foto == '' ? 'required' : '' }}>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Scan Kartu Keluarga (KK)</label>
                                    <img id="preview_scan_kk" class="img-thumbnail mt-2 mb-3"
                                        src="{{ $kkSrc }}"
                                        style="max-width: 300px; {{ $guru->scan_kk ? '' : 'display:none;' }}">
                                    <input type="file" name="scan_kk" id="scan_kk" class="form-control text-uppercase"
                                        accept="image/png, image/jpeg, image/jpg, application/pdf" data-parsley-filemaxsize="2"
                                        data-parsley-fileextension="jpg,jpeg,png,pdf"
                                        {{ $guru->scan_kk == '' ? 'required' : '' }}>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Scan Akta Lahir</label>
                                    <img id="preview_scan_akta" class="img-thumbnail mt-2 mb-3"
                                        src="{{ $aktaSrc }}"
                                        style="max-width: 300px; {{ $guru->scan_akta ? '' : 'display:none;' }}">
                                    <input type="file" name="scan_akta" id="scan_akta"
                                        class="form-control text-uppercase" accept="image/png, image/jpeg, image/jpg, application/pdf"
                                        data-parsley-filemaxsize="2" data-parsley-fileextension="jpg,jpeg,png,pdf"
                                        {{ $guru->scan_akta == '' ? 'required' : '' }}>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Scan KTP</label>
                                    <img id="preview_scan_ktp" class="img-thumbnail mt-2 mb-3"
                                        src="{{ $ktpSrc }}"
                                        style="max-width: 300px; {{ $guru->scan_ktp ? '' : 'display:none;' }}">
                                    <input type="file" name="scan_ktp" id="scan_ktp" class="form-control text-uppercase"
                                        accept="image/png, image/jpeg, image/jpg, application/pdf" data-parsley-filemaxsize="2"
                                        data-parsley-fileextension="jpg,jpeg,png,pdf"
                                        {{ $guru->scan_ktp == '' ? 'required' : '' }}>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Scan SK</label>
                                    <img id="preview_scan_sk" class="img-thumbnail mt-2 mb-3"
                                        src="{{ $skSrc }}"
                                        style="max-width: 300px; {{ $guru->scan_sk ? '' : 'display:none;' }}">
                                    <input type="file" name="scan_sk" id="scan_sk" class="form-control text-uppercase"
                                        accept="image/png, image/jpeg, image/jpg, application/pdf" data-parsley-filemaxsize="2"
                                        data-parsley-fileextension="jpg,jpeg,png,pdf"
                                        {{ $guru->scan_sk == '' ? 'required' : '' }}>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Scan Transkrip Nilai</label>
                                    <img id="preview_scan_transkrip_nilai" class="img-thumbnail mt-2 mb-3"
                                        src="{{ $transkripSrc }}"
                                        style="max-width: 300px; {{ $guru->scan_transkrip_nilai ? '' : 'display:none;' }}">
                                    <input type="file" name="scan_transkrip_nilai" id="scan_transkrip_nilai"
                                        class="form-control text-uppercase" accept="image/png, image/jpeg, image/jpg, application/pdf"
                                        data-parsley-filemaxsize="2" data-parsley-fileextension="jpg,jpeg,png,pdf"
                                        {{ $guru->scan_transkrip_nilai == '' ? 'required' : '' }}>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <div class="alert alert-info p-2">
                                        <dl>
                                            <dt><strong>Informasi & Ketentuan :</strong></dt>
                                            <dd>
                                                <ul class="mb-0 mt-2">
                                                    <li>Foto Guru harus menggunakan foto berwarna dan tampak jelas.</li>
                                                    <li>Scan Kartu Keluarga (KK) harus terbaca dengan jelas, tidak buram,
                                                        dan seluruh bagian dokumen terlihat.</li>
                                                    <li>Scan Akta Kelahiran harus terbaca dengan jelas, tidak terpotong, dan
                                                        seluruh informasi dapat dibaca.</li>
                                                    <li>Scan KTP, Scan SK, dan Scan Transkrip Nilai harus dalam kondisi
                                                        jelas dan mudah dibaca.</li>
                                                    <li>Format file yang diperbolehkan: JPG, JPEG, PNG, atau PDF.</li>
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
                            <a href="{{ route('guru.lengkapi_data.show') }}" class="btn btn-danger"><i class="fas fa-reply"></i> Kembali</a>
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
        function readURL(input, previewId) {
            if (input.files && input.files[0]) {
                var file = input.files[0];
                var ext = file.name.split('.').pop().toLowerCase();
                if (ext === 'pdf') {
                    var pdfSvg = 'data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" width="100" height="120"><path fill="%23dc3545" d="M369.9 97.9L286 14C277 5 264.8-.1 252.1-.1H48C21.5-.1 0 21.4 0 48v416c0 26.5 21.5 48 48 48h288c26.5 0 48-21.5 48-48V131.9c0-12.7-5.1-25-14.1-34zM256 48l80 80h-80V48zM56 464c-4.4 0-8-3.6-8-8V56c0-4.4 3.6-8 8-8h152v96c0 13.3 10.7 24 24 24h96v288c0 4.4-3.6 8-8 8H56z"/></svg>';
                    $(previewId).attr('src', pdfSvg).show();
                } else {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $(previewId)
                            .attr('src', e.target.result)
                            .show();
                    }
                    reader.readAsDataURL(file);
                }
            }
        }

        $('#foto').on('change', function() {
            readURL(this, '#preview_foto');
        });

        $('#scan_kk').on('change', function() {
            readURL(this, '#preview_scan_kk');
        });

        $('#scan_akta').on('change', function() {
            readURL(this, '#preview_scan_akta');
        });

        $('#scan_ktp').on('change', function() {
            readURL(this, '#preview_scan_ktp');
        });

        $('#scan_sk').on('change', function() {
            readURL(this, '#preview_scan_sk');
        });

        $('#scan_transkrip_nilai').on('change', function() {
            readURL(this, '#preview_scan_transkrip_nilai');
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
                        url: "{{ route('guru.lengkapi_data.update.upload') }}",
                        type: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
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
        })
    </script>
@endpush
