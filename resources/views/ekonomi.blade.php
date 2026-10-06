@extends('layouts.sphere')

@section('title', 'SPHERE — Nilai Ekonomi Karbon 2023–2026')
@section('body_class', 'sphere-app sphere-page-ekonomi')
@section('meta_description', 'SPHERE - Estimasi nilai ekonomi karbon Kabupaten Merauke tahun 2023–2026 berdasarkan skenario harga US$2–US$4 per MgCO₂e.')

@push('styles')
<link href="{{ asset('css/sphere-economy.css') }}?v=economy-carbon-1" rel="stylesheet">
@endpush

@section('content')
<section class="context-subheader economy-page-hero">
    <div class="container-fluid px-4">
        <div class="row align-items-center gy-3">
            <div class="col-12 col-lg-8">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-sphere m-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Ringkasan</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Ekonomi</li>
                    </ol>
                </nav>
                <div class="economy-eyebrow mt-2">VALUASI EKONOMI KARBON</div>
                <h1 class="page-title m-0">Nilai Ekonomi Karbon 2023–2026</h1>
                <div class="page-subtitle">
                    Estimasi nilai potensial emisi karbon menggunakan skenario harga US$2–US$4 per MgCO₂e.
                </div>
            </div>
            <div class="col-12 col-lg-4">
                <div class="d-flex flex-wrap justify-content-lg-end gap-2">
                    <span class="economy-data-chip"><i class="bi bi-calendar-range"></i> 4 tahun data</span>
                    <span class="economy-data-chip"><i class="bi bi-cash-coin"></i> US$2–US$4/MgCO₂e</span>
                    <button class="btn btn-sm btn-outline-primary btn-export-trigger" data-format="Tabel Nilai Ekonomi Karbon CSV">
                        <i class="bi bi-download me-1"></i>Unduh data
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

