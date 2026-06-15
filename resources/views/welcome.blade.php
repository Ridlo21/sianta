<?php
// SIANTA - Sistem Management Data SMKNAA Portal Landing Page (Single-Screen Elegant Blue Layout)
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SIANTA - Sistem Management Data SMKNAA</title>
    <meta name="description"
        content="Portal Sistem Informasi Manajemen Data Terintegrasi SMK Nurul Abror Al-Robbaniyyin (SMKNAA). Akses layanan administrasi, data siswa, guru, dan database alumni secara mudah dan terintegrasi dalam satu layar.">
    <meta name="keywords" content="SIANTA, SMKNAA, SMK Nurul Abror, portal sekolah, sistem data sekolah, Curug Tangerang">

    <script>
        // Render-blocking script to apply theme matching system preferences
        (function() {
            const savedTheme = localStorage.getItem('theme');
            if (savedTheme === 'light') {
                document.documentElement.setAttribute('data-theme', 'light');
            } else if (savedTheme === 'dark') {
                document.documentElement.removeAttribute('data-theme');
            } else {
                // First-time visit: default to computer/OS color scheme
                const prefersLight = window.matchMedia('(prefers-color-scheme: light)').matches;
                if (prefersLight) {
                    document.documentElement.setAttribute('data-theme', 'light');
                }
            }
        })();
    </script>

    <!-- CSS Stylesheet -->
    <link rel="stylesheet" href="{{ asset('asset_portal') }}/style.css">

    <!-- Favicon -->
    <link rel="icon" type="image/webp" href="{{ asset('asset_portal') }}/logo.webp">
</head>

