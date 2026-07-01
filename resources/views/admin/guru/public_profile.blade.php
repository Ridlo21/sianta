@php
    $defaultAvatar = $guru->jenis_kelamin === 'P' ? 'gurufemale.png' : 'gurumale.png';
    $foto = $guru->foto
        ? asset('gambar_berkas/berkas_guru/' . $guru->foto)
        : asset('asset_admin/img/avatars/' . $defaultAvatar);
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Profil Publik Terverifikasi {{ $guru->nama_lengkap }} pada aplikasi SIANTA.">
    <title>Profil Publik - {{ $guru->nama_lengkap }}</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- FontAwesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary: #4f46e5;
            --primary-light: rgba(99, 102, 241, 0.08);
            --primary-dark: #4338ca;
            --success: #10b981;
            --success-light: #d1fae5;
            --success-dark: #065f46;
            --warning: #f59e0b;
            --warning-light: #fef3c7;
            --warning-dark: #92400e;
            --bg-gray: #f8fafc;
            --card-bg: #ffffff;
            --text-dark: #0f172a;
            --text-muted: #64748b;
            --border-color: #f1f5f9;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Plus Jakarta Sans', sans-serif;
            -webkit-tap-highlight-color: transparent;
        }

        body {
            background-color: var(--bg-gray);
            color: var(--text-dark);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            position: relative;
            overflow-x: hidden;
        }

        /* Decorative background blobs */
        .bg-blob {
            position: absolute;
            width: 500px;
            height: 500px;
            border-radius: 50%;
            filter: blur(120px);
            z-index: -1;
            opacity: 0.15;
        }

        .bg-blob-1 {
            background-color: #4f46e5;
            top: -10%;
            left: -10%;
        }

        .bg-blob-2 {
            background-color: #06b6d4;
            bottom: 10%;
            right: -10%;
        }

        .container {
            max-width: 900px;
            width: 100%;
            margin: 0 auto;
            padding: 24px 16px;
            flex: 1;
        }

        /* Header Card */
        .profile-header-card {
            background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%);
            border-radius: 24px;
            padding: 40px 32px;
            color: #ffffff;
            position: relative;
            overflow: hidden;
            box-shadow: 0 20px 40px -15px rgba(99, 102, 241, 0.3);
            margin-bottom: 24px;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .profile-header-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url("data:image/svg+xml,%3Csvg width='80' height='80' viewBox='0 0 80 80' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23ffffff' fill-opacity='0.03' fill-rule='evenodd'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm1-61c3.16 0 5.71-2.55 5.71-5.71 0-3.16-2.55-5.71-5.71-5.71-3.16 0-5.71 2.55-5.71 5.71 0 3.16 2.55 5.71 5.71 5.71zm54-15c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zM29 57c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zM67 14c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4z'/%3E%3C/g%3E%3C/svg%3E");
            opacity: 0.8;
            pointer-events: none;
        }

        @media (min-width: 768px) {
            .profile-header-card {
                flex-direction: row;
                text-align: left;
                align-items: center;
                gap: 32px;
                padding: 48px;
            }
        }

        .avatar-wrapper {
            position: relative;
            margin-bottom: 20px;
            flex-shrink: 0;
        }

        @media (min-width: 768px) {
            .avatar-wrapper {
                margin-bottom: 0;
            }
        }

        .avatar-img {
            width: 140px;
            height: 180px;
            object-fit: cover;
            border-radius: 18px;
            border: 4px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
            background-color: rgba(255, 255, 255, 0.1);
        }

        .header-info-container {
            flex-grow: 1;
        }

        .verify-badge {
            background-color: var(--success);
            color: #ffffff;
            font-size: 11px;
            font-weight: 700;
            padding: 6px 14px;
            border-radius: 20px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 12px;
            box-shadow: 0 4px 10px rgba(16, 185, 129, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.1);
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.5); }
            70% { box-shadow: 0 0 0 8px rgba(16, 185, 129, 0); }
            100% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
        }

        .teacher-name {
            font-size: 24px;
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 8px;
            letter-spacing: -0.5px;
        }

        @media (min-width: 768px) {
            .teacher-name {
                font-size: 32px;
            }
        }

        .teacher-role {
            font-size: 15px;
            opacity: 0.9;
            font-weight: 500;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            flex-wrap: wrap;
        }

        @media (min-width: 768px) {
            .teacher-role {
                justify-content: flex-start;
            }
        }

        .teacher-role span {
            background-color: rgba(255, 255, 255, 0.15);
            padding: 4px 12px;
            border-radius: 6px;
            font-size: 13px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
            width: 100%;
            max-width: 450px;
            margin: 0 auto;
        }

        @media (min-width: 768px) {
            .stats-grid {
                margin: 0;
            }
        }

        .stat-item {
            background-color: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 12px;
            padding: 10px 8px;
            text-align: center;
            backdrop-filter: blur(5px);
        }

        .stat-val {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 2px;
        }

        .stat-lbl {
            font-size: 10px;
            text-transform: uppercase;
            opacity: 0.7;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        /* Tabs Navigation */
        .tabs-nav {
            display: flex;
            background-color: #e2e8f0;
            padding: 6px;
            border-radius: 16px;
            margin-bottom: 24px;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.03);
        }

        .tab-btn {
            flex: 1;
            background: none;
            border: none;
            padding: 12px 8px;
            font-size: 13px;
            font-weight: 700;
            color: var(--text-muted);
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            outline: none;
        }

        @media (min-width: 500px) {
            .tab-btn {
                font-size: 14px;
                padding: 14px 16px;
            }
        }

        .tab-btn.active {
            background-color: var(--card-bg);
            color: var(--primary);
            box-shadow: 0 4px 12px rgba(15, 23, 42, 0.05);
        }

        /* Tab Content Panels */
        .tab-panel {
            display: none;
            animation: fadeIn 0.4s ease forwards;
        }

        .tab-panel.active {
            display: block;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(12px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Info Card */
        .info-card {
            background-color: var(--card-bg);
            border-radius: 20px;
            padding: 24px;
            box-shadow: 0 10px 30px -10px rgba(15, 23, 42, 0.04);
            border: 1px solid var(--border-color);
            margin-bottom: 24px;
        }

        .card-title {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            color: var(--text-dark);
            border-bottom: 2px solid var(--border-color);
            padding-bottom: 12px;
        }

        .card-title i {
            color: var(--primary);
        }

        /* Grid Lists */
        .info-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 16px;
        }

        @media (min-width: 600px) {
            .info-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        .info-row {
            display: flex;
            flex-direction: column;
            gap: 4px;
            padding: 10px 14px;
            background-color: #f8fafc;
            border-radius: 12px;
            border: 1px solid #f1f5f9;
            transition: all 0.2s ease;
        }

        .info-row:hover {
            border-color: #cbd5e1;
            background-color: #f1f5f9;
        }

        .info-label {
            font-size: 11px;
            font-weight: 600;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .info-value {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-dark);
        }

        /* Timeline for Education */
        .timeline {
            position: relative;
            padding-left: 24px;
            margin-left: 10px;
            border-left: 2px dashed #cbd5e1;
            display: flex;
            flex-direction: column;
            gap: 24px;
        }

        .timeline-item {
            position: relative;
        }

        .timeline-marker {
            position: absolute;
            left: -33px;
            top: 2px;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            background-color: var(--card-bg);
            border: 4px solid var(--primary);
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
            transition: all 0.3s ease;
        }

        .timeline-item:hover .timeline-marker {
            background-color: var(--primary);
            transform: scale(1.15);
        }

        .timeline-content {
            background-color: #f8fafc;
            border-radius: 16px;
            padding: 16px;
            border: 1px solid #f1f5f9;
            transition: all 0.3s ease;
        }

        .timeline-content:hover {
            transform: translateX(4px);
            border-color: rgba(37, 99, 235, 0.2);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.03);
        }

        .timeline-year {
            display: inline-block;
            font-size: 11px;
            font-weight: 700;
            color: var(--primary);
            background-color: var(--primary-light);
            padding: 2px 8px;
            border-radius: 20px;
            margin-bottom: 6px;
        }

        .timeline-title {
            font-size: 15px;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 2px;
        }

        .timeline-subtitle {
            font-size: 13px;
            color: var(--text-muted);
            font-weight: 500;
        }

        .empty-state {
            text-align: center;
            padding: 32px 16px;
            color: var(--text-muted);
        }

        .empty-state i {
            font-size: 40px;
            margin-bottom: 12px;
            opacity: 0.5;
        }

        .empty-state p {
            font-size: 14px;
            font-weight: 500;
        }

        /* Class / Pembelajaran Card */
        .class-list {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .class-card {
            background-color: #f8fafc;
            border: 1px solid #f1f5f9;
            border-radius: 16px;
            padding: 20px;
            display: flex;
            flex-direction: column;
            gap: 12px;
            transition: all 0.3s ease;
        }

        .class-card:hover {
            border-color: rgba(37, 99, 235, 0.2);
            background-color: #f1f5f9;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.02);
        }

        @media (min-width: 600px) {
            .class-card {
                flex-direction: row;
                align-items: center;
                justify-content: space-between;
            }
        }

        .class-info {
            display: flex;
            align-items: flex-start;
            gap: 14px;
        }

        .class-icon-wrapper {
            background-color: var(--primary-light);
            color: var(--primary);
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            flex-shrink: 0;
        }

        .class-details h4 {
            font-size: 15px;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 2px;
        }

        .class-details p {
            font-size: 13px;
            color: var(--text-muted);
            font-weight: 500;
        }

        .class-badge {
            background-color: var(--primary-light);
            color: var(--primary-dark);
            font-size: 12px;
            font-weight: 700;
            padding: 6px 12px;
            border-radius: 8px;
            align-self: flex-start;
        }

        @media (min-width: 600px) {
            .class-badge {
                align-self: center;
            }
        }

        /* Verification Note footer card */
        .verification-footer-card {
            background-color: rgba(99, 102, 241, 0.05);
            border: 1px dashed rgba(99, 102, 241, 0.2);
            border-radius: 20px;
            padding: 20px;
            display: flex;
            align-items: flex-start;
            gap: 14px;
            margin-bottom: 24px;
        }

        .verification-footer-card i {
            color: #4f46e5;
            font-size: 20px;
            margin-top: 2px;
        }

        .verification-footer-card div h5 {
            font-size: 14px;
            font-weight: 700;
            color: #312e81;
            margin-bottom: 4px;
        }

        .verification-footer-card div p {
            font-size: 12px;
            color: #1e40af;
            line-height: 1.5;
            font-weight: 500;
        }

        footer {
            text-align: center;
            padding: 24px 16px 40px 16px;
            color: var(--text-muted);
            font-size: 12px;
            border-top: 1px solid var(--border-color);
            background-color: #ffffff;
            margin-top: auto;
        }

        footer strong {
            color: var(--text-dark);
        }
    </style>
</head>
<body>

    <div class="bg-blob bg-blob-1"></div>
    <div class="bg-blob bg-blob-2"></div>

    <div class="container">
        
        <!-- Header Card -->
        <div class="profile-header-card">
            <div class="avatar-wrapper">
                <img src="{{ $foto }}" alt="Foto Guru" class="avatar-img">
            </div>
            
            <div class="header-info-container">
                <div class="verify-badge">
                    <i class="fa-solid fa-circle-check"></i> Profil Terverifikasi
                </div>
                
                <h1 class="teacher-name">{{ $guru->nama_lengkap }}</h1>
                
                <div class="teacher-role">
                    <span><i class="fa-solid fa-briefcase me-1"></i> {{ $guru->jabatan_gtk ?? $guru->jenis_gtk ?? 'Tenaga Pendidik' }}</span>
                    <span><i class="fa-solid fa-circle-user me-1"></i> Status Keaktifan: Aktif</span>
                </div>
                
                <div class="stats-grid">
                    <div class="stat-item">
                        <div class="stat-val">{{ count($activePembelajaran) }}</div>
                        <div class="stat-lbl">Rombel</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-val">{{ $totalJamMengajar }}</div>
                        <div class="stat-lbl">Jam/Minggu</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-val">{{ $guru->status_kepegawaian ?? '-' }}</div>
                        <div class="stat-lbl">Kepegawaian</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Navigation Tabs -->
        <div class="tabs-nav">
            <button class="tab-btn active" onclick="switchTab(event, 'tab-profile')">
                <i class="fa-solid fa-user-tie"></i> Profil
            </button>
            <button class="tab-btn" onclick="switchTab(event, 'tab-education')">
                <i class="fa-solid fa-graduation-cap"></i> Pendidikan
            </button>
            <button class="tab-btn" onclick="switchTab(event, 'tab-schedule')">
                <i class="fa-solid fa-book-open"></i> Pembelajaran
            </button>
        </div>

        <!-- Tab 1: Profile -->
        <div id="tab-profile" class="tab-panel active">
            <div class="info-card">
                <h3 class="card-title"><i class="fa-solid fa-address-card"></i> Informasi Identitas</h3>
                <div class="info-grid">
                    <div class="info-row">
                        <span class="info-label">Gelar Depan</span>
                        <span class="info-value">{{ $guru->gelar_depan ?? '-' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Gelar Belakang</span>
                        <span class="info-value">{{ $guru->gelar_belakang ?? '-' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Jenis Kelamin</span>
                        <span class="info-value">{{ $guru->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Agama</span>
                        <span class="info-value">{{ $guru->agama->nama_agama ?? '-' }}</span>
                    </div>
                </div>
            </div>

            <div class="info-card">
                <h3 class="card-title"><i class="fa-solid fa-shield-halved"></i> Penugasan & Kredensial</h3>
                <div class="info-grid">
                    <div class="info-row">
                        <span class="info-label">NIY / NIGK</span>
                        <span class="info-value">{{ $guru->niy ?? '-' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">NUPTK</span>
                        <span class="info-value">
                            @if($guru->nuptk)
                                {{ substr($guru->nuptk, 0, 4) }}**********
                            @else
                                -
                            @endif
                        </span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Jenis GTK</span>
                        <span class="info-value">{{ $guru->jenis_gtk ?? '-' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Jabatan GTK</span>
                        <span class="info-value">{{ $guru->jabatan_gtk ?? '-' }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tab 2: Education -->
        <div id="tab-education" class="tab-panel">
            <div class="info-card">
                <h3 class="card-title"><i class="fa-solid fa-graduation-cap"></i> Riwayat Pendidikan Formal</h3>
                @if($guru->pendidikan && $guru->pendidikan->count() > 0)
                    <div class="timeline">
                        @foreach($guru->pendidikan->sortByDesc('tahun_lulus') as $edu)
                            <div class="timeline-item">
                                <div class="timeline-marker"></div>
                                <div class="timeline-content">
                                    <span class="timeline-year">{{ $edu->tahun_masuk }} - {{ $edu->tahun_lulus }}</span>
                                    <h4 class="timeline-title">{{ $edu->jenjang }} {{ $edu->jurusan ? '- ' . $edu->jurusan : '' }}</h4>
                                    <p class="timeline-subtitle">{{ $edu->nama_instansi }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state">
                        <i class="fa-solid fa-user-gradient"></i>
                        <p>Riwayat pendidikan belum ditambahkan.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Tab 3: Schedule / Teaching Assignments -->
        <div id="tab-schedule" class="tab-panel">
            <div class="info-card">
                <h3 class="card-title"><i class="fa-solid fa-book-bookmark"></i> Rekapitulasi Rombongan Belajar Aktif</h3>
                @if($activePembelajaran && $activePembelajaran->count() > 0)
                    <div class="class-list">
                        @foreach($activePembelajaran as $pemb)
                            <div class="class-card">
                                <div class="class-info">
                                    <div class="class-icon-wrapper">
                                        <i class="fa-solid fa-chalkboard-user"></i>
                                    </div>
                                    <div class="class-details">
                                        <h4>{{ $pemb->mataPelajaran->nama_mapel ?? '-' }}</h4>
                                        <p><i class="fa-solid fa-users-rectangle me-1"></i> Rombel: {{ $pemb->rombel->nama_rombel ?? '-' }}</p>
                                        <p><i class="fa-solid fa-code me-1"></i> Kode Mapel: {{ $pemb->mataPelajaran->kode_mapel ?? '-' }}</p>
                                    </div>
                                </div>
                                <div class="class-badge">
                                    {{ $pemb->jam_mengajar }} Jam / Minggu
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state">
                        <i class="fa-solid fa-calendar-xmark"></i>
                        <p>Tidak ada kegiatan pembelajaran aktif di semester ini.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Official Verification Card -->
        <div class="verification-footer-card">
            <i class="fa-solid fa-shield-check"></i>
            <div>
                <h5>Verifikasi Keamanan SIANTA</h5>
                <p>Halaman ini merupakan informasi resmi guru SMK SIANTA yang dihasilkan secara otomatis melalui tanda tangan elektronik QR. Untuk alasan privasi dan keamanan, data sensitif guru disembunyikan.</p>
            </div>
        </div>

    </div>

    <footer>
        <p>&copy; {{ date('Y') }} <strong>SIANTA</strong>. Hak Cipta Dilindungi.</p>
        <p style="font-size: 11px; margin-top: 4px; opacity: 0.8;">Sistem Informasi Akademik & Data Terpadu Sekolah</p>
    </footer>

    <script>
        function switchTab(event, tabId) {
            // Hide all tab panels
            const panels = document.querySelectorAll('.tab-panel');
            panels.forEach(panel => panel.classList.remove('active'));

            // Remove active class from all buttons
            const buttons = document.querySelectorAll('.tab-btn');
            buttons.forEach(btn => btn.classList.remove('active'));

            // Show current tab panel
            document.getElementById(tabId).classList.add('active');

            // Add active class to clicked button
            event.currentTarget.classList.add('active');
        }
    </script>
</body>
</html>
