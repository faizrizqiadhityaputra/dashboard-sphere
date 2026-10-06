@extends('layouts.sphere')

@section('title', 'SPHERE — Ringkasan Pemantauan Merauke')
@section('body_class', 'sphere-app sphere-page-dashboard sphere-summary-page')
@section('meta_description', 'Ringkasan terpadu data geospasial, lingkungan, karbon, dan ekonomi Kabupaten Merauke periode 2023–2026.')

@push('styles')
<link href="{{ asset('css/sphere-summary.css') }}?v=20260920-2" rel="stylesheet">
@endpush

@section('content')
<div class="summary-shell">
    <section class="summary-hero">
        <div class="summary-hero-copy">
            <div class="summary-eyebrow"><i class="bi bi-grid-1x2-fill"></i> EXECUTIVE OVERVIEW</div>
            <div class="summary-title-row">
                <h1>Ringkasan Pemantauan Merauke</h1>
                <span class="summary-live is-provisional"><i></i> 2026 provisional</span>
            </div>
            <p>Ikhtisar terpadu indikator geospasial, lingkungan, karbon, dan ekonomi berdasarkan data periode 2023–2026.</p>
            <div class="summary-system-name">SPHERE — <em>Spatial Policy &amp; Health Evaluation for Regional Emissions</em></div>
            <div class="summary-meta">
                <span><i class="bi bi-calendar3"></i> Periode 2023–2026</span>
                <span><i class="bi bi-geo-alt"></i> Kabupaten Merauke</span>
                <span><i class="bi bi-clock-history"></i> Diperbarui 20 September 2026</span>
            </div>
        </div>
        <div class="summary-hero-actions">
            <a href="{{ route('laporan') }}" class="summary-btn summary-btn-primary"><i class="bi bi-download"></i><span><small>Pusat data</small>Unduh laporan</span></a>
            <a href="{{ route('geospasial') }}" class="summary-btn summary-btn-secondary"><i class="bi bi-map"></i><span><small>Eksplorasi</small>Buka geospasial</span></a>
        </div>
    </section>

    <div class="summary-provisional-note">
        <i class="bi bi-hourglass-split"></i>
        <span><strong>Status data 2026:</strong> provisional, memakai komposit Juni–September 2026 dan cakupan September belum lengkap.</span>
    </div>

    <section class="summary-kpi-grid" aria-label="Indikator utama tahun 2026">
        <article class="summary-kpi kpi-carbon">
            <div class="summary-kpi-top"><span>Emisi karbon 2026</span><i class="bi bi-cloud-haze2"></i></div>
            <strong>130,65 <small>MtCO₂e</small></strong>
            <div class="summary-kpi-foot"><span class="trend-up"><i class="bi bi-arrow-up-right"></i> 88,3%</span><span>dari 2025</span></div>
        </article>
        <article class="summary-kpi kpi-area">
            <div class="summary-kpi-top"><span>Luas skenario 2026</span><i class="bi bi-bounding-box-circles"></i></div>
            <strong>954.325,95 <small>ha</small></strong>
            <div class="summary-kpi-foot"><span>Faktor emisi</span><span>136,9 MgCO₂e/ha</span></div>
        </article>
        <article class="summary-kpi kpi-production">
            <div class="summary-kpi-top"><span>Potensi produksi</span><i class="bi bi-box-seam"></i></div>
            <strong>5,44 <small>juta ton</small></strong>
            <div class="summary-kpi-foot"><span>Nilai bruto</span><span>Rp35,36 triliun</span></div>
        </article>
        <article class="summary-kpi kpi-value">
            <div class="summary-kpi-top"><span>Nilai ekonomi karbon</span><i class="bi bi-cash-coin"></i></div>
            <strong>US$261,3–522,6 <small>juta</small></strong>
            <div class="summary-kpi-foot"><span>Skenario harga</span><span>US$2–4/MgCO₂e</span></div>
        </article>
        <article class="summary-kpi kpi-lst">
            <div class="summary-kpi-top"><span>Rerata LST 2026</span><i class="bi bi-thermometer-sun"></i></div>
            <strong id="summaryLstValue">26,14 <small>°C</small></strong>
            <div class="summary-kpi-foot"><span>Rentang raster</span><span id="summaryLstRange">23,42–32,38°C</span></div>
        </article>
        <article class="summary-kpi kpi-pressure">
            <div class="summary-kpi-top"><span>Tekanan ekologis</span><i class="bi bi-tree"></i></div>
            <strong id="summaryPressureValue">0,195 <small>indeks</small></strong>
            <div class="summary-kpi-foot"><span class="trend-down"><i class="bi bi-arrow-down-right"></i> 10,8%</span><span>dari 2025</span></div>
        </article>
    </section>

    <section class="summary-main-grid">
        <article class="summary-panel summary-map-panel">
            <div class="summary-panel-heading">
                <div><span class="summary-section-label">INTELIJEN GEOSPASIAL</span><h2>Pemantauan multitemporal</h2><p>NDVI, suhu permukaan, dan tekanan ekologis di dalam batas administrasi.</p></div>
                <a href="{{ route('geospasial') }}">Lihat layar penuh <i class="bi bi-arrow-up-right"></i></a>
            </div>
            <div class="summary-map-wrap">
                @include('partials.unified-map-modern', ['mapPrefix' => 'dashboard', 'mapContainerId' => 'sphereMap'])
            </div>
        </article>

        <aside class="summary-insights">
            <div class="summary-panel-heading compact"><div><span class="summary-section-label">SOROTAN 2026</span><h2>Temuan utama</h2></div></div>
            <article class="insight-card insight-danger">
                <div class="insight-icon"><i class="bi bi-graph-up-arrow"></i></div>
                <div><span>KARBON</span><strong>Lonjakan emisi paling besar</strong><p>Emisi naik 88,3% dibandingkan 2025, mengikuti perluasan skenario menjadi 954.325,95 ha.</p><a href="{{ route('karbon') }}">Buka analisis karbon <i class="bi bi-arrow-right"></i></a></div>
            </article>
            <article class="insight-card insight-blue">
                <div class="insight-icon"><i class="bi bi-pie-chart"></i></div>
                <div><span>PERBANDINGAN NASIONAL</span><strong>Setara 3,6–5,5% secara ilustratif</strong><p>Skenario emisi 2023 dibandingkan dengan rentang emisi nasional 800 juta–1,2 miliar ton CO₂e. Nilai ini bukan kontribusi emisi aktual Merauke.</p></div>
            </article>
            <article class="insight-card insight-gold">
                <div class="insight-icon"><i class="bi bi-bar-chart"></i></div>
                <div><span>EKONOMI</span><strong>Potensi bruto Rp35,36 triliun</strong><p>Produksi 2026 diperkirakan mencapai 5,44 juta ton dengan asumsi produktivitas 5,7 ton/ha.</p><a href="{{ route('ekonomi') }}">Buka analisis ekonomi <i class="bi bi-arrow-right"></i></a></div>
            </article>
            <article class="insight-card insight-green">
                <div class="insight-icon"><i class="bi bi-leaf"></i></div>
                <div><span>LINGKUNGAN</span><strong>Tekanan rerata menurun</strong><p>Indeks tekanan ekologis turun dari 0,219 pada 2025 menjadi 0,195 pada 2026.</p><a href="{{ route('lingkungan') }}">Buka statistik lingkungan <i class="bi bi-arrow-right"></i></a></div>
            </article>
            <div class="summary-method-note"><i class="bi bi-info-circle"></i><p><strong>Catatan data</strong> Nilai karbon dan produksi merupakan estimasi skenario. Statistik LST dan tekanan ekologis dibaca dari raster proyek.</p></div>
        </aside>
    </section>

    <section class="summary-panel summary-social-panel">
        <div class="summary-panel-heading">
            <div><span class="summary-section-label">KONTEKS SOSIAL-EKONOMI</span><h2>Profil wilayah Kabupaten Merauke</h2><p>Indikator konteks wilayah, bukan ukuran dampak kausal Food Estate.</p></div>
            <span class="summary-period-badge">BPS 2025</span>
        </div>
        <div class="summary-social-grid">
            <article><i class="bi bi-people"></i><div><span>Pekerja sektor pertanian</span><strong>33,91 ribu</strong><small>dari 102,04 ribu penduduk bekerja</small></div></article>
            <article><i class="bi bi-person-workspace"></i><div><span>TPAK</span><strong>66,50%</strong><small>Sakernas Agustus 2025</small></div></article>
            <article><i class="bi bi-briefcase"></i><div><span>TPT</span><strong>4,35%</strong><small>Sakernas Agustus 2025</small></div></article>
            <article><i class="bi bi-house-heart"></i><div><span>Penduduk miskin</span><strong>27,72 ribu</strong><small>11,31% • Maret 2025</small></div></article>
        </div>
    </section>

    <section class="summary-chart-grid">
        <article class="summary-panel chart-panel">
            <div class="summary-panel-heading">
                <div><span class="summary-section-label">TREN AKTUAL</span><h2>Karbon dan nilai bruto produksi</h2><p>Perbandingan tahunan memakai empat tahun data yang tersedia.</p></div>
                <span class="summary-period-badge">2023–2026</span>
            </div>
            <div class="summary-chart"><canvas id="summaryCarbonEconomyChart"></canvas></div>
        </article>
        <article class="summary-panel chart-panel">
            <div class="summary-panel-heading">
                <div><span class="summary-section-label">BIOFISIK</span><h2>LST dan tekanan ekologis</h2><p>Rerata tahunan berdasarkan statistik GeoTIFF.</p></div>
                <span class="summary-data-state" id="summaryEnvironmentStatus"><i></i> Memuat data</span>
            </div>
            <div class="summary-chart"><canvas id="summaryEnvironmentChart"></canvas></div>
        </article>
    </section>

    <section class="summary-source-strip">
        <div><i class="bi bi-database-check"></i><span><strong>12 raster tematik</strong>NDVI, LST, dan tekanan • 2023–2026</span></div>
        <div><i class="bi bi-map"></i><span><strong>1 batas administrasi</strong>GeoJSON Kabupaten Merauke</span></div>
        <div><i class="bi bi-file-earmark-text"></i><span><strong>3 kelompok analisis</strong>Lingkungan, karbon, dan ekonomi</span></div>
        <a href="{{ route('laporan') }}">Buka pusat laporan <i class="bi bi-arrow-right"></i></a>
    </section>
