@php
    $mapPrefix = $mapPrefix ?? 'dashboard';
    $mapContainerId = $mapContainerId ?? 'sphereMap';
@endphp
<section class="sphere-explorer" data-sphere-explorer data-prefix="{{ $mapPrefix }}" data-container="{{ $mapContainerId }}" aria-label="Eksplorasi peta Kabupaten Merauke">
    <header class="explorer-header">
        <div>
            <div class="sage-eyebrow">EKSPLORASI SPASIAL / MERAUKE</div>
            <h2 class="section-title">Satu wilayah. Empat tahun pengamatan.</h2>
            <p>Pahami perubahan vegetasi, suhu permukaan, dan tekanan ekologis.</p>
        </div>
        <div class="explorer-actions">
            <button type="button" class="btn btn-sm btn-outline-primary" data-action="compare" aria-pressed="false"><i class="bi bi-layout-split" aria-hidden="true"></i> Bandingkan tahun</button>
            <button type="button" class="btn btn-sm btn-outline-secondary" data-action="focus" aria-pressed="false"><i class="bi bi-arrows-fullscreen" aria-hidden="true"></i> Fokus peta</button>
        </div>
    </header>

    <div class="explorer-controls">
        <div class="map-preset-group btn-group" role="group" aria-label="Pilih indikator utama">
            <button type="button" class="btn active" data-theme="ndvi" id="{{ $mapPrefix }}PresetNdvi" aria-pressed="true"><i class="bi bi-tree" aria-hidden="true"></i> NDVI</button>
            <button type="button" class="btn" data-theme="lst" id="{{ $mapPrefix }}PresetLst" aria-pressed="false"><i class="bi bi-thermometer-half" aria-hidden="true"></i> LST</button>
            <button type="button" class="btn" data-theme="pressure" id="{{ $mapPrefix }}PresetPressure" aria-pressed="false"><i class="bi bi-activity" aria-hidden="true"></i> Tekanan ekologis</button>
        </div>
        <div class="explorer-years">
            <label for="{{ $mapPrefix }}MapYear"><span data-left-year-label>Tahun analisis</span>
                <select class="form-select form-select-sm" id="{{ $mapPrefix }}MapYear" data-control="year">
                    @foreach ([2023, 2024, 2025, 2026] as $year)
                        <option value="{{ $year }}">{{ $year }}</option>
                    @endforeach
                </select>
            </label>
            <label for="{{ $mapPrefix }}CompareYear" data-compare-only hidden>Tahun B
                <select class="form-select form-select-sm" id="{{ $mapPrefix }}CompareYear" data-control="yearB">
                    @foreach ([2023, 2024, 2025, 2026] as $year)
                        <option value="{{ $year }}" @selected($year === 2026)>{{ $year }}</option>
                    @endforeach
                </select>
            </label>
            <button type="button" class="btn btn-sm btn-outline-secondary" data-action="swap" data-compare-only hidden aria-label="Tukar tahun A dan B"><i class="bi bi-arrow-left-right" aria-hidden="true"></i></button>
        </div>
    </div>
    <p class="explorer-hint" data-compare-note hidden>Kamera kedua peta tersinkron. Gunakan indikator dan transparansi yang sama untuk membaca perubahan.</p>

    <div class="explorer-workspace">
        <details class="explorer-layer-panel" open>
            <summary><i class="bi bi-sliders2" aria-hidden="true"></i> Layer & tampilan <span aria-hidden="true">⌄</span></summary>
            <div class="explorer-layer-body">
                <p class="control-caption">LAYER ANALISIS</p>
                @foreach (['ndvi' => ['Ndvi', 'NDVI'], 'lst' => ['Lst', 'Suhu permukaan (LST)'], 'pressure' => ['Pressure', 'Tekanan ekologis']] as $key => $layer)
                    <div class="explorer-layer-row">
                        <label for="{{ $mapPrefix }}Sw{{ $layer[0] }}"><span class="layer-dot dot-{{ $key }}"></span>{{ $layer[1] }}</label>
                        <input class="form-check-input" type="checkbox" id="{{ $mapPrefix }}Sw{{ $layer[0] }}" data-control="{{ $key }}" @checked($key === 'ndvi')>
                    </div>
                @endforeach
                <p class="control-caption mt-3">PETA DASAR</p>
                <div class="explorer-layer-row"><label for="{{ $mapPrefix }}SwSatellite">Citra satelit</label><input class="form-check-input" type="checkbox" id="{{ $mapPrefix }}SwSatellite" data-control="satellite" checked></div>
                <div class="explorer-layer-row"><label for="{{ $mapPrefix }}SwAdmin">Batas administrasi</label><input class="form-check-input" type="checkbox" id="{{ $mapPrefix }}SwAdmin" data-control="admin" checked></div>
                <div class="opacity-control">
                    <label for="{{ $mapPrefix }}Opacity">Opasitas layer <output for="{{ $mapPrefix }}Opacity" data-opacity-value>82%</output></label>
                    <input class="form-range" type="range" min="0" max="100" step="1" value="82" id="{{ $mapPrefix }}Opacity" data-control="opacity" aria-describedby="{{ $mapPrefix }}OpacityHelp">
                    <small id="{{ $mapPrefix }}OpacityHelp">0% transparan · 100% paling pekat</small>
                </div>
            </div>
        </details>
        <div class="explorer-map-grid">
            <div class="explorer-pane" data-pane="A">
                <div class="pane-label">A <strong data-year-label="A">2023</strong></div>
                <div class="explorer-canvas" id="{{ $mapContainerId }}" aria-label="Peta tahun A"></div>
            </div>
            <div class="explorer-pane" data-pane="B" hidden>
                <div class="pane-label">B <strong data-year-label="B">2026</strong></div>
                <div class="explorer-canvas" id="{{ $mapContainerId }}Compare" aria-label="Peta tahun B"></div>
            </div>
        </div>
        <div class="explorer-toolbar" role="group" aria-label="Navigasi peta">
            <button type="button" data-action="zoomIn" id="{{ $mapPrefix }}ZoomIn" aria-label="Perbesar peta" title="Perbesar"><i class="bi bi-plus-lg" aria-hidden="true"></i></button>
            <button type="button" data-action="zoomOut" id="{{ $mapPrefix }}ZoomOut" aria-label="Perkecil peta" title="Perkecil"><i class="bi bi-dash-lg" aria-hidden="true"></i></button>
            <button type="button" data-action="extent" id="{{ $mapPrefix }}ResetExtent" aria-label="Zoom ke batas administrasi Merauke" title="Batas Merauke"><i class="bi bi-crosshair" aria-hidden="true"></i></button>
        </div>
    </div>

    <div class="explorer-status-bar">
        <div data-load-status role="status" aria-live="polite" aria-atomic="true">Menyiapkan peta…</div>
        <button type="button" class="btn btn-sm btn-outline-primary" data-action="retry" hidden>Coba lagi</button>
    </div>
    <p class="explorer-hint" data-map-notice role="status" hidden></p>

    <div class="explorer-reading-grid">
        <details class="explorer-legend" open>
            <summary>Legenda & satuan <span aria-hidden="true">⌄</span></summary>
            <div id="{{ $mapPrefix }}LegendContent" data-legend></div>
        </details>
        <div class="explorer-statistics">
            <div class="control-caption">RINGKASAN RASTER <span class="data-tag">Statistik tersimpan</span></div>
            <div data-statistics></div>
            <p class="explorer-hint">Rerata piksel valid pada raster asal. Bukan statistik area layar atau persentase luas terdampak.</p>
        </div>
    </div>

    <details class="explorer-about">
        <summary><i class="bi bi-info-circle" aria-hidden="true"></i> Tentang data & batas penggunaannya <span aria-hidden="true">⌄</span></summary>
        <div data-about></div>
    </details>
</section>
