(() => {
    const root = document.querySelector('[data-mobile-nav-root]');
    const toggle = document.querySelector('[data-mobile-nav-toggle]');
    const menu = document.querySelector('[data-mobile-nav-menu]');
    const topLine = document.querySelector('[data-mobile-nav-line-top]');
    const middleLine = document.querySelector('[data-mobile-nav-line-middle]');
    const bottomLine = document.querySelector('[data-mobile-nav-line-bottom]');

    if (root && toggle && menu) {
        const setOpen = (isOpen) => {
            toggle.setAttribute('aria-expanded', String(isOpen));
            menu.classList.toggle('max-h-0', !isOpen);
            menu.classList.toggle('opacity-0', !isOpen);
            menu.classList.toggle('max-h-[420px]', isOpen);
            menu.classList.toggle('opacity-100', isOpen);
            topLine?.classList.toggle('translate-y-[7px]', isOpen);
            topLine?.classList.toggle('rotate-45', isOpen);
            middleLine?.classList.toggle('opacity-0', isOpen);
            bottomLine?.classList.toggle('-translate-y-[7px]', isOpen);
            bottomLine?.classList.toggle('-rotate-45', isOpen);
        };

        toggle.addEventListener('click', () => {
            setOpen(toggle.getAttribute('aria-expanded') !== 'true');
        });

        menu.querySelectorAll('a').forEach((link) => {
            link.addEventListener('click', () => setOpen(false));
        });

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') {
                setOpen(false);
            }
        });
    }

    const header = document.querySelector('[data-site-header]');
    const progress = document.querySelector('[data-page-progress]');
    const topButton = document.querySelector('[data-back-to-top]');
    const navLinks = document.querySelectorAll('[data-nav-link]');

    const updateChrome = () => {
        const scrollTop = window.scrollY || document.documentElement.scrollTop;
        const scrollable = document.documentElement.scrollHeight - window.innerHeight;
        const progressValue = scrollable > 0 ? Math.min(scrollTop / scrollable, 1) : 0;

        progress?.style.setProperty('transform', `scaleX(${progressValue})`);
        header?.classList.toggle('shadow-lg', scrollTop > 12);
        header?.classList.toggle('shadow-slate-950/5', scrollTop > 12);
        topButton?.classList.toggle('is-visible', scrollTop > 520);
    };

    const setActiveHash = () => {
        const hash = window.location.hash.replace('#', '');

        navLinks.forEach((link) => {
            link.classList.toggle('is-active', Boolean(hash) && link.dataset.navLink === hash);
        });
    };

    topButton?.addEventListener('click', () => {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });

    window.addEventListener('scroll', updateChrome, { passive: true });
    window.addEventListener('hashchange', setActiveHash);
    updateChrome();
    setActiveHash();

    const revealItems = document.querySelectorAll('[data-reveal]');

    if (!revealItems.length || !('IntersectionObserver' in window)) {
        revealItems.forEach((item) => item.classList.add('is-visible'));
        return;
    }

    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.add('is-visible');
                observer.unobserve(entry.target);
            }
        });
    }, {
        threshold: 0.14,
    });

    revealItems.forEach((item, index) => {
        item.style.transitionDelay = `${Math.min(index * 80, 320)}ms`;
        observer.observe(item);
    });
})();
