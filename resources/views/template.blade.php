<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Responsive Admin &amp; Dashboard Template based on Bootstrap 5">
    <meta name="author" content="AdminKit">
    <meta name="keywords"
        content="adminkit, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

    <link rel="preconnect" href="https://fonts.gstatic.com/">
    <link rel="shortcut icon" href="img/icons/icon-48x48.png" />

    <link rel="canonical" href="index-2.html" />

    <title>AdminKit Demo - Bootstrap 5 Admin Template</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&amp;display=swap" rel="stylesheet">

    <!-- Choose your prefered color scheme -->
    <link href="{{ asset('asset_admin') }}/css/light.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('asset_admin') }}/parsleyjs/parsley.css" />

    <style>
        body {
            opacity: 0;
        }

        /* OVERLAY LOADER */
        #loader {
            position: fixed;
            inset: 0;
            background: rgb(255, 255, 255);
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
    <!-- END SETTINGS -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-120946860-10"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'UA-120946860-10', {
            'anonymize_ip': true
        });
    </script>
</head>

<body data-theme="default" data-layout="fluid" data-sidebar-position="left" data-sidebar-layout="default">
    <div id="loader">
        <div class="spinner"></div>
    </div>
    <div class="wrapper">
        <nav id="sidebar" class="sidebar js-sidebar">
            <div class="sidebar-content js-simplebar">
                <a class='sidebar-brand' href='index-2.html'>
                    <span class="sidebar-brand-text align-middle">
                        AdminKit
                        <sup><small class="badge bg-primary text-uppercase">Pro</small></sup>
                    </span>
                    <svg class="sidebar-brand-icon align-middle" width="32px" height="32px" viewBox="0 0 24 24"
                        fill="none" stroke="#FFFFFF" stroke-width="1.5" stroke-linecap="square"
                        stroke-linejoin="miter" color="#FFFFFF" style="margin-left: -3px">
                        <path d="M12 4L20 8.00004L12 12L4 8.00004L12 4Z"></path>
                        <path d="M20 12L12 16L4 12"></path>
                        <path d="M20 16L12 20L4 16"></path>
                    </svg>
                </a>

                <div class="sidebar-user">
                    <div class="d-flex justify-content-center">
                        <div class="flex-shrink-0">
                            <img src="{{ asset('asset_admin') }}/img/avatars/avatar.jpg"
                                class="avatar img-fluid rounded me-1" alt="Charles Hall" />
                        </div>
                        <div class="flex-grow-1 ps-2">
                            <a class="sidebar-user-title dropdown-toggle" href="#" data-bs-toggle="dropdown">
                                Charles Hall
                            </a>
                            <div class="dropdown-menu dropdown-menu-start">
                                <a class='dropdown-item' href='pages-profile.html'><i class="align-middle me-1"
                                        data-feather="user"></i> Profile</a>
                                <a class="dropdown-item" href="#"><i class="align-middle me-1"
                                        data-feather="pie-chart"></i> Analytics</a>
                                <div class="dropdown-divider"></div>
                                <a class='dropdown-item' href='pages-settings.html'><i class="align-middle me-1"
                                        data-feather="settings"></i> Settings &
                                    Privacy</a>
                                <a class="dropdown-item" href="#"><i class="align-middle me-1"
                                        data-feather="help-circle"></i> Help Center</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" onclick="logout()">Log out</a>
                            </div>

                            <div class="sidebar-user-subtitle">Designer</div>
                        </div>
                    </div>
                </div>

                <ul class="sidebar-nav">
                    <li class="sidebar-header">
                        Pages
                    </li>
                    <li class="sidebar-item active">
                        <a data-bs-target="#dashboards" data-bs-toggle="collapse" class="sidebar-link">
                            <i class="align-middle" data-feather="sliders"></i> <span
                                class="align-middle">Dashboards</span>
                        </a>
                        <ul id="dashboards" class="sidebar-dropdown list-unstyled collapse show"
                            data-bs-parent="#sidebar">
                            <li class="sidebar-item active"><a class='sidebar-link' href='index-2.html'>Analytics</a>
                            </li>
                            <li class="sidebar-item"><a class='sidebar-link'
                                    href='dashboard-ecommerce.html'>E-Commerce
                                    <span class="sidebar-badge badge bg-primary">Pro</span></a></li>
                            <li class="sidebar-item"><a class='sidebar-link' href='dashboard-crypto.html'>Crypto
                                    <span class="sidebar-badge badge bg-primary">Pro</span></a></li>
                        </ul>
                    </li>

                    <li class="sidebar-item">
                        <a data-bs-target="#pages" data-bs-toggle="collapse" class="sidebar-link collapsed">
                            <i class="align-middle" data-feather="layout"></i> <span
                                class="align-middle">Pages</span>
                        </a>
                        <ul id="pages" class="sidebar-dropdown list-unstyled collapse "
                            data-bs-parent="#sidebar">
                            <li class="sidebar-item"><a class='sidebar-link' href='pages-settings.html'>Settings</a>
                            </li>
                            <li class="sidebar-item"><a class='sidebar-link' href='pages-projects.html'>Projects
                                    <span class="sidebar-badge badge bg-primary">Pro</span></a></li>
                            <li class="sidebar-item"><a class='sidebar-link' href='pages-clients.html'>Clients <span
                                        class="sidebar-badge badge bg-primary">Pro</span></a></li>
                            <li class="sidebar-item"><a class='sidebar-link' href='pages-orders.html'>Orders <span
                                        class="sidebar-badge badge bg-primary">Pro</span></a></li>
                            <li class="sidebar-item"><a class='sidebar-link' href='pages-pricing.html'>Pricing <span
                                        class="sidebar-badge badge bg-primary">Pro</span></a></li>
                            <li class="sidebar-item"><a class='sidebar-link' href='pages-chat.html'>Chat <span
                                        class="sidebar-badge badge bg-primary">Pro</span></a></li>
                            <li class="sidebar-item"><a class='sidebar-link' href='pages-blank.html'>Blank Page</a>
                            </li>
                        </ul>
                    </li>

                    <li class="sidebar-item">
                        <a class='sidebar-link' href='pages-profile.html'>
                            <i class="align-middle" data-feather="user"></i> <span
                                class="align-middle">Profile</span>
                        </a>
                    </li>

                    <li class="sidebar-item">
                        <a class='sidebar-link' href='pages-invoice.html'>
                            <i class="align-middle" data-feather="credit-card"></i> <span
                                class="align-middle">Invoice</span>
                        </a>
                    </li>

                    <li class="sidebar-item">
                        <a class='sidebar-link' href='pages-tasks.html'>
                            <i class="align-middle" data-feather="list"></i> <span class="align-middle">Tasks</span>
                            <span class="sidebar-badge badge bg-primary">Pro</span>
                        </a>
                    </li>

                    <li class="sidebar-item">
                        <a class='sidebar-link' href='calendar.html'>
                            <i class="align-middle" data-feather="calendar"></i> <span
                                class="align-middle">Calendar</span>
                            <span class="sidebar-badge badge bg-primary">Pro</span>
                        </a>
                    </li>

                    <li class="sidebar-item">
                        <a href="#auth" data-bs-toggle="collapse" class="sidebar-link collapsed">
                            <i class="align-middle" data-feather="users"></i> <span class="align-middle">Auth</span>
                        </a>
                        <ul id="auth" class="sidebar-dropdown list-unstyled collapse "
                            data-bs-parent="#sidebar">
                            <li class="sidebar-item"><a class='sidebar-link' href='pages-sign-in.html'>Sign In</a>
                            </li>
                            <li class="sidebar-item"><a class='sidebar-link' href='pages-sign-up.html'>Sign Up</a>
                            </li>
                            <li class="sidebar-item"><a class='sidebar-link' href='pages-reset-password.html'>Reset
                                    Password <span class="sidebar-badge badge bg-primary">Pro</span></a></li>
                            <li class="sidebar-item"><a class='sidebar-link' href='pages-404.html'>404 Page <span
                                        class="sidebar-badge badge bg-primary">Pro</span></a></li>
                            <li class="sidebar-item"><a class='sidebar-link' href='pages-500.html'>500 Page <span
                                        class="sidebar-badge badge bg-primary">Pro</span></a></li>
                        </ul>
                    </li>

                </ul>
            </div>
        </nav>

        <div class="main">
            <nav class="navbar navbar-expand navbar-light navbar-bg">
                <a class="sidebar-toggle js-sidebar-toggle">
                    <i class="hamburger align-self-center"></i>
                </a>
                <div class="navbar-collapse collapse">
                    <ul class="navbar-nav navbar-align">
                        <li class="nav-item dropdown">
                            <a class="nav-icon dropdown-toggle" href="#" id="alertsDropdown"
                                data-bs-toggle="dropdown">
                                <div class="position-relative">
                                    <i class="align-middle" data-feather="bell"></i>
                                    <span class="indicator">4</span>
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end py-0"
                                aria-labelledby="alertsDropdown">
                                <div class="dropdown-menu-header">
                                    4 New Notifications
                                </div>
                                <div class="list-group">
                                    <a href="#" class="list-group-item">
                                        <div class="row g-0 align-items-center">
                                            <div class="col-2">
                                                <i class="text-danger" data-feather="alert-circle"></i>
                                            </div>
                                            <div class="col-10">
                                                <div class="text-dark">Update completed</div>
                                                <div class="text-muted small mt-1">Restart server 12 to complete the
                                                    update.</div>
                                                <div class="text-muted small mt-1">30m ago</div>
                                            </div>
                                        </div>
                                    </a>
                                    <a href="#" class="list-group-item">
                                        <div class="row g-0 align-items-center">
                                            <div class="col-2">
                                                <i class="text-warning" data-feather="bell"></i>
                                            </div>
                                            <div class="col-10">
                                                <div class="text-dark">Lorem ipsum</div>
                                                <div class="text-muted small mt-1">Aliquam ex eros, imperdiet vulputate
                                                    hendrerit et.</div>
                                                <div class="text-muted small mt-1">2h ago</div>
                                            </div>
                                        </div>
                                    </a>
                                    <a href="#" class="list-group-item">
                                        <div class="row g-0 align-items-center">
                                            <div class="col-2">
                                                <i class="text-primary" data-feather="home"></i>
                                            </div>
                                            <div class="col-10">
                                                <div class="text-dark">Login from 192.186.1.8</div>
                                                <div class="text-muted small mt-1">5h ago</div>
                                            </div>
                                        </div>
                                    </a>
                                    <a href="#" class="list-group-item">
                                        <div class="row g-0 align-items-center">
                                            <div class="col-2">
                                                <i class="text-success" data-feather="user-plus"></i>
                                            </div>
                                            <div class="col-10">
                                                <div class="text-dark">New connection</div>
                                                <div class="text-muted small mt-1">Christina accepted your request.
                                                </div>
                                                <div class="text-muted small mt-1">14h ago</div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="dropdown-menu-footer">
                                    <a href="#" class="text-muted">Show all notifications</a>
                                </div>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-icon dropdown-toggle" href="#" id="messagesDropdown"
                                data-bs-toggle="dropdown">
                                <div class="position-relative">
                                    <i class="align-middle" data-feather="message-square"></i>
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end py-0"
                                aria-labelledby="messagesDropdown">
                                <div class="dropdown-menu-header">
                                    <div class="position-relative">
                                        4 New Messages
                                    </div>
                                </div>
                                <div class="list-group">
                                    <a href="#" class="list-group-item">
                                        <div class="row g-0 align-items-center">
                                            <div class="col-2">
                                                <img src="{{ asset('asset_admin') }}/img/avatars/avatar-5.jpg"
                                                    class="avatar img-fluid rounded-circle" alt="Vanessa Tucker">
                                            </div>
                                            <div class="col-10 ps-2">
                                                <div class="text-dark">Vanessa Tucker</div>
                                                <div class="text-muted small mt-1">Nam pretium turpis et arcu. Duis
                                                    arcu tortor.</div>
                                                <div class="text-muted small mt-1">15m ago</div>
                                            </div>
                                        </div>
                                    </a>
                                    <a href="#" class="list-group-item">
                                        <div class="row g-0 align-items-center">
                                            <div class="col-2">
                                                <img src="{{ asset('asset_admin') }}/img/avatars/avatar-2.jpg"
                                                    class="avatar img-fluid rounded-circle" alt="William Harris">
                                            </div>
                                            <div class="col-10 ps-2">
                                                <div class="text-dark">William Harris</div>
                                                <div class="text-muted small mt-1">Curabitur ligula sapien euismod
                                                    vitae.</div>
                                                <div class="text-muted small mt-1">2h ago</div>
                                            </div>
                                        </div>
                                    </a>
                                    <a href="#" class="list-group-item">
                                        <div class="row g-0 align-items-center">
                                            <div class="col-2">
                                                <img src="{{ asset('asset_admin') }}/img/avatars/avatar-4.jpg"
                                                    class="avatar img-fluid rounded-circle" alt="Christina Mason">
                                            </div>
                                            <div class="col-10 ps-2">
                                                <div class="text-dark">Christina Mason</div>
                                                <div class="text-muted small mt-1">Pellentesque auctor neque nec urna.
                                                </div>
                                                <div class="text-muted small mt-1">4h ago</div>
                                            </div>
                                        </div>
                                    </a>
                                    <a href="#" class="list-group-item">
                                        <div class="row g-0 align-items-center">
                                            <div class="col-2">
                                                <img src="{{ asset('asset_admin') }}/img/avatars/avatar-3.jpg"
                                                    class="avatar img-fluid rounded-circle" alt="Sharon Lessman">
                                            </div>
                                            <div class="col-10 ps-2">
                                                <div class="text-dark">Sharon Lessman</div>
                                                <div class="text-muted small mt-1">Aenean tellus metus, bibendum sed,
                                                    posuere ac, mattis non.</div>
                                                <div class="text-muted small mt-1">5h ago</div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="dropdown-menu-footer">
                                    <a href="#" class="text-muted">Show all messages</a>
                                </div>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-flag dropdown-toggle" href="#" id="languageDropdown"
                                data-bs-toggle="dropdown">
                                <img src="{{ asset('asset_admin') }}/img/flags/us.png" alt="English" />
                            </a>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="languageDropdown">
                                <a class="dropdown-item" href="#">
                                    <img src="{{ asset('asset_admin') }}/img/flags/us.png" alt="English"
                                        width="20" class="align-middle me-1" />
                                    <span class="align-middle">English</span>
                                </a>
                                <a class="dropdown-item" href="#">
                                    <img src="{{ asset('asset_admin') }}/img/flags/es.png" alt="Spanish"
                                        width="20" class="align-middle me-1" />
                                    <span class="align-middle">Spanish</span>
                                </a>
                                <a class="dropdown-item" href="#">
                                    <img src="{{ asset('asset_admin') }}/img/flags/ru.png" alt="Russian"
                                        width="20" class="align-middle me-1" />
                                    <span class="align-middle">Russian</span>
                                </a>
                                <a class="dropdown-item" href="#">
                                    <img src="{{ asset('asset_admin') }}/img/flags/de.png" alt="German"
                                        width="20" class="align-middle me-1" />
                                    <span class="align-middle">German</span>
                                </a>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-icon js-fullscreen d-none d-lg-block" href="#">
                                <div class="position-relative">
                                    <i class="align-middle" data-feather="maximize"></i>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-icon pe-md-0 dropdown-toggle" href="#" data-bs-toggle="dropdown">
                                <img src="{{ asset('asset_admin') }}/img/avatars/avatar.jpg"
                                    class="avatar img-fluid rounded" alt="Charles Hall" />
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class='dropdown-item' href='pages-profile.html'><i class="align-middle me-1"
                                        data-feather="user"></i> Profile</a>
                                <a class="dropdown-item" href="#"><i class="align-middle me-1"
                                        data-feather="pie-chart"></i> Analytics</a>
                                <div class="dropdown-divider"></div>
                                <a class='dropdown-item' href='pages-settings.html'><i class="align-middle me-1"
                                        data-feather="settings"></i> Settings &
                                    Privacy</a>
                                <a class="dropdown-item" href="#"><i class="align-middle me-1"
                                        data-feather="help-circle"></i> Help Center</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" onclick="logout()">Log out</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>

            <main class="content">
                @yield('content')
            </main>

            <footer class="footer">
                <div class="container-fluid">
                    <div class="row text-muted">
                        <div class="col-6 text-start">
                            <p class="mb-0">
                                <a href="#" target="_blank" class="text-muted"><strong>SIANTA</strong></a>
                                &copy; {{ date('Y') }}
                            </p>
                        </div>
                        <div class="col-6 text-end">
                            <ul class="list-inline">
                                <li class="list-inline-item">
                                    <span class="text-muted" href="#">Developed By <a
                                            href="https://github.com/Ridlo21" target="_blank">Inurri99</a></span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <script src="{{ asset('asset_admin') }}/js/app.js"></script>
    <script src="{{ asset('asset_admin') }}/jquery/jquery.min.js"></script>
    <script src="{{ asset('asset_admin') }}/parsleyjs/parsley.min.js"></script>
    <script src="{{ asset('asset_admin') }}/parsleyjs/i18n/id.js"></script>
    <script src="{{ asset('asset_admin') }}/sweetalert2/sweetalert2.all.min.js"></script>
    <script>
        function logout() {
            Swal.fire({
                title: 'Anda yakin?',
                text: 'Apakah anda yakin untuk logout?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Tidak',
                confirmButtonText: 'Ya, logout!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{ route('logout') }}";
                }
            });
        }
    </script>
    @stack('scripts')
</body>

</html>
