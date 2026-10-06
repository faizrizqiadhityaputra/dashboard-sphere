# SPHERE 3.0 — Aurora Glass UI

Paket ini berisi redesign antarmuka Laravel Blade untuk SPHERE. Integrasi MapLibre, GeoJSON Merauke, NDVI, LST, tekanan ekologis, Chart.js, route, dan ID elemen interaktif tetap dipertahankan.

## Pemasangan

1. Cadangkan project lama atau buat commit Git.
2. Ekstrak isi ZIP ini ke root project `sphere-dashboard`.
3. Pilih **Replace files in the destination** saat diminta Windows.
4. Jangan menghapus folder tile raster yang sudah ada:
   - `public/tiles/ndvi/`
   - `public/tiles/lst/`
   - `public/tiles/pressure/`
5. Jalankan:

   ```powershell
   php artisan optimize:clear
   php artisan serve
   ```

6. Buka `http://127.0.0.1:8000/dashboard` dan lakukan hard refresh dengan `Ctrl + F5`.

## File utama redesign

- `public/css/sphere-dashboard.css` — design system, glassmorphism, bento cards, responsive layout, dan motion.
- `public/js/sphere-dashboard.js` — reveal animation, ripple button, pencarian, toast, dan scroll progress.
- `resources/views/layouts/sphere.blade.php` — font, ambient background, dan shell global modern.
- `resources/views/partials/navbar.blade.php` — floating aurora navigation.
- `resources/views/partials/footer.blade.php` — footer glass dan status data.
- `resources/views/partials/unified-map-modern.blade.php` — tampilan panel peta bersama.
- Blade halaman utama — aksen warna spesifik per halaman.

## Aksen halaman

- Ringkasan: indigo
- Geospasial: cyan
- Lingkungan: emerald
- Ekonomi: orange
- Karbon: rose
- Laporan: violet

## Catatan

- Library animasi eksternal tidak diperlukan. Micro-interactions memakai CSS dan JavaScript native agar ringan.
- Animasi otomatis dinonaktifkan ketika perangkat memakai `prefers-reduced-motion`.
- Data geospasial dan raster tidak disertakan ulang di dalam paket ini selain `public/data/merauke.geojson`.
