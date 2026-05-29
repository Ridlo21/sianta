<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>

    <link rel="stylesheet" href="{{ asset('asset_admin') }}/parsleyjs/parsley.css" />

    <style>
        /* OVERLAY LOADER */
        #loader {
            position: fixed;
            inset: 0;
            background: rgba(255, 255, 255, 0.4);
            /* transparan */
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
    </style>
</head>

<body>
    <div id="loader">
        <div class="spinner"></div>
    </div>
    <h1>Login</h1>

    <form id="formLogin" data-parsley-validate>
        @csrf
        <input type="email" name="email" id="email" placeholder="Email" data-parsley-required="true"
            data-parsley-type="email">
        <input type="password" name="password" id="password" placeholder="Password" data-parsley-required="true">
        <button type="submit">Login</button>
    </form>

    <script src="{{ asset('asset_admin') }}/jquery/jquery.min.js"></script>
    <script src="{{ asset('asset_admin') }}/parsleyjs/parsley.min.js"></script>
    <script src="{{ asset('asset_admin') }}/parsleyjs/i18n/id.js"></script>
    <script src="{{ asset('asset_admin') }}/sweetalert2/sweetalert2.all.min.js"></script>

    <script>
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
                        error: function() {
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
</body>

</html>
