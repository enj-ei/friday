document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('a[href*="#"]').forEach(function (link) {
        link.addEventListener('click', function (e) {
            const href = link.getAttribute('href');
            const hashIndex = href.indexOf('#');
            if (hashIndex === -1) return;

            const targetPath = href.substring(0, hashIndex);
            const targetId = href.substring(hashIndex + 1);
            const currentPath = window.location.pathname.split('/').pop();
            const onIndex = (currentPath === '' || currentPath === 'index.php');

            if (targetPath === '' || targetPath === currentPath || (targetPath === 'index.php' && onIndex)) {
                const target = document.getElementById(targetId);
                if (target) {
                    e.preventDefault();
                    target.scrollIntoView({ behavior: 'smooth' });
                    history.pushState(null, '', '#' + targetId);
                }
            }
            // otherwise let the browser navigate to index.php and jump to the anchor normally
        });
    });
});
