(() => {
    const root = document.querySelector('[data-reservation-root]');

    if (!root) {
        return;
    }

    const slotButtons = [...root.querySelectorAll('[data-slot-option]')];
    const reserveButton = root.querySelector('[data-reserve-button]');
    const loginReserveLink = root.querySelector('[data-login-reserve-link]');
    const summary = root.querySelector('[data-selected-slot-summary]');
    const selectedSlotInput = root.querySelector('[data-selected-slot-input]');
    const loginUrl = loginReserveLink ? new URL(loginReserveLink.href) : null;
    const initialSlot = root.dataset.initialSlot;

    slotButtons.forEach((button) => {
        button.addEventListener('click', () => {
            slotButtons.forEach((slotButton) => {
                slotButton.dataset.selected = 'false';
                slotButton.setAttribute('aria-pressed', 'false');
            });

            button.dataset.selected = 'true';
            button.setAttribute('aria-pressed', 'true');

            if (summary) {
                summary.textContent = `Selected slot: ${button.dataset.slotLabel}`;
                summary.classList.remove('hidden');
            }

            if (reserveButton) {
                reserveButton.disabled = false;
                reserveButton.textContent = `Continue to payment · ${button.dataset.slotLabel}`;
            }

            if (selectedSlotInput) {
                selectedSlotInput.value = button.dataset.slotId;
            }

            if (loginReserveLink && loginUrl) {
                const redirectUrl = new URL(loginUrl.searchParams.get('redirect'));
                redirectUrl.searchParams.set('slot', button.dataset.slotId);
                loginUrl.searchParams.set('redirect', redirectUrl.toString());
                loginReserveLink.href = loginUrl.toString();
                loginReserveLink.textContent = `Log in to reserve ${button.dataset.slotLabel}`;
            }
        });
    });

    if (initialSlot) {
        root.querySelector(`[data-slot-id="${initialSlot}"]`)?.click();
    }
})();
