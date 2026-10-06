@extends('layouts.sphere')

@section('title', 'SPHERE — Estimasi Emisi Karbon 2023–2026')
@section('body_class', 'sphere-app sphere-page-karbon')
@section('meta_description', 'SPHERE - Estimasi emisi karbon berdasarkan luas kelas PSN Kabupaten Merauke tahun 2023–2026.')

@push('styles')
<link href="{{ asset('css/sphere-carbon.css') }}?v=carbon-actual-2026-2" rel="stylesheet">
@endpush

@section('content')
<section class="context-subheader carbon-page-hero">
    <div class="container-fluid px-4">
        <div class="row align-items-center gy-3">
            <div class="col-12 col-lg-8">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-sphere m-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Ringkasan</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Karbon</li>
                    </ol>
                </nav>
                <div class="carbon-eyebrow mt-2">EMISI KARBON / KELAS PSN</div>
                <h1 class="page-title m-0">Estimasi Emisi Karbon 2023–2026</h1>
                <div class="page-subtitle">Perubahan prakiraan luas kelas PSN dan estimasi emisi menggunakan faktor 136,9 MgCO₂e per hektare.</div>
            </div>
            <div class="col-12 col-lg-4">
                <div class="d-flex flex-wrap justify-content-lg-end gap-2">
                    <span class="carbon-data-chip"><i class="bi bi-calendar-range"></i> 4 tahun data</span>
                    <span class="carbon-data-chip"><i class="bi bi-database-check"></i> 2023–2026</span>
                    <button class="btn btn-sm btn-outline-primary btn-export-trigger" data-format="Tabel Emisi Karbon CSV">
                        <i class="bi bi-download me-1"></i>Unduh data
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

