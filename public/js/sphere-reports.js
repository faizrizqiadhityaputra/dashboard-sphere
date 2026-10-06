(function () {
    'use strict';

    const config = window.SPHERE_REPORT_CONFIG || {};
    const carbonRows = [
        { year: 2023, area: 318485.38, emission: 43600649, change: '' },
        { year: 2024, area: 451613.10, emission: 61825833, change: 41.8 },
        { year: 2025, area: 506787.87, emission: 69379259, change: 12.2 },
        { year: 2026, area: 954325.95, emission: 130647222, change: 88.3 }
    ];
    const economyRows = [
        { year: 2023, emission: 43600649, low: 87.2, high: 174.4 },
        { year: 2024, emission: 61825833, low: 123.7, high: 247.3 },
        { year: 2025, emission: 69379259, low: 138.8, high: 277.5 },
        { year: 2026, emission: 130647222, low: 261.3, high: 522.6 }
    ];
    const productionRows = [
        { year: 2023, area: 318485.38, production: 1815366.67, gross: 11.80 },
        { year: 2024, area: 451613.10, production: 2574194.67, gross: 16.73 },
        { year: 2025, area: 506787.87, production: 2888690.86, gross: 18.78 },
        { year: 2026, area: 954325.95, production: 5439657.92, gross: 35.36 }
    ];

    const formatId = (value, digits) => Number(value).toLocaleString('id-ID', {
        minimumFractionDigits: digits,
        maximumFractionDigits: digits
    });

    function notify(title, message, type) {
        if (typeof window.showSphereNotification === 'function') {
            window.showSphereNotification(title, message, type || 'info');
        }
    }

    function csvEscape(value) {
        const string = String(value == null ? '' : value);
        return /[;"\r\n]/.test(string) ? `"${string.replace(/"/g, '""')}"` : string;
    }

    function makeCsv(headers, rows) {
        return '\uFEFF' + [headers, ...rows]
            .map(row => row.map(csvEscape).join(';'))
            .join('\r\n');
    }

    function downloadBlob(content, fileName, mimeType) {
        const blob = content instanceof Blob ? content : new Blob([content], { type: mimeType });
        const url = URL.createObjectURL(blob);
        const anchor = document.createElement('a');
        anchor.href = url;
        anchor.download = fileName;
        document.body.appendChild(anchor);
        anchor.click();
        anchor.remove();
        window.setTimeout(() => URL.revokeObjectURL(url), 1000);
    }

    function carbonCsv() {
        return makeCsv(
            ['Tahun', 'Luas skenario (ha)', 'Emisi (MgCO2e)', 'Emisi (MtCO2e)', 'Perubahan tahunan (%)'],
            carbonRows.map(row => [row.year, formatId(row.area, 2), row.emission, formatId(row.emission / 1e6, 2), row.change])
        );
    }

    function economyCsv() {
        const rows = productionRows.map((row, index) => [
            row.year, formatId(row.area, 2), formatId(row.production, 2), formatId(row.gross, 2),
            economyRows[index].emission, formatId(economyRows[index].low, 1), formatId(economyRows[index].high, 1)
        ]);
        return makeCsv(
            ['Tahun', 'Luas skenario (ha)', 'Potensi produksi (ton)', 'Nilai bruto produksi (Rp triliun)', 'Emisi (MgCO2e)', 'Nilai karbon minimum (juta US$)', 'Nilai karbon maksimum (juta US$)'],
            rows
        );
    }

    function executiveCsv() {
        return makeCsv(
            ['Indikator', 'Nilai 2026', 'Satuan', 'Keterangan'],
            [
                ['Luas skenario', '954325,95', 'ha', 'Estimasi spasial PSN'],
                ['Emisi karbon', '130647222', 'MgCO2e', '+88,3% dari 2025'],
                ['Nilai ekonomi karbon', '261,3–522,6', 'juta US$', 'Skenario US$2–4/MgCO2e'],
                ['Potensi produksi', '5439657,92', 'ton', 'Produktivitas 5,7 ton/ha'],
                ['Nilai bruto produksi', '35,36', 'Rp triliun', 'Harga Rp6.500/kg']
            ]
        );
    }

    function manifestCsv() {
        const rows = [];
        const layers = [
            ['NDVI', 'ndvi'],
            ['Suhu Permukaan (LST)', 'lst'],
            ['Tekanan Ekologis', 'pressure']
        ];
        layers.forEach(([label, slug]) => {
            for (let year = 2023; year <= 2026; year += 1) {
                rows.push([label, year, `storage/app/geospatial/raw/${slug}_${year}.tif`, `public/tiles/${slug}/${year}/{z}/{x}/{y}.png`]);
            }
        });
        return makeCsv(['Indikator', 'Tahun', 'Raster sumber', 'Pola URL tile XYZ'], rows);
    }

    async function fetchJson(url, label) {
        if (!url) throw new Error(`URL ${label} belum dikonfigurasi.`);
        const response = await fetch(url, { headers: { Accept: 'application/json, application/geo+json' } });
        if (!response.ok) throw new Error(`${label} gagal dimuat (HTTP ${response.status}).`);
        return response.json();
    }

    async function environmentCsv() {
        const payload = await fetchJson(config.environmentUrl, 'statistik lingkungan');
        const rows = [];
        Object.keys(payload.years || {}).sort().forEach(year => {
            const item = payload.years[year] || {};
            ['ndvi', 'lst', 'pressure'].forEach(indicator => {
                const stats = item[indicator] || {};
                rows.push([year, indicator.toUpperCase(), stats.min, stats.max, stats.mean, stats.validPercent || stats.valid_percent || '']);
            });
        });
        if (!rows.length) throw new Error('Statistik lingkungan belum berisi data tahunan.');
        return makeCsv(['Tahun', 'Indikator', 'Minimum', 'Maksimum', 'Rerata', 'Persen piksel valid'], rows);
    }

    function getJsPdf() {
        const JsPdf = window.jspdf && window.jspdf.jsPDF;
        if (!JsPdf) throw new Error('Pustaka PDF belum termuat. Periksa koneksi internet lalu muat ulang halaman.');
        return JsPdf;
    }

    function pdfHeader(doc, title, subtitle) {
        doc.setFillColor(20, 116, 73);
        doc.rect(0, 0, 210, 34, 'F');
        doc.setTextColor(255, 255, 255);
        doc.setFont('helvetica', 'bold');
        doc.setFontSize(18);
        doc.text(title, 16, 16);
        doc.setFont('helvetica', 'normal');
        doc.setFontSize(9);
        doc.text(subtitle, 16, 24);
        doc.setTextColor(24, 39, 31);
    }

    function pdfFooter(doc) {
        const pages = doc.getNumberOfPages();
        for (let page = 1; page <= pages; page += 1) {
            doc.setPage(page);
            doc.setDrawColor(220, 232, 225);
            doc.line(16, 282, 194, 282);
            doc.setTextColor(100, 118, 108);
            doc.setFontSize(7.5);
            doc.text(`SPHERE • Merauke 2023–2026 • Halaman ${page}/${pages}`, 16, 288);
        }
    }

    function addSection(doc, y, title, lines) {
        if (y > 254) { doc.addPage(); y = 20; }
        doc.setTextColor(20, 116, 73);
        doc.setFont('helvetica', 'bold');
        doc.setFontSize(11);
        doc.text(title, 16, y);
        doc.setTextColor(45, 58, 51);
        doc.setFont('helvetica', 'normal');
        doc.setFontSize(9);
        let cursor = y + 7;
        lines.forEach(line => {
            const wrapped = doc.splitTextToSize(String(line), 178);
            if (cursor + wrapped.length * 5 > 274) { doc.addPage(); cursor = 20; }
            doc.text(wrapped, 16, cursor);
            cursor += wrapped.length * 5 + 2;
        });
        return cursor + 5;
    }

    async function buildPdf(type) {
        const JsPdf = getJsPdf();
        const doc = new JsPdf({ unit: 'mm', format: 'a4' });
        const date = new Intl.DateTimeFormat('id-ID', { dateStyle: 'long' }).format(new Date());
        let y = 45;

        if (type === 'executive') {
            pdfHeader(doc, 'Ringkasan Eksekutif SPHERE', `Kabupaten Merauke • Periode 2023–2026 • ${date}`);
            y = addSection(doc, y, 'Temuan utama 2026', [
                'Luas skenario mencapai 954.325,95 ha dengan estimasi emisi 130.647.222 MgCO2e (130,65 MtCO2e).',
                'Emisi meningkat 88,3% dibanding 2025 dan 199,6% dibanding 2023.',
                'Potensi produksi diperkirakan 5.439.657,92 ton dengan nilai bruto Rp35,36 triliun.',
                'Nilai ekonomi karbon berada pada rentang US$261,3–522,6 juta.'
            ]);
            y = addSection(doc, y, 'Implikasi kebijakan', [
                'Kenaikan tajam pada 2026 perlu ditempatkan sebagai skenario risiko dan diverifikasi terhadap perubahan tutupan lahan aktual.',
                'Gunakan NDVI, LST, dan tekanan ekologis secara bersamaan untuk menentukan prioritas pengawasan dan mitigasi.'
            ]);
        } else if (type === 'carbon') {
            pdfHeader(doc, 'Laporan Karbon dan Emisi', `Dataset aktual 2023–2026 • ${date}`);
            y = addSection(doc, y, 'Deret emisi', carbonRows.map(row => `${row.year}: ${formatId(row.area, 2)} ha • ${formatId(row.emission, 0)} MgCO2e${row.change === '' ? '' : ` • ${formatId(row.change, 1)}% YoY`}`));
            y = addSection(doc, y, 'Metodologi', ['Estimasi memakai faktor emisi 136,9 MgCO2e per hektare. Angka disajikan sebagai hasil pemodelan skenario dan bukan inventaris GRK resmi.']);
        } else if (type === 'economy') {
            pdfHeader(doc, 'Laporan Ekonomi dan Produksi', `Skenario 2023–2026 • ${date}`);
            y = addSection(doc, y, 'Potensi produksi', productionRows.map(row => `${row.year}: ${formatId(row.production, 2)} ton • Rp${formatId(row.gross, 2)} triliun`));
            y = addSection(doc, y, 'Valuasi karbon', economyRows.map(row => `${row.year}: US$${formatId(row.low, 1)}–${formatId(row.high, 1)} juta`));
            y = addSection(doc, y, 'Asumsi', ['Produktivitas 5,7 ton/ha, harga Rp6.500/kg, dan harga karbon US$2–4/MgCO2e.']);
        } else if (type === 'environment') {
            const payload = await fetchJson(config.environmentUrl, 'statistik lingkungan');
            pdfHeader(doc, 'Laporan Lingkungan dan Biofisik', `Statistik raster 2023–2026 • ${date}`);
            const lines = [];
            Object.keys(payload.years || {}).sort().forEach(year => {
                const row = payload.years[year];
                const describe = (key, label) => row && row[key] ? `${label} mean ${formatId(row[key].mean, 2)} (min ${formatId(row[key].min, 2)}; max ${formatId(row[key].max, 2)})` : `${label} tidak tersedia`;
                lines.push(`${year}: ${describe('ndvi', 'NDVI')} • ${describe('lst', 'LST')} • ${describe('pressure', 'Tekanan')}`);
            });
            if (!lines.length) lines.push('Statistik lingkungan belum tersedia.');
            y = addSection(doc, y, 'Ringkasan statistik', lines);
            y = addSection(doc, y, 'Sumber', ['Statistik dihitung dari GeoTIFF hasil clip batas administrasi dan dipublikasikan melalui environment-stats.json.']);
        } else {
            pdfHeader(doc, 'Laporan Analisis Geospasial', `Kabupaten Merauke • ${date}`);
            y = addSection(doc, y, 'Ketersediaan layer', [
                'NDVI: 2023, 2024, 2025, 2026',
                'Suhu Permukaan (LST): 2023, 2024, 2025, 2026',
                'Tekanan Ekologis: 2023, 2024, 2025, 2026',
                'Batas administrasi: public/data/merauke.geojson (EPSG:4326).'
            ]);
            y = addSection(doc, y, 'Catatan', ['Layer raster telah dipotong mengikuti batas administrasi dan disajikan sebagai tile XYZ pada dashboard MapLibre.']);
        }

        pdfFooter(doc);
        return doc;
    }

    async function downloadPdf(type, fileName) {
        const doc = await buildPdf(type);
        doc.save(fileName);
    }

    async function downloadGeoJson(returnText) {
        const payload = await fetchJson(config.administrationUrl, 'batas administrasi');
        const text = JSON.stringify(payload, null, 2);
        if (!returnText) downloadBlob(text, 'SPHERE-Batas-Administrasi-Merauke.geojson', 'application/geo+json;charset=utf-8');
        return text;
    }

    async function buildAllZip() {
        if (!window.JSZip) throw new Error('Pustaka ZIP belum termuat. Periksa koneksi internet lalu muat ulang halaman.');
        const zip = new window.JSZip();
        zip.file('data/SPHERE-Ringkasan-2026.csv', executiveCsv());
        zip.file('data/SPHERE-Karbon-2023-2026.csv', carbonCsv());
        zip.file('data/SPHERE-Ekonomi-Produksi-2023-2026.csv', economyCsv());
        zip.file('data/SPHERE-Manifest-Raster-Tile.csv', manifestCsv());

        try { zip.file('data/SPHERE-Lingkungan-2023-2026.csv', await environmentCsv()); }
        catch (error) { zip.file('catatan/lingkungan.txt', error.message); }
        try { zip.file('geospasial/merauke.geojson', await downloadGeoJson(true)); }
        catch (error) { zip.file('catatan/geospasial.txt', error.message); }

        for (const type of ['executive', 'carbon', 'economy', 'environment', 'spatial']) {
            try {
                const doc = await buildPdf(type);
                zip.file(`laporan/SPHERE-${type}.pdf`, doc.output('arraybuffer'));
            } catch (error) {
                zip.file(`catatan/${type}.txt`, error.message);
            }
        }
        zip.file('README.txt', 'Paket data SPHERE Kabupaten Merauke periode 2023–2026. Dibuat otomatis dari halaman Laporan.');
        const blob = await zip.generateAsync({ type: 'blob', compression: 'DEFLATE', compressionOptions: { level: 6 } });
        downloadBlob(blob, 'SPHERE-Paket-Laporan-2023-2026.zip', 'application/zip');
    }

    async function handleDownload(action) {
        switch (action) {
            case 'all': return buildAllZip();
            case 'executive-pdf': return downloadPdf('executive', 'SPHERE-Ringkasan-Eksekutif-2023-2026.pdf');
            case 'executive-csv': return downloadBlob(executiveCsv(), 'SPHERE-Ringkasan-2026.csv', 'text/csv;charset=utf-8');
            case 'carbon-pdf': return downloadPdf('carbon', 'SPHERE-Laporan-Karbon-2023-2026.pdf');
            case 'carbon-csv': return downloadBlob(carbonCsv(), 'SPHERE-Karbon-2023-2026.csv', 'text/csv;charset=utf-8');
            case 'economy-pdf': return downloadPdf('economy', 'SPHERE-Laporan-Ekonomi-2023-2026.pdf');
            case 'economy-csv': return downloadBlob(economyCsv(), 'SPHERE-Ekonomi-Produksi-2023-2026.csv', 'text/csv;charset=utf-8');
            case 'environment-pdf': return downloadPdf('environment', 'SPHERE-Laporan-Lingkungan-2023-2026.pdf');
            case 'environment-csv': return downloadBlob(await environmentCsv(), 'SPHERE-Lingkungan-2023-2026.csv', 'text/csv;charset=utf-8');
            case 'spatial-pdf': return downloadPdf('spatial', 'SPHERE-Laporan-Geospasial-2023-2026.pdf');
            case 'geojson': return downloadGeoJson(false);
            case 'manifest-csv': return downloadBlob(manifestCsv(), 'SPHERE-Manifest-Raster-Tile.csv', 'text/csv;charset=utf-8');
            default: throw new Error('Jenis unduhan tidak dikenali.');
        }
    }

    document.querySelectorAll('.report-download').forEach(button => {
        button.addEventListener('click', async function () {
            if (this.disabled) return;
            const original = this.innerHTML;
            this.disabled = true;
            this.innerHTML = '<span class="spinner-border spinner-border-sm" aria-hidden="true"></span> Menyiapkan…';
            try {
                await handleDownload(this.dataset.download);
                notify('Unduhan siap', 'File berhasil dibuat dan dikirim ke folder Downloads.', 'success');
            } catch (error) {
                console.error('[SPHERE Reports]', error);
                notify('Unduhan gagal', error.message || 'File belum dapat dibuat.', 'danger');
            } finally {
                this.disabled = false;
                this.innerHTML = original;
            }
        });
    });
})();
