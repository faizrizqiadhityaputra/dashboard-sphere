@once
@php
    // Shared catalog: Dashboard and Geospasial always use this same data.
    // Remove a year's URL (or set it to null) if that dataset is unavailable.
    $sphereCatalog = [
        'ndvi' => [
            'label' => 'NDVI', 'unit' => 'Indeks −1–1', 'precision' => 3,
            'description' => 'Indeks vegetasi; nilai lebih besar umumnya berkaitan dengan vegetasi lebih rapat. Nilai negatif dapat berkaitan dengan air atau permukaan nonvegetasi.',
            'source' => 'GeoTIFF NDVI yang diunggah pengguna; identitas sensor dan komposit tahunan belum dilengkapi.',
            'resolution' => 'NDVI 2023: 0,00026949° (sekitar 30 m). Resolusi tahun lain belum diverifikasi.',
            'method' => 'Raster dipotong dengan batas Merauke, diberi warna, lalu dikonversi menjadi tile XYZ.',
            'paletteNote' => 'Palet referensi dari ndvi-colors.txt terakhir. Kesamaan palet 2023–2026 perlu diverifikasi sebelum membandingkan warna.',
            'stops' => [[-1, '#a50026'], [0, '#d73027'], [0.2, '#fee08b'], [0.4, '#d9ef8b'], [0.6, '#66bd63'], [0.8, '#1a9850'], [1, '#006837']],
            'means' => [2023 => 0.64351257332937, 2024 => null, 2025 => null, 2026 => null],
        ],
        'lst' => [
            'label' => 'LST', 'unit' => '°C', 'precision' => 1,
            'description' => 'Suhu permukaan daratan, bukan suhu udara. Rentang legenda menunjukkan rentang tampilan, bukan ambang bahaya.',
            'source' => 'GeoTIFF LST_2023.tif sampai LST_2026.tif dari pengguna. Sensor, tanggal akuisisi, dan metode komposit belum dicantumkan.',
            'resolution' => '1505 × 1116 piksel. Ukuran piksel dalam meter belum diverifikasi.',
            'method' => 'Raster band LST dipotong dengan batas Merauke dan disajikan sebagai tile berwarna. Metode estimasi suhu belum didokumentasikan.',
            'paletteNote' => 'Rentang 22–36 °C mengikuti legenda sebelumnya. Palet referensi perlu dicocokkan dengan lst-colors.txt yang dipakai membuat tile.',
            'stops' => [[22, '#1e40af'], [36, '#7f1d1d']],
            'gradient' => 'linear-gradient(90deg,#1e40af,#2563eb,#22d3ee,#facc15,#f97316,#ef4444,#7f1d1d)',
            'means' => [2023 => 27.715253834764, 2024 => 26.367312465628, 2025 => 25.831086155635, 2026 => 26.137172983871],
        ],
        'pressure' => [
            'label' => 'Tekanan ekologis', 'unit' => 'Indeks 0–1', 'precision' => 3,
            'description' => 'Indeks tekanan ekologis band pertama. Nilai ini bukan persentase luas terdampak. Definisi formula dan ambang kelas perlu merujuk metodologi penelitian.',
            'source' => 'GeoTIFF TekananEkologis_2023.tif sampai TekananEkologis_2026.tif dari pengguna.',
            'resolution' => '1505 × 1116 piksel. Ukuran piksel dalam meter belum diverifikasi.',
            'method' => 'Band pertama (indeks 0–1) dipotong dengan batas Merauke, diwarnai memakai pressure-colors.txt, lalu dibuat tile XYZ. Band kedua 0–2 tidak dipakai pada tampilan ini.',
            'paletteNote' => 'Palet berdasarkan pressure-colors.txt yang Anda kirim. Nilai NoData dibuat transparan.',
            'stops' => [[0, '#16a34a'], [0.2, '#84cc16'], [0.4, '#facc15'], [0.6, '#f97316'], [0.8, '#ef4444'], [1, '#7f1d1d']],
            'means' => [2023 => 0.29304574672575, 2024 => 0.24699213613867, 2025 => 0.21855684084666, 2026 => 0.19490035018596],
        ],
    ];
    foreach ($sphereCatalog as $theme => &$dataset) {
        $dataset['tiles'] = [];
        foreach ([2023, 2024, 2025, 2026] as $year) {
            $version = $theme === 'ndvi' ? ($year === 2023 ? '' : '?v=clip2') : '?v=1';
            $dataset['tiles'][$year] = asset("tiles/{$theme}/{$year}") . '/{z}/{x}/{y}.png' . $version;
        }
    }
    unset($dataset);
    $sphereMapConfig = [
        'adminUrl' => asset('data/merauke.geojson'),
        'years' => [2023, 2024, 2025, 2026],
        'minzoom' => 6, 'maxzoom' => 13,
        'fallbackBounds' => [[137.6400475, -9.1205052], [141.0195096, -6.6179785]],
        'catalog' => $sphereCatalog,
    ];
@endphp
<script>window.SphereMapConfig = @json($sphereMapConfig);</script>
<script src="{{ asset('js/sphere-map.js') }}?v=sage-complete-3"></script>
@endonce
