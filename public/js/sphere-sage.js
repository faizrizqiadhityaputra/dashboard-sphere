/* Presentation only: keeps MapLibre data and event handlers intact. */
(function () {
    'use strict';
    function init() {
        document.querySelectorAll('.sphere-page-dashboard [class*="kpi-border-"]').forEach(card => {
            const label = document.createElement('span');
            label.className = 'sage-simulation-label';
            label.textContent = 'SIMULASI';
            card.prepend(label);
        });
        document.querySelectorAll('.sphere-page-dashboard canvas').forEach(canvas => {
            if (canvas.id !== 'tradeoffDashboardChart') return;
            const label = document.createElement('p');
            label.className = 'sage-demo-note';
            label.textContent = 'Proyeksi simulasi — bukan hasil perhitungan langsung dari raster NDVI, LST, atau tekanan ekologis.';
            canvas.parentElement.insertAdjacentElement('beforebegin', label);
        });
        const narrow = window.matchMedia('(max-width: 767px)').matches;
        document.querySelectorAll('.sage-layer-panel').forEach(panel => {
            // On phones, the user opens the panel when needed.
            if (narrow) panel.open = false;
        });
        document.querySelectorAll('.map-toolbar button').forEach(button => {
            if (button.title) button.setAttribute('aria-label', button.title);
        });
        document.querySelectorAll('.sphere-nav-link.active').forEach(link => {
            link.setAttribute('aria-current', 'page');
        });
        // Mirror the existing map script's active classes for assistive tech.
        document.querySelectorAll('.map-preset-group').forEach(group => {
            const sync = () => group.querySelectorAll('button').forEach(button => {
                button.setAttribute('aria-pressed', String(button.classList.contains('active')));
            });
            sync();
            new MutationObserver(sync).observe(group, {
                subtree: true, attributes: true, attributeFilter: ['class']
            });
        });
    }
    if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', init);
    else init();
})();
