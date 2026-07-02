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

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Outfit:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    <style>
        * {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        body {
            background-color: #f1f5f9;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 16px;
            position: relative;
            overflow: hidden;
            /* Prevents scroll globally */
        }

        /* Ambient Glow Blobs */
        .glow-blob {
            position: fixed;
            border-radius: 50%;
            filter: blur(120px);
            opacity: 0.08;
            pointer-events: none;
            z-index: 0;
        }

        .glow-1 {
            top: -10%;
            right: -5%;
            width: 450px;
            height: 450px;
            background: #6366f1;
        }

        .glow-2 {
            bottom: -10%;
            left: -5%;
            width: 450px;
            height: 450px;
            background: #a855f7;
        }

        /* OVERLAY LOADER */
        #loader {
            position: fixed;
            inset: 0;
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(6px);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .spinner {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            border: 6px solid;
            border-color: #6366f1 rgba(99, 102, 241, 0.1) rgba(99, 102, 241, 0.1) rgba(99, 102, 241, 0.1);
            animation: spinner-rotate 0.8s linear infinite;
        }

        @keyframes spinner-rotate {
            to {
                transform: rotate(1turn);
            }
        }

        /* LOGIN CARD */
        .login-wrapper {
            width: 100%;
            max-width: 1050px;
            height: 80vh;
            min-height: 520px;
            max-height: 620px;
            background: rgba(255, 255, 255, 0.75);
            border: 1px solid rgba(226, 232, 240, 0.8);
            border-radius: 28px;
            overflow: hidden;
            box-shadow: 0 20px 40px -15px rgba(15, 23, 42, 0.08);
            backdrop-filter: blur(20px);
            z-index: 10;
        }

        /* LEFT SIDE (Branding) */
        .left-side {
            position: relative;
            height: 100%;
            background: linear-gradient(135deg, #e0e7ff 0%, #e0f2fe 100%);
            color: #0f172a;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            overflow: hidden;
            border-right: 1px solid rgba(226, 232, 240, 0.8);
        }

        /* Glowing blob inside left-side */
        .left-side::after {
            content: '';
            position: absolute;
            bottom: -50px;
            right: -50px;
            width: 200px;
            height: 200px;
            background: #cbd5e1;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.3;
            pointer-events: none;
        }

        .dot-pattern {
            position: absolute;
            top: 36px;
            right: 36px;
            opacity: .08;
        }

        .dot-pattern span {
            width: 4px;
            height: 4px;
            background: #0f172a;
            border-radius: 50%;
            display: block;
        }

        .logo-container {
            width: 64px;
            height: 64px;
            background: rgba(255, 255, 255, 0.7);
            border: 1px solid rgba(226, 232, 240, 0.8);
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            box-shadow: 0 4px 12px rgba(15, 23, 42, 0.05);
        }

        .logo-sekolah {
            width: 38px;
            height: 38px;
            object-fit: contain;
        }

        .title {
            font-family: 'Outfit', sans-serif;
            font-size: 40px;
            font-weight: 800;
            letter-spacing: -0.03em;
            background: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 6px;
        }

        .subtitle {
            color: #4f46e5;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.06em;
            text-transform: uppercase;
        }

        .line {
            width: 45px;
            height: 4px;
            border-radius: 2px;
            background: linear-gradient(90deg, #3b82f6, #8b5cf6);
            margin: 20px 0;
        }

        .description {
            font-size: 12.5px;
            line-height: 1.6;
            color: #475569;
            max-width: 300px;
        }

        .security-badge {
            background: rgba(255, 255, 255, 0.6);
            border: 1px solid rgba(226, 232, 240, 0.8);
            border-radius: 14px;
            padding: 12px 14px;
            backdrop-filter: blur(10px);
            z-index: 2;
            box-shadow: 0 4px 12px rgba(15, 23, 42, 0.03);
        }

        .shield-icon {
            width: 36px;
            height: 36px;
            background: rgba(99, 102, 241, 0.1);
            color: #4f46e5;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            border: 1px solid rgba(99, 102, 241, 0.2);
            flex-shrink: 0;
        }

        .badge-title {
            font-weight: 600;
            font-size: 12px;
            color: #0f172a;
        }

        .badge-desc {
            font-size: 10.5px;
            color: #64748b;
        }

        /* RIGHT SIDE (Login Form) */
        .right-side {
            background: #ffffff;
            padding: 40px;
            display: flex;
            align-items: center;
            height: 100%;
        }

        .form-area {
            width: 100%;
        }

        .period-badge {
            display: inline-flex;
            align-items: center;
            padding: 5px 12px;
            background: rgba(99, 102, 241, 0.06);
            border: 1px solid rgba(99, 102, 241, 0.15);
            border-radius: 20px;
            color: #4f46e5;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.02em;
        }

        .welcome {
            font-family: 'Outfit', sans-serif;
            font-size: 24px;
            font-weight: 700;
            color: #0f172a;
            margin-top: 10px;
            margin-bottom: 4px;
        }

        .welcome-sub {
            font-size: 13px;
            color: #64748b;
        }

        .form-label {
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #475569;
            margin-bottom: 6px;
        }

        .input-group {
            height: 44px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .input-group:focus-within {
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.15);
            background: #ffffff;
        }

        .input-group-text {
            background: transparent !important;
            border: none;
            color: #94a3b8;
            font-size: 15px;
            padding-left: 14px;
        }

        .form-control {
            background: transparent !important;
            color: #0f172a !important;
            border: none !important;
            box-shadow: none !important;
            font-size: 13px;
            padding-right: 14px;
        }

        .form-control::placeholder {
            color: #94a3b8;
        }

        #togglePassword {
            color: #94a3b8;
            transition: color 0.2s ease;
        }

        #togglePassword:hover {
            color: #4f46e5;
        }

        .forgot {
            font-size: 12px;
            color: #4f46e5;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s ease;
        }

        .forgot:hover {
            color: #312e81;
        }

        .btn-login {
            height: 44px;
            border-radius: 12px;
            font-size: 13.5px;
            font-weight: 600;
            border: none;
            background: linear-gradient(135deg, #6366f1, #4f46e5);
            color: white;
            box-shadow: 0 4px 14px rgba(99, 102, 241, 0.2);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .btn-login:hover {
            background: linear-gradient(135deg, #4f46e5, #4338ca);
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(99, 102, 241, 0.3);
        }

        .btn-login:active {
            transform: translateY(1px);
        }

        .btn-register {
            height: 44px;
            border-radius: 12px;
            font-size: 13.5px;
            font-weight: 600;
            border: 1px solid rgba(99, 102, 241, 0.4) !important;
            color: #4f46e5 !important;
            background: transparent !important;
            box-shadow: none !important;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
        }

        .btn-register:hover {
            background: rgba(99, 102, 241, 0.05) !important;
            border-color: #4f46e5 !important;
            color: #4f46e5 !important;
            transform: translateY(-1px);
        }

        .btn-register:active {
            transform: translateY(1px);
        }

        .copyright {
            text-align: center;
            margin-top: 24px;
            color: #94a3b8;
            font-size: 11px;
            letter-spacing: 0.02em;
        }

        .parsley-errors-list {
            list-style: none;
            padding-left: 0;
            margin-top: 4px;
            color: #ef4444;
            font-size: 11.5px;
            font-weight: 500;
        }

        .parsley-errors-list li {
            display: flex;
            align-items: center;
            gap: 4px;
        }

        /* RESPONSIVE DESIGN */
        @media(max-width:991px) {
            body {
                background-color: #f1f5f9;
            }

            .login-wrapper {
                width: 100%;
                max-width: 440px;
                height: auto;
                max-height: 90vh;
                min-height: auto;
                background: rgba(255, 255, 255, 0.9);
                border: 1px solid rgba(226, 232, 240, 0.8);
                border-radius: 24px;
                margin: 0 auto;
                box-shadow: 0 20px 40px rgba(15, 23, 42, 0.08);
            }

            .left-side {
                display: none !important;
            }

            .right-side {
                background: transparent;
                padding: 32px 24px;
            }
        }

        /* Dynamic viewport check: Allow scrolling only on very small heights (e.g. keyboard active) */
        @media(max-height: 580px) {
            body {
                overflow-y: auto;
                align-items: flex-start;
                padding: 20px 16px;
            }

            .login-wrapper {
                height: auto !important;
                max-height: none !important;
            }
        }
    </style>
</head>

<body>

    <!-- Ambient background glow elements -->
    <div class="glow-blob glow-1"></div>
    <div class="glow-blob glow-2"></div>

    <div id="loader">
        <div class="spinner"></div>
    </div>

    <div class="container-fluid d-flex justify-content-center align-items-center min-vh-100">

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

                    <div class="logo-container">
                        <img src="{{ asset('asset_login/sianta.png') }}" class="logo-sekolah">
                    </div>

                    <div>
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
                    </div>

                    <div class="security-badge mt-auto">
                        <div class="d-flex align-items-center gap-3">
                            <div class="shield-icon">
                                <i class="bi bi-shield-lock-fill"></i>
                            </div>
                            <div>
                                <div class="badge-title">Protected & Secured</div>
                                <div class="badge-desc">Data Anda dilindungi dengan enkripsi tingkat tinggi.</div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- RIGHT -->
                <div class="col-lg-6 right-side">

                    <div class="form-area">

                        <div class="text-center text-lg-start mb-3">
                            <div class="d-flex justify-content-center justify-content-lg-start mb-1">
                                <span class="period-badge">
                                    <i class="bi bi-calendar3 me-2"></i>
                                    @if ($tahunAjaran)
                                        {{ $tahunAjaran->tahun }} • Sem. {{ $tahunAjaran->semester }}
                                    @else
                                        Tahun Ajaran
                                    @endif
                                </span>
                            </div>

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

                            <a href="{{ route('register') }}" class="btn btn-register w-100 mt-2">

                                <i class="bi bi-person-plus me-2"></i>

                                Daftar Akun Guru

                            </a>

                        </form>

                        <div class="copyright">

                            <i class="bi bi-shield-check me-1"></i>

                            SIANTA © {{ date('Y') }} • All rights reserved

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