</div>
@endsection

@push('scripts')
@include('partials.map-scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    if (typeof Chart === 'undefined') return;
    const years = ['2023', '2024', '2025', '2026'];
    const commonLegend = { position: 'bottom', labels: { usePointStyle: true, pointStyle: 'circle', boxWidth: 7, boxHeight: 7, padding: 18, color: '#64736b' } };
    const carbonCanvas = document.getElementById('summaryCarbonEconomyChart');
    if (carbonCanvas) {
        new Chart(carbonCanvas, {
            data: { labels: years, datasets: [
                { type: 'bar', label: 'Emisi (MtCO₂e)', yAxisID: 'y', data: [43.60, 61.83, 69.38, 130.65], backgroundColor: ['#dbeae1', '#a9cfb8', '#72ae89', '#237451'], borderRadius: 8, maxBarThickness: 44 },
                { type: 'line', label: 'Nilai bruto produksi (Rp triliun)', yAxisID: 'y1', data: [11.80, 16.73, 18.78, 35.36], borderColor: '#d99a2b', backgroundColor: '#d99a2b', pointBackgroundColor: '#fff', pointBorderWidth: 3, pointRadius: 4, borderWidth: 2.5, tension: .28 }
            ] },
            options: { responsive: true, maintainAspectRatio: false, interaction: { mode: 'index', intersect: false }, plugins: { legend: commonLegend, tooltip: { backgroundColor: '#173426', padding: 11 } }, scales: {
                x: { grid: { display: false }, border: { display: false }, ticks: { color: '#687970', font: { weight: '600' } } },
                y: { beginAtZero: true, position: 'left', grid: { color: 'rgba(45,80,60,.08)' }, border: { display: false }, ticks: { color: '#687970' }, title: { display: true, text: 'MtCO₂e', color: '#687970' } },
                y1: { beginAtZero: true, position: 'right', grid: { drawOnChartArea: false }, border: { display: false }, ticks: { color: '#a46f16' }, title: { display: true, text: 'Rp triliun', color: '#a46f16' } }
            } }
        });
    }

    const paperEnvironment = {
        '2023': { lst: { mean: 27.72143 }, pressure: { mean: .293 } },
        '2024': { lst: { mean: 26.37318 }, pressure: { mean: .247 } },
        '2025': { lst: { mean: 25.83567 }, pressure: { mean: .219 } },
        '2026': { lst: { mean: 26.14196, min: 23.424, max: 32.376 }, pressure: { mean: .195 } }
    };
    function drawEnvironmentChart(data, isLive) {
        const canvas = document.getElementById('summaryEnvironmentChart');
        const status = document.getElementById('summaryEnvironmentStatus');
        if (status) { status.classList.toggle('is-fallback', !isLive); status.innerHTML = '<i></i>' + (isLive ? ' Acuan full paper' : ' Data cadangan'); }
        const current = data['2026'] || paperEnvironment['2026'];
        const lstValue = document.getElementById('summaryLstValue');
        const lstRange = document.getElementById('summaryLstRange');
        const pressureValue = document.getElementById('summaryPressureValue');
        if (lstValue && current.lst) lstValue.innerHTML = Number(current.lst.mean).toLocaleString('id-ID', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + ' <small>°C</small>';
        if (lstRange && current.lst && current.lst.min != null) lstRange.textContent = Number(current.lst.min).toLocaleString('id-ID', { maximumFractionDigits: 2 }) + '–' + Number(current.lst.max).toLocaleString('id-ID', { maximumFractionDigits: 2 }) + '°C';
        if (pressureValue && current.pressure) pressureValue.innerHTML = Number(current.pressure.mean).toLocaleString('id-ID', { minimumFractionDigits: 3, maximumFractionDigits: 3 }) + ' <small>indeks</small>';
        if (!canvas) return;
        new Chart(canvas, {
            type: 'line', data: { labels: years, datasets: [
                { label: 'Rerata LST (°C)', yAxisID: 'y', data: years.map(year => data[year]?.lst?.mean ?? null), borderColor: '#e18a28', backgroundColor: 'rgba(225,138,40,.09)', fill: true, borderWidth: 2.5, pointRadius: 4, tension: .3 },
                { label: 'Tekanan ekologis', yAxisID: 'y1', data: years.map(year => data[year]?.pressure?.mean ?? null), borderColor: '#27855a', backgroundColor: '#27855a', borderWidth: 2.5, pointRadius: 4, tension: .3 }
            ] },
            options: { responsive: true, maintainAspectRatio: false, interaction: { mode: 'index', intersect: false }, plugins: { legend: commonLegend, tooltip: { backgroundColor: '#173426', padding: 11 } }, scales: {
                x: { grid: { display: false }, border: { display: false }, ticks: { color: '#687970', font: { weight: '600' } } },
                y: { position: 'left', grid: { color: 'rgba(45,80,60,.08)' }, border: { display: false }, ticks: { color: '#a46f16' }, title: { display: true, text: '°C', color: '#a46f16' } },
                y1: { position: 'right', suggestedMin: 0, suggestedMax: .4, grid: { drawOnChartArea: false }, border: { display: false }, ticks: { color: '#27855a' }, title: { display: true, text: 'Indeks', color: '#27855a' } }
            } }
        });
    }
    drawEnvironmentChart(paperEnvironment, true);
});
</script>
@endpush
