(() => {
    const shell = document.querySelector('[data-dashboard-shell]');

    if (!shell) {
        return;
    }

    const sidebar = shell.querySelector('[data-dashboard-sidebar]');
    const overlay = shell.querySelector('[data-sidebar-overlay]');
    const openButtons = shell.querySelectorAll('[data-sidebar-open]');
    const closeButtons = shell.querySelectorAll('[data-sidebar-close]');
    const profileRoot = shell.querySelector('[data-profile-menu]');
    const profileButton = shell.querySelector('[data-profile-button]');
    const profilePanel = shell.querySelector('[data-profile-panel]');

    const setSidebarOpen = (isOpen) => {
        sidebar?.classList.toggle('-translate-x-full', !isOpen);
        overlay?.classList.toggle('hidden', !isOpen);
        document.body.classList.toggle('overflow-hidden', isOpen);
    };

    const setProfileOpen = (isOpen) => {
        profileButton?.setAttribute('aria-expanded', String(isOpen));
        profilePanel?.classList.toggle('hidden', !isOpen);
    };

    openButtons.forEach((button) => button.addEventListener('click', () => setSidebarOpen(true)));
    closeButtons.forEach((button) => button.addEventListener('click', () => setSidebarOpen(false)));
    overlay?.addEventListener('click', () => setSidebarOpen(false));

    profileButton?.addEventListener('click', (event) => {
        event.stopPropagation();
        setProfileOpen(profileButton.getAttribute('aria-expanded') !== 'true');
    });

    document.addEventListener('click', (event) => {
        if (profileRoot && !profileRoot.contains(event.target)) {
            setProfileOpen(false);
        }
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            setSidebarOpen(false);
            setProfileOpen(false);
        }
    });
})();