<main class="container-fluid px-4 py-3 carbon-actual-dashboard" aria-labelledby="carbonMainTitle">
    <section class="carbon-disclosure">
        <i class="bi bi-info-circle"></i>
        <div>
            <strong>Estimasi berbasis luas kelas PSN</strong>
            <span>Nilai bukan hasil pengukuran emisi langsung, kuota FOLU, ataupun inventarisasi emisi terverifikasi.</span>
        </div>
    </section>

    <section class="row g-3 mt-0" aria-label="Ringkasan emisi karbon">
        <div class="col-6 col-xl-3">
            <article class="card carbon-kpi-card h-100">
                <div class="carbon-kpi-icon icon-emission"><i class="bi bi-cloud-haze2"></i></div>
                <div class="metric-label">Emisi 2026</div>
                <div class="carbon-kpi-value">130,65 <small>MtCO₂e</small></div>
                <p>130.647.222 MgCO₂e</p>
            </article>
        </div>
        <div class="col-6 col-xl-3">
            <article class="card carbon-kpi-card h-100">
                <div class="carbon-kpi-icon icon-area"><i class="bi bi-bounding-box-circles"></i></div>
                <div class="metric-label">Luas PSN 2026</div>
                <div class="carbon-kpi-value">954.325,95 <small>ha</small></div>
                <p>Luas skenario terbesar</p>
            </article>
        </div>
        <div class="col-6 col-xl-3">
            <article class="card carbon-kpi-card h-100">
                <div class="carbon-kpi-icon icon-change"><i class="bi bi-arrow-up-right"></i></div>
                <div class="metric-label">Perubahan 2025–2026</div>
                <div class="carbon-kpi-value text-danger">+88,3 <small>%</small></div>
                <p>Kenaikan estimasi tahunan</p>
            </article>
        </div>
        <div class="col-6 col-xl-3">
            <article class="card carbon-kpi-card h-100">
                <div class="carbon-kpi-icon icon-peak"><i class="bi bi-bar-chart-line"></i></div>
                <div class="metric-label">Emisi Tertinggi</div>
                <div class="carbon-kpi-value">130,65 <small>MtCO₂e</small></div>
                <p>Tercatat pada tahun 2026</p>
            </article>
        </div>
    </section>

    <section class="row g-3 mt-0">
        <div class="col-12 col-xl-8">
            <article class="card carbon-panel h-100">
                <header class="carbon-panel-header">
                    <div>
                        <span class="carbon-overline">TREN TAHUNAN</span>
                        <h2 id="carbonMainTitle">Luas kelas PSN dan emisi karbon</h2>
                        <p>Batang menunjukkan emisi dalam MtCO₂e; garis menunjukkan luas dalam ribu hektare.</p>
                    </div>
                    <span class="carbon-period-badge"><i class="bi bi-activity"></i> Data 2023–2026</span>
                </header>
                <div class="carbon-chart-shell">
                    <canvas id="carbonActualChart" aria-label="Grafik luas kelas PSN dan emisi karbon tahun 2023 sampai 2026"></canvas>
                </div>
                <div class="carbon-chart-caption">
                    <i class="bi bi-lightbulb"></i>
                    <span>Emisi mencapai puncak pada 2026. Nilainya meningkat 88,3% dari 2025 seiring luas skenario naik menjadi 954.325,95 ha.</span>
                </div>
            </article>
        </div>

        <div class="col-12 col-xl-4">
            <article class="card carbon-panel h-100">
                <header class="carbon-panel-header compact">
                    <div>
                        <span class="carbon-overline">NILAI TAHUNAN</span>
                        <h2>Tabel estimasi emisi</h2>
                        <p>Format angka mengikuti penulisan Indonesia.</p>
                    </div>
                </header>
                <div class="table-responsive carbon-table-wrap">
                    <table class="table carbon-actual-table align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Tahun</th>
                                <th class="text-end">Luas PSN <small>ha</small></th>
                                <th class="text-end">Emisi <small>MgCO₂e</small></th>
                            </tr>
                        </thead>
                        <tbody id="carbonActualTableBody"></tbody>
                    </table>
                </div>

                <div class="carbon-factor-box">
                    <span class="carbon-factor-icon"><i class="bi bi-calculator"></i></span>
                    <div>
                        <small>Faktor estimasi</small>
                        <strong>136,9 MgCO₂e/ha</strong>
                        <p>Emisi = luas kelas PSN × faktor emisi</p>
                    </div>
                </div>
            </article>
        </div>
    </section>

    <section class="row g-3 mt-0">
        <div class="col-12 col-lg-4">
            <article class="carbon-insight h-100">
                <span>01</span>
                <div><strong>Emisi meningkat 199,6% selama 2023–2026</strong><p>Estimasi bertambah dari 43,60 menjadi 130,65 MtCO₂e.</p></div>
            </article>
        </div>
        <div class="col-12 col-lg-4">
            <article class="carbon-insight h-100">
                <span>02</span>
                <div><strong>2026 mengalami kenaikan tajam</strong><p>Nilai emisi meningkat 88,3% dibandingkan data tahun 2025.</p></div>
            </article>
        </div>
        <div class="col-12 col-lg-4">
            <article class="carbon-insight h-100">
                <span>03</span>
                <div><strong>Luas dan emisi bersifat linear</strong><p>Perubahan luas menghasilkan perubahan emisi proporsional karena faktor emisi dibuat konstan.</p></div>
            </article>
        </div>
    </section>

    <details class="carbon-methodology mt-3">
        <summary><i class="bi bi-journal-text"></i> Metode, satuan, dan batas interpretasi <span>⌄</span></summary>
        <div class="carbon-methodology-body">
            <div><strong>Data luas</strong><p>2023: 318.485,38 ha; 2024: 451.613,10 ha; 2025: 506.787,87 ha; 2026: 954.325,95 ha.</p></div>
            <div><strong>Data emisi</strong><p>2023: 43.600.649; 2024: 61.825.833; 2025: 69.379.259; 2026: 130.647.222 MgCO₂e.</p></div>
            <div><strong>Konversi</strong><p>Satu MtCO₂e setara dengan 1.000.000 MgCO₂e.</p></div>
            <div><strong>Batas penggunaan</strong><p>Hasil merupakan estimasi skenario berbasis luas dan belum menggantikan inventarisasi GRK yang terverifikasi.</p></div>
        </div>
    </details>
