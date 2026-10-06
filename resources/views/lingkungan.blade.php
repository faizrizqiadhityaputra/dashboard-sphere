@extends('layouts.sphere')

@section('title', 'SPHERE — Pemantauan Lingkungan 2023–2026')
@section('body_class', 'sphere-app sphere-page-lingkungan')
@section('meta_description', 'SPHERE - Statistik multitemporal NDVI, suhu permukaan lahan, dan tekanan ekologis Kabupaten Merauke tahun 2023–2026.')

@push('styles')
<link href="{{ asset('css/sphere-environment.css') }}?v=environment-actual-1" rel="stylesheet">
@endpush

@section('content')
<section class="context-subheader environment-page-hero">
    <div class="container-fluid px-4">
        <div class="row align-items-center gy-3">
            <div class="col-12 col-lg-8">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-sphere m-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Ringkasan</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Lingkungan</li>
                    </ol>
                </nav>
                <div class="environment-eyebrow mt-2">ANALISIS MULTITEMPORAL</div>
                <h1 class="page-title m-0">Kondisi Lingkungan 2023–2026</h1>
                <div class="page-subtitle">Ringkasan statistik raster NDVI, suhu permukaan lahan, dan tekanan ekologis dalam batas administrasi Merauke.</div>
            </div>
            <div class="col-12 col-lg-4">
                <div class="d-flex flex-wrap justify-content-lg-end gap-2">
                    <label class="environment-year-control" for="environmentYearSelect">
                        <span>Tahun aktif</span>
                        <select id="environmentYearSelect" aria-label="Pilih tahun analisis">
                            <option value="2023">2023</option>
                            <option value="2024">2024</option>
                            <option value="2025">2025</option>
                            <option value="2026" selected>2026</option>
                        </select>
                    </label>
                    <button class="btn btn-sm btn-outline-primary btn-export-trigger" data-format="Ringkasan Lingkungan CSV"><i class="bi bi-download me-1"></i>Unduh data</button>
                </div>
            </div>
        </div>
    </div>
</section>

