(function () {
    'use strict';

    window.showSphereNotification = function (title, message, type = 'info') {
        const toastElement = document.getElementById('sphereGlobalToast');
        const titleElement = document.getElementById('globalToastTitle');
        const messageElement = document.getElementById('globalToastMessage');
        const iconElement = document.getElementById('globalToastIcon');

        if (!toastElement || typeof bootstrap === 'undefined') {
            console.info(`[${title}] ${message}`);
            return;
        }

        if (titleElement) titleElement.textContent = title;
        if (messageElement) messageElement.textContent = message;

        const iconClasses = {
            success: 'bi bi-check-circle text-success fs-5',
            warning: 'bi bi-exclamation-triangle text-warning fs-5',
            danger: 'bi bi-x-octagon text-danger fs-5',
            info: 'bi bi-info-circle text-info fs-5'
        };

        if (iconElement) {
            iconElement.className = iconClasses[type] || iconClasses.info;
        }

        bootstrap.Toast.getOrCreateInstance(toastElement, {
            delay: 3200
        }).show();
    };

    document.addEventListener('DOMContentLoaded', function () {
        const navbar = document.querySelector('.sphere-navbar');
        const progressBar = document.getElementById('sphereScrollProgress');
        const syncNavbarState = function () {
            if (navbar) navbar.classList.toggle('is-scrolled', window.scrollY > 12);

            if (progressBar) {
                const scrollable = document.documentElement.scrollHeight - window.innerHeight;
                const progress = scrollable > 0 ? Math.min(100, (window.scrollY / scrollable) * 100) : 0;
                progressBar.style.width = `${progress}%`;
            }
        };
        syncNavbarState();
        window.addEventListener('scroll', syncNavbarState, { passive: true });

        if (typeof bootstrap !== 'undefined') {
            document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(element => {
                bootstrap.Tooltip.getOrCreateInstance(element);
            });
        }

        if (typeof Chart !== 'undefined') {
            Chart.defaults.font.family = 'Inter, system-ui, sans-serif';
            Chart.defaults.color = '#68708f';
            Chart.defaults.borderColor = 'rgba(117, 125, 164, .12)';
        }

        const revealTargets = document.querySelectorAll(
            '.context-subheader > .container-fluid, .card, .mini-summary-card, .footer-shell'
        );

        revealTargets.forEach((element, index) => {
            element.classList.add('sphere-reveal');
            element.style.setProperty('--reveal-delay', `${Math.min(index % 6, 5) * 55}ms`);
        });

        if ('IntersectionObserver' in window) {
            const revealObserver = new IntersectionObserver(entries => {
                entries.forEach(entry => {
                    if (!entry.isIntersecting) return;
                    entry.target.classList.add('is-visible');
                    revealObserver.unobserve(entry.target);
                });
            }, { threshold: 0.08, rootMargin: '0px 0px -24px' });

            revealTargets.forEach(element => revealObserver.observe(element));
        } else {
            revealTargets.forEach(element => element.classList.add('is-visible'));
        }

        document.querySelectorAll('.card, .mini-summary-card').forEach(surface => {
            surface.addEventListener('pointermove', event => {
                const bounds = surface.getBoundingClientRect();
                const x = ((event.clientX - bounds.left) / bounds.width) * 100;
                const y = ((event.clientY - bounds.top) / bounds.height) * 100;
                surface.style.setProperty('--pointer-x', `${x}%`);
                surface.style.setProperty('--pointer-y', `${y}%`);
            }, { passive: true });
        });

        document.querySelectorAll('.btn').forEach(button => {
            button.addEventListener('pointerdown', function (event) {
                const bounds = this.getBoundingClientRect();
                const diameter = Math.max(bounds.width, bounds.height);
                const ripple = document.createElement('span');

                ripple.className = 'sphere-ripple';
                ripple.style.width = `${diameter}px`;
                ripple.style.height = `${diameter}px`;
                ripple.style.left = `${event.clientX - bounds.left - diameter / 2}px`;
                ripple.style.top = `${event.clientY - bounds.top - diameter / 2}px`;

                this.querySelector('.sphere-ripple')?.remove();
                this.appendChild(ripple);
                window.setTimeout(() => ripple.remove(), 680);
            });
        });

        document.querySelectorAll('.btn-export-trigger').forEach(button => {
            button.addEventListener('click', function () {
                const format = this.dataset.format || 'data';
                window.showSphereNotification(
                    'Ekspor Dipersiapkan',
                    `Fitur ekspor ${format} masih menggunakan data simulasi.`,
                    'info'
                );
            });
        });

        const searchInput = document.getElementById('globalSearchInput');
        if (searchInput) {
            searchInput.addEventListener('keydown', function (event) {
                if (event.key !== 'Enter') return;

                const query = this.value.trim().toLowerCase();
                if (!query) return;

                const candidates = Array.from(document.querySelectorAll(
                    '.card, .mini-summary-card, .metric-label, .section-title, .page-title'
                ));
                const match = candidates.find(element =>
                    element.textContent.toLowerCase().includes(query)
                );

                if (match) {
                    const target = match.closest('.card, .mini-summary-card') || match;
                    target.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    target.classList.add('sphere-search-hit');
                    window.setTimeout(() => target.classList.remove('sphere-search-hit'), 1600);
                } else {
                    window.showSphereNotification('Pencarian', `Tidak ditemukan informasi untuk “${this.value.trim()}”.`, 'warning');
                }
            });
        }
    });
})();
