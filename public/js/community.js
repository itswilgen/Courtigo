(() => {
    const roots = document.querySelectorAll('[data-community-tabs]');

    roots.forEach((root) => {
        const tabs = Array.from(root.querySelectorAll('[data-community-tab]'));
        const panels = Array.from(root.querySelectorAll('[data-community-panel]'));

        tabs.forEach((tab) => {
            tab.addEventListener('click', () => {
                const target = tab.dataset.communityTab;

                tabs.forEach((item) => {
                    item.dataset.active = String(item === tab);
                });

                panels.forEach((panel) => {
                    panel.classList.toggle('hidden', panel.dataset.communityPanel !== target);
                });
            });
        });
    });
})();
