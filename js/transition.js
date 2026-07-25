document.addEventListener('DOMContentLoaded', function () {
    // Fade the page in once it has loaded
    document.body.classList.add('page-loaded');

    // Intercept internal link clicks to fade out before navigating
    document.querySelectorAll('a[href]').forEach(function (link) {
        const href = link.getAttribute('href');

        // Skip external links, page anchors, mailto/tel, and new-tab links
        if (!href || href.startsWith('http') || href.includes('#') ||
            href.startsWith('mailto:') || href.startsWith('tel:') ||
            link.target === '_blank') {
            return;
        }

        link.addEventListener('click', function (e) {
            e.preventDefault();
            document.body.classList.remove('page-loaded');
            document.body.classList.add('page-leaving');
            setTimeout(function () {
                window.location.href = href;
            }, 300);
        });
    });
});