<main class="container-fluid px-4 py-3 environment-dashboard" aria-labelledby="environmentMainTitle">
    <section class="environment-disclosure" id="environmentDataStatus" aria-live="polite">
        <i class="bi bi-database-check"></i>
        <div><strong>Memuat statistik raster…</strong><span>Data dibaca dari hasil pengolahan GeoTIFF proyek.</span></div>
    </section>

    <section class="row g-3 mt-0" aria-label="Indikator lingkungan tahun aktif">
        <div class="col-6 col-xl">
            <article class="card environment-kpi-card h-100">
                <div class="environment-kpi-icon icon-ndvi"><i class="bi bi-tree"></i></div>
                <div class="metric-label">Rerata NDVI <span class="active-year-label">2026</span></div>
                <div class="environment-kpi-value" id="metricNdviMean">—</div>
                <p id="metricNdviRange">Menunggu statistik raster</p>
            </article>
        </div>
        <div class="col-6 col-xl">
            <article class="card environment-kpi-card h-100">
                <div class="environment-kpi-icon icon-lst"><i class="bi bi-thermometer-half"></i></div>
                <div class="metric-label">Rerata LST <span class="active-year-label">2026</span></div>
                <div class="environment-kpi-value" id="metricLstMean">—</div>
                <p id="metricLstRange">Menunggu statistik raster</p>
            </article>
        </div>
        <div class="col-6 col-xl">
            <article class="card environment-kpi-card h-100">
                <div class="environment-kpi-icon icon-pressure"><i class="bi bi-speedometer2"></i></div>
                <div class="metric-label">Rerata Tekanan <span class="active-year-label">2026</span></div>
                <div class="environment-kpi-value" id="metricPressureMean">—</div>
                <p id="metricPressureRange">Menunggu statistik raster</p>
            </article>
        </div>
        <div class="col-6 col-xl">
            <article class="card environment-kpi-card h-100">
                <div class="environment-kpi-icon icon-change"><i class="bi bi-arrow-left-right"></i></div>
                <div class="metric-label">Perubahan LST dari 2023</div>
                <div class="environment-kpi-value" id="metricLstChange">—</div>
                <p>Selisih rerata terhadap baseline 2023</p>
            </article>
        </div>
        <div class="col-6 col-xl">
            <article class="card environment-kpi-card h-100">
                <div class="environment-kpi-icon icon-status"><i class="bi bi-shield-check"></i></div>
                <div class="metric-label">Kelas Mean Tekanan</div>
                <div class="environment-kpi-value status-value" id="metricPressureClass">—</div>
                <p>Klasifikasi berdasarkan rerata indeks 0–1</p>
            </article>
        </div>
    </section>

    <section class="row g-3 mt-0">
        <div class="col-12 col-xl-6">
            <article class="card environment-panel h-100">
                <header class="environment-panel-header">
                    <div><span class="environment-overline">KONDISI VEGETASI</span><h2 id="environmentMainTitle">Tren NDVI 2023–2026</h2><p>Nilai minimum, rata-rata, dan maksimum pada wilayah kajian.</p></div>
                    <span class="environment-unit-badge">Indeks −1 hingga 1</span>
                </header>
                <div class="environment-chart-shell"><canvas id="ndviEnvironmentChart" aria-label="Grafik NDVI 2023 sampai 2026"></canvas></div>
                <div class="environment-chart-caption"><i class="bi bi-info-circle"></i><span>NDVI merepresentasikan kehijauan vegetasi dan tidak digunakan sebagai pengganti langsung kelas tutupan hutan.</span></div>
            </article>
        </div>
        <div class="col-12 col-xl-6">
            <article class="card environment-panel h-100">
                <header class="environment-panel-header">
                    <div><span class="environment-overline">SUHU PERMUKAAN</span><h2>Tren LST 2023–2026</h2><p>Perbandingan suhu minimum, rata-rata, dan maksimum tahunan.</p></div>
                    <span class="environment-unit-badge">Derajat Celsius</span>
                </header>
                <div class="environment-chart-shell"><canvas id="lstEnvironmentChart" aria-label="Grafik LST 2023 sampai 2026"></canvas></div>
                <div class="environment-chart-caption"><i class="bi bi-info-circle"></i><span>Grafik menggunakan ringkasan raster tahunan; tidak ditafsirkan sebagai variasi suhu bulanan.</span></div>
            </article>
        </div>
    </section>

    <section class="row g-3 mt-0">
        <div class="col-12 col-xl-7">
            <article class="card environment-panel h-100">
                <header class="environment-panel-header">
                    <div><span class="environment-overline">INDEKS KOMPOSIT</span><h2>Tren Tekanan Ekologis</h2><p>Perubahan statistik indeks tekanan ekologis tahun 2023–2026.</p></div>
                    <span class="environment-unit-badge">Indeks 0–1</span>
                </header>
                <div class="environment-chart-shell pressure-chart"><canvas id="pressureEnvironmentChart" aria-label="Grafik tekanan ekologis 2023 sampai 2026"></canvas></div>
            </article>
        </div>
        <div class="col-12 col-xl-5">
            <article class="card environment-panel h-100">
                <header class="environment-panel-header compact"><div><span class="environment-overline">INTERPRETASI</span><h2>Kelas rerata tekanan</h2><p>Kategori untuk membaca nilai rata-rata wilayah.</p></div></header>
                <div class="pressure-class-list">
                    <div><span style="--class-color:#55a66d"></span><strong>Sangat rendah</strong><small>0,00–0,20</small></div>
                    <div><span style="--class-color:#9bc34a"></span><strong>Rendah</strong><small>&gt;0,20–0,40</small></div>
                    <div><span style="--class-color:#e4be3f"></span><strong>Sedang</strong><small>&gt;0,40–0,60</small></div>
                    <div><span style="--class-color:#e48635"></span><strong>Tinggi</strong><small>&gt;0,60–0,80</small></div>
                    <div><span style="--class-color:#cf4b4b"></span><strong>Sangat tinggi</strong><small>&gt;0,80–1,00</small></div>
                </div>
                <div class="environment-caution"><i class="bi bi-exclamation-circle"></i><span>Kelas rerata tidak menggantikan analisis piksel. Nilai maksimum dapat menunjukkan lokasi bertekanan tinggi meskipun rerata wilayah rendah.</span></div>
            </article>
        </div>
    </section>

    <section class="row g-3 mt-0">
        <div class="col-12">
            <article class="card environment-panel">
                <header class="environment-panel-header compact">
                    <div><span class="environment-overline">STATISTIK TAHUNAN</span><h2>Tabel kondisi lingkungan</h2><p>Ringkasan statistik band pertama setiap GeoTIFF setelah pemotongan batas administrasi.</p></div>
                    <span class="environment-unit-badge">2023–2026</span>
                </header>
                <div class="table-responsive environment-table-wrap">
                    <table class="table environment-actual-table align-middle mb-0">
                        <caption class="visually-hidden">Statistik NDVI, LST, dan tekanan ekologis tahun 2023 sampai 2026</caption>
                        <thead><tr><th>Tahun</th><th class="text-end">Mean NDVI</th><th class="text-end">Min–Maks NDVI</th><th class="text-end">Mean LST</th><th class="text-end">Min–Maks LST</th><th class="text-end">Mean Tekanan</th><th class="text-end">Min–Maks Tekanan</th><th>Status mean</th></tr></thead>
                        <tbody id="environmentTableBody"></tbody>
                    </table>
                </div>
            </article>
        </div>
    </section>

    <details class="environment-methodology mt-3">
        <summary><i class="bi bi-journal-text"></i> Sumber statistik dan batas interpretasi <span>⌄</span></summary>
        <div class="environment-methodology-body">
            <div><strong>Sumber nilai</strong><p>Statistik dihitung otomatis dari band pertama GeoTIFF NDVI, LST, dan Tekanan Ekologis pada folder data proyek.</p></div>
            <div><strong>Wilayah analisis</strong><p>Raster yang digunakan harus sudah dipotong mengikuti batas administrasi Merauke dan mempunyai NoData yang benar.</p></div>
            <div><strong>Konsistensi waktu</strong><p>Grafik membandingkan ringkasan tahunan 2023–2026. Periode akuisisi citra tiap tahun perlu dicantumkan dalam naskah LKTI.</p></div>
            <div><strong>Batas penggunaan</strong><p>Nilai merupakan statistik deskriptif raster. Hubungan sebab-akibat memerlukan analisis dan variabel pendukung tambahan.</p></div>
        </div>
    </details>
