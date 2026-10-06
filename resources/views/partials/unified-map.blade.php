@php
    $mapPrefix = $mapPrefix ?? 'dashboard';
    $mapContainerId = $mapContainerId ?? 'sphereMap';
    $mapWrapperId = $mapPrefix . 'MapWrapper';
@endphp

<!-- Komponen peta tunggal: dipakai Dashboard dan Geospasial -->
<div class="unified-map-header d-flex flex-wrap align-items-center justify-content-between">
    <div>
        <div class="d-flex flex-wrap align-items-center gap-2">
            <span class="badge bg-primary text-white" style="font-size:.68rem;letter-spacing:.04em;">INTELIJEN GEOSPASIAL</span>
            <h2 class="section-title m-0" style="font-size:.95rem;">Pemantauan Geospasial Multitemporal</h2>
            <span class="text-muted" style="font-size:.78rem;">Kabupaten Merauke • 2023–2026</span>
        </div>
        <div class="text-muted mt-1" style="font-size:.72rem;">
            Perbandingan NDVI, suhu permukaan (LST), dan tekanan ekologis dalam satu batas administrasi.
        </div>
    </div>

    <div class="btn-group btn-group-sm map-preset-group mt-2 mt-lg-0" role="group" aria-label="Preset layer tematik">
        <button type="button" class="btn btn-outline-success active" id="{{ $mapPrefix }}PresetNdvi">
            <i class="bi bi-tree me-1"></i>NDVI
        </button>
        <button type="button" class="btn btn-outline-warning" id="{{ $mapPrefix }}PresetLst">
            <i class="bi bi-thermometer-high me-1"></i>LST
        </button>
        <button type="button" class="btn btn-outline-danger" id="{{ $mapPrefix }}PresetPressure">
            <i class="bi bi-exclamation-triangle me-1"></i>Tekanan Ekologis
        </button>
    </div>
</div>

