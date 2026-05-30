(() => {
    const shell = document.querySelector('[data-admin-shell]');
    const toggle = document.querySelector('[data-sidebar-toggle]');
    const overlay = document.querySelector('[data-admin-overlay]');

    if (!shell || !toggle) {
        return;
    }

    const isDesktop = () => window.matchMedia('(min-width: 992px)').matches;
    const closeMobile = () => shell.classList.remove('is-mobile-open');

    toggle.addEventListener('click', () => {
        if (isDesktop()) {
            shell.classList.toggle('is-collapsed');
            return;
        }

        shell.classList.toggle('is-mobile-open');
    });

    overlay?.addEventListener('click', closeMobile);

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            closeMobile();
        }
    });

    window.addEventListener('resize', () => {
        if (isDesktop()) {
            closeMobile();
        }
    });
})();
