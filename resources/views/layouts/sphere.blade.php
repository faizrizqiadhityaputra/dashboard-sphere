<!DOCTYPE html>
<html lang="id" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#ffffff">
    <meta name="color-scheme" content="light">
    <meta name="description" content="@yield('meta_description', 'SPHERE - Sistem Evaluasi Kebijakan, Lingkungan, dan Risiko Spasial. Platform Intelijen Geospasial untuk Pemantauan Dampak Wilayah Kajian Merauke.')">
    <title>@yield('title', 'SPHERE — Sistem Evaluasi Kebijakan, Lingkungan, dan Risiko Spasial')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://unpkg.com/maplibre-gl@5.6.0/dist/maplibre-gl.css" rel="stylesheet">
    <link href="{{ asset('css/sphere-dashboard.css') }}" rel="stylesheet">

    @stack('styles')
    <link href="{{ asset('css/sphere-sage.css') }}?v=sage-complete-3" rel="stylesheet">
</head>
<body class="@yield('body_class', 'sphere-app')">
    <div class="sphere-ambient" aria-hidden="true">
        <span class="ambient-orb ambient-orb-one"></span>
        <span class="ambient-orb ambient-orb-two"></span>
        <span class="ambient-orb ambient-orb-three"></span>
    </div>

    <div class="sphere-scroll-progress" aria-hidden="true"><span id="sphereScrollProgress"></span></div>
    <a class="skip-link" href="#sphereMainContent">Lewati ke konten utama</a>

    @include('partials.navbar')

    <main id="sphereMainContent" class="sphere-main">
        @yield('content')
    </main>

    @include('partials.footer')

    <div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index:1090;">
        <div id="sphereGlobalToast" class="toast align-items-center text-bg-dark border-0 shadow-lg" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body d-flex align-items-center gap-2.5 py-2.5">
                    <i id="globalToastIcon" class="bi bi-info-circle text-info fs-5"></i>
                    <div>
                        <div class="fw-bold" id="globalToastTitle" style="font-size:.84rem;">Notifikasi Sistem</div>
                        <div class="small text-white-50" id="globalToastMessage" style="font-size:.76rem;">Pembaruan data berhasil dilakukan.</div>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Tutup"></button>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/maplibre-gl@5.6.0/dist/maplibre-gl.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
    <script src="{{ asset('js/sphere-dashboard.js') }}"></script>

    @stack('scripts')
    <script src="{{ asset('js/sphere-sage.js') }}?v=sage-complete-3"></script>
</body>
</html>