<div class="map-wrapper sphere-map-frame flex-grow-1 position-relative" id="{{ $mapWrapperId }}">
    <div id="{{ $mapContainerId }}" style="position:absolute;inset:0;width:100%;height:100%;z-index:1;"></div>

    <div class="map-layer-panel glass-map-panel">
        <div class="d-flex align-items-center justify-content-between mb-2 pb-1 border-bottom">
            <span class="fw-bold text-dark" style="font-size:.76rem;text-transform:uppercase;letter-spacing:.04em;">
                <i class="bi bi-layers text-primary me-1"></i>Lapisan Peta
            </span>
            <span class="badge bg-primary-subtle text-primary" id="{{ $mapPrefix }}MapYearBadge">2023</span>
        </div>

        <label for="{{ $mapPrefix }}MapYear" class="form-label text-muted mb-1" style="font-size:.7rem;">Tahun analisis</label>
        <select class="form-select form-select-sm mb-2" id="{{ $mapPrefix }}MapYear">
            <option value="2023" selected>2023</option>
            <option value="2024">2024</option>
            <option value="2025">2025</option>
            <option value="2026">2026</option>
        </select>

        <div class="form-check form-switch mb-1 d-flex align-items-center justify-content-between ps-0">
            <label class="form-check-label text-dark" for="{{ $mapPrefix }}SwSatellite" style="font-size:.75rem;">Basemap Satelit</label>
            <input class="form-check-input ms-auto" type="checkbox" role="switch" id="{{ $mapPrefix }}SwSatellite" checked>
        </div>
        <div class="form-check form-switch mb-1 d-flex align-items-center justify-content-between ps-0">
            <label class="form-check-label text-success" for="{{ $mapPrefix }}SwNdvi" style="font-size:.75rem;">
                <span class="status-dot me-1" style="background:#22c55e;"></span>NDVI
            </label>
            <input class="form-check-input ms-auto" type="checkbox" role="switch" id="{{ $mapPrefix }}SwNdvi" checked>
        </div>
        <div class="form-check form-switch mb-1 d-flex align-items-center justify-content-between ps-0">
            <label class="form-check-label" for="{{ $mapPrefix }}SwLst" style="font-size:.75rem;color:#b45309;">
                <span class="status-dot me-1" style="background:#f59e0b;"></span>Suhu Permukaan (LST)
            </label>
            <input class="form-check-input ms-auto" type="checkbox" role="switch" id="{{ $mapPrefix }}SwLst">
        </div>
        <div class="form-check form-switch mb-1 d-flex align-items-center justify-content-between ps-0">
            <label class="form-check-label text-danger" for="{{ $mapPrefix }}SwPressure" style="font-size:.75rem;">
                <span class="status-dot me-1" style="background:#ef4444;"></span>Tekanan Ekologis
            </label>
            <input class="form-check-input ms-auto" type="checkbox" role="switch" id="{{ $mapPrefix }}SwPressure">
        </div>
        <div class="form-check form-switch d-flex align-items-center justify-content-between ps-0">
            <label class="form-check-label text-primary" for="{{ $mapPrefix }}SwAdmin" style="font-size:.75rem;">
                <span class="status-dot me-1" style="background:#38bdf8;"></span>Batas Administrasi Merauke
            </label>
            <input class="form-check-input ms-auto" type="checkbox" role="switch" id="{{ $mapPrefix }}SwAdmin" checked>
        </div>
    </div>

    <div class="map-toolbar glass-map-toolbar">
        <button type="button" class="btn btn-light btn-sm rounded-0 border-bottom p-2" id="{{ $mapPrefix }}ZoomIn" title="Perbesar"><i class="bi bi-plus-lg"></i></button>
        <button type="button" class="btn btn-light btn-sm rounded-0 border-bottom p-2" id="{{ $mapPrefix }}ZoomOut" title="Perkecil"><i class="bi bi-dash-lg"></i></button>
        <button type="button" class="btn btn-light btn-sm rounded-0 border-bottom p-2" id="{{ $mapPrefix }}ResetExtent" title="Zoom ke batas administrasi"><i class="bi bi-crosshair"></i></button>
        <button type="button" class="btn btn-light btn-sm rounded-0 p-2" id="{{ $mapPrefix }}ToggleLegend" title="Tampilkan/sembunyikan legenda"><i class="bi bi-list-task"></i></button>
    </div>

    <div class="map-legend glass-dark-panel" id="{{ $mapPrefix }}LegendBox">
        <div class="fw-bold mb-1 text-uppercase">Legenda <span id="{{ $mapPrefix }}LegendYear">2023</span></div>
        <div id="{{ $mapPrefix }}LegendContent">NDVI: rendah hingga tinggi</div>
    </div>

    <div class="map-stats-overlay glass-dark-panel">
        <div class="text-white-50 text-uppercase fw-semibold mb-1" style="font-size:.65rem;letter-spacing:.05em;">Ringkasan Tahun <span id="{{ $mapPrefix }}StatsYear">2023</span></div>
        <div class="d-flex align-items-center gap-3">
            <div>
                <div class="text-white-50" style="font-size:.68rem;">Rerata NDVI</div>
                <div class="fw-bold text-success" id="{{ $mapPrefix }}MetricNdvi">0,644</div>
            </div>
            <div class="border-start border-secondary ps-3">
                <div class="text-white-50" style="font-size:.68rem;">Rerata LST</div>
                <div class="fw-bold text-warning" id="{{ $mapPrefix }}MetricLst">28,6°C</div>
            </div>
            <div class="border-start border-secondary ps-3">
                <div class="text-white-50" style="font-size:.68rem;">Tekanan Ekologis</div>
                <div class="fw-bold text-danger" id="{{ $mapPrefix }}MetricPressure">38%</div>
            </div>
        </div>
    </div>
</div>

<div class="map-data-status d-flex flex-wrap align-items-center gap-3">
    <span class="d-flex align-items-center gap-1 text-muted"><span class="status-dot bg-success"></span>MapLibre aktif</span>
    <span class="d-flex align-items-center gap-1 text-muted"><span class="status-dot bg-primary"></span>Periode 2023–2026</span>
    <span class="d-flex align-items-center gap-1 text-muted"><span class="status-dot bg-success"></span>NDVI 2023–2026 asli</span>
    <span class="d-flex align-items-center gap-1 text-muted"><span class="status-dot bg-warning"></span>LST dan tekanan ekologis masih simulasi</span>
    <span class="d-flex align-items-center gap-1 text-muted"><span class="status-dot bg-info"></span>Batas Administrasi Merauke</span>
</div>
