(() => {
    const root = document.querySelector('[data-courts-discovery]');

    if (!root) {
        return;
    }

    const hiddenCards = Array.from(root.querySelectorAll('[data-discovery-extra="true"]'));
    const loader = root.querySelector('[data-discovery-loader]');
    const slotsModal = document.querySelector('[data-slots-modal]');
    const slotsTitle = slotsModal?.querySelector('[data-slots-title]');
    const slotsVendor = slotsModal?.querySelector('[data-slots-vendor]');
    const slotsList = slotsModal?.querySelector('[data-slots-list]');
    const mobileWidgetModal = document.querySelector('[data-mobile-widget-modal]');
    const mobileWidgetPanel = mobileWidgetModal?.querySelector('[data-mobile-widget-panel]');
    const searchInput = root.querySelector('[data-court-search]');
    const cards = Array.from(root.querySelectorAll('[data-court-card]'));
    let revealIndex = 0;
    let revealPending = false;
    let searchActive = false;

    const setModalOpen = (modal, isOpen) => {
        modal?.classList.toggle('hidden', !isOpen);
        modal?.setAttribute('aria-hidden', String(!isOpen));
        document.body.classList.toggle('overflow-hidden', isOpen);
    };

    const revealMoreCards = () => {
        if (searchActive || revealPending || revealIndex >= hiddenCards.length) {
            return;
        }

        revealPending = true;
        loader?.classList.remove('hidden');
        loader?.classList.add('flex');

        window.setTimeout(() => {
            hiddenCards.slice(revealIndex, revealIndex + 4).forEach((card) => {
                card.classList.remove('hidden');
                card.classList.add('animate-[fadeIn_.35s_ease-out]');
            });

            revealIndex += 4;
            revealPending = false;
            loader?.classList.add('hidden');
            loader?.classList.remove('flex');
        }, 420);
    };

    root.querySelectorAll('[data-follow-button]').forEach((button) => {
        button.addEventListener('click', () => {
            const isFollowing = button.dataset.following === 'true';
            const nextState = !isFollowing;
            const label = button.querySelector('[data-follow-label]');
            const plus = button.querySelector('[data-follow-icon-plus]');
            const check = button.querySelector('[data-follow-icon-check]');

            button.dataset.following = String(nextState);
            button.setAttribute('data-following', String(nextState));
            if (label) {
                label.textContent = nextState ? 'Following' : 'Follow';
            }
            plus?.classList.toggle('hidden', nextState);
            check?.classList.toggle('hidden', !nextState);
        });
    });

    root.querySelectorAll('[data-filter-chip]').forEach((chip) => {
        chip.addEventListener('click', () => {
            chip.dataset.active = chip.dataset.active === 'true' ? 'false' : 'true';
        });
    });

    searchInput?.addEventListener('input', () => {
        const query = searchInput.value.trim().toLowerCase();
        searchActive = query.length > 0;

        cards.forEach((card) => {
            const matches = !searchActive || (card.dataset.courtSearchIndex || '').includes(query);
            card.classList.toggle('hidden', !matches);
        });

        if (!searchActive) {
            hiddenCards.forEach((card, index) => {
                card.classList.toggle('hidden', index >= revealIndex);
            });
        }
    });

    root.querySelectorAll('[data-view-slots]').forEach((button) => {
        button.addEventListener('click', () => {
            const card = button.closest('[data-court-card]');
            const slots = (card?.dataset.courtSlots || '8:00 AM|10:00 AM|1:00 PM|4:00 PM').split('|');

            if (slotsTitle) {
                slotsTitle.textContent = card?.dataset.courtName || 'Available slots';
            }

            if (slotsVendor) {
                slotsVendor.textContent = `${card?.dataset.courtVendor || 'Courtigo Partner'} · Today`;
            }

            if (slotsList) {
                slotsList.innerHTML = '';
                slots.forEach((slot) => {
                    const button = document.createElement('button');
                    button.type = 'button';
                    button.className = 'rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-left text-sm font-black text-courtigo-navy transition hover:border-courtigo-blue hover:bg-blue-50';
                    button.textContent = slot;
                    slotsList.appendChild(button);
                });
            }

            setModalOpen(slotsModal, true);
        });
    });

    document.querySelectorAll('[data-slots-close]').forEach((button) => {
        button.addEventListener('click', () => setModalOpen(slotsModal, false));
    });

    document.querySelectorAll('[data-mobile-widget-open]').forEach((button) => {
        button.addEventListener('click', () => {
            const widget = button.dataset.mobileWidgetOpen;
            const source = root.querySelector(`[data-mobile-widget-content="${widget}"]`);

            if (!source || !mobileWidgetPanel) {
                return;
            }

            mobileWidgetPanel.innerHTML = source.innerHTML;
            setModalOpen(mobileWidgetModal, true);
        });
    });

    document.querySelectorAll('[data-mobile-widget-close]').forEach((button) => {
        button.addEventListener('click', () => setModalOpen(mobileWidgetModal, false));
    });

    window.addEventListener('scroll', () => {
        const nearBottom = window.innerHeight + window.scrollY >= document.documentElement.scrollHeight - 420;

        if (nearBottom) {
            revealMoreCards();
        }
    }, { passive: true });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            setModalOpen(slotsModal, false);
            setModalOpen(mobileWidgetModal, false);
        }
    });
})();
