(() => {
    const carousel = document.querySelector('[data-court-carousel]');

    if (!carousel) {
        return;
    }

    const previousButton = document.querySelector('[data-court-carousel-prev]');
    const nextButton = document.querySelector('[data-court-carousel-next]');
    const dots = [...document.querySelectorAll('[data-court-carousel-dot]')];
    const cards = [...carousel.children];
    let autoplay;

    const cardStep = () => {
        const firstCard = cards[0];

        if (!firstCard) {
            return carousel.clientWidth;
        }

        return firstCard.getBoundingClientRect().width + 20;
    };

    const updateDots = () => {
        if (!dots.length) {
            return;
        }

        const activeIndex = Math.round(carousel.scrollLeft / cardStep());

        dots.forEach((dot, index) => {
            dot.dataset.active = index === activeIndex ? 'true' : 'false';
        });
    };

    const moveNext = () => {
        const maxScroll = carousel.scrollWidth - carousel.clientWidth;
        const shouldLoop = carousel.scrollLeft + cardStep() >= maxScroll - 4;

        carousel.scrollTo({
            left: shouldLoop ? 0 : carousel.scrollLeft + cardStep(),
            behavior: 'smooth',
        });
    };

    const startAutoplay = () => {
        if (cards.length < 2) {
            return;
        }

        autoplay = window.setInterval(moveNext, 3500);
    };

    const stopAutoplay = () => {
        window.clearInterval(autoplay);
    };

    previousButton?.addEventListener('click', () => {
        stopAutoplay();
        carousel.scrollBy({ left: -cardStep(), behavior: 'smooth' });
        startAutoplay();
    });

    nextButton?.addEventListener('click', () => {
        stopAutoplay();
        moveNext();
        startAutoplay();
    });

    dots.forEach((dot) => {
        dot.addEventListener('click', () => {
            stopAutoplay();
            carousel.scrollTo({
                left: Number(dot.dataset.courtCarouselDot) * cardStep(),
                behavior: 'smooth',
            });
            startAutoplay();
        });
    });

    carousel.addEventListener('scroll', () => {
        window.requestAnimationFrame(updateDots);
    });
    carousel.addEventListener('mouseenter', stopAutoplay);
    carousel.addEventListener('mouseleave', startAutoplay);
    carousel.addEventListener('focusin', stopAutoplay);
    carousel.addEventListener('focusout', startAutoplay);

    updateDots();
    startAutoplay();
})();
