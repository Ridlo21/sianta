@extends('template_guru')

@section('content')
    <style>
        .welcome-banner {
            background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%);
            border-radius: 16px;
            padding: 2.25rem;
            color: #ffffff;
            position: relative;
            overflow: hidden;
            border: none;
            box-shadow: 0 10px 25px rgba(99, 102, 241, 0.15);
            margin-bottom: 2rem;
        }

        .welcome-banner::before {
            content: '';
            position: absolute;
            top: -40%;
            right: -10%;
            width: 320px;
            height: 320px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.18) 0%, rgba(255, 255, 255, 0) 70%);
            pointer-events: none;
        }

        .welcome-banner-title {
            font-size: 1.75rem;
            font-weight: 750;
            margin-bottom: 0.5rem;
            letter-spacing: -0.02em;
        }

        .welcome-banner-text {
            font-size: 0.975rem;
            opacity: 0.9;
            font-weight: 400;
            max-width: 580px;
            line-height: 1.5;
        }

        .quick-stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
        }

        .bg-primary-subtle {
            background-color: rgba(99, 102, 241, 0.08) !important;
        }

        .bg-success-subtle {
            background-color: rgba(16, 185, 129, 0.08) !important;
        }

        .bg-info-subtle {
            background-color: rgba(6, 182, 212, 0.08) !important;
        }

        .text-theme-value {
            color: var(--text-value) !important;
        }
    </style>

    <div class="container-fluid p-0">
        <!-- Modern Welcome Banner -->
        <div class="welcome-banner">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h3 class="welcome-banner-title">Selamat datang, {{ $user->name }}! 👋</h3>
                    <p class="welcome-banner-text mb-3">
                        Mohon segera lengkapi formulir biodata Anda. Pastikan seluruh informasi yang diisikan lengkap, benar, dan sesuai dengan data yang sebenarnya untuk mendukung kelancaran proses administrasi.
                    </p>
                    @php
                        $btnLink = ($guru && $guru->nik !== null)
                            ? route('guru.lengkapi_data.step2')
                            : route('guru.lengkapi_data.step1');
                    @endphp
                    <a href="{{ $btnLink }}" class="btn btn-warning fw-bold text-dark px-4 py-2 mt-2" style="border-radius: 8px;">
                        <i class="fas fa-edit me-2"></i> Lengkapi Biodata
                    </a>
                </div>
                @if ($periodeAktif)
                    <div class="col-md-4 text-md-end mt-3 mt-md-0">
                        <div class="welcome-badge-glass">
                            <i data-feather="calendar" style="width: 16px; height: 16px;"></i>
                            <span>Periode Aktif: {{ $periodeAktif->awal }}/{{ $periodeAktif->akhir }} (Smtr
                                {{ $periodeAktif->semester }})</span>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script></script>
@endpush
