document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('pkgSearchInput');
    const pills = document.querySelectorAll('#pkgFilterPills .filter-pill');
    const cards = document.querySelectorAll('#pkgGrid .package-card');
    const countLabel = document.getElementById('pkgResultsCount');

    if (!searchInput || !pills.length || !cards.length) return;

    let activeFilter = 'All';

    function applyFilters() {
        const query = searchInput.value.trim().toLowerCase();
        let visibleCount = 0;

        cards.forEach(function (card) {
            const matchesCategory = (activeFilter === 'All' || card.dataset.category === activeFilter);
            const matchesSearch = (query === '' || card.dataset.search.includes(query));
            const show = matchesCategory && matchesSearch;
            card.style.display = show ? '' : 'none';
            if (show) visibleCount++;
        });

        countLabel.textContent = visibleCount + (visibleCount === 1 ? ' package found' : ' packages found');
    }

    pills.forEach(function (pill) {
        pill.addEventListener('click', function () {
            pills.forEach(function (p) { p.classList.remove('active'); });
            pill.classList.add('active');
            activeFilter = pill.dataset.filter;
            applyFilters();
        });
    });

    searchInput.addEventListener('input', applyFilters);
});
