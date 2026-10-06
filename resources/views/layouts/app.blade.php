<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#064d88">
    <meta name="description" content="@yield('meta_description', 'SPHERE - Sistem Evaluasi Kebijakan, Lingkungan, dan Risiko Spasial. Platform Intelijen Geospasial untuk Pemantauan Dampak Wilayah Kajian Merauke.')">
    <title>@yield('title', 'SPHERE — Sistem Evaluasi Kebijakan, Lingkungan, dan Risiko Spasial')</title>

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <!-- MapLibre GL CSS -->
    <link href="https://unpkg.com/maplibre-gl@5.6.0/dist/maplibre-gl.css" rel="stylesheet">

    <!-- SPHERE Centralized Enterprise Stylesheet -->
    <link href="{{ asset('css/sphere-dashboard.css') }}" rel="stylesheet">

    @stack('styles')
</head>
<body class="@yield('body_class', 'sphere-app')">

    <a class="skip-link" href="#sphereMainContent">Lewati ke konten utama</a>

    <!-- 1. Top Navigation Bar (Shared Component) -->
    @include('partials.navbar')

    <!-- 2. Main Viewport Content -->
    <main id="sphereMainContent">
        @yield('content')
    </main>

    <!-- 3. Footer (Shared Component) -->
    @include('partials.footer')

    <!-- 4. Global Interactive Notification Toast -->
    <div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 1090;">
        <div id="sphereGlobalToast" class="toast align-items-center text-bg-dark border-0 shadow-lg" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body d-flex align-items-center gap-2.5 py-2.5">
                    <i id="globalToastIcon" class="bi bi-info-circle text-info fs-5"></i>
                    <div>
                        <div class="fw-bold" id="globalToastTitle" style="font-size: 0.84rem;">Notifikasi Sistem</div>
                        <div class="small text-white-50" id="globalToastMessage" style="font-size: 0.76rem;">Pembaruan data berhasil dilakukan.</div>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>

    <!-- Library global: urutan ini wajib sebelum @stack('scripts') -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/maplibre-gl@5.6.0/dist/maplibre-gl.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>

    <!-- SPHERE Global JS -->
    <script src="{{ asset('js/sphere-dashboard.js') }}"></script>

    <!-- Script spesifik setiap halaman -->
    @stack('scripts')
</body>
</html>
