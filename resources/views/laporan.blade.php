@extends('layouts.sphere')

@section('title', 'SPHERE — Pusat Laporan dan Data')
@section('body_class', 'sphere-app sphere-page-laporan sphere-report-page')
@section('meta_description', 'Pusat laporan, dataset, dan ekspor data SPHERE Merauke periode 2023–2026.')

@push('styles')
<link href="{{ asset('css/sphere-reports.css') }}?v=20260920" rel="stylesheet">
@endpush

@section('content')
<div class="report-shell">
    <section class="report-hero">
        <div class="report-hero-copy">
            <div class="report-eyebrow"><i class="bi bi-stars"></i> PUSAT DOKUMEN SPHERE</div>
            <h1>Laporan dan ekspor data</h1>
            <p>Satu pintu untuk mengunduh temuan karbon, ekonomi, lingkungan, dan data geospasial Merauke periode 2023–2026.</p>
            <div class="report-chips">
                <span><i class="bi bi-calendar3"></i> 2023–2026</span>
                <span><i class="bi bi-patch-check-fill"></i> Data tersinkron</span>
            </div>
        </div>
        <button type="button" class="report-primary report-download" data-download="all">
            <span class="report-primary-icon"><i class="bi bi-file-earmark-zip"></i></span>
            <span><small>Paket lengkap</small>Unduh semua data</span>
            <i class="bi bi-arrow-down-circle"></i>
        </button>
    </section>

    <section class="report-status" aria-label="Status dataset">
        <span class="report-pulse"></span>
        <strong>Dataset aktif</strong>
        <span>12 raster tematik • 4 tahun observasi • 1 batas administrasi</span>
        <span class="report-status-date">Pembaruan 20 September 2026</span>
    </section>

    <section class="report-kpis" aria-label="Ringkasan data 2026">
        <article class="report-kpi report-kpi-red">
            <div class="report-kpi-icon"><i class="bi bi-cloud-haze2"></i></div>
            <div><span>Emisi karbon 2026</span><strong>130,65 MtCO₂e</strong><small>+88,3% dari 2025</small></div>
        </article>
        <article class="report-kpi report-kpi-green">
            <div class="report-kpi-icon"><i class="bi bi-bounding-box-circles"></i></div>
            <div><span>Luas skenario 2026</span><strong>954.325,95 ha</strong><small>Estimasi spasial PSN</small></div>
        </article>
        <article class="report-kpi report-kpi-blue">
            <div class="report-kpi-icon"><i class="bi bi-box-seam"></i></div>
            <div><span>Potensi produksi</span><strong>5,44 juta ton</strong><small>Nilai bruto Rp35,36 T</small></div>
        </article>
        <article class="report-kpi report-kpi-gold">
            <div class="report-kpi-icon"><i class="bi bi-cash-coin"></i></div>
            <div><span>Nilai ekonomi karbon</span><strong>US$261,3–522,6 jt</strong><small>Skenario US$2–4/MgCO₂e</small></div>
        </article>
    </section>

    <div class="report-section-heading">
        <div><span>KOLEKSI DATA</span><h2>Pilih laporan yang dibutuhkan</h2></div>
        <p>PDF untuk dibaca, CSV/GeoJSON untuk dianalisis kembali.</p>
    </div>

    <section class="report-grid">
        <article class="report-card report-card-featured">
            <div class="report-card-top">
                <div class="report-card-icon"><i class="bi bi-file-earmark-bar-graph"></i></div>
                <span class="report-card-badge">Rekomendasi</span>
            </div>
            <h3>Ringkasan Eksekutif</h3>
            <p>Sintesis indikator utama karbon, ekonomi, produksi, lingkungan, dan implikasi kebijakan periode 2023–2026.</p>
            <div class="report-card-meta"><span><i class="bi bi-layers"></i> Lintas sektor</span><span>Versi 2.0</span></div>
            <div class="report-actions">
                <button class="report-download" data-download="executive-pdf"><i class="bi bi-file-earmark-pdf"></i> PDF</button>
                <button class="report-download" data-download="executive-csv"><i class="bi bi-filetype-csv"></i> CSV</button>
            </div>
        </article>

        <article class="report-card report-card-carbon">
            <div class="report-card-top"><div class="report-card-icon"><i class="bi bi-clouds"></i></div><span class="report-card-badge">4 tahun</span></div>
            <h3>Karbon dan Emisi</h3>
            <p>Deret emisi aktual 2023–2026, luas skenario, perubahan tahunan, dan valuasi ekonomi karbon.</p>
            <div class="report-card-meta"><span><i class="bi bi-graph-up-arrow"></i> 130,65 MtCO₂e</span><span>2026</span></div>
            <div class="report-actions">
                <button class="report-download" data-download="carbon-pdf"><i class="bi bi-file-earmark-pdf"></i> PDF</button>
                <button class="report-download" data-download="carbon-csv"><i class="bi bi-filetype-csv"></i> CSV</button>
            </div>
        </article>

        <article class="report-card report-card-economy">
            <div class="report-card-top"><div class="report-card-icon"><i class="bi bi-bar-chart-line"></i></div><span class="report-card-badge">Valuasi</span></div>
            <h3>Ekonomi dan Produksi</h3>
            <p>Skenario produksi 2023–2026, nilai bruto produksi, dan rentang nilai ekonomi karbon.</p>
            <div class="report-card-meta"><span><i class="bi bi-currency-exchange"></i> Rp35,36 triliun</span><span>2026</span></div>
            <div class="report-actions">
                <button class="report-download" data-download="economy-pdf"><i class="bi bi-file-earmark-pdf"></i> PDF</button>
                <button class="report-download" data-download="economy-csv"><i class="bi bi-filetype-csv"></i> CSV</button>
            </div>
        </article>

        <article class="report-card report-card-environment">
            <div class="report-card-top"><div class="report-card-icon"><i class="bi bi-tree"></i></div><span class="report-card-badge">Raster aktual</span></div>
            <h3>Lingkungan dan Biofisik</h3>
            <p>Statistik NDVI, suhu permukaan, dan tekanan ekologis yang dibaca dari hasil pengolahan GeoTIFF.</p>
            <div class="report-card-meta"><span><i class="bi bi-grid-3x3"></i> 12 layer</span><span>Dinamis</span></div>
            <div class="report-actions">
                <button class="report-download" data-download="environment-pdf"><i class="bi bi-file-earmark-pdf"></i> PDF</button>
                <button class="report-download" data-download="environment-csv"><i class="bi bi-filetype-csv"></i> CSV</button>
            </div>
        </article>

        <article class="report-card report-card-spatial">
            <div class="report-card-top"><div class="report-card-icon"><i class="bi bi-map"></i></div><span class="report-card-badge">GeoJSON</span></div>
            <h3>Analisis Geospasial</h3>
            <p>Batas administrasi kajian dan ringkasan ketersediaan layer NDVI, LST, serta tekanan ekologis.</p>
            <div class="report-card-meta"><span><i class="bi bi-geo-alt"></i> Kabupaten Merauke</span><span>EPSG:4326</span></div>
            <div class="report-actions">
                <button class="report-download" data-download="spatial-pdf"><i class="bi bi-file-earmark-pdf"></i> PDF</button>
                <button class="report-download" data-download="geojson"><i class="bi bi-braces"></i> GeoJSON</button>
            </div>
        </article>

        <article class="report-card report-card-catalog">
            <div class="report-card-top"><div class="report-card-icon"><i class="bi bi-database"></i></div><span class="report-card-badge">Katalog teknis</span></div>
            <h3>Manifest Raster dan Tile</h3>
            <p>Daftar lokasi file sumber dan pola URL tile untuk membantu audit atau pengembangan lanjutan.</p>
            <div class="report-card-meta"><span><i class="bi bi-filetype-tiff"></i> NDVI • LST • Tekanan</span><span>CSV</span></div>
            <div class="report-actions report-actions-single">
                <button class="report-download" data-download="manifest-csv"><i class="bi bi-download"></i> Unduh manifest</button>
            </div>
        </article>
    </section>

    <section class="report-note">
        <div class="report-note-icon"><i class="bi bi-info-circle"></i></div>
        <div><strong>Catatan metodologi</strong><p>Angka karbon memakai faktor 136,9 MgCO₂e/ha. Nilai ekonomi memakai skenario US$2–4/MgCO₂e. Produksi memakai produktivitas 5,7 ton/ha dan harga Rp6.500/kg. Statistik lingkungan mengikuti berkas <code>environment-stats.json</code> hasil pengolahan raster.</p></div>
    </section>
</div>
@endsection

@push('scripts')
<script>
window.SPHERE_REPORT_CONFIG = {
    environmentUrl: @json(asset('data/environment-stats.json')),
    administrationUrl: @json(asset('data/merauke.geojson'))
};
</script>
<script src="https://cdn.jsdelivr.net/npm/jspdf@2.5.2/dist/jspdf.umd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jszip@3.10.1/dist/jszip.min.js"></script>
<script src="{{ asset('js/sphere-reports.js') }}?v=20260920"></script>
@endpush
