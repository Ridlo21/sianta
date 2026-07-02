@extends('template_guru')

@section('content')
    <div class="container-fluid p-0">
        <h3 class="mb-3 text-theme-value"><strong>Pengaturan Profil</strong></h3>

        <div class="row">
            <!-- Left Column: Avatar & Profile Summary -->
            <div class="col-md-4 col-xl-3">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Foto Profil</h5>
                    </div>
                    <div class="card-body text-center">
                        <form id="formPhoto" enctype="multipart/form-data">
                            @csrf
                            <div class="avatar-upload">
                                <div class="avatar-edit">
                                    <input type='file' id="imageUpload" name="photo" accept=".png, .jpg, .jpeg" />
                                    <label for="imageUpload" title="Pilih Foto Baru">
                                        <i class="align-middle" data-feather="edit-2" style="width: 14px; height: 14px;"></i>
                                    </label>
                                </div>
                                <div class="avatar-preview">
                                    <div id="imagePreview" 
                                         style="background-image: url('{{ $user->photo ? asset('gambar_berkas/avatars/' . $user->photo) : asset('asset_admin/img/avatars/avatar.png') }}');">
                                    </div>
                                </div>
                            </div>
                        </form>
                        
                        <h5 class="card-title mb-0 mt-2 text-theme-value">{{ $user->name }}</h5>
                        <div class="text-muted mb-2">{{ $user->email }}</div>

                        <div>
                            <span class="badge bg-primary-light text-primary">
                                {{ ucfirst($user->role ?? 'Guru') }}
                            </span>
                        </div>
                        
                        <hr class="my-3" />
                        <small class="text-muted d-block mb-2">Klik tombol edit pada foto untuk memilih foto baru, kemudian klik "Simpan Perubahan".</small>
                    </div>
                </div>
            </div>

            <!-- Right Column: Profile Form & Password Form -->
            <div class="col-md-8 col-xl-9">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Informasi Profil</h5>
                    </div>
                    <div class="card-body">
                        <form id="formProfile">
                            @csrf
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label class="form-label" for="name">Nama Lengkap</label>
                                    <input type="text" class="form-control" id="name" name="name" 
                                           value="{{ $user->name }}" readonly style="background-color: var(--bg-table-row) !important; cursor: not-allowed;">
                                    <small class="text-muted">Nama tidak dapat diubah.</small>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label" for="email">Alamat Email</label>
                                    <input type="email" class="form-control" id="email" name="email" 
                                           value="{{ $user->email }}" readonly style="background-color: var(--bg-table-row) !important; cursor: not-allowed;">
                                    <small class="text-muted">Email tidak dapat diubah.</small>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <i class="align-middle me-1" data-feather="save"></i> Simpan Foto Profil
                            </button>
                        </form>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Ubah Password</h5>
                    </div>
                    <div class="card-body">
                        <form id="formPassword" data-parsley-validate>
                            @csrf
                            <div class="mb-3">
                                <label class="form-label" for="current_password">Password Saat Ini</label>
                                <input type="password" class="form-control" id="current_password" name="current_password" 
                                       required placeholder="Masukkan password saat ini">
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="password">Password Baru</label>
                                <input type="password" class="form-control" id="password" name="password" 
                                       required data-parsley-minlength="8" placeholder="Masukkan password baru (min. 8 karakter)">
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="password_confirmation">Konfirmasi Password Baru</label>
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" 
                                       required data-parsley-equalto="#password" placeholder="Ulangi password baru">
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <i class="align-middle me-1" data-feather="key"></i> Perbarui Password
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Custom CSS styling for beautiful Avatar Upload -->
    <style>
        .avatar-upload {
            position: relative;
            max-width: 150px;
            margin: 20px auto;
        }
        .avatar-edit {
            position: absolute;
            right: 10px;
            z-index: 10;
            bottom: 5px;
        }
        .avatar-edit input {
            display: none;
        }
        .avatar-edit label {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            margin-bottom: 0;
            border-radius: 50%;
            background: #FFFFFF;
            border: 1px solid #dee2e6;
            box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            transition: all 0.2s ease-in-out;
        }
        .avatar-edit label:hover {
            background: #f8f9fa;
            border-color: #adb5bd;
            transform: scale(1.05);
        }
        .avatar-preview {
            width: 150px;
            height: 150px;
            position: relative;
            border-radius: 50%;
            border: 4px solid #f8f9fa;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            background-color: #e9ecef;
        }
        .avatar-preview > div {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            transition: transform 0.3s ease;
        }
        .avatar-preview:hover > div {
            transform: scale(1.05);
        }
    </style>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Instant Image Preview on Select
            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#imagePreview').css('background-image', 'url(' + e.target.result + ')');
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }

            $("#imageUpload").change(function() {
                readURL(this);
            });

            // Submit Profile Photo information via AJAX
            $('#formProfile').on('submit', function(e) {
                e.preventDefault();

                let fileInput = $('#imageUpload')[0];
                if (fileInput.files.length === 0) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Perhatian',
                        text: 'Silakan pilih foto profil baru terlebih dahulu.'
                    });
                    return;
                }

                Swal.fire({
                    title: 'Perbarui Foto Profil?',
                    text: 'Apakah Anda yakin ingin memperbarui foto profil Anda?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    cancelButtonText: 'Batal',
                    confirmButtonText: 'Ya, Simpan!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#loader').css('display', 'flex');

                        let formData = new FormData();
                        formData.append('photo', fileInput.files[0]);
                        formData.append('_token', '{{ csrf_token() }}');

                        $.ajax({
                            type: "POST",
                            url: "{{ route('guru.profile.update') }}",
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function(response) {
                                $('#loader').css('display', 'none');
                                if (response.status === 'success') {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Berhasil',
                                        text: response.message,
                                    }).then(() => {
                                        location.reload();
                                    });
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Gagal',
                                        text: response.message,
                                    });
                                }
                            },
                            error: function(xhr) {
                                $('#loader').css('display', 'none');
                                if (xhr.status === 422) {
                                    let errors = xhr.responseJSON.errors;
                                    let message = xhr.responseJSON.message || 'Validasi gagal.';
                                    if (errors && errors.photo) {
                                        message = errors.photo[0];
                                    }
                                    Swal.fire({
                                        icon: 'warning',
                                        title: 'Validasi Gagal',
                                        text: message
                                    });
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: 'Terjadi kesalahan saat menyimpan data.'
                                    });
                                }
                            }
                        });
                    }
                });
            });

            // Submit Password Change via AJAX
            $('#formPassword').on('submit', function(e) {
                e.preventDefault();
                $(this).parsley().validate();

                if ($(this).parsley().isValid()) {
                    Swal.fire({
                        title: 'Perbarui Password?',
                        text: 'Apakah Anda yakin ingin memperbarui password?',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        cancelButtonText: 'Batal',
                        confirmButtonText: 'Ya, Ubah!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $('#loader').css('display', 'flex');

                            $.ajax({
                                type: "POST",
                                url: "{{ route('guru.profile.password') }}",
                                data: $(this).serialize(),
                                success: function(response) {
                                    $('#loader').css('display', 'none');
                                    if (response.status === 'success') {
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Berhasil',
                                            text: response.message,
                                        }).then(() => {
                                            $('#formPassword')[0].reset();
                                            $('#formPassword').parsley().reset();
                                        });
                                    } else {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Gagal',
                                            text: response.message,
                                        });
                                    }
                                },
                                error: function(xhr) {
                                    $('#loader').css('display', 'none');
                                    if (xhr.status === 422) {
                                        let message = xhr.responseJSON.message || 'Validasi gagal.';
                                        Swal.fire({
                                            icon: 'warning',
                                            title: 'Validasi Gagal',
                                            text: message
                                        });
                                    } else {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Error',
                                            text: 'Terjadi kesalahan saat memperbarui password.'
                                        });
                                    }
                                }
                            });
                        }
                    });
                }
            });
        });
    </script>
@endpush