</main>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    'use strict';

    const carbonData = Object.freeze([
        Object.freeze({ year: 2023, areaHa: 318485.38, emissionMg: 43600649 }),
        Object.freeze({ year: 2024, areaHa: 451613.10, emissionMg: 61825833 }),
        Object.freeze({ year: 2025, areaHa: 506787.87, emissionMg: 69379259 }),
        Object.freeze({ year: 2026, areaHa: 954325.95, emissionMg: 130647222 })
    ]);

    const numberID = new Intl.NumberFormat('id-ID', { maximumFractionDigits: 0 });
    const decimal2ID = new Intl.NumberFormat('id-ID', { minimumFractionDigits: 2, maximumFractionDigits: 2 });

    const tableBody = document.getElementById('carbonActualTableBody');
    if (tableBody) {
        tableBody.innerHTML = carbonData.map(function (item) {
            const peakLabel = item.year === 2026 ? '<span class="carbon-peak-label">Tertinggi</span>' : '';
            return '<tr' + (item.year === 2026 ? ' class="carbon-peak-row"' : '') + '>' +
                '<th scope="row"><span class="carbon-year-badge">' + item.year + '</span></th>' +
                '<td class="text-end">' + decimal2ID.format(item.areaHa) + '</td>' +
                '<td class="text-end"><strong>' + numberID.format(item.emissionMg) + '</strong>' + peakLabel + '</td>' +
            '</tr>';
        }).join('');
    }

    const canvas = document.getElementById('carbonActualChart');
    if (!canvas || typeof Chart === 'undefined') return;

    window.sphereCarbonActualChart = new Chart(canvas.getContext('2d'), {
        data: {
            labels: carbonData.map(item => String(item.year)),
            datasets: [
                {
                    type: 'bar',
                    label: 'Emisi (MtCO₂e)',
                    data: carbonData.map(item => item.emissionMg / 1000000),
                    backgroundColor: carbonData.map(item => item.year === 2026 ? '#237451' : '#8dc9a1'),
                    hoverBackgroundColor: '#195c3f',
                    borderRadius: 7,
                    borderSkipped: false,
                    maxBarThickness: 64,
                    yAxisID: 'yEmission'
                },
                {
                    type: 'line',
                    label: 'Luas PSN (ribu ha)',
                    data: carbonData.map(item => item.areaHa / 1000),
                    borderColor: '#d09a45',
                    backgroundColor: '#d09a45',
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: '#b67c22',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    borderWidth: 2.2,
                    tension: 0.25,
                    yAxisID: 'yArea'
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: { mode: 'index', intersect: false },
            plugins: {
                legend: { position: 'bottom', labels: { usePointStyle: true, pointStyle: 'circle', padding: 20 } },
                tooltip: {
                    backgroundColor: '#20352a',
                    padding: 12,
                    callbacks: {
                        afterBody: function (items) {
                            const row = carbonData[items[0].dataIndex];
                            return [
                                'Luas: ' + decimal2ID.format(row.areaHa) + ' ha',
                                'Emisi: ' + numberID.format(row.emissionMg) + ' MgCO₂e'
                            ];
                        }
                    }
                }
            },
            scales: {
                x: { grid: { display: false }, border: { display: false } },
                yEmission: {
                    beginAtZero: true,
                    position: 'left',
                    suggestedMax: 150,
                    title: { display: true, text: 'Emisi (MtCO₂e)' },
                    grid: { color: 'rgba(50, 80, 62, .08)' }
                },
                yArea: {
                    beginAtZero: true,
                    position: 'right',
                    suggestedMax: 1100,
                    title: { display: true, text: 'Luas PSN (ribu ha)' },
                    grid: { drawOnChartArea: false }
                }
            }
        }
    });
});
</script>
@endpush