<main class="container-fluid px-4 py-3 economy-carbon-dashboard" aria-labelledby="economyMainTitle">
    <section class="economy-disclosure" aria-label="Keterangan valuasi">
        <i class="bi bi-info-circle"></i>
        <div>
            <strong>Nilai ekonomi potensial, bukan pendapatan aktual</strong>
            <span>Rentang dihitung dari emisi tahunan dikalikan harga karbon US$2 dan US$4 per MgCO₂e.</span>
        </div>
    </section>

    <section class="row g-3 mt-0" aria-label="Ringkasan nilai ekonomi karbon">
        <div class="col-6 col-xl-3">
            <article class="card economy-kpi-card h-100">
                <div class="economy-kpi-icon icon-current"><i class="bi bi-wallet2"></i></div>
                <div class="metric-label">Nilai Ekonomi 2026</div>
                <div class="economy-kpi-value">US$261,3–522,6 <small>juta</small></div>
                <p>Berdasarkan emisi 130.647.222 MgCO₂e</p>
            </article>
        </div>
        <div class="col-6 col-xl-3">
            <article class="card economy-kpi-card h-100">
                <div class="economy-kpi-icon icon-peak"><i class="bi bi-graph-up-arrow"></i></div>
                <div class="metric-label">Nilai Tertinggi</div>
                <div class="economy-kpi-value">US$261,3–522,6 <small>juta</small></div>
                <p>Tercatat pada tahun 2026</p>
            </article>
        </div>
        <div class="col-6 col-xl-3">
            <article class="card economy-kpi-card h-100">
                <div class="economy-kpi-icon icon-change"><i class="bi bi-arrow-down-right"></i></div>
                <div class="metric-label">Perubahan 2025–2026</div>
                <div class="economy-kpi-value text-danger">+88,3 <small>%</small></div>
                <p>Kenaikan nilai pada kedua skenario</p>
            </article>
        </div>
        <div class="col-6 col-xl-3">
            <article class="card economy-kpi-card h-100">
                <div class="economy-kpi-icon icon-price"><i class="bi bi-tags"></i></div>
                <div class="metric-label">Skenario Harga</div>
                <div class="economy-kpi-value">US$2–US$4 <small>/MgCO₂e</small></div>
                <p>Batas bawah dan batas atas valuasi</p>
            </article>
        </div>
    </section>

    <section class="row g-3 mt-0" aria-label="Potensi produksi dan nilai bruto produksi">
        <div class="col-12 col-xl-7">
            <article class="card economy-panel h-100">
                <header class="economy-panel-header compact">
                    <div>
                        <span class="economy-overline">SKENARIO PRODUKSI</span>
                        <h2>Potensi produksi dan nilai bruto</h2>
                        <p>Perbandingan potensi produksi dan nilai bruto berdasarkan luas skenario tahunan.</p>
                    </div>
                    <span class="economy-period-badge"><i class="bi bi-graph-up-arrow"></i> 2023–2026</span>
                </header>
                <div class="economy-chart-shell production-chart-shell">
                    <canvas id="productionEconomyChart" aria-label="Grafik potensi produksi dan nilai bruto tahun 2023 sampai 2026"></canvas>
                </div>
                <div class="economy-chart-caption">
                    <i class="bi bi-lightbulb"></i>
                    <span>Tahun 2026 menjadi skenario terbesar dengan potensi produksi 5,44 juta ton dan nilai bruto Rp35,36 triliun.</span>
                </div>
            </article>
        </div>

        <div class="col-12 col-xl-5">
            <article class="card economy-panel h-100">
                <header class="economy-panel-header compact">
                    <div>
                        <span class="economy-overline">DATA PRODUKSI</span>
                        <h2>Rincian skenario tahunan</h2>
                        <p>Nilai bruto menggunakan estimasi Rp6.500 per kilogram.</p>
                    </div>
                </header>
                <div class="table-responsive economy-table-wrap">
                    <table class="table economy-actual-table align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Tahun</th>
                                <th class="text-end">Luas <small>ha</small></th>
                                <th class="text-end">Produksi <small>ton</small></th>
                                <th class="text-end">Nilai bruto</th>
                            </tr>
                        </thead>
                        <tbody id="productionEconomyTableBody"></tbody>
                    </table>
                </div>
            </article>
        </div>
    </section>

    <section class="row g-3 mt-0">
        <div class="col-12 col-xl-8">
            <article class="card economy-panel h-100">
                <header class="economy-panel-header">
                    <div>
                        <span class="economy-overline">PERBANDINGAN TAHUNAN</span>
                        <h2 id="economyMainTitle">Rentang nilai ekonomi karbon</h2>
                        <p>Perbandingan nilai pada skenario harga US$2 dan US$4 per MgCO₂e.</p>
                    </div>
                    <span class="economy-period-badge"><i class="bi bi-bar-chart"></i> 2023–2026</span>
                </header>
                <div class="economy-chart-shell">
                    <canvas id="carbonEconomyChart" aria-label="Grafik nilai ekonomi karbon tahun 2023 sampai 2026"></canvas>
                </div>
                <div class="economy-chart-caption">
                    <i class="bi bi-lightbulb"></i>
                    <span>Nilai tertinggi terjadi pada 2026. Rentangnya mencapai US$261,3–522,6 juta seiring kenaikan estimasi emisi menjadi 130,65 juta MgCO₂e.</span>
                </div>
            </article>
        </div>

        <div class="col-12 col-xl-4">
            <article class="card economy-panel h-100">
                <header class="economy-panel-header compact">
                    <div>
                        <span class="economy-overline">SKENARIO HARGA</span>
                        <h2>Cara membaca nilai</h2>
                        <p>Tiga sudut pandang untuk setiap tahun analisis.</p>
                    </div>
                </header>

                <div class="price-scenario-list">
                    <div class="price-scenario-item low">
                        <span class="scenario-icon"><i class="bi bi-arrow-down"></i></span>
                        <div><small>Batas bawah</small><strong>US$2/MgCO₂e</strong><p>Skenario valuasi konservatif</p></div>
                    </div>
                    <div class="price-scenario-item middle">
                        <span class="scenario-icon"><i class="bi bi-dash"></i></span>
                        <div><small>Nilai tengah</small><strong>US$3/MgCO₂e</strong><p>Referensi tengah rentang analisis</p></div>
                    </div>
                    <div class="price-scenario-item high">
                        <span class="scenario-icon"><i class="bi bi-arrow-up"></i></span>
                        <div><small>Batas atas</small><strong>US$4/MgCO₂e</strong><p>Skenario valuasi optimistis</p></div>
                    </div>
                </div>

                <div class="economy-formula-box">
                    <div><i class="bi bi-calculator"></i></div>
                    <div>
                        <strong>Rumus valuasi</strong>
                        <p>Nilai ekonomi = emisi × harga karbon</p>
                        <small>Contoh 2026: 130.647.222 × US$2–US$4 = US$261,3–522,6 juta.</small>
                    </div>
                </div>
            </article>
        </div>
    </section>

    <section class="row g-3 mt-0">
        <div class="col-12">
            <article class="card economy-panel">
                <header class="economy-panel-header compact">
                    <div>
                        <span class="economy-overline">DATA RINCI</span>
                        <h2>Tabel nilai ekonomi karbon</h2>
                        <p>Nilai moneter ditampilkan dalam juta dolar Amerika Serikat.</p>
                    </div>
                    <span class="economy-unit-badge">juta US$</span>
                </header>

                <div class="table-responsive economy-table-wrap">
                    <table class="table economy-actual-table align-middle mb-0">
                        <caption class="visually-hidden">Nilai ekonomi karbon tahun 2023 sampai 2026</caption>
                        <thead>
                            <tr>
                                <th scope="col">Tahun</th>
                                <th scope="col" class="text-end">Emisi <small>MgCO₂e</small></th>
                                <th scope="col" class="text-end">US$2 <small>juta US$</small></th>
                                <th scope="col" class="text-end">US$3 <small>juta US$</small></th>
                                <th scope="col" class="text-end">US$4 <small>juta US$</small></th>
                                <th scope="col" class="text-end">Rentang Nilai Ekonomi</th>
                            </tr>
                        </thead>
                        <tbody id="carbonEconomyTableBody"></tbody>
                    </table>
                </div>
            </article>
        </div>
    </section>

    <section class="row g-3 mt-0">
        <div class="col-12 col-lg-4">
            <article class="economy-insight h-100">
                <span>01</span>
                <div><strong>Nilai meningkat 199,6% selama 2023–2026</strong><p>Kenaikan mengikuti pertambahan estimasi emisi dari 43,60 menjadi 130,65 juta MgCO₂e.</p></div>
            </article>
        </div>
        <div class="col-12 col-lg-4">
            <article class="economy-insight h-100">
                <span>02</span>
                <div><strong>Nilai 2026 menjadi yang tertinggi</strong><p>Rentang naik menjadi US$261,3–522,6 juta atau 88,3% di atas nilai tahun 2025.</p></div>
            </article>
        </div>
        <div class="col-12 col-lg-4">
            <article class="economy-insight h-100">
                <span>03</span>
                <div><strong>Nilai ekonomi bergerak linear</strong><p>Harga karbon dibuat tetap, sehingga perubahan nilai mengikuti perubahan emisi.</p></div>
            </article>
        </div>
    </section>

    <details class="economy-methodology mt-3">
        <summary><i class="bi bi-journal-text"></i> Metode dan batas interpretasi <span>⌄</span></summary>
        <div class="economy-methodology-body">
            <div><strong>Data masukan</strong><p>Estimasi emisi 2023–2026: 43.600.649; 61.825.833; 69.379.259; dan 130.647.222 MgCO₂e.</p></div>
            <div><strong>Skenario harga</strong><p>Batas bawah memakai US$2, nilai tengah US$3, dan batas atas US$4 per MgCO₂e.</p></div>
            <div><strong>Konversi satuan</strong><p>Hasil dalam dolar dibagi 1.000.000 agar ditampilkan sebagai juta US$.</p></div>
            <div><strong>Batas penggunaan</strong><p>Nilai merupakan estimasi potensi ekonomi, bukan transaksi, penerimaan, atau harga pasar karbon yang telah diverifikasi.</p></div>
        </div>
    </details>
