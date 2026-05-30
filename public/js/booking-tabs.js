(() => {
    const root = document.querySelector('[data-booking-tabs]');

    if (!root) {
        return;
    }

    const buttons = root.querySelectorAll('[data-tab-button]');
    const panels = root.querySelectorAll('[data-tab-panel]');

    buttons.forEach((button) => {
        button.addEventListener('click', () => {
            const key = button.dataset.tabButton;
            buttons.forEach((item) => {
                item.dataset.active = String(item === button);
            });
            panels.forEach((panel) => {
                panel.classList.toggle('hidden', panel.dataset.tabPanel !== key);
            });
        });
    });
})();
