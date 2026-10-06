/* SPHERE Sage Complete 3. MapLibre 5.x, no framework dependency. */
(function (global) {
    'use strict';
    const THEMES = ['ndvi', 'lst', 'pressure'];
    const STATE_KEY = 'sphere.unified-map-state.v6';
    const EMPTY = { type: 'FeatureCollection', features: [] };
    const BASE = {
        osm: { url: 'https://tile.openstreetmap.org/{z}/{x}/{y}.png', attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors' },
        satellite: { url: 'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', attribution: 'Tiles &copy; Esri' }
    };
    const escape = value => String(value).replace(/[&<>"']/g, c => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]));
    const fmt = (value, digits = 3) => Number.isFinite(value) ? value.toLocaleString('id-ID', { minimumFractionDigits: digits, maximumFractionDigits: digits }) : 'Belum tersedia';
    function normalizeState(input, config) {
        const s = input && typeof input === 'object' ? input : {};
        const validYear = y => config.years.includes(Number(y));
        const opacity = Number(s.opacity);
        const result = {
            year: validYear(s.year) ? Number(s.year) : 2023,
            yearB: validYear(s.yearB) ? Number(s.yearB) : 2026,
            compare: s.compare === true,
            opacity: s.opacity != null && Number.isFinite(opacity) ? Math.max(0, Math.min(100, opacity)) : 82
        };
        for (const key of [...THEMES, 'satellite', 'admin']) {
            result[key] = typeof s[key] === 'boolean' ? s[key] : ['ndvi', 'satellite', 'admin'].includes(key);
        }
        return result;
    }
    function boundsOf(geojson) {
        let west = Infinity, south = Infinity, east = -Infinity, north = -Infinity, count = 0;
        function walkCoordinates(a) {
            if (!Array.isArray(a)) throw new Error('Koordinat tidak valid.');
            if (typeof a[0] === 'number') {
                const [x, y] = a;
                if (!Number.isFinite(x) || !Number.isFinite(y) || Math.abs(x) > 180 || Math.abs(y) > 90) throw new Error('GeoJSON harus memakai koordinat WGS84 (longitude, latitude).');
                west = Math.min(west, x); east = Math.max(east, x); south = Math.min(south, y); north = Math.max(north, y); count++;
            } else a.forEach(walkCoordinates);
        }
        function walk(g) {
            if (!g) return;
            if (g.type === 'FeatureCollection') return (g.features || []).forEach(walk);
            if (g.type === 'Feature') return walk(g.geometry);
            if (g.type === 'GeometryCollection') return (g.geometries || []).forEach(walk);
            if (g.type === 'Polygon' || g.type === 'MultiPolygon') walkCoordinates(g.coordinates);
        }
        walk(geojson);
        if (count < 4 || west === east || south === north) throw new Error('Batas administrasi tidak berisi poligon yang valid.');
        return [[west, south], [east, north]];
    }
    function rasterSpec(config, theme, year, revision) {
        const url = config.catalog[theme]?.tiles?.[year];
        if (!url) return null;
        return {
            type: 'raster', tileSize: 256, minzoom: config.minzoom, maxzoom: config.maxzoom,
            tiles: [url + (revision ? `${url.includes('?') ? '&' : '?'}sphere_retry=${revision}` : '')],
            attribution: `${escape(config.catalog[theme].label)} ${year} · Data pengguna`
        };
    }
    function cameraOf(map) { return { center: map.getCenter(), zoom: map.getZoom(), bearing: map.getBearing(), pitch: map.getPitch() }; }
    function syncCamera(source, target, lock) {
        if (!source || !target || lock.busy) return;
        lock.busy = true;
        try { target.jumpTo(cameraOf(source)); } finally { lock.busy = false; }
    }
    function sourceFailed(record, event) {
        const code = event.error?.status || event.status;
        record.status = 'error';
        record.message = code === 404 ? 'Sebagian tile tidak ditemukan (404).' : 'Gagal memuat tile. Periksa koneksi atau sumber data.';
    }

    class Pane {
        constructor(host, side, element, camera) {
            this.host = host; this.side = side; this.element = element;
            this.records = new Map(); this.sequence = 0; this.ready = false; this.disposed = false;
            this.baseState = { osm: { status: 'loading' }, satellite: { status: 'loading' } };
            const sources = {}, layers = [];
            for (const [key, data] of Object.entries(BASE)) {
                sources[`base-${key}`] = { type: 'raster', tiles: [data.url], tileSize: 256, attribution: data.attribution, maxzoom: key === 'osm' ? 19 : 18 };
                layers.push({ id: `base-${key}`, type: 'raster', source: `base-${key}`, layout: { visibility: (key === 'satellite') === host.state.satellite ? 'visible' : 'none' } });
            }
            this.map = new global.maplibregl.Map({
                container: element, style: { version: 8, sources, layers },
                center: [139.3298, -7.8692], zoom: 7, maxZoom: 18,
                attributionControl: false, renderWorldCopies: false, ...camera
            });
            this.map.addControl(new global.maplibregl.AttributionControl({ compact: true }), 'bottom-right');
            this.map.addControl(new global.maplibregl.ScaleControl({ unit: 'metric', maxWidth: 90 }), 'bottom-left');
            this.initTimer = setTimeout(() => {
                if (!this.ready && !this.disposed) { this.initError = 'Peta belum selesai disiapkan.'; host.renderStatus(); }
            }, 15000);
            this.map.on('load', () => {
                if (this.disposed) return;
                clearTimeout(this.initTimer); this.ready = true; this.initError = null;
                this.map.addSource('admin', { type: 'geojson', data: host.adminData || EMPTY });
                this.map.addLayer({ id: 'admin-fill', type: 'fill', source: 'admin', paint: { 'fill-color': '#237451', 'fill-opacity': 0.015 } });
                this.map.addLayer({ id: 'admin-line', type: 'line', source: 'admin', paint: { 'line-color': '#38bdf8', 'line-width': 2.4, 'line-dasharray': [3, 2] } });
                this.apply();
                if (side === 'A' && host.adminBounds) host.fit();
                if (side === 'B' && host.panes.A) syncCamera(host.panes.A.map, this.map, host.lock);
            });
            this.map.on('sourcedataloading', event => this.sourceEvent(event, true));
            this.map.on('sourcedata', event => this.sourceEvent(event, false));
            this.map.on('error', event => {
                if (this.disposed) return;
                const rec = [...this.records.values()].find(r => r.id === event.sourceId);
                if (rec) { clearTimeout(rec.timer); sourceFailed(rec, event); }
                else if (event.sourceId?.startsWith('raster-')) return; // Stale response after a year change.
                else if (event.sourceId?.startsWith('base-') && this.baseState[event.sourceId.slice(5)]) sourceFailed(this.baseState[event.sourceId.slice(5)], event);
                else if (event.sourceId === 'admin') { host.adminError = 'Batas administrasi gagal digambar.'; }
                else { this.initError = 'Gangguan pada mesin peta. Coba muat ulang.'; }
                host.renderStatus();
            });
            this.map.on('idle', () => this.checkLoaded());
            this.map.on('move', () => {
                if (this.disposed) return;
                const other = host.panes[side === 'A' ? 'B' : 'A'];
                if (other) syncCamera(this.map, other.map, host.lock);
            });
            this.map.on('moveend', () => { this.checkLoaded(); host.renderStatus(); });
        }
        sourceEvent(event, loading) {
            if (this.disposed) return;
            const rec = [...this.records.values()].find(r => r.id === event.sourceId);
            const base = event.sourceId?.startsWith('base-') ? this.baseState[event.sourceId.slice(5)] : null;
            const target = rec || base;
            if (!target || target.status === 'error') return;
            if (loading) {
                target.status = 'loading';
                if (rec) this.armTimeout(rec);
                else if (!target.timer) target.timer = setTimeout(() => {
                    target.timer = null;
                    if (!this.disposed && target.status === 'loading') { target.status = 'timeout'; this.host.renderStatus(); }
                }, 15000);
            } else if (event.isSourceLoaded) { target.status = 'loaded'; clearTimeout(target.timer); target.timer = null; }
            this.host.renderStatus();
        }
        armTimeout(rec) {
            if (rec.timer) return;
            rec.timer = setTimeout(() => {
                rec.timer = null;
                if (!this.disposed && this.records.get(rec.theme) === rec && rec.status === 'loading') {
                    rec.status = 'timeout'; rec.message = 'Pemuatan terlalu lama. Coba lagi.'; this.host.renderStatus();
                }
            }, 15000);
        }
        removeRecord(rec) {
            clearTimeout(rec.timer);
            this.records.delete(rec.theme); // Ignore late events from the removed source.
            if (this.map.getLayer(rec.id)) this.map.removeLayer(rec.id);
            if (this.map.getSource(rec.id)) this.map.removeSource(rec.id);
        }
        apply(force = false) {
            if (!this.ready || this.disposed) return;
            const { state, config } = this.host;
            const year = this.side === 'A' ? state.year : state.yearB;
            for (const rec of [...this.records.values()]) {
                if (!state[rec.theme] || rec.year !== year || force) this.removeRecord(rec);
            }
            for (const theme of THEMES) {
                if (!state[theme]) continue;
                let rec = this.records.get(theme);
                if (!rec) {
                    const spec = rasterSpec(config, theme, year, force ? Date.now() : 0);
                    if (spec && this.host.adminBounds) {
                        const [[west, south], [east, north]] = this.host.adminBounds;
                        spec.bounds = [west, south, east, north];
                    }
                    const id = `raster-${theme}-${year}-${++this.sequence}`;
                    rec = { id, theme, year, status: spec ? 'loading' : 'unavailable', timer: null };
                    this.records.set(theme, rec);
                    if (spec) {
                        this.armTimeout(rec);
                        this.map.addSource(id, spec);
                        this.map.addLayer({ id, type: 'raster', source: id, paint: { 'raster-opacity': state.opacity / 100, 'raster-fade-duration': 100 } }, 'admin-fill');
                    }
                }
                if (this.map.getLayer(rec.id)) {
                    this.map.setPaintProperty(rec.id, 'raster-opacity', state.opacity / 100);
                    // Deterministic overlay order in both maps, independent of toggling history.
                    this.map.moveLayer(rec.id, 'admin-fill');
                }
            }
            for (const key of Object.keys(BASE)) this.map.setLayoutProperty(`base-${key}`, 'visibility', ((key === 'satellite') === state.satellite) ? 'visible' : 'none');
            for (const id of ['admin-fill', 'admin-line']) this.map.setLayoutProperty(id, 'visibility', state.admin ? 'visible' : 'none');
            this.checkLoaded();
        }
        checkLoaded() {
            if (!this.ready || this.disposed) return;
            for (const rec of this.records.values()) {
                if (['error', 'unavailable'].includes(rec.status)) continue;
                if (this.map.getSource(rec.id) && this.map.isSourceLoaded(rec.id)) {
                    rec.status = 'loaded'; clearTimeout(rec.timer); rec.timer = null;
                }
            }
            for (const key of Object.keys(BASE)) {
                if (this.baseState[key].status !== 'error' && this.map.isSourceLoaded(`base-${key}`)) {
                    this.baseState[key].status = 'loaded'; clearTimeout(this.baseState[key].timer); this.baseState[key].timer = null;
                }
            }
            this.host.renderStatus();
        }
        destroy() {
            this.disposed = true; clearTimeout(this.initTimer);
            for (const rec of this.records.values()) clearTimeout(rec.timer);
            for (const base of Object.values(this.baseState)) clearTimeout(base.timer);
            this.map.remove();
        }
    }

    class Explorer {
        constructor(root, config, saved, publish) {
            this.root = root; this.config = config; this.state = normalizeState(saved, config);
            this.publish = publish; this.panes = {}; this.lock = { busy: false }; this.disposed = false;
            this.adminData = null; this.adminBounds = null; this.adminError = null; this.adminLoading = true;
            this.adminGeneration = 0; this.adminAbort = null;
            this.q = selector => root.querySelector(selector);
            this.bind();
            this.render();
            this.createPane('A');
            if (this.state.compare) this.createPane('B');
            this.fetchAdmin();
            this.resizeObserver = typeof ResizeObserver !== 'undefined' ? new ResizeObserver(() => this.resize()) : null;
            this.resizeObserver?.observe(this.q('.explorer-map-grid'));
        }
        createPane(side, camera) {
            const container = side === 'A' ? this.root.dataset.container : this.root.dataset.container + 'Compare';
            this.panes[side] = new Pane(this, side, document.getElementById(container), camera);
            if (side === 'A') global[this.root.dataset.prefix === 'geo' ? 'geoMap' : 'sphereMap'] = this.panes.A.map;
        }
        update(patch, broadcast = true) {
            const previous = this.state;
            this.state = normalizeState({ ...this.state, ...patch }, this.config);
            if (!this.state.compare && this.panes.B) { this.panes.B.destroy(); delete this.panes.B; }
            this.render();
            if (this.state.compare && !this.panes.B && this.panes.A) this.createPane('B', cameraOf(this.panes.A.map));
            for (const pane of Object.values(this.panes)) pane.apply();
            if (!previous.admin && this.state.admin && this.adminBounds) this.fit();
            if (previous.compare !== this.state.compare) this.resize();
            if (broadcast) this.publish(this.state, this);
        }
        bind() {
            this.root.addEventListener('change', event => {
                const key = event.target.dataset.control;
                if (key && key !== 'opacity') this.update({ [key]: event.target.type === 'checkbox' ? event.target.checked : Number(event.target.value) });
            });
            this.root.addEventListener('input', event => {
                if (event.target.dataset.control === 'opacity') this.update({ opacity: Number(event.target.value) });
            });
            this.root.addEventListener('click', event => {
                const button = event.target.closest('button');
                if (!button || !this.root.contains(button)) return;
                if (button.dataset.theme) { this.update(Object.fromEntries(THEMES.map(t => [t, t === button.dataset.theme]))); return; }
                const action = button.dataset.action;
                if (action === 'compare') this.update({ compare: !this.state.compare });
                if (action === 'swap') this.update({ year: this.state.yearB, yearB: this.state.year });
                if (action === 'extent') this.fit(true);
                if (action === 'zoomIn') this.panes.A?.map.zoomIn();
                if (action === 'zoomOut') this.panes.A?.map.zoomOut();
                if (action === 'retry') this.retry();
                if (action === 'focus') this.focus();
            });
            this.onFullscreen = () => {
                const active = document.fullscreenElement === this.root;
                const button = this.q('[data-action="focus"]');
                button.setAttribute('aria-pressed', String(active));
                button.innerHTML = `<i class="bi bi-${active ? 'fullscreen-exit' : 'arrows-fullscreen'}" aria-hidden="true"></i> ${active ? 'Keluar fokus' : 'Fokus peta'}`;
                this.resize();
            };
            document.addEventListener('fullscreenchange', this.onFullscreen);
            if (!this.root.requestFullscreen || document.fullscreenEnabled === false) {
                this.q('[data-action="focus"]').disabled = true;
                this.q('[data-action="focus"]').title = 'Mode layar penuh tidak tersedia di browser ini.';
            }
            if (global.matchMedia('(max-width:767px)').matches) this.q('.explorer-layer-panel').open = false;
        }
        notice(text) { const el = this.q('[data-map-notice]'); el.textContent = text; el.hidden = !text; }
        async focus() {
            try {
                if (document.fullscreenElement === this.root) await document.exitFullscreen();
                else await this.root.requestFullscreen();
            } catch { this.notice('Browser tidak dapat membuka layar penuh. Peta tetap dapat digunakan di halaman ini.'); }
        }
        resize() {
            global.requestAnimationFrame(() => {
                if (this.disposed) return;
                // Resize events can emit move; synchronize once after both have resized.
                this.lock.busy = true;
                try { for (const pane of Object.values(this.panes)) pane.map.resize(); }
                finally { this.lock.busy = false; }
                if (this.panes.B) syncCamera(this.panes.A.map, this.panes.B.map, this.lock);
            });
        }
        fit(userRequested = false) {
            if (!this.adminBounds) { if (userRequested) this.notice('Batas administrasi belum tersedia. Gunakan Coba lagi untuk memuat batas.'); return; }
            const reduced = global.matchMedia('(prefers-reduced-motion: reduce)').matches;
            this.panes.A?.map.fitBounds(this.adminBounds, { padding: 32, maxZoom: 11, duration: reduced ? 0 : 600 });
        }
        async fetchAdmin() {
            this.adminAbort?.abort();
            const generation = ++this.adminGeneration;
            const controller = new AbortController(); this.adminAbort = controller;
            this.adminLoading = true; this.adminError = null;
            const timer = setTimeout(() => controller.abort(), 20000);
            this.renderStatus();
            try {
                const response = await fetch(this.config.adminUrl, { signal: controller.signal, headers: { Accept: 'application/geo+json,application/json' } });
                if (!response.ok) throw new Error(`HTTP ${response.status}`);
                const data = await response.json(); const bounds = boundsOf(data);
                if (this.disposed || generation !== this.adminGeneration) return;
                this.adminData = data; this.adminBounds = bounds;
                for (const pane of Object.values(this.panes)) {
                    pane.map.getSource('admin')?.setData(data);
                    // Clipped rasters only cover the study area; avoid requesting tiles worldwide.
                    pane.apply(true);
                }
                this.fit();
            } catch (error) {
                if (this.disposed || generation !== this.adminGeneration) return;
                this.adminError = `Batas Merauke gagal dimuat: ${error.name === 'AbortError' ? 'waktu tunggu habis' : error.message}.`;
                // No dummy boundary is drawn when the real boundary fails.
            } finally {
                clearTimeout(timer);
                if (!this.disposed && generation === this.adminGeneration) { this.adminLoading = false; this.renderStatus(); }
            }
        }
        retry() {
            this.notice('');
            if (this.adminError) this.fetchAdmin();
            for (const [side, pane] of Object.entries(this.panes)) {
                const base = pane.baseState[this.state.satellite ? 'satellite' : 'osm'];
                if (!pane.ready || pane.initError || ['error', 'timeout'].includes(base.status)) {
                    const camera = cameraOf(pane.map); pane.destroy(); delete this.panes[side]; this.createPane(side, camera);
                } else pane.apply(true);
            }
        }
        render() {
            const s = this.state, catalog = this.config.catalog;
            this.root.classList.toggle('is-comparing', s.compare);
            this.q('[data-pane="B"]').hidden = !s.compare;
            this.root.querySelectorAll('[data-compare-only]').forEach(el => { el.hidden = !s.compare; });
            this.q('[data-action="compare"]').setAttribute('aria-pressed', String(s.compare));
            this.q('[data-left-year-label]').textContent = s.compare ? 'Tahun A' : 'Tahun analisis';
            this.root.querySelectorAll('[data-control]').forEach(el => {
                if (el.type === 'checkbox') el.checked = s[el.dataset.control]; else el.value = String(s[el.dataset.control]);
            });
            this.q('[data-opacity-value]').textContent = `${s.opacity}%`;
            for (const side of ['A', 'B']) {
                const year = side === 'A' ? s.year : s.yearB;
                this.q(`[data-year-label="${side}"]`).textContent = year;
                this.q(`[data-pane="${side}"] .explorer-canvas`).setAttribute('aria-label', `Peta ${side}, tahun ${year}`);
            }
            const themes = THEMES.filter(t => s[t]);
            this.root.querySelectorAll('[data-theme]').forEach(el => {
                const active = themes.length === 1 && themes[0] === el.dataset.theme;
                el.classList.toggle('active', active); el.setAttribute('aria-pressed', String(active));
            });
            const note = this.q('[data-compare-note]'); note.hidden = !s.compare;
            note.textContent = s.year === s.yearB ? 'Tahun A dan B sama. Pilih tahun berbeda untuk membandingkan perubahan.' : 'Kamera, indikator, dan opasitas tersinkron. Periksa kesamaan palet dan metode antartahun sebelum menafsirkan perubahan.';
            if (themes.length > 1) note.textContent += ' Beberapa raster bertumpuk: urutan atas tekanan ekologis, LST, lalu NDVI.';
            if (themes.length > 1) note.hidden = false;
            const legend = themes.map(t => {
                const d = catalog[t], first = d.stops[0][0], last = d.stops[d.stops.length - 1][0];
                const gradient = d.gradient || `linear-gradient(90deg,${d.stops.map(([v, color]) => `${color} ${(v - first) / (last - first) * 100}%`).join(',')})`;
                return `<div class="legend-row"><strong>${escape(d.label)} <small>${escape(d.unit)}</small></strong><div class="legend-ramp" style="background:${escape(gradient)}"></div><div class="legend-ticks"><span>${fmt(first, t === 'lst' ? 0 : 1)}</span><span>${fmt(last, t === 'lst' ? 0 : 1)}</span></div><p>${escape(d.description)}</p><small>${escape(d.paletteNote)}</small></div>`;
            });
            this.q('[data-legend]').innerHTML = `<p class="explorer-hint">${s.compare ? `A · ${s.year} / B · ${s.yearB}` : `Tahun ${s.year}`}</p>` + (legend.join('') || '<p class="explorer-hint">Aktifkan layer untuk melihat legenda.</p>');
            const header = `<thead><tr><th scope="col">Indikator</th><th scope="col">A · ${s.year}</th>${s.compare ? `<th scope="col">B · ${s.yearB}</th><th scope="col">Δ B − A</th>` : ''}</tr></thead>`;
            const body = THEMES.map(t => {
                const d = catalog[t], a = d.means[s.year], b = d.means[s.yearB];
                const delta = Number.isFinite(a) && Number.isFinite(b) ? b - a : null;
                return `<tr><th scope="row">${escape(d.label)}<small>${t === 'lst' ? '°C' : 'Indeks'}</small></th><td>${fmt(a, d.precision)}</td>${s.compare ? `<td>${fmt(b, d.precision)}</td><td>${Number.isFinite(delta) && delta > 0 ? '+' : ''}${fmt(delta, d.precision)}</td>` : ''}</tr>`;
            }).join('');
            this.q('[data-statistics]').innerHTML = `<div class="statistics-scroll"><table><caption class="visually-hidden">Rerata raster per tahun dan selisih B dikurangi A</caption>${header}<tbody>${body}</tbody></table></div>`;
            this.q('[data-about]').innerHTML = `<p>Periode: 2023–2026. Data tahunan berasal dari berkas pengguna. Tampilan ini tidak menghitung ulang statistik ketika peta digeser atau diperbesar.</p>${THEMES.map(t => {
                const d = catalog[t]; return `<article><h3>${escape(d.label)}</h3><dl><dt>Sumber</dt><dd>${escape(d.source)}</dd><dt>Resolusi</dt><dd>${escape(d.resolution)}</dd><dt>Pengolahan</dt><dd>${escape(d.method)}</dd></dl></article>`;
            }).join('')}<p>Rerata NDVI 2024–2026 belum disediakan. Selisih hanya ditampilkan jika kedua rerata tersedia. Komposit, cakupan piksel valid, dan metode yang berbeda dapat memengaruhi perbandingan.</p>`;
            this.renderStatus();
        }
        renderStatus() {
            if (this.disposed) return;
            const rows = []; let retry = false, busy = false;
            for (const [side, pane] of Object.entries(this.panes)) {
                const year = side === 'A' ? this.state.year : this.state.yearB;
                if (pane.initError) { rows.push(`${side}: ${pane.initError}`); retry = true; }
                else if (!pane.ready) { rows.push(`${side}: menyiapkan peta…`); busy = true; }
                for (const rec of pane.records.values()) {
                    const name = `${side} · ${this.config.catalog[rec.theme].label} ${year}`;
                    if (rec.status === 'loading') { rows.push(`Memuat ${name}…`); busy = true; }
                    if (rec.status === 'error' || rec.status === 'timeout') { rows.push(`${name}: ${rec.message}`); retry = true; }
                    if (rec.status === 'unavailable') rows.push(`${name}: data belum tersedia.`);
                }
                const base = pane.baseState[this.state.satellite ? 'satellite' : 'osm'];
                if (base.status === 'error' || base.status === 'timeout') { rows.push(`${side}: peta dasar ${base.status === 'timeout' ? 'terlalu lama dimuat' : 'gagal dimuat'}.`); retry = true; }
                else if (base.status === 'loading') { rows.push(`${side}: memuat peta dasar…`); busy = true; }
            }
            if (this.adminError) { rows.push(this.adminError); retry = true; }
            else if (this.adminLoading) { rows.push('Memuat batas administrasi…'); busy = true; }
            if (!rows.length) rows.push(THEMES.some(t => this.state[t]) ? 'Tile untuk tampilan ini selesai dimuat.' : 'Peta dasar aktif. Pilih layer analisis untuk mulai.');
            if (this.state.opacity === 0 && THEMES.some(t => this.state[t])) rows.push('Opasitas 0%: layer analisis tidak terlihat.');
            if (this.panes.A?.map.getZoom() < this.config.minzoom && THEMES.some(t => this.state[t])) rows.push(`Perbesar ke zoom ${this.config.minzoom} untuk menampilkan raster.`);
            const status = this.q('[data-load-status]'); const text = rows.join(' ');
            if (status.textContent !== text) status.textContent = text;
            status.classList.toggle('is-loading', busy); status.classList.toggle('has-error', retry);
            this.q('[data-action="retry"]').hidden = !retry;
            this.q('.explorer-map-grid').setAttribute('aria-busy', String(busy));
        }
        destroy() {
            this.disposed = true; this.adminGeneration++; this.adminAbort?.abort(); this.resizeObserver?.disconnect();
            document.removeEventListener('fullscreenchange', this.onFullscreen);
            for (const pane of Object.values(this.panes)) pane.destroy();
        }
    }

    function boot() {
        const roots = [...document.querySelectorAll('[data-sphere-explorer]')];
        if (!roots.length || global.SphereExplorerApp) return;
        if (!global.maplibregl || !global.SphereMapConfig) {
            roots.forEach(root => {
                root.querySelector('[data-load-status]').textContent = 'Pustaka atau konfigurasi peta gagal dimuat. Periksa koneksi lalu muat ulang halaman.';
                const retry = root.querySelector('[data-action="retry"]'); retry.hidden = false; retry.textContent = 'Muat ulang halaman';
                retry.addEventListener('click', () => global.location.reload());
                root.querySelectorAll('button, input, select').forEach(el => { if (el !== retry) el.disabled = true; });
            });
            return;
        }
        const config = global.SphereMapConfig, explorers = [];
        let saved = null;
        try { saved = JSON.parse(global.localStorage.getItem(STATE_KEY) || global.localStorage.getItem('sphere.unified-map-state.v5') || 'null'); } catch { /* Private mode still works. */ }
        const publish = (state, sender) => {
            try { global.localStorage.setItem(STATE_KEY, JSON.stringify(state)); } catch { /* Optional persistence. */ }
            explorers.forEach(explorer => { if (explorer !== sender) explorer.update(state, false); });
        };
        roots.forEach(root => {
            try { explorers.push(new Explorer(root, config, saved, publish)); }
            catch (error) {
                root.querySelector('[data-load-status]').textContent = 'Peta tidak dapat dimulai. Periksa dukungan WebGL dan muat ulang halaman.';
                console.error('[SPHERE]', error);
            }
        });
        const onStorage = event => {
            if (event.key !== STATE_KEY) return;
            try { const state = JSON.parse(event.newValue); explorers.forEach(e => e.update(state, false)); } catch { /* Ignore invalid state. */ }
        };
        global.addEventListener('storage', onStorage);
        global.SphereExplorerApp = { explorers, destroy() { explorers.forEach(e => e.destroy()); global.removeEventListener('storage', onStorage); } };
    }
    // Pure helpers/classes are exported for local regression tests, never required by Blade.
    if (typeof module !== 'undefined' && module.exports) module.exports = { normalizeState, boundsOf, rasterSpec, syncCamera, sourceFailed, Pane, Explorer, fmt };
    if (typeof document !== 'undefined') {
        if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', boot); else boot();
    }
})(typeof window !== 'undefined' ? window : globalThis);