</main>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    'use strict';

    const economyData = Object.freeze([
        Object.freeze({ year: 2023, emissionMg: 43600649 }),
        Object.freeze({ year: 2024, emissionMg: 61825833 }),
        Object.freeze({ year: 2025, emissionMg: 69379259 }),
        Object.freeze({ year: 2026, emissionMg: 130647222 })
    ].map(function (item) {
        return Object.freeze({
            year: item.year,
            emissionMg: item.emissionMg,
            valueLow: item.emissionMg * 2 / 1000000,
            valueMid: item.emissionMg * 3 / 1000000,
            valueHigh: item.emissionMg * 4 / 1000000
        });
    }));

    const numberID = new Intl.NumberFormat('id-ID', { maximumFractionDigits: 0 });
    const decimalID = new Intl.NumberFormat('id-ID', { minimumFractionDigits: 1, maximumFractionDigits: 1 });
    const decimal2ID = new Intl.NumberFormat('id-ID', { minimumFractionDigits: 2, maximumFractionDigits: 2 });

    const productionData = Object.freeze([
        Object.freeze({ year: 2023, areaHa: 318485.38, productionTon: 1815366.67, grossTrillion: 11.80 }),
        Object.freeze({ year: 2024, areaHa: 451613.10, productionTon: 2574194.67, grossTrillion: 16.73 }),
        Object.freeze({ year: 2025, areaHa: 506787.87, productionTon: 2888690.86, grossTrillion: 18.78 }),
        Object.freeze({ year: 2026, areaHa: 954325.95, productionTon: 5439657.92, grossTrillion: 35.36 })
    ]);

    const tableBody = document.getElementById('carbonEconomyTableBody');
    if (tableBody) {
        tableBody.innerHTML = economyData.map(function (item) {
            const peakLabel = item.year === 2026 ? '<span class="economy-peak-label">Tertinggi</span>' : '';
            return '<tr' + (item.year === 2026 ? ' class="economy-peak-row"' : '') + '>' +
                '<th scope="row"><span class="economy-year-badge">' + item.year + '</span></th>' +
                '<td class="text-end">' + numberID.format(item.emissionMg) + '</td>' +
                '<td class="text-end">' + decimalID.format(item.valueLow) + '</td>' +
                '<td class="text-end">' + decimalID.format(item.valueMid) + '</td>' +
                '<td class="text-end">' + decimalID.format(item.valueHigh) + '</td>' +
                '<td class="text-end"><strong>US$' + decimalID.format(item.valueLow) + '–' + decimalID.format(item.valueHigh) + ' juta</strong>' + peakLabel + '</td>' +
            '</tr>';
        }).join('');
    }

    const productionTableBody = document.getElementById('productionEconomyTableBody');
    if (productionTableBody) {
        productionTableBody.innerHTML = productionData.map(function (item) {
            const peakLabel = item.year === 2026 ? '<span class="economy-peak-label">Tertinggi</span>' : '';
            return '<tr' + (item.year === 2026 ? ' class="economy-peak-row"' : '') + '>' +
                '<th scope="row"><span class="economy-year-badge">' + item.year + '</span></th>' +
                '<td class="text-end">' + decimal2ID.format(item.areaHa) + '</td>' +
                '<td class="text-end">' + decimal2ID.format(item.productionTon) + '</td>' +
                '<td class="text-end"><strong>Rp' + decimal2ID.format(item.grossTrillion) + ' T</strong>' + peakLabel + '</td>' +
            '</tr>';
        }).join('');
    }

    const productionCanvas = document.getElementById('productionEconomyChart');
    if (productionCanvas && typeof Chart !== 'undefined') {
        window.sphereProductionEconomyChart = new Chart(productionCanvas.getContext('2d'), {
            data: {
                labels: productionData.map(item => String(item.year)),
                datasets: [
                    {
                        type: 'bar',
                        label: 'Potensi produksi (juta ton)',
                        data: productionData.map(item => item.productionTon / 1000000),
                        backgroundColor: '#6fae83',
                        hoverBackgroundColor: '#4f9368',
                        borderRadius: 7,
                        borderSkipped: false,
                        yAxisID: 'yProduction'
                    },
                    {
                        type: 'line',
                        label: 'Nilai bruto (Rp triliun)',
                        data: productionData.map(item => item.grossTrillion),
                        borderColor: '#d09a45',
                        backgroundColor: '#d09a45',
                        pointBackgroundColor: '#ffffff',
                        pointBorderColor: '#b67c22',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        borderWidth: 2.2,
                        tension: 0.25,
                        yAxisID: 'yGross'
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: { mode: 'index', intersect: false },
                plugins: {
                    legend: { position: 'bottom', labels: { usePointStyle: true, padding: 18 } },
                    tooltip: {
                        callbacks: {
                            afterBody: function (items) {
                                const row = productionData[items[0].dataIndex];
                                return 'Luas skenario: ' + decimal2ID.format(row.areaHa) + ' ha';
                            }
                        }
                    }
                },
                scales: {
                    x: { grid: { display: false }, border: { display: false } },
                    yProduction: {
                        beginAtZero: true,
                        position: 'left',
                        title: { display: true, text: 'Produksi (juta ton)' },
                        grid: { color: 'rgba(50, 80, 62, .08)' }
                    },
                    yGross: {
                        beginAtZero: true,
                        position: 'right',
                        title: { display: true, text: 'Nilai bruto (Rp triliun)' },
                        grid: { drawOnChartArea: false }
                    }
                }
            }
        });
    }

    const canvas = document.getElementById('carbonEconomyChart');
    if (!canvas || typeof Chart === 'undefined') return;

    window.sphereCarbonEconomyChart = new Chart(canvas.getContext('2d'), {
        type: 'bar',
        data: {
            labels: economyData.map(item => String(item.year)),
            datasets: [
                {
                    label: 'Skenario US$2',
                    data: economyData.map(item => item.valueLow),
                    backgroundColor: '#9bc9ab',
                    hoverBackgroundColor: '#7eb793',
                    borderRadius: 7,
                    borderSkipped: false,
                    maxBarThickness: 56
                },
                {
                    label: 'Skenario US$4',
                    data: economyData.map(item => item.valueHigh),
                    backgroundColor: '#237451',
                    hoverBackgroundColor: '#195c3f',
                    borderRadius: 7,
                    borderSkipped: false,
                    maxBarThickness: 56
                },
                {
                    type: 'line',
                    label: 'Nilai tengah US$3',
                    data: economyData.map(item => item.valueMid),
                    borderColor: '#d09a45',
                    backgroundColor: '#d09a45',
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: '#b67c22',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    borderWidth: 2.2,
                    tension: 0.25
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: { mode: 'index', intersect: false },
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: { usePointStyle: true, pointStyle: 'circle', boxWidth: 7, boxHeight: 7, padding: 20 }
                },
                tooltip: {
                    backgroundColor: '#20352a',
                    padding: 12,
                    callbacks: {
                        label: function (context) {
                            return ' ' + context.dataset.label + ': US$' + decimalID.format(context.raw) + ' juta';
                        },
                        afterBody: function (items) {
                            const row = economyData[items[0].dataIndex];
                            return 'Emisi: ' + numberID.format(row.emissionMg) + ' MgCO₂e';
                        }
                    }
                }
            },
            scales: {
                x: {
                    grid: { display: false },
                    border: { display: false },
                    ticks: { color: '#64736b', font: { weight: '600' } }
                },
                y: {
                    beginAtZero: true,
                    suggestedMax: 600,
                    border: { display: false },
                    grid: { color: 'rgba(50, 80, 62, .08)' },
                    title: { display: true, text: 'Nilai ekonomi (juta US$)', color: '#64736b' },
                    ticks: { color: '#64736b', callback: value => 'US$' + value + ' jt' }
                }
            }
        }
    });
});
</script>
@endpush


