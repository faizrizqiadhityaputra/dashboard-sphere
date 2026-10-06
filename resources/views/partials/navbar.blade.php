<nav class="navbar navbar-expand-xl sphere-navbar sticky-top px-3" aria-label="Navigasi utama">
    <div class="container-fluid px-2 px-xl-3">
        <a href="{{ route('dashboard') }}" class="sphere-brand text-decoration-none me-3">
            <span class="brand-icon-box"><i class="bi bi-globe-asia-australia"></i><span class="brand-orbit"></span></span>
            <span class="brand-copy">
                <strong>SPHERE</strong>
                <small>Geospatial Intelligence</small>
            </span>
            <span class="brand-live d-none d-sm-inline-flex"><i></i>LIVE</span>
        </a>

        <button class="navbar-toggler sphere-menu-toggle" type="button" data-bs-toggle="collapse"
                data-bs-target="#sphereNavbarContent" aria-controls="sphereNavbarContent"
                aria-expanded="false" aria-label="Buka navigasi">
            <i class="bi bi-list"></i>
        </button>

        <div class="collapse navbar-collapse" id="sphereNavbarContent">
            <ul class="navbar-nav mx-auto mb-2 mb-xl-0 sphere-nav-menu">
                <li class="nav-item"><a class="sphere-nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}"><i class="bi bi-grid-1x2-fill"></i><span>Ringkasan</span></a></li>
                <li class="nav-item"><a class="sphere-nav-link {{ request()->routeIs('geospasial') ? 'active' : '' }}" href="{{ route('geospasial') }}"><i class="bi bi-layers"></i><span>Geospasial</span></a></li>
                <li class="nav-item"><a class="sphere-nav-link {{ request()->routeIs('lingkungan') ? 'active' : '' }}" href="{{ route('lingkungan') }}"><i class="bi bi-tree"></i><span>Lingkungan</span></a></li>
                <li class="nav-item"><a class="sphere-nav-link {{ request()->routeIs('ekonomi') ? 'active' : '' }}" href="{{ route('ekonomi') }}"><i class="bi bi-graph-up-arrow"></i><span>Ekonomi</span></a></li>
                <li class="nav-item"><a class="sphere-nav-link {{ request()->routeIs('karbon') ? 'active' : '' }}" href="{{ route('karbon') }}"><i class="bi bi-cloud-haze2"></i><span>Karbon</span></a></li>
                <li class="nav-item"><a class="sphere-nav-link {{ request()->routeIs('laporan') ? 'active' : '' }}" href="{{ route('laporan') }}"><i class="bi bi-file-earmark-bar-graph"></i><span>Laporan</span></a></li>
            </ul>

            <div class="sphere-nav-actions">
                <label class="nav-search-wrapper d-none d-xxl-flex" for="globalSearchInput">
                    <i class="bi bi-search"></i>
                    <input type="search" id="globalSearchInput" placeholder="Cari insight…" autocomplete="off">
                    <kbd>↵</kbd>
                </label>

                <div class="dropdown">
                    <button class="nav-icon-btn" type="button" id="notificationDropdown"
                            data-bs-toggle="dropdown" aria-expanded="false" title="Peringatan aktif">
                        <i class="bi bi-bell"></i><span class="badge-pill">3</span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end sphere-dropdown notification-menu p-2" aria-labelledby="notificationDropdown">
                        <div class="d-flex align-items-center justify-content-between px-2 py-2 border-bottom">
                            <strong>Aktivitas terbaru</strong><span class="badge rounded-pill text-bg-primary">3</span>
                        </div>
                        <a class="dropdown-item sphere-notification" href="{{ route('geospasial') }}"><span class="notification-icon success"><i class="bi bi-satellite"></i></span><span><strong>Raster multitemporal aktif</strong><small>NDVI, LST, dan tekanan ekologis 2023–2026.</small></span></a>
                        <a class="dropdown-item sphere-notification" href="{{ route('lingkungan') }}"><span class="notification-icon warning"><i class="bi bi-thermometer-high"></i></span><span><strong>Pemantauan LST</strong><small>Empat periode siap dibandingkan.</small></span></a>
                        <a class="dropdown-item sphere-notification" href="{{ route('laporan') }}"><span class="notification-icon info"><i class="bi bi-file-earmark-text"></i></span><span><strong>Ringkasan analisis</strong><small>Ekspor laporan siap disusun.</small></span></a>
                    </div>
                </div>

                <div class="dropdown">
                    <button class="sphere-profile-btn dropdown-toggle" type="button" id="userProfileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="profile-avatar">PK</span>
                        <span class="profile-copy d-none d-lg-flex"><strong>Pengambil Kebijakan</strong><small><i></i> Sistem aktif</small></span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end sphere-dropdown profile-menu" aria-labelledby="userProfileDropdown">
                        <li><h6 class="dropdown-header">Mode demonstrasi</h6></li>
                        <li><a class="dropdown-item" href="javascript:void(0)" onclick="window.showSphereNotification('Profil', 'Akses pengamat kebijakan wilayah Merauke.', 'info')"><i class="bi bi-person"></i> Profil</a></li>
                        <li><a class="dropdown-item" href="javascript:void(0)" onclick="window.showSphereNotification('Preferensi', 'Unit metrik dan tampilan peta aktif.', 'info')"><i class="bi bi-sliders2"></i> Preferensi</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</nav>