</main>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    'use strict';

    const STATS_URL = @json(asset('data/environment-stats.json'));
    const YEARS = ['2023', '2024', '2025', '2026'];
    const FALLBACK = {
        generatedAt: null,
        mode: 'fallback',
        years: {
            '2023': { ndvi:{min:-1,mean:0.6435125733,max:0.9722566009}, lst:{min:23.1283333333,mean:27.7152538348,max:35.2725}, pressure:{min:0,mean:0.2930457467,max:0.9457083344} },
            '2024': { ndvi:null, lst:{min:22.678,mean:26.3673124656,max:31.764}, pressure:{min:0,mean:0.2469921361,max:0.8881999850} },
            '2025': { ndvi:null, lst:{min:22.5133333333,mean:25.8310861556,max:30.9625}, pressure:{min:0,mean:0.2185568408,max:0.8481249809} },
            '2026': { ndvi:null, lst:{min:23.4241666667,mean:26.1371729839,max:32.3763636364}, pressure:{min:0,mean:0.1949003502,max:0.8798809648} }
        }
    };

    const format = (value, digits = 3) => Number.isFinite(Number(value)) ? Number(value).toLocaleString('id-ID', { minimumFractionDigits: digits, maximumFractionDigits: digits }) : '—';
    const valueOf = (data, year, metric, property) => data?.years?.[year]?.[metric]?.[property] ?? null;
    const series = (data, metric, property) => YEARS.map(year => valueOf(data, year, metric, property));
    const pressureClass = value => {
        if (!Number.isFinite(Number(value))) return { label:'Belum tersedia', className:'unknown' };
        if (value <= .2) return { label:'Sangat rendah', className:'very-low' };
        if (value <= .4) return { label:'Rendah', className:'low' };
        if (value <= .6) return { label:'Sedang', className:'medium' };
        if (value <= .8) return { label:'Tinggi', className:'high' };
        return { label:'Sangat tinggi', className:'very-high' };
    };

    let charts = [];
    let environmentData = FALLBACK;

    function setStatus(data, loaded) {
        const box = document.getElementById('environmentDataStatus');
        if (!box) return;
        if (loaded) {
            const generated = data.generatedAt ? new Date(data.generatedAt).toLocaleString('id-ID') : 'waktu tidak tercatat';
            box.classList.remove('is-warning');
            box.innerHTML = '<i class="bi bi-database-check"></i><div><strong>Statistik GeoTIFF aktif</strong><span>Dibuat otomatis dari data proyek • ' + generated + '</span></div>';
        } else {
            box.classList.add('is-warning');
            box.innerHTML = '<i class="bi bi-exclamation-triangle"></i><div><strong>File statistik otomatis belum ditemukan</strong><span>LST dan tekanan memakai hasil pemeriksaan sebelumnya; statistik NDVI 2024–2026 akan tampil setelah generator dijalankan.</span></div>';
        }
    }

    function updateKpis(year) {
        document.querySelectorAll('.active-year-label').forEach(el => el.textContent = year);
        const ndvi = environmentData.years?.[year]?.ndvi;
        const lst = environmentData.years?.[year]?.lst;
        const pressure = environmentData.years?.[year]?.pressure;
        document.getElementById('metricNdviMean').textContent = format(ndvi?.mean, 3);
        document.getElementById('metricNdviRange').textContent = ndvi ? 'Rentang ' + format(ndvi.min, 3) + ' hingga ' + format(ndvi.max, 3) : 'Statistik tahun ini belum dihitung';
        document.getElementById('metricLstMean').textContent = lst ? format(lst.mean, 2) + '°C' : '—';
        document.getElementById('metricLstRange').textContent = lst ? 'Rentang ' + format(lst.min, 2) + '–' + format(lst.max, 2) + '°C' : 'Statistik tahun ini belum dihitung';
        document.getElementById('metricPressureMean').textContent = format(pressure?.mean, 3);
        document.getElementById('metricPressureRange').textContent = pressure ? 'Maksimum ' + format(pressure.max, 3) : 'Statistik tahun ini belum dihitung';
        const baseLst = valueOf(environmentData, '2023', 'lst', 'mean');
        const change = Number.isFinite(Number(lst?.mean)) && Number.isFinite(Number(baseLst)) ? Number(lst.mean) - Number(baseLst) : null;
        const changeBox = document.getElementById('metricLstChange');
        changeBox.textContent = change === null ? '—' : (change > 0 ? '+' : '') + format(change, 2) + '°C';
        changeBox.classList.toggle('text-danger', change > 0);
        changeBox.classList.toggle('text-success', change <= 0 && change !== null);
        const status = pressureClass(pressure?.mean);
        const statusBox = document.getElementById('metricPressureClass');
        statusBox.textContent = status.label;
        statusBox.className = 'environment-kpi-value status-value status-' + status.className;
    }

    function fillTable() {
        const body = document.getElementById('environmentTableBody');
        if (!body) return;
        body.innerHTML = YEARS.map(year => {
            const ndvi = environmentData.years?.[year]?.ndvi;
            const lst = environmentData.years?.[year]?.lst;
            const pressure = environmentData.years?.[year]?.pressure;
            const status = pressureClass(pressure?.mean);
            const range = (item, digits, suffix = '') => item ? format(item.min, digits) + '–' + format(item.max, digits) + suffix : '—';
            return '<tr><th scope="row"><span class="environment-year-badge">' + year + '</span></th>' +
                '<td class="text-end"><strong>' + format(ndvi?.mean, 3) + '</strong></td>' +
                '<td class="text-end">' + range(ndvi, 3) + '</td>' +
                '<td class="text-end"><strong>' + (lst ? format(lst.mean, 2) + '°C' : '—') + '</strong></td>' +
                '<td class="text-end">' + range(lst, 2, '°C') + '</td>' +
                '<td class="text-end"><strong>' + format(pressure?.mean, 3) + '</strong></td>' +
                '<td class="text-end">' + range(pressure, 3) + '</td>' +
                '<td><span class="pressure-status status-' + status.className + '">' + status.label + '</span></td></tr>';
        }).join('');
    }

    function lineDataset(label, values, color, dash = []) {
        return { label, data: values, borderColor: color, backgroundColor: color, borderWidth: 2.2, pointRadius: 4, pointHoverRadius: 6, tension: .28, borderDash: dash, spanGaps: false };
    }

    function commonOptions(yTitle, tickCallback, suggestedMin, suggestedMax) {
        return { responsive:true, maintainAspectRatio:false, interaction:{mode:'index',intersect:false}, plugins:{legend:{position:'bottom',labels:{usePointStyle:true,pointStyle:'circle',boxWidth:7,boxHeight:7,padding:18}},tooltip:{backgroundColor:'#20352a',padding:11}}, scales:{x:{grid:{display:false},border:{display:false},ticks:{color:'#64736b',font:{weight:'600'}}},y:{suggestedMin,suggestedMax,border:{display:false},grid:{color:'rgba(50,80,62,.08)'},title:{display:true,text:yTitle,color:'#64736b'},ticks:{color:'#64736b',callback:tickCallback}}} };
    }

    function drawCharts() {
        charts.forEach(chart => chart.destroy());
        charts = [];
        if (typeof Chart === 'undefined') return;
        const ndviCanvas = document.getElementById('ndviEnvironmentChart');
        const lstCanvas = document.getElementById('lstEnvironmentChart');
        const pressureCanvas = document.getElementById('pressureEnvironmentChart');
        charts.push(new Chart(ndviCanvas.getContext('2d'), {type:'line',data:{labels:YEARS,datasets:[lineDataset('Minimum',series(environmentData,'ndvi','min'),'#9a6545',[5,4]),lineDataset('Rata-rata',series(environmentData,'ndvi','mean'),'#237451'),lineDataset('Maksimum',series(environmentData,'ndvi','max'),'#74aa67',[5,4])]},options:commonOptions('Nilai NDVI',v=>Number(v).toFixed(1),-1,1)}));
        charts.push(new Chart(lstCanvas.getContext('2d'), {type:'line',data:{labels:YEARS,datasets:[lineDataset('Minimum',series(environmentData,'lst','min'),'#4f86a8',[5,4]),lineDataset('Rata-rata',series(environmentData,'lst','mean'),'#d08434'),lineDataset('Maksimum',series(environmentData,'lst','max'),'#cc5548',[5,4])]},options:commonOptions('Suhu permukaan (°C)',v=>v+'°C',20,38)}));
        charts.push(new Chart(pressureCanvas.getContext('2d'), {type:'bar',data:{labels:YEARS,datasets:[{label:'Rata-rata',data:series(environmentData,'pressure','mean'),backgroundColor:['#7fb891','#6cab83','#55986f','#3f815c'],borderRadius:8,borderSkipped:false,maxBarThickness:58},{type:'line',label:'Maksimum',data:series(environmentData,'pressure','max'),borderColor:'#cc5548',backgroundColor:'#cc5548',borderWidth:2.2,pointRadius:4,tension:.25}]},options:commonOptions('Indeks tekanan ekologis',v=>Number(v).toFixed(1),0,1)}));
    }

    function render(data, loaded) {
        environmentData = data;
        setStatus(data, loaded);
        updateKpis(document.getElementById('environmentYearSelect')?.value || '2026');
        fillTable();
        drawCharts();
    }

    document.getElementById('environmentYearSelect')?.addEventListener('change', function () { updateKpis(this.value); });
    fetch(STATS_URL + '?v=' + Date.now(), { headers:{ Accept:'application/json' } })
        .then(response => { if (!response.ok) throw new Error('HTTP ' + response.status); return response.json(); })
        .then(data => render(data, true))
        .catch(() => render(FALLBACK, false));
});
</script>
@endpush