<body>

    <div class="portal-container">

        <!-- ==========================================
         LEFT PANEL: BRANDING, HERO & CONTACT INFO
         ========================================== -->
        <aside class="sidebar-panel">
            <!-- Sidebar Header (Logo and Toggle button) -->
            <div class="sidebar-header">
                <!-- Branding Logo & Subtext -->
                <a href="#" class="branding" id="brandingLogo">
                    <img src="{{ asset('asset_portal') }}/logo.webp" alt="Logo SMKNAA" class="logo-img">
                    <div class="branding-text">
                        <span class="brand-name">SMKNAA</span>
                        <span class="brand-sub">SMK Nurul Abror Al-Robbaniyyin</span>
                    </div>
                </a>

                <!-- Interactive Dark/Light Toggle Button -->
                <button class="theme-toggle-btn" id="themeToggleBtn" aria-label="Ubah Tema">
                    <!-- SVG icon will be dynamically injected by JavaScript -->
                </button>
            </div>

            <!-- Hero Main Content -->
            <div class="hero-content">
                <div class="hero-tag">Portal Resmi SMKNAA</div>
                <h1 class="hero-title">SIANTA</h1>
                <h2 class="hero-subtitle">Sistem Management Data</h2>
                <p class="hero-description">
                    Sistem terintegrasi untuk pengelolaan data sekolah yang cepat, akurat, dan aman. Menghubungkan data
                    siswa, guru, alumni, serta layanan administrasi dalam satu platform digital tanpa batas.
                </p>
                <div class="hero-actions">
                    <a href="{{route('login')}}" class="btn-primary" id="btnSidebarPortal">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                            stroke-linejoin="round">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />
                            <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                        </svg>
                        Masuk Portal
                    </a>
                    <a href="#panduan" class="btn-secondary" id="btnSidebarGuide">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z" />
                            <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z" />
                        </svg>
                        Panduan Penggunaan
                    </a>
                </div>
            </div>

            <!-- Contact Info & Copyright at Bottom -->
            <div class="sidebar-footer">
                <div class="contact-list">
                    <!-- Address -->
                    <a href="https://maps.google.com" target="_blank" rel="noopener noreferrer" class="contact-item"
                        id="sidebarContactAddr">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" />
                            <circle cx="12" cy="10" r="3" />
                        </svg>
                        <span>Jl. KH. Agus Salim No. 155, Alasbulu Wongsorejo</span>
                    </a>

                    <!-- Phone & Mail -->
                    <div style="display: flex; gap: var(--space-md); flex-wrap: wrap;">
                        <a href="tel:02112345678" class="contact-item" id="sidebarContactPhone">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path
                                    d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z" />
                            </svg>
                            <span>082230765106</span>
                        </a>

                        <a href="mailto:esemka.naa@gmail.com" class="contact-item" id="sidebarContactMail">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                                <polyline points="22,6 12,13 2,6" />
                            </svg>
                            <span>esemka.naa@gmail.com</span>
                        </a>
                    </div>
                </div>
                <p class="copyright">&copy; <?php echo date('Y'); ?> SMKNAA. All rights reserved.</p>
            </div>
        </aside>

        <!-- ==========================================
         RIGHT PANEL: VISUAL BANNER, STATS & FEATURES
         ========================================== -->
        <main class="content-panel">
            <!-- Top School Image with mask overlay -->
            <section class="visual-block">
                <div class="visual-overlay"></div>
                <img src="{{ asset('asset_portal') }}/gedung.png" alt="Gedung SMK Nurul Abror Al-Robbaniyyin">
            </section>

            <!-- Bottom Dashboard Block -->
            <div class="dashboard-block">

                <!-- Stats Row -->
                <div class="stats-container">
                    <div class="stats-card">
                        <div class="stats-grid">

                            <!-- Stat: Siswa -->
                            <div class="stat-item siswa">
                                <div class="stat-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                                        <circle cx="9" cy="7" r="4" />
                                        <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                                        <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                                    </svg>
                                </div>
                                <div class="stat-info">
                                    <span class="stat-title">Data Siswa</span>
                                    <span class="stat-value">1.245+</span>
                                    <span class="stat-desc">Siswa Aktif</span>
                                </div>
                            </div>

                            <!-- Stat: Guru -->
                            <div class="stat-item guru">
                                <div class="stat-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M22 10v6M2 10l10-5 10 5-10 5z" />
                                        <path d="M6 12v5c0 2 2 3 6 3s6-1 6-3v-5" />
                                    </svg>
                                </div>
                                <div class="stat-info">
                                    <span class="stat-title">Data Guru</span>
                                    <span class="stat-value">87+</span>
                                    <span class="stat-desc">Tenaga Pendidik</span>
                                </div>
                            </div>

                            <!-- Stat: Alumni -->
                            <div class="stat-item alumni">
                                <div class="stat-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                                        <circle cx="8.5" cy="7" r="4" />
                                        <polyline points="17 11 19 13 23 9" />
                                    </svg>
                                </div>
                                <div class="stat-info">
                                    <span class="stat-title">Data Alumni</span>
                                    <span class="stat-value">3.560+</span>
                                    <span class="stat-desc">Alumni Terdaftar</span>
                                </div>
                            </div>

                            <!-- Stat: Layanan -->
                            <div class="stat-item layanan">
                                <div class="stat-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <rect x="3" y="3" width="7" height="7" />
                                        <rect x="14" y="3" width="7" height="7" />
                                        <rect x="14" y="14" width="7" height="7" />
                                        <rect x="3" y="14" width="7" height="7" />
                                    </svg>
                                </div>
                                <div class="stat-info">
                                    <span class="stat-title">Layanan</span>
                                    <span class="stat-value">10+</span>
                                    <span class="stat-desc">Sistem Terintegrasi</span>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- Features Section -->
                <div class="features-container">
                    <div class="features-header">
                        <div>
                            <span class="features-tagline">Fitur Utama</span>
                            <h2 class="features-title">Layanan Data &amp; Administrasi Sekolah</h2>
                        </div>
                    </div>

                    <!-- Features Grid -->
                    <div class="features-grid">

                        <!-- Card 1 -->
                        <article class="feature-card" id="featSiswa">
                            <div class="feature-icon-wrapper">
                                <div class="feature-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                                        <circle cx="9" cy="7" r="4" />
                                        <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                                        <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                                    </svg>
                                </div>
                            </div>
                            <div class="feature-info">
                                <h3 class="feature-title">Manajemen Siswa</h3>
                                <p class="feature-description">Administrasi dan rekapitulasi data profil siswa
                                    terstruktur.</p>
                            </div>
                        </article>

                        <!-- Card 2 -->
                        <article class="feature-card" id="featGuru">
                            <div class="feature-icon-wrapper">
                                <div class="feature-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                                        <circle cx="8.5" cy="7" r="4" />
                                        <line x1="18" y1="8" x2="23" y2="13" />
                                        <line x1="23" y1="8" x2="18" y2="13" />
                                    </svg>
                                </div>
                            </div>
                            <div class="feature-info">
                                <h3 class="feature-title">Guru &amp; Tendik</h3>
                                <p class="feature-description">Manajemen kepegawaian dan kependidikan guru terpusat.
                                </p>
                            </div>
                        </article>

                        <!-- Card 3 -->
                        <article class="feature-card" id="featAlumni">
                            <div class="feature-icon-wrapper">
                                <div class="feature-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path d="M22 10v6M2 10l10-5 10 5-10 5z" />
                                        <path d="M6 12v5c0 2 2 3 6 3s6-1 6-3v-5" />
                                    </svg>
                                </div>
                            </div>
                            <div class="feature-info">
                                <h3 class="feature-title">Database Alumni</h3>
                                <p class="feature-description">Tracer study lulusan dan jejaring alumni berkelanjutan.
                                </p>
                            </div>
                        </article>

                        <!-- Card 4 -->
                        <article class="feature-card" id="featArsip">
                            <div class="feature-icon-wrapper">
                                <div class="feature-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path
                                            d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="feature-info">
                                <h3 class="feature-title">Arsip Digital</h3>
                                <p class="feature-description">Penyimpanan dokumen resmi sekolah aman berbasis cloud.
                                </p>
                            </div>
                        </article>

                        <!-- Card 5 -->
                        <article class="feature-card" id="featInfo">
                            <div class="feature-icon-wrapper">
                                <div class="feature-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9" />
                                        <path d="M13.73 21a2 2 0 0 1-3.46 0" />
                                    </svg>
                                </div>
                            </div>
                            <div class="feature-info">
                                <h3 class="feature-title">Pengumuman</h3>
                                <p class="feature-description">Informasi pengumuman &amp; agenda sekolah waktu nyata.
                                </p>
                            </div>
                        </article>

                        <!-- Card 6 -->
                        <article class="feature-card" id="featSecurity">
                            <div class="feature-icon-wrapper">
                                <div class="feature-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="feature-info">
                                <h3 class="feature-title">Keamanan Data</h3>
                                <p class="feature-description">Proteksi data rahasia institusi terenkripsi berlapis.
                                </p>
                            </div>
                        </article>

                    </div>
                </div>

            </div>
        </main>

    </div>

    <!-- Theme Toggle Logic Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const themeToggleBtn = document.getElementById('themeToggleBtn');

            // Dynamic SVG Icon Contents
            const sunIcon = `
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
          <circle cx="12" cy="12" r="5"/>
          <line x1="12" y1="1" x2="12" y2="3"/>
          <line x1="12" y1="21" x2="12" y2="23"/>
          <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/>
          <line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/>
          <line x1="1" y1="12" x2="3" y2="12"/>
          <line x1="21" y1="12" x2="23" y2="12"/>
          <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/>
          <line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/>
        </svg>
      `;
            const moonIcon = `
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
          <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/>
        </svg>
      `;

            // Updates button icon based on loaded theme class
            function updateToggleIcon() {
                const currentTheme = document.documentElement.getAttribute('data-theme');
                if (currentTheme === 'light') {
                    themeToggleBtn.innerHTML = moonIcon;
                    themeToggleBtn.setAttribute('title', 'Ubah ke Mode Gelap');
                } else {
                    themeToggleBtn.innerHTML = sunIcon;
                    themeToggleBtn.setAttribute('title', 'Ubah ke Mode Terang');
                }
            }

            // Initial render
            updateToggleIcon();

            // Click event to swap theme attribute and update store
            themeToggleBtn.addEventListener('click', function() {
                const currentTheme = document.documentElement.getAttribute('data-theme');
                if (currentTheme === 'light') {
                    document.documentElement.removeAttribute('data-theme');
                    localStorage.setItem('theme', 'dark');
                } else {
                    document.documentElement.setAttribute('data-theme', 'light');
                    localStorage.setItem('theme', 'light');
                }
                updateToggleIcon();
            });
        });
    </script>

</body>

</html>
