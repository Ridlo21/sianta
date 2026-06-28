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
    <link rel="shortcut icon" href="{{ asset('asset_login') }}/sianta.png" />

    <title>{{ $title }} | SIANTA</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&amp;display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Choose your prefered color scheme -->
    <script>
        (function() {
            const savedTheme = localStorage.getItem('theme') || 'auto';
            let theme = savedTheme;
            if (savedTheme === 'auto') {
                theme = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
            }

            const themeUrl = theme === 'dark' ?
                '{{ asset('asset_admin/css/dark.css') }}' :
                '{{ asset('asset_admin/css/light.css') }}';

            document.write('<link id="theme-stylesheet" href="' + themeUrl + '" rel="stylesheet">');
            document.documentElement.setAttribute('data-theme', theme);
        })();
    </script>
    <link rel="stylesheet" href="{{ asset('asset_admin') }}/parsleyjs/parsley.css" />
    <link rel="stylesheet" href="{{ asset('asset_admin') }}/datatables.net-bs5/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="{{ asset('asset_admin') }}/select2/css/select2.min.css">
    <style>
        :root {
            /* Variables for Light Theme (default) */
            --bg-card: #ffffff;
            --border-card: rgba(226, 232, 240, 0.7);
            --text-main: #475569;
            --text-muted: #64748b;
            --text-value: #0f172a;
            --bg-quick-card: #ffffff;
            --bg-table-row: rgba(248, 250, 252, 0.6);
            --bg-table-hover: rgba(241, 245, 249, 1);
            --text-table-label: #475569;
            --navbar-bg: #ffffff;
            --navbar-border: rgba(226, 232, 240, 0.8);
            --input-bg: #ffffff;
            --input-border: #cbd5e1;
            --input-text: #1e293b;
        }

        [data-theme="dark"] {
            /* Variables for Dark Theme */
            --bg-card: #151c2e;
            /* dark blue-slate */
            --border-card: rgba(255, 255, 255, 0.05);
            --text-main: #94a3b8;
            --text-muted: #64748b;
            --text-value: #f8fafc;
            --bg-quick-card: #151c2e;
            --bg-table-row: rgba(255, 255, 255, 0.01);
            --bg-table-hover: rgba(255, 255, 255, 0.03);
            --text-table-label: #94a3b8;
            --navbar-bg: #151c2e;
            --navbar-border: rgba(255, 255, 255, 0.05);
            --input-bg: #0d121f;
            --input-border: rgba(255, 255, 255, 0.08);
            --input-text: #f8fafc;
        }

        body {
            opacity: 0;
        }

        /* Chrome, Edge, Safari */
        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }

        /* OVERLAY LOADER */
        #loader {
            position: fixed;
            inset: 0;
            background: rgb(255, 255, 255, 0.5);
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
            border-color: #2563eb #0000;
            animation: spinner-0tkp9a 1s infinite;
        }

        @keyframes spinner-0tkp9a {
            to {
                transform: rotate(.5turn);
            }
        }

        /* Premium Modern Sidebar Theme Overrides */
        .sidebar {
            background: #09142e !important;
            /* Deep midnight navy blue */
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.15) !important;
            border-right: 1px solid rgba(255, 255, 255, 0.03);
        }

        .sidebar-content {
            background: #09142e !important;
        }

        /* Brand / Header */
        .sidebar-brand {
            background: #09142e !important;
            padding: 1.5rem 1.5rem !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.04);
        }

        .sidebar-brand-text {
            font-weight: 750 !important;
            letter-spacing: 0.05em;
            background: linear-gradient(135deg, #93c5fd 0%, #3b82f6 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* User Info Panel */
        .sidebar-user {
            background: rgba(255, 255, 255, 0.02) !important;
            border: 1px solid rgba(255, 255, 255, 0.04) !important;
            padding: 1.15rem 1rem !important;
            margin: 1.25rem 1rem 0.75rem !important;
            border-radius: 12px;
        }

        .sidebar-user .avatar {
            border: 2px solid #3b82f6;
            padding: 2px;
            background: #ffffff;
            width: 40px;
            height: 40px;
            border-radius: 8px !important;
        }

        .sidebar-user-title {
            color: #f8fafc !important;
            font-weight: 600 !important;
            transition: color 0.2s ease;
        }

        .sidebar-user-title:hover {
            color: #60a5fa !important;
        }

        .sidebar-user-subtitle {
            color: #94a3b8 !important;
            font-size: 0.75rem !important;
            opacity: 0.8;
        }

        /* Nav List items */
        .sidebar-header {
            color: #475569 !important;
            font-weight: 700 !important;
            text-transform: uppercase !important;
            letter-spacing: 0.08em !important;
            padding: 1.5rem 1.5rem 0.5rem !important;
            font-size: 0.725rem !important;
        }

        .sidebar-link {
            background: transparent !important;
            color: #94a3b8 !important;
            padding: 0.75rem 1.5rem !important;
            font-weight: 550 !important;
            border-left: 3px solid transparent;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1) !important;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .sidebar-link i {
            color: #64748b !important;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1) !important;
        }

        /* Link Hover */
        .sidebar-item:hover .sidebar-link {
            color: #ffffff !important;
            background: rgba(255, 255, 255, 0.02) !important;
            border-left-color: rgba(37, 99, 235, 0.3) !important;
        }

        .sidebar-item:hover .sidebar-link i {
            color: #60a5fa !important;
            transform: scale(1.08);
        }

        /* Active Sidebar Link (Top-Level) */
        .sidebar-item.active>.sidebar-link {
            background: linear-gradient(135deg, #1d4ed8 0%, #3b82f6 100%) !important;
            color: #ffffff !important;
            border-left-color: #60a5fa !important;
            box-shadow: 0 4px 15px rgba(37, 99, 235, 0.2) !important;
            font-weight: 600 !important;
        }

        .sidebar-item.active>.sidebar-link i {
            color: #ffffff !important;
        }

        /* Submenus (Dropdowns) */
        .sidebar-dropdown {
            background: rgba(0, 0, 0, 0.15) !important;
            padding: 0.25rem 0 !important;
        }

        .sidebar-dropdown .sidebar-link {
            padding-left: 3.25rem !important;
            font-size: 0.85rem !important;
            border-left: none !important;
        }

        .sidebar-dropdown .sidebar-item.active .sidebar-link {
            background: transparent !important;
            color: #60a5fa !important;
            box-shadow: none !important;
            font-weight: 650 !important;
        }

        .sidebar-dropdown .sidebar-item.active .sidebar-link::before {
            content: '•';
            color: #60a5fa;
            font-size: 1.15rem;
            position: absolute;
            left: 2rem;
            line-height: 1;
        }

        /* Top Navbar Improvements */
        .navbar {
            border-bottom: 1px solid var(--navbar-border) !important;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.01) !important;
            background: var(--navbar-bg) !important;
        }

        .sidebar-toggle {
            transition: all 0.25s ease;
            border-radius: 8px;
            padding: 0.35rem !important;
        }

        .sidebar-toggle:hover {
            color: #2563eb !important;
            background: rgba(37, 99, 235, 0.05) !important;
        }

        /* Cohesive Global CSS overrides */
        .card {
            border: 1px solid var(--border-card) !important;
            background: var(--bg-card) !important;
            border-radius: 16px !important;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.01), 0 2px 4px -1px rgba(0, 0, 0, 0.005) !important;
            margin-bottom: 1.5rem;
            transition: all 0.3s ease;
        }

        .card-header {
            background: transparent !important;
            border-bottom: 1px solid var(--border-card) !important;
            padding: 1.25rem 1.5rem !important;
        }

        .card-title {
            font-weight: 700 !important;
            color: var(--text-value) !important;
            font-size: 1rem !important;
            letter-spacing: -0.015em;
        }

        .card-subtitle {
            color: var(--text-muted) !important;
            font-size: 0.85rem !important;
            line-height: 1.5;
        }

        .card-body {
            padding: 1.5rem !important;
            color: var(--text-main) !important;
        }

        /* Global Buttons styling */
        .btn {
            border-radius: 10px !important;
            font-weight: 600 !important;
            padding: 0.5rem 1.25rem;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1) !important;
        }

        /* Style for small buttons (.btn-sm) and table actions to keep them neat, compact, and equal size */
        .btn-sm,
        .table .btn,
        .dataTables_wrapper .btn {
            padding: 0.35rem 0.6rem !important;
            font-size: 0.775rem !important;
            border-radius: 6px !important;
            height: 28px !important;
            min-width: 28px !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 0.25rem !important;
        }

        .btn-primary {
            background: linear-gradient(135deg, #1d4ed8 0%, #3b82f6 100%) !important;
            border: none !important;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2) !important;
            color: #ffffff !important;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #1e40af 0%, #2563eb 100%) !important;
            transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(37, 99, 235, 0.3) !important;
        }

        .btn-primary:active {
            transform: translateY(1px) !important;
        }

        .btn-secondary {
            background: var(--border-card) !important;
            border: 1px solid var(--border-card) !important;
            color: var(--text-main) !important;
        }

        .btn-secondary:hover {
            background: var(--bg-table-hover) !important;
            color: var(--text-value) !important;
            transform: translateY(-1px);
        }

        /* Form Inputs */
        .form-control {
            background-color: var(--input-bg) !important;
            border: 1px solid var(--input-border) !important;
            color: var(--input-text) !important;
            border-radius: 10px !important;
            padding: 0.45rem 0.85rem !important;
            font-size: 0.875rem !important;
            transition: all 0.2s ease !important;
        }

        .form-select {
            background-color: var(--input-bg) !important;
            border: 1px solid var(--input-border) !important;
            color: var(--input-text) !important;
            border-radius: 10px !important;
            padding: 0.45rem 2.25rem 0.45rem 0.85rem !important;
            /* Space for the dropdown arrow */
            font-size: 0.875rem !important;
            transition: all 0.2s ease !important;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #3b82f6 !important;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15) !important;
            outline: none !important;
        }

        .form-control::placeholder {
            color: var(--text-muted) !important;
            opacity: 0.5 !important;
        }

        /* Tables & DataTables Styling */
        .table {
            color: var(--text-main) !important;
            width: 100% !important;
        }

        .table thead th {
            border-bottom: 2px solid var(--border-card) !important;
            color: var(--text-value) !important;
            font-weight: 700 !important;
            text-transform: uppercase;
            font-size: 0.725rem;
            letter-spacing: 0.05em;
            padding: 1rem 0.75rem !important;
            background: transparent !important;
        }

        .table tbody td {
            border-bottom: 1px solid var(--border-card) !important;
            padding: 0.85rem 0.75rem !important;
            font-size: 0.875rem !important;
            vertical-align: middle;
            background: transparent !important;
        }

        .table-striped tbody tr:nth-of-type(odd) td {
            background-color: var(--bg-table-row) !important;
        }

        .table tbody tr:hover td {
            background-color: var(--bg-table-hover) !important;
        }

        .page-item.active .page-link {
            background: linear-gradient(135deg, #1d4ed8 0%, #3b82f6 100%) !important;
            border-color: transparent !important;
            color: #ffffff !important;
            box-shadow: 0 4px 10px rgba(37, 99, 235, 0.15) !important;
        }

        .page-link {
            border-radius: 8px !important;
            margin: 0 2px;
            color: var(--text-main) !important;
            background: var(--bg-card) !important;
            border: 1px solid var(--border-card) !important;
            transition: all 0.2s ease;
        }

        .page-link:hover {
            background: var(--bg-table-hover) !important;
            color: #2563eb !important;
        }

        /* Responsive Datatable Wrappers */
        .table-responsive {
            overflow-x: auto !important;
            -webkit-overflow-scrolling: touch !important;
            width: 100% !important;
            display: block !important;
        }

        .dataTables_wrapper {
            width: 100% !important;
        }

        .dataTables_wrapper .col-sm-12 {
            overflow-x: auto !important;
            -webkit-overflow-scrolling: touch !important;
            width: 100% !important;
        }

        /* Select2 Dark Mode support */
        [data-theme="dark"] .select2-container--default .select2-selection--single {
            background-color: var(--input-bg) !important;
            border-color: var(--input-border) !important;
            color: var(--input-text) !important;
            height: 38px !important;
            border-radius: 10px !important;
        }

        [data-theme="dark"] .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: var(--input-text) !important;
            line-height: 36px !important;
        }

        [data-theme="dark"] .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 36px !important;
        }

        [data-theme="dark"] .select2-dropdown {
            background-color: var(--input-bg) !important;
            border-color: var(--input-border) !important;
            color: var(--input-text) !important;
            border-radius: 10px !important;
        }

        [data-theme="dark"] .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: #2563eb !important;
            color: #ffffff !important;
        }

        [data-theme="dark"] .select2-container--default .select2-results__option[aria-selected=true] {
            background-color: rgba(37, 99, 235, 0.15) !important;
            color: #ffffff !important;
        }

        [data-theme="dark"] .select2-search--dropdown .select2-search__field {
            background-color: var(--input-bg) !important;
            border-color: var(--input-border) !important;
            color: var(--input-text) !important;
            border-radius: 6px !important;
        }

        /* Form Checkbox custom styling */
        .form-check-input {
            background-color: var(--input-bg) !important;
            border-color: var(--input-border) !important;
            border-radius: 4px !important;
        }

        .form-check-input:checked {
            background-color: #2563eb !important;
            border-color: #2563eb !important;
        }

        /* Parsley validations styling matching */
        .parsley-errors-list {
            color: #ef4444 !important;
            font-size: 0.75rem !important;
            margin-top: 0.25rem !important;
            list-style: none !important;
            padding-left: 0 !important;
            font-weight: 600;
        }

        input.parsley-error,
        select.parsley-error,
        textarea.parsley-error {
            border-color: #ef4444 !important;
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.15) !important;
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
                <a class='sidebar-brand d-flex align-items-center' href="{{ route('dashboard') }}">
                    <img src="{{ asset('asset_login') }}/sianta.png" alt="Logo" width="40" height="40"
                        class="me-2">
                    <span class="sidebar-brand-text align-middle">
                        SIANTA
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
                            <img src="{{ $user->photo ? asset('gambar_berkas/avatars/' . $user->photo) : asset('asset_admin/img/avatars/avatar.png') }}"
                                class="avatar img-fluid rounded me-1" alt="{{ $user->name }}" />
                        </div>
                        <div class="flex-grow-1 ps-2">
                            <a class="sidebar-user-title" href="{{ route('profile') }}">
                                {{ $user->name }}
                            </a>

                            <div class="sidebar-user-subtitle">{{ $user->email }}</div>
                        </div>
                    </div>
                </div>

                <ul class="sidebar-nav">
                    <li class="sidebar-header">
                        Menu
                    </li>
                    <li class="sidebar-item {{ $title == 'Dashboard' ? 'active' : '' }}">
                        <a class='sidebar-link' href="{{ route('dashboard') }}">
                            <i class="align-middle" data-feather="sliders"></i> <span
                                class="align-middle">Dashboard</span>
                        </a>
                    </li>

                    <!-- GROUP: DATA MASTER -->
                    @php
                        $isMasterActive = in_array($title, ['Periode Akademik', 'Jurusan', 'Guru & Tendik', 'Siswa']);
                    @endphp
                    <li class="sidebar-item {{ $isMasterActive ? 'active' : '' }}">
                        <a data-bs-target="#master" data-bs-toggle="collapse"
                            class="sidebar-link {{ $isMasterActive ? '' : 'collapsed' }}">
                            <i class="align-middle" data-feather="database"></i> <span class="align-middle">Data
                                Master</span>
                        </a>
                        <ul id="master"
                            class="sidebar-dropdown list-unstyled collapse {{ $isMasterActive ? 'show' : '' }}"
                            data-bs-parent="#sidebar">
                            <li class="sidebar-item {{ $title == 'Periode Akademik' ? 'active' : '' }}">
                                <a class='sidebar-link' href='{{ route('periode') }}'>Periode</a>
                            </li>
                            <li class="sidebar-item {{ $title == 'Jurusan' ? 'active' : '' }}">
                                <a class='sidebar-link' href='{{ route('jurusan') }}'>Jurusan</a>
                            </li>
                            <li class="sidebar-item {{ $title == 'Guru & Tendik' ? 'active' : '' }}">
                                <a class='sidebar-link' href='{{ route('guru') }}'>Guru & Tendik</a>
                            </li>
                            <li class="sidebar-item {{ $title == 'Siswa' ? 'active' : '' }}">
                                <a class='sidebar-link' href="{{ route('siswa') }}">Siswa</a>
                            </li>
                        </ul>
                    </li>

                    <!-- GROUP: AKADEMIK -->
                    @php
                        $isAkademikActive =
                            in_array($title, [
                                'Rombel',
                                'Kelola Detail Rombel',
                                'Pembagian Kelas Massal',
                                'Mata Pelajaran',
                                'Sebaran Mapel',
                            ]) || str_contains($title, 'Jadwal');
                    @endphp
                    <li class="sidebar-item {{ $isAkademikActive ? 'active' : '' }}">
                        <a data-bs-target="#akademik" data-bs-toggle="collapse"
                            class="sidebar-link {{ $isAkademikActive ? '' : 'collapsed' }}">
                            <i class="align-middle" data-feather="book-open"></i> <span
                                class="align-middle">Akademik</span>
                        </a>
                        <ul id="akademik"
                            class="sidebar-dropdown list-unstyled collapse {{ $isAkademikActive ? 'show' : '' }}"
                            data-bs-parent="#sidebar">
                            <li
                                class="sidebar-item {{ in_array($title, ['Rombel', 'Kelola Detail Rombel', 'Pembagian Kelas Massal']) ? 'active' : '' }}">
                                <a class='sidebar-link' href='{{ route('rombel') }}'>Rombel</a>
                            </li>
                            <li class="sidebar-item {{ $title == 'Mata Pelajaran' ? 'active' : '' }}">
                                <a class='sidebar-link' href='{{ route('mapel') }}'>Mata Pelajaran</a>
                            </li>
                            <li class="sidebar-item {{ $title == 'Sebaran Mapel' ? 'active' : '' }}">
                                <a class='sidebar-link' href='{{ route('sebaran-mapel') }}'>Sebaran Mapel</a>
                            </li>
                            <li class="sidebar-item {{ str_contains($title, 'Jadwal') ? 'active' : '' }}">
                                <a class='sidebar-link' href='{{ route('jadwal') }}'>Jadwal Pelajaran</a>
                            </li>
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
                        {{-- <li class="nav-item dropdown">
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
                        </li> --}}
                        <!-- Theme Toggle Selector -->
                        <li class="nav-item dropdown me-2">
                            <a class="nav-icon dropdown-toggle" href="#" id="themeDropdown"
                                data-bs-toggle="dropdown">
                                <div class="position-relative" id="theme-icon-container">
                                    <i class="align-middle" data-feather="sun"></i>
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="themeDropdown">
                                <a class="dropdown-item d-flex align-items-center gap-2" href="#"
                                    onclick="setTheme('light'); event.preventDefault();">
                                    <i data-feather="sun" style="width: 14px; height: 14px;"></i> Terang (Light)
                                </a>
                                <a class="dropdown-item d-flex align-items-center gap-2" href="#"
                                    onclick="setTheme('dark'); event.preventDefault();">
                                    <i data-feather="moon" style="width: 14px; height: 14px;"></i> Gelap (Dark)
                                </a>
                                <a class="dropdown-item d-flex align-items-center gap-2" href="#"
                                    onclick="setTheme('auto'); event.preventDefault();">
                                    <i data-feather="monitor" style="width: 14px; height: 14px;"></i> Sistem (Auto)
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
                                <img src="{{ $user->photo ? asset('gambar_berkas/avatars/' . $user->photo) : asset('asset_admin/img/avatars/avatar.png') }}"
                                    class="avatar img-fluid rounded" alt="{{ $user->name }}" />
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class='dropdown-item' href='{{ route('profile') }}'><i class="align-middle me-1"
                                        data-feather="user"></i> Profil</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" onclick="logout()">Logout</a>
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
                                    <span class="text-muted">Version <a>1.0</a></span>
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
    <script src="{{ asset('asset_admin') }}/datatables/js/dataTables.min.js"></script>
    <script src="{{ asset('asset_admin') }}/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
    <script src="{{ asset('asset_admin') }}/select2/js/select2.full.min.js"></script>
    <script>
        function logout() {
            Swal.fire({
                title: '{{ __('Anda yakin?') }}',
                text: '{{ __('Apakah anda yakin untuk logout?') }}',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: '{{ __('Tidak') }}',
                confirmButtonText: '{{ __('Ya, logout!') }}'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{ route('logout') }}";
                }
            });
        }

        $('input[type="number"]').on('keydown', function(e) {
            if (['e', 'E', '+', '-'].includes(e.key)) {
                e.preventDefault();
            }
        });

        $('input, textarea, select').attr('autocomplete', 'off');

        // Wrap tables in table-responsive container dynamically to prevent overflow bugs
        $(document).ready(function() {
            $('table.table').each(function() {
                if (!$(this).parent().hasClass('table-responsive')) {
                    $(this).wrap('<div class="table-responsive"></div>');
                }
            });
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'F12') {
                e.preventDefault();
            }

            if (e.ctrlKey && e.key.toLowerCase() === 'u') {
                e.preventDefault();
            }
        });
        // Theme Switcher Functions
        function setTheme(mode) {
            localStorage.setItem('theme', mode);
            let theme = mode;
            if (mode === 'auto') {
                theme = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
            }

            // Update stylesheet link
            const stylesheet = document.getElementById('theme-stylesheet');
            if (stylesheet) {
                const themeUrl = theme === 'dark' ?
                    '{{ asset('asset_admin/css/dark.css') }}' :
                    '{{ asset('asset_admin/css/light.css') }}';
                stylesheet.setAttribute('href', themeUrl);
            }

            // Set attributes
            document.body.setAttribute('data-theme', theme === 'dark' ? 'dark' : 'default');
            document.documentElement.setAttribute('data-theme', theme);

            // Update Toggle icons
            updateThemeToggleUI(mode);

            // Trigger customized chart color changes if we are on dashboard
            if (typeof updateChartsTheme === 'function') {
                updateChartsTheme(theme);
            }
        }

        function updateThemeToggleUI(mode) {
            const container = document.getElementById('theme-icon-container');
            if (!container) return;

            let featherIcon = 'sun';
            if (mode === 'dark') {
                featherIcon = 'moon';
            } else if (mode === 'auto') {
                featherIcon = 'monitor';
            }

            container.innerHTML = `<i class="align-middle" data-feather="${featherIcon}"></i>`;
            if (window.feather) {
                feather.replace();
            }
        }

        // Apply theme early on load
        (function() {
            const savedTheme = localStorage.getItem('theme') || 'auto';

            // Listen for system theme changes if set to auto
            window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
                if (localStorage.getItem('theme') === 'auto') {
                    setTheme('auto');
                }
            });

            document.addEventListener('DOMContentLoaded', function() {
                // Set initial opacity to show body smoothly after theme resolves
                document.body.style.opacity = 1;

                let theme = savedTheme;
                if (savedTheme === 'auto') {
                    theme = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
                }

                document.body.setAttribute('data-theme', theme === 'dark' ? 'dark' : 'default');
                document.documentElement.setAttribute('data-theme', theme);

                updateThemeToggleUI(savedTheme);
            });
        })();
    </script>
    @stack('scripts')
</body>

</html>
