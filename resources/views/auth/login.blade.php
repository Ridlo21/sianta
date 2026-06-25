<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>
    <link rel="shortcut icon" href="{{ asset('asset_login') }}/sianta.png" />
    <link rel="stylesheet" href="{{ asset('asset_admin') }}/parsleyjs/parsley.css" />
    <link href="{{ asset('asset_login') }}/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('asset_login') }}/bootstrap-icons/font/bootstrap-icons.min.css" />

    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: #f3f6fb;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 18px;
            overflow: hidden;
        }

        /* OVERLAY LOADER */
        #loader {
            position: fixed;
            inset: 0;
            background: rgba(255, 255, 255, 0.5);
            justify-content: center;
            align-items: center;
            z-index: 9999;
            display: none;
        }

        .spinner {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            border: 9px solid;
            border-color: #474bff #0000;
            animation: spinner-0tkp9a 1s infinite;
        }

        @keyframes spinner-0tkp9a {
            to {
                transform: rotate(.5turn);
            }
        }

        /* LOGIN CARD */

        .login-wrapper {
            /* width: 100%;
            max-width: 1050px;
            height: 620px;
            background: #fff;
            border-radius: 22px;
            overflow: hidden;
            box-shadow: 0 10px 35px rgba(0, 0, 0, .08); */
            width: 100%;
            max-width: 1050px;
            height: 88vh;
            background: #fff;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 10px 35px rgba(0, 0, 0, 0.06);
        }

        /* LEFT */

        .left-side {
            /* background:
                linear-gradient(rgba(8, 24, 68, .88),
                    rgba(8, 24, 68, .88)),
                url('/asset_login/bglogin.png');

            background-size: cover;
            background-position: center;
            color: white;
            padding: 20px;
            position: relative; */
            position: relative;
            height: 100%;
            background:
                linear-gradient(rgba(10, 25, 70, .88),
                    rgba(10, 25, 70, .90)),
                url('/asset_login/bglogin.png');

            background-size: cover;
            background-position: center;
            color: white;
            padding: 36px;
        }

        .dot-pattern {
            position: absolute;
            top: 28px;
            right: 28px;
            opacity: .35;
        }

        .dot-pattern span {
            width: 5px;
            height: 5px;
            background: white;
            border-radius: 50%;
            display: block;
        }

        .logo-sekolah {
            width: 80px;
            margin-bottom: 8px;
        }

        .title {
            font-size: 40px;
            font-weight: 700;
            line-height: 1;
            margin-bottom: 4px;
        }

        .subtitle {
            color: #46a6ff;
            font-size: 13px;
            font-weight: 500;
        }

        .line {
            width: 45px;
            height: 3px;
            border-radius: 20px;
            background: #3b82f6;
            margin: 16px 0;
        }

        .description {
            font-size: 12px;
            line-height: 1.7;
            max-width: 260px;
            color: rgba(255, 255, 255, .92);
        }

        .security-box {
            position: absolute;
            bottom: 16px;
            left: 16px;
            right: 16px;
            background: rgba(255, 255, 255, .12);
            backdrop-filter: blur(10px);
            border-radius: 12px;
            padding: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .security-box .fw-bold {
            font-size: 14px !important;
        }

        .security-box .small {
            font-size: 10px !important;
        }

        .security-icon {
            width: 46px;
            height: 46px;
            background: #2563eb;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            flex-shrink: 0;
        }

        /* RIGHT */

        .right-side {
            padding: 18px 22px;
            display: flex;
            align-items: center;
        }

        .form-area {
            width: 100%;
        }

        .lock-icon {
            width: 54px;
            height: 54px;
            background: #eef4ff;
            color: #2563eb;
            border-radius: 50%;
            font-size: 26px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: auto;
            margin-bottom: 8px;
        }

        .welcome {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 2px;
        }

        .welcome-sub {
            font-size: 14px;
            color: #64748b;
        }

        .form-label {
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 3px;
        }

        .input-group {
            height: 40px;
            border: 1px solid #dbe2ea;
            border-radius: 10px;
            overflow: hidden;
        }

        .input-group-text {
            background: white;
            border: none;
            color: #94a3b8;
            font-size: 13px;
            padding-left: 14px;
        }

        .form-control {
            border: none !important;
            box-shadow: none !important;
            font-size: 13px;
        }

        .forgot {
            font-size: 12px;
            text-decoration: none;
        }

        .btn-login {
            height: 36px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 600;
            border: none;
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
        }

        .divider {
            display: flex;
            align-items: center;
            margin: 16px 0;
            font-size: 12px;
            color: #94a3b8;
        }

        .divider::before,
        .divider::after {
            content: "";
            flex: 1;
            height: 1px;
            background: #e2e8f0;
        }

        .divider span {
            padding: 0 12px;
        }

        .info-box {
            border: 1px solid #dbeafe;
            background: #f8fbff;
            border-radius: 12px;
            padding: 10px;
        }

        .info-box .fw-bold {
            font-size: 14px;
        }

        .info-box .small {
            font-size: 12px;
        }

        .stats-box {
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 10px 4px;
            text-align: center;
        }

        .stats-box i {
            font-size: 16px;
        }

        .stats-box h5 {
            font-size: 14px;
        }

        .stats-box small {
            font-size: 10px;
        }

        .copyright {
            text-align: center;
            margin-top: 10px;
            color: #94a3b8;
            font-size: 10px;
        }

        .parsley-errors-list {
            list-style: none;
            padding-left: 0;
            margin-top: 6px;
            color: red;
            font-size: 12px;
        }

        /* MOBILE */

        @media(max-width:991px) {

            body {
                overflow: auto;
            }

            .login-wrapper {
                width: 100%;
                max-width: 1020px;
                height: 90vh;
                background: #fff;
                border-radius: 22px;
                overflow: hidden;
                box-shadow: 0 8px 28px rgba(0, 0, 0, .07);
            }

            .left-side {
                display: none !important;
            }

            .right-side {
                width: 100%;
                padding: 30px 24px;
            }
        }
    </style>
</head>

<body>

    <div id="loader">
        <div class="spinner"></div>
    </div>

    <div class="container-fluid d-flex justify-content-center align-items-center vh-100">

        <div class="login-wrapper">

            <div class="row g-0 h-100">

                <!-- LEFT -->
                <div class="col-lg-6 left-side d-none d-lg-flex flex-column justify-content-center">

                    <!-- DOT -->
                    <div class="dot-pattern d-grid gap-2"
                        style="grid-template-columns: repeat(5,1fr); width: max-content;">
                        <span></span><span></span><span></span><span></span><span></span>
                        <span></span><span></span><span></span><span></span><span></span>
                        <span></span><span></span><span></span><span></span><span></span>
                    </div>

                    <img src="{{ asset('asset_login/sianta.png') }}" class="logo-sekolah">

                    <div class="title">
                        SIANTA
                    </div>

                    <div class="subtitle">
                        Single Management Data SMKNAA
                    </div>

                    <div class="line"></div>

                    <div class="description">
                        Sistem terintegrasi untuk pengelolaan data sekolah secara
                        single, akurat, modern, dan efisien.
                    </div>

                    {{-- <div class="security-box">

                        <div class="security-icon">
                            <i class="bi bi-shield-check"></i>
                        </div>

                        <div>

                            <div class="fw-bold fs-5">
                                Keamanan Terjamin
                            </div>

                            <div class="small text-light opacity-75">
                                Data Anda dilindungi dengan sistem enkripsi tingkat tinggi.
                            </div>

                        </div>

                    </div> --}}

                </div>

                <!-- RIGHT -->
                <div class="col-lg-6 right-side">

                    <div class="form-area">

                        <div class="lock-icon">
                            <i class="bi bi-lock"></i>
                        </div>

                        <div class="text-center mb-4">

                            <div class="welcome">
                                Selamat Datang Kembali!
                            </div>

                            <div class="welcome-sub">
                                Silakan masuk untuk melanjutkan ke aplikasi SIANTA
                            </div>

                        </div>

                        <!-- FORM -->
                        <form id="formLogin" data-parsley-validate>

                            @csrf

                            <!-- EMAIL -->
                            <div class="mb-3">

                                <label class="form-label">
                                    Email
                                </label>

                                <div class="input-group">

                                    <span class="input-group-text">
                                        <i class="bi bi-envelope"></i>
                                    </span>

                                    <input type="email" class="form-control" name="email" id="email"
                                        placeholder="Masukkan email" data-parsley-required="true"
                                        data-parsley-type="email" data-parsley-errors-container="#email-errors">

                                </div>
                                <div id="email-errors"></div>

                            </div>

                            <!-- PASSWORD -->
                            <div class="mb-2">

                                <label class="form-label">
                                    Password
                                </label>

                                <div class="input-group">

                                    <span class="input-group-text">
                                        <i class="bi bi-lock"></i>
                                    </span>

                                    <input type="password" class="form-control" name="password" id="password"
                                        placeholder="Masukkan password" data-parsley-required="true"
                                        data-parsley-errors-container="#password-errors">

                                    <span class="input-group-text" id="togglePassword" style="cursor:pointer">
                                        <i class="bi bi-eye-slash"></i>
                                    </span>

                                </div>
                                <div id="password-errors"></div>

                            </div>

                            <div class="text-end mb-3">

                                <a href="#" class="forgot">
                                    Lupa password?
                                </a>

                            </div>

                            <button type="submit" class="btn btn-primary btn-login w-100">

                                <i class="bi bi-box-arrow-in-right me-2"></i>

                                Masuk ke Sistem

                            </button>

                        </form>

                        <!-- DIVIDER -->
                        <div class="divider">
                            <span>Informasi Sistem</span>
                        </div>

                        <!-- INFO -->
                        <div class="info-box mb-3">

                            <div class="d-flex align-items-center gap-3">

                                <div class="fs-3 text-primary">
                                    <i class="bi bi-info-circle-fill"></i>
                                </div>

                                <div>

                                    <div class="fw-bold">
                                        @if ($tahunAjaran)
                                            Periode {{ $tahunAjaran->tahun }} Semester {{ $tahunAjaran->semester }}
                                        @else
                                            Tahun Ajaran
                                        @endif
                                    </div>

                                    <div class="small text-muted">
                                        Sistem aktif dan berjalan normal.
                                    </div>

                                </div>

                            </div>

                        </div>

                        <!-- STATS -->
                        <div class="row g-3">

                            <div class="col-4">

                                <div class="stats-box">

                                    <i class="bi bi-people text-primary"></i>

                                    <h5 class="fw-bold">
                                        1.200+
                                    </h5>

                                    <small class="text-muted">
                                        Siswa
                                    </small>

                                </div>

                            </div>

                            <div class="col-4">

                                <div class="stats-box">

                                    <i class="bi bi-mortarboard text-success"></i>

                                    <h5 class="fw-bold">
                                        80+
                                    </h5>

                                    <small class="text-muted">
                                        Guru
                                    </small>

                                </div>

                            </div>

                            <div class="col-4">

                                <div class="stats-box">

                                    <i class="bi bi-pc-display text-primary"></i>

                                    <h5 class="fw-bold">
                                        24/7
                                    </h5>

                                    <small class="text-muted">
                                        Monitoring
                                    </small>

                                </div>

                            </div>

                        </div>

                        <div class="copyright">

                            <i class="bi bi-shield-check me-1"></i>

                            SIANTA © 2026 • All rights reserved

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <script src="{{ asset('asset_login') }}/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('asset_admin') }}/jquery/jquery.min.js"></script>
    <script src="{{ asset('asset_admin') }}/parsleyjs/parsley.min.js"></script>
    <script src="{{ asset('asset_admin') }}/parsleyjs/i18n/id.js"></script>
    <script src="{{ asset('asset_admin') }}/sweetalert2/sweetalert2.all.min.js"></script>

    <script>
        document.addEventListener('contextmenu', e => e.preventDefault());

        document.addEventListener('keydown', function(e) {
            if (e.key === 'F12') {
                e.preventDefault();
            }

            if (e.ctrlKey && e.key.toLowerCase() === 'u') {
                e.preventDefault();
            }
        });
        // SHOW PASSWORD
        $('#togglePassword').click(function() {

            let password = $('#password');

            if (password.attr('type') == 'password') {

                password.attr('type', 'text');

                $(this).html('<i class="bi bi-eye"></i>');

            } else {

                password.attr('type', 'password');

                $(this).html('<i class="bi bi-eye-slash"></i>');
            }

        });

        $(document).ready(function() {
            $('#formLogin').on('submit', function(e) {
                e.preventDefault();
                $(this).parsley().validate();
                let url = "{{ route('loginUser') }}";
                if ($(this).parsley().isValid()) {
                    $('#loader').css('display', 'flex');
                    $.ajax({
                        type: "POST",
                        url: url,
                        data: $(this).serialize(),
                        success: function(response) {
                            if (response.status == 'success') {
                                $('#loader').css('display', 'none');
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: response.message,
                                }).then(() => {
                                    window.location.href = response.url;
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
                            let message = 'Terjadi kesalahan pada server.';
                            if (xhr.status === 429) {
                                message =
                                    'Terlalu banyak percobaan login. Silakan coba lagi dalam beberapa saat.';
                            } else if (xhr.responseJSON && xhr.responseJSON.message) {
                                message = xhr.responseJSON.message;
                            }
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: message,
                            });
                        }
                    });
                }
            });
        })
    </script>
</body>

</html>
