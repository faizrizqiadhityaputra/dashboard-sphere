(function () {
    'use strict';
    function initMidnight() {
        if (typeof Chart !== 'undefined') {
            Chart.defaults.color = '#b7c2dd';
            Object.values(Chart.instances).forEach(chart => {
                Object.values(chart.options.scales || {}).forEach(scale => {
                    if (scale.ticks) scale.ticks.color = '#b7c2dd';
                    if (scale.grid) scale.grid.color = 'rgba(183,194,221,.10)';
                    if (scale.title) scale.title.color = '#e7edff';
                });
                if (chart.options.plugins.legend?.labels) {
                    chart.options.plugins.legend.labels.color = '#d7dff5';
                }
                chart.update('none');
            });
        }
        document.querySelectorAll('.sphere-nav-link').forEach(link => {
            if (link.classList.contains('active')) link.setAttribute('aria-current', 'page');
        });
        document.querySelectorAll('.map-toolbar button').forEach(button => {
            if (button.title) button.setAttribute('aria-label', button.title);
        });
    }
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initMidnight);
    } else {
        initMidnight();
    }
})();
